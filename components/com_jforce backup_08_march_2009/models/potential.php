<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			potential.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelPotential extends JModel {
	
	var $_id					= null;
	var $_potential 			= null;
	var $_category				= null;
	var $_milestone				= null;
	var $_published				= 1;
	var $_required				= array('name');

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
	
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_potential	= null;
	}	

	function &getPotential()
	{
		global $mainframe;
		$user = &JFactory::getUser();
		// Load the Category data
		if ($this->_loadPotential())
		{
			if (!$this->_potential->visibility && !$user->systemrole->can_see_private_objects) :
				JForceHelper::notAuth();
			endif;
			
			$read = JForceHelper::getObjectStatus($this->_potential->id, 'potential');
			if (!$read) :
				JForceHelper::setObjectStatus($this->_potential->id, 'potential');
			endif;
			
			$this->_potential->probability = $this->_potential->probability.'%';
			#$this->_potential->attachments = $this->loadAttachments();
			
			$this->_potential->createdDate = JForceHelper::getDaysDate($this->_potential->created, false);
			$this->_potential->shortDate = JForceHelper::getDaysDate($this->_potential->closedate, false);
			
			$mainframe->triggerEvent('onLoadPotential',array($this->_potential));		
			
		}
		else
		{
			$potential =& JTable::getInstance('Potential');
			$potential->parameters	= new JParameter( '' );
			$this->_potential			= $potential;
			$this->_potential->sourcetype = 'lead';
		}

		return $this->_potential;
	}

	function save($data)
	{
		global $mainframe;
		
		$data['visibility'] = isset($data['visibility']) ? $data['visibility'] : 1;
		
		$user =& JFactory::getUser();

		$potential  =& JTable::getInstance('Potential');
		
		// Bind the form fields to the web link table
		if (!$potential->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$potential->id = (int) $potential->id;
		
		if (isset($data['sourcetype']) && $data['sourcetype'] == 0) :
			$potential->lead = 0;
		elseif (isset($data['sourcetype']) && $data['sourcetype'] == 1):
			$potential->company = 0;
		endif;
		
		if (!$potential->id) :
			$potential->author = $user->get('id');
			$potential->created = gmdate("Y-m-d H:i:s");
			$potential->published = 1;
			$new = 1;
		else :
			$new = 0;
		endif;

		$potential->modified = gmdate("Y-m-d H:i:s");

		// Make sure the table is valid
		if (!$potential->check()) {
			$this->setError($potential->getError());
			return false;
		}
		
		if (!isset($data['override'])) :
			JForceHelper::validateObject($potential, $this->_required);
		endif;
		
		$files = JRequest::get('files');

		$mainframe->triggerEvent('onBeforePotentialSave',array($potential,$new));		

		// Store the article table to the database
		if (!$potential->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		for ($i=0; $i<count($files['file']['name']); $i++) :
			$data['attachment'] = 1;
			$data['potential'] = $potential->id;
			$data['id'] = null;
			$fileHandler = JModel::getInstance('File', 'JForceModel');
			$fileHandler->uploadFiles($files, $data);
		endfor;		

		$selectedUsers = JRequest::getVar('hiddenSubscription');
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setId($potential->id);
		$subscriptionModel->setPid($potential->pid);
		$subscriptionModel->setAction('potential');
		$subscriptionModel->save($selectedUsers);
		
		$this->_potential	=& $potential;

		if ($data['notify']) :
			$this->sendNotifications($potential, $new);
		endif;

		$mainframe->triggerEvent('onAfterPotentialSave',array($this->_potential,$new));		

		return true;
	}
	
	function getTotal() {
		$where = $this->_buildWhere();

		$query = 'SELECT COUNT(*) '.
				' FROM #__jf_potentials AS p' .
				' LEFT JOIN #__users AS u on p.author = u.id' .
				$where;
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		return $total;
	}
	
	function listPotentials() {	
		global $mainframe;
		
		$where = $this->_buildWhere();

		$query = 'SELECT p.*, p.author as authorid, u.name as author '.
				' FROM #__jf_potentials AS p' .
				' LEFT JOIN #__users AS u on p.author = u.id' .
				$where;
	
		// Get the pagination request variables
		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

        $potentials = $this->_getList($query, $limitstart, $limit);
		
		for($i=0;$i<count($potentials);$i++):
			$potential = $potentials[$i];
			$potential->link = JRoute::_('index.php?option=com_jforce&c=sales&view=potential&layout=potential&id='.$potential->id);
			
			$read = JForceHelper::getObjectStatus($potential->id, 'potential');
			
			if ($read) :
				$potential->read = "<img src='components".DS."com_jforce".DS."images".DS."potential_icon.png' />";
			else :
				$potential->read = "<img src='components".DS."com_jforce".DS."images".DS."potential_icon_new.png' />";
			endif;
			
			$mainframe->triggerEvent('onLoadPotential',array($potential));		
		
		endfor;
		
		$this->list =$potentials;
        return $this->list;
    }

	function _loadPotential()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_potential))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT p.*, p.author as authorid, u.name as author, q.image, c.name as company, p.company as companyid, cam.name AS campaignName'.
					' FROM #__jf_potentials AS p' .
					' LEFT JOIN #__users AS u ON p.author = u.id'.
					' LEFT JOIN #__jf_persons AS q ON q.uid = u.id'.
					' LEFT JOIN #__jf_companies AS c ON c.id = p.company'.
					' LEFT JOIN #__jf_campaigns AS cam ON cam.id = p.campaign'.
					$where;
			$this->_db->setQuery($query);
			$this->_potential = $this->_db->loadObject();

			if ( ! $this->_potential ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function loadAttachments($id = null) 
	{
		if(!$id) $id = $this->_id;
		
		$documentModel =& JModel::getInstance('Document','JForceModel');
		$documentModel->setId(null);
		$documentModel->setType('potential',$id);
		$attachments = $documentModel->listDocuments();

		return $attachments;
	}
	
	function loadComments($id = null) {
		
		if (!$id) $id = $this->_id;
	
		$commentModel = &JModel::getInstance('Comment', 'JforceModel');
		$commentModel->setId(null);
		$commentModel->setType('potential', $id);
		$comments = $commentModel->listComments();
	
		return $comments;
	}
	
	function getCommentCount($potential) 
	{
		$query = "SELECT count(*) FROM #__jf_comments AS c WHERE c.potential='$potential'";
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		if(!$total) $total = 1;
		
		return $total;
		
	}
	
	
	function _buildWhere()
	{
		$user = &JFactory::getUser();
		
		$where  = ' WHERE p.published = '. (int) $this->_published;
				
		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR p.id = ',$this->_id);
				$where .= ' AND (p.id = '. $ids.')';
			else:
				$where .=' AND p.id = '.(int) $this->_id;
			endif;
		endif;
		
		if(!$user->systemrole->can_see_private_objects && !$this->_id) :
			$where .= " AND p.visibility = '1'";
		endif;
		
		return $where;
	}	
		
	function buildLists() {
				
		$lists['visibility'] = JForceListsHelper::getVisibilityList($this->_potential->visibility, $this->_potential->id);

		$lists['campaign'] = JForceListsHelper::getCampaignList($this->_potential->campaign);

		$lists['salesstage'] = JForceListsHelper::getSalesStages($this->_potential->salesstage);
		
		$lists['company'] = JForceListsHelper::getClientList($this->_potential->companyid);
		
		$lists['leads'] = JForceListsHelper::getLeadList($this->_potential->lead);
		
		$sourcetype = 0;
		if ($this->_potential->lead > 0) :
			$sourcetype = 1;
		endif;
		
		$lists['sourcetype'] = JHTML::_('select.booleanlist', 'sourcetype', '', $sourcetype, JText::_('Lead'), JText::_('Company'),'lead');
		
		$probabilityOptions = array();
		for($i=0;$i<100;$i++):
			if ($i%5 == 0) :
				$probabilityOptions[] = JHTML::_('select.option', $i, $i.'%');
			endif;
		endfor;
		$probabilityOptions[] = JHTML::_('select.option', 99, '99%');
		$lists['probability'] = JHTML::_('select.genericlist',$probabilityOptions,'probability', 'class="inputbox"','value','text',$this->_potential->probability);

		return $lists;
		
	}
	
	function sendNotifications(&$potential, $new = false) {
		$user = &JFactory::getUser();
		if($potential):
			$this->setId($potential->id);
		endif;
		
		$potential = $this->getPotential();
		
		$values = array(
					'type' => 'Potential',
					'title' => $potential->summary, 
					'date' => $potential->modified, 
					'project' => $potential->projectname, 
					'description' => $potential->message, 
					'author' => $user->name
				);		
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->sendMail($values, $potential, 'potential', $new);
		
	}
		
}