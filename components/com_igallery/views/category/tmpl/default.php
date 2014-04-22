<?php 
defined('_JEXEC') or die('Restricted access');

//if they have chosen yes for show parent cat in the category, this loop will display
//all the categories that are a parent of this category
$numParentCats = count($this->parentCats);
if($numParentCats > 0)
{
?> 
	<div id="parent_cat_wrapper<?php echo $this->category->id; ?>" class="parent_cat_wrapper"><!--start parent category wrapper -->
	<?php
	
	$counter = 0;
	
	if($this->category->columns == 0)
	{
		$this->category->columns = $numParentCats;
	}
	while($counter<$numParentCats)
	{
	?>
		<?php
		for($i=0; $i<$this->category->columns; $i++)
		{
			$row = &$this->parentCats[$counter];
			if($row != null)
			{
				$link = JRoute::_('index.php?option=com_igallery&view=category&id='.$row->id.'&Itemid='.$this->itemId);
				?> 
				<div class="parent_cat_div" style="width: <?php echo $row->menu_max_width; ?>px;">
					<h3>
						<a href="<?php echo $link; ?>">
							<?php echo $row->name; ?> 
						</a>
					</h3>
					<?php if( strlen($row->menu_image_filename) > 1 ): ?>
					<a href="<?php echo $link; ?>">
						<img src="<?php echo $this->host.'images/stories/igallery/category_pics/'.$row->menu_image_filename?>" alt=""/>
					</a>
					<?php endif; ?>
					
					<?php echo $row->menu_description; ?> 
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
	</div><!--end parent category wrapper -->
	<div class="igallery_clear"></div>
<?php
}

//this loop will display all the categories that are children of this category
$numChildCats = count($this->childCats);

if($numChildCats > 0)
{
?> 
	<div id="cat_wrapper<?php echo $this->category->id; ?>" class="cat_wrapper"><!--start category wrapper -->
	<?php
	
	$counter = 0;
	if($this->category->columns == 0)
	{
		$this->category->columns = $numChildCats;
	}
	while($counter<$numChildCats)
	{
	?>
		<?php
		for($i=0; $i<$this->category->columns; $i++)
		{
			$row = &$this->childCats[$counter];
			if($row != null)
			{
				$link = JRoute::_('index.php?option=com_igallery&view=category&id='.$row->id.'&Itemid='.$this->itemId);
			?> 
				<div class="cat_div" style="width: <?php echo $row->menu_max_width; ?>px;" >
					<h3>
						<a href="<?php echo $link; ?>">
							<?php echo $row->name; ?> 
						</a>
					</h3>
					<?php if( strlen($row->menu_image_filename) > 1 ): ?>
					<a href="<?php echo $link; ?>">
						<img src="<?php echo $this->host.'images/stories/igallery/category_pics/'.$row->menu_image_filename?>" alt=""/>
					</a>
					<?php endif; ?>
					<?php echo $row->menu_description; ?> 
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
	</div><!--end category wrapper -->
	<div class="igallery_clear"></div>
<?php
}

$numChildGalleries = count($this->childGalleries);
if($numChildGalleries > 0)
{
	//this loop will display all the galleries that are children of this category
	?> 
	<div id="gallery_menu_wrapper<?php echo $this->category->id; ?>" class="gallery_menu_wrapper"><!--start gallery menu wrapper -->
	<?php
	
	$counter = 0;
	if($this->category->columns == 0)
	{
		$this->category->columns = $numChildGalleries;
	}
	while($counter<$numChildGalleries)
	{
	?>
		<?php
		for($i=0; $i<$this->category->columns; $i++)
		{
			$row = &$this->childGalleries[$counter];
			
			if($row != null)
			{	
				$link = JRoute::_('index.php?option=com_igallery&view=gallery&id='.$row->id.'&Itemid='.$this->itemId);
				?> 
				<div class="gallery_menu_div" style="width: <?php echo $row->menu_max_width; ?>px;">
					<h3>
						<a href="<?php echo $link; ?>">
							<?php echo $row->name; ?> 
						</a>
					</h3>
					<?php if( strlen($row->menu_image_filename) > 1 ): ?>
					<a href="<?php echo $link; ?>">
						<img src="<?php echo $this->host.'images/stories/igallery/'.$row->folder.'/'.$row->menu_image_filename; ?>" alt=""/>
					</a>
					<?php endif; ?>
					<?php echo $row->menu_description; ?>
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
	</div><!--end gallery menu wrapper -->
	<div class="igallery_clear"></div>
<?php
}