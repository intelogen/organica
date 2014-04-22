<?php
/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			document.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<div class='contentheading'><?php echo $this->document->name; ?></div>
<div class='quickLinks'>
<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=file&layout=upload&pid='.$this->document->pid); ?>' class='button'><?php echo JText::_('Upload Files'); ?></a>
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
<div class='tabContainer'>
<?php if ($this->comments->showMain) : ?>
	<?php $k = 1; ?>
	<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Name'); ?></div><a href='<?php echo $this->document->file->downloadUrl; ?>'><?php echo $this->document->name; ?></a></div>
	<div class='row<?php echo $k%2; $k = 1 - $k; ?>'><div class='itemTitle'><?php echo JText::_('Version'); ?></div>#<?php echo $this->document->file->version; ?>--<?php echo JText::_('Uploaded'); ?> <span class='hasTip' title="<?php echo $this->document->file->created."::"; ?>"><?php echo $this->document->file->createdDate; ?></span> <?php echo JText::_('by'); ?> <a href='<?php echo $this->document->file->authorUrl; ?>'><?php echo $this->document->file->author; ?></a></div>
	<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Size and Kind'); ?></div><?php echo $this->document->file->filesize; ?>, <?php echo $this->document->file->filetype; ?></div>
    <?php if($this->document->attachedType): ?>
    <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class='itemTitle'><?php echo $this->document->attachedType; ?></div><a href='<?php echo $this->document->attachedUrl; ?>'><?php echo $this->document->attached; ?></a></div>
    <?php endif; ?>
    
	<?php if($this->document->category): ?>
    <div class='row<?php echo $k%2; $k = 1 - $k; ?>'><div class='itemTitle'><?php echo JText::_('Category'); ?></div><?php echo $this->document->category; ?></div>
    <?php endif; ?>
    <?php if($this->document->tags): ?>
		<div class='row<?php echo $k%2; $k = 1 - $k; ?>'><div class='itemTitle'><?php echo JText::_('Tags'); ?></div><?php echo $this->document->tags; ?></div>			
	<?php endif; ?>
    
	<?php if($this->document->file->image==0): ?>
		<div class='fileAreaLarge'>
			<a href='<?php echo $this->document->file->downloadUrl; ?>'><?php echo $this->document->file->imageLarge; ?></a>
            <div class='fileAreaFooter'><?php echo JText::_('Image Preview'); ?> <a href='<?php echo $this->document->file->downloadUrl; ?>'><strong><?php echo JText::_('Click to download'); ?></strong></a> <?php echo JText::_('full size image'); ?>
            </div>
        </div>
	<?php endif; ?>
    
    <div class='notesArea'>
    	<?php echo $this->document->description; ?>
    </div>
	
	<?php if($this->versions): ?>
    <div class='notesArea'>
    	<h3><?php echo JText::_('Previous Versions'); ?></h3>	
            <?php
                for($i=0; $i<count($this->versions); $i++) :
                    $version = $this->versions[$i];
                    $k = $i%2;
                ?>
                <div class='row<?php echo $k; ?>'>
                    <div class='downloadLink'>
                        <a href='<?php echo $version->downloadUrl; ?>' class='button'><?php echo JText::_('Download'); ?></a>
                    </div>
                    <div class='fileVersion'>#<?php echo $version->version; ?></div>			
                    <div class='fileImageSmall'>
                        <a href='<?php echo $version->downloadUrl; ?>'><?php echo $version->image; ?></a>
                    </div>
                    <div class='fileDetail'>
                        <div class='key'><?php echo JText::_('Name'); ?></div><a href='<?php echo $version->downloadUrl; ?>'><?php echo $version->name;?></a>
                    </div>
                    <div class="fileDetail">
                        <div class='key'><?php echo JText::_('Size and Kind'); ?></div><?php echo $version->filesize; ?>, <?php echo $version->filetype; ?>
                    </div>
                    <div class="fileDetail">
                	<div class='key'><?php echo JText::_('Date'); ?></div><?php echo JText::_('Uploaded'); ?> <span class='hasTip' title="<?php echo $version->created."::"; ?>"><?php echo $version->createdDate; ?></span> <?php echo JText::_('by'); ?> <a href='<?php echo $version->authorUrl; ?>'><?php echo $version->author; ?></a>
                </div>
                </div>
            <?php endfor; ?>
        </div>	
    <?php endif; ?> 
<?php endif; ?>

<div class='commentTitle'>
	<h2><?php echo JText::_('Comments'); ?></h2>
</div>
<?php echo $this->comments->display(); ?>
</div>