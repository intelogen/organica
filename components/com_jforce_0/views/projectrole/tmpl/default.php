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
<ul>
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=projectrole&layout=form'); ?>'><?php echo JText::_('New Projectrole'); ?></a></li>	
</ul>

		<div>
			<?php
	 		for($i=0; $i<count($this->projectroles); $i++) :
				$projectrole = $this->projectroles[$i];
				$k = $i%2;
			?>
			<div>
				<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=projectrole&layout=projectrole&id='.$projectrole->id); ?>'><?php echo JText::_('View Projectrole'); ?></a><br />
		<span class='title'><?php echo JText::_('Uid'); ?></span>:  
					<?php echo $projectrole->uid;?><br />
				<span class='title'><?php echo JText::_('Name'); ?></span>:  
					<?php echo $projectrole->name;?><br />
				<span class='title'><?php echo JText::_('Milestone'); ?></span>:  
					<?php echo $projectrole->milestone;?><br />
				<span class='title'><?php echo JText::_('Checklist'); ?></span>:  
					<?php echo $projectrole->checklist;?><br />
				<span class='title'><?php echo JText::_('Timerecord'); ?></span>:  
					<?php echo $projectrole->timerecord;?><br />
				<span class='title'><?php echo JText::_('File'); ?></span>:  
					<?php echo $projectrole->file;?><br />
				<span class='title'><?php echo JText::_('Tickets'); ?></span>:  
					<?php echo $projectrole->tickets;?><br />
				<span class='title'><?php echo JText::_('Discussions'); ?></span>:  
					<?php echo $projectrole->discussions;?><br />
				<span class='title'><?php echo JText::_('Created'); ?></span>:  
					<?php echo $projectrole->created;?><br />
				<span class='title'><?php echo JText::_('Modified'); ?></span>:  
					<?php echo $projectrole->modified;?><br />
				<span class='title'><?php echo JText::_('Author'); ?></span>:  
					<?php echo $projectrole->author;?><br />
				
			</div>
		<?php endfor; ?>
	</div>	
