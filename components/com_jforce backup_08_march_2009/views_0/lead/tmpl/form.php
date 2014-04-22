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
		<div class="mainColumn">
			<div class="editField2">
			<label for="firstname" class="key"><?php echo JText::_("First Name"); ?></label>
			<input type="text" name="firstname" size="30" class="inputbox" value="<?php echo $this->lead->firstname;?>" />
			</div>
			<div class="editField2">
			<label for="lastname" class="key"><?php echo JText::_("Last Name"); ?></label>
			<input type="text" name="lastname" size="30" class="inputbox" value="<?php echo $this->lead->lastname;?>" />
			</div>
			<div class="editField">
			<label for="company" class="key"><?php echo JText::_("Company"); ?></label>
			<input type="text" name="company" size="30" class="inputbox" value="<?php echo htmlspecialchars($this->lead->company);?>" />
			</div>
			
			<div class="editField2">
			<label for="email" class="key"><?php echo JText::_("Email"); ?></label>
			<input type="text" name="email" size="30" class="inputbox" value="<?php echo $this->lead->email;?>" />
			</div>
			<div class="editField2">
			<label for="office_phone" class="key"><?php echo JText::_("Office Phone"); ?></label>
			<input type="text" name="office_phone" size="30" class="inputbox" value="<?php echo $this->lead->office_phone;?>" />
			</div>
            <div class="editField2">
			<label for="home_phone" class="key"><?php echo JText::_("Home Phone"); ?></label>
			<input type="text" name="home_phone" size="30" class="inputbox" value="<?php echo $this->lead->home_phone;?>" />
			</div>
            <div class="editField2">
			<label for="cell_phone" class="key"><?php echo JText::_("Cell Phone"); ?></label>
			<input type="text" name="cell_phone" size="30" class="inputbox" value="<?php echo $this->lead->cell_phone;?>" />
			</div>
			<div class="editField2">
			<label for="status" class="key"><?php echo JText::_("Status"); ?></label>
			<?php echo $this->lists['status']; ?>
			</div>	
		</div>
	<div class='customFields secondaryColumn sideBox'>
            <?php for ($i=0; $i<count($this->lead->customFields); $i++) : 
				$cf = $this->lead->customFields[$i];?>
			<div class='editField'>
			<label for='<?php echo $cf['name']; ?>' class='key'><?php echo $cf['label']; ?></label>
			<?php echo $cf['field']; ?>
			</div>
            <?php endfor; ?>
	</div>
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