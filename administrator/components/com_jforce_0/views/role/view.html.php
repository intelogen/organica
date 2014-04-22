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

class JforceViewRole extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		// Add front-side Models
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');

		$type = JRequest::getVar('type');
		
		$model = &JModel::getInstance('AccessRole', 'JForceModel');


		if($layout == 'form') {
			$this->_displayForm($tpl, $model);
			return;
		}
		
		
		$roles = $model->listAccessroles();
		
		$this->assignRef('roles', $roles);
		$this->assignRef('type', $type);
        
        parent::display($tpl);		
	}	
	
	
	
	function _displayForm($tpl, $model) {
		global $option, $mainframe;
		jimport('joomla.html.pane');
		$tabs = JPane::getInstance('tabs');

		// Initialize variables
		$document	=& JFactory::getDocument();
		$uri		=& JFactory::getURI();	
		
		$checked = JRequest::getVar('boxchecked',0);
		
		if($checked != 0):
			
			$cid = JRequest::getVar('cid', 0);
			$id = $cid[0];
			$model->setId($id);
		endif;

		
		$role = &$model->getAccessrole();
		$projectroleoptions = $model->buildProjectRoleOptions();
		$systemroleoptions = $model->buildSystemRoleOptions();
		
		// Build the page title string
		$title = $role->id ? JText::_('Edit Role') : JText::_('New Role');			
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('role',	$role);	
		$this->assignRef('type',	$type);
		$this->assignRef('projectroleoptions',	$projectroleoptions);
		$this->assignRef('systemroleoptions',	$systemroleoptions);
		$this->assignRef('type',	$type);
		$this->assignRef('tabs',	$tabs);
		
		parent::display($tpl);			
	}
	
}