<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			ticket.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<div class='contentheading'><?php echo $this->ticket->summary;?></div>
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
<div class='topContainer'>
	<div class='mainColumn'>
    	<?php $k = 1; ?>
            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Summary'); ?></div><?php echo $this->ticket->summary; ?></div>	
            <?php if($this->ticket->duedate): ?>
            	<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Due Date'); ?></div><?php echo $this->ticket->duedate; ?></div>	
            <?php endif; ?>
            <?php if($this->ticket->priority): ?>
            	<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Priority'); ?></div><?php echo $this->ticket->priority; ?></div>
            <?php endif; ?>
            <?php if($this->ticket->assignees): ?>
            	<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Assignees'); ?></div><?php echo $this->ticket->assignees; ?></div>	
			<?php endif; ?>
            <?php if($this->ticket->category): ?>
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Category'); ?></div><a href='<?php echo $this->ticket->categoryUrl; ?>'><?php echo $this->ticket->category; ?></a></div>
           	<?php endif; ?>
            <?php if($this->ticket->milestonename): ?>        
 	           <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Milestone'); ?></div><a href='<?php echo $this->ticket->milestoneUrl; ?>'><?php echo $this->ticket->milestonename; ?></a></div>
            <?php endif; ?>
            
	</div>
	<div class='secondaryColumn sideBox'>
	<?php for ($i=0; $i<count($this->ticket->customFields); $i++) : 
				$cf = $this->ticket->customFields[$i];
				if($cf['label']): 
					if($cf['fieldtype']=='textarea'): ?>
	                <div class='row1'><div class='itemTitle full'><?php echo $cf['label']; ?></div><?php echo $cf['field'];?></div>					
					<?php else: ?>
    	            <div class='row1'><div class='itemTitle'><?php echo $cf['label']; ?></div><?php echo $cf['field'];?></div>
            	<?php 
				endif;
			endif;
		endfor; ?>
	</div>
</div>
			<div class="row1">
				<div class='commentTitle'>
					<div class="commentImage"><?php echo $this->ticket->image; ?></div>
					<div class='commentAuthor'><a href="<?php echo $this->ticket->authorUrl; ?>"><?php echo $this->ticket->author; ?></a> <?php echo JText::_('said'); ?> </div>
					<div class='commentTime'><span class='hasTip' title="<?php echo $this->ticket->created."::"; ?>"><?php echo $this->ticket->createdDate; ?></span></div>
				</div>
				<div class='commentArea'>
                	<?php echo $this->ticket->description; ?>
					<?php if($this->ticket->attachments): ?>
                    <div class='attachmentArea'>
					<span class='attachmentTitle'><?php echo JText::_('Attachments'); ?>:</span>  
                    <?php
					for($i=0;$i<count($this->ticket->attachments);$i++):
						$attachment = $this->ticket->attachments[$i];
					?>
                        	<a href='<?php echo $attachment->link; ?>'><?php echo $attachment->name; ?></a>
                      
                    <?php endfor; ?>
					</div>
                    <?php endif; ?>
				</div>
			</div>
<?php endif; ?>

<?php echo $this->comments->display(); ?>

</div>