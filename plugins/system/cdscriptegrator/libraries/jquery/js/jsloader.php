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

define('DS', DIRECTORY_SEPARATOR);
$dir = dirname(__FILE__);

$filename = array();
$filename []= $dir . DS . 'jquery-latest.packed.js';
$filename []= $dir . DS . 'jquery-noconflict.js';

	
header ("content-type: text/javascript; charset: UTF-8");
header('Cache-Control: must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');

foreach ($filename as $file) {
	if (file_exists($file)) {
		include($file);
		echo "\n";
	}
}

?>
