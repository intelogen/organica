<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			Phase.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class JforceControllerPhase extends JController {

	function display() {
		// Set a default view if none exists
        JRequest::setVar('view', "phase" );
        /**
		if ( ! JRequest::getCmd( 'view' ) ) {
		
		$default = 'phase'; 
		
			JRequest::setVar('view', $default );
		}
		**/
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

		// Set redirect url to specific comment (if needed)
		if ($post['model'] == 'comment') :
			$referer = $model->getCommentLink($model->_comment);
		endif;
		
		$this->setRedirect($referer, $msg);		
	}
	
	function cancel()
	{
		// If the task was cancel, we go back to the item
		$referer = JRequest::getString('ret', JURI::base());

		$this->setRedirect($referer);
	}
	
	function uploadFiles() {
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$post = JRequest::get('post');
		$files = JRequest::get('files');
		
		$pid = $post['pid'];
		
		$model =& $this->getModel('File');
		$model->uploadFiles($files, $post);

		
		$msg = JText::_('Files Successfully Uploaded');
		$redirect = JRoute::_('index.php?option=com_jforce&view=document&pid='.$pid);

		$this->setRedirect($redirect, $msg);
	}
	
	function downloadFile() {
		$model =& $this->getModel('File');
		$model->downloadFile();
	}
	
	function ical() {
		$model=& $this->getModel('Phase');
		$model->ical();
	}
	
	function trash() {
		JRequest::checkToken() or jexit('Invalid Token');
			
		$post = JRequest::get('post');
		
		JForceHelper::trashItem($post);
		
		$msg = JText::_('Item Successfully Trashed');
		$referer = $post['ret'];
		
		$this->setRedirect($referer,$msg);
			
	}

}