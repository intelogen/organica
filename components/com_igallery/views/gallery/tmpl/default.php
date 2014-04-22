<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?> 

<!-- start ignite gallery html -->
<?php

//work out alignment of wrapper
$align = 'float: left;';
if($this->gallery->align == 'right')
{
	$align = 'float: right;';
}
if($this->gallery->align == 'center')
{
	$align = 'margin-left: auto; margin-right: auto;';
}

?>
<div id="main_gallery_wrapper<?php echo $this->id; ?>" class="main_gallery_wrapper" style="width: <?php echo $this->galleryWidth; ?>px; <?php echo $align; ?>" ><!-- start main gallery wrapper -->
<?php

//if 'show parent category menu at top' is enabled, show the menu
if($this->gallery->show_cat_menu == 1 && $this->calledFrom == 'component')
{
	$numGalleries = count($this->galleries);
	if($numGalleries != 0)
	{
		?>
		<div id="parent_cat_menu_wrapper<?php echo $this->id; ?>" class="parent_cat_menu_wrapper"><!-- start gallery menu div -->
		<?php
		$counter = 0;
		if($this->gallery->cat_menu_columns == 0)
		{
			$this->gallery->cat_menu_columns = $numGalleries;
		}
		while($counter < $numGalleries)
		{
			for($i=0; $i<$this->gallery->cat_menu_columns; $i++)
			{
				$row = &$this->galleries[$counter];
				if($row != null)
				{
					$link = JRoute::_('index.php?option=com_igallery&view=gallery&id='.$row->id.'&Itemid='.$this->itemId);
					?>
					<div class="gallery_menu_top" style="width: <?php echo $row->menu_max_width; ?>px;">
						<h3>
							<a href="<?php echo $link; ?>">
								<?php echo $row->name; ?>
							</a>
						</h3>
					<?php
					if( strlen($row->menu_image_filename) > 1 )
					{
					?>
						<a href="<?php echo $link; ?>"><img src="<?php echo $this->host; ?>images/stories/igallery/<?php echo $row->folder; ?>/<?php echo $row->menu_image_filename; ?>" alt=""/></a>
					<?php
					}
					echo $row->menu_description;
					?>
					</div>
					<?php
				}
				$counter++;
			}
			?>
			<div class="igallery_clear"></div>
			<?php
		}
?>
</div><!-- end gallery menu div -->

<?php
	}	

}

//gallery description above bit
if($this->gallery->gallery_des_position == 'above' && strlen($this->gallery->gallery_description) > 1)
{
?> 
	<div id="gallery_description<?php echo $this->id; ?>" class="gallery_description"><!-- gallery description above -->
		<?php echo $this->gallery->gallery_description; ?> 
	</div>
	
<?php
}

//we are going to inlcude the includes/thumbs.php file twice, once for the main gallery, and (possibly)
//once for the lightbox, so we set some vars here, then reset them before we include it again for
//the lightbox 
$thumbsVars = new stdClass();
$thumbsVars->thumb_scrollbar = $this->gallery->thumb_scrollbar;
$thumbsVars->images_per_row = $this->gallery->images_per_row;
$thumbsVars->prefix = 'main';
$thumbsVars->show_thumbs = $this->gallery->show_thumbs;
$thumbsVars->thumb_padding = $this->gallery->thumb_padding;
$thumbsVars->foldertype = 'thumbs';
$thumbsVars->arrows_left_right = $this->gallery->arrows_left_right;
$thumbsVars->arrows_up_down = $this->gallery->arrows_up_down;
$thumbsVars->thumb_width_name = 'thumb_width';
$thumbsVars->thumb_height_name = 'thumb_height';


//thumbs in above position
if($this->gallery->thumb_position == 'above')
{
	$thumbsVars->thumb_container_width = $this->galleryWidth;
	$thumbsVars->thumb_container_height = $this->gallery->thumb_container_height;
	include('includes'.DS.'thumbs.php');
}
 
$desVars = new stdClass();
$desVars->prefix = 'main';
$desVars->show = $this->gallery->show_descriptions;
//gallery description in above position
if($this->gallery->photo_des_position == 'above')
{
	$desVars->des_container_width = $this->galleryWidth;
	$desVars->photo_des_height = $this->gallery->photo_des_height;
	include('includes'.DS.'descriptions.php');
}


//description position left part
if($this->gallery->photo_des_position == 'left')
{
	$desVars->des_container_width = $this->gallery->photo_des_width;
	$desVars->photo_des_height = $this->largestHeight;
	include('includes'.DS.'descriptions.php');
}



//thumbs left position part
if($this->gallery->thumb_position == 'left')
{
	$thumbsVars->thumb_container_width = $this->gallery->thumb_container_width;
	$thumbsVars->thumb_container_height = $this->largestHeight;
	include('includes'.DS.'thumbs.php');
}


//big image part
?>
	<div id="main_image_slideshow_wrapper<?php echo $this->id; ?>" class="main_image_slideshow_wrapper">   
		<div id="main_large_image<?php echo $this->id; ?>" class="main_large_image" style="width: <?php echo $this->largestWidth; ?>px; height: <?php echo $this->largestHeight; ?>px; <?php if($this->gallery->show_large_image == 0){?> display: none;<?php }?>">
		</div><!-- end main large image div -->
	<?php
	if($this->gallery->enable_slideshow == 1 && $this->gallery->show_slideshow_controls == 1)
	{
	?> 	<div class="igallery_clear"></div>
		<div id="main_slideshow_buttons<?php echo $this->id; ?>" class="main_slideshow_buttons" ><!--main slideshow buttons bit -->
			<img src="<?php echo $this->host; ?>components/com_igallery/images/rewind.jpg" id="slideshow_rewind<?php echo $this->id; ?>" alt="" />
			<img src="<?php echo $this->host; ?>components/com_igallery/images/play.jpg" id="slideshow_play<?php echo $this->id; ?>" alt="" />
			<img src="<?php echo $this->host; ?>components/com_igallery/images/forward.jpg" id="slideshow_forward<?php echo $this->id; ?>" alt="" />
		</div>
	<?php
		}
	?>
	</div><!--end main image slideshow wrapper-->
	<?php
						
//thumbs right part
if($this->gallery->thumb_position == 'right')
{
	$thumbsVars->thumb_container_width = $this->gallery->thumb_container_width;
	$thumbsVars->thumb_container_height = $this->largestHeight;
	include('includes'.DS.'thumbs.php');
}



//description right part
if($this->gallery->photo_des_position == 'right')
{		
	$desVars->des_container_width = $this->gallery->photo_des_width;
	$desVars->photo_des_height = $this->largestHeight;
	include('includes'.DS.'descriptions.php');
}


//description below part
if($this->gallery->photo_des_position == 'below')
{
	$desVars->des_container_width = $this->galleryWidth;
	$desVars->photo_des_height = $this->gallery->photo_des_height;
	include('includes'.DS.'descriptions.php');
}



//thumbs below part
if($this->gallery->thumb_position == 'below')
{
	$thumbsVars->thumb_container_width = $this->galleryWidth;
	$thumbsVars->thumb_container_height = $this->gallery->thumb_container_height;
	include('includes'.DS.'thumbs.php');
}

//gallery description below bit
if($this->gallery->gallery_des_position == 'below' && strlen($this->gallery->gallery_description) > 1)
{
?>
<!-- gallery description below -->
<div id="gallery_description<?php echo $this->id; ?>" class="gallery_description">
<?php echo $this->gallery->gallery_description; ?>
</div>
<?php
}

$ratingsVars = new stdClass();
//main gallery rating bit
if($this->gallery->allow_rating == 1)
{	
	$ratingsVars->prefix = 'main';
	include('includes'.DS.'ratings.php');
}

$commentsVars = new stdClass();
//main gallery comments bit
if($this->gallery->allow_comments == 1)
{	
	$commentsVars->prefix = 'main';
	include('includes'.DS.'comments.php');
}

?>

</div><!-- end main wrapper div -->
<div class="igallery_clear"></div>
<?php

//START HIDDEN LIGHTBOX HTML

if($this->gallery->lightbox == 1)
{
?> 
<!--start ignite gallery hidden lbox html -->
<div id="lbox_dark<?php echo $this->id; ?>" class="lbox_dark" style="display: none;" ></div><!-- lbox dark div -->

<div id="lbox_white<?php echo $this->id; ?>" class="lbox_white" style="width:<?php echo $this->galleryLboxWidth; ?>px; display: none;" ><!-- start white lbox div -->
<?php

$thumbsVars->thumb_scrollbar = $this->gallery->lbox_thumb_scrollbar;
$thumbsVars->images_per_row = $this->gallery->lbox_images_per_row;
$thumbsVars->prefix = 'lbox';-
$thumbsVars->show_thumbs = $this->gallery->lbox_show_thumbs;
$thumbsVars->thumb_padding = $this->gallery->lbox_thumb_padding;
$thumbsVars->foldertype = 'lightbox_thumbs';
$thumbsVars->arrows_left_right = $this->gallery->lbox_arrows_left_right;
$thumbsVars->arrows_up_down = $this->gallery->lbox_arrows_up_down;
$thumbsVars->thumb_width_name = 'lightbox_thumb_width';
$thumbsVars->thumb_height_name = 'lightbox_thumb_height';

//lbox thumbs above bit
if($this->gallery->lbox_thumb_position == 'above')
{
	$thumbsVars->thumb_container_width = $this->galleryLboxWidth;
	$thumbsVars->thumb_container_height = $this->gallery->lbox_thumb_container_height;
	include('includes'.DS.'thumbs.php');
}


$desVars->prefix = 'lbox';
$desVars->show = $this->gallery->lbox_show_descriptions;
//lbox description above bit
if($this->gallery->lbox_photo_des_position == 'above')
{
	$desVars->des_container_width = $this->galleryLboxWidth;
	$desVars->photo_des_height = $this->gallery->lbox_photo_des_height;
	include('includes'.DS.'descriptions.php');
}

//lbox left description bit
if($this->gallery->lbox_photo_des_position == 'left')
{
	$desVars->des_container_width = $this->gallery->lbox_photo_des_width;
	$desVars->photo_des_height = $this->largestLboxHeight;
	include('includes'.DS.'descriptions.php');
}



//lbox left thumbs bit
if($this->gallery->lbox_thumb_position == 'left')
{
	$thumbsVars->thumb_container_width = $this->gallery->lbox_thumb_container_width;
	$thumbsVars->thumb_container_height = $this->largestLboxHeight;
	include('includes'.DS.'thumbs.php');
}

//lbox big image bit
?>
		<!-- start lbox big image div -->
		<div id="lbox_image_slideshow_wrapper<?php echo $this->id; ?>" class="lbox_image_slideshow_wrapper">
		<div id="lbox_large_image<?php echo $this->id; ?>" class="lbox_large_image" style="width: <?php echo $this->largestLboxWidth; ?>px; height: <?php echo $this->largestLboxHeight; ?>px;" >
		</div>
		<?php
		if($this->gallery->lbox_enable_slideshow == 1 && $this->gallery->lbox_show_slideshow_controls == 1)
		{
			?>
			<!--lbox slideshow buttons bit -->
			<div class="igallery_clear"></div>
			<div id="lbox_slideshow_buttons<?php echo $this->id; ?>" class="lbox_slideshow_buttons" >
				<img src="<?php echo $this->host; ?>components/com_igallery/images/rewind.jpg" id="lbox_slideshow_rewind<?php echo $this->id; ?>" alt="" />
				<img src="<?php echo $this->host; ?>components/com_igallery/images/play.jpg" id="lbox_slideshow_play<?php echo $this->id; ?>" alt="" />
				<img src="<?php echo $this->host; ?>components/com_igallery/images/forward.jpg" id="lbox_slideshow_forward<?php echo $this->id; ?>" alt="" />
			</div>
		<?php
		}
		?>
		</div><!--end lbox image slideshow wrapper-->
		<?php
		

//lbox thumbs right bit
if($this->gallery->lbox_thumb_position == 'right')
{
	$thumbsVars->thumb_container_width = $this->gallery->lbox_thumb_container_width;
	$thumbsVars->thumb_container_height = $this->largestLboxHeight;
	include('includes'.DS.'thumbs.php');
}



//lbox description right bit
if($this->gallery->lbox_photo_des_position == 'right')
{
	$desVars->des_container_width = $this->gallery->lbox_photo_des_width;
	$desVars->photo_des_height = $this->largestLboxHeight;
	include('includes'.DS.'descriptions.php');
}


//lbox description below bit
if($this->gallery->lbox_photo_des_position == 'below')
{
	$desVars->des_container_width = $this->galleryLboxWidth;
	$desVars->photo_des_height = $this->gallery->lbox_photo_des_height;
	include('includes'.DS.'descriptions.php');	
}


//lbox thumbs below bit
if($this->gallery->lbox_thumb_position == 'below')
{
	$thumbsVars->thumb_container_width = $this->galleryLboxWidth;
	$thumbsVars->thumb_container_height = $this->gallery->lbox_thumb_container_height;
	include('includes'.DS.'thumbs.php');
}

//lightbox rating bit
if($this->gallery->lbox_allow_rating == 1)
{
	$ratingsVars->prefix = 'lbox';
	include('includes'.DS.'ratings.php');
}

//lightbox comments bit
if($this->gallery->lbox_allow_comments == 1)
{	
	$commentsVars->prefix = 'lbox';
	include('includes'.DS.'comments.php');
}


//close lbox image bit
?>

	<img src="<?php echo $this->host; ?>components/com_igallery/images/close.gif" id="closeImage<?php echo $this->id; ?>" class="closeImage" alt="close" /><!-- close image -->

</div><!-- end lbox white div -->
<?php
}
?>
<!-- end ignite gallery html -->