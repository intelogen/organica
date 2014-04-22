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
					<?php echo JText::_('Uid'); ?></td><td>
					<input type='text' name='uid' size='35' class='inputbox required' value='<?php echo $this->projectrole->uid;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Name'); ?></td><td>
					<input type='text' name='name' size='35' class='inputbox required' value='<?php echo $this->projectrole->name;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Milestone'); ?></td><td>
					<input type='text' name='milestone' size='35' class='inputbox required' value='<?php echo $this->projectrole->milestone;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Checklist'); ?></td><td>
					<input type='text' name='checklist' size='35' class='inputbox required' value='<?php echo $this->projectrole->checklist;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Timerecord'); ?></td><td>
					<input type='text' name='timerecord' size='35' class='inputbox required' value='<?php echo $this->projectrole->timerecord;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('File'); ?></td><td>
					<input type='text' name='file' size='35' class='inputbox required' value='<?php echo $this->projectrole->file;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Tickets'); ?></td><td>
					<input type='text' name='tickets' size='35' class='inputbox required' value='<?php echo $this->projectrole->tickets;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Discussions'); ?></td><td>
					<input type='text' name='discussions' size='35' class='inputbox required' value='<?php echo $this->projectrole->discussions;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Created'); ?></td><td>
					<input type='text' name='created' size='35' class='inputbox required' value='<?php echo $this->projectrole->created;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Modified'); ?></td><td>
					<input type='text' name='modified' size='35' class='inputbox required' value='<?php echo $this->projectrole->modified;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Author'); ?></td><td>
					<input type='text' name='author' size='35' class='inputbox required' value='<?php echo $this->projectrole->author;?>' />
				</td>
			</tr>
		</table>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='projectrole' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->projectrole->id; ?>' />
<input type='hidden' name='task' value='' />
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
