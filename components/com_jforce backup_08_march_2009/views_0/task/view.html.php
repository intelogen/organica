<?php 

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			view.html.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view'); 

class JforceViewTask extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'task') {
			$this->_displayTask($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}

        $model = &$this->getModel();


		$user =& JFactory::getUser();
		$model->setUid($user->id);
		
		$assigned = JRequest::getVar('assigned', 0, '', 'int');
		if($assigned):
			$model->setMyAssignments();
		endif;


		$tasks = $model->listTasks();
		
		$this->assignRef('tasks', $tasks);

        
        parent::display($tpl);		
	}	
	
	function _displayTask($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		
        $task = &$model->getTask();
    
        $this->assignRef('task', $task);
        $this->assignRef('option', $option);

		parent::display($tpl);		
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
			
		JHTML::_('behavior.modal');
		// Initialize variables
        $model = &$this->getModel();
		JForceHelper::initValidation($model->_required);
        $task = &$model->getTask();
		$lists = &$model->buildLists();
		// Build the page title string
		$title = $task->id ? JText::_('Edit Task') : JText::_('New Task');			

		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('task');
		$subscriptionFields = $subscriptionModel->buildSubscriptionFields();
		
		$subscriptionLink = 'index.php?tmpl=component&option=com_jforce&view=modal&action=task&type=subscription&pid='.$task->pid;
		
		$subscriptionModel->setType('assignment');
		$assignmentFields = $subscriptionModel->buildSubscriptionFields();
		$assignmentLink = 'index.php?tmpl=component&option=com_jforce&view=modal&action=task&type=assignment&pid='.$task->pid;

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');	
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('task',	$task);
		$this->assignRef('user',	$user);	
		$this->assignRef('lists',	$lists);
		$this->assignRef('subscriptionLink',	$subscriptionLink);
		$this->assignRef('subscriptionFields',	$subscriptionFields);
		$this->assignRef('assignmentFields',	$assignmentFields);
		$this->assignRef('assignmentLink',	$assignmentLink);
		
		parent::display($tpl);			
	}		
	
}