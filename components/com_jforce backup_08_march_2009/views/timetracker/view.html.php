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

class JforceViewTimetracker extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'timetracker') {
			$this->_displayTimetracker($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}

		$pid = JRequest::getVar('pid');
		$newTimetrackerLink = JRoute::_('index.php?option=com_jforce&view=timetracker&layout=form&pid='.$pid);
		
		$document =& JFactory::getDocument();
		$js = "window.addEvent('domready', function() {
				$$('img.billabletime').addEvent('click',function() {
					toggleBillable(this.id);											  
				});
													
				});";
		
		$document->addScriptDeclaration($js);
		
        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		$timetrackers = $model->listTimetrackers();
		
		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$timetrackers):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;

		$this->assignRef('startupText',$startupText);
		$this->assignRef('timetrackers', $timetrackers);
		$this->assignRef('newTimetrackerLink',$newTimetrackerLink);
		$this->assignRef('pagination',$pagination);
        
        parent::display($tpl);		
	}	
	
	function _displayTimetracker($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		
        $timetracker = &$model->getTimetracker();
        
		$pathway =& $mainframe->getPathway();
		$pathway->addItem(JText::_('List Timetrackers'), 'index.php?option=com_jforce&view=timetracker');	
		$pathway->addItem(JText::_('Timetracker'));	

        $this->assignRef('timetracker', $timetracker);
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
				
        $timetracker = &$model->getTimetracker();

		$lists = $model->buildLists();

		// Build the page title string
		$title = $timetracker->id ? JText::_('Edit Timetracker') : JText::_('New Timetracker');			

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');		
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assignRef('lists',$lists);
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('timetracker',	$timetracker);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);		
		
		parent::display($tpl);			
	}		
	
}