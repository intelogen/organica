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

class JforceViewFile extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'file') {
			$this->_displayFile($tpl);
			return;	
		}

		if($layout == 'upload') {
			$this->_displayForm($tpl);
			return;
		}
		
		if($layout == 'version') {
			$this->_displayVersionForm($tpl);
			return;
		}

		$pid = &JRequest::getVar('pid');
        $model = &$this->getModel();
		
		$files = $model->listFiles();

		$categoryList = $model->getFilter();	
		
		$newFileLink = "<a href='".JRoute::_('index.php?option=com_jforce&view=file&layout=upload&pid='.$pid)."'>".JText::_('New File')."</a>";
		
		$this->assignRef('files', $files);
		$this->assignRef('categoryList',$categoryList);
		$this->assignRef('newFileLink', $newFileLink);

        
        parent::display($tpl);		
	}	
	
	function _displayFile($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		
        $file = &$model->getFile();
        
		$pathway =& $mainframe->getPathway();
		$pathway->addItem(JText::_('List Files'), 'index.php?option=com_jforce&view=file');	
		$pathway->addItem(JText::_('File'));	

        $this->assignRef('file', $file);
        $this->assignRef('option', $option);

		parent::display($tpl);		
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$uri		=& JFactory::getURI();	
			
		$pid = JRequest::getVar('pid');
		$milestone = JRequest::getVar('milestone', '');
		
		// Initialize variables
        $model = &$this->getModel();
		
        $file = &$model->getFile();
		
		$docModel = &JModel::getInstance('Document', 'JforceModel');
		$docModel->setId(null);
		$docModel->setMilestone($milestone);
		$docModel->getDocument();
		
		$lists = $docModel->buildLists();
		
		// Build the page title string
		$title = JText::_('Upload Files');				
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('pid',   $pid);
		$this->assignRef('title',   $title);
		$this->assignRef('lists',   $lists);
		
		parent::display($tpl);			
	}
	
	function _displayVersionForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$uri		=& JFactory::getURI();	
			
		$pid = JRequest::getVar('pid');
		$document = JRequest::getVar('document');
		// Initialize variables
        $model = &$this->getModel();
		
		// Build the page title string
		$title = JText::_('Upload a New Version');				
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('pid',   $pid);
		$this->assignRef('title',   $title);
		$this->assignRef('document',   $document);
		
		parent::display($tpl);			
	}
	
}