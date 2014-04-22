<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			discussion.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<?php if($this->discussion->visibility==0): ?>
<div class="alertArea"><?php echo JText::_('This item is marked as private'); ?></div>
<?php endif; ?>

<div class='contentheading'><?php echo $this->discussion->summary; ?></div>
<div class='quickLinks'>
<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=discussion&layout=form&pid='.$this->discussion->pid); ?>' class='button'><?php echo JText::_('New Discussion'); ?></a>
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
            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Name'); ?></div><?php echo $this->discussion->summary; ?></div>	
			<?php if($this->discussion->category): ?>
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Category'); ?></div><a href='<?php echo $this->discussion->categoryUrl; ?>'><?php echo $this->discussion->category; ?></a></div>        
            <?php endif; ?>
            <?php if($this->discussion->milestonename): ?>
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Milestone'); ?></div><a href='<?php echo $this->discussion->milestoneUrl; ?>'><?php echo $this->discussion->milestonename; ?></a></div>	        
            <?php endif; ?>
            <?php if($this->discussion->tags): ?>
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Tags'); ?></div><?php echo $this->discussion->tags; ?></div>	
			<?php endif; ?>
            <div class="row<?php echo $k%2; $k = 1 - $k; ?>">
				<div class='commentTitle'>
					<div class="commentImage"><?php echo $this->discussion->image; ?></div>
					<div class='commentAuthor'><a href="<?php echo $this->discussion->authorUrl; ?>"><?php echo $this->discussion->author; ?></a> <?php echo JText::_('said'); ?> </div>
					<div class='commentTime'><span class='hasTip' title="<?php echo $this->discussion->created."::"; ?>"><?php echo $this->discussion->createdDate; ?></span></div>
				</div>
				<div class='commentArea'>
                <?php echo $this->discussion->message; ?>
					<div class='attachmentArea'>
					<span class='attachmentTitle'><?php echo JText::_('Attachments'); ?>:</span>  
                    <?php
					for($i=0;$i<count($this->discussion->attachments);$i++):
						$attachment = $this->discussion->attachments[$i];
					?>
                        	<a href='<?php echo $attachment->link; ?>'><?php echo $attachment->name; ?></a>
                      
                    <?php endfor; ?>
					</div>
				</div>
			</div>
<?php endif; ?>
<?php echo $this->comments->display(); ?>
</div>