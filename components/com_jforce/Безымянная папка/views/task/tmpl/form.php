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
<div class="contentheading"><?php echo $this->title; ?></div>
<div class="quickLinks">
	<button type='button' onclick="submitbutton('save')" class='button'>
		<?php echo JText::_('Save') ?>
	</button>
	<button type='button' onclick="submitbutton('cancel')" class='button'>
		<?php echo JText::_('Cancel') ?>
	</button>
</div>
<div class="tabContainer2">
<form action='<?php echo $this->action ?>' method='post' name='adminForm'>
	<div class="mainColumn">
			<div class='editField'>
			<label for='summary' class='key required'><?php echo JText::_('Summary'); ?></label>			
					<input type='text' name='summary' size='50' class='inputbox required' value='<?php echo $this->task->summary;?>' />
			</div>
			<div class='editField2'>			
			<label for='priority' class='key'><?php echo JText::_('Priority'); ?></label>
					<?php echo $this->lists['priority'];?>
			</div>
			<div class='editField2'>
			<label for='duedate' class='key required'><?php echo JText::_('Due Date'); ?></label>
					<?php echo JHTML::_('calendar', $this->task->duedate, 'duedate', 'duedate', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'19', 'readonly'=>'readonly')); ?>
			</div>
	</div>
	<div class="secondaryColumn sideBox">
			<div class='editField'>
			<label for='completed' class='key'><?php echo JText::_('Completed'); ?></label>
					<?php echo $this->lists['completed']; ?>
			</div>
            <div class='editField'>
			<label for='notify' class='key'><?php echo JText::_('Notify'); ?></label>
					<input type="checkbox" name="notify" class="inputbox" value="1"  />
			</div>
            <div id="assignmentHolder">
            	<div class="assignmentTitleHolder">
					<div class="assignmentTitle"><?php echo JText::_('Assignees'); ?></div>
	            	<div class="manageLink"><a class="modal button" href="<?php echo $this->assignmentLink;?>" rel="{handler: 'iframe', size: {x: 600, y: 300}}"><?php echo JText::_('Manage');?></a></div>
                </div>
				<?php echo $this->assignmentFields;?>
            </div>
            <hr />
            <div id="subscriptionHolder"> 
            	<div class="assignmentTitleHolder">
					<div class="assignmentTitle"><?php echo JText::_('Subscribers');?></div>
	           	 	<div class="manageLink"><a class="modal button" href="<?php echo $this->subscriptionLink;?>" rel="{handler: 'iframe', size: {x: 600, y: 300}}"><?php echo JText::_('Manage');?></a></div>
                </div>
				<?php echo $this->subscriptionFields;?>
            </div>
	</div>
	
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='task' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->task->id; ?>' />
<input type='hidden' name='pid' value='<?php echo $this->task->pid; ?>' />
<input type='hidden' name='cid' value='<?php echo $this->task->cid; ?>' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
</div>