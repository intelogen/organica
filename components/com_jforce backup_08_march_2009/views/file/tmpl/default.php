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
<div class='contentheading'><?php echo JText::_('Files'); ?></div>
<div class='quickLinks'><?php echo $this->newFileLink; ?></div>
<div class='tabs'>
	<?php echo $this->categorylist; ?>
</div>
		<div class='tabContainer'>			
		<?php
	 		for($i=0; $i<count($this->files); $i++) :
				$file = $this->files[$i];
				$k = $i%2;
			?>
            <div class='row<?php echo $k; ?>'>
				<a href='<?php echo $file->link; ?>'><?php echo JText::_('View File'); ?></a><br />
		<span class='title'><?php echo JText::_('Pid'); ?></span>:  
					<?php echo $file->pid;?><br />
				<span class='title'><?php echo JText::_('Filelocation'); ?></span>:  
					<?php echo $file->filelocation;?><br />
				<span class='title'><?php echo JText::_('Filetype'); ?></span>:  
					<?php echo $file->filetype;?><br />
				<span class='title'><?php echo JText::_('Filesize'); ?></span>:  
					<?php echo $file->filesize;?><br />
				<span class='title'><?php echo JText::_('Name'); ?></span>:  
					<?php echo $file->name;?><br />
				<span class='title'><?php echo JText::_('Description'); ?></span>:  
					<?php echo $file->description;?><br />
				<span class='title'><?php echo JText::_('Visibility'); ?></span>:  
					<?php echo $file->visibility;?><br />
				<span class='title'><?php echo JText::_('Category'); ?></span>:  
					<?php echo $file->category;?><br />
				<span class='title'><?php echo JText::_('Milestone'); ?></span>:  
					<?php echo $file->milestone;?><br />
				<span class='title'><?php echo JText::_('Checklist'); ?></span>:  
					<?php echo $file->checklist;?><br />
				<span class='title'><?php echo JText::_('Discussion'); ?></span>:  
					<?php echo $file->discussion;?><br />
				<span class='title'><?php echo JText::_('Comment'); ?></span>:  
					<?php echo $file->comment;?><br />
				<span class='title'><?php echo JText::_('Tags'); ?></span>:  
					<?php echo $file->tags;?><br />
				<span class='title'><?php echo JText::_('Notify'); ?></span>:  
					<?php echo $file->notify;?><br />
				<span class='title'><?php echo JText::_('Version'); ?></span>:  
					<?php echo $file->version;?><br />
				<span class='title'><?php echo JText::_('Created'); ?></span>:  
					<?php echo $file->created;?><br />
				<span class='title'><?php echo JText::_('Modified'); ?></span>:  
					<?php echo $file->modified;?><br />
				<span class='title'><?php echo JText::_('Author'); ?></span>:  
					<?php echo $file->author;?><br />
				
			</div>
		<?php endfor; ?>
	</div>	
