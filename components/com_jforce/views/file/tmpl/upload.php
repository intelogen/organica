<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			upload.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<script language='javascript' type='text/javascript'>
<!--
function submitbutton(pressbutton) {
	var form = document.adminForm;
	form.task.value=pressbutton;
	form.submit();
}
//-->
</script>
<div class='contentheading'><?php echo $this->title; ?></div>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
<div class='quickLinks'>
		<button type='button' onclick="submitbutton('uploadFiles')" class='button'>
			<?php echo JText::_('Save') ?>
		</button>
		<button type='button' onclick="submitbutton('cancel')" class='button'>
			<?php echo JText::_('Cancel') ?>
		</button>
</div>
<div class='tabContainer2'>
	<div class='mainContainer'>
	<div class='mainColumn'>
        <div class='editField'>
            <label for='<?php echo JText::_('Milestone'); ?>' class='key'><?php echo JText::_('Milestone'); ?></label>
            <?php echo $this->lists['milestones'];?>
        </div>
        <div class='editField'>
            <label for='<?php echo JText::_('Category'); ?>' class='key'><?php echo JText::_('Category'); ?></label>
            <?php echo $this->lists['category']; ?>
        </div>
    </div>
    <div class='secondaryColumn sideBox'>
        <div class='editField'>
            <label for='<?php echo JText::_('Visibility'); ?>' class='key'><?php echo JText::_('Visibility'); ?></label>
            <?php echo $this->lists['visibility']; ?>
        </div>     
        <div class='editField'>
        	<label for='<?php echo JText::_('Tags'); ?>' class='key'><?php echo JText::_('Tags'); ?></label>
            <input type="text" name="tags" class="inputbox" size="35" />  
        </div>
	</div>
   </div>
   <div class='notesArea'>
    	<div class='editField2'>
			<label for='<?php echo JText::_('File');?>' class='key'><?php echo JText::_('File'); ?></label>
        	<input type="file" name="file[]" class="inputbox" />
        </div>
        <div class='editField2'>
			<label for='<?php echo JText::_('Description');?>' class='key'><?php echo JText::_('Description'); ?></label>        
        	<input type="text" name="description[]" class="inputbox" size="35" />
		</div>
	</div>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='task' value='' />
<input type='hidden' name='pid' value='<?php echo $this->pid;?>' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>
</div>