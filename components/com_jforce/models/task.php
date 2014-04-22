<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			task.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelTask extends JModel {
	
	var $_id			= null;
	var $_pid			= null;
	var $_cid			= null;
	var $_task			= null;
	var $_range			= null;
	var $_published 	= 1;
	var $_uid			= null;
	var $_myassignments = null;
	var $_required		= array('summary');


    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
	
		$this->_pid		= JRequest::getVar('pid', '');
		$this->_cid		= JRequest::getVar('cid', '');
	} 
	
	function setUid($uid) {
		$this->_uid = $uid;
	}
	
	function setCid($cid)
	{
		$this->_cid = $cid;
	}
	
	function setMyAssignments() {
		
		$this->_myassignments = 1;
	}

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_task	= null;
	}	

	function setPid($pid) {
		$this->_pid		= $pid;
		$this->setId(null);
	}

	function setDateRange($dates) {
		$this->_range['lower'] = $dates['lower'];
		
		if (isset($dates['upper'])) $this->_range['upper'] = $dates['upper'];
	}

	function &getTask()
	{
		global $mainframe;
		// Load the Category data
		if ($this->_loadTask())
		{

		//	$this->_loadTaskParams();
		$mainframe->triggerEvent('onLoadTask',array($this->_task));		
		$this->_task->buttons	= $this->getButtons($this->_task);
		}
		else
		{
			$task =& JTable::getInstance('Task');
			$task->parameters	= new JParameter( '' );
			$this->_task			= $task;
			$this->_task->pid		= $this->_pid;
			$this->_task->cid		= $this->_cid;
			
		}

		return $this->_task;
	}

	function save($data)
	{
		global $mainframe;
		$user = &JFactory::getUser();
		$task  =& JTable::getInstance('Task');


		// Check old record for changes
		$id = $data['id'];
		if ($id) :
			$task->load($id);
			if ($task->completed == 1 && $data['completed'] == 0) :
				$data['reopened'] = 1;
				$data['datereopened'] = gmdate("Y-m-d H:i:s");
				$data['reopenedby'] = $user->get('id');
			elseif ($task->completed == 0 && $data['completed'] == 1) :
				$data['datecompleted'] = gmdate("Y-m-d H:i:s");
				$data['completedby'] = $user->get('id');	
			endif;
		endif;

		// Bind the form fields to the web link table
		if (!$task->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$task->id) :
			$task->created = gmdate("Y-m-d H:i:s");
			$task->author = $user->get('id');
			$task->published = 1;
			$new = 1;
		else :
			$new = 0;
		endif;

		$task->modified = gmdate("Y-m-d H:i:s");

		// sanitise id field
		$task->id = (int) $task->id;

		// Make sure the table is valid
		if (!$task->check()) {
			$this->setError($task->getError());
			return false;
		}
		
		if (!isset($data['override'])) :
			JForceHelper::validateObject($task, $this->_required);
		endif;
		
		$mainframe->triggerEvent('onBeforeTaskSave',array($task,$new));		
		
		// Store the article table to the database
		if (!$task->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_task	= $task;

		$assignedUsers = JRequest::getVar('hiddenAssignment');
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setId($task->id);
		$subscriptionModel->setPid($task->pid);
		$subscriptionModel->setAction('task');
		$subscriptionModel->setType('assignment');
		$subscriptionModel->save($assignedUsers);

		if (isset($data['notify'])) :
			$this->sendNotifications($new, $task);
		endif;

		$mainframe->triggerEvent('onAfterTaskSave',array($task,$new));		

		return $this->_task;
	}
	
	function listTasks() {	
		global $mainframe;
		
		$where = $this->_buildWhere();

		$query = 'SELECT t.*, u.name as author, c.name as completer '.
				' FROM #__jf_tasks AS t' .
				' LEFT JOIN #__users AS u on t.author = u.id '.
				' LEFT JOIN #__users as c on t.completedby = c.id '.
				$where.
				' ORDER BY t.duedate'
				;
				
        $tasks = $this->_getList($query, 0, 0);
		
		for($i=0;$i<count($tasks);$i++):
			$task = $tasks[$i];
			$task->date = JForceHelper::getDaysDate($task->duedate);
			
			$task->duedate= JHTML::_('date',  $task->duedate,'%b %d, %Y');			
			$task->link = JRoute::_('index.php?option=com_jforce&view=checklist&layout=checklist&pid='.$task->pid.'&id='.$task->cid);

			$task->buttons = $this->getButtons($task);

			$subscriptionModel =& JModel::getInstance('Subscription','JForceModel');
			$subscriptionModel->setId($task->id);
			$assignees = $subscriptionModel->loadCurrentSubscriptions();
			$task->assignees = $assignees ? JForceHelper::prepareAssignees($assignees) : '';
			
			$mainframe->triggerEvent('onLoadTask',array($task));		
		endfor;
		
		$this->list = $tasks;
        return $this->list;
    }

	function getButtons($task) {
		
		$buttons = JForceHelper::getTrashLink($task, 'task');

		$buttons .= "<a href='".JRoute::_('index.php?option=com_jforce&view=task&layout=form&pid='.$task->pid.'&cid='.$task->cid.'&id='.$task->id)."'><img src='".JURI::base()."/components/com_jforce/images/edit_icon.png' /></a>";
		$buttons .= "<a href='#'><img src='".JURI::base()."/components/com_jforce/images/time_link.png' /></a>";
		$buttons .= "<a href='#' class='taskSubscribeLinks' id='".$task->id."'><img src='".JURI::base()."/components/com_jforce/images/subscribe_link.png' /></a>";
		
		return $buttons;
		
	}

	function _loadTask()
	{
		global $mainframe;

		if (isset($this->_task)) :
			return true;
		endif;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_task))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT t.*, p.name AS projectname'.
					' FROM #__jf_tasks AS t' .
					' LEFT JOIN #__jf_projects AS p ON p.id = t.pid' .
					$where;
			
			$this->_db->setQuery($query);
			$this->_task = $this->_db->loadObject();

			if ( ! $this->_task ) {
				return false;
			}
			return true;
		} 
		return true;
	}

	function getCountTasks($pid = null,$completed = false)
	{
		if(!$pid) $pid = $this->_pid;
		
		$where = ' WHERE published = 1' .
		 		 ' AND pid = ' . (int) $pid;
		
		if($completed):
			$where .= '  AND completed = 1';
		endif;
		
		$query = 'SELECT COUNT(*) FROM #__jf_tasks '. $where ;
		$this->_db->setQuery($query);
		return $this->_db->loadResult();
	}
	
	function _buildWhere()
	{
		global $mainframe;
		
		$where = ' WHERE t.published = '. (int) $this->_published;

	
		if($this->_uid):
			$subscriptionModel=& JModel::getInstance('Subscription','JForceModel');
			$subscriptionModel->setType('task');
			$this->_id = $subscriptionModel->buildUserSubscriptionIdList($this->_uid, $this->_myassignments);
		endif;
		
		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR t.id = ',$this->_id);
				$where .= ' AND (t.id = '. $ids.')';
			else:
				$where .=' AND t.id = '.(int) $this->_id;
				$where .= ' AND t.cid = '. $this->_cid;
			endif;

		elseif($this->_pid):
			$where .= ' AND t.pid = '.(int)$this->_pid;
		else:
			$where .= ' AND t.cid = '. $this->_cid;
		endif;
		
		if (isset($this->_range['lower'])) :
			$where .= ' AND t.duedate >= "'.$this->_range['lower'].'"';
		endif;
		
		if (isset($this->_range['upper'])) :
			$where .= ' AND t.duedate <= "'.$this->_range['upper'].'"';
		endif;
				
		return $where;
	}	
	
	function buildLists() {
		$lists['priority'] =JforceListsHelper::getPriorityList($this->_task->priority);	

		
		$lists['completed'] = JHTML::_('select.booleanlist', 'completed', '', $this->_task->completed, JText::_('Yes'), JText::_('No'));
		
		return $lists;
	}
	
	function sendNotifications($new, $task) {
		$user = &JFactory::getUser();
		$this->setId($task->id);
		$this->_task = null;
		$task = $this->getTask();
		
		$values = array(
					'type' => 'Task',
					'title' => $task->summary, 
					'date' => $task->modified, 
					'project' => $task->projectname, 
					'description' => '', 
					'author' => $user->name
				);		
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->sendMail($values, $task, 'task', $new);
		
	}
	
}