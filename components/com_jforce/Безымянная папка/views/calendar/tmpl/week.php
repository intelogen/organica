<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			week.php														*
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
					<input type='text' name='uid' size='35' class='inputbox required' value='<?php echo $this->person->uid;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Cid'); ?></td><td>
					<input type='text' name='cid' size='35' class='inputbox required' value='<?php echo $this->person->cid;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Address'); ?></td><td>
					<input type='text' name='address' size='35' class='inputbox required' value='<?php echo $this->person->address;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Role'); ?></td><td>
					<input type='text' name='role' size='35' class='inputbox required' value='<?php echo $this->person->role;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Office_phone'); ?></td><td>
					<input type='text' name='office_phone' size='35' class='inputbox required' value='<?php echo $this->person->office_phone;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Im'); ?></td><td>
					<input type='text' name='im' size='35' class='inputbox required' value='<?php echo $this->person->im;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Image'); ?></td><td>
					<input type='text' name='image' size='35' class='inputbox required' value='<?php echo $this->person->image;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Auto_add'); ?></td><td>
					<input type='text' name='auto_add' size='35' class='inputbox required' value='<?php echo $this->person->auto_add;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Created'); ?></td><td>
					<input type='text' name='created' size='35' class='inputbox required' value='<?php echo $this->person->created;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Modified'); ?></td><td>
					<input type='text' name='modified' size='35' class='inputbox required' value='<?php echo $this->person->modified;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Author'); ?></td><td>
					<input type='text' name='author' size='35' class='inputbox required' value='<?php echo $this->person->author;?>' />
				</td>
			</tr>
		</table>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='person' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->person->id; ?>' />
<input type='hidden' name='task' value='' />
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
