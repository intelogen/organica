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

class JforceViewPlugin extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		// Add front-side Models
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');

		$type = JRequest::getVar('type');
		
		$model = &JModel::getInstance('Plugin', 'JForceModel');


		if($layout == 'form') {
			$this->_displayForm($tpl, $model);
			return;
		}
		
		$model->set('published', 0);
		$pagination = JForceHelper::getPagination($model);
		
		$plugins = $model->listPlugins();
		
		$this->assignRef('plugins', $plugins);
		$this->assignRef('pagination', $pagination);
        
        parent::display($tpl);		
	}	
	
	function _displayForm($tpl, $model) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$uri		=& JFactory::getURI();	
		
		$checked = JRequest::getVar('boxchecked',0);
		
		if($checked != 0):
			$cid = JRequest::getVar('cid', 0);
			$id = $cid[0];
			$model->set('id',$id);
		endif;
		
		$plugin = &$model->getPlugin();
		$params = &$model->loadParams();
		$lists = &$model->buildLists();
		// Build the page title string
		$title = JText::_('Edit Plugin');			
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('plugin',	$plugin);	
		$this->assignRef('params',	$params);
		$this->assignRef('lists',	$lists);
		
		parent::display($tpl);			
	}		
	
}