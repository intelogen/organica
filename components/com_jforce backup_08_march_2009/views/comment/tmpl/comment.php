<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			comment.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<ul>
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=comment&layout=form&id='.$this->comment->id); ?>'><?php echo JText::_('Edit Comment'); ?></a></li>	
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=comment&layout=form'); ?>'><?php echo JText::_('New Comment'); ?></a></li>	
</ul>

		<div>
		Discussion: <?php echo $this->comment->discussion;?><br />
					File: <?php echo $this->comment->file;?><br />
					Pid: <?php echo $this->comment->pid;?><br />
					Message: <?php echo $this->comment->message;?><br />
					Created: <?php echo $this->comment->created;?><br />
					Modified: <?php echo $this->comment->modified;?><br />
					Author: <?php echo $this->comment->author;?><br />
					
		</div>	
