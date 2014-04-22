<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			ajax.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								  	*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class JforceControllerAjax extends JController {

	function display() {
		// Set a default view if none exists
		if ( ! JRequest::getCmd( 'view' ) ) {
		
		$default = 'company'; 
		
			JRequest::setVar('view', $default );
		}
		
		parent::display();	
	}	
	
	/**
	 * Call the Save Function
	 * Model determined by Array value
	 * @return 
	 */
	
	function toggleTask() {
		$post = JRequest::get('post');
		$id = $post['id'];
		$model = &JModel::getInstance('Task', 'JforceModel');
		$current = &JTable::getInstance('Task', 'JTable');
		$current->load($id);
		
		$data['id'] = $id;
		$data['completed'] = 1-$current->completed;
		
		$task = $model->save($data);
		
		$checkListModel = &JModel::getInstance('Checklist', 'JForceModel');
		$checkListModel->setId($task->cid);
		$openTasks = $checkListModel->getOpenTasks();
		
		$complete = !$openTasks ? 1 : 0;

		$checkListModel->updateCompletion($complete);
		
		$return = array(
					$data['completed'],
					$complete
					);
		
		echo $this->ajaxEncode($return);
		
	}
	
	function createTask() {
			// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$post = &JRequest::get('post');
		
		$model = &$this->getModel('Task');
		$model->save($post);
		
		$task = $model->getTask();
		if ($task->duedate) :
			$task->date = JForceHelper::getDaysDate($task->duedate);		
			$task->duedate= JHTML::_('date',  $task->duedate,'%b %d, %Y');
		else :
			$task->date = '';
			$task->duedate = '';
		endif;
		
		$return = array(
						$task->id,
						$task->summary,
						$task->duedate,
						$task->date,
						$task->buttons
						);
		echo $this->ajaxEncode($return);
	}
	
	function prefillCompany() {
		$post = JRequest::get('post');
		$id = $post['id'];
	
		$model = &$this->getModel('Company');
		$current = &JTable::getInstance('Company', 'JTable');

		$current->load($id);
		
		$return = array(
						$current->name,
						$current->address,
						$current->phone,
						$current->fax,
						$current->homepage
						);
		
		echo $this->ajaxEncode($return);
	}
	function prefillProject() {
		$post = JRequest::get('post');
		$pid = $post['pid'];
	
		$model = &$this->getModel('Project');
		$current = &JTable::getInstance('Project', 'JTable');

		$current->load($pid);
		
		$return = array(
						$current->name,
						$current->description
						);
		
		echo $this->ajaxEncode($return);
	}
	
	function getServiceInfo() {
		$serviceModel = &JModel::getInstance('Service', 'JForceModel');
		$service = $serviceModel->getService();
		
		$return = array($service->price, $service->description);
		$return = $this->ajaxEncode($return);
		echo $return;
	}
	
	function ajaxEncode($array) {
		$delimiter = '|%|';
		$encode = implode($delimiter, $array);
		return $encode;
	}
	
	function getProfileIcon() {
		$model = JRequest::getVar('model');
		#$model = &$this->getModel($model);
		#$icon = $model->getProfileIcon();
		$icon = JForceIconHelper::getProfileIcon($model);
		echo $icon;
	}
	
	function removeProfileIcon() {
		$model = JRequest::getVar('model');
		#$model = &$this->getModel($model);
		JForceIconHelper::updateIcon($model);
		#$model->removeProfileIcon();
	}
	
	function toggleMilestone() {
		$model =& JModel::getInstance('Milestone','JForceModel');
		$milestone = JTable::getInstance('Milestone');
		$post = JRequest::get('post');		
		$id = $post['id'];
		$milestone->load($id);
		$status = $milestone->completed;
		
		$newStatus = 1 - $status;
		
		if($newStatus):
			$linkText = JText::_('Reopen'); 
			$value = JText::_('Completed'); 
		else:
			$linkText = JText::_('Complete');
			$value = JText::_('Active');
		endif;
		
		$milestone->completed = $newStatus;
		
		$milestone->store();
		
		$return = array($value,$linkText);
		$return = $this->ajaxEncode($return);
		
		echo $return;
	}
	
	function toggleBillable() {
		$model =& JModel::getInstance('Timetracker','JForceModel');
		$time = JTable::getInstance('Timetracker');
		$post = JRequest::get('post');		
		$id = $post['id'];
		$id = str_replace('bt_','',$id);
		$time->load($id);
		$status = $time->billable;
		
		$newStatus = 1 - $status;
		
		$time->billable = $newStatus;
		
		$time->store();

		$return = 'components/com_jforce/images/billable_'.$time->billable.'.png'; 

		echo $return;
	}

	function subscribeMe() {	
		$post = JRequest::get('post');

		$model = JModel::getInstance('Subscription','JForceModel');
		$return = $model->subscribeMe($post);
		
		echo $return;
	}
	
	function remindPeople() {
		
		$post = JRequest::get('post');
		$type = ucwords($post['type']);
		
		$model =& JModel::getInstance($type, 'JForceModel');
		$model->setId($post['id']);
		$model->sendNotifications();
	
	}
}