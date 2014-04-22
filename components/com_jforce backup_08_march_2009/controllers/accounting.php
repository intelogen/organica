<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			accounting.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class JforceControllerAccounting extends JController {

	function display() {
		// Set a default view if none exists
		if ( ! JRequest::getCmd( 'view' ) ) {
		
		$default = 'quote'; 
		
			JRequest::setVar('view', $default );
		}
		
		parent::display();	
	}	
	
	/**
	 * Call the Save Function
	 * Model determined by Array value
	 * @return 
	 */
	
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
	
	function quoteAction() {
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$post = JRequest::get('post');
		$model =& $this->getModel($post['model']);
		$model->quoteAction($post);
		
		$referer = $_SERVER['HTTP_REFERER'];
		$msg = $post['accept'] == '1' ? JText::_('Quote Accepted') : JText::_('Quote Denied');

		$this->setRedirect($referer, $msg);		
	}
	
	function processPayment() {
		
		$post = JRequest::get('post');
		$model = $this->getModel('Invoice');
		$invoice = $model->getInvoice();
		$response = $model->processPayment($post);
	
		$url = JRoute::_('index.php?option=com_jforce&c=accounting&view=invoice&layout=invoice&pid='.$invoice->pid.'&id='.$invoice->id);
		
		$this->setRedirect($url, $response[1]);
	
	}
	
	function cancel()
	{

		// If the task was cancel, we go back to the item
		$referer = JRequest::getString('ret', JURI::base());

		$this->setRedirect($referer);
	}	

	
	function copyObject() {
		$m = JRequest::getVar('view','');
		$model =& $this->getModel($m);
		$function = 'copy'.ucwords($m);
		$item = $model->$function();
		$url = JRoute::_('index.php?option=com_jforce&c=accounting&view='.$m.'&layout=form&pid='.$item->pid.'&id='.$item->id);
		$this->setRedirect($url);
	}

}