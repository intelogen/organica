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
<div class='contentheading'><?php echo $this->title; ?></div>

<form action='<?php echo $this->action ?>' method='post' name='adminForm' enctype="multipart/form-data">
	<div class="mainColumn" style="background-color:#FAFAFA;border:1px solid #DDD;padding:10px;width:auto;">
			<div class='editField'>
			<label for='<?php echo JText::_('Name'); ?>' class='key'><?php echo JText::_('Name'); ?></label>
			<input type='text' name='name' size='50' class='inputbox' value='<?php echo $this->project->name;?>' />
			</div>
            
            <div class='editField'>
            <label for='<?php echo JText::_('Status'); ?>' class='key'><?php echo JText::_('Status'); ?></label>
            <?php echo $this->lists['status']; ?>            
            </div>
            <div class='editField'>
            <label for'<?php echo JText::_('Starts On'); ?>' class='key'><?php echo JText::_('Starts On'); ?></label>
            <?php echo JHTML::_('calendar', $this->project->startson, 'startson', 'startson', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'19', 'readonly'=>'readonly')); ?>
            </div>
            <div class='editField'>
            <label for='<?php echo JText::_('Alert Message'); ?>' class='key'><?php echo JText::_('Alert Message'); ?></label>
            <input type='text' name='alertmessage' class='inputbox' value='<?php echo $this->project->alertmessage;?>' size='35'/>
            </div>
            
            
            <div class='editField'>
                <button type='button' onclick="submitbutton('save')" class='button'>
                    <?php echo JText::_('Save') ?>
                </button>
                <button type='button' onclick="submitbutton('cancel')" class='button'>
                    <?php echo JText::_('Cancel') ?>
                </button>
            </div>
            
            <?php
            /** JTPL HACK
			
            
            <div class='editField'>			
			<label for='<?php echo JText::_('Description'); ?>' class='key'><?php echo JText::_('Description'); ?></label>
			<textarea name='description' style="width: 400px;height: 50%;"><?php echo $this->project->description; ?></textarea>
			</div>
            
            **/
            ?>
	</div>
        
            <?php
            /** 
            * JTPL HACK
            * 
            * 
            * 

    <div class="secondaryColumn sideBox">
            
            <div class='editField'>
			<label for='<?php echo JText::_('Client'); ?>' class='key'><?php echo JText::_('Client'); ?></label>
			<?php echo $this->lists['company']; ?>
			 </div>
             
             
            
			<div class='editField'>
			<label for='<?php echo JText::_('Leader'); ?>' class='key'><?php echo JText::_('Leader'); ?></label>
            
			<?php echo $this->lists['leader']; ?>
			 </div>		              
             
			 <div class='editField'>
			<label for='<?php echo JText::_('Status'); ?>' class='key'><?php echo JText::_('Status'); ?></label>
			<?php echo $this->lists['status']; ?>            
			</div>
			<div class='editField'>
			<label for'<?php echo JText::_('Starts On'); ?>' class='key'><?php echo JText::_('Starts On'); ?></label>
			<?php echo JHTML::_('calendar', $this->project->startson, 'startson', 'startson', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'19', 'readonly'=>'readonly')); ?>
			</div>
			<div class='editField'>
			<label for='<?php echo JText::_('Alert Message'); ?>' class='key'><?php echo JText::_('Alert Message'); ?></label>
			<input type='text' name='alertmessage' class='inputbox' value='<?php echo $this->project->alertmessage;?>' size='35'/>
			</div>
	</div>
            
                         **/
             ?>



				
		<input type='hidden' name='option' value='com_jforce' />
		<input type='hidden' name='model' value='project' />
		<input type='hidden' name='ret' value='<?php JRoute::_("index.php?") ?>' />
		<input type='hidden' name='id' value='<?php echo $this->project->id; ?>' />
		<input type='hidden' name='task' value='' />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php echo JHTML::_('behavior.keepalive'); ?>	