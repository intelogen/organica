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
					<?php echo JText::_('Field'); ?></td><td>
					<input type='text' name='field' size='35' class='inputbox required' value='<?php echo $this->customfield->field;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Values'); ?></td><td>
					<input type='text' name='values' size='35' class='inputbox required' value='<?php echo $this->customfield->values;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Type'); ?></td><td>
					<input type='text' name='type' size='35' class='inputbox required' value='<?php echo $this->customfield->type;?>' />
				</td>
			</tr>
		</table>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='customfield' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->customfield->id; ?>' />
<input type='hidden' name='task' value='' />
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
