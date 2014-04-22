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
<form action='<?php echo $this->action ?>' method='post' enctype="multipart/form-data" name='adminForm'>
	<div class="mainColumn">
			<div class='editField'>
			<label for='name' class='key'><?php echo JText::_('Name'); ?></label>			
					<input type='text' name='name' size='50' class='inputbox' value='<?php echo $this->campaign->name;?>' />
			</div>
            <div class='editField2'>
			<label for='ecost' class='key'><?php echo JText::_('Estimated Cost'); ?></label>
					<input type='text' name='ecost' size='30' class='inputbox' value='<?php echo $this->campaign->ecost;?>' />
			</div>
            <div class='editField2'>
			<label for='acost' class='key'><?php echo JText::_('Actual Cost'); ?></label>
					<input type='text' name='acost' size='30' class='inputbox' value='<?php echo $this->campaign->acost;?>' />
			</div>
            <div class='editField2'>
			<label for='eresponse' class='key'><?php echo JText::_('Estimated Response'); ?></label>
					<input type='text' name='eresponse' size='30' class='inputbox' value='<?php echo $this->campaign->eresponse;?>' />
			</div>
            <div class='editField2'>
			<label for='aresponse' class='key'><?php echo JText::_('Actual Response'); ?></label>
					<input type='text' name='aresponse' size='30' class='inputbox' value='<?php echo $this->campaign->aresponse;?>' />
			</div>
			<div class='editField2'>
			<label for='erevenue' class='key'><?php echo JText::_('Estimated Revenue'); ?></label>
					<input type='text' name='erevenue' size='30' class='inputbox' value='<?php echo $this->campaign->erevenue;?>' />
			</div>
            <div class='editField2'>
			<label for='arevenue' class='key'><?php echo JText::_('Actual Revenue'); ?></label>
					<input type='text' name='arevenue' size='30' class='inputbox' value='<?php echo $this->campaign->arevenue;?>' />
			</div>
            <div class='editField2'>
			<label for='eroi' class='key'><?php echo JText::_('Estimated ROI'); ?></label>
					<input type='text' name='eroi' size='30' class='inputbox' value='<?php echo $this->campaign->eroi;?>' />
			</div>
            <div class='editField2'>
			<label for='aroi' class='key'><?php echo JText::_('Actual ROI'); ?></label>
					<input type='text' name='aroi' size='30' class='inputbox' value='<?php echo $this->campaign->aroi;?>' />
			</div>
			<div class='editField'>			
			<label for='description' class='key'><?php echo JText::_('Description'); ?></label>
					<textarea name='message' cols='35' rows='10' class='inputbox'><?php echo $this->campaign->description;?></textarea>
			</div>
	</div>
	<div class="secondaryColumn sideBox">
    		<div class='editField'>
			<label for='expectedclose' class='key'><?php echo JText::_('Expected Close'); ?></label>
                    <?php echo JHTML::_('calendar', $this->campaign->expectedclose, 'expectedclose', 'expectedclose', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19', 'readonly'=>'readonly')); ?>
			</div>
			<div class='editField'>
			<label for='type' class='key'><?php echo JText::_('Type'); ?></label>
					<input type='text' name='type' size='35' class='inputbox' value='<?php echo $this->campaign->type;?>' />
			</div>
            <div class='editField'>
			<label for='audience' class='key'><?php echo JText::_('Audience'); ?></label>
					<input type='text' name='audience' size='35' class='inputbox' value='<?php echo $this->campaign->audience;?>' />
			</div>
            <div class='editField'>
			<label for='sponsor' class='key'><?php echo JText::_('Sponsor'); ?></label>
					<input type='text' name='sponsor' size='35' class='inputbox' value='<?php echo $this->campaign->sponsor;?>' />
			</div>
            <div class='editField'>
			<label for='reach' class='key'><?php echo JText::_('Reach'); ?></label>
					<input type='text' name='reach' size='35' class='inputbox' value='<?php echo $this->campaign->reach;?>' />
			</div>
			<div class='editField'>
            <label for='file' class='key'><?php echo JText::_('Attachment'); ?></label>	
		            <input type="file" name="file[]" class="inputbox" /><br />
        	</div>
            <div class='editField1'>
				<input type="checkbox" name="notify" class="inputbox" value="1" />&nbsp;<label for='notify' class='key'><?php echo JText::_('Notify Subscribers'); ?></label>
			</div>
            <!--
        	<div id="subscriptionHolder"> 
            	<div class="assignmentTitleHolder">
					<div class="assignmentTitle"><?php echo JText::_('Subscribers');?></div>
	           	 	<div class="manageLink"><a class="modal button" href="<?php echo $this->subscriptionLink;?>" rel="{handler: 'iframe', size: {x: 600, y: 300}}"><?php echo JText::_('Manage');?></a></div>
                </div>
				<?php echo $this->subscriptionFields;?>
            </div>-->
            
	</div>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='c' value='sales' />
<input type='hidden' name='model' value='campaign' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->campaign->id; ?>' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
</div>