<?php

/********************************************************************************
*	@package		Joomla														*
*	@subpackage		jForce, the Joomla! CRM										*
*	@version		2.0															*
*	@file			checklist.php												*
*	@updated		2008-12-15													*
*	@copyright		Copyright (C) 2008 - 2009 JoomPlanet. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								*
********************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>

<div class='contentheading'><?php echo JText::_('My Tasks'); ?></div>

<div class="tabContainer2">
			<?php
	 		for($i=0; $i<count($this->tasks); $i++) :
				$task = $this->tasks[$i];
				$k = $i%2;
			?>
						<div class='row<?php echo $k; ?>' id="task_<?php echo $task->id; ?>">
							<div class='itemButtons'><?php echo $task->buttons; ?></div>
							<div class='listTitle'><a href='<?php echo $task->link; ?>'><?php echo $task->summary; ?></a></div>
							<?php if ($task->duedate) : ?>
	                            <div class="inline"><div class="hasTip" title="<?php echo $task->duedate; ?>::"><?php echo $task->date; ?></div></div>
                            <?php endif; ?>
                            <?php echo $task->duedate && $task->assignees ? '<div class="inline">|</div>' : ''; ?>
                            <?php if ($task->assignees) : ?>
                            	<div class="inline"><?php echo JText::_('Assignees').': '.$task->assignees; ?></div>
                            <?php endif; ?>
						</div>
			<?php endfor; ?>
	</div>	
