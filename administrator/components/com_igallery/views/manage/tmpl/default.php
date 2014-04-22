<?php defined('_JEXEC') or die('Restricted access'); ?>

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

<form action="index.php" method="post" name="adminForm" id="adminForm">
<fieldset class="adminform">
<legend><?php echo JText::_( 'CURRENT IMAGES' ); ?></legend>
<table class="adminlist">
<thead>
	<tr>
		<th width="5">
			<?php echo JText::_( 'NUM' ); ?>
		</th>
		
		<th width="20">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->photoList ); ?>);" />
		</th>
		
		<th class="title">
			<?php echo JText::_( 'THUMBNAIL' )?>
		</th>
		
		<th class="title">
			<?php echo JHTML::_('grid.sort', JText::_( 'FILE' ).JText::_( 'NAME' ), 
			'filename', $this->lists['order_Dir'], $this->lists['order'], 'manage' ); ?>
		</th>
		
		<th class="title">
			<?php echo JHTML::_('grid.sort', JText::_( 'FILE' ).JText::_( 'SIZE' ), 
			'filesize', $this->lists['order_Dir'], $this->lists['order'], 'manage' ); ?>
		</th>
		
		<th class="title">
			<?php echo JHTML::_('grid.sort', JText::_( 'DESCRIPTION' ), 'description', 
			$this->lists['order_Dir'], $this->lists['order'], 'manage' ); ?>
		</th>
		
		<th class="title">
			<?php echo JHTML::_('grid.sort', JText::_( 'IMAGE LINK' ), 'link', 
			$this->lists['order_Dir'], $this->lists['order'], 'manage' ); ?>
		</th>
		
		<th width="5%" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort', JText::_( 'PUBLISHED' ), 'published', 
			$this->lists['order_Dir'], $this->lists['order'], 'manage' ); ?>	
		</th>
		
		<th width="5%" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort', JText::_( 'ACCESS' ), 'access', 
			$this->lists['order_Dir'], $this->lists['order'], 'manage' ); ?>	
		</th>
		
		<th width="80" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort',  JText::_( 'ORDER' ), 'ordering', 
			$this->lists['order_Dir'], $this->lists['order'], 'manage' ); ?>
	 	</th>
	 			 
		<th width="1%">
			<?php echo JHTML::_('grid.order',  $this->photoList ); ?>
		</th>
	</tr>
</thead>	
<tfoot>
	<tr>
		<td colspan="11">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
</tfoot>
<?php
$k = 0;
$numPhotos = count($this->photoList);
for ($i=0; $i<$numPhotos; $i++)
{
	$row = &$this->photoList[$i];
	$editLink 	= JRoute::_( 'index.php?option=com_igallery&controller=manage&task=edit_photo&gid='.$this->gallery->id.'&cid[]='. $row->id );
	$checked 	= JHTML::_('grid.id',   $i, $row->id );
	$published 	= JHTML::_('grid.published', $row, $i);
	
	//get the name of the access group
	$db =& JFactory::getDBO();
	$query = 'SELECT name FROM #__groups where id = '.$row->access;
	$db->setQuery($query);
	$groupNameRow = $db->loadObject();
	$access = $groupNameRow->name;
	?>
	<tr class="<?php echo "row$k"; ?>">
		<td>
			<?php echo $this->pagination->getRowOffset($i); ?>
		</td>
		
		<td>
			<?php echo $checked; ?>
		</td>
		
		<td>
			<img src="../images/stories/igallery/<?php echo $this->gallery->folder . '/thumbs/' . 
			$row->filename; ?>" width="<?php echo $row->thumb_width; ?>" height="<?php echo $row->thumb_height; ?>" alt="<?php echo $row->alt_text; ?>"/>
		</td>
		
		<td align="center">
			<?php echo $row->filename;?>
		</td>
		
		<td align="center">
			<?php echo $row->filesize;?>Kb
		</td>
		
		<td align="center">
			<?php echo $row->description;?> <a href="<?php echo $editLink;?>"><?php echo JText::_( 'EDIT' ); ?></a>
		</td>
		
		<td align="center">
			<?php echo $row->link;?> <a href="<?php echo $editLink;?>"><?php echo JText::_( 'EDIT' ); ?></a>
		</td>
		
		<td align="center">
			<?php echo $published;?>
		</td>
		
		<td align="center">
			<a href="<?php echo $editLink;?>"><?php echo $access;?></a>
		</td>
		
		<td class="order" colspan="2">
			<span><?php echo $this->pagination->orderUpIcon($i, true, 'orderup', 'Move Up', 
			isset($this->photoList[$i-1]) ); ?></span>
			
			<span><?php echo $this->pagination->orderDownIcon($i, $numPhotos, true, 'orderdown', 'Move Down', 
			isset($this->photoList[$i+1]) ); ?></span>
			
			<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" 
			class="text_area" style="text-align: center" />
		</td>
		
	</tr>
	<?php
	$k = 1 - $k;
}
?>

</table>

<input type="hidden" name="option" value="com_igallery" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="manage" />
<input type="hidden" name="gid" value="<?php echo $this->gallery->id; ?>" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</fieldset>
</form>
	