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

class JforceViewDocument extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'document') {
			$this->_displayDocument($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}
		
		if($layout == 'version') {
			$this->_displayVersionForm($tpl);
			return;
		}

		$pid = &JRequest::getVar('pid');
        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		
		$documents = $model->listDocuments();

		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$documents):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;


		$categoryList = $model->getFilter();
		
		$newFileLink = "<a href='".JRoute::_('index.php?option=com_jforce&view=file&layout=upload&pid='.$pid)."' class='button'>".JText::_('Upload File')."</a>";
		
		$this->assignRef('startupText',$startupText);
		$this->assignRef('categoryList',$categoryList);
		$this->assignRef('documents', $documents);
		$this->assignRef('newFileLink', $newFileLink);
		$this->assignRef('pagination', $pagination);

        
        parent::display($tpl);		
	}	
	
	function _displayDocument($tpl) {
        global $mainframe, $option;
		$pid = JRequest::getVar('pid');
        $model = &$this->getModel();
		$user = &JFactory::getUser();
        $document = &$model->getDocument();
		$doc = &JFactory::getDocument();
		$js = "window.addEvent('domready',function() {

			$('subscribeLink').addEvent('click',function(e) {
					e = new Event(e);
					subscribeMe('".$document->id."','document', '".$document->pid."');
					e.stop();										
				});
				$('remindLink').addEvent('click',function(e) {
						e = new Event(e);
						remindPeople('".$document->id."','document');
						e.stop();										
					});
						
			   });";
		
		$doc->addScriptDeclaration($js);
		
		$versions =&$model->getAllVersions($document->file->version);
		
		$comments = JForceHelper::loadComments('document', $document);
		
		$tabMenu = JForceTabHelper::getTabMenu($document);
		
		$this->assignRef('tabMenu',$tabMenu);
		$this->assignRef('trashLink',$trashLink);
		$this->assignRef('versions',$versions);
        $this->assignRef('document', $document);
        $this->assignRef('option', $option);
		$this->assignRef('comments', $comments);
		$this->assignRef('subscribeText', $subscribeText);

		parent::display($tpl);		
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
		$privateAccess = $user->systemrole->can_see_private_objects;
		// Load the JEditor object
		$editor =& JFactory::getEditor();

		// Initialize variables
        $model = &$this->getModel();
		JForceHelper::initValidation($model->_required);
		
        $document = &$model->getDocument();
		
		$lists = $model->buildLists();
		
		JHTML::_('behavior.modal', 'a.modal');
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('document');
		$subscriptionFields = $subscriptionModel->buildSubscriptionFields();
		
		$subscriptionLink = 'index.php?tmpl=component&option=com_jforce&view=modal&action=file&pid='.$document->pid;
		if ($document->id) $subscriptionLink .= '&id='.$document->id;
		
		// Build the page title string
		$title = $document->id ? JText::_('Edit File') : JText::_('New File');			
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('file',	$document);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);	
		$this->assignRef('lists',	$lists);	
		$this->assignRef('subscriptionLink',	$subscriptionLink);	
		$this->assignRef('subscriptionFields',	$subscriptionFields);
		$this->assignRef('privateAccess',	$privateAccess);
		
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