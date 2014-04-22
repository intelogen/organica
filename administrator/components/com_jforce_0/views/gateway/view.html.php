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

class JforceViewGateway extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		// Add front-side Models
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');

		$type = JRequest::getVar('type');
		
		$model = &JModel::getInstance('Gateway', 'JForceModel');


		if($layout == 'form') {
			$this->_displayForm($tpl, $model);
			return;
		}
		
		
		
		$pagination = JForceHelper::getPagination($model);
		
		$gateways = $model->listGateways();
		
		$this->assignRef('gateways', $gateways);
		$this->assignRef('pagination', $pagination);
        
        parent::display($tpl);		
	}	
	
	function _displayForm($tpl, $model) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$uri		=& JFactory::getURI();	
		
		$checked = JRequest::getVar('boxchecked',0);
		
		if($checked != 0):
			$cid = JRequest::getVar('cid', 0);
			$id = $cid[0];
			$model->setId($id);
		endif;
		
		$gateway = &$model->getGateway();
		$params = &$model->loadParams();
		$lists = &$model->buildLists();
		// Build the page title string
		$title = JText::_('Edit Gateway');			
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('gateway',	$gateway);	
		$this->assignRef('params',	$params);
		$this->assignRef('lists',	$lists);
		
		parent::display($tpl);			
	}		
	
}