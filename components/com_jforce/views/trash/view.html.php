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

class JforceViewTrash extends JView {
	
function display($tpl = null) {
        global $mainframe;
		
		$layout = $this->getLayout();
        $model = &$this->getModel();
		
		$trash = $model->listTrash();
		
		$this->assignRef('trash', $trash);
        
        parent::display($tpl);		
	}	
	
}