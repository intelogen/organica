<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			timetracker.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<ul>
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=timetracker&layout=form&id='.$this->timetracker->id); ?>'><?php echo JText::_('Edit Timetracker'); ?></a></li>	
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=timetracker&layout=form'); ?>'><?php echo JText::_('New Timetracker'); ?></a></li>	
</ul>

		<div>
		Pid: <?php echo $this->timetracker->pid;?><br />
					Uid: <?php echo $this->timetracker->uid;?><br />
					Date: <?php echo $this->timetracker->date;?><br />
					Hours: <?php echo $this->timetracker->hours;?><br />
					Summary: <?php echo $this->timetracker->summary;?><br />
					Billable: <?php echo $this->timetracker->billable;?><br />
					Billed: <?php echo $this->timetracker->billed;?><br />
					
		</div>	