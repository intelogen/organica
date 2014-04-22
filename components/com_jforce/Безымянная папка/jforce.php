<?php

/**********************************************************************************
*	@package		Joomla														  *
*	@subpackage		jForce, the Joomla! CRM										  *
*	@version		2.0															  *
*	@file			jforce.php													  *
*	@updated		2008-12-15													  *
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.*
*	@license		GNU/GPL, see jforce.license.php								  *
**********************************************************************************/
 
// no direct access
defined('_JEXEC') or die('Restricted access');

// Set the table directory
JTable::addIncludePath( JPATH_COMPONENT_ADMINISTRATOR.DS.'com_jforce'.DS.'tables');

//Add helpers

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'style.helper.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'jforce.helper.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'lists.helper.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'icon.helper.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'pathway.helper.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'startup.helper.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'plugin.helper.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'menu.helper.php');


// нужно розкоментить
//require_once(JPATH_COMPONENT.DS.'controllers'.DS.'access.php');


// Impose Access Restrictions
$controllerName = JRequest::getCmd( 'c', 'project' );


// check for jtpl hack
$viewname = JRequest::getCmd("view");




if($viewname == "phase"){
    $controllerName = "phase";
}

$controllerFile = JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php';


if (file_exists($controllerFile)) :
	require_once($controllerFile);
else :
	JForceHelper::lockOut();
endif;
	

// нужно розкоментить
//$accessHelper = new JForceControllerAccess();
//$accessHelper->checkAccess();

$format = JRequest::getVar('format');

if ($format != 'raw') :
	JforceStyleHelper::getStyle();
	JHTML::_('behavior.mootools');
	JHTML::_('behavior.tooltip');
	
	#JForcePathwayHelper::getPathway();

	$doc =& JFactory::getDocument();
	$doc->addScript('components/com_jforce/js/jforce.js');

//Add Customized TinyMCE Editor
	$doc->addScript(JURI::base().'/plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js');

	$js = "initializeTinyMCE();";
	$doc->addScriptDeclaration($js);
	
endif;
	
	
	$controllerName = 'JforceController'.ucfirst($controllerName);

	// Create the controller
	$controller = new $controllerName();
	
	
	// Initialize Plugins
	$plugins = &JModel::getInstance('Plugin', 'JForceModel');
	$plugins->initialize();

	// Perform the Request task
	$controller->execute( JRequest::getCmd('task') );

	// Redirect if set by the controller
	$controller->redirect();