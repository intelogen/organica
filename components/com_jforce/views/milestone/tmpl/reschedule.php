<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			reshedule.php													*
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
<div class='quickLinks'>
		<button type='button' onclick="submitbutton('save')" class='button'>
			<?php echo JText::_('Save') ?>
		</button>
		<button type='button' onclick="submitbutton('cancel')" class='button'>
			<?php echo JText::_('Cancel') ?>
		</button>
</div>
<div class='tabContainer2'>
<form action='<?php echo $this->action ?>' method='post' name='adminForm'>
		<div class='mainColumn'>
					<div class='editField2'>
					<label for='<?php echo JText::_('Start Date'); ?>' class='key required'><?php echo JText::_('Start Date'); ?></label>			
                    <?php echo JHTML::_('calendar', $this->milestone->startdate, 'startdate', 'startdate', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19', 'readonly'=>'readonly')); ?>
					</div>
                    <div class='editField2'>
					<label for='<?php echo JText::_('Due Date'); ?>' class='key required'><?php echo JText::_('Due Date'); ?></label>			
                    <?php echo JHTML::_('calendar', $this->milestone->duedate, 'duedate', 'duedate', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19', 'readonly'=>'readonly')); ?>
					</div>
	    </div>
        <div class='allMilestones'>

        </div>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='milestone' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->milestone->id; ?>' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
</div>