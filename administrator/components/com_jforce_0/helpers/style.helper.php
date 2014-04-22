<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			style.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
class JforceStyleHelper {
	
	function getStyle() {
		global $mainframe;
		jimport('joomla.filesystem.file');
		
		$doc =& JFactory::getDocument();
		$doc->addStyleSheet('components/com_jforce/css/style.css');
		
		$template = $mainframe->getTemplate();
		
		$path = 'templates/'.$template.'/com_jforce/css/style.css';
		
		if(JFile::exists($path)) {
			$doc->addStyleSheet($path);
		}
	}
	
}