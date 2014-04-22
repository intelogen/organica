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

class JforceViewCalendar extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

        $model = &$this->getModel();

	
		$doc =& JFactory::getDocument();
		$doc->addScript('components/com_jforce/js/morph.js');
		$js = " window.addEvent('domready',function() {
					$$('.calendarDay').addEvent('click', function(e) {
						var target = String(e.target);
						if (target.substr(0,4) != 'http') {
							toggleMorph(this);
						}
					});
				});";
				
		$doc->addScriptDeclaration($js);	
		
		$calendar = $model->buildCalendar();
		
		$this->assignRef('calendar', $calendar);

        
        parent::display($tpl);		
	}	
	
	function _displayCalendar($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		
        #$calendar = &$model->getCalendar();
        
		$pathway =& $mainframe->getPathway();
		$pathway->addItem(JText::_('List Calendars'), 'index.php?option=com_jforce&view=calendar');	
		$pathway->addItem(JText::_('Calendar'));	
						

        $this->assignRef('calendar', $calendar);
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
		
        $calendar = &$model->getCalendar();
		
		// Build the page title string
		$title = $Calendar->id ? JText::_('Edit Calendar') : JText::_('New Calendar');			

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');		
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('calendar',	$calendar);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);		
		
		parent::display($tpl);			
	}		
	
}