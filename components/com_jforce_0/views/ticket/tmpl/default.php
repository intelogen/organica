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
<div class='contentheading'><?php echo JText::_('Tickets'); ?></div>
<div class='quickLinks'>
	<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=ticket&layout=form&pid='.$this->pid); ?>' class='button'><?php echo JText::_('New Ticket'); ?></a>	
</div>
<div class='tabs'>
	<ul id="tabMenu">
	  <li id="tab-1"><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=ticket&status=1&pid='.$this->pid); ?>' class='<?php echo $this->status=='1' ? 'active' : ''; ?>'><?php echo JText::_('Resolved'); ?></a></li>
	  <li id="tab-2"><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=ticket&pid='.$this->pid); ?>' class='<?php echo $this->status=='' ? 'active' : ''; ?>'><?php echo JText::_('Active'); ?></a></li>
	</ul>
</div>
<div class='tabContainer'>
		<?php
        for($i=0; $i<count($this->tickets); $i++) :
            $ticket = $this->tickets[$i];
            $k = $i%2;
        ?>
        <div class='row<?php echo $k; ?>'>
				<div class="lastPost">
					<span class='itemDetails'><?php echo JText::_('Last activity'); ?>: <a href="#"><?php echo $ticket->lastPostAuthor; ?></a><br /><?php echo $ticket->lastPost; ?></span>
				</div>

            <div class='ticketPriority'>
                <?php echo $ticket->priority; ?>
            </div>
            <div class='logo'>
                <?php echo $ticket->read; ?>
            </div>
            <div class="listTitle">
                <a href='<?php echo JRoute::_('index.php?option=com_jforce&view=ticket&layout=ticket&pid='.$ticket->pid.'&id='.$ticket->id); ?>'>
                    <?php echo $ticket->summary;?>
                </a>
            </div>
            <?php if ($ticket->category): ?>
            <div class='subheading inline'>
           		<?php echo JText::_('Category').': '.$ticket->category; ?>
            </div>
            <?php endif; ?>
            <?php echo $ticket->category && $ticket->assignees ? '<div class="inline">|</div>' : ''; ?>
            <?php if ($ticket->assignees) : ?>
               	<div class="subheading inline">
            	   	<?php echo JText::_('Assignees').': '.$ticket->assignees; ?>
                </div>
            <?php endif; ?>			
        </div>
    <?php endfor; ?>
    <div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>
    <?php echo $this->startupText; ?>
</div>	
