<?php
/**
* @version		2.1
* @package		Ignite Gallery
* @copyright	Copyright (C) 2009 Matthew Thomson. All rights reserved.
* @license		GNU/GPLv2
*/
defined('_JEXEC') or die('Restricted access');

//get the controller from the get/post, if none is there, 'igallery' will be used
$controller = JRequest::getWord('controller','igallery');

//get the controller file
require_once(JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');

//the name of the controller class in there will be the name of the file (without the .php) + 'Controller'
$controllerName = $controller.'Controller';

//instianate the class
$controller = new $controllerName();

//execute the task in the get/post, if there is no task, display task will be done
$controller->execute( JRequest::getCmd('task') );
$controller->redirect(); 
?>
