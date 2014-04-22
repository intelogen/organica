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

class JforceViewCustomfield extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'customfield') {
			$this->_displayCustomfield($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}


        $model = &$this->getModel();
		$model->setPublished(0);
		$pagination = JForceHelper::getPagination($model);
		$customfields = $model->listCustomfields();
		
		$this->assignRef('customfields', $customfields);
		$this->assignRef('pagination', $pagination);

        
        parent::display($tpl);		
	}	
	
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();
		
		$js = "window.addEvent('domready', function() {
			$('fieldtype').addEvent('change', function() {
				var type = $('fieldtype').value;
				toggleValueRow();
			});
			
			$('addValue').addEvent('click', function() {
				createValueField();
			});
			
			toggleValueRow();
			
		});";
		
		$document->addScriptDeclaration($js);
			
		// Load the JEditor object
		$editor =& JFactory::getEditor();

		// Initialize variables
        $model = &$this->getModel();
		
		$checked = JRequest::getVar('boxchecked',0);
		
		if($checked != 0):
			$cid = JRequest::getVar('cid', 0);
			$id = $cid[0];
			$model->setId($id);
		endif;
		$model->setPublished(0);
        $customfield = &$model->getCustomfield();
		$lists = $model->buildLists();
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('customfield',	$customfield);
		$this->assignRef('lists',	$lists);	
		
		parent::display($tpl);			
	}		
	
}