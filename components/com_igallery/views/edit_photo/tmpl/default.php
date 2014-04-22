<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<fieldset class="adminform">
<table class="admintable">
    <tr>    
    	<td class="key" valign="top">
    		<?php echo JText::_( 'DESCRIPTION' ); ?>:<br /><br />
    		<img src="<?php echo $this->host; ?>/images/stories/igallery/<?php echo $this->gallery->folder . '/thumbs/' . $this->photo->filename; ?>" alt="<?php echo $this->photo->alt_text; ?>"/>
    	</td>
        <td>
        	<textarea cols="40" rows="4" name="description" id="description" ><?php echo $this->photo->description; ?></textarea>
		</td>
   </tr>
		
</table>
</fieldset>

<input type="submit" name="save_edit_photo_submit" value="Save" style="width:85px;" /> 
<input type="submit" name="save_edit_photo_cancel" value="Cancel" style="width:60px;" />
<input type="hidden" name="option" value="com_igallery" />
<input type="hidden" name="controller" value="manage" />
<input type="hidden" name="task" value="save_edit_photo" />
<input type="hidden" name="gid" value="<?php echo $this->gallery->id ?>" />
<input type="hidden" name="cid[]" value="<?php echo $this->photo->id; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
</form>
