<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			toolbar.jforce.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

defined('_JEXEC') or die();

require_once( $mainframe->getPath( 'toolbar_html' ) ); 
$layout = JRequest::getVar('layout','default');
$view = JRequest::getVar('view');

if ($view == 'configuration' && $layout == 'default') :
	$layout = 'controlPanel';
endif;

switch ( $layout ) { 

	case 'controlPanel':
		menuJforce::controlPanelMenu();
	break;

	case 'form':
		menuJforce::detailMenu();
	break;

	default:
	case 'default':
		menuJforce::defaultMenu();
	break;  

	case 'general':
	case 'categories':
		menuJforce::categoryMenu();
	break;
	
	case 'templates':
	case 'accounting':
		menuJforce::templatesMenu();
	break;

}