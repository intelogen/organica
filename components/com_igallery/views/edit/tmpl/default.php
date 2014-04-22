<?php
defined('_JEXEC') or die('Restricted access');

//we are including the backend template file, so we dont repeat ourselves
include(JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'edit'.DS.'tmpl'.DS.'default.php')
?>
<br />
<input type="hidden" name="cid[]" value="<?php echo $this->gallery->id; ?>" />
<input type="submit" name="edit_gallery_submit" value="Save" style="width:85px;" /> 
<input type="submit" name="edit_gallery_cancel" value="Cancel" style="width:60px;" />
<input type="hidden" name="option" value="com_igallery" />
<input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
<input type="hidden" name="task" value="save_changes" />
</form>
