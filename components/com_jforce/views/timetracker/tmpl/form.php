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
<div class='contentheading'><?php echo JText::_('Time Tracker'); ?></div>
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
	<div class='mainColumn'>
		<div class='editField'>
        <label for='<?php echo JText::_('User'); ?>' class='key'><?php echo JText::_('User'); ?></label>
					<?php echo $this->lists['user']; ?>
		</div>
		<div class='editField'>
        <label for='<?php echo JText::_('Summary'); ?>' class='key'><?php echo JText::_('Summary'); ?></label>
			<textarea name='summary' size='50' class='inputbox'><?php echo $this->timetracker->summary;?></textarea>
    	</div>
	</div>
    <div class='secondaryColumn sideBox'>
        <div class='editField2'>
        <label for='<?php echo JText::_('Date'); ?>' class='key'><?php echo JText::_('Date'); ?></label>
			<?php echo JHTML::_('calendar', $this->timetracker->date, 'date', 'date', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'19', 'readonly'=>'readonly')); ?>
		</div>
        <div class='editField2'>
        <label for='<?php echo JText::_('Hours'); ?>' class='key'><?php echo JText::_('Hours'); ?></label>
        	<input type='text' name='hours' size='5' class='inputbox required' value='<?php echo $this->timetracker->hours;?>' />
		</div>        
        <div class='editField2'>
        <label for='<?php echo JText::_('Billable'); ?>' class='key'><?php echo JText::_('Billable'); ?></label>
        	<?php echo $this->lists['billable']; ?>
		</div>
        <div class='editField2'>
        <label for='<?php echo JText::_('Billed'); ?>' class='key'><?php echo JText::_('Billed'); ?></label>
        	<?php echo $this->lists['billed']; ?>
		</div>		
    </div>
<input type='hidden' name='pid' value='<?php echo $this->timetracker->pid;?>' />
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='timetracker' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->timetracker->id; ?>' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>
</form>

<?php echo JHTML::_('behavior.keepalive'); ?>	
</div>