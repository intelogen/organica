<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			task.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<ul>
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=task&layout=form&id='.$this->task->id); ?>'><?php echo JText::_('Edit Task'); ?></a></li>	
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=task&layout=form'); ?>'><?php echo JText::_('New Task'); ?></a></li>	
</ul>

		<div>
		Cid: <?php echo $this->task->cid;?><br />
					Pid: <?php echo $this->task->pid;?><br />
					Summary: <?php echo $this->task->summary;?><br />
					Priority: <?php echo $this->task->priority;?><br />
					Duedate: <?php echo $this->task->duedate;?><br />
					Notify: <?php echo $this->task->notify;?><br />
					Completed: <?php echo $this->task->completed;?><br />
					Completedby: <?php echo $this->task->completedby;?><br />
					Completeddate: <?php echo $this->task->completeddate;?><br />
					Created: <?php echo $this->task->created;?><br />
					Modified: <?php echo $this->task->modified;?><br />
					Author: <?php echo $this->task->author;?><br />
					
		</div>	
