<?php
/**
 * Core Design Scriptegrator plugin for Joomla! 1.5
 */

switch ((string)$_GET['compress']) {
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

$ui_css = array();
$ui_css []= 'ui.accordion';
$ui_css []= 'ui.all';
$ui_css []= 'ui.base';
$ui_css []= 'ui.core';
$ui_css []= 'ui.datepicker';
$ui_css []= 'ui.dialog';
$ui_css []= 'ui.progressbar';
$ui_css []= 'ui.resizable';
$ui_css []= 'ui.slider';
$ui_css []= 'ui.tabs';
$ui_css []= 'ui.theme';

define('DS', DIRECTORY_SEPARATOR);
$dir = dirname(__FILE__);

$filepath = $dir . DS . $file . '.css';

header('Content-type: text/css; charset: UTF-8');
header('Cache-Control: must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');

if (in_array($file, $ui_css) and file_exists($filepath)) include($filepath);

?>
