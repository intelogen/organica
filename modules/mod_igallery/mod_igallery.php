<?php
defined('_JEXEC') or die('Restricted access');

$galleryId = $params->get('gallery_id', 1);

require_once(JPATH_SITE.DS.'components'.DS.'com_igallery'.DS.'includes'.DS.'write_gallery.php');
$moduleHtml = writeGallery('module',$galleryId);
echo $moduleHtml;	
