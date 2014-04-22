<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			company.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelCompany extends JModel {
	
	var $_id				= null;
	var $_company			= null;
	var $_admin				= null;
	var $_pid				= null;
	var $_published			= 1;
	var $_required			= array('name');
	
    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$pid = JRequest::getVar('pid');
		$this->setPid((int)$pid);
	
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_company	= null;
	}	
	
	function setPid($pid) {
		$this->_pid = $pid;
	}	
	function getAdminCompany() 
	{
		$this->_admin = true;
		$this->_id = null;
		
		$company = $this->getCompany();
		
		return $company;
	}

	function &getCompany()
	{
		global $mainframe;
		// Load the Category data
		if ($this->_loadCompany())
		{
			if($this->_company->image):
				$this->_company->image = '<img src="'.JURI::root().'jf_projects/company_icons/'.$this->_company->image.'" />';
			else:
				$this->_company->image = '<img src="'.JURI::root().'components/com_jforce/images/company_icons/default_large.png" />';
			endif;
			
			$personModel =& JModel::getInstance('Person','JForceModel');
			$personModel->setId(null);
			$personModel->setCompany($this->_company->id);
			$this->_company->people = $personModel->listPersons();
			
			$mainframe->triggerEvent('onLoadCompany', array($this->_company));
		}
		else
		{
			$company =& JTable::getInstance('Company');
			$company->parameters	= new JParameter( '' );
			$this->_company			= $company;
		}
		
		$customFieldModel = &JModel::getInstance('Customfield', 'JforceModel');
		$layout = JRequest::getVar('layout');
		$edit = ($layout == 'form' || $layout == 'general') ? true : false;
		
		$this->_company->customFields = $customFieldModel->loadCustomFields('company', $this->_company->id, $edit);

		return $this->_company;
	}

	function save($data)
	{
		global $mainframe;
		$user = &JFactory::getUser();

		$company  =& JTable::getInstance('Company');

		// Bind the form fields to the web link table
		if (!$company->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$company->id) :
			$company->author = $user->get('id');
			$company->created = gmdate("Y-m-d H:i:s");
			$company->published = 1;
			$isNew = true;
		else :
			$company->modified = gmdate("Y-m-d H:i:s");
			$isNew = false;
		endif;

		// sanitise id field
		$company->id = (int) $company->id;
		#$company->address = JRequest::getVar('address', '', 'post', 'string', JREQUEST_ALLOWRAW);
		// Make sure the table is valid
		if (!$company->check()) {
			$this->setError($company->getError());
			return false;
		}

		if (!isset($data['override'])) :
			JForceHelper::validateObject($company, $this->_required);
		endif;

		$mainframe->triggerEvent('onBeforeCompanySave',array($company, $isNew));

		// Store the article table to the database
		if (!$company->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$cf = JRequest::getVar('cf', '', 'post', 'array', JREQUEST_ALLOWRAW);
		if ($cf) :
			$customFieldModel = &JModel::getInstance('customfield', 'JforceModel');
			$customFieldModel->saveCustomFields($cf, $company->id);
		endif;
		
		$this->_company	=& $company;

		$mainframe->triggerEvent('onAfterCompanySave',array($this->_company, $isNew));

		return $this->_company;
	}
	
	function getTotal() {
		$where = $this->_buildWhere();

		$query = 'SELECT c.* '.
				' FROM #__jf_companies AS c' .
				$where;
				
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		return $total;
	}
	
	function listCompanies() {	
		global $mainframe;
		$where = $this->_buildWhere();

		$query = 'SELECT c.* '.
				' FROM #__jf_companies AS c' .
				$where;

		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		
        $companies = $this->_getList($query, $limitstart, $limit);
		for($i=0;$i<count($companies);$i++):
			$company = $companies[$i];
			if($company->image):
				$company->image = '<img src="'.JURI::root().'jf_projects/company_icons/thumbs/'.$company->image.'" />';
			else:
				$company->image = '<img src="'.JURI::root().'components/com_jforce/images/company_icons/default.png" />';
			endif;
			
			if($company->homepage):
				$company->homepageURL = '<a href='.$company->homepage.' />'.$company->homepage.'</a>';
			endif;
			$mainframe->triggerEvent('onLoadCompany', array($company));
		endfor;
		
		$this->list =$companies;
        return $this->list;
    }

	function _loadCompany()
	{
		global $mainframe;

		if (!$this->_id && !$this->_admin) :
			return false;
		endif;

		// Load the item if it doesn't already exist
		if (empty($this->_company))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT c.*'.
					' FROM #__jf_companies AS c' .
					$where;
			$this->_db->setQuery($query);
			$this->_company = $this->_db->loadObject();

			if ( ! $this->_company ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function _buildWhere()
	{
		global $mainframe;
		
		$where = ' WHERE c.published = ' .(int) $this->_published;
		
		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR c.id = ',$this->_id);
				$where .= ' AND (c.id = '. $ids.')';
			else:
				$where .=' AND c.id = '.(int) $this->_id;
			endif;
		endif;
		
		if($this->_admin):
			$where .= ' AND c.admin = 1';
		endif;
		
		return $where;
	}
	
	function buildLists() 
	{
		$lists = array();
		
		$lists['owner'] = JForceListsHelper::getOwnerList($this->_id, $this->_company->owner);
		
		return $lists;
	}
	
}