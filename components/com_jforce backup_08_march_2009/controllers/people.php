<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			people.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class JforceControllerPeople extends JController {

	function display() {
		// Set a default view if none exists
		if ( ! JRequest::getCmd( 'view' ) ) {
		
		$default = 'company'; 
		
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
	
	function cancel()
	{

		// If the task was cancel, we go back to the item
		$referer = JRequest::getString('ret', JURI::base());

		$this->setRedirect($referer);
	}	
	
	function convertLead()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$post = JRequest::get('post');
		$stage = $post['stage'];
		$model =& $this->getModel($post['model']);
		
		$function = 'convertLead'.$stage;
		$return = $model->$function($post);
		
		$link = 'index.php?option=com_jforce&view=modal&layout=wizard'.($stage+1).'&tmpl=component';
		
		if ($post['id']) :
			$link .= '&id='.$post['id'];
		endif;
		
		if($post['person']):
			$link .= '&person='.$post['person'];
		endif;
		
		if($post['pid']):
			$link .= '&pid='.$post['pid'];
		endif;
		
		if ($stage == '3') :
			$link .= '&pid='.$return;
		endif;
		
		$redirect = JRoute::_($link);
		
		$this->setRedirect($redirect);
	}
	
	function convertLeadFinal()
	{
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$projectroleModel = &JModel::getInstance('Projectrole', 'JForceModel');
		$data = JRequest::get('post');
		$data['selectedUsers'] = array($data['id']);
		unset($data['id']);
		$projectroleModel->addPeopletoProject($data);
		
		$doc = JFactory::getDocument();
		$redirect = JRoute::_('index.php?option=com_jforce&view=project&layout=project&pid='.$data['pid']);
	
		$js = "window.addEvent('domready', function() {
					window.parent.location = '".$redirect."';
					closeModal();
				});
				";
		$doc->addscriptDeclaration($js);
	}
	
	function uploadProfilePic() {
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$post = JRequest::get('post');
		$files = JRequest::get('files');
		
		$modelType = $post['model'];
		
		$fileModel =& $this->getModel('File');
		
		$newIcon = $fileModel->uploadIcon($files,$post, $modelType);
		
		JForceIconHelper::updateIcon($modelType, $newIcon);
		
		$doc = JFactory::getDocument();
		$js = "window.addEvent('domready', function() {
				closeModal();
				updateIcon('".$modelType."');
			});";
		$doc->addscriptDeclaration($js);
				
	}
	
	function addPeople() {
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$post = JRequest::get('post');
		
		if (isset($post['selectedUsers'])) :
			$model = &JModel::getInstance('Accessrole', 'JForceModel');
			$model->addPeopletoProject($post);
		endif;
		
		$url = JRoute::_('index.php?option=com_jforce&view=person&pid='.$post['pid']);
		
		$document = &JFactory::getDocument();
		$js = "window.addEvent('domready', function() {
			window.parent.$('sbox-window').close();
			window.parent.location = '".$url."';
		});";
		$document->addScriptDeclaration($js);
		
	}
	
	function saveProjectPermissions() {
		
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$post = JRequest::get('post');
		
		$model = &JModel::getInstance('Accessrole', 'JForceModel');
		$model->saveUserProjectRole($post['pr'], $post['uid'], $post['pid']);
		
		$document = &JFactory::getDocument();
		$js = "window.addEvent('domready', function() {
			window.parent.$('sbox-window').close();
		});";
		$document->addScriptDeclaration($js);
	}
	
	function deletePermissions() {
		JRequest::checkToken() or jexit( 'Invalid Token' );
		$post = JRequest::get('post');
		$model = &JModel::getInstance('Projectrole', 'JForceModel');
		$id = $model->getRoleId($post['id'], $post['pid']);
		$model->_destroyRole($id, $post['pid']);
		
		$url = JRoute::_('index.php?option=com_jforce&view=person&pid='.$post['pid']);
		$msg = JText::_('User Successfully Removed from Project');
		$this->setRedirect($url, $msg);
	}
	
	
}