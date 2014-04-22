<?php defined('_JEXEC') or die('Restricted access'); ?>

<p style="width: 100%; text-align: right;">
	<a href="<?php echo $this->host; ?>index.php?option=com_igallery&amp;view=add&amp;Itemid=<?php echo $this->itemId; ?>"><?php echo JText::_( 'NEW GALLERY' ); ?></a>
</p>

<form id="igalleryForm" name="igalleryForm" method="post" action="index.php" >
<table class="adminlist">
<thead>
	<tr>
		<th class="title">
			<?php echo JText::_( 'NAME' ); ?>
		</th>
		
		<th class="title">
			<?php echo JText::_( 'MANAGE PHOTOS' ); ?>
		</th>
		
		<th class="title">
			<?php echo JText::_( 'PUBLISHED' ); ?>
		</th>
		
		<th class="title">
			<?php echo JText::_( 'DELETE' ); ?>
		</th>
		
		<th class="title">
			<?php echo JText::_( 'ORDER' ); ?> &nbsp;
			<a href="javascript: submitform()">
				<img src="administrator/images/filesave.png" alt="Save Order" />
			</a>
		</th>
	</tr>
</thead>	

<?php
$k = 0;
$numberGalleries = count($this->galleries);
for ($i=0; $i <$numberGalleries; $i++)
{
	$row = &$this->galleries[$i];
	
	$editLink 	= JRoute::_('index.php?option=com_igallery&view=edit&cid[]='.$row->id.'&Itemid='.$this->itemId);
	$managelink 	= JRoute::_('index.php?option=com_igallery&controller=manage&view=manage&gid='.$row->id.'&Itemid='.$this->itemId);
	$deletelink 	= JRoute::_('index.php?option=com_igallery&task=delete&cid[]='.$row->id.'&Itemid='.$this->itemId);
	
	//we dont have joomlas backend javascript, so we will just make the publish buttons links
	//and grab the images manually
	if($row->published == 1)
	{
		$publishedText = JText::_( 'PUBLISHED' );
		$publishedImg = 'administrator/images/tick.png';
		$publishedLink = 'index.php?option=com_igallery&task=unpublish&cid[]='.$row->id.'&Itemid='.$this->itemId;
	}
	else
	{
		$publishedText = JText::_( 'UNPUBLISHED' );
		$publishedImg = 'administrator/images/publish_x.png';
		$publishedLink = 'index.php?option=com_igallery&task=publish&cid[]='.$row->id.'&Itemid='.$this->itemId;
	}
	?>
	<tr class="<?php echo "row$k"; ?>">
		<td>
			<a href="<?php echo $editLink; ?>"><?php echo $row->name; ?></a>
		</td>
		
		<td>
			<a href="<?php echo $managelink; ?>">
				<?php echo JText::_( 'MANAGE PHOTOS' ); ?>
			</a>
		</td>
		
		<td>
			<a href="<?php echo $publishedLink; ?>">
				<img src="<?php echo $publishedImg; ?>" alt="<?php echo $publishedText; ?>" />
			</a>
		</td>
		
		<td>
			<a href="<?php echo $deletelink; ?>" onclick="return confirm('<?php echo JText::_('CONFIRM DELETE GALLERY'); ?>')">
				<?php echo JText::_( 'DELETE' ); ?>
			</a>
		</td>
		
		<td>
			<input type="text" size="3" name="order[]" value="<?php echo $row->ordering; ?>" />
			<input type="hidden" name="cid[]" value="<?php echo $row->id; ?>" />
		</td>
		
	</tr>
	<?php
	$k = 1 - $k;
}
?>
</table>
<input type="hidden" name="option" value="com_igallery" />
<input type="hidden" name="task" value="saveorder" />
<input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
</form>
