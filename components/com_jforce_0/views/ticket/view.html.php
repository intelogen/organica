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

class JforceViewTicket extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'ticket') {
			$this->_displayTicket($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}


        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		$tickets = $model->listTickets();
		$pid = JRequest::getVar('pid');
		
		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$tickets):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;
				
		$status = JRequest::getVar('status');
		
		$this->assignRef('status',$status);
		$this->assignRef('startupText',$startupText);
		$this->assignRef('tickets', $tickets);
		$this->assignRef('pid', $pid);
		$this->assignRef('pagination', $pagination);

        
        parent::display($tpl);		
	}	
	
	function _displayTicket($tpl) {
        global $mainframe, $option;
		$document = &JFactory::getDocument();
		$user = &JFactory::getUser();
        $model = &$this->getModel();
		
        $ticket = &$model->getTicket();

		$js = "window.addEvent('domready',function() {

			$('subscribeLink').addEvent('click',function(e) {
					e = new Event(e);
					subscribeMe('".$ticket->id."','ticket', '".$ticket->pid."');
					e.stop();										
				});
			
			$('remindLink').addEvent('click',function(e) {
						e = new Event(e);
						remindPeople('".$ticket->id."','ticket');
						e.stop();										
					});
			   });";
		
		$document->addScriptDeclaration($js);

		
		$ticket->authorUrl = JRoute::_('index.php?option=com_jforce&view=person&layout=person&pid='.$ticket->pid.'id='.$ticket->authorid);
		$ticket->milestoneUrl = JRoute::_('index.php?option=com_jforce&view=milestone&layout=milestone&pid='.$ticket->pid.'&id='.$ticket->milestone);
		$ticket->categoryUrl = JRoute::_('index.php?option=com_jforce&view=ticket&pid='.$ticket->pid.'&category='.$ticket->category);
		
		$comments = JForceHelper::loadComments('ticket', $ticket);

		$tabMenu = JForceTabHelper::getTabMenu($ticket);
		
		$this->assignRef('tabMenu',$tabMenu);
		$this->assignRef('comments', $comments);
		$this->assignRef('pagination', $pagination);
        $this->assignRef('ticket', $ticket);
        $this->assignRef('option', $option);
		$this->assignRef('commentView', $commentView);

		parent::display($tpl);		
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
			
		// Load the JEditor object
		$editor =& JFactory::getEditor();

		// Initialize variables
        $model = &$this->getModel();
		JForceHelper::initValidation($model->_required);
        $ticket = &$model->getTicket();
		
		$lists = &$model->buildLists();	
	
		// Build the page title string
		$title = $ticket->id ? JText::_('Edit Ticket') : JText::_('New Ticket');			

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');		
		JHTML::_('behavior.modal', 'a.modal');
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('ticket');
		$subscriptionFields = $subscriptionModel->buildSubscriptionFields();
		
		$subscriptionLink = 'index.php?tmpl=component&option=com_jforce&view=modal&action=ticket&pid='.$ticket->pid;
		if ($ticket->id) $subscriptionLink .= '&id='.$ticket->id;
		
		$subscriptionModel->setType('assignment');
		$assignmentFields = $subscriptionModel->buildSubscriptionFields();
		$assignmentLink = 'index.php?tmpl=component&option=com_jforce&view=modal&action=milestone&type=assignment&pid='.$ticket->pid;
				
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('lists',$lists);
		$this->assignRef('ticket',	$ticket);
		$this->assignRef('editor',	$editor);
		$this->assignRef('subscriptionLink',	$subscriptionLink);
		$this->assignRef('subscriptionFields',	$subscriptionFields);
		$this->assignRef('assignmentLink',	$assignmentLink);
		$this->assignRef('assignmentFields',	$assignmentFields);
	#	$this->assignRef('customFields',	$customFields);		
		
		parent::display($tpl);			
	}		
	
}