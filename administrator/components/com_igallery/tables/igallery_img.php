<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class Tableigallery_img extends JTable
{
	
	var $id = null;
	var $description = null;
	var $published = null;
	var $ordering = null;
	var $gallery_id = null;
	var $filename = null;
	var $filesize = null;
	var $lightbox_width = null;
	var $lightbox_height = null;
	var $width = null;
	var $height = null;
	var $link = null;
	var $target_blank = null;
	var $access = null;
	var $thumb_width = null;
	var $thumb_height = null;
	var $lightbox_thumb_width = null;
	var $lightbox_thumb_height = null;
	var $alt_text = null;
	
	
	function Tableigallery_img(& $db) 
	{
		parent::__construct('#__igallery_img', 'id', $db);
	}

}
?>
