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
<div class='contentheading'><?php echo JText::_('Checklists'); ?></div>
<div class='quickLinks'>
	<?php echo $this->newChecklistLink;?>
</div>
<div class='tabs'>
	<ul id="tabMenu">
	  <li id="tab-1"><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=checklist&pid='.$this->pid.'&status=Completed'); ?>'class='<?php echo $this->status=='Completed' ? ' active' : ''; ?>'><?php echo JText::_('Completed'); ?></a></li>
	  <li id="tab-2"><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=checklist&pid='.$this->pid); ?>' class='<?php echo $this->status ? '' : ' active'; ?>'><?php echo JText::_('Active'); ?></a></li>
	</ul>
</div>
<div class='tabContainer'>
			<?php
	 		for($i=0; $i<count($this->checklists); $i++) :
				$checklist = $this->checklists[$i];
				$k = $i%2;
			?>
            
            <div class='row<?php echo $k; ?>'>
				<div class='logo'>
					<?php echo $checklist->read; ?>
				</div>
				<div class="listTitle">
					<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=checklist&layout=checklist&pid='.$checklist->pid.'&id='.$checklist->id); ?>'>
						<?php echo $checklist->summary; ?>
					</a>
				</div>
				<div class="subheading">
					<strong><?php echo $checklist->openTasks; ?></strong> <?php echo JText::_('open tasks of'); ?> 
					<strong><?php echo $checklist->totalTasks; ?></strong> <?php echo JText::_('total tasks'); ?>
				</div>
			</div>
		<?php endfor; ?>
        <div class='pagination'>
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
        <?php echo $this->startupText; ?>
</div>