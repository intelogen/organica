<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class igalleryVIEWbase extends JView
{
		//this function is called in the view.html.php of the add gallery views (front end and back end)
		//it returns the html for the new gallery form elements
		function getNewFormElements()
		{
			$lists = array();
			
			$configArray =& JComponentHelper::getParams('com_igallery');
			$configParams = array();
			
			//general tab
			$db =& JFactory::getDBO();
			$query = 'SELECT id AS value, name AS text FROM #__groups ORDER BY id';
			$db->setQuery($query);
			$groups = $db->loadObjectList();
			$lists['gallery_access'] = JHTML::_('select.genericlist', $groups, 'access', 'class="inputbox" size="3"', 'value', 'text', 0, '', 1 );
			
			$configParams['img_quality'] = $configArray->get('img_quality', 80);
			
			$configParams['published'] = $configArray->get('published', 0);
			$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $configParams['published'] );
			
			//category tab
			$configParams['menu_max_width'] = $configArray->get('menu_max_width', 200);
			
			$configParams['menu_max_height'] = $configArray->get('menu_max_height', 150);
			
			$db =& JFactory::getDBO();
			$query = 'SELECT id AS value, name AS text FROM #__groups ORDER BY id';
			$db->setQuery($query);
			$groups = $db->loadObjectList();
			$lists['menu_access'] = JHTML::_('select.genericlist', $groups, 'menu_access', 'class="inputbox" size="3"', 'value', 'text', 0, '', 1 );
			
			//main image tab
			$configParams['show_large_image'] = $configArray->get('show_large_image', 1);
			$lists['show_large_image'] = JHTML::_('select.booleanlist',  'show_large_image', 'class="inputbox"', $configParams['show_large_image'] );
			
			$configParams['max_width'] = $configArray->get('max_width', 600);
			
			$configParams['max_height'] = $configArray->get('max_height', 400);
			
			$configParams['img_container_width'] = $configArray->get('img_container_width', 0);
			
			$configParams['img_container_height'] = $configArray->get('img_container_height', 0);
			
			$configParams['fade'] = $configArray->get('fade', 1);
			$lists['fade'] = JHTML::_('select.booleanlist',  'fade', 'class="inputbox"', $configParams['fade'] );
			
			$configParams['preload'] = $configArray->get('preload', 1);
			$lists['preload'] = JHTML::_('select.booleanlist',  'preload', 'class="inputbox"', $configParams['preload'] );
			
			$configParams['magnify'] = $configArray->get('magnify', 1);
			$lists['magnify'] = JHTML::_('select.booleanlist',  'magnify', 'class="inputbox"', $configParams['magnify'] );
			
			//thumbnail tab
			$configParams['show_thumbs'] = $configArray->get('show_thumbs', 1);
			$lists['show_thumbs'] = JHTML::_('select.booleanlist',  'show_thumbs', 'class="inputbox"', $configParams['show_thumbs'] );
			
			$configParams['thumb_width'] = $configArray->get('thumb_width', 90);
			
			$configParams['thumb_height'] = $configArray->get('thumb_height', 90);
			
			$configParams['crop_thumbs'] = $configArray->get('crop_thumbs', 1);
			$lists['crop_thumbs'] = JHTML::_('select.booleanlist',  'crop_thumbs', 'class="inputbox"', $configParams['crop_thumbs'] );
			
			$configParams['thumb_position'] = $configArray->get('thumb_position', 'below');
			$thumb_position = array();
			$thumb_position[] = JHTML::_( 'select.option', 'left', JText::_( 'LEFT' ) );
			$thumb_position[] = JHTML::_( 'select.option', 'below', JText::_( 'BELOW' ) );
			$thumb_position[] = JHTML::_( 'select.option', 'right', JText::_( 'RIGHT' ) );
			$thumb_position[] = JHTML::_( 'select.option', 'above', JText::_( 'ABOVE' ) );
			$lists['thumb_position'] = JHTML::_('select.radiolist', $thumb_position, 'thumb_position', 'class="inputbox" ', 'value', 'text', $configParams['thumb_position'], 'thumb_position' );
			
			$configParams['thumb_container_width'] = $configArray->get('thumb_container_width', 200);
			
			$configParams['thumb_container_height'] = $configArray->get('thumb_container_height', 0);
			
			$configParams['images_per_row'] = $configArray->get('images_per_row', 0);
			
			$configParams['thumb_scrollbar'] = $configArray->get('thumb_scrollbar', 0);
			$lists['thumb_scrollbar'] = JHTML::_('select.booleanlist',  'thumb_scrollbar', 'class="inputbox"', $configParams['thumb_scrollbar'] );
			
			$configParams['arrows_up_down'] = $configArray->get('arrows_up_down', 0);
			$lists['arrows_up_down'] = JHTML::_('select.booleanlist',  'arrows_up_down', 'class="inputbox"', $configParams['arrows_up_down'] );
			
			$configParams['arrows_left_right'] = $configArray->get('arrows_left_right', 1);
			$lists['arrows_left_right'] = JHTML::_('select.booleanlist',  'arrows_left_right', 'class="inputbox"', $configParams['arrows_left_right'] );
			
			$configParams['scroll_speed'] = $configArray->get('scroll_speed', .07);
			
			$configParams['scroll_boundary'] = $configArray->get('scroll_boundary', 150);
			
			//other tab
			$configParams['show_cat_menu'] = $configArray->get('show_cat_menu', 0);
			$lists['show_cat_menu'] = JHTML::_('select.booleanlist',  'show_cat_menu', 'class="inputbox"', $configParams['show_cat_menu'] );
			
			$configParams['cat_menu_columns'] = $configArray->get('cat_menu_columns', 2);
			
			$configParams['gallery_des_position'] = $configArray->get('gallery_des_position', 'above');
			$gallery_des_position = array();
			$gallery_des_position[] = JHTML::_( 'select.option', 'above', JText::_( 'ABOVE' ) );
			$gallery_des_position[] = JHTML::_( 'select.option', 'below', JText::_( 'BELOW' ) );
			$lists['gallery_des_position'] = JHTML::_('select.radiolist', $gallery_des_position, 'gallery_des_position', 'class="inputbox" ', 'value', 'text', $configParams['gallery_des_position'], 'gallery_des_position' );
			
			$configParams['allow_comments'] = $configArray->get('allow_comments', 0);
			$lists['allow_comments'] = JHTML::_('select.booleanlist',  'allow_comments', 'class="inputbox"', $configParams['allow_comments'] );
			
			$configParams['allow_rating'] = $configArray->get('allow_rating', 0);
			$lists['allow_rating'] = JHTML::_('select.booleanlist',  'allow_rating', 'class="inputbox"', $configParams['allow_rating'] );
			
			$configParams['photo_des_position'] = $configArray->get('photo_des_position', 'below');
			$photo_des_position = array();
			$photo_des_position[] = JHTML::_( 'select.option', 'left', JText::_( 'LEFT' ) );
			$photo_des_position[] = JHTML::_( 'select.option', 'below', JText::_( 'BELOW' ) );
			$photo_des_position[] = JHTML::_( 'select.option', 'right', JText::_( 'RIGHT' ) );
			$photo_des_position[] = JHTML::_( 'select.option', 'above', JText::_( 'ABOVE' ) );
			$lists['photo_des_position'] = JHTML::_('select.radiolist', $photo_des_position, 'photo_des_position', 'class="inputbox" ', 'value', 'text', $configParams['photo_des_position'], 'photo_des_position' );
			
			
			$styles = array();
			$styles['plain'] = JHTML::_( 'select.option', 'plain', JText::_( 'PLAIN' ) );
			$styles['grey-border-shadow'] = JHTML::_( 'select.option', 'grey-border-shadow', JText::_( 'GREY BORDER SHADOW' ) );
			$lists['style'] = JHTML::_('select.genericlist', $styles, 'style', 'class="inputbox" size="2"', 'value', 'text', $configArray->get('style', 'plain'), '', 1 );
			
			$configParams['enable_slideshow'] = $configArray->get('enable_slideshow', 0);
			$lists['enable_slideshow'] = JHTML::_('select.booleanlist',  'enable_slideshow', 'class="inputbox"', $configParams['enable_slideshow'] );
			
			$configParams['show_slideshow_controls'] = $configArray->get('show_slideshow_controls', 0);
			$lists['show_slideshow_controls'] = JHTML::_('select.booleanlist',  'show_slideshow_controls', 'class="inputbox"', $configParams['show_slideshow_controls'] );
			
			$configParams['slideshow_autostart'] = $configArray->get('slideshow_autostart', 0);
			$lists['slideshow_autostart'] = JHTML::_('select.booleanlist',  'slideshow_autostart', 'class="inputbox"', $configParams['slideshow_autostart'] );
			
			$configParams['slideshow_pause'] = $configArray->get('slideshow_pause', 3000);
			
			$configParams['show_descriptions'] = $configArray->get('show_descriptions', 1);
			$lists['show_descriptions'] = JHTML::_('select.booleanlist',  'show_descriptions', 'class="inputbox"', $configParams['show_descriptions'] );
			
			$configParams['align'] = $configArray->get('align', 'left');
			$align = array();
			$align[] = JHTML::_( 'select.option', 'left', JText::_( 'LEFT' ) );
			$align[] = JHTML::_( 'select.option', 'center', JText::_( 'CENTER' ) );
			$align[] = JHTML::_( 'select.option', 'right', JText::_( 'RIGHT' ) );
			$lists['align'] = JHTML::_('select.radiolist', $align, 'align', 'class="inputbox" ', 'value', 
			'text', $configParams['align'], 'align' );
			
			$configParams['photo_des_width'] = $configArray->get('photo_des_width', 200);
			
			$configParams['photo_des_height'] = $configArray->get('photo_des_height', 40);
			
			
			//lightbox tab
			$configParams['lightbox'] = $configArray->get('lightbox', 1);
			$lists['lightbox'] = JHTML::_('select.booleanlist',  'lightbox', 'class="inputbox"', $configParams['lightbox'] );
			
			$configParams['lbox_max_width'] = $configArray->get('lbox_max_width', 800);
			
			$configParams['lbox_max_height'] = $configArray->get('lbox_max_height', 600);
			
			$configParams['lbox_img_container_width'] = $configArray->get('lbox_img_container_width', 0);
			
			$configParams['lbox_img_container_height'] = $configArray->get('lbox_img_container_height', 0);
			
			$configParams['lbox_fade'] = $configArray->get('lbox_fade', 1);
			$lists['lbox_fade'] = JHTML::_('select.booleanlist',  'lbox_fade', 'class="inputbox"', $configParams['lbox_fade'] );
			
			$configParams['lbox_preload'] = $configArray->get('lbox_preload', 1);
			$lists['lbox_preload'] = JHTML::_('select.booleanlist',  'lbox_preload', 'class="inputbox"', $configParams['lbox_preload'] );
			
			//lightbox thumbs tab
			$configParams['lbox_show_thumbs'] = $configArray->get('lbox_show_thumbs', 1);
			$lists['lbox_show_thumbs'] = JHTML::_('select.booleanlist',  'lbox_show_thumbs', 'class="inputbox"', $configParams['lbox_show_thumbs'] );
			
			$configParams['lbox_thumb_width'] = $configArray->get('lbox_thumb_width', 90);
			
			$configParams['lbox_thumb_height'] = $configArray->get('lbox_thumb_height', 90);
			
			$configParams['lbox_crop_thumbs'] = $configArray->get('lbox_crop_thumbs', 1);
			$lists['lbox_crop_thumbs'] = JHTML::_('select.booleanlist',  'lbox_crop_thumbs', 'class="inputbox"', $configParams['lbox_crop_thumbs'] );
			
			$configParams['lbox_thumb_position'] = $configArray->get('lbox_thumb_position', 'below');
			$lbox_thumb_position = array();
			$lbox_thumb_position[] = JHTML::_( 'select.option', 'left', JText::_( 'LEFT' ) );
			$lbox_thumb_position[] = JHTML::_( 'select.option', 'below', JText::_( 'BELOW' ) );
			$lbox_thumb_position[] = JHTML::_( 'select.option', 'right', JText::_( 'RIGHT' ) );
			$lbox_thumb_position[] = JHTML::_( 'select.option', 'above', JText::_( 'ABOVE' ) );
			$lists['lbox_thumb_position'] = JHTML::_('select.radiolist', $lbox_thumb_position, 'lbox_thumb_position', 'class="inputbox" ', 'value', 'text', $configParams['lbox_thumb_position'], 'lbox_thumb_position' );
			
			$configParams['lbox_thumb_container_width'] = $configArray->get('lbox_thumb_container_width', 200);
			
			$configParams['lbox_thumb_container_height'] = $configArray->get('lbox_thumb_container_height', 0);
			
			$configParams['lbox_images_per_row'] = $configArray->get('lbox_images_per_row', 0);
			
			$configParams['lbox_thumb_scrollbar'] = $configArray->get('lbox_thumb_scrollbar', 0);
			$lists['lbox_thumb_scrollbar'] = JHTML::_('select.booleanlist',  'lbox_thumb_scrollbar', 'class="inputbox"', $configParams['lbox_thumb_scrollbar'] );
			
			$configParams['lbox_arrows_up_down'] = $configArray->get('lbox_arrows_up_down', 0);
			$lists['lbox_arrows_up_down'] = JHTML::_('select.booleanlist',  'lbox_arrows_up_down', 'class="inputbox"', $configParams['lbox_arrows_up_down'] );
			
			$configParams['lbox_arrows_left_right'] = $configArray->get('lbox_arrows_left_right', 1);
			$lists['lbox_arrows_left_right'] = JHTML::_('select.booleanlist',  'lbox_arrows_left_right', 'class="inputbox"', $configParams['lbox_arrows_left_right'] );
			
			$configParams['lbox_scroll_speed'] = $configArray->get('lbox_scroll_speed', .07);
			
			$configParams['lbox_scroll_boundary'] = $configArray->get('lbox_scroll_boundary', 200);
			
			//lightbox other tab
			$configParams['lbox_allow_comments'] = $configArray->get('lbox_allow_comments', 0);
			$lists['lbox_allow_comments'] = JHTML::_('select.booleanlist',  'lbox_allow_comments', 'class="inputbox"', $configParams['lbox_allow_comments'] );
			
			$configParams['lbox_allow_rating'] = $configArray->get('lbox_allow_rating', 0);
			$lists['lbox_allow_rating'] = JHTML::_('select.booleanlist',  'lbox_allow_rating', 'class="inputbox"', $configParams['lbox_allow_rating'] );
			
			$configParams['lbox_enable_slideshow'] = $configArray->get('lbox_enable_slideshow', 0);
			$lists['lbox_enable_slideshow'] = JHTML::_('select.booleanlist',  'lbox_enable_slideshow', 'class="inputbox"', $configParams['lbox_enable_slideshow'] );
			
			$configParams['lbox_show_slideshow_controls'] = $configArray->get('lbox_show_slideshow_controls', 0);
			$lists['lbox_show_slideshow_controls'] = JHTML::_('select.booleanlist',  'lbox_show_slideshow_controls', 'class="inputbox"', $configParams['lbox_show_slideshow_controls'] );
			
			$configParams['lbox_slideshow_autostart'] = $configArray->get('lbox_slideshow_autostart', 0);
			$lists['lbox_slideshow_autostart'] = JHTML::_('select.booleanlist',  'lbox_slideshow_autostart', 'class="inputbox"', $configParams['lbox_slideshow_autostart'] );
			
			$configParams['lbox_slideshow_pause'] = $configArray->get('lbox_slideshow_pause', 3000);
			
			$configParams['lbox_show_descriptions'] = $configArray->get('lbox_show_descriptions', 1);
			$lists['lbox_show_descriptions'] = JHTML::_('select.booleanlist',  'lbox_show_descriptions', 'class="inputbox"', $configParams['lbox_show_descriptions'] );
			
			$configParams['lbox_photo_des_position'] = $configArray->get('lbox_photo_des_position', 'below');
			$lbox_photo_des_position = array();
			$lbox_photo_des_position[] = JHTML::_( 'select.option', 'left', JText::_( 'LEFT' ) );
			$lbox_photo_des_position[] = JHTML::_( 'select.option', 'below', JText::_( 'BELOW' ) );
			$lbox_photo_des_position[] = JHTML::_( 'select.option', 'right', JText::_( 'RIGHT' ) );
			$lbox_photo_des_position[] = JHTML::_( 'select.option', 'above', JText::_( 'ABOVE' ) );
			$lists['lbox_photo_des_position'] = JHTML::_('select.radiolist', $lbox_photo_des_position, 'lbox_photo_des_position', 'class="inputbox" ', 'value', 'text', $configParams['lbox_photo_des_position'], 'lbox_photo_des_position' );
			
			$configParams['lbox_photo_des_width'] = $configArray->get('lbox_photo_des_width', 200);
			
			$configParams['lbox_photo_des_height'] = $configArray->get('lbox_photo_des_height', 40);
			
			$lists['configParams'] = $configParams;
			return $lists;
		}
		
		//this function is called in the view.html.php of the edit gallery views (front end and back end)
		//it returns the html for the edit gallery form elements
		function getEditFormElements($gallery)
		{
			$lists = array();
			
			//general tab
			$db =& JFactory::getDBO();
			$query = 'SELECT id AS value, name AS text FROM #__groups ORDER BY id';
			$db->setQuery($query);
			$groups = $db->loadObjectList();
			$lists['gallery_access'] = JHTML::_('select.genericlist', $groups, 'access', 'class="inputbox" size="3"', 'value', 'text', intval($gallery->access), '', 1 );
	
			$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $gallery->published );
			
			$db =& JFactory::getDBO();
			$query = 'SELECT id AS value, name AS text FROM #__users ORDER BY id';
			$db->setQuery($query);
			$groups = $db->loadObjectList();
			$lists['authors'] = JHTML::_('select.genericlist', $groups, 'user', 'class="inputbox" size="1"', 'value', 'text',$gallery->user );
			
			
			//category tab
			$lists['remove_menu_image'] = JHTML::_('select.booleanlist',  'remove_menu_image', 'class="inputbox"', 0 );
			
			$db =& JFactory::getDBO();
			$query = 'SELECT id AS value, name AS text FROM #__groups ORDER BY id';
			$db->setQuery($query);
			$groups = $db->loadObjectList();
			$lists['menu_access'] = JHTML::_('select.genericlist', $groups, 'menu_access', 'class="inputbox" size="3"', 'value', 'text', intval($gallery->menu_access), '', 1 );
			
			//main image tab
			$lists['show_large_image'] = JHTML::_('select.booleanlist',  'show_large_image', 'class="inputbox"', $gallery->show_large_image );
			
			$lists['fade'] = JHTML::_('select.booleanlist',  'fade', 'class="inputbox"', $gallery->fade );
			
			$lists['preload'] = JHTML::_('select.booleanlist',  'preload', 'class="inputbox"', $gallery->preload );
			
			$lists['magnify'] = JHTML::_('select.booleanlist',  'magnify', 'class="inputbox"', $gallery->magnify );
			
			
			//thumbs tab
			$lists['show_thumbs'] = JHTML::_('select.booleanlist',  'show_thumbs', 'class="inputbox"', $gallery->show_thumbs );
			
			$lists['crop_thumbs'] = JHTML::_('select.booleanlist',  'crop_thumbs', 'class="inputbox"', $gallery->crop_thumbs );
			
			$thumb_position = array();
			$thumb_position[] = JHTML::_( 'select.option', 'left', JText::_( 'LEFT' ) );
			$thumb_position[] = JHTML::_( 'select.option', 'below', JText::_( 'BELOW' ) );
			$thumb_position[] = JHTML::_( 'select.option', 'right', JText::_( 'RIGHT' ) );
			$thumb_position[] = JHTML::_( 'select.option', 'above', JText::_( 'ABOVE' ) );
			$lists['thumb_position'] = JHTML::_('select.radiolist', $thumb_position, 'thumb_position', 'class="inputbox" ', 'value', 'text', $gallery->thumb_position, 'thumb_position' );	
			
			$lists['thumb_scrollbar'] = JHTML::_('select.booleanlist',  'thumb_scrollbar', 'class="inputbox"', $gallery->thumb_scrollbar );
			
			$lists['arrows_up_down'] = JHTML::_('select.booleanlist',  'arrows_up_down', 'class="inputbox"', $gallery->arrows_up_down );
			
			$lists['arrows_left_right'] = JHTML::_('select.booleanlist',  'arrows_left_right', 'class="inputbox"', $gallery->arrows_left_right );
			
			
			//other tab
			$lists['show_cat_menu'] = JHTML::_('select.booleanlist',  'show_cat_menu', 'class="inputbox"', $gallery->show_cat_menu );
			
			$gallery_des_position = array();
			$gallery_des_position[] = JHTML::_( 'select.option', 'above', JText::_( 'ABOVE' ) );
			$gallery_des_position[] = JHTML::_( 'select.option', 'below', JText::_( 'BELOW' ) );
			$lists['gallery_des_position'] = JHTML::_('select.radiolist', $gallery_des_position, 'gallery_des_position', 'class="inputbox" ', 'value', 'text', $gallery->gallery_des_position, 'gallery_des_position' );
			
			$styles = array();
			$styles['plain'] = JHTML::_( 'select.option', 'plain', JText::_( 'PLAIN' ) );
			$styles['grey-border-shadow'] = JHTML::_( 'select.option', 'grey-border-shadow', JText::_( 'GREY BORDER SHADOW' ) );
			$lists['style'] = JHTML::_('select.genericlist', $styles, 'style', 'class="inputbox" size="2"', 'value', 'text', $gallery->style, '', 1 );
			
			
			$lists['allow_comments'] = JHTML::_('select.booleanlist',  'allow_comments', 'class="inputbox"', $gallery->allow_comments );
			
			$lists['allow_rating'] = JHTML::_('select.booleanlist',  'allow_rating', 'class="inputbox"', $gallery->allow_rating );
			
			$align = array();
			$align[] = JHTML::_( 'select.option', 'left', JText::_( 'LEFT' ) );
			$align[] = JHTML::_( 'select.option', 'center', JText::_( 'CENTER' ) );
			$align[] = JHTML::_( 'select.option', 'right', JText::_( 'RIGHT' ) );
			$lists['align'] = JHTML::_('select.radiolist', $align, 'align', 'class="inputbox" ', 'value', 'text', $gallery->align, 'align' );
	
			$lists['enable_slideshow'] = JHTML::_('select.booleanlist',  'enable_slideshow', 'class="inputbox"', $gallery->enable_slideshow );
			
			$lists['show_slideshow_controls'] = JHTML::_('select.booleanlist',  'show_slideshow_controls', 'class="inputbox"', $gallery->show_slideshow_controls );
			
			$lists['slideshow_autostart'] = JHTML::_('select.booleanlist',  'slideshow_autostart', 'class="inputbox"', $gallery->slideshow_autostart );
			
			$lists['show_descriptions'] = JHTML::_('select.booleanlist',  'show_descriptions', 'class="inputbox"', $gallery->show_descriptions );
			
			$photo_des_position = array();
			$photo_des_position[] = JHTML::_( 'select.option', 'left', JText::_( 'LEFT' ) );
			$photo_des_position[] = JHTML::_( 'select.option', 'below', JText::_( 'BELOW' ) );
			$photo_des_position[] = JHTML::_( 'select.option', 'right', JText::_( 'RIGHT' ) );
			$photo_des_position[] = JHTML::_( 'select.option', 'above', JText::_( 'ABOVE' ) );
			$lists['photo_des_position'] = JHTML::_('select.radiolist', $photo_des_position, 'photo_des_position', 'class="inputbox" ', 'value', 'text', $gallery->photo_des_position, 'photo_des_position' );
			
			//lightbox tab
			$lists['lightbox'] = JHTML::_('select.booleanlist',  'lightbox', 'class="inputbox"', $gallery->lightbox );
			
			$lists['lbox_fade'] = JHTML::_('select.booleanlist',  'lbox_fade', 'class="inputbox"', $gallery->lbox_fade );
			
			$lists['lbox_preload'] = JHTML::_('select.booleanlist',  'lbox_preload', 'class="inputbox"', $gallery->lbox_preload );
			
			
			//lightbox thumbs tab
			$lists['lbox_show_thumbs'] = JHTML::_('select.booleanlist',  'lbox_show_thumbs', 'class="inputbox"', $gallery->lbox_show_thumbs );
			
			$lists['lbox_crop_thumbs'] = JHTML::_('select.booleanlist',  'lbox_crop_thumbs', 'class="inputbox"', $gallery->lbox_crop_thumbs );
			
			$lbox_thumb_position = array();
			$lbox_thumb_position[] = JHTML::_( 'select.option', 'left', JText::_( 'LEFT' ) );
			$lbox_thumb_position[] = JHTML::_( 'select.option', 'below', JText::_( 'BELOW' ) );
			$lbox_thumb_position[] = JHTML::_( 'select.option', 'right', JText::_( 'RIGHT' ) );
			$lbox_thumb_position[] = JHTML::_( 'select.option', 'above', JText::_( 'ABOVE' ) );
			$lists['lbox_thumb_position'] = JHTML::_('select.radiolist', $lbox_thumb_position, 'lbox_thumb_position', 'class="inputbox" ', 'value', 'text', $gallery->lbox_thumb_position, 'lbox_thumb_position' );
			
			$lists['lbox_thumb_scrollbar'] = JHTML::_('select.booleanlist',  'lbox_thumb_scrollbar', 'class="inputbox"', $gallery->lbox_thumb_scrollbar );
			
			$lists['lbox_arrows_up_down'] = JHTML::_('select.booleanlist',  'lbox_arrows_up_down', 'class="inputbox"', $gallery->lbox_arrows_up_down );	
			
			$lists['lbox_arrows_left_right'] = JHTML::_('select.booleanlist',  'lbox_arrows_left_right', 'class="inputbox"', $gallery->lbox_arrows_left_right );
			
			
			//lightbox other tab
			$lists['lbox_allow_comments'] = JHTML::_('select.booleanlist',  'lbox_allow_comments', 'class="inputbox"', $gallery->lbox_allow_comments );
			
			$lists['lbox_allow_rating'] = JHTML::_('select.booleanlist',  'lbox_allow_rating', 'class="inputbox"', $gallery->lbox_allow_rating );
			
			$lists['lbox_enable_slideshow'] = JHTML::_('select.booleanlist',  'lbox_enable_slideshow', 'class="inputbox"', $gallery->lbox_enable_slideshow );
			
			$lists['lbox_show_slideshow_controls'] = JHTML::_('select.booleanlist',  'lbox_show_slideshow_controls', 'class="inputbox"', $gallery->lbox_show_slideshow_controls );
			
			$lists['lbox_slideshow_autostart'] = JHTML::_('select.booleanlist',  'lbox_slideshow_autostart', 'class="inputbox"', $gallery->lbox_slideshow_autostart );
			
			$lists['lbox_show_descriptions'] = JHTML::_('select.booleanlist',  'lbox_show_descriptions', 'class="inputbox"', $gallery->lbox_show_descriptions );
			
			$lbox_photo_des_position = array();
			$lbox_photo_des_position[] = JHTML::_( 'select.option', 'left', JText::_( 'LEFT' ) );
			$lbox_photo_des_position[] = JHTML::_( 'select.option', 'below', JText::_( 'BELOW' ) );
			$lbox_photo_des_position[] = JHTML::_( 'select.option', 'right', JText::_( 'RIGHT' ) );
			$lbox_photo_des_position[] = JHTML::_( 'select.option', 'above', JText::_( 'ABOVE' ) );
			$lists['lbox_photo_des_position'] = JHTML::_('select.radiolist', $lbox_photo_des_position, 'lbox_photo_des_position', 'class="inputbox" ', 'value', 'text', $gallery->lbox_photo_des_position, 'lbox_photo_des_position' );
			
			return $lists;
		}
}