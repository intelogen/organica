<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			message.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class JforceControllerMessage extends JController {

	function display() {
		// Set a default view if none exists
		if ( ! JRequest::getCmd( 'view' ) ) {
		
		$default = 'project'; 
		
			JRequest::setVar('view', $default );
		}
		
		parent::display();	
	}	
	
	
	
	function save() {
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$post = JRequest::get('post');
		
		$model =& $this->getModel($post['model']);
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
	
	
	function trash() {
		JRequest::checkToken() or jexit('Invalid Token');
			
		$post = JRequest::get('post');
		
		JForceHelper::trashItem($post);
		
		$msg = JText::_('Item Successfully Trashed');
		$referer = JRequest::getVar('ret', JURI::base());
		
		$this->setRedirect($referer,$msg);
			
	}

}