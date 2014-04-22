<?php
defined('_JEXEC') or die('Restricted access');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">

<?php if($this->backend == true):
	$editor =& JFactory::getEditor();
	
	jimport('joomla.html.pane');
	$pane =& JPane::getInstance('Tabs');
	echo $pane->startPane('myPane');
	
	echo $pane->startPanel(JText::_( 'GENERAL' ), 'general');

endif; ?>
		
<table class="admintable">
		
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'NAME' ); ?>:
	</td>
	<td>
		<input type="text" name="name" id="name" class="text_area" size="48" maxlength="250" value="<?php echo $this->gallery->name; ?>" />
	</td>
</tr>

<?php if($this->backend == true || $this->configArray->get('allow_alias', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'IG ALIAS' ); ?>:
	</td>
	<td>
		<input type="text" name="alias" id="alias" class="text_area" size="48" maxlength="250" value="<?php echo $this->gallery->alias; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_gallery_access', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'GALLERY ACCESS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['gallery_access']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_img_quality', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'IMAGE QUALITY' ).' (0-100)';?>:
	</td>
	<td>
		<input  type="text" name="img_quality" id="img_quality" 
		class="text_area" size="24" maxlength="12" value="<?php echo $this->gallery->img_quality; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_published', 1) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'PUBLISHED' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['published']; ?>
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'AUTHOR' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['authors']; ?>
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true): ?>
	</table>
	<?php echo $pane->endPanel(); 

	echo $pane->startPanel(JText::_( 'CATEGORY' ), 'category');?>
	
	<table class="admintable">
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_category', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'CATEGORY' );?>:
	</td>
	<td>
		<?php echo $this->catList; ?>
	</td>
</tr>
<?php endif; ?>
	
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'MENU IMAGE' ); ?>:
	</td>
	<td>
		<input type="file" name="upload_image" /><br /><br />
		<?php if( strlen($this->gallery->menu_image_filename) > 1 ): ?>
		<img src="<?php echo $this->host.'images/stories/igallery/'.$this->gallery->folder.'/'.$this->gallery->menu_image_filename; ?>" alt=""/>
		<?php endif; ?>
	</td>
</tr>

<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'REMOVE MENU IMAGE' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['remove_menu_image']; ?>
	</td>
</tr>

<?php if($this->backend == true || $this->configArray->get('allow_menu_max_width', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'MENU IMAGE MAXIMUM IMAGE WIDTH' ); ?>:
	</td>
	<td>
		<input type="text" name="menu_max_width" id="menu_max_width" 
		class="text_area" size="12" maxlength="12" value="<?php echo $this->gallery->menu_max_width; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_menu_max_height', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'MENU IMAGE MAXIMUM IMAGE HEIGHT' ); ?>:
	</td>
	<td>
		<input  type="text" name="menu_max_height" id="menu_max_height" 
		class="text_area" size="12" maxlength="12" value="<?php echo $this->gallery->menu_max_height; ?>" />
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true || $this->configArray->get('allow_menu_description', 1) == 1): ?>
<tr>
	<td width="100" align="right" valign="top" class="key">
		<?php echo JText::_( 'MENU DESCRIPTION' ); ?>:
	</td>
	<td>
		<?php if($this->backend == true): 
	 		echo $editor->display( 'menu_description', $this->gallery->menu_description ,'100%', '150', '60', '5' );
	  	endif; ?>
			
		<?php if($this->backend == false): ?>
			<textarea cols="50" rows="2" name="menu_description" id="menu_description" ><?php echo $this->gallery->menu_description; ?></textarea>
		<?php endif; ?>
	</td>
</tr>
<?php endif; ?>
		
<?php if($this->backend == true || $this->configArray->get('allow_menu_access', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'MENU ACCESS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['menu_access']; ?>
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true): ?>
	</table>
	<?php echo $pane->endPanel(); 
	echo $pane->startPanel(JText::_( 'MAIN IMAGE' ), 'main_image');?>
	<table class="admintable">	
<?php endif; ?>	

<?php if($this->backend == true || $this->configArray->get('allow_show_large_image', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'SHOW LARGE IMAGE' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['show_large_image']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_max_width', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'MAXIMUM IMAGE WIDTH' ); ?>:
	</td>
	<td>
		<input  type="text" name="max_width" id="max_width" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->max_width; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_max_height', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'MAXIMUM IMAGE HEIGHT' ); ?>:
	</td>
	<td>
		<input  type="text" name="max_height" id="max_height" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->max_height; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_img_container_width', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'IMG CONTAINER WIDTH ZERO EQUALS AUTO' ); ?>:
	</td>
	<td>
		<input type="text" name="img_container_width" id="img_container_width" 
		class="text_area" size="12" maxlength="12" value="<?php echo $this->gallery->img_container_width; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_img_container_height', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'IMG CONTAINER HEIGHT ZERO EQUALS AUTO' ); ?>:
	</td>
	<td>
		<input  type="text" name="img_container_height" id="img_container_height" 
		class="text_area" size="12" maxlength="12" value="<?php echo $this->gallery->img_container_height; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_fade', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'FADE BETWEEN IMAGES' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['fade']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_preload', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'PRELOAD LARGE IMAGES' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['preload']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_magnify', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'SHOW ENLARGE GIF' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['magnify']; ?>
	</td>
</tr>
<?php endif; ?>
	
	<?php if($this->backend == true): ?>
	</table>
<?php echo $pane->endPanel(); 
	echo $pane->startPanel(JText::_( 'THUMBNAILS' ), 'thumbnails');?>
	<table class="admintable">
	
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_show_thumbs', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'SHOW THUMBNAILS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['show_thumbs']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_thumb_width', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'THUMBNAIL MAXIMUM WIDTH' ); ?>:
	</td>
	<td>
		<input  type="text" name="thumb_width" id="thumb_width" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->thumb_width; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_thumb_height', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'THUMBNAIL MAXIMUM HEIGHT' ); ?>:
	</td>
	<td>
		<input  type="text" name="thumb_height" id="thumb_height" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->thumb_height; ?>" />
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true || $this->configArray->get('allow_crop_thumbs', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'CROP THUMBNAILS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['crop_thumbs']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_thumb_position', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'THUMBNAIL POSITION' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['thumb_position']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_thumb_container_width', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'THUMBNAIL CONTAINER WIDTH' ); ?>:
	</td>
	<td>
		<input  type="text" name="thumb_container_width" id="thumb_container_width" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->thumb_container_width; ?>" />
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true || $this->configArray->get('allow_thumb_container_height', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'THUMBNAIL CONTAINER HEIGHT' ); ?>:
	</td>
	<td>
		<input  type="text" name="thumb_container_height" id="thumb_container_height" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->thumb_container_height; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_images_per_row', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'IMAGES PER ROW' )?>:
	</td>
	<td>
		<input  type="text" name="images_per_row" id="images_per_row" 
		class="text_area" size="12" maxlength="12" value="<?php echo $this->gallery->images_per_row; ?>" /> 
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_thumb_scrollbar', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'SHOW THUMBNAIL SCROLLBAR' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['thumb_scrollbar']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_arrows_up_down', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'SHOW UP DOWN ARROWS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['arrows_up_down']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_arrows_left_right', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'SHOW LEFT RIGHT ARROWS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['arrows_left_right']; ?>
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true || $this->configArray->get('allow_scroll_speed', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'MOUSEOVER SCROLLER SPEED' )?>:
	</td>
	<td>
		<input  type="text" name="scroll_speed" id="scroll_speed" 
		class="text_area" size="24" maxlength="12" value="<?php echo $this->gallery->scroll_speed; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_scroll_boundary', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'MOUSEOVER SCROLLER BOUNDARY' )?>:
	</td>
	<td>
		<input  type="text" name="scroll_boundary" id="scroll_boundary" 
		class="text_area" size="24" maxlength="12" value="<?php echo $this->gallery->scroll_boundary; ?>" />
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true): ?>
	</table>
	<?php echo $pane->endPanel(); 
	echo $pane->startPanel(JText::_( 'OTHER' ), 'other');?>

	<fieldset class="adminform">
	<legend><?php echo JText::_( 'OTHER' ); ?></legend>
	<table class="admintable">
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_show_cat_menu', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'SHOW CATEGORY MENU IN GALLERY' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['show_cat_menu']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_cat_menu_columns', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'CATEGORY MENU COLUMNS GALLERY PAGE' );?>:
	</td>
	<td>
		<input  type="text" name="cat_menu_columns" id="cat_menu_columns" 
		class="text_area" size="24" maxlength="12" value="<?php echo $this->gallery->cat_menu_columns; ?>" />
	</td>
</tr>
<?php endif; ?>
		
		
		
<?php if($this->backend == true || $this->configArray->get('allow_gallery_description', 1) == 1): ?>
<tr>
	<td width="100" align="right" valign="top" class="key">
		<?php echo JText::_( 'GALLERY DESCRIPTION' ); ?>:
	</td>
	<td>
		
		<?php if($this->backend == true): 
			 		echo $editor->display( 'gallery_description', $this->gallery->gallery_description ,'100%', '150', '60', '5' );
		      endif; ?>
		
		<?php if($this->backend == false): ?>
			<textarea cols="50" rows="2" name="gallery_description" id="gallery_description"><?php echo $this->gallery->gallery_description; ?></textarea>
		<?php endif; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_gallery_des_position', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'GALLERY DESCRIPTION POSITION' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['gallery_des_position']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_allow_comments', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'ALLOW COMMENTS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['allow_comments']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_allow_rating', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'ALLOW RATING' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['allow_rating']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_align', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'GALLERY ALIGNMENT' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['align']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_style', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'STYLE' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['style']; ?>
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true): ?>
	</table>
	</fieldset>
	
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'SLIDESHOW' ); ?></legend>
	
	<table class="admintable">
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_enable_slideshow', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'ENABLE SLIDESHOW' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['enable_slideshow']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_show_slideshow_controls', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'SHOW SLIDESHOW CONTROLS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['show_slideshow_controls']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_slideshow_autostart', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'SLIDESHOW AUTOSTART' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['slideshow_autostart']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_slideshow_pause', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'SLIDESHOW PAUSE' ); ?>:
	</td>
	<td>
		<input  type="text" name="slideshow_pause" id="slideshow_pause" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->slideshow_pause; ?>" />
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true): ?>
	</table>
	</fieldset>
	
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'DESCRIPTIONS' ); ?></legend>
	
	<table class="admintable">
<?php endif; ?>
	
	
<?php if($this->backend == true || $this->configArray->get('allow_show_descriptions', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'SHOW DESCRIPTIONS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['show_descriptions']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_photo_des_position', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'PHOTO DESCRIPTION POSITION' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['photo_des_position']; ?>
	</td>
</tr>
<?php endif; ?>


<?php if($this->backend == true || $this->configArray->get('allow_photo_des_width', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'PHOTO DESCRIPTION WIDTH' ); ?>:
	</td>
	<td>
		<input  type="text" name="photo_des_width" id="photo_des_width" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->photo_des_width; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_photo_des_height', 0) == 1): ?>
<tr>
	<td width="100" align="right" valign="top" class="key">
		<?php echo JText::_( 'DESCRIPTION BOX HEIGHT' ); ?>:
	</td>
	<td>
		<input  type="text" name="photo_des_height" id="photo_des_height" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->photo_des_height; ?>" />
	</td>
</tr>
<?php endif; ?>
	
	
<?php if($this->backend == true): ?>
	</table>
	</fieldset>
	<?php echo $pane->endPanel(); 
	echo $pane->startPanel(JText::_( 'LIGHTBOX IMAGE' ), 'lightbox_image');?>
	<table class="admintable">
<?php endif; ?>
	
<?php if($this->backend == true || $this->configArray->get('allow_lightbox', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX EFFECT' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lightbox']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_max_width', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX MAXIMUM IMAGE WIDTH' ); ?>:
	</td>
	<td>
		<input  type="text" name="lbox_max_width" id="max_lightbox_width" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->lbox_max_width; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_max_height', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX MAXIMUM IMAGE HEIGHT' ); ?>:
	</td>
	<td>
		<input  type="text" name="lbox_max_height" id="max_lightbox_height" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->lbox_max_height; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_img_container_width', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX IMG CONTAINER WIDTH ZERO EQUALS AUTO' ); ?>:
	</td>
	<td>
		<input type="text" name="lbox_img_container_width" id="lbox_img_container_width" 
		class="text_area" size="12" maxlength="12" value="<?php echo $this->gallery->lbox_img_container_width; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_img_container_height', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX IMG CONTAINER HEIGHT ZERO EQUALS AUTO' ); ?>:
	</td>
	<td>
		<input  type="text" name="lbox_img_container_height" id="lbox_img_container_height" 
		class="text_area" size="12" maxlength="12" value="<?php echo $this->gallery->lbox_img_container_height; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_fade', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX FADE BETWEEN IMAGES' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_fade']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_preload', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX PRELOAD LARGE IMAGES' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_preload']; ?>
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true): ?>
	</table>
	<?php echo $pane->endPanel(); 
	echo $pane->startPanel(JText::_( 'LIGHTBOX THUMBNAILS' ), 'lbox_thumbs');?>
	<table class="admintable">
<?php endif; ?>


<?php if($this->backend == true || $this->configArray->get('allow_lbox_show_thumbs', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX SHOW THUMBNAILS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_show_thumbs']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_thumb_width', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX THUMBNAIL FORCED WIDTH' ); ?>:
	</td>
	<td>
		<input  type="text" name="lbox_thumb_width" id="lbox_thumb_width" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->lbox_thumb_width; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_thumb_height', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX THUMBNAIL FORCED HEIGHT' ); ?>:
	</td>
	<td>
		<input  type="text" name="lbox_thumb_height" id="lbox_thumb_height" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->lbox_thumb_height; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_crop_thumbs', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX CROP THUMBNAILS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_crop_thumbs']; ?>
	</td>
</tr>
<?php endif; ?>


<?php if($this->backend == true || $this->configArray->get('allow_lbox_thumb_position', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX THUMBNAIL POSITION' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_thumb_position']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_thumb_container_width', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX THUMBNAIL CONTAINER WIDTH' ); ?>:
	</td>
	<td>
		<input  type="text" name="lbox_thumb_container_width" id="lbox_thumb_container_width" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->lbox_thumb_container_width; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_thumb_container_height', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX THUMBNAIL CONTAINER HEIGHT' ); ?>:
	</td>
	<td>
		<input  type="text" name="lbox_thumb_container_height" id="lbox_thumb_container_height" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->lbox_thumb_container_height; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_images_per_row', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX IMAGES PER ROW' )?>:
	</td>
	<td>
		<input  type="text" name="lbox_images_per_row" id="lbox_images_per_row" 
		class="text_area" size="12" maxlength="12" value="<?php echo $this->gallery->lbox_images_per_row; ?>" /> 
	</td>
</tr>
<?php endif; ?>


<?php if($this->backend == true || $this->configArray->get('allow_lbox_thumb_scrollbar', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX SHOW THUMBNAIL SCROLLBAR' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_thumb_scrollbar']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_arrows_up_down', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX SHOW UP DOWN ARROWS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_arrows_up_down']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_arrows_left_right', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX SHOW LEFT RIGHT ARROWS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_arrows_left_right']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('lbox_scroll_speed', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX MOUSEOVER SCROLLER SPEED' )?>:
	</td>
	<td>
		<input  type="text" name="lbox_scroll_speed" id="lbox_scroll_speed" 
		class="text_area" size="24" maxlength="12" value="<?php echo $this->gallery->lbox_scroll_speed; ?>" />
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true || $this->configArray->get('allow_lbox_scroll_boundary', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX MOUSEOVER SCROLLER BOUNDARY' )?>:
	</td>
	<td>
		<input  type="text" name="lbox_scroll_boundary" id="lbox_scroll_boundary" 
		class="text_area" size="24" maxlength="12" value="<?php echo $this->gallery->lbox_scroll_boundary; ?>" />
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true): ?>
	</table>
	<?php echo $pane->endPanel(); 
	echo $pane->startPanel(JText::_( 'LIGHTBOX OTHER' ), 'lbox_other');?>

	<fieldset class="adminform">
	<legend><?php echo JText::_( 'LIGHTBOX OTHER' ); ?></legend>
	<table class="admintable">
<?php endif; ?>					
	
<?php if($this->backend == true || $this->configArray->get('allow_lbox_allow_comments', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX ALLOW COMMENTS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_allow_comments']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_allow_rating', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX ALLOW RATING' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_allow_rating']; ?>
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true): ?>
	</table>
	</fieldset>
	
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'LIGHTBOX SLIDESHOW' ); ?></legend>
	
	<table class="admintable">
<?php endif; ?>
	
<?php if($this->backend == true || $this->configArray->get('allow_lbox_enable_slideshow', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX ENABLE SLIDESHOW' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_enable_slideshow']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_show_slideshow_controls', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX SHOW SLIDESHOW CONTROLS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_show_slideshow_controls']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_slideshow_autostart', 0) == 1): ?>
<tr>
	<td valign="top" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX SLIDESHOW AUTOSTART' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_slideshow_autostart']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_slideshow_pause', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX SLIDESHOW PAUSE' ); ?>:
	</td>
	<td>
		<input  type="text" name="lbox_slideshow_pause" id="lbox_slideshow_pause" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->lbox_slideshow_pause; ?>" />
	</td>
</tr>
<?php endif; ?>
	
<?php if($this->backend == true): ?>
	</table>
	</fieldset>
	
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'LIGHTBOX DESCRIPTIONS' ); ?></legend>
	
	<table class="admintable">
<?php endif; ?>
	
<?php if($this->backend == true || $this->configArray->get('allow_lbox_show_descriptions', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX SHOW DESCRIPTIONS' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_show_descriptions']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_photo_des_position', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX PHOTO DESCRIPTION POSITION' ); ?>:
	</td>
	<td>
		<?php echo $this->lists['lbox_photo_des_position']; ?>
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_photo_des_width', 0) == 1): ?>
<tr>
	<td width="100" align="right" class="key">
		<?php echo JText::_( 'LIGHTBOX PHOTO DESCRIPTION WIDTH' ); ?>:
	</td>
	<td>
		<input  type="text" name="lbox_photo_des_width" id="lbox_photo_des_width" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->lbox_photo_des_width; ?>" />
	</td>
</tr>
<?php endif; ?>

<?php if($this->backend == true || $this->configArray->get('allow_lbox_photo_des_height', 0) == 1): ?>
<tr>
	<td width="100" align="right" valign="top" class="key">
		<?php echo JText::_( 'LIGHTBOX DESCRIPTION BOX HEIGHT' ); ?>:
	</td>
	<td>
		<input  type="text" name="lbox_photo_des_height" id="lbox_photo_des_height" class="text_area" 
		size="12" maxlength="12" value="<?php echo $this->gallery->lbox_photo_des_height; ?>" />
	</td>
</tr>
<?php endif; ?>
	
</table>
<?php if($this->backend == true): ?>
	</fieldset>
	<?php 
	echo $pane->endPanel(); 
	
	echo $pane->endPane();
	
	?>
	<input type="hidden" name="cid[]" value="<?php echo $this->gallery->id; ?>" />
	<input type="hidden" name="option" value="com_igallery" />
	<input type="hidden" name="task" value="" />
	</form>
<?php endif; ?>
