<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			configuration.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class JforceControllerConfiguration extends JController { 

	function display() {
		// Set a default view if none exists
		if ( ! JRequest::getCmd( 'view' ) ) {
		
		$default = 'configuration'; 
		
			JRequest::setVar('view', $default );
		}
		
		parent::display();	
	}
	
	function save() {
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$post = JRequest::get('post');
		
		if (isset($post['action']) && $post['action'] == 'role') :
			$this->saveRole($post);
			return;
		endif;
		
		if($post['model']):
			$model =& $this->getModel($post['model']);	
		else:
			$model =& $this->getModel('configuration');
		endif;
		
		$model->save($post);

		$msg = JText::_('Item successfully saved.');
		
		$referer = JRequest::getVar('ret', JURI::base());


		$this->setRedirect($referer, $msg);		
	}
	
	function cancel()
	{

		// If the task was cancel, we go back to the item
		$referer = JRequest::getString('ret', JURI::base());

		$this->setRedirect($referer);
	}
	
	function projectRoles() {
		JRequest::setVar('view', 'role');
		JRequest::setVar('type', 'project');
		parent::display();
	}
	
	function systemRoles() {
		JRequest::setVar('view', 'role');
		JRequest::setVar('type', 'system');
		parent::display();
	}
	
	function saveRole($post) {
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');
		$modelName = $post['type'] == 'system' ? 'systemrole' : 'projectrole';
		$model = $this->getModel($modelName);
		$bind = $post['pr'];
		$bind['id'] = $post['id'];
		$bind['name'] = $post['name'];
		
		$model->save($bind);
		
		$type = $post['type'] == 'projectrole' ? 'project' : 'system';
		$url = JRoute::_('index.php?option=com_jforce&view=role&type='.$type);
		$msg = JText::_('Role Successfully Saved');
		$this->setRedirect($url, $msg);
		
	}
	
	function installPlugin() {
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');
		
		$post = JRequest::get('post');
		$files = JRequest::get('files');
		
		$plugin = &JModel::getInstance('Plugin', 'JForceModel');
		$plugin->upload($files, $post);
		
		$return = $_SERVER['HTTP_REFERER'];
		$this->setRedirect($return);
	}
	
	function testInstall() {
		$file1 = JPATH_COMPONENT_ADMINISTRATOR.DS.'tmp'.DS.'paypal.tgz';
		$file2 = JPATH_COMPONENT_ADMINISTRATOR.DS.'tmp'.DS.'paypal.tar';
		$file3 = JPATH_COMPONENT_ADMINISTRATOR.DS.'tmp'.DS.'paypal.zip';
		$file4 = JPATH_COMPONENT_ADMINISTRATOR.DS.'tmp'.DS.'paypal.tbz';
		
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');
		$plugin = &JModel::getInstance('Plugin', 'JForceModel');
		$plugin->set('package', $file3);
		$plugin->install();
	}

}
