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
	<?php echo $this->categoryList; ?>
</div>
	<div class='tabContainer'>			
		<?php
	 		for($i=0; $i<count($this->documents); $i++) :
				$document = $this->documents[$i];
				$k = $i%2;
			?>
            <div class='row<?php echo $k; ?>'>
				<div class='downloadLink'>
					<a href='<?php echo $document->file->downloadUrl; ?>' class='button'><?php echo JText::_('Download'); ?></a>
				</div>	
                <div class='fileHolder'>			
                    <div class='fileImageSmall'>
                        <a href='<?php echo $document->link; ?>'><?php echo $document->file->image; ?></a>
                    </div>
				</div>
				<div class='fileDetail'>
                	<div class='key'><?php echo JText::_('Name'); ?></div><a href='<?php echo $document->link; ?>'><?php echo $document->name;?></a>
                </div>
                <?php if($document->attachment): ?>
				<div class="fileDetail">
                	<div class='key'><?php echo JText::_('Attached to'); ?></div><?php echo $document->attachedType; ?>: <a href='<?php echo $document->attachedUrl; ?>'><?php echo $document->attached; ?></a>
                </div>
                <?php endif; ?>
				<div class="fileDetail">
                	<div class='key'><?php echo JText::_('Size and Kind'); ?></div><?php echo $document->file->filesize; ?>, <?php echo $document->file->filetype; ?>
                </div>
				<div class="fileDetail">
                	<div class='key'><?php echo $document->first ? JText::_('Latest Version') : JText::_('Date'); ?></div><?php echo JText::_('Uploaded'); ?> <span class='hasTip' title="<?php echo $document->file->created."::"; ?>"><?php echo $document->file->createdDate; ?></span> <?php echo JText::_('by'); ?> <a href='<?php echo $document->file->authorUrl; ?>'><?php echo $document->file->author; ?></a>
                </div>
                <?php if($document->first): ?>
				<div class="fileDetail">
                	<div class='key'><?php echo JText::_('First Version'); ?></div><?php echo JText::_('Uploaded'); ?> <span class='hasTip' title="<?php echo $document->first->created."::"; ?>"><?php echo $document->first->createdDate; ?></span> <?php echo JText::_('by'); ?> <a href='<?php echo $document->first->authorUrl; ?>'><?php echo $document->first->author; ?></a>
                </div>
                <?php endif; ?>                
			</div>
		<?php endfor; ?>
        <div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>
        <?php echo $this->startupText; ?>
	</div>	
