<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			lead.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<div class='quickLinks'>
<a href='<?php echo JRoute::_('index.php?option=com_jforce&c=people&view=lead&layout=form'); ?>' class='button'><?php echo JText::_('New Lead'); ?></a>
<!--<a href='<?php echo JRoute::_('index.php?option=com_jforce&c=people&view=modal&layout=wizard1&tmpl=component&id='.$this->lead->id); ?>' class='modal button' rel="{handler: 'iframe'}">
	<?php echo JText::_('Convert Lead'); ?>
</a>-->
</div>
<div class='tabs'>
	<ul id='tabMenu'>
		<?php for($i=0;$i<count($this->tabMenu);$i++):
                    $tab = $this->tabMenu[$i]; 
                    if(!$tab['Link']): ?>
    	                <li id='tab-<?php echo $i; ?>'><?php echo $tab['Text']; ?></li>
					<?php else: ?>
        	            <li id='tab-<?php echo $i; ?>'><a href='<?php echo $tab['Link']; ?>' <?php echo $tab['Options']; ?>><?php echo $tab['Text']; ?></a></li>
            	<?php endif;
			endfor; ?>
    </ul>
</div>
<div class='tabContainer'>
	<div class='companyArea'>
		<div class='companyDetails'>
			<div class="row1"><div class="itemTitle"><?php echo JText::_('Name'); ?></div><?php echo $this->lead->firstname.' '.$this->lead->lastname; ?></div>	
			<div class="row0"><div class="itemTitle"><?php echo JText::_('Company'); ?></div>
               	<?php echo $this->lead->company; ?>
            </div>	
    		<div class="row1"><div class="itemTitle"><?php echo JText::_('Email'); ?></div><a href='mailto:<?php echo $this->lead->email; ?>'><?php echo $this->lead->email; ?></a></div>	
		</div>
	</div>
	<div class='customFields'>
		<div class='title'><?php echo JText::_('Custom Fields'); ?></div>
			<?php for ($i=0; $i<count($this->lead->customFields); $i++) : 
				$cf = $this->lead->customFields[$i]; ?>
				<div class='editField'>
					<label for='<?php echo $cf['label']; ?>' class='key' ><?php echo $cf['label']; ?></label>
					<?php echo $cf['field'];?>
				</div>
            <?php endfor; ?>
	
	</div>
</div>	
