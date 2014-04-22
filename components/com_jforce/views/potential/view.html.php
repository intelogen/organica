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

class JforceViewPotential extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'potential') {
			$this->_displayPotential($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}


        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		$potentials = $model->listPotentials();
		
		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$potentials):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;

		$newPotentialLink = "<a href='".JRoute::_('index.php?option=com_jforce&c=sales&view=potential&layout=form')."' class='button'>".JText::_('New Potential')."</a>";
		
		$this->assignRef('startupText',$startupText);
		$this->assignRef('potentials', $potentials);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('newPotentialLink',$newPotentialLink);
        
        parent::display($tpl);		
	}	
	
	function _displayPotential($tpl) {
        global $mainframe, $option;
		
		$user = &JFactory::getUser();
		$model = &$this->getModel();
		$document =& JFactory::getDocument();
		
		$potential = &$model->getPotential();
		
		$js = "window.addEvent('domready',function() {
				
			$('subscribeLink').addEvent('click',function(e) {
					e = new Event(e);
					subscribeMe('".$potential->id."','potential', '');
					e.stop();										
				});
			$('remindLink').addEvent('click',function(e) {
					e = new Event(e);
					remindPeople('".$potential->id."','potential');
					e.stop();										
				});

			   });";
		
		$document->addScriptDeclaration($js);
	
		
		$potential->authorUrl = JRoute::_('index.php?option=com_jforce&c=sales&view=person&layout=person&id='.$potential->authorid);
		
		$comments = JForceHelper::loadComments('potential', $potential);

		$tabMenu = JForceTabHelper::getTabMenu($potential);

		$this->assignRef('tabMenu',$tabMenu);
        $this->assignRef('potential', $potential);
        $this->assignRef('option', $option);
		$this->assignRef('comments', $comments);

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
        $potential = &$model->getPotential();
		
		$js = "window.addEvent('domready',function() {
						
				$('lead0').addEvent('click',function(e) {
						togglePotentialType();									
				});
				
				$('lead1').addEvent('click',function(e) {
						togglePotentialType();									
				});
				
				togglePotentialType();
				});";
		
		$document->addScriptDeclaration($js);
		
		// Build Select Lists
		$lists = &$model->buildLists();	
		
		// Build the page title string
		$title = $potential->id ? JText::_('Edit Potential') : JText::_('New Potential');			

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');		
		JHTML::_('behavior.modal', 'a.modal');
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('potential');
		$subscriptionFields = $subscriptionModel->buildSubscriptionFields();
		
		$subscriptionLink = 'index.php?tmpl=component&option=com_jforce&c=sales&view=modal&action=potential';
		if ($potential->id) $subscriptionLink .= '&id='.$potential->id;
				
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('potential',	$potential);
		$this->assignRef('user',	$user);	
		$this->assignRef('lists',$lists);
		$this->assignRef('subscriptionLink',$subscriptionLink);
		$this->assignRef('subscriptionFields',	$subscriptionFields);
		$this->assignRef('privateAccess',	$privateAccess);
		
		parent::display($tpl);			
	}		
	
}