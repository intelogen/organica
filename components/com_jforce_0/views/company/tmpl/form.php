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
<form action='<?php echo $this->action ?>' method='post' name='adminForm' enctype="multipart/form-data">
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
			<div class='editField'>
			<label for='name' class='key'><?php echo JText::_('Name'); ?></label>
			<input type='text' name='name' size='50' class='inputbox' value='<?php echo $this->company->name;?>' />
			</div>
			<div class='editField'>
			<label for='address' class='key'><?php echo JText::_('Address'); ?></label>
			<input type='text' name='address' size='50' class='inputbox' value='<?php echo $this->company->address;?>' />
			</div>
			<div class='editField2'>
			<label for='phone' class='key'><?php echo JText::_('Phone'); ?></label>
			<input type='text' name='phone' size='30' class='inputbox' value='<?php echo $this->company->phone;?>' />
			</div>
			<div class='editField2'>
			<label for='fax' class='key'><?php echo JText::_('Fax'); ?></label>
			<input type='text' name='fax' size='30' class='inputbox' value='<?php echo $this->company->fax;?>' />
			</div>
			<div class='editField'>
			<label for='homepage' class='key'><?php echo JText::_('Homepage'); ?></label>
			<input type='text' name='homepage' size='50' class='inputbox' value='<?php echo $this->company->homepage;?>' />
			</div>
		</div>
		<div class='secondaryColumn sideBox'>
			<div class='previewLogo' id="previewLogo">
				<?php echo $this->company->image; ?>
			</div>
			<div class='updateLogo'>
            	<?php if ($this->company->id) : ?>
					<a href='#' id="removeLink"><?php echo JText::_('Remove');?></a> / 
                    <a href='<?php echo $this->company->uploadProfileUrl; ?>' class='modal'  rel="{handler: 'iframe', size: {x: 500, y: 150}}"><?php echo JText::_('Upload'); ?></a>
                <?php else : ?>
                	<em><?php echo JText::_('Please save to upload profile image.'); ?></em>
                <?php endif; ?>
			</div>
			<div class='editField'>
			<label for='<?php echo JText::_('Owner'); ?>' class='key'><?php echo JText::_('Owner'); ?></label>
			<?php echo $this->lists['owner']; ?>
			</div>
		</div>
	</div>
	<div class='customFields'>
            <div class='title'><?php echo JText::_('Custom Fields'); ?></div>
            <?php for ($i=0; $i<count($this->company->customFields); $i++) : 
				$cf = $this->company->customFields[$i];?>
				<div class='editField'>
					<label for='<?php echo $cf['label']; ?>' class='key'><?php echo $cf['label']; ?></label>
					<?php echo $cf['field'];?>
				</div>
            <?php endfor; ?>
	</div>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='company' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' id="id" value='<?php echo $this->company->id; ?>' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>
</div>