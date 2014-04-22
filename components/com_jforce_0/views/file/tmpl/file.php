<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			file.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<ul>
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=file&layout=form&id='.$this->file->id); ?>'><?php echo JText::_('Edit File'); ?></a></li>	
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=file&layout=form'); ?>'><?php echo JText::_('New File'); ?></a></li>	
</ul>

		<div>
		Pid: <?php echo $this->file->pid;?><br />
					Filelocation: <?php echo $this->file->filelocation;?><br />
					Filetype: <?php echo $this->file->filetype;?><br />
					Filesize: <?php echo $this->file->filesize;?><br />
					Name: <?php echo $this->file->name;?><br />
					Description: <?php echo $this->file->description;?><br />
					Visibility: <?php echo $this->file->visibility;?><br />
					Category: <?php echo $this->file->category;?><br />
					Milestone: <?php echo $this->file->milestone;?><br />
					Checklist: <?php echo $this->file->checklist;?><br />
					Discussion: <?php echo $this->file->discussion;?><br />
					Comment: <?php echo $this->file->comment;?><br />
					Tags: <?php echo $this->file->tags;?><br />
					Notify: <?php echo $this->file->notify;?><br />
					Version: <?php echo $this->file->version;?><br />
					Created: <?php echo $this->file->created;?><br />
					Modified: <?php echo $this->file->modified;?><br />
					Author: <?php echo $this->file->author;?><br />
					
		</div>	
