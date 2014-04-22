<?php
defined('_JEXEC') or die('Restricted access');

//we dont want to repeat ourselves, so just include the backend template file
include(JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'add'.DS.'tmpl'.DS.'default.php');
?>
<br />
<input type="submit" name="new_gallery_submit" value="Save" style="width:85px;" /> 
<input type="submit" name="new_gallery_cancel" value="Cancel" style="width:60px;" />
<input type="hidden" name="option" value="com_igallery" />
<input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
<input type="hidden" name="task" value="save" />
</form>
