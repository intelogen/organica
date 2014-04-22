<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			milestone.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
	<div class='contentheading'><?php echo JText::_('Milestone'); ?>: <?php echo $this->milestone->summary; ?></div>
	<div class='quickLinks'>
	    <?php echo $this->newMilestoneLink; ?>
	</div>	
	<div class='tabs'>
		<ul id="tabMenu">
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
<div class="tabContainer">
	<?php $k = 1; ?>
	
    <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Name'); ?></div><?php echo $this->milestone->summary; ?></div>
	
    <div class='row<?php echo $k%2; $k = 1 - $k; ?>'><div class='itemTitle'><?php echo JText::_('Posted By'); ?></div><?php echo $this->milestone->author; ?> <?php echo JText::_('on'); ?> <?php echo $this->milestone->created; ?></div>
    
	<?php if($this->milestone->status): ?>
	    <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Status'); ?></div><span id='milestoneStatus'><?php echo $this->milestone->status; ?></span></div>
	<?php endif; ?>
    
    <?php if($this->milestone->startdate): ?>
	    <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('From / To'); ?></div><?php echo $this->milestone->startdate; ?> - <?php echo $this->milestone->duedate; ?></div>
	<?php endif; ?>
    
    <?php if($this->milestone->priority): ?>
	    <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Priority'); ?></div><?php echo $this->milestone->priority; ?></div>
    <?php endif; ?>
    
    <?php if($this->milestone->assignees): ?>
	    <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Assignees'); ?></div><?php echo $this->milestone->assignees; ?></div>
	<?php endif; ?>
    
    <?php if($this->milestone->tags): ?>
	    <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Tags'); ?></div><?php echo $this->milestone->tags; ?></div>	
	<?php endif; ?>
    
    <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Add to Milestone'); ?></div>
        <a href="<?php echo $this->links['checklist']; ?>"><?php echo JText::_('Checklist'); ?></a>, 
        <a href="<?php echo $this->links['discussion']; ?>"><?php echo JText::_('Discussion'); ?></a>, 
        <a href="<?php echo $this->links['file']; ?>"><?php echo JText::_('File'); ?></a>, 
        <a href="<?php echo $this->links['ticket']; ?>"><?php echo JText::_('Ticket'); ?></a>
	</div>			
	
	<div class="notesArea">
		<div class='notesTitle'><?php echo JText::_('Notes'); ?></div>
		<?php echo $this->milestone->notes; ?>
	</div>
    
	<?php if($this->checklists): ?>
	<div class="checklistsArea">
		<h3><?php echo JText::_('Checklists'); ?></h3>
		<?php 
			for($i=0;$i<count($this->checklists); $i++) 
				{
					$k = $i%2;
					$checklist = $this->checklists[$i]; 
					echo "<div class='row".$k."'>";
					echo "<a href='".$checklist->link."'>".$checklist->summary."</a><br />";
					echo "<span class='subheading'><strong>".$checklist->openTasks."</strong> ".JText::_('open tasks of')." <strong>".$checklist->totalTasks."</strong> ".JText::_('tasks in the list')."</span>";
		 			echo "</div>";
				} 
		?>
	</div>
	<?php endif; ?>

	<?php if($this->discussions): ?>
	<div class="discussionsArea">
		<h3><?php echo JText::_('Discussions'); ?></h3>
		<?php 
			for($i=0;$i<count($this->discussions); $i++) 
				{
					$k = $i%2;
					$discussion = $this->discussions[$i]; 
					echo "<div class='row".$k."'>";
					echo "<a href='".$discussion->link."'>".$discussion->summary."</a><br />";
					echo '<div class="subheading">'.JText::_('Started by').' '.$discussion->author.' '.JText::_('in').' '.$discussion->category.'</div>';				
					echo "</div>";
		 		} 
		?>
	</div>
	<?php endif; ?>

	<?php if($this->tickets): ?>
	<div class="ticketsArea">
		<h3><?php echo JText::_('Tickets'); ?></h3>
		<?php 
			for($i=0;$i<count($this->tickets); $i++) 
				{
					$k = $i%2;
					$ticket = $this->tickets[$i]; 
            		
					echo "<div class='row".$k."'>";
					echo "<div class='listTitle'><a href=".$ticket->link."'>".$ticket->summary."</a></div>";
										
						if ($ticket->category):
							echo "<div class='subheading inline'>".JText::_('Category').': '.$ticket->category."</div>";
						endif;
						
						echo $ticket->category && $ticket->assignees ? '<div class="inline">|</div>' : '';
						
						if ($ticket->assignees) :
						echo '<div class="subheading inline">'.JText::_('Assignees').': '.$ticket->assignees.'</div>';
						endif;
					echo "</div>";
				} 
		?>
	</div>
	<?php endif; ?>

	<?php if($this->files): ?>
	<div class="filesArea">
		<h3><?php echo JText::_('Files'); ?></h3>
		<?php 
			for($i=0;$i<count($this->files); $i++) 
				{
					$file = $this->files[$i]; 
					echo $i>0 ? ', ': '';
					echo "<a href='".$file->link."'>".$file->name."</a>";
		 		} 
		?>
	</div>
	<?php endif; ?>

</div>