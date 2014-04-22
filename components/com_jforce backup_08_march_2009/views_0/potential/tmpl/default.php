<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			default.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<div class='contentheading'><?php echo JText::_('Potentials'); ?></div>
<div class='quickLinks'><?php echo $this->newPotentialLink; ?></div>
<div class='tabs'>

</div>
		<div class='tabContainer'>
			<?php
	 		for($i=0; $i<count($this->potentials); $i++) :
				$potential = $this->potentials[$i];
				$k = $i%2;
			?>
            
            <div class='row<?php echo $k; ?>'>
				<div class="logo">
					<?php echo $potential->read; ?>
				</div>
				<div class="listTitle">
					<a href='<?php echo $potential->link; ?>'><?php echo $potential->name; ?></a>
				</div>
				<div class="subheading"><?php echo JText::_('Started by'); ?> <?php echo $potential->author; ?></div>				
			</div>
		<?php endfor; ?>
        <div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>
        <?php echo $this->startupText; ?>
	</div>	
	
