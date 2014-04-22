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

class JforceViewDiscussion extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'discussion') {
			$this->_displayDiscussion($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}


		#$doc = &JFactory::getDocument();
		#$css = '.logo { display:none; } ';
		#$doc->addStyleDeclaration($css);

		#JForceStyleHelper::getIconSet();

        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		$discussions = $model->listDiscussions();
		
		$categoryList = $model->getFilter();
		
		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$discussions):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;

		$pid = JRequest::getVar('pid', '');

		$newDiscussionLink = "<a href='".JRoute::_('index.php?option=com_jforce&view=discussion&layout=form&pid='.$pid)."' class='button'>".JText::_('New Discussion')."</a>";
		
		$this->assignRef('startupText',$startupText);
		$this->assignRef('categorylist',$categoryList);
		$this->assignRef('discussions', $discussions);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('newDiscussionLink',$newDiscussionLink);
        
        parent::display($tpl);		
	}	
	
	function _displayDiscussion($tpl) {
        global $mainframe, $option;
		
		$user = &JFactory::getUser();
		$model = &$this->getModel();
		$document =& JFactory::getDocument();
		
		$discussion = &$model->getDiscussion();
		
		$js = "window.addEvent('domready',function() {
				
			$('subscribeLink').addEvent('click',function(e) {
					e = new Event(e);
					subscribeMe('".$discussion->id."','discussion', '".$discussion->pid."');
					e.stop();										
				});
			
			$('remindLink').addEvent('click',function(e) {
						e = new Event(e);
						remindPeople('".$discussion->id."','discussion');
						e.stop();										
					});
			   });";
		
		$document->addScriptDeclaration($js);
	
		
		$discussion->authorUrl = JRoute::_('index.php?option=com_jforce&view=person&layout=person&id='.$discussion->authorid);
		$discussion->milestoneUrl = JRoute::_('index.php?option=com_jforce&view=milestone&layout=milestone&id='.$discussion->milestone);
		$discussion->categoryUrl = JRoute::_('index.php?option=com_jforce&view=discussion&pid='.$discussion->pid.'&category='.$discussion->category);
		
		$comments = JForceHelper::loadComments('discussion', $discussion);
		
		$tabMenu = JForceTabHelper::getTabMenu($discussion);
		
		$this->assignRef('tabMenu',$tabMenu);
		$this->assignRef('trashLink',$trashLink);
        $this->assignRef('discussion', $discussion);
        $this->assignRef('option', $option);
		$this->assignRef('comments', $comments);
		$this->assignRef('subscribeText', $subscribeText);

		parent::display($tpl);		
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
		$privateAccess = $user->systemrole->can_see_private_objects;
		// Initialize variables
        $model = &$this->getModel();
		JForceHelper::initValidation($model->_required);
		
        $discussion = &$model->getDiscussion();
		
		// Build Select Lists
		$lists = &$model->buildLists();	
		
		// Build the page title string
		$title = $discussion->id ? JText::_('Edit Discussion') : JText::_('New Discussion');			

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');		
		JHTML::_('behavior.modal', 'a.modal');
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('discussion');
		$subscriptionFields = $subscriptionModel->buildSubscriptionFields();
		
		$subscriptionLink = 'index.php?tmpl=component&option=com_jforce&view=modal&action=discussion&pid='.$discussion->pid;
		if ($discussion->id) $subscriptionLink .= '&id='.$discussion->id;
				
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('discussion',	$discussion);
		$this->assignRef('user',	$user);	
		$this->assignRef('lists',$lists);
		$this->assignRef('subscriptionLink',$subscriptionLink);
		$this->assignRef('subscriptionFields',	$subscriptionFields);
		$this->assignRef('privateAccess',	$privateAccess);
		
		parent::display($tpl);			
	}		
	
}