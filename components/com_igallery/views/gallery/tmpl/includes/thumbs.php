<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<div id="<?php echo $thumbsVars->prefix; ?>_thumbs_arrow_wrapper<?php echo $this->id; ?>" class="<?php echo $thumbsVars->prefix; ?>_thumbs_arrow_wrapper">
<?php

//show up arrow
if($thumbsVars->arrows_up_down == 1)
{
?>
		<div id="<?php echo $thumbsVars->prefix; ?>_up_arrow<?php echo $this->id; ?>" class="<?php echo $thumbsVars->prefix; ?>_up_arrow" style="width: <?php echo $thumbsVars->thumb_container_width; ?>px;">
			<img src="<?php echo $this->host; ?>components/com_igallery/images/up_arrow.gif" id="<?php echo $thumbsVars->prefix; ?>_up_arrow_img<?php echo $this->id; ?>" class="<?php echo $thumbsVars->prefix; ?>_up_arrow_img" alt="" /><!-- thumbs up arrow -->
		</div>
		<div class="igallery_clear"></div>
<?php
}
?>
		
		<div id="<?php echo $thumbsVars->prefix; ?>_thumb_container<?php echo $this->id; ?>" class="<?php echo $thumbsVars->prefix; ?>_thumb_container" style="width: <?php echo $thumbsVars->thumb_container_width; ?>px;
<?php
if($thumbsVars->thumb_scrollbar == 1)
{
?>
 overflow: auto; 
<?php
}
else
{
?>
 overflow: hidden; 
<?php
}
	
if($thumbsVars->show_thumbs == 0)
{
?>
 display: none;
<?php
}
		
if($thumbsVars->thumb_container_height != 0)
{
?>
 height:<?php echo $thumbsVars->thumb_container_height; ?>px;
<?php
}
?>
		"><!-- start <?php echo $thumbsVars->prefix; ?> thumbs container div -->

			<table id="<?php echo $thumbsVars->prefix; ?>_thumb_table<?php echo $this->id; ?>" class="<?php echo $thumbsVars->prefix; ?>_thumb_table" cellpadding="0" cellspacing="0" ><!-- start <?php echo $thumbsVars->prefix; ?> thumbs table -->
<?php

//set the number of images in a row
if($thumbsVars->images_per_row == 0)
{
	$thumbsInRow = $this->numPics;
}
else
{
	$thumbsInRow = $thumbsVars->images_per_row;
}

$counter = 0;
while($counter < $this->numPics)
{
?>
			<tr>
<?php	
	for($i=0; $i<$thumbsInRow; $i++)
	{
		if( isset($this->photoList[$counter]) )
		{
			$row = &$this->photoList[$counter];
			
			$cleanLink = '#';
			$target = '';
			$linkClass = 'no_link';
			
			if(strlen($row->link) > 1)
			{
				$cleanLink = str_replace('\'', '&#039',$row->link);
				$linkClass = 'picture_link';
				if($row->target_blank == 1)
				{
					$target = ' target="_blank"';
				}
			}
			?> 
				<td align="center">
					<div class="thumbs_div" style="width: <?php echo $row->{$thumbsVars->thumb_width_name} + 14; ?>px; height:<?php echo $row->{$thumbsVars->thumb_height_name} + 14; ?>px;" >
						<a href="<?php echo $cleanLink; ?>" class="<?php echo $linkClass; ?>"<?php echo $target; ?>>
							<img src="<?php echo $this->host; ?>images/stories/igallery/<?php echo $this->gallery->folder; ?>/<?php echo $thumbsVars->foldertype; ?>/<?php echo $row->filename; ?>" alt="<?php echo $row->alt_text; ?>" width="<?php echo $row->{$thumbsVars->thumb_width_name}; ?>" height="<?php echo $row->{$thumbsVars->thumb_height_name}; ?>" />
						</a>
					</div>
				</td>
		<?php
		}
		else
		{
		?>
				<td>&nbsp;</td>
		<?php
		}
		$counter++;
	}
	?>
	
			</tr>
				
<?php
}
?>
			</table><!-- end <?php echo $thumbsVars->prefix; ?> thumbs table -->
		
		</div><!-- end <?php echo $thumbsVars->prefix; ?> thumbs container div -->
					
<?php
if($thumbsVars->arrows_left_right == 1)
{
?>		<div class="igallery_clear"></div>
		<div id="<?php echo $thumbsVars->prefix; ?>_left_right_arrows_div<?php echo $this->id; ?>" class="<?php echo $thumbsVars->prefix; ?>_left_right_arrows_div" style=" width: <?php echo $thumbsVars->thumb_container_width; ?>px;"><!-- start <?php echo $thumbsVars->prefix; ?> left/right arrows div -->			
				
			<img src="<?php echo $this->host; ?>components/com_igallery/images/left_arrow.gif" id="<?php echo $thumbsVars->prefix; ?>_left_arrow<?php echo $this->id; ?>" class="<?php echo $thumbsVars->prefix; ?>_left_arrow_img" alt="" />
			<img src="<?php echo $this->host; ?>components/com_igallery/images/right_arrow.gif" id="<?php echo $thumbsVars->prefix; ?>_right_arrow<?php echo $this->id; ?>" class="<?php echo $thumbsVars->prefix; ?>_right_arrow_img" alt="" />	
		
		</div><!-- end <?php echo $thumbsVars->prefix; ?> left/right arrows div -->
<?php
}

if($thumbsVars->arrows_up_down == 1)
{
?>
	<div class="igallery_clear"></div>
	<div id="<?php echo $thumbsVars->prefix; ?>down_arrow<?php echo $this->id; ?>" class="<?php echo $thumbsVars->prefix; ?>_down_arrow" style="width: <?php echo $thumbsVars->thumb_container_width; ?>px;">
		<img src="<?php echo $this->host; ?>components/com_igallery/images/down_arrow.gif" id="<?php echo $thumbsVars->prefix; ?>_down_arrow<?php echo $this->id; ?>" class="<?php echo $thumbsVars->prefix; ?>_down_arrow_img" alt="" /><!-- thumbs down arrow -->
	</div>
<?php
}
?>
</div><!-- end thumbs arrow wrapper -->