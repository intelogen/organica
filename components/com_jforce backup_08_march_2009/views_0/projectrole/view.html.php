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

class JforceViewProjectrole extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'projectrole') {
			$this->_displayProjectrole($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}


        $model = &$this->getModel();
		
		$projectroles = $model->listProjectroles();
		
		$this->assignRef('projectroles', $projectroles);

        
        parent::display($tpl);		
	}	
	
	function _displayProjectrole($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		
        $projectrole = &$model->getProjectrole();
        
		$pathway =& $mainframe->getPathway();
		$pathway->addItem(JText::_('List Projectroles'), 'index.php?option=com_jforce&view=projectrole');	
		$pathway->addItem(JText::_('Projectrole'));	

        $this->assignRef('projectrole', $projectrole);
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
		
        $projectrole = &$model->getProjectrole();
		
		// Build the page title string
		$title = $projectrole->id ? JText::_('Edit Projectrole') : JText::_('New Projectrole');			

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');		
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('projectrole',	$projectrole);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);		
		
		parent::display($tpl);			
	}		
	
}