<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			checklist.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelChecklist extends JModel {
	
	var $_id				= null;
	var $_checklist			= null;
	var $_mid				= null;
	var $_pid				= null;
	var $_range				= null;
	var $_published			= 1;
	var $_required			= array('summary');

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$pid = JRequest::getVar('pid', 0, '', 'int');
		$this->setPid((int)$pid);
	} 

	function setMid($mid) 
	{
		$this->_mid = $mid;
	}
	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id			= $id;
		$this->_checklist	= null;
	}
	
	function setPid($pid)
	{
		$this->_pid		= $pid;
	}	

	function setPublished($published)
	{
		$this->_published = $published;	
	}
	function &getChecklist()
	{
		global $mainframe;
		$user = &JFactory::getUser();
		// Load the Category data
		if ($this->_loadChecklist())
		{
			if ($this->_checklist->pid != $this->_pid || ($this->_checklist->visibility == '0' && $user->systemrole->can_see_private_objects == '0')) :
				JForceHelper::notAuth();
			endif;
			$read = JForceHelper::getObjectStatus($this->_checklist->id,'checklist');
			if(!$read) JForceHelper::setObjectStatus($this->_checklist->id,'checklist');
			
			$layout = JRequest::getVar('layout');
			if($layout!='form'):
				$this->_checklist->tags = JForceHelper::prepareTags($this->_checklist->tags, $this->_checklist->pid);
			endif;		

			$mainframe->triggerEvent('onLoadChecklist',array($this->_checklist));

		}
		else
		{
			$checklist =& JTable::getInstance('Checklist');
			$checklist->parameters	= new JParameter( '' );
			$this->_checklist			= $checklist;
			$this->_checklist->pid		= $this->_pid;
			$this->_checklist->milestone = $this->_mid;
		}

		return $this->_checklist;
	}

	function save($data)
	{
		global $mainframe;

		$checklist  =& JTable::getInstance('Checklist');
		$user = &JFactory::getUser();

		$data['visibility'] = isset($data['visibility']) ? $data['visibility'] : 1;

		// Check old record for changes
		$id = $data['id'];
		if ($id) :
			$checklist->load($id);
			if ($checklist->completed == 1 && $data['completed'] == 0) :
				$data['reopened'] = 1;
				$data['datereopened'] = gmdate("Y-m-d H:i:s");
				$data['reopenedby'] = $user->get('id');
			elseif ($checklist->completed == 0 && $data['completed'] == 1) :
				$data['datecompleted'] = gmdate("Y-m-d H:i:s");
				$data['completedby'] = $user->get('id');	
			endif;
		endif;

		// Bind the form fields to the web link table
		if (!$checklist->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$checklist->id) :
			$checklist->created = gmdate("Y-m-d H:i:s");
			$checklist->author = $user->get('id');
			$checklist->published = 1;
			$isNew = true;
		else :
			$checklist->modified = gmdate("Y-m-d H:i:s");
			$isNew = false;
		endif;

		// sanitise id field
		$checklist->id = (int) $checklist->id;
		$checklist->description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		// Make sure the table is valid
		if (!$checklist->check()) {
			$this->setError($checklist->getError());
			return false;
		}
		
		if (!isset($data['override'])) :
			JForceHelper::validateObject($checklist, $this->_required);
		endif;
		
		$mainframe->triggerEvent('onBeforeChecklistSave',array($checklist,$isNew));
		
		// Store the article table to the database
		if (!$checklist->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$selectedUsers = JRequest::getVar('hiddenSubscription');
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setId($checklist->id);
		$subscriptionModel->setPid($checklist->pid);
		$subscriptionModel->setAction('checklist');
		$subscriptionModel->save($selectedUsers);
		
		$this->_checklist	=& $checklist;

		$mainframe->triggerEvent('onAfterChecklistSave',array($this->_checklist,$isNew));
		
		return $this->_checklist;
	}
	
	function getTotal() {
		
		$where = $this->_buildWhere();
		
		$query = 'SELECT COUNT(*)'.
				' FROM #__jf_checklists AS c' .
				' LEFT JOIN #__users AS u ON c.author = u.id' .	
				$where;
		$this->_db->setQuery($query);
        $total = $this->_db->loadResult();
		
		return $total;
	}
	
	function listChecklists() {	
		global $mainframe;
        
        // check permission here
        // JTPL hack
        // check current user and see the role
        $user = JFactory::getUser();
        
        if($user->systemrole->name == "Client"){
            // check phase status
            $project_id = $this->_pid;
            $project_model = JModel::getInstance("Project","JForceModel");
            $project = $project_model->getProject();
            $status = $project->status;
            
            // check status and load checklists only when the project is active or paused
            if($status == "Active" || $status == "Completed"){
                // do nothing
            }else{                
                $mainframe->redirect(JRoute::_("index.php?option=com_jforce&view=project&status=Active"),"Phases those are marked Active or Completed can only be accessed. ");
                //http://maxim.janakitech.com/index.php?option=com_jforce&view=checklist&pid=594
            }
        }
	
		$where = $this->_buildWhere();
		
		$limit = JRequest::getVar('limit', 0);
		$limitstart = JRequest::getVar('limitstart', 0);

		$query = 'SELECT c.*, u.name as author'.
				' FROM #__jf_checklists AS c' .
				' LEFT JOIN #__users AS u ON c.author = u.id' .	
				$where.
				' ORDER BY c.id ASC' // changed to ORDER BY ASC because first created was the first step
				;

        $checklists = $this->_getList($query, $limitstart, $limit);
		
		for($i=0;$i<count($checklists);$i++) {
			$checklist = $checklists[$i];
			$checklist->link = JRoute::_('index.php?option=com_jforce&view=checklist&layout=checklist&pid='.$checklist->pid.'&id='.$checklist->id);
			$checklist->openTasks = $this->getOpenTasks($checklist->id);
			$checklist->totalTasks = $this->getTotalTasks($checklist->id);
	
			$read = JForceHelper::getObjectStatus($checklist->id,'checklist');
			if($read):
				$checklist->read = "<img src='".JURI::root()."components/com_jforce/images/checklist_icon.png' />";
			else:
				$checklist->read = "<img src='".JURI::root()."components/com_jforce/images/checklist_icon_new.png' />";
			endif;
	
			$mainframe->triggerEvent('onLoadChecklist',array($checklist));			
		}
		
		$this->list =$checklists;

        return $this->list;
    }

	function loadTasks() 
	{
		$taskModel = &JModel::getInstance('Task','JForceModel');		
		$taskModel->setCid($this->_checklist->id);
		$taskModel->setId(null);
		$taskModel->setPid(null);
		$tasks = $taskModel->listTasks();
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('task');
		$subscriptionModel->setPid($this->_checklist->pid);
		$subscriptionModel->setType('assignment');
		
		$taskList['active'] = array();
		$taskList['completed'] = array();		
		
		for($i=0;$i<count($tasks);$i++):
			$task = $tasks[$i];
			
			$subscriptionModel->setId($task->id);
			$assignees = $subscriptionModel->loadCurrentSubscriptions();
			$task->assignees = $assignees ? JForceHelper::prepareAssignees($assignees) : '';
			
			if($task->completed):
				$taskList['completed'][] = $task;
			else:
				$taskList['active'][] = $task;
			endif;
		endfor;
		
		return $taskList;
	}
	function _loadChecklist()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_checklist))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT c.*, u.name as author, m.summary as milestone '.
					' FROM #__jf_checklists AS c' .
					' LEFT JOIN #__users AS u ON c.author = u.id' .
					' LEFT JOIN #__jf_milestones AS m on c.milestone = m.id' .								
					$where;
					
			$this->_db->setQuery($query);
			$this->_checklist = $this->_db->loadObject();
			
			if ( ! $this->_checklist ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function _buildWhere()
	{
		global $mainframe;
		$user = &JFactory::getUser();
	
		$where = ' WHERE c.published = '. (int) $this->_published;
	
		if($this->_id):
			
			if(is_array($this->_id)):
				$ids = implode(' OR c.id = ',$this->_id);
				$where .= ' AND (c.id = '. $ids.')';
			else:
				$where .=' AND c.id = '.(int) $this->_id;
			endif;
			$where .= ' AND c.pid = '.(int) $this->_pid;
		endif;
		
		if($this->_pid):
			$where .= ' AND c.pid = '.(int) $this->_pid;
		endif;
		
		if($this->_mid):
			$where .= ' AND c.milestone = '. (int) $this->_mid;
		endif;
		
		if(!$user->systemrole->can_see_private_objects && !$this->_id) :
			$where .= " AND c.visibility = '1'";
		endif;
		
		return $where;
	}	
	
	function buildLists() {
				
		$lists['milestones'] = JforceListsHelper::getMilestoneList($this->_checklist->milestone);
				
		$lists['visibility'] = JHTML::_('select.booleanlist', 'visibility', '', $this->_checklist->visibility, JText::_('Public'), JText::_('Private'));
		$lists['completed'] = JHTML::_('select.booleanlist', 'completed', '', $this->_checklist->completed, JText::_('Yes'), JText::_('No'));


		return $lists;
	}
	
	function getOpenTasks($id = null) {
		$id = $id ? $id : $this->_id;
		$query = "SELECT COUNT(*) FROM #__jf_tasks WHERE cid = '$id' AND completed = '0' AND published = '1'";
		$this->_db->setQuery($query);
		$openTasks = $this->_db->loadResult();
	
		return $openTasks;
	}
	
	function getTotalTasks($id = null) {
		$id = $id ? $id : $this->_id;
		$query = "SELECT COUNT(*) FROM #__jf_tasks WHERE cid = '$id' AND published = '1'";
		$this->_db->setQuery($query);
		$totalTasks = $this->_db->loadResult();
		
		return $totalTasks;
	}
	
	function updateCompletion($complete) {
		$query = "UPDATE #__jf_checklists SET completed	='$complete' WHERE id = '$this->_id'";
		$this->_db->setQuery($query);
		$this->_db->query();
	}
    
    function getCountChecklists($pid = null,$completed = false)
    {
        if(!$pid) $pid = $this->_pid;
        
        $where = ' WHERE published = 1' .
                  ' AND pid = ' . (int) $pid;
        
        if($completed):
            $where .= '  AND completed = 1';
        endif;
        
        $query = 'SELECT COUNT(*) FROM #__jf_checklists '. $where ;
        $this->_db->setQuery($query);
        return $this->_db->loadResult();
    }
	
}