<?php 

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			view.raw.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view'); 

class JforceViewReport extends JView {
	
function display($tpl = null) { 
        global $mainframe;
			
		$model =& $this->getModel();
				
		$data = $model->getData();	
		
		$type = JRequest::getVar('type');
		
		$this->assignRef('type',$type);
		$this->assignRef('data',$data);
		
		parent::display($tpl);		
	}
		
}