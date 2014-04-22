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

class JforceViewCustomfield extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'customfield') {
			$this->_displayCustomfield($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}


        $model = &$this->getModel();
		
		$customfields = $model->listCustomfields();
		
		$this->assignRef('customfields', $customfields);

        
        parent::display($tpl);		
	}	
	
	function _displayCustomfield($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		
        $customfield = &$model->getCustomfield();
        
		$pathway =& $mainframe->getPathway();
		$pathway->addItem(JText::_('List Customfields'), 'index.php?option=com_jforce&view=customfield');	
		$pathway->addItem(JText::_('Customfield'));	

        $this->assignRef('customfield', $customfield);
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
		
        $customfield = &$model->getCustomfield();
		
		// Build the page title string
		$title = $customfield->id ? JText::_('Edit Customfield') : JText::_('New Customfield');			

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');		
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('customfield',	$customfield);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);		
		
		parent::display($tpl);			
	}		
	
}