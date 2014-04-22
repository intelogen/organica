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

class JforceViewDashboard extends JView {
	
function display($tpl = null) {
        global $mainframe, $option;
		
		$user = &JFactory::getUser();
		$model = &$this->getModel();
		$document =& JFactory::getDocument();
		
		$dashboard = &$model->getDashboard();	

		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$dashboard):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;

		$this->assignRef('startupText',$startupText);
        $this->assignRef('dashboard', $dashboard);
        $this->assignRef('option', $option);
		
		parent::display($tpl);		
	
	}	
	
}