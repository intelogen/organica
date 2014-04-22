<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			plugin.helper.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
// Component Helper
jimport('joomla.application.component.helper');


class JForcePluginHelper {

	function loadParams($name) {
		
		$pluginModel = JModel::getInstance('Plugin','JForceModel');
		$plugin = $pluginModel->getPlugin($name);
		
		$params = new JParameter( $plugin->params );
		
		return $params;
	}
}