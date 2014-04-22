<?php
/**
 * Health Report for Joomla! 1.5
 * @author Alexander Barannikov
 * @copyright 2010 Seanetix Company
 */

defined('_JEXEC') or die('Access denied.');

require_once JPATH_COMPONENT.DS.'controller.php';

if($controller = JRequest::getWord('c')) {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if (file_exists($path)) {
        require_once $path;
    } else {
        $controller = '';
    }
}

$classname    = 'HReportController'.$controller;
$controller   = new $classname( );

$controller->execute( JRequest::getWord( 'task' ) );

$controller->redirect();
?>