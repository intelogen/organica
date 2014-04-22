<?php
/**
* @version		2.1
* @package		Ignite Gallery
* @copyright	Copyright (C) 2009 Matthew Thomson. All rights reserved.
* @license		GNU/GPLv2
*/
defined('_JEXEC') or die('Restricted access');

$controller = JRequest::getWord('controller','igallery');

require_once(JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');

$controllerName = $controller.'Controller';
$controller = new $controllerName();

$controller->execute( JRequest::getCmd('task') );
$controller->redirect(); 
?>