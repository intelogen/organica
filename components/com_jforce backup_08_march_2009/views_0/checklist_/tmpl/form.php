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
<div class="tabContainer2">
<form action='<?php echo $this->action ?>' method='post' name='adminForm'>
	<div class="mainColumn">
			<div class='editField'>
			<label for='summary' class='key'><?php echo JText::_('Summary'); ?></label>			
					<input type='text' name='summary' size='50' class='inputbox' value='<?php echo $this->checklist->summary;?>' />
			</div>
			<div class='editField'>			
			<label for='description' class='key'><?php echo JText::_('Description'); ?></label>
					<textarea name='description' cols='35' rows='10' class='inputbox'><?php echo $this->checklist->description;?></textarea>
			</div>
	</div>
	<div class="secondaryColumn sideBox">
    		<?php if ($this->privateAccess) : ?>
				<div class='editField'>
				<label for='visibility' class='key'><?php echo JText::_('Visibility'); ?></label>
						<?php echo $this->lists['visibility']; ?>
				</div>
            <?php endif; ?>
			<div class='editField'>
			<label for='milestone' class='key'><?php echo JText::_('Milestone'); ?></label>
					<?php echo $this->lists['milestones']; ?>
			</div>
			<div class='editField'>
			<label for='tags' class='key'><?php echo JText::_('Tags'); ?></label>
					<input type='text' name='tags' size='35' class='inputbox' value='<?php echo $this->checklist->tags;?>' />
			</div>
			<div class='editField'>
			<label for='completed' class='key'><?php echo JText::_('Completed'); ?></label>
					<?php echo $this->lists['completed']; ?>
			</div>
	        <div id="subscriptionHolder"> 
            	<div class="assignmentTitleHolder">
					<div class="assignmentTitle"><?php echo JText::_('Subscribers');?></div>
	           	 	<div class="manageLink"><a class="modal button" href="<?php echo $this->subscriptionLink;?>" rel="{handler: 'iframe', size: {x: 600, y: 300}}"><?php echo JText::_('Manage');?></a></div>
                </div>
				<?php echo $this->subscriptionFields;?>
            </div>
    </div>
	
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='checklist' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->checklist->id; ?>' />
<input type='hidden' name='pid' value='<?php echo $this->checklist->pid; ?>' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
</div>