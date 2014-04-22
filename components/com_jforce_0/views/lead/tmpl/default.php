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
<div class='contentheading'><?php echo JText::_('Leads'); ?></div>
<div class='quickLinks'>
	<?php echo $this->newLink;?>
</div>
<div class='tabContainer2'>
			<?php
			$k=0;
	 		for($i=0; $i<count($this->leads); $i++) :
				$lead = $this->leads[$i];
				$k = 1-$k;
				
			?>
            
			<div class='row<?php echo $k; ?>'>
				<div class='logo'>
					<?php #echo $lead->image; ?>
				</div>
				<div class='personContainer'>
					<div class="listTitle">
						<a href='<?php echo JRoute::_('index.php?option=com_jforce&c=sales&view=lead&layout=lead&id='.$lead->id); ?>'>
							<?php echo $lead->firstname.' '.$lead->lastname; ?>
						</a>
					</div>
					<div class='personDetail'>
						<div class='key'><?php echo JText::_('Company'); ?></div>
                        	<?php echo $lead->company; ?>
					</div>			
					<div class='personDetail'>
						<div class='key'><?php echo JText::_('Email'); ?></div><a href='mailto:<?php echo $lead->email; ?>'><?php echo $lead->email;?></a>
					</div>								
				</div>
			</div>
   
		<?php endfor; ?>
       <div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>
		<?php echo $this->startupText; ?>
</div>