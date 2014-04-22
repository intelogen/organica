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
			<?php if ($this->showPid) : ?>
					<div class='editField'>
            		<?php echo JText::_('Project'); ?>
					<?php echo $this->lists['projects'];?>
					</div>
			<?php endif; ?>
				<div class='editField'>					
					<label for='summary' class='key'><?php echo JText::_('Summary'); ?></label>			
					<input type='text' name='summary' size='50' class='inputbox' value='<?php echo $this->milestone->summary;?>' />
					</div>            
					<div class='editField2'>
					<label for='startdate' class='key'><?php echo JText::_('Start Date'); ?></label>			
                    <?php echo JHTML::_('calendar', $this->milestone->startdate, 'startdate', 'startdate', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19', 'readonly'=>'readonly')); ?>
					</div>
                    <div class='editField2'>
					<label for='duedate' class='key'><?php echo JText::_('Due Date'); ?></label>			
                    <?php echo JHTML::_('calendar', $this->milestone->duedate, 'duedate', 'duedate', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19', 'readonly'=>'readonly')); ?>
					</div>
					<div class='editField'>					
					<label for='notes' class='key'><?php echo JText::_('Notes'); ?></label>			
					<textarea name='notes' cols='75' rows='10'><?php echo $this->milestone->notes; ?></textarea>
					</div>
	    </div>
   		<div class='secondaryColumn sideBox'>
        	<div class='editField'>
				<label for='completed' class='key'><?php echo JText::_('Completed'); ?></label>			
					<?php echo $this->lists['completed']; ?>
			</div>
            <div class='editField'>
				<label for='priority' class='key'><?php echo JText::_('Priority'); ?></label>			
					<?php echo $this->lists['priority']; ?>
			</div>
            <div class='editField'>
				<label for='tags' class='key'><?php echo JText::_('Tags'); ?></label>			
					<input type='text' name='tags' size='35' class='inputbox' value='<?php echo $this->milestone->tags;?>' />
			</div>
            <div class='editField'>
				<label for='notify' class='key'><?php echo JText::_('Notify'); ?></label>			
					<input type="checkbox" name="notify" class="inputbox" value="1" />
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
<input type='hidden' name='model' value='milestone' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->milestone->id; ?>' />
<input type='hidden' name='task' value='' />
<?php if (!$this->showPid) : ?>
	<input type='hidden' name='pid' value='<?php echo $this->milestone->pid;?>' />
<?php endif; ?>
<?php echo JHTML::_( 'form.token' ); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
</div>