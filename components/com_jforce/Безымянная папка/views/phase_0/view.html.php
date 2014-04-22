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

class JforceViewPhase extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'phase') {
			$this->_displayPhase($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}

        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		
		$phases = $model->listPhases();
		
		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$phases):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;
		
		
		$statusOptions = $model->getStatusOptions();
		
		$activeStatus = JRequest::getVar('status');
		
		$this->assignRef('startupText',$startupText);
		$this->assignRef('activeStatus',$activeStatus);
		$this->assignRef('phases', $phases);
		$this->assignRef('statusOptions',$statusOptions);
		$this->assignRef('pagination',	$pagination);
		
        
        parent::display($tpl);		
	}	
	
	function _displayPhase($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		#$model->autoAddPeople();
        $phase = &$model->getPhase();
		
		$milestones = &$model->loadMilestones();

		$latestActivity = $model->latestActivity();
		
		$tabMenu = JForceTabHelper::getTabMenu($phase, false, false);
		
		$this->assignRef('tabMenu',$tabMenu);
		$this->assignRef('milestones',$milestones);
        $this->assignRef('phase', $phase);
		$this->assignRef('latestActivity',$latestActivity);		
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
		//$editor =& JFactory::getEditor();
		// Initialize variables
		
        $model = &$this->getModel();
		
        $phase = &$model->getPhase();
		
		// Build Select Lists
		$lists = &$model->buildLists();
		
		// Build the page title string
		$title = $phase->id ? JText::_('Edit '.$phase->name) : JText::_('New Phase');			

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');				
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem(JText::_('List Phases'), 'index.php?option=com_jforce&view=phase');			
		$pathway->addItem('Edit '.$phase->name, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('phase',	$phase);
		$this->assignRef('user',	$user);
		$this->assignRef('lists',	$lists);
		
		parent::display($tpl);			
	}		
}