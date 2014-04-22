<?php
defined('_JEXEC') or die('Restricted access');
$editor =& JFactory::getEditor();
?>

<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'CATEGORY DETAILS' ); ?></legend>

		<table class="admintable">
		
		<tr>
			<td width="100" align="right" class="key">
				<?php echo JText::_( 'NAME' ); ?>:
			</td>
			<td>
				<input type="text" name="name" id="name" value="<?php echo $this->category->name; ?>" class="text_area" size="48" maxlength="250" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<?php echo JText::_( 'ALIAS' ); ?>:
			</td>
			<td>
				<input type="text" name="alias" id="alias" value="<?php echo $this->category->alias; ?>" class="text_area" size="48" maxlength="250" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" valign="top" class="key">
				<?php echo JText::_( 'DESCRIPTION' ); ?>:
			</td>
			<td>
				<?php echo $editor->display( 'menu_description', $this->category->menu_description ,'100%', '150', '60', '5' );?>
			</td>
		</tr>
		
		<tr>
			<td valign="top" align="right" class="key">
				<?php echo JText::_( 'PARENT' );?>:
			</td>
			<td>
				<?php echo $this->parentList; ?>
			</td>
		</tr>
		
		<tr>
			<td valign="top" align="right" class="key">
				<?php echo JText::_( 'ACCESS' ); ?>:
			</td>
			<td>
				<?php echo $this->lists['access']; ?>
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<?php echo JText::_( 'IMAGE' ); ?>:
			</td>
			<td>
				<input type="file" name="upload_image" /><br />
				<img src="<?php echo $this->host.'images/stories/igallery/category_pics/'.$this->category->menu_image_filename; ?>" alt=""/>
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
		
		<tr>
			<td width="100" align="right" class="key">
				<?php echo JText::_( 'MAXIMUM IMAGE WIDTH' ); ?>:
			</td>
			<td>
				<input type="text" name="menu_max_width" id="menu_max_width" 
				class="text_area" size="12" maxlength="12" value="<?php echo $this->category->menu_max_width; ?>" />
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<?php echo JText::_( 'MAXIMUM IMAGE HEIGHT' ); ?>:
			</td>
			<td>
				<input  type="text" name="menu_max_height" id="menu_max_height" 
				class="text_area" size="12" maxlength="12" value="<?php echo $this->category->menu_max_height; ?>" />
			</td>
		</tr>
		
		<tr>
			<td valign="top" align="right" class="key">
				<?php echo JText::_( 'SHOW PARENT CATEGORY AT TOP' ); ?>:
			</td>
			<td>
				<?php echo $this->lists['show_parent']; ?>
			</td>
		</tr>
		
		<tr>
			<td valign="top" align="right" class="key">
				<?php echo JText::_( 'NUMBER OF COLUMNS' );?>:
			</td>
			<td>
				<input  type="text" name="columns" id="columns" 
				class="text_area" size="24" maxlength="12" value="<?php echo $this->category->columns; ?>" />
			</td>
		</tr>
		
		
		
		<tr>
			<td valign="top" align="right" class="key">
				<?php echo JText::_( 'PUBLISHED' ); ?>:
			</td>
			<td>
				<?php echo $this->lists['published']; ?>
			</td>
		</tr>
		
	</table>
	</fieldset>

<input type="hidden" name="option" value="com_igallery" />
<input type="hidden" name="cid" value="<?php echo $this->category->id; ?>" />
<input type="hidden" name="task" value="" />
</form>
