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
<div class='contentheading'><?php echo JText::_('Campaigns'); ?></div>
<div class='quickLinks'><?php echo $this->newCampaignLink; ?></div>
<div class='tabs'>
	<?php echo $this->categorylist; ?>
</div>
		<div class='tabContainer'>
			<?php
	 		for($i=0; $i<count($this->campaigns); $i++) :
				$campaign = $this->campaigns[$i];
				$k = $i%2;
			?>
            
            <div class='row<?php echo $k; ?>'>
				<div class="lastPost">
					<span class='itemDetails'><?php #echo $campaign->lastPost; ?> <?php #echo JText::_('by'); ?> <a href="#"><?php #echo $campaign->lastPostAuthor; ?></a></span>
				</div>
                <div class="numPosts"><?php #echo $campaign->numPosts; ?> <?php echo JText::_('Posts'); ?></div>
				<div class="logo">
					<?php echo $campaign->read; ?>
				</div>
				<div class="listTitle">
					<a href='<?php echo $campaign->link; ?>'><?php echo $campaign->name; ?></a>
				</div>
				<div class="subheading"><?php echo JText::_('Started by'); ?> <?php echo $campaign->author; ?> <?php #echo JText::_('in'); ?> <?php #echo $campaign->category; ?></div>				
			</div>
		<?php endfor; ?>
        <div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>
        <?php echo $this->startupText; ?>
	</div>	
	
