<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class Tableigallery extends JTable
{
	var $id = null;
	var $ordering = null;
	var $folder = null;
	var $name = null;
	var $menu_description = null;
	var $gallery_description = null;
	var $gallery_des_position = null;
	var $menu_image_filename = null;
	var $menu_max_height = null;
	var $menu_max_width = null;
	var $menu_access = null;
	var $max_height = null;
	var $max_width = null;
	var $img_container_height = null;
	var $img_container_width = null;
	var $fade = null;
	var $preload = null;
	var $magnify = null;
	var $allow_comments = null;
	var $allow_rating = null;
	var $thumb_width = null;
	var $thumb_height = null;
	var $thumb_position = null;
	var $thumb_container_width = null;
	var $thumb_container_height = null;
	var $images_per_row = null;
	var $thumb_scrollbar = null;
	var $arrows_up_down = null;
	var $arrows_left_right = null;
	var $scroll_speed = null;
	var $scroll_boundary = null;
	var $photo_des_position = null;
	var $photo_des_width = null;
	var $photo_des_height = null;
	var $align = null;
	var $lightbox = null;
	var $lbox_max_width = null;
	var $lbox_max_height = null;
	var $lbox_img_container_height = null;
	var $lbox_img_container_width = null;
	var $lbox_fade = null;
	var $lbox_preload = null;
	var $lbox_allow_comments = null;
	var $lbox_allow_rating = null;
	var $lbox_thumb_width = null;
	var $lbox_thumb_height = null;
	var $lbox_thumb_position = null;
	var $lbox_thumb_container_width = null;
	var $lbox_thumb_container_height = null;
	var $lbox_images_per_row = null;
	var $lbox_thumb_scrollbar = null;
	var $lbox_arrows_up_down = null;
	var $lbox_arrows_left_right = null;
	var $lbox_scroll_speed = null;
	var $lbox_scroll_boundary = null;
	var $lbox_photo_des_position = null;
	var $lbox_photo_des_width = null;
	var $lbox_photo_des_height = null;
	var $scroll_color = null;
	var $handle_color = null;
	var $img_quality = null;
	var $parent = null;
	var $show_cat_menu = null;
	var $cat_menu_columns = null;
	var $access = null;
	var $published = null;
	var $columns = null;
	var $show_large_image = null;
	var $show_thumbs = null;
	var $show_descriptions = null;
	var $lbox_show_thumbs = null;
	var $lbox_show_descriptions = null;
	var $enable_slideshow = null;
	var $show_slideshow_controls = null;
	var $slideshow_autostart = null;
	var $slideshow_pause = null;
	var $lbox_enable_slideshow = null;
	var $lbox_show_slideshow_controls = null;
	var $lbox_slideshow_autostart = null;
	var $lbox_slideshow_pause = null;
	var $crop_thumbs = null;
	var $lbox_crop_thumbs = null;
	var $alias = null;
	var $user = null;
	var $style = null;
	
	function Tableigallery(& $db) 
	{
		parent::__construct('#__igallery', 'id', $db);
	}

}
?>
