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
<div class='contentheading'><?php echo JText::_('Projects'); ?></div>
<div class='quickLinks'>
	<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=project&layout=form'); ?>' class='button'><?php echo JText::_('New Project'); ?></a>
</div>
<div class='tabs'>
	<ul id="tabMenu">
	<?php for($i=0;$i<count($this->statusOptions);$i++):
		$status = $this->statusOptions[$i];
	?>
      <li id="tab-<?php echo $i; ?>"><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=project&status='.$status); ?>'><?php echo JText::_($status); ?></a></li>
	<?php endfor; ?>
    </ul>
</div>
<div class='tabContainer'>
			<?php
	 		for($i=0; $i<count($this->projects); $i++) :
				$project = $this->projects[$i];
				$k = $i%2;
			?>
            
            <div class='row<?php echo $k; ?>'>
				<div class="progressHolder">
					<span class='progressBar'><?php echo $project->progressBar; ?></span>
					<span><?php echo $project->taskStatus; ?></span>
				</div>
				<div class="listLogo">
					<?php echo $project->imagethumb; ?>
				</div>
				<div class="listTitle">
					<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=project&layout=project&pid='.$project->id); ?>'><?php echo $project->name; ?></a>
				</div>
				<div class="subheading"><?php echo JText::_('Leader'); ?>: <a href='<?php echo $project->leaderUrl; ?>' ><?php echo $project->leader; ?></a></div>
				<div class="subheading"><?php echo JText::_('Client'); ?>: <a href='<?php echo $project->companyUrl; ?>' ><?php echo $project->company; ?></a></div>				
			</div>
		<?php endfor; ?>
	<div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>
	<?php echo $this->startupText; ?>
</div>