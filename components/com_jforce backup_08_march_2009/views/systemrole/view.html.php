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

class JforceViewSystemrole extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'systemrole') {
			$this->_displaySystemrole($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}


        $model = &$this->getModel();
		
		$systemroles = $model->listSystemroles();
		
		$this->assignRef('systemroles', $systemroles);

        
        parent::display($tpl);		
	}	
	
	function _displaySystemrole($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		
        $systemrole = &$model->getSystemrole();
        
		$pathway =& $mainframe->getPathway();
		$pathway->addItem(JText::_('List Systemroles'), 'index.php?option=com_jforce&view=systemrole');	
		$pathway->addItem(JText::_('Systemrole'));	

        $this->assignRef('systemrole', $systemrole);
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
		
        $systemrole = &$model->getSystemrole();
		
		// Build the page title string
		$title = $systemrole->id ? JText::_('Edit Systemrole') : JText::_('New Systemrole');			

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');		
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('systemrole',	$systemrole);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);		
		
		parent::display($tpl);			
	}		
	
}