<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			leadform.php													*
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
<form action='<?php echo $this->action ?>' method='post' name='adminForm'>
<div class='quickLinks'>
			<button type='button' onclick="submitbutton('save')" class='button'>
				<?php echo JText::_('Save') ?>
			</button>
			<button type='button' onclick="submitbutton('cancel')" class='button'>
				<?php echo JText::_('Cancel') ?>
			</button>
</div>
<div class='tabContainer2'>
	<div class='mainContainer'>
			<div class='editField'>
			<label for='<?php echo JText::_('First Name'); ?>' class='key required'><?php echo JText::_('First Name'); ?></label>
			<input type='text' name='firstname' size='30' class='inputbox required' value='' />
			</div>
			<div class='editField'>
			<label for='<?php echo JText::_('Last Name'); ?>' class='key required'><?php echo JText::_('Last Name'); ?></label>
			<input type='text' name='lastname' size='30' class='inputbox required' value='' />
			</div>
			<div class='editField'>
			<label for='<?php JText::_('Company'); ?>' class='key required'><?php echo JText::_('Company'); ?></label>
			<input type='text' name='lead_company' size='30' class='inputbox required' value='' />
			</div>
				<div class='editField'>
			<label for='<?php echo JText::_('Email Address'); ?>' class='key required'><?php echo JText::_('Email Address'); ?></label>
			<input type='text' name='user[email]' size='30' class='inputbox required' value='<?php echo $this->person->email;?>' />
			</div>		
	</div>
	<div class='customFields'>
            <?php for ($i=0; $i<count($this->customFields); $i++) : 
				$cf = $this->customFields[$i];?>
			<div class='editField'>
			<label for='<?php echo $cf['label']; ?>' class='key required'><?php echo $cf['label']; ?></label>
			<?php echo $cf['field']; ?>
			</div>
            <?php endfor; ?>
	</div>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='person' />
<input type='hidden' name='uid' value='' />
<input type='hidden' name='lead' value='1' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>	
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>
</div>