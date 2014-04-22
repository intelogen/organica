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
			<label for='firstname' class='key'><?php echo JText::_('First Name'); ?></label>
			<input type='text' name='firstname' size='30' class='inputbox' value='' />
			</div>
			<div class='editField'>
			<label for='lastname' class='key'><?php echo JText::_('Last Name'); ?></label>
			<input type='text' name='lastname' size='30' class='inputbox' value='' />
			</div>
			<div class='editField'>
			<label for='company' class='key'><?php echo JText::_('Company'); ?></label>
			<input type='text' name='company' size='30' class='inputbox' value='' />
			</div>
				<div class='editField'>
			<label for='email' class='key'><?php echo JText::_('Email Address'); ?></label>
			<input type='text' name='email' size='30' class='inputbox' value='<?php echo $this->lead->email;?>' />
			</div>		
	</div>
	<div class='customFields'>
            <?php for ($i=0; $i<count($this->customFields); $i++) : 
				$cf = $this->customFields[$i];?>
			<div class='editField'>
			<label for='<?php echo $cf['name']; ?>' class='key'><?php echo $cf['label']; ?></label>
			<?php echo $cf['field']; ?>
			</div>
            <?php endfor; ?>
	</div>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='c' value='sales' />
<input type='hidden' name='model' value='lead' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' id='id' value='<?php echo $this->lead->id; ?>' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>	
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>
</div>