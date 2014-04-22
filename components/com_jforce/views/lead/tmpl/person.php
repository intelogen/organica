<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			person.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<div class='quickLinks'>
<a href='<?php echo JRoute::_('index.php?option=com_jforce&c=people&view=person&layout=form'); ?>' class='button'><?php echo JText::_('New Lead'); ?></a>
<?php if($this->person->lead==1): ?>
	<a href='<?php echo JRoute::_('index.php?option=com_jforce&c=people&view=modal&layout=wizard1&tmpl=component&id='.$this->person->id); ?>' class='modal button' rel="{handler: 'iframe'}">
		<?php echo JText::_('Convert Lead'); ?>
	</a>
<?php endif; ?>
</div>
<div class='tabs'>
	<ul id='tabMenu'>
		<li id="tab-0"><a href='<?php echo JRoute::_('index.php?option=com_jforce&c=people&view=person&layout=form&id='.$this->person->id); ?>' class='button'><?php echo JText::_('Edit Person'); ?></a></li>
        <li id="tab-1"><?php echo $this->trashLink; ?></li>
    </ul>
</div>
<div class='tabContainer'>
	<div class='companyArea'>
		<div class='logo'>
			<?php echo $this->person->image; ?>
		</div>
		<div class='companyDetails'>
			<div class="row1"><div class="itemTitle"><?php echo JText::_('Name'); ?></div><?php echo $this->person->name; ?></div>	
			<div class="row0"><div class="itemTitle"><?php echo JText::_('Company'); ?></div>
            	<?php if($this->person->company): ?>
            		<a href='<?php echo $this->person->companyLink; ?>'><?php echo $this->person->company; ?></a>
				<?php else: ?>
                	<?php echo $this->person->lead_company; ?>
                <?php endif; ?>
            </div>	
    		<div class="row1"><div class="itemTitle"><?php echo JText::_('Email'); ?></div><a href='mailto:<?php echo $this->person->email; ?>'><?php echo $this->person->email; ?></a></div>	
			<div class="row0"><div class="itemTitle"><?php echo JText::_('Username'); ?></div><?php echo $this->person->username; ?></div>	
			<div class="row1"><div class="itemTitle"><?php echo JText::_('System Role'); ?></div><?php echo $this->person->systemrole; ?></div>	
		</div>
	</div>
	<div class='customFields'>
		<div class='title'><?php echo JText::_('Custom Fields'); ?></div>
			<?php for ($i=0; $i<count($this->person->customFields); $i++) : 
				$cf = $this->person->customFields[$i]; ?>
				<div class='editField'>
					<label for='<?php echo $cf['label']; ?>' class='key' ><?php echo $cf['label']; ?></label>
					<?php echo $cf['field'];?>
				</div>
            <?php endfor; ?>
	
	</div>
</div>	
