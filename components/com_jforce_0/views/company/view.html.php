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

class JforceViewCompany extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'company') {
			$this->_displayCompany($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}


        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		$companies = $model->listCompanies();
		
		$this->assignRef('companies', $companies);
		$this->assignRef('pagination',$pagination);
        
        parent::display($tpl);		
	}	
	
	function _displayCompany($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		
        $company = &$model->getCompany();
        
		if($company->homepage):
			$company->homepage = '<a href='.$company->homepage.' />'.$company->homepage.'</a>';
		endif;

		$tabMenu = JForceTabHelper::getTabMenu($company, false, false);
		
		$this->assignRef('tabMenu',$tabMenu);
		$this->assignRef('company', $company);
        $this->assignRef('option', $option);

		parent::display($tpl);		
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
			
		// Load the JEditor object
		$editor =& JFactory::getEditor();
		
		$js = "window.addEvent('domready', function() {
			if ($('removeLink')) {
				$('removeLink').addEvent('click', function() {
					removeIcon('company');										   
				});
			}
		});";
		$document->addScriptDeclaration($js);

		// Initialize variables
        $model = &$this->getModel();
		JForceHelper::initValidation($model->_required);
        $company = &$model->getCompany();
		
		// Create Modal Link for Profile Picture
		$company->uploadProfileUrl = JRoute::_('index.php?option=com_jforce&c=people&view=modal&layout=profilepic&id='.$company->id.'&tmpl=component&model=company');
		
		$lists = &$model->buildLists();
		
		// Build the page title string
		$title = $company->id ? JText::_('Edit Company') : JText::_('New Company');			

		JHTML::_('behavior.modal', 'a.modal');		
		
		$this->assignRef('lists', $lists);
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('company',	$company);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);		
		
		parent::display($tpl);			
	}		
	
}