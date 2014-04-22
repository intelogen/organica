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

class JforceViewMilestone extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();


		if ($layout == 'milestone') {
			$this->_displayMilestone($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}
		
		if($layout == 'reschedule') {
			$this->_displayReschedule($tpl);
			return;
		}


        $model = &$this->getModel();
		
		$milestones = $model->listMilestones();
		
		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$milestones['active'] && !$milestones['late'] && !$milestones['completed']):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;
		
		$pid = JRequest::getVar('pid', 0);
		$link = "index.php?option=com_jforce&view=milestone&layout=form";
		if ($pid) $link .= "&pid=".$pid;
		$newMilestoneLink = "<a href='".JRoute::_($link)."' class='button'>".JText::_('New Milestone')."</a>";
		
		$activeMilestonesLink = JRoute::_('index.php?option=com_jforce&view=milestone&pid='.$pid);
		$completedMilestonesLink = JRoute::_('index.php?option=com_jforce&view=milestone&pid='.$pid.'&status=3');
		
		$status = JRequest::getVar('status');
		
		$this->assignRef('status',$status);
		$this->assignRef('startupText',$startupText);
		$this->assignRef('activeMilestonesLink',$activeMilestonesLink);
		$this->assignRef('completedMilestonesLink',$completedMilestonesLink);
		$this->assignRef('milestones', $milestones);
		$this->assignRef('newMilestoneLink', $newMilestoneLink);

        
        parent::display($tpl);		
	}	
	
	function _displayMilestone($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		JForceHelper::initValidation($model->_required);
		$document =& JFactory::getDocument();
		$user = &JFactory::getUser();
		
        $milestone = &$model->getMilestone();
		
		$discussions = &$model->loadDiscussions();
		
		$checklists = &$model->loadChecklists();
		
		$files = &$model->loadFiles();
		
		$tickets = &$model->loadTickets();

		$js = "window.addEvent('domready',function() {
				
				$('toggleLink').addEvent('click',function(e) {
					e = new Event(e);
					toggleMilestone('".$milestone->id."');
					e.stop();										
				});

				$('subscribeLink').addEvent('click',function(e) {
						e = new Event(e);
						subscribeMe('".$milestone->id."','milestone', '".$milestone->pid."');
						e.stop();										
					});
				
				$('remindLink').addEvent('click',function(e) {
						e = new Event(e);
						remindPeople('".$milestone->id."','milestone');
						e.stop();										
					});
			
			   });";
		
		$document->addScriptDeclaration($js);

		$pid = JRequest::getVar('pid', 0);
		$link = "index.php?option=com_jforce&view=milestone&layout=form";
		if ($pid) $link .= "&pid=".$pid;
		$newMilestoneLink = "<a href='".JRoute::_($link)."' class='button'>".JText::_('New Milestone')."</a>";	
			
		$links = array();
		$links['checklist'] = JRoute::_('index.php?option=com_jforce&view=checklist&layout=form&pid='.$pid.'&milestone='.$milestone->id);
		$links['discussion'] = JRoute::_('index.php?option=com_jforce&view=discussion&layout=form&pid='.$pid.'&milestone='.$milestone->id);
		$links['file'] = JRoute::_('index.php?option=com_jforce&view=file&layout=upload&pid='.$pid.'&milestone='.$milestone->id);
		$links['ticket'] = JRoute::_('index.php?option=com_jforce&view=ticket&layout=form&pid='.$pid.'&milestone='.$milestone->id);
		
		$tabMenu = JForceTabHelper::getTabMenu($milestone);
		
		$this->assignRef('tabMenu',$tabMenu);
		$this->assignRef('links',$links);
		$this->assignRef('newMilestoneLink',$newMilestoneLink);
		$this->assignRef('checklists',$checklists);
		$this->assignRef('discussions',$discussions);
		$this->assignRef('files',$files);
		$this->assignRef('tickets',$tickets);
        $this->assignRef('milestone', $milestone);
        $this->assignRef('option', $option);
		
		parent::display($tpl);		
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
			
		// Initialize variables
        $model = &$this->getModel();
		JForceHelper::initValidation($model->_required);
        $milestone = &$model->getMilestone();
		
		$showPid = true;
		if ($milestone->id) $showPid = false;
		if (!$milestone->pid && JRequest::getVar('pid')) :
			$showPid = false;
			$milestone->pid = JRequest::getVar('pid');
		endif;
		$lists = &$model->buildLists();
		// Build the page title string
		$title = $milestone->id ? JText::_('Edit Milestone') : JText::_('New Milestone');			

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');	
		JHTML::_('behavior.modal', 'a.modal');
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('milestone');
		$subscriptionFields = $subscriptionModel->buildSubscriptionFields();
		
		$subscriptionLink = 'index.php?tmpl=component&option=com_jforce&view=modal&action=milestone&type=subscription&pid='.$milestone->pid;
		
		$subscriptionModel->setType('assignment');
		$assignmentFields = $subscriptionModel->buildSubscriptionFields();
		$assignmentLink = 'index.php?tmpl=component&option=com_jforce&view=modal&action=milestone&type=assignment&pid='.$milestone->pid;
				
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('milestone',	$milestone);
		$this->assignRef('user',	$user);	
		$this->assignRef('lists',	$lists);
		$this->assignRef('showPid',	$showPid);
		$this->assignRef('subscriptionLink',	$subscriptionLink);
		$this->assignRef('subscriptionFields',	$subscriptionFields);
		$this->assignRef('assignmentLink',	$assignmentLink);
		$this->assignRef('assignmentFields',	$assignmentFields);
		
		parent::display($tpl);			
	}		
	function _displayReschedule($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
			
		// Initialize variables
        $model = &$this->getModel();
		
        $milestone = &$model->getMilestone();
		
		$allMilestones =& $model->listMilestones();
		
		$lists = &$model->buildLists();
		// Build the page title string
		$title = JText::_('Reschedule Milestone');			

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');	
		JHTML::_('behavior.modal', 'a.modal');
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title);		
		
		$this->assignRef('allMilestones',$allMilestones);
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('milestone',	$milestone);
		$this->assignRef('user',	$user);	
		$this->assignRef('lists',	$lists);
		
		parent::display($tpl);			
	}		
}