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
					<input type='text' name='uid' size='35' class='inputbox required' value='<?php echo $this->report->uid;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Name'); ?></td><td>
					<input type='text' name='name' size='35' class='inputbox required' value='<?php echo $this->report->name;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Description'); ?></td><td>
					<input type='text' name='description' size='35' class='inputbox required' value='<?php echo $this->report->description;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Search'); ?></td><td>
					<input type='text' name='search' size='35' class='inputbox required' value='<?php echo $this->report->search;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Created'); ?></td><td>
					<input type='text' name='created' size='35' class='inputbox required' value='<?php echo $this->report->created;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Lastrun'); ?></td><td>
					<input type='text' name='lastrun' size='35' class='inputbox required' value='<?php echo $this->report->lastrun;?>' />
				</td>
			</tr>
		</table>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='report' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->report->id; ?>' />
<input type='hidden' name='task' value='' />
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
