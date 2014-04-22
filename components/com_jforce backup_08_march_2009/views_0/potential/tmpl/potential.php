<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			potential.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<?php if($this->potential->visibility==0): ?>
<div class="alertArea"><?php echo JText::_('This item is marked as private'); ?></div>
<?php endif; ?>

<div class='contentheading'><?php echo $this->potential->name; ?></div>
<div class='quickLinks'>
<a href='<?php echo JRoute::_('index.php?option=com_jforce&c=sales&view=potential&layout=form&pid='.$this->potential->pid); ?>' class='button'><?php echo JText::_('New Potential'); ?></a>
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
            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Name'); ?></div><?php echo $this->potential->name; ?></div>	
			
			<?php if($this->potential->company): ?>
            	<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Lead/Company'); ?></div><a href='<?php echo JRoute::_('index.php?option=com_jforce&c=people&view=company&layout=company&id='.$this->potential->companyid); ?>'><?php echo $this->potential->company; ?></a></div> 
            <?php endif; ?>
            
            <?php if($this->potential->campaign): ?>
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Campaign'); ?></div><a href='<?php echo JRoute::_('index.php?option=com_jforce&c=sales&view=campaign&layout=campaign&id='.$this->potential->campaign); ?>'><?php echo $this->potential->campaignName; ?></a></div>                    
    		<?php endif; ?>
            
            <?php if($this->potential->closedate): ?> 	       
 	           <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Close Date'); ?></div><span class='hasTip' title='<?php echo $this->potential->closedate; ?>'><?php echo $this->potential->shortDate; ?></span></div>	        
    		<?php endif; ?>
            
            <?php if($this->potential->nextstep): ?> 	       
  	          <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Next Step'); ?></div><?php echo $this->potential->nextstep; ?></div>	
    		<?php endif; ?>
            
            <?php if($this->potential->salesstage): ?>        
 	           <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Sales Stage'); ?></div><?php echo $this->potential->salesstage; ?></div>	
    		<?php endif; ?>
            
            <?php if($this->potential->probability): ?>        
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Probability'); ?></div><?php echo $this->potential->probability; ?></div>	
    		<?php endif; ?>
            
            <?php if($this->potential->amount): ?> 	       
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Amount'); ?></div><?php echo $this->potential->amount; ?></div>	
    		<?php endif; ?>
            
            <?php if($this->potential->tags): ?>       
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Tags'); ?></div><?php echo $this->potential->tags; ?></div>	
			<?php endif; ?>
            <!--
				<div class='commentArea'>
                <?php echo $this->potential->description; ?>
					<div class='attachmentArea'>
					<span class='attachmentTitle'><?php echo JText::_('Attachments'); ?>:</span>  
                    <?php
					for($i=0;$i<count($this->potential->attachments);$i++):
						$attachment = $this->potential->attachments[$i];
					?>
                        	<a href='<?php echo $attachment->link; ?>'><?php echo $attachment->name; ?></a>
                      
                    <?php endfor; ?>
					</div>
				</div> -->
<?php endif; ?>
<?php echo $this->comments->display(); ?>
</div>