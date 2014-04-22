<?php 

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			customfield.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class JforceControllerCustomfield extends JController { 

	function display() {
		// Set a default view if none exists
		if ( ! JRequest::getCmd( 'view' ) ) {
		
		$default = 'customfield'; 
		
			JRequest::setVar('view', $default );
		}
		
		parent::display();	
	}
	
	function save() {
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$post = JRequest::get('post');
		$model =& $this->getModel('customfield');
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
		$model =& $this->getModel('customfield');
		$model->trash($post);

		$msg = JText::_('Item(s) successfully trashed.');
		
		$referer = JRequest::getVar('ret', JURI::base());


		$this->setRedirect($referer, $msg);				
	}

}