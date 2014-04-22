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
<form action='<?php echo $this->action ?>' method='post' name='adminForm'>
	<div class='jfAdminTitle'><?php echo $this->title; ?></div>
	<fieldset class="adminform">
    	<legend><?php echo JText::_('Details'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
			<tr>
				<td class='key'>
					<?php echo JText::_('Name'); ?></td><td>
					<input type='text' name='name' size='35' class='inputbox required' value='<?php echo $this->gateway->name;?>' />
				</td>
			</tr>
            <tr>
				<td class='key'>
					<?php echo JText::_('Published'); ?></td><td>
					<?php echo $this->lists['published']; ?>
				</td>
			</tr>
            <tr>
				<td class='key'>
					<?php echo JText::_('Default Gateway'); ?></td><td>
					<?php echo $this->lists['default']; ?>
				</td>
			</tr>
				<?php echo $this->params->render(); ?>
		</table>
</fieldset>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->gateway->id; ?>' />
<input type='hidden' name='task' value='' />
<input type='hidden' name='type' value='gateway' />
<input type='hidden' name='model' value='gateway' />
<input type='hidden' name='action' value='gateway' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive');
