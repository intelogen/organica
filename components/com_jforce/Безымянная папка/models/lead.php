<?php

/************************************************************************************
*	@package		Joomla									   						*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			lead.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
*************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelLead extends JModel {
	
	var $_id					= null;
	var $_type					= null;
	var $_lead 					= null;
	var $_company				= null;
	var $_published 			= 1;
	var $_required				= array('lastname','company');

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$type = JRequest::getVar('type', 0, '', 'int');
		$this->setType($type);
				
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_lead	= null;
	}
	
	function setLid($lid)
	{
		// Set new article ID and wipe data
		$this->_lid		= $lid;
	}

	function setCompany($company)
	{
		// Set new article ID and wipe data
		$this->_company	= $company;
	}	
	
	function setUserid($uid) {
		$this->_uid = $uid;
	}
	
	function setType($type) {
	
		$this->_type = $type;
	
	}

	function &getLead()
	{
		global $mainframe;
		// Load the Category data
		if ($this->_loadLead())
		{
			//	$this->_loadLeadParams();
			$mainframe->triggerEvent('onLoadLead',array($this->_lead));

		}
		else
		{
			$lead =& JTable::getInstance('Lead');
			$lead->parameters	= new JParameter( '' );
			$lead->email = null;
			$this->_lead			= $lead;
		}

		$customFieldModel = &JModel::getInstance('Customfield', 'JForceModel');
		$customFieldModel->setId(NULL);
		$layout = JRequest::getVar('layout');
		$edit = $layout == 'form' ? true : false;
		
		if ($layout == 'new') :
			$edit = true;
			$customFieldModel->setPublicOnly();
		endif;

		$this->_lead->customFields = $customFieldModel->loadCustomFields('lead', $this->_lead->id, $edit);

		return $this->_lead;
	}

	function save($data)
	{
		global $mainframe;
		$user = &JFactory::getUser();

		$lead  =& JTable::getInstance('Lead');

		// Bind the form fields to the web link table
		if (!$lead->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		if (!$lead->id) :
			$lead->author = $user->get('id');
			$lead->created = gmdate("Y-m-d H:i:s");
			$lead->published = 1;
			$new = 1;
		else :
			$lead->modified = gmdate("Y-m-d H:i:s");
			$new = 0;
		endif;
		$lead->address = JRequest::getVar('address', '', 'post', 'string', JREQUEST_ALLOWRAW);
		// sanitise id field
		$lead->id = (int) $lead->id;

		// Make sure the table is valid
		if (!$lead->check()) {
			$this->setError($lead->getError());
			return false;
		}
		
		$mainframe->triggerEvent('onBeforeLeadSave',array($lead,$new));
		
		// Store the article table to the database
		if (!$lead->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$cf = JRequest::getVar('cf', '', 'post', 'array', JREQUEST_ALLOWRAW);
		if ($cf) :
			$customFieldModel = &JModel::getInstance('customfield', 'JforceModel');
			$customFieldModel->saveCustomFields($cf, $lead->id);
		endif;
	
		$this->_lead	=& $lead;

		$mainframe->triggerEvent('onAfterLeadSave',array($lead,$new));

		return $this->_lead;
	}
	
	function getTotal() {
		$where = $this->_buildWhere();

		$query = 'SELECT COUNT(*)'.
				' FROM #__jf_leads AS l' .
				$where;
				
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		return $total;
	}
	
	function listLeads() {	
		global $mainframe;
		
		$where = $this->_buildWhere();

		$query = 'SELECT l.*'.
				' FROM #__jf_leads AS l' .
				$where;
		
		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		
        $leads = $this->_getList($query, $limitstart, $limit);
		
		for($i=0;$i<count($leads);$i++):
			$lead = $leads[$i];
			$mainframe->triggerEvent('onLoadLead',array($lead));	
		endfor;
		
		$this->list =$leads;
        return $this->list;
    }

	function _loadLead()
	{
		global $mainframe;

		if($this->_lead):
			return true;
		endif;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_lead))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT l.* '.
					' FROM #__jf_leads AS l' .
					$where;
					
			$this->_db->setQuery($query);
			$this->_lead = $this->_db->loadObject();

			if ( ! $this->_lead ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function _buildWhere()
	{
		global $mainframe;
				
		
		$where = ' WHERE l.published = '. (int) $this->_published;

		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR l.id = ',$this->_id);
				$where .= ' AND (l.id = '. $ids.')';
			else:
				$where .=' AND l.id = '.(int) $this->_id;
			endif;

		endif;
		
		
		return $where;
	}
	
	function buildLists() {
		$lists = array();
		
		$lists['status'] = JForceListsHelper::getLeadStatusList($this->_lead->status);
		
		return $lists;	
	}
	
	
	
	function auto_assign() {
		
		$this->_db->setQuery("SELECT id, userid, (groupweight/100) AS weight FROM #__jgroupmap WHERE groupid = '4' AND groupweight > '0' ORDER BY id");
		$groups = $this->_db->loadObjectList();
		$today = date("Y-m-d");
		
		$query = "SELECT COUNT(*) FROM #__jprojects"
				."\n WHERE created >= '$today'"
				;
				
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult() ? $this->_db->loadResult() : 1;
		
		$possible = array();
		$all = array();
		$countArray = array();
		
		for($i=0; $i<count($groups); $i++) :
			$id = $groups[$i]->userid;
			$query = "SELECT COUNT(*) FROM #__jprojects"
					."\n WHERE cm = '$id'"
					."\n AND created >= '$today'"
					;
			$this->_db->setQuery($query);
			$count = $this->_db->loadResult();
			
			$all[] = $id;
			
			if ($count/$total < $groups[$i]->weight) :
				$possible[] = $id;
			
			endif;
			
		endfor;
		
		if (empty($possible)) :
			$possible = $all;
		endif;
		$totalPossible = count($possible) - 1;
		
		$key = mt_rand(0, $totalPossible);
		$cm = $possible[$key];
		return $cm;
		
	}
	
		
}