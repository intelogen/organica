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
			<div class='editField2'>
			<label for='firstname' class='key'><?php echo JText::_('First Name'); ?></label>
			<input type='text' name='firstname' size='30' class='inputbox' value='<?php echo $this->person->firstname;?>' />
			</div>
			<div class='editField2'>
			<label for='lastname' class='key'><?php echo JText::_('Last Name'); ?></label>
			<input type='text' name='lastname' size='30' class='inputbox' value='<?php echo $this->person->lastname;?>' />
			</div>
            <div class='editField'>
            <label for='company' class='key'><?php echo JText::_('Company'); ?></label>
            <?php echo $this->lists['company']; ?>
            </div>
			<div class='divider'></div>
            <?php if(!$this->person->id): ?>
                <div class='editField'>
                    <?php echo $this->lists['joomlausers']; ?>
                </div>
            <?php endif; ?>
            <div id="JUserBlock">
                <div class='editField2'>
                <label for='user[username]' class='key'><?php echo JText::_('Username'); ?></label>
                <input type='text' name='user[username]' size='30' class='inputbox' value='<?php echo $this->person->username;?>' />
                </div>
                <div class='editField2'>
                <label for='user[email]' class='key'><?php echo JText::_('Email Address'); ?></label>
                <input type='text' name='user[email]' size='30' class='inputbox' value='<?php echo $this->person->email;?>' />
                </div>
                <div class='editField2'>
                <label for='user[password]' class='key'><?php echo JText::_('Password'); ?></label>
                <input type='password' name='user[password]' size='30' class='inputbox' />
                </div>			
                <div class='editField2'>
                <label for='user[password2]' class='key'><?php echo JText::_('Verify Password'); ?></label>
                <input type='password' name='user[password2]' size='30' class='inputbox' />
                </div>
            </div>
			<div class='editField'>
			<label for='sysem_role' class='key'><?php echo JText::_('Access Role'); ?></label>
			<?php echo $this->lists['roles']; ?>
			</div>
			<div class='editField'>
			<label for='auto_add' class='key'><?php echo JText::_('Automatically add this person to all new projects?'); ?></label>
			<?php echo $this->lists['auto_add']; ?>
			</div>
			<div class='editField' id='projectPermissions'>
			
			</div>	
		</div>
		<div class='secondaryColumn sideBox'>		
			<div class='previewLogo' id="previewLogo">
				<?php echo $this->person->image; ?>
			</div>
			<div class='updateLogo'>
            	<?php if ($this->person->id) : ?>
					<a href='#' id="removeLink"><?php echo JText::_('Remove');?></a> / 
                    <a href='<?php echo $this->person->uploadProfileUrl; ?>' class='modal'  rel="{handler: 'iframe', size: {x: 500, y: 150}}"><?php echo JText::_('Upload'); ?></a>
                <?php else : ?>
                	<em><?php echo JText::_('Please save to upload profile image.'); ?></em>
                <?php endif; ?>
			</div>
		</div>
	</div>
	<div id="customProjectRoles">
		<?php
			echo $this->tabs->startPane('pane');
			echo $this->tabs->startPanel('General', 'tab1');
			echo $this->systemroleoptions['settings'];
			echo $this->tabs->endPanel();
			echo $this->tabs->startPanel('System', 'tab2');
			echo $this->systemroleoptions['objects']; 
			echo $this->tabs->endPanel();			
			echo $this->tabs->startPanel('Project', 'tab3');
			echo $this->projectroleoptions; 
			echo $this->tabs->endPanel();			
			echo $this->tabs->endPane();
		?>
	</div>		
	<div class='customFields'>
		<div class='title'>Custom Fields</div>
            <?php for ($i=0; $i<count($this->person->customFields); $i++) : 
				$cf = $this->person->customFields[$i];?>
			<div class='editField'>
			<label for='<?php echo $cf['label']; ?>' class='key'><?php echo $cf['label']; ?></label>
			<?php echo $cf['field']; ?>
			</div>
            <?php endfor; ?>
	</div>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='person' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' id='id' value='<?php echo $this->person->id; ?>' />
<?php if ($this->person->id) : ?>
	<input type='hidden' name='uid' id='uid' value='<?php echo $this->person->uid; ?>' />
<?php endif; ?>
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>	
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>

</div> 