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

class JforceViewLead extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'lead') {
			$this->_displayLead($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}
		
		if($layout == 'new') {
			$this->_displayLeadForm($tpl);
			return;
		}
		
		$link = 'index.php?option=com_jforce&c=sales&view=lead&layout=form';
		$newLink = '<a href="'.JRoute::_($link).'" class="button">'.JText::_('New Lead').'</a>';

        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		$leads = $model->listLeads();
		
		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$leads):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;
		
		$this->assignRef('startupText',$startupText);
		$this->assignRef('leads', $leads);
		$this->assignRef('newLink',$newLink);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('pid',$pid);
        
        parent::display($tpl);		
	}	
	
	function _displayLead($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		
        $lead = &$model->getLead();
		
		JHTML::_('behavior.modal');
        
		$pathway =& $mainframe->getPathway();
		$pathway->addItem(JText::_('List Leads'), 'index.php?option=com_jforce&c=sales&view=lead');	
		$pathway->addItem(JText::_('Lead'));	
		
		$tabMenu = JForceTabHelper::getTabMenu($lead, false, false);

		$this->assignRef('tabMenu',$tabMenu);
        $this->assignRef('lead', $lead);
        $this->assignRef('option', $option);

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
		
        $lead = &$model->getLead();
			
		$customFields = $lead->customFields;
		
		$lists = $model->buildLists();
		
		// Build the page title string
		$title = $lead->id ? JText::_('Edit Lead') : JText::_('New Lead');			
				
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('lead',	$lead);
		$this->assignRef('editor',	$editor);
		$this->assignRef('customFields',	$customFields);	
		$this->assignRef('lists',	$lists);
		
		parent::display($tpl);			
	}		
	function _displayLeadForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$uri		=& JFactory::getURI();	
		// Load the JEditor object
		$editor =& JFactory::getEditor();

		// Initialize variables
        $model = &$this->getModel();
		
        $lead = &$model->getLead();
		
		JForceHelper::initValidation($model->_required);
	
		$customFields = $lead->customFields;
		
		$lists = $model->buildLists();
		
		// Build the page title string
		$title = JText::_('New Lead');			
			
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('lead',	$lead);
		$this->assignRef('editor',	$editor);
		$this->assignRef('customFields',	$customFields);	
		$this->assignRef('lists',	$lists);
		
		parent::display($tpl);			
	}		
		
}