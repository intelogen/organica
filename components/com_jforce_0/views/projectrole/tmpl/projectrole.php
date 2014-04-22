<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			projectrole.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<ul>
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=projectrole&layout=form&id='.$this->projectrole->id); ?>'><?php echo JText::_('Edit Projectrole'); ?></a></li>	
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=projectrole&layout=form'); ?>'><?php echo JText::_('New Projectrole'); ?></a></li>	
</ul>

		<div>
		Uid: <?php echo $this->projectrole->uid;?><br />
					Name: <?php echo $this->projectrole->name;?><br />
					Milestone: <?php echo $this->projectrole->milestone;?><br />
					Checklist: <?php echo $this->projectrole->checklist;?><br />
					Timerecord: <?php echo $this->projectrole->timerecord;?><br />
					File: <?php echo $this->projectrole->file;?><br />
					Tickets: <?php echo $this->projectrole->tickets;?><br />
					Discussions: <?php echo $this->projectrole->discussions;?><br />
					Created: <?php echo $this->projectrole->created;?><br />
					Modified: <?php echo $this->projectrole->modified;?><br />
					Author: <?php echo $this->projectrole->author;?><br />
					
		</div>	
