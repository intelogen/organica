<?php defined('_JEXEC') or die('Restricted access'); ?>
 
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<fieldset class="adminform">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(
				<?php echo count( $this->items ); ?>);" />
			</th>
			
			<th class="title">
				<?php echo JText::_( 'NAME' ); ?>
			</th>
			
			<th class="title" style="text-align: left;">
				<?php echo JText::_( 'MANAGE PHOTOS' ); ?>
			</th>
			
			<th width="90" class="title">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			
			<th width="90" class="title">
				<?php echo JText::_( 'AUTHOR' ); ?>
			</th>
			
			<th width="150" class="title">
				<?php echo JText::_( 'ACCESS' ); ?>
			</th>
			
			<th width="150" class="title">
				<?php echo JText::_( 'PUBLISHED' ); ?>
			</th>
			
			<th width="60" class="title" style="text-align: left;">
				<?php echo JText::_( 'DELETE' ); ?>
			</th>
			
			<th width="100" nowrap="nowrap">
				<?php echo JText::_( 'ORDER' ); ?>
				<?php echo JHTML::_('grid.order', $this->items ); ?>
			</th>
		</tr>
	</thead>
	
	<tfoot>
		<tr>
			<td colspan="10">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
	</tfoot>
	
	<tbody>	
<?php
	$k = 0;
	$numItems = count($this->items);
	$db =& JFactory::getDBO();
	
	for ($i=0; $i<$numItems; $i++)
	{
		$row = &$this->items[$i];
		
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$published 	= JHTML::_('grid.published', $row, $i);
		
		//if the row is a category
		if($row->type == 0)
		{
			$editLink 	= JRoute::_( 'index.php?option=com_igallery&task=cat_edit&cid[]='. $row->id );
			$delLink 	= JRoute::_( 'index.php?option=com_igallery&task=cat_delete&cid[]='. $row->id );
			$delText = 'CONFIRM DELETE CATEGORY';
			$color = 'green';
			$orderUpTask = 'cat_orderup';
			$orderDownTask = 'cat_orderdown';
		}
		//if it is a gallery
		else
		{
			$manageLink 	= JRoute::_('index.php?option=com_igallery&controller=manage&gid='.$row->id);
			$editLink 	= JRoute::_( 'index.php?option=com_igallery&task=edit&cid[]='. $row->id );
			$delText = 'CONFIRM DELETE GALLERY';
			$delLink 	= JRoute::_( 'index.php?option=com_igallery&task=remove&cid[]='. $row->id );
			$color = '#0B55C4;';
			$orderUpTask = 'orderup';
			$orderDownTask = 'orderdown';
		}
		
		//the access is just a number, so we need the name from the joomla table
		$query = 'SELECT name FROM #__groups where id = '.intval($row->access);
		$db->setQuery($query);
		$groupName = $db->loadObject();
		
		//if it is a gallery get the owner of the galleries name
		if($row->type == 1)
		{
			$query = 'SELECT name FROM #__users where id = '.intval($row->user);
			$db->setQuery($query);
			$author = $db->loadObject();
			
			//if the author has been deleted, make a question mark, the admin can change the owner in
			//the edit gallery screen
			if($author == null)
			{	
				$author = new stdClass();
				$author->name = '?';
			}
		}
			
	?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $this->pagination->getRowOffset($i); ?>
			</td>
			
			<td>
				<?php echo $checked; ?>
			</td>
			
			<td>
			<?php
			//if someone forgot to put in the name, make a __ for the name so it can 
			//be clicked on for editing
			if( strlen($this->items[$i]->treename) < 1)
			{
				$this->items[$i]->treename = '____';
			}
			?>
				<a href="<?php echo $editLink ?>" style="color: <?php echo $color; ?>;"><?php  echo $this->items[$i]->treename; ?></a>
			</td>
			
			<td>
				<?php if($row->type == 1): ?>
					<a href="<?php echo $manageLink; ?>">
					<?php echo JText::_( 'MANAGE PHOTOS' ); ?></a>
				<?php endif; ?>
			</td>
			
			<td align="center">
				<?php echo $row->id;?>
			</td>
			
			<td align="center">
				<?php if($row->type == 1): 
					echo $author->name;
				endif; ?>
			</td>
			
			<td align="center">
				<?php echo $groupName->name; ?>
			</td>
			
			<td align="center">
				<?php echo $published; ?>
			</td>
			
			<td>
				<a href="<?php echo $delLink; ?>" onclick="return confirm('<?php echo JText::_( $delText ); ?>')"><?php echo JText::_('DELETE'); ?></a>
			</td>
			
			<td class="order">
			<?php
			//the ordering is a bit tricky with categories and galleries on the same list, so we need
			//to do a few little things..
			
			$showOrderUp = false;
			$showOrderDown = false;
			
			//loop through all the galleries/categories
			foreach($this->items as $key =>$value)
			{
				//if there is another item that has the same parent as the item we are displaying, and it is the same type,
				//and the other item is lower down in the order, show an order up
				if ($row->parent == $value->parent && $row->type == $value->type && $row->ordering > $value->ordering )
				{
					$showOrderUp = true;
				}
				//same idea for order down
				if ($row->parent == $value->parent && $row->type == $value->type && $row->ordering < $value->ordering)
				{
					$showOrderDown = true;
				}
			}
			?>
 				<span><?php echo $this->pagination->orderUpIcon($i, $showOrderUp, $orderUpTask, 'Move Up', 
 				true );?></span>
				<span><?php echo $this->pagination->orderDownIcon($i, $numItems, $showOrderDown, $orderDownTask, 'Move Down', 
				true ); ?></span>
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" 
				class="text_area" style="text-align: center" />
			</td>
			
			
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
</tbody>
</table>
</fieldset>

<input type="hidden" name="option" value="com_igallery" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>
	