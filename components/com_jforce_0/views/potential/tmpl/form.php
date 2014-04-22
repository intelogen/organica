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
					<input type='text' name='name' size='50' class='inputbox' value='<?php echo $this->potential->name;?>' />
			</div>
            <div class='editField'>
            <label for='sourcetype' class='key'><?php echo JText::_('Source Type'); ?></label>
            	<?php echo $this->lists['sourcetype']; ?>
            </div>
			<div class='editField' id='leadfield'>
			<label for='lead' class='key'><?php echo JText::_('Lead'); ?></label>
					<?php echo $this->lists['leads']; ?>
			</div>
			<div class='editField' id='companyfield'>
			<label for='company' class='key'><?php echo JText::_('Company'); ?></label>
					<?php echo $this->lists['company']; ?>
			</div>            
			<div class='editField'>
			<label for='nextstep' class='key'><?php echo JText::_('Next Step'); ?></label>			
					<input type='text' name='nextstep' size='50' class='inputbox' value='<?php echo $this->potential->nextstep;?>' />
			</div>           
			<div class='editField'>			
			<label for='description' class='key'><?php echo JText::_('Description'); ?></label>
					<textarea name='description' cols='35' rows='10' class='inputbox'><?php echo $this->potential->description;?></textarea>
			</div>                                    
	</div>
	<div class="secondaryColumn sideBox">
			<div class='editField'>
			<div class='editField'>
			<label for='amount' class='key'><?php echo JText::_('Amount'); ?></label>
					<input type='text' name='amount' size='10' class='inputbox' value='<?php echo $this->potential->amount;?>' />
			</div>                
			<label for='campaign' class='key'><?php echo JText::_('Campaign'); ?></label>
					<?php echo $this->lists['campaign']; ?>
			</div>
			<div class='editField'>
			<label for='salesstage' class='key'><?php echo JText::_('Sales Stage'); ?></label>
					<?php echo $this->lists['salesstage']; ?>
			</div>            
			<div class='editField'>
			<label for='closedate' class='key'><?php echo JText::_('Close Date'); ?></label>
                    <?php echo JHTML::_('calendar', $this->potential->closedate, 'closedate', 'closedate', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'15',  'maxlength'=>'19', 'readonly'=>'readonly')); ?>
			</div>            
			<div class='editField'>
			<label for='probability' class='key'><?php echo JText::_('Probability'); ?></label>
					<?php echo $this->lists['probability']; ?>
			</div>            
                                
            <?php if ($this->privateAccess) : ?>
			<div class='editField1'>
			<label for='visibility' class='key'><?php echo JText::_('Visibility'); ?></label>
					<?php echo $this->lists['visibility']; ?>
			</div>
            <?php endif; ?>
			<div class='editField'>
			<label for='tags' class='key'><?php echo JText::_('Tags'); ?></label>
					<input type='text' name='tags' size='35' class='inputbox' value='<?php echo $this->potential->tags;?>' />
			</div>
			<div class='editField'>
            <label for='file' class='key'><?php echo JText::_('Attachment'); ?></label>	
		            <input type="file" name="file[]" class="inputbox" /><br />
        	</div>
            <div class='editField'>
				<label for='notify' class='key'><?php echo JText::_('Notify'); ?></label>			
					<input type="checkbox" name="notify" class="inputbox" value="1" />
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
<input type='hidden' name='model' value='potential' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->potential->id; ?>' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
</div>