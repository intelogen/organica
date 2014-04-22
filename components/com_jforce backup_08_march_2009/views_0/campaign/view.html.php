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

class JforceViewCampaign extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'campaign') {
			$this->_displayCampaign($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}


        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		$campaigns = $model->listCampaigns();
		
		$categoryList = $model->getFilter();
		
		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$campaigns):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;

		$pid = JRequest::getVar('pid', '');

		$newCampaignLink = "<a href='".JRoute::_('index.php?option=com_jforce&c=sales&view=campaign&layout=form&pid='.$pid)."' class='button'>".JText::_('New Campaign')."</a>";
		
		$this->assignRef('startupText',$startupText);
		$this->assignRef('categorylist',$categoryList);
		$this->assignRef('campaigns', $campaigns);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('newCampaignLink',$newCampaignLink);
        
        parent::display($tpl);		
	}	
	
	function _displayCampaign($tpl) {
        global $mainframe, $option;
		
		$user = &JFactory::getUser();
		$model = &$this->getModel();
		$document =& JFactory::getDocument();
		
		$campaign = &$model->getCampaign();
		
		$js = "window.addEvent('domready',function() {
				
			$('subscribeLink').addEvent('click',function(e) {
					e = new Event(e);
					subscribeMe('".$campaign->id."','campaign');
					e.stop();										
				});
				$('remindLink').addEvent('click',function(e) {
						e = new Event(e);
						remindPeople('".$campaign->id."','campaign');
						e.stop();										
					});
						
			   });";
		
		$document->addScriptDeclaration($js);
		
		$comments = JForceHelper::loadComments('campaign', $campaign);
		
		$tabMenu = JForceTabHelper::getTabMenu($campaign);

		$this->assignRef('tabMenu',$tabMenu);
        $this->assignRef('campaign', $campaign);
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
		#$privateAccess = $user->systemrole->can_see_private_objects;
		// Initialize variables
        $model = &$this->getModel();
		JForceHelper::initValidation($model->_required);
		
        $campaign = &$model->getCampaign();
		
		// Build Select Lists
		$lists = &$model->buildLists();	
		
		// Build the page title string
		$title = $campaign->id ? JText::_('Edit Campaign') : JText::_('New Campaign');			

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');		
		JHTML::_('behavior.modal', 'a.modal');
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('campaign');
		$subscriptionFields = $subscriptionModel->buildSubscriptionFields();
		
		$subscriptionLink = 'index.php?tmpl=component&option=com_jforce&c=sales&view=modal&action=campaign';
		if ($campaign->id) $subscriptionLink .= '&id='.$campaign->id;
				
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('campaign',	$campaign);
		$this->assignRef('user',	$user);	
		$this->assignRef('lists',$lists);
		$this->assignRef('subscriptionLink',$subscriptionLink);
		$this->assignRef('subscriptionFields',	$subscriptionFields);
		$this->assignRef('privateAccess',	$privateAccess);
		
		parent::display($tpl);			
	}		
	
}