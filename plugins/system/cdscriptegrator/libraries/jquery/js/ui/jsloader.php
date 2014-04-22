<?php
/**
 * Core Design Scriptegrator plugin for Joomla! 1.5
 */

$compress = (string)$_GET['compress'];
switch ($compress) {
	case '0':
	default:
		break;
	case '1':
		if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) {
			@ob_start('ob_gzhandler');
		}
		break;
}

if (isset($_GET['file'])) {
	$file = (string )$_GET['file'];
} else {
	die();
}

$ui_files = array();
$ui_files []= 'effects.blind';
$ui_files []= 'effects.bounce';
$ui_files []= 'effects.clip';
$ui_files []= 'effects.core';
$ui_files []= 'effects.drop';
$ui_files []= 'effects.explode';
$ui_files []= 'effects.fold';
$ui_files []= 'effects.highlight';
$ui_files []= 'effects.pulsate';
$ui_files []= 'effects.scale';
$ui_files []= 'effects.shake';
$ui_files []= 'effects.slide';
$ui_files []= 'effects.transfer';
$ui_files []= 'ui.accordion';
$ui_files []= 'ui.core';
$ui_files []= 'ui.datepicker';
$ui_files []= 'ui.dialog';
$ui_files []= 'ui.draggable';
$ui_files []= 'ui.droppable';
$ui_files []= 'ui.resizable';
$ui_files []= 'ui.selectable';
$ui_files []= 'ui.slider';
$ui_files []= 'ui.sortable';
$ui_files []= 'ui.tabs';

define('DS', DIRECTORY_SEPARATOR);
$dir = dirname(__FILE__);

$filepath = $dir . DS . $file . '.js';

header ("content-type: text/javascript; charset: UTF-8");
header('Cache-Control: must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');

if (in_array($file, $ui_files) and file_exists($filepath)) include($filepath);

?>