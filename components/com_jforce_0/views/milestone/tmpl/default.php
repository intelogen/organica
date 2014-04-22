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
<div class='contentheading'><?php echo JText::_('Milestones'); ?></div>
	<div class='quickLinks'>
		<?php echo $this->newMilestoneLink; ?>
	</div>
	<div class='tabs'>
		<ul id="tabMenu">
			<li id="tab-1"><a href='<?php echo $this->activeMilestonesLink; ?>' class='<?php echo $this->status ? '' : 'active'; ?>'><?php echo JText::_('Active'); ?></a></li>
			<li id="tab-2"><a href='<?php echo $this->completedMilestonesLink; ?>' class='<?php echo $this->status==3 ? 'active' : ''; ?>'><?php echo JText::_('Completed'); ?></a></li>
		</ul>
	</div>
<div class="tabContainer">
	<?php if($this->milestones['late']): ?>
		<h3><?php echo JText::_('Late Milestones'); ?></h3>
			<?php for($i=0;$i<count($this->milestones['late']);$i++) { 
				$milestone = $this->milestones['late'][$i];
				$k = $i%2;
			?>
				<div class="row<?php echo $k; ?>">
                <div class='milestoneLogo'>
                </div>
					<div class='milestoneTitle'><a href="<?php echo $milestone->link; ?>"><?php echo $milestone->summary; ?></a></div><div class='dateRange'><?php echo $milestone->startdate." - ".$milestone->duedate; ?></div><div class="hasTip dueDate" title="<?php echo $milestone->duedate; ?>::"><?php echo $milestone->date; ?></div>
                    <div class='subheading inline'>
                    	<?php echo JText::_('Posted By'); ?> <a href='<?php echo $milestone->authorURL; ?>'><?php echo $milestone->author; ?></a>
                    </div>
                    <?php if ($milestone->assignees) : ?>
                    	<div class="inline">|</div>
                    	<div class="subheading inline">
                        	<?php echo JText::_('Assignees').': '.$milestone->assignees; ?>
                        </div>
                    <?php endif; ?>
				</div>
			<?php } ?>
	<?php endif; ?>
	
	<?php if($this->milestones['active']): ?>
		<h3><?php echo JText::_('Upcoming Milestones'); ?></h3>
			<?php for($i=0;$i<count($this->milestones['active']);$i++) { 
				$milestone = $this->milestones['active'][$i];
				$k = $i%2;
			?>
				<div class="row<?php echo $k; ?>">
				<div class='milestoneLogo'>
                </div>
                    <div class='milestoneTitle'><a href="<?php echo $milestone->link; ?>"><?php echo $milestone->summary; ?></a></div><div class='dateRange'><?php echo $milestone->startdate." - ".$milestone->duedate; ?></div> <div class="hasTip dueDate" title="<?php echo $milestone->duedate; ?>::"><?php echo $milestone->date; ?></div>
                    <div class='subheading inline'>
                    	<?php echo JText::_('Posted By'); ?> <a href='<?php echo $milestone->authorURL; ?>'><?php echo $milestone->author; ?></a>
                    </div>
                    <?php if ($milestone->assignees) : ?>
                    	<div class="inline">|</div>
                    	<div class="inline">
                        	<?php echo JText::_('Assignees').': '.$milestone->assignees; ?>
                        </div>
                    <?php endif; ?>
				</div>
			<?php } ?>

	<?php endif; ?>
	
	<?php if($this->milestones['completed']): ?>
		<h3><?php echo JText::_('Completed Milestones'); ?></h3>
			<?php for($i=0;$i<count($this->milestones['completed']);$i++) { 
				$milestone = $this->milestones['completed'][$i];
				$k = $i%2;
			?>
				<div class="row<?php echo $k; ?>">
				<div class='milestoneLogo'>
                </div>
                	<span class='projectMilestoneTitle'><a href="<?php echo $milestone->link; ?>"><?php echo $milestone->summary; ?></a></span><span class='dateRange'><?php echo $milestone->startdate." - ".$milestone->duedate; ?></span> <div class="hasTip dueDate" title="<?php echo $milestone->datecompleted; ?>::"><?php echo $milestone->datecompleted; ?></div>
				</div>
                    <div class='subheading'>
                    	<?php echo JText::_('Posted By'); ?> <a href='<?php echo $milestone->authorURL; ?>'><?php echo $milestone->author; ?></a>
                    </div>
			<?php } ?>

	<?php endif; ?>	
	<?php echo $this->startupText; ?>
</div>