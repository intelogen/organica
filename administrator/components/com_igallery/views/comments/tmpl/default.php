<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm" >
<table border="0" width="100%">
	<tr>
		<td align="right">
			<?php echo $this->lists['gallery_id'];?>
		</td>
	</tr>
</table>

<table class="adminlist">
<thead>
	<tr>
		<th width="10">
			<?php echo JText::_( 'NUM' ); ?>
		</th>
		
		<th width="30">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->commentsList ); ?>);" />
		</th>
		
		<th class="title" style="text-align: left;">
			<?php echo JHTML::_('grid.sort', JText::_( 'AUTHOR' ), 'author', $this->lists['order_Dir'], $this->lists['order'] ); ?>
		</th>
		
		<th class="title" style="text-align: left;">
			<?php echo JHTML::_('grid.sort', JText::_( 'TEXT' ), 'text', $this->lists['order_Dir'], $this->lists['order'] ); ?>
		</th>
		
		<th class="title" style="text-align: left;">
			<?php echo JText::_( 'IMAGE' ); ?>
		</th>
		
		<th class="title" style="text-align: left;">
			<?php echo JHTML::_('grid.sort', JText::_( 'GALLERY NAME' ), 'gallery_id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
		</th>
		
		
		<th class="title" style="text-align: left;">
			<?php echo JHTML::_('grid.sort', JText::_( 'IP ADDRESS' ), 'ip', $this->lists['order_Dir'], $this->lists['order'] ); ?>
		</th>
		
		<th class="title" style="text-align: left;">
			<?php echo JHTML::_('grid.sort', JText::_( 'DATE' ), 'date', $this->lists['order_Dir'], $this->lists['order'] ); ?>
		</th>
		
		<th width="80" nowrap="nowrap">
			<?php echo JHTML::_('grid.sort', JText::_( 'PUBLISHED' ), 'published', $this->lists['order_Dir'], $this->lists['order'] ); ?>	
		</th>
		
	</tr>
</thead>

<tfoot>
	<tr>
		<td colspan="9" align="center" style="text-align: center">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tr>
</tfoot>
	
<?php
$k = 0;
$numberComments = count($this->commentsList);
$db =& JFactory::getDBO();

for ($i=0; $i < $numberComments; $i++)
{
	$row = &$this->commentsList[$i];
	
	$checked = JHTML::_('grid.id', $i, $row->id);
	$published 	= JHTML::_('grid.published', $row, $i );
	
	$query = 'SELECT * FROM #__igallery WHERE id = '.intval($row->gallery_id);
	$db->setQuery($query);
	$gallery = $db->loadObject();
	
	$query = 'SELECT * FROM #__igallery_img WHERE id = '.intval($row->img_id);
	$db->setQuery($query);
	$photo = $db->loadObject();	

	?>
	<tr class="<?php echo "row$k"; ?>">
		<td>
			<?php echo $this->pagination->getRowOffset($i); ?>
		</td>
		
		<td>
			<?php echo $checked; ?>
		</td>
	
		<td>
			<?php echo $row->author; ?>
		</td>
		
		<td>
			<?php echo $row->text; ?>
		</td>
		
		<td>
			<img src="<?php echo $this->host.'images/stories/igallery/'.$gallery->folder.'/thumbs/'.$photo->filename; ?>" alt="<?php echo $photo->alt_text; ?>" />
		</td>
		
		<td>
			<?php echo $gallery->name; ?>
		</td>
		
		<td>
			<?php echo $row->ip; ?>
		</td>
		
		<td>
			<?php echo date(" G:i j/m/Y",$row->date); ?>
		</td>
		
		<td align="center">
			<?php echo $published;?>
		</td>
		
	</tr>
<?php
$k = 1 - $k;
}
?>


</table>

<input type="hidden" name="option" value="com_igallery" />
<input type="hidden" name="controller" value="comments" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>
