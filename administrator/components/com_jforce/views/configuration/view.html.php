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

class JforceViewConfiguration extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();
	
		switch($layout):
		
			case 'general':
				$this->_displayGeneral($tpl);
				return;
			break;
			
			case 'templates':
				$this->_displayTemplates($tpl);
				return;
			break;
			
			case 'accounting':
				$this->_displayAccounting($tpl);
				return;
			break;
			
			case 'categories':
				$this->_displayCategories($tpl);
				return;
			break;
			
			case 'access':
				$this->_displayAccess($tpl);
				return;
			break;
			
			case 'form':
				$this->_displayForm($tpl);
				return;
			break;
		
		endswitch;


        $model = &$this->getModel();
		$buttons = $model->listButtons();
		
		$this->assignRef('buttons', $buttons);

        
        parent::display($tpl);		
	}	
	
	function _displayGeneral($tpl) {
	
		$document	=& JFactory::getDocument();
		
		$js = "window.addEvent('domready', function() {
			
			$('addTaxValue').addEvent('click', function() {
				createValueField('tax');										 
			});
					
		});";
		
		$document->addScriptDeclaration($js);
	
		$model =&$this->getModel();
		
		$company = $model->getCompany();
		$lists = $model->buildGeneralLists();
		
		$tax = $model->getConfig('tax',true);
		
		$this->assignRef('company',$company);
		$this->assignRef('lists',$lists);
		$this->assignRef('tax',$tax);
		
		parent::display($tpl);
	}
	
	function _displayCategories($tpl) {
	
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();
		
		$js = "window.addEvent('domready', function() {
			
			$('addSupportValue').addEvent('click', function() {
				createValueField('supportcategories');										 
			});

			$('addDiscussionValue').addEvent('click', function() {
				createValueField('discussioncategories');										 
			});
					
		});";
		
		$document->addScriptDeclaration($js);


		$model =&$this->getModel();
		
		$support = $model->getConfig('supportcategories', true);
		
		$discussion = $model->getConfig('generalcategories', true);
	
		$this->assignRef('support',$support);
		$this->assignRef('discussion',$discussion);
		
		parent::display($tpl);
	}

function _displayTemplates($tpl) {
		// Load the JEditor object
		$editor =& JFactory::getEditor();
	
		$model =&$this->getModel();
		
		$email = $model->getEmailFields();
		
		$quotetemplate = $model->getConfig('quotetemplate');
		$invoicetemplate = $model->getConfig('invoicetemplate');
			
		$this->assignRef('quotetemplate', $quotetemplate);
		$this->assignRef('invoicetemplate', $invoicetemplate);
		$this->assignRef('email',$email);
		$this->assignRef('editor',$editor);
		
		parent::display($tpl);
	}
	
	function _displayAccounting($tpl) {
		// Load the JEditor object
		$editor =& JFactory::getEditor();
	
		$model =&$this->getModel();
		
		$currency = $model->getCurrencies();
		
		$printtemplate = $model->getConfig('printtemplate');
	
		$this->assignRef('currency', $currency);
		$this->assignRef('printtemplate', $printtemplate);
		$this->assignRef('editor',$editor);
		
		parent::display($tpl);
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();
		
		$js = "";
		
		$document->addScriptDeclaration($js);
			
		// Load the JEditor object
		$editor =& JFactory::getEditor();

		// Initialize variables
        $model = &$this->getModel();
		
        $customfield = &$model->getCustomfield();
		$lists = $model->buildLists();
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('customfield',	$customfield);
		$this->assignRef('lists',	$lists);	
		
		parent::display($tpl);			
	}
	
}