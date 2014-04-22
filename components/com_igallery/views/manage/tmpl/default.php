<?php defined('_JEXEC') or die('Restricted access'); ?>

<p style="width: 100%; text-align: right;">
	<a href="<?php echo $this->host; ?>/index.php?option=com_igallery&amp;view=igallery&amp;Itemid=<?php echo $this->itemId; ?>"><?php echo JText::_( 'BACK TO MENU' ); ?></a>
</p>

<div id="swfuploader">
	
	<form id="form1" action="index.php" method="post" enctype="multipart/form-data">
		
		<fieldset class="adminform">
		
			<div class="fieldset flash" id="fsUploadProgress">
				<span class="legend"><?php echo JText::_( 'UPLOAD QUEUE' ); ?></span>
			</div>
			
			<div id="divStatus">
				0 <?php echo JText::_( 'FILES UPLOADED' ); ?>
			</div>
			
			<div>
				<span id="spanButtonPlaceHolder"></span>
				<input id="btnCancel" type="button" value="<?php echo JText::_( 'CANCEL ALL UPLOADS' ); ?>" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 13px; height: 29px;" />
				<br />
				<?php echo JText::_( 'HOLD CONTROL SHIFT' ); ?>
			</div>
			
		</fieldset>
		
	</form>
	
</div>

<br />
   
<form id="igalleryPhotoForm" name="igalleryPhotoForm" method="post" action="index.php" >
<fieldset class="adminform">
<legend><?php echo JText::_( 'CURRENT IMAGES' ); ?></legend>

<table class="adminlist">
<thead>
	<tr>
		
		<th class="title">
			<?php echo JText::_( 'THUMBNAIL' )?>
		</th>
		
		<th class="title">
			<?php echo JText::_( 'DESCRIPTION' )?>
		</th>
		
		<th width="5%" nowrap="nowrap">
			<?php echo JText::_( 'PUBLISHED' )?>	
		</th>
		
		<th class="title">
			<?php echo JText::_( 'DELETE' ); ?>
		</th>
		
		<th class="title">
			<?php echo JText::_( 'ORDER' ); ?> &nbsp;
			<a href="javascript: submitIgalleryForm()">
				<img src="administrator/images/filesave.png" alt="Save Order" />
			</a>
		</th>
	</tr>
</thead>	
<tbody>	
<?php
$k = 0;
$numPhotos = count($this->photoList);
for ($i=0; $i<$numPhotos; $i++)
{
	$row = &$this->photoList[$i];
	$editDesLink 	= JRoute::_( 'index.php?option=com_igallery&controller=manage&view=edit_photo&gid='.$this->gallery->id.'&cid[]='. $row->id.'&Itemid='.$this->itemId );
	$deletelink 	= JRoute::_('index.php?option=com_igallery&controller=manage&task=delete_photo&gid='.$this->gallery->id.'&cid='.$row->id.'&Itemid='.$this->itemId);
	
	if($row->published == 1)
	{
		$publishedText = JText::_( 'PUBLISHED' );
		$publishedImg = 'administrator/images/tick.png';
		$publishedLink = 'index.php?option=com_igallery&controller=manage&task=unpublish&gid='.$this->gallery->id.'&cid[]='.$row->id.'&Itemid='.$this->itemId;
	}
	else
	{
		$publishedText = JText::_( 'UNPUBLISHED' );
		$publishedImg = 'administrator/images/publish_x.png';
		$publishedLink = 'index.php?option=com_igallery&controller=manage&task=publish&gid='.$this->gallery->id.'&cid[]='.$row->id.'&Itemid='.$this->itemId;
	}
	
	//get the name of the access group
	$db =& JFactory::getDBO();
	$query = 'SELECT name FROM #__groups where id = '.intval($row->access);
	$db->setQuery($query);
	$groupNameRow = $db->loadObject();
	$access = $groupNameRow->name;
	?>
	<tr class="<?php echo "row$k"; ?>">
		
		<td>
			<img src="images/stories/igallery/<?php echo $this->gallery->folder . '/thumbs/' . 
			$row->filename; ?>" alt="<?php echo $row->alt; ?>"/>
		</td>
		
		<td align="center">
			<?php echo $row->description;?> <a href="<?php echo $editDesLink;?>"><?php echo JText::_( 'EDIT' ); ?></a>
		</td>
		
		<td>
			<a href="<?php echo $publishedLink; ?>">
				<img src="<?php echo $publishedImg; ?>" alt="<?php echo $publishedText; ?>" />
			</a>
		</td>
		
		<td>
			<a href="<?php echo $deletelink; ?>">
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
</tbody>
</table>

<input type="hidden" name="option" value="com_igallery" />
<input type="hidden" name="controller" value="manage" />
<input type="hidden" name="task" value="saveorder" />
<input type="hidden" name="gid" value="<?php echo $this->gallery->id; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
</fieldset>
</form>	