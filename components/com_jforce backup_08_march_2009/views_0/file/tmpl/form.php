<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			form.php														*
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
<h1><?php echo $this->title; ?></h1>
<form action='<?php echo $this->action ?>' method='post' name='adminForm'>
<table class='adminform' width='100%'>
<tr>
	<td>
			<button type='button' onclick="submitbutton('save')">
				<?php echo JText::_('Save') ?>
			</button>
			<button type='button' onclick="submitbutton('cancel')">
				<?php echo JText::_('Cancel') ?>
			</button>
	</td>
</tr>
</table>
<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
			<tr>
				<td class='key'>
					<?php echo JText::_('Filelocation'); ?></td><td>
					<input type='text' name='filelocation' size='35' class='inputbox required' value='<?php echo $this->file->filelocation;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Filetype'); ?></td><td>
					<input type='text' name='filetype' size='35' class='inputbox required' value='<?php echo $this->file->filetype;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Filesize'); ?></td><td>
					<input type='text' name='filesize' size='35' class='inputbox required' value='<?php echo $this->file->filesize;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Name'); ?></td><td>
					<input type='text' name='name' size='35' class='inputbox required' value='<?php echo $this->file->name;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Description'); ?></td><td>
					<input type='text' name='description' size='35' class='inputbox required' value='<?php echo $this->file->description;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Visibility'); ?></td><td>
					<input type='text' name='visibility' size='35' class='inputbox required' value='<?php echo $this->file->visibility;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Category'); ?></td><td>
					<input type='text' name='category' size='35' class='inputbox required' value='<?php echo $this->file->category;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Milestone'); ?></td><td>
					<input type='text' name='milestone' size='35' class='inputbox required' value='<?php echo $this->file->milestone;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Checklist'); ?></td><td>
					<input type='text' name='checklist' size='35' class='inputbox required' value='<?php echo $this->file->checklist;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Discussion'); ?></td><td>
					<input type='text' name='discussion' size='35' class='inputbox required' value='<?php echo $this->file->discussion;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Comment'); ?></td><td>
					<input type='text' name='comment' size='35' class='inputbox required' value='<?php echo $this->file->comment;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Tags'); ?></td><td>
					<input type='text' name='tags' size='35' class='inputbox required' value='<?php echo $this->file->tags;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Notify'); ?></td><td>
					<input type='text' name='notify' size='35' class='inputbox required' value='<?php echo $this->file->notify;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Version'); ?></td><td>
					<input type='text' name='version' size='35' class='inputbox required' value='<?php echo $this->file->version;?>' />
				</td>
			</tr>
		</table>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='file' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->file->id; ?>' />
<input type='hidden' name='task' value='' />
<input type='hidden' name='pid' value='<?php echo $this->file->pid;?>' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
