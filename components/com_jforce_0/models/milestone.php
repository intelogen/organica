<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			milestone.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelMilestone extends JModel {
	
	var $_id				= null;
	var $_milestone			= null;
	var $_pid				= null;
	var $_range				= null;
	var $_published   		= 1;
	var $_required			= array('summary','duedate');

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$pid = JRequest::getVar('pid', 0, '', 'int');
		$this->setPid((int)$pid);
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_milestone	= null;
	}
	
	function setPid($pid)
	{
		$this->_pid		= $pid;
	}

	function setDateRange($dates) {
		$this->_range['lower'] = $dates['lower'];
		
		if (isset($dates['upper'])) $this->_range['upper'] = $dates['upper'];
	}

	function &getMilestone()
	{
		global $mainframe;
		// Load the Category data
		if ($this->_loadMilestone())
		{
			if ($this->_milestone->pid != $this->_pid) :
				JForceHelper::notAuth();
			endif;
			
			$layout = JRequest::getVar('layout');
			
			$this->_milestone->status = $this->_milestone->completed==0 ? 'Active' : 'Completed';
			$this->_milestone->editLink = JRoute::_('index.php?option=com_jforce&view=milestone&layout=form&pid='.$this->_milestone->pid.'&id='.$this->_milestone->id);
			$this->_milestone->rescheduleLink = JRoute::_('index.php?option=com_jforce&view=milestone&layout=reschedule&pid='.$this->_milestone->pid.'&id='.$this->_milestone->id);
			$this->_milestone->assignees = $this->getAssignees($this->_milestone->id);
			if ($layout != 'form') :
				$this->_milestone->tags = JForceHelper::prepareTags($this->_milestone->tags,$this->_milestone->pid);
			endif;

		$mainframe->triggerEvent('onLoadMilestone',array($this->_milestone));		

		}
		else
		{
			$milestone =& JTable::getInstance('Milestone');
			$milestone->parameters	= new JParameter( '' );
			$this->_milestone			= $milestone;
		}

		return $this->_milestone;
	}

	function save($data)
	{
		global $mainframe;
		$user = &JFactory::getUser();
		$milestone  =& JTable::getInstance('Milestone');

		// Check old record for changes
		$id = $data['id'];
		if ($id) :
			$milestone->load($id);
			if ($milestone->completed == 1 && $data['completed'] == 0) :
				$data['reopened'] = 1;
				$data['datereopened'] = gmdate("Y-m-d H:i:s");
				$data['reopenedby'] = $user->get('id');
			elseif ($milestone->completed == 0 && $data['completed'] == 1) :
				$data['datecompleted'] = gmdate("Y-m-d H:i:s");
				$data['completedby'] = $user->get('id');
			endif;
		endif;

		// Bind the form fields to the web link table
		if (!$milestone->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$milestone->id) :
			$milestone->created = gmdate("Y-m-d H:i:s");
			$milestone->author = $user->get('id');
			$new = 1;
			$milestone->published = 1;
		else :
			$new = 0;
		endif;

		$milestone->modified = gmdate("Y-m-d H:i:s");

		// sanitise id field
		$milestone->id = (int) $milestone->id;

		

		// Make sure the table is valid
		if (!$milestone->check()) {
			$this->setError($milestone->getError());
			return false;
		}
		
		if (!isset($data['override'])) :
			JForceHelper::validateObject($milestone, $this->_required);
		endif;
		
		$mainframe->triggerEvent('onBeforeMilestoneSave',array($milestone,$new));		
		
		// Store the article table to the database
		if (!$milestone->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$selectedUsers = JRequest::getVar('hiddenSubscription');
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setId($milestone->id);
		$subscriptionModel->setPid($milestone->pid);
		$subscriptionModel->setAction('milestone');
		$subscriptionModel->save($selectedUsers);
		
		$assignedUsers = JRequest::getVar('hiddenAssignment');
		$subscriptionModel->setType('assignment');
		$subscriptionModel->save($assignedUsers);
		
		$this->_id			=& $milestone->id;
		$this->_milestone	=& $milestone;

		if ($data['notify']) :
			$this->sendNotifications($milestone, $new);
		endif;

		$mainframe->triggerEvent('onAfterMilestoneSave',array($this->_milestone,$new));		

		return true;
	}
	
	function listMilestones($status = 6) {	
	
		if(JRequest::getVar('status')) $status = JRequest::getVar('status');
	
		$ms 				= array();
		$ms['active'] 		= array();
		$ms['late'] 		= array();
		$ms['completed'] 	= array();
						
		switch ($status) {
			
			case 1:
				$ms['active'] = $this->listActiveMilestones();
			break;
			
			case 2:
				$ms['late'] = $this->listLateMilestones();
			break;
			
			case 3:
				$ms['completed'] = $this->listCompletedMilestones();	
			break;
			
			case 4:
				$ms['late'] = $this->listLateMilestones();
				$ms['active'] = $this->listActiveMilestones();
				$ms['completed'] = $this->listCompletedMilestones();	
			break;
			
			case 5:
				$ms['trash'] = $this->listTrashMilestones();
			break;
			
			case 6:
			default:
				$ms['late'] = $this->listLateMilestones();
				$ms['active'] = $this->listActiveMilestones();
			break;
		}

		return $ms;
    }
	
	function getAssignees($id) {
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('milestone');
		$subscriptionModel->setPid($this->_pid);
		$subscriptionModel->setType('assignment');
		$subscriptionModel->setId($id);
		
		$assignees = $subscriptionModel->loadCurrentSubscriptions();
		
		$assignees = $assignees ? JForceHelper::prepareAssignees($assignees) : '';
		
		return $assignees;
	}
	
	function listLateMilestones() {
		global $mainframe;
	
		$query = "SELECT m.*, u.name as author, p.id as authorid ".
				 "FROM #__jf_milestones as m ".
				 "LEFT JOIN #__jf_persons AS p on p.uid = m.author ".
				 "LEFT JOIN #__users AS u on m.author = u.id ".
				 "WHERE m.duedate < NOW() AND m.completed = 0 ".
				 " AND m.duedate <> 0000-00-00 ".
				 "AND m.pid = '$this->_pid' ".
				 "AND m.published = '$this->_published' ".
				 " ORDER BY m.duedate DESC";
        
		$milestones = $this->_getList($query, 0, 0);
		
		
		
		for($i=0;$i<count($milestones);$i++) {
			$milestone = $milestones[$i];
			$milestone->link = JRoute::_('index.php?option=com_jforce&view=milestone&layout=milestone&pid='.$milestone->pid.'&id='.$milestone->id);
			$milestone->assignees = $this->getAssignees($milestone->id);
			$milestone->date = JForceHelper::getDaysDate($milestone->duedate);
			
			$milestone->startdate = JHTML::_('date',  $milestone->startdate,'%b %d, %Y');			
			$milestone->duedate = JHTML::_('date',  $milestone->duedate,'%b %d, %Y');	
			
			$milestone->authorURL = JRoute::_('index.php?option=com_jforce&view=person&layout=person&id='.$milestone->authorid);
			
			$mainframe->triggerEvent('onLoadMilestone',array($milestone));		
		
		}
		
		return $milestones;
	}

	function listCompletedMilestones() {
		global $mainframe;
		
		$query = "SELECT m.*, u.name as author, p.id as authorid ".
				 "FROM #__jf_milestones as m ".
				 "LEFT JOIN #__jf_persons as p on p.uid = m.author ".
				 "LEFT JOIN #__users AS u ON m.author = u.id ".
				 "WHERE m.completed = 1 ".
				 "AND m.pid = '$this->_pid'".
				 "AND m.published = '$this->_published' ".
				 " ORDER BY m.duedate ASC";

        $milestones = $this->_getList($query, 0, 0);
		
		for($i=0;$i<count($milestones);$i++) {
			$milestone = $milestones[$i];
			$milestone->link = JRoute::_('index.php?option=com_jforce&view=milestone&layout=milestone&pid='.$milestone->pid.'&id='.$milestone->id);
			$milestone->assignees = $this->getAssignees($milestone->id);
			
			$milestone->date = JForceHelper::getDaysDate($milestone->duedate);
			
			$milestone->startdate = JHTML::_('date',  $milestone->startdate,'%b %d, %Y');			
			$milestone->duedate = JHTML::_('date',  $milestone->duedate,'%b %d, %Y');			
			$milestone->datecompleted = JHTML::_('date',  $milestone->datecompleted,'%b %d, %Y');

			$milestone->authorURL = JRoute::_('index.php?option=com_jforce&view=person&layout=person&id='.$milestone->authorid);

			$mainframe->triggerEvent('onLoadMilestone',array($milestone));		
		}
				
		return $milestones;
	}

	function listTrashMilestones() {
		global $mainframe;
		
		$query = "SELECT m.*, u.name as author, p.id as authorid ".
				 "FROM #__jf_milestones as m ".
				 "LEFT JOIN #__jf_persons as p on p.uid = m.author ".
				 "LEFT JOIN #__users AS u ON m.author = u.id ".
				 "WHERE m.published = -1 ".
				 "AND m.pid = '$this->_pid'";
        $milestones = $this->_getList($query, 0, 0);
		
		for($i=0;$i<count($milestones);$i++) {
			$milestone = $milestones[$i];
			$milestone->link = JRoute::_('index.php?option=com_jforce&view=milestone&layout=milestone&pid='.$milestone->pid.'&id='.$milestone->id);
			$milestone->assignees = $this->getAssignees($milestone->id);
			$milestone->date = JForceHelper::getDaysDate($milestone->duedate);
			
			$milestone->startdate = JHTML::_('date',  $milestone->startdate,'%b %d, %Y');			
			$milestone->duedate = JHTML::_('date',  $milestone->duedate,'%b %d, %Y');			
			$milestone->datecompleted = JHTML::_('date',  $milestone->datecompleted,'%b %d, %Y');		

			$milestone->authorURL = JRoute::_('index.php?option=com_jforce&view=person&layout=person&id='.$milestone->authorid);

			$mainframe->triggerEvent('onLoadMilestone',array($milestone));		

		}
				
		return $milestones;
	}


	function listActiveMilestones() {
		global $mainframe;
		
		$where = null;
		if (isset($this->_range['lower'])) $where .= " AND m.duedate >= '".$this->_range['lower']."'";
		if (isset($this->_range['upper'])) $where .= " AND m.duedate <= '".$this->_range['upper']."'";
		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR m.id = ',$this->_id);
				$where .= ' AND (m.id = '. $ids.')';
			else:
				$where .=' AND m.id = '.(int) $this->_id;
			endif;
		endif;
	
		$query = "SELECT m.*, u.name as author, p.id as authorid ". 
				 "FROM #__jf_milestones as m " .
				 "LEFT JOIN #__jf_persons as p on p.uid = m.author ".
				 "LEFT JOIN #__users AS u ON m.author = u.id " .
				 "WHERE m.duedate >= NOW() and m.completed = 0 ".
				 " AND m.duedate <> 0000-00-00 ".				 
				 "AND m.pid = '$this->_pid'".
				 "AND m.published = '$this->_published' ".
				 $where.
				 " ORDER BY m.duedate ASC";
				 
				 ;
        $milestones = $this->_getList($query, 0, 0);

		for($i=0;$i<count($milestones);$i++) {
			$milestone = $milestones[$i];
			$milestone->link = JRoute::_('index.php?option=com_jforce&view=milestone&layout=milestone&pid='.$milestone->pid.'&id='.$milestone->id);
			$milestone->assignees = $this->getAssignees($milestone->id);
			$milestone->date = JForceHelper::getDaysDate($milestone->duedate);
	
			$milestone->startdate = JHTML::_('date',  $milestone->startdate,'%b %d, %Y');			
			$milestone->duedate = JHTML::_('date',  $milestone->duedate,'%b %d, %Y');		
			
			$milestone->authorURL = JRoute::_('index.php?option=com_jforce&view=person&layout=person&id='.$milestone->authorid);

			$mainframe->triggerEvent('onLoadMilestone',array($milestone));		

		}
				
		return $milestones;
	}	
	
	function loadChecklists() 
	{
	
		$checklistModel = JModel::getInstance('Checklist','JForceModel');
		$checklistModel->setMid($this->_milestone->id);
		$checklistModel->setId(null);
		$checklists = $checklistModel->listChecklists();
		
		return $checklists;
	}	
	
	function loadDiscussions()
	{
		$discussionModel = JModel::getInstance('Discussion','JForceModel');
		$discussionModel->setMilestone($this->_milestone->id);
		$discussionModel->setId(null);
		$discussions = $discussionModel->listDiscussions();
				
		return $discussions;	
	}

	function loadTickets()
	{
		$ticketModel = JModel::getInstance('Ticket','JForceModel');
		$ticketModel->setMilestone($this->_milestone->id);
		$ticketModel->setId(null);
		$tickets = $ticketModel->listTickets();
				
		return $tickets;	
	}
	
	function loadFiles()
	{
		$documentModel = JModel::getInstance('Document','JForceModel');
		$documentModel->setMilestone($this->_milestone->id);
		$documentModel->setId(null);
		$documents = $documentModel->listDocuments();
				
		return $documents;	
	}
	
	function _loadMilestone()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_milestone))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT m.*, u.name as author, m.author as authorid, b.name AS projectname '.
					' FROM #__jf_milestones AS m' .
					' LEFT JOIN #__jf_persons AS p ON p.id = m.author '.
					' LEFT JOIN #__users AS u ON p.uid = u.id' .
					' LEFT JOIN #__jf_projects AS b ON b.id = m.pid '.
					$where;
			$this->_db->setQuery($query);
			$this->_milestone = $this->_db->loadObject();

			if ( ! $this->_milestone ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function getCountMilestones($pid = null,$completed = false)
	{
		if(!$pid) $pid = $this->_pid;
		
		$where = ' WHERE m.pid = ' . (int) $pid.
				 ' AND m.published = '.$this->_published;
		
		if($completed):
			$where .= '  AND m.completed = 1';
		endif;
		
		$query = 'SELECT COUNT(*) FROM #__jf_milestones AS m '. $where ;
		
		$this->_db->setQuery($query);
		return $this->_db->loadResult();
	}

	function _buildWhere()
	{
		global $mainframe;
	
		$where = ' WHERE m.published = '. (int) $this->_published;
	
		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR m.id = ',$this->_id);
				$where .= ' AND (m.id = '. $ids.')';
			else:
				$where .=' AND m.id = '.(int) $this->_id;
			endif;
		endif;
		
		return $where;
	}	
	
	function buildLists() {
		
		$lists['priority'] = JForceListsHelper::getPriorityList($this->_milestone->priority);
		
		$lists['completed'] = JHTML::_('select.booleanlist', 'completed', '', $this->_milestone->completed, JText::_('Yes'), JText::_('No'));
	
		return $lists;
	}
	
	function sendNotifications($milestone = false, $new = false) {

		if(!$milestone):
			$milestone = $this->getMilestone();
		endif;
		
		$user = &JFactory::getUser();
	
		$values = array(
					'type' => 'Milestone',
					'title' => $milestone->summary, 
					'date' => $milestone->modified, 
					'project' => $milestone->projectname, 
					'description' => $milestone->notes, 
					'author' => $user->name
				);		
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->sendMail($values, $milestone, 'milestone', $new);
		
	}
	
}