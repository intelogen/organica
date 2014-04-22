<?php

/********************************************************************************
*	@package		Joomla														*
*	@subpackage		jForce, the Joomla! CRM										*
*	@version		2.0															*
*	@file			project.php													*
*	@updated		2008-01-04													*
*	@copyright		Copyright (C) 2008 - 2009 JoomPlanet. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								*
********************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<?php if($this->project->alertmessage): ?>
<div class="alertArea"><?php echo $this->project->alertmessage; ?></div>
<?php endif; ?>
<div class='contentheading'><?php echo $this->project->name; ?> <?php echo JText::_('Overview'); ?></div>

<div class='tabs'>
	<ul id="tabMenu">
      <li id="tab-1"><?php echo $this->trashLink; ?></li>
	  <li id="tab-2"><a href="<?php echo JRoute::_('index.php?option=com_jforce&view=project&layout=form&pid='.$this->project->id); ?>" class='button'><?php echo JText::_('Edit Project'); ?></a></li>
      <li id="tab-3"><a href="javascript:copyProject('<?php echo $this->project->id;?>');" class='button'><?php echo JText::_('Copy Project'); ?></a></li>
    </ul>
</div>
<div class="tabContainer">
	<div class="sideBox">
		<div class="logo">
			<?php echo $this->project->imagethumb; ?>
		</div>
		<div class="title">
			<?php echo $this->project->name; ?>
		</div>
		<div class="itemDetails">
			<?php echo $this->project->description; ?>
		</div>
		<div class='projectDetails'>
			<div class="subheading"><?php echo JText::_('Leader'); ?>:<?php echo $this->project->leader; ?></div> 
			<div class="subheading"><?php echo JText::_('Client'); ?>: <?php echo $this->project->company; ?></div>
			<div class="subheading"><?php echo JText::_('Starts On'); ?>: <?php echo $this->project->created; ?></div>
			<div class="subheading"><?php echo JText::_('Status'); ?>: <?php echo $this->project->status; ?></div>					
		</div>
		<div class="progressHolder">
			<span class='progressBar'><?php echo $this->project->progressBar; ?></span>
			<span><?php echo $this->project->taskStatus; ?></span>
		</div>		
	</div>
	<div class="moduleHeader">
		<h3><?php echo JText::_('Quick Links'); ?></h3>
		<ul class='projectLinks'>
			<li class='tasks'><a href="<?php echo '#'; ?>"><?php echo JText::_('Tasks that I am responsible for'); ?></a> <?php echo JText::_('or that I am involved in'); ?></li>
			<li class='calendar'><a href="<?php echo JRoute::_('index.php?option=com_jforce&format=raw&task=ical&pid='.$this->project->id); ?>"><?php echo JText::_('iCalendar feed'); ?></a> <?php echo JText::_('for this project so I can see all milestones and tasks in my favorite calendar application (iCal, Google Calendar, etc...)'); ?></li>
			<li class='rss'><a href="<?php echo JRoute::_('index.php?option=com_jforce&format=feed&pid='.$this->project->id); ?>"><?php echo JText::_('Recent activities as a RSS feed'); ?></a> <?php echo JText::_('so I can track changes in this project'); ?></li>
		</ul>
	</div>
	<div class="moduleHeader">
		<h3><?php echo JText::_('Late / Today Milestones'); ?></h3>

	<?php if($this->milestones['late']): ?>
			<?php for($i=0;$i<count($this->milestones['late']);$i++) { 
				$milestone = $this->milestones['late'][$i];
				$k = $i%2;
			?>
				<ul class='projectLinks'>
                <li class='milestone'>
					<div class='projectMilestoneTitle'><a href="<?php echo $milestone->link; ?>"><?php echo $milestone->summary; ?></a></div> <span class="hasTip late" title="<?php echo $milestone->duedate; ?>::"><?php echo $milestone->date; ?></span>
                </li>
				</ul>
			<?php } ?>
	<?php endif; ?>
	</div>
		<h3><?php echo JText::_('Recent Activities'); ?></h3>
	<div class="listItems">
		<?php if(count($this->latestActivity)):
				foreach($this->latestActivity as $date => $items): ?>
				<div class='dateTitle'><?php echo $date; ?></div>
			<?php if(count($items)):
					foreach($items as $item): ?>
						<div class='itemHolder'>
							<div class='itemTag <?php echo $item['type']; ?>'><?php echo $item['type']; ?></div>
							<span class='listTitle'><a href="<?php echo $item['link']; ?>" /><?php echo $item['title']; ?></a></span> <?php echo JText::_('by'); ?> <?php echo $item['author']; ?>
							<div class='itemDetails'><?php echo $item['text']; ?></div>
						</div>
				<?php
					endforeach;
				endif;
			endforeach;
		endif;
		?>
	</div>
</div>