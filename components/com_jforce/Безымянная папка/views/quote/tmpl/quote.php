<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			quote.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<div class='contentheading'><?php echo JText::_('Quote'); ?>: <?php echo $this->quote->name; ?></div>
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
		<div class='dateArea sideBox'>
			<strong><?php echo JText::_('Quote'); ?>: </strong><?php echo $this->quote->id; ?><hr />
			<strong><?php echo JText::_('Valid Till'); ?></strong> <?php echo $this->quote->validtill; ?>
		</div>
		<div class='ownerAddress'>
			<strong><?php echo $this->owner->name; ?></strong><br />
			<?php echo $this->owner->address; ?><br />
			<?php echo $this->owner->phone; ?>
		</div>
		<div class='companyAddress'>
		<span class='billingTitle'><?php echo JText::_('Billing Information'); ?>:</span><br />
			<strong><?php echo $this->company->name; ?></strong><br />
			<?php echo $this->company->address; ?><br />
            <?php echo $this->company->phone; ?>
		</div>
		<h1><?php echo $this->quote->name; ?></h1>
        
		<?php if($this->quote->pid): ?>
			<div><?php echo JText::_('Project'); ?>: <a href='<?php echo $this->quote->projectlink; ?>'><?php echo $this->quote->project; ?></a></div>
		<?php endif; ?>
        	
		<?php if($this->quote->milestone): ?>
			<div><?php echo JText::_('Milestone'); ?>: <a href='<?php echo $this->quote->milestoneUrl; ?>'><?php echo $this->quote->milestone; ?></a></div>
		<?php endif; 
		
		if($this->quote->checklist): ?>
			<div><?php echo JText::_('Checklist'); ?>: <a href='<?php echo $this->quote->checklistUrl; ?>'><?php echo $this->quote->checklist; ?></a></div>
		<?php endif; ?>
		
		<?php if($this->quote->description): ?>
		<div class='notesArea'>
		<div class='notesTitle'><?php echo JText::_('Quote Description'); ?></div>
			<?php echo $this->quote->description;?>
		</div>
		<?php endif; ?>

		<div class='servicesArea'>
		<div class='notesTitle'><?php echo JText::_('Services'); ?></div><hr />
        	<div class='servicesHeader'>
            	<div class='serviceTotals'><?php echo JText::_('Cost'); ?></div>
                <div class='serviceQuantity'><?php echo JText::_('Quantity'); ?></div>
                <div class='listTitle'><?php echo JText::_('Service'); ?></div>
            </div>
			<?php for($i=0;$i<count($this->services);$i++): 
					$service = $this->services[$i]; 
					$k = $i%2; ?>
						<div class='row<?php echo $k; ?>'>
                        	<div class='serviceTotals'>
                            	<div class='key'><?php echo JText::_('Subtotal'); ?></div><?php echo $service->subtotal; ?><br />
                                <div class='key'><?php echo $service->discount ? JText::_('Discount')."</div>".$service->discount : "</div>";?><br />
                                <div class='key'><?php echo $service->tax ? JText::_('Tax')."</div>".$service->tax : "</div>"; ?><br />
                                <div class='key'><?php echo JText::_('Total'); ?></div><?php echo $service->total; ?><br />
                            </div>
                            <div class='serviceQuantity'><?php echo $service->quantity; ?></div>
							<div class='listTitle'><?php echo $service->name; ?></div>
							<div class='serviceDescription'><?php echo $service->description; ?></div>
						</div>
			<?php endfor; ?>
			</div>
        <div class='totalsArea'>
            <div class='sideBox'>
                <div class='field'>
                    <div class='key'><?php echo JText::_('Subtotal'); ?></div>
                    <span><?php echo $this->currency.$this->quote->subtotal; ?></span>
                </div>
                <?php if($this->quote->discount): ?>
                <div class='field'>
                    <div class='key'><?php echo JText::_('Discount'); ?></div>
                    <span><?php echo $this->currency.$this->quote->discount; ?></span>
                </div>
                <?php endif;
				if($this->quote->tax): ?>
                <div class='field'>
                    <div class='key'><?php echo JText::_('Tax'); ?></div>
                    <span><?php echo $this->currency.$this->quote->tax; ?></span>
                </div>
                <?php endif; ?>
                <div class='fieldTotal'>
                    <div class='key'><?php echo JText::_('Total'); ?></div>
                    <span><?php echo $this->currency.$this->quote->total; ?></span>
                </div>
            </div>
        </div>

	<div class='footerArea'>
	    <span class='right'><?php echo $this->owner->phone; ?></span>
		<span class='left'><strong><?php echo $this->owner->name; ?></strong></span>
        <span><?php echo $this->owner->address; ?></span>
	</div>			
</div>	
<div class='quoteActionArea'>
	<?php echo $this->quote->acceptedHTML; ?>
</div>
<?php endif; ?>

<?php echo $this->comments->display(); ?>

