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

class JforceViewReport extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'report') {
			$this->_displayReport($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}

        $model = &$this->getModel();
		
		$reports = $model->listReports();
		
		$this->assignRef('reports', $reports);

        
        parent::display($tpl);		
	}	
	
	function _displayReport($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		
		$type = JRequest::getVar('type','column');
		$id = JRequest::getVar('id');
				
		$xmlPath = 'index.php?option=com_jforce&format=raw&view=report&layout=chart&type='.$type.'&id='.$id;
		$xmlPath = urlencode($xmlPath);
		$chartPath = 'components'.DS.'com_jforce'.DS.'lib'.DS.'charts'.DS.'charts_library&xml_source='.$xmlPath;

		$graphTypes = array('bar','column','pie','line');
		$graphLinks = array();
		for($i=0;$i<count($graphTypes);$i++):
			$graphType = $graphTypes[$i];
			$graphLinks[$i]['name'] = JText::_(ucwords($graphType));
			$graphLinks[$i]['link'] = JRoute::_('index.php?option=com_jforce&view=report&layout=report&type='.$graphType.'&id='.$id);
		endfor;
		
		$pathway =& $mainframe->getPathway();
		$pathway->addItem(JText::_('List Reports'), 'index.php?option=com_jforce&view=report');	
		$pathway->addItem(JText::_('Report'));	

		$report = $model->getReport();
		$this->assignRef('report', $report);

		$this->assignRef('graphLinks',$graphLinks);
		$this->assignRef('chartPath',$chartPath);
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
		
        $report = &$model->getReport();
		
		// Build the page title string
		$title = $report->id ? JText::_('Edit Report') : JText::_('New Report');			

		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');		
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('report',	$report);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);		
		
		parent::display($tpl);			
	}		
	
}