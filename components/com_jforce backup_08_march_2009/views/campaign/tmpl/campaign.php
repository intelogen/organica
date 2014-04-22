<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			campaign.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<div class='contentheading'><?php echo $this->campaign->name; ?></div>
<div class='quickLinks'>
<a href='<?php echo JRoute::_('index.php?option=com_jforce&c=sales&view=campaign&layout=form'); ?>' class='button'><?php echo JText::_('New Campaign'); ?></a>
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
			<!--<div class="row0"><div class="itemTitle"><?php echo JText::_('Category'); ?></div><a href='<?php echo $this->campaign->categoryUrl; ?>'><?php echo $this->campaign->category; ?></a></div>      -->  
            
            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Name'); ?></div><?php echo $this->campaign->name; ?></div>	
			
			<?php if($this->campaign->status): ?>
            	<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Satus'); ?></div><?php echo $this->campaign->status; ?></div> 
            <?php endif; ?>
            
            <?php if($this->campaign->expectedclose): ?>
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Expected Close'); ?></div><?php echo $this->campaign->expectedclose; ?></div>
    		<?php endif; ?>
            
            <?php if($this->campaign->type): ?> 	       
 	           <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Type'); ?></div><?php echo $this->campaign->type; ?></div>	        
    		<?php endif; ?>
            
            <?php if($this->campaign->audience): ?> 	       
  	          <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Audience'); ?></div><?php echo $this->campaign->audience; ?></div>	
    		<?php endif; ?>
            
            <?php if($this->campaign->sponsor): ?>        
 	           <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Sponsor'); ?></div><?php echo $this->campaign->sponsor; ?></div>	
    		<?php endif; ?>
            
            <?php if($this->campaign->reach): ?>        
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Reach'); ?></div><?php echo $this->campaign->reach; ?></div>	
    		<?php endif; ?>
            
            <?php if($this->campaign->ecost): ?> 	       
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Estimated Cost'); ?></div><?php echo $this->campaign->ecost; ?></div>	
    		<?php endif; ?>
            <?php if($this->campaign->acost): ?> 	       
 	           <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Actual Cost'); ?></div><?php echo $this->campaign->acost; ?></div>	        
    		<?php endif; ?>
            
            <?php if($this->campaign->eresponse): ?> 	       
  	          <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Estimated Response'); ?></div><?php echo $this->campaign->eresponse; ?></div>	
    		<?php endif; ?>
            
            <?php if($this->campaign->aresponse): ?>        
 	           <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Actual Response'); ?></div><?php echo $this->campaign->aresponse; ?></div>	
    		<?php endif; ?>
            
            <?php if($this->campaign->erevenue): ?>        
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Estimated Revenue'); ?></div><?php echo $this->campaign->erevenue; ?></div>	
    		<?php endif; ?>
            
            <?php if($this->campaign->arevenue): ?> 	       
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Actual Revenue'); ?></div><?php echo $this->campaign->arevenue; ?></div>	
    		<?php endif; ?>
            
            <?php if($this->campaign->eroi): ?> 	       
  	          <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Estimated ROI'); ?></div><?php echo $this->campaign->eroi; ?></div>	
    		<?php endif; ?>
            
            <?php if($this->campaign->aroi): ?>        
 	           <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Actual ROI'); ?></div><?php echo $this->campaign->aroi; ?></div>	
    		<?php endif; ?>
            
            <?php if($this->campaign->tags): ?>       
	            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Tags'); ?></div><?php echo $this->campaign->tags; ?></div>	
			<?php endif; ?>
            <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Tags'); ?></div><?php echo $this->campaign->tags; ?></div>	
			<div class='commentArea'>
                <?php echo $this->campaign->description; ?>
					<div class='attachmentArea'>
					<span class='attachmentTitle'><?php echo JText::_('Attachments'); ?>:</span>  
                    <?php
					for($i=0;$i<count($this->campaign->attachments);$i++):
						$attachment = $this->campaign->attachments[$i];
					?>
                        	<a href='<?php echo $attachment->link; ?>'><?php echo $attachment->name; ?></a>
                      
                    <?php endfor; ?>
					</div>
				</div>
<?php endif; ?>
<?php echo $this->comments->display(); ?>
</div>