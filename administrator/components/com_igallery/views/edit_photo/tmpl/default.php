<?php
defined('_JEXEC') or die('Restricted access');
$editor =& JFactory::getEditor();
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<fieldset class="adminform">
<table class="admintable">
    <tr>    
    	<td class="key" valign="top">
    		<?php echo JText::_( 'DESCRIPTION' ); ?>:<br /><br />
    		<img src="../images/stories/igallery/<?php echo $this->gallery->folder . '/thumbs/' . $this->photo->filename; ?>" 
			alt="<?php echo $this->photo->alt_text; ?>"/>
    	</td>
        <td>
			<?php echo $editor->display( 'description', $this->photo->description ,'100%', 
			'150', '40', '5' );?>
		</td>
   </tr>
   <tr>    
    	<td class="key" valign="top">
    		<?php echo JText::_( 'IMAGE LINK' ); ?>:
    	</td>
        <td valign="top">
			<input type="text" name="link" id="link" class="text_area" size="48" 
			maxlength="250" value="<?php echo $this->photo->link; ?>" />
		</td>
   </tr>
   <tr>    
    	<td class="key" valign="top">
    		<?php echo JText::_( 'IMAGE ALT TEXT' ); ?>:
    	</td>
        <td valign="top">
			<input type="text" name="alt_text" id="alt_text" class="text_area" size="48" 
			maxlength="250" value="<?php echo $this->photo->alt_text; ?>" />
		</td>
   </tr>
   <tr>
		<td valign="top" align="right" class="key">
			<?php echo JText::_( 'NEW WINDOW' ); ?>:
		</td>
		<td>
			<?php echo $this->lists['target_blank']; ?>
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
		
</table>
</fieldset>
<input type="hidden" name="task" value="" />
<input type="hidden" name="option" value="com_igallery" />
<input type="hidden" name="controller" value="manage" />
<input type="hidden" name="gid" value="<?php echo $this->gallery->id ?>" />
<input type="hidden" name="cid[]" value="<?php echo $this->photo->id; ?>" />
</form>
