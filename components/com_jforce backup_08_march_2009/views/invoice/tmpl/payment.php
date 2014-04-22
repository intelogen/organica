<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			payment.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<script language='javascript' type='text/javascript'>
<!--
function submitbutton(pressbutton) {
	var form = document.adminForm;
	form.task.value=pressbutton;
	form.submit();
}
//-->
</script>
<div class='contentheading'><?php echo JText::_('Invoice'); ?>: <?php echo $this->invoice->name; ?></div>
<div class='quickLinks'>
<a href='<?php echo JRoute::_('index.php?option=com_jforce&c=accounting&view=invoice&layout=form&id='.$this->invoice->id); ?>' class='button'><?php echo JText::_('Edit Invoice'); ?></a>
<a href='<?php echo JRoute::_('index.php?option=com_jforce&c=accounting&view=invoice&layout=form&action=duplicate'); ?>' class='button'><?php echo JText::_('Copy Invoice'); ?></a>
</div>
<div class='tabs'>
	<ul id="tabMenu">
	  <li id="tab-0"><a href='<?php echo JRoute::_('index.php?option=com_jforce&c=accounting&view=invoice&layout=invoice&pid='.$this->invoice->pid.'&id='.$this->invoice->id); ?>'><?php echo JText::_('Screen'); ?></a></li>
	  <li id="tab-1"><a href='#'><?php echo JText::_('Email'); ?></a></li>
	  <li id="tab-2"><a href='<?php echo JRoute::_('index.php?option=com_jforce&c=accounting&view=invoice&layout=print&pid='.$this->invoice->pid.'&id='.$this->invoice->id.'&tmpl=component'); ?>' onclick="window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;"><?php echo JText::_('Print'); ?></a></li>
	</ul>
</div>
<div class='tabContainer'>
		<div class='dateArea sideBox'>
			<strong><?php echo JText::_('Invoice'); ?>: </strong><?php echo $this->invoice->id; ?><hr />
			<strong><?php echo JText::_('Valid Till'); ?></strong> <?php echo $this->invoice->validtill; ?>
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
		<h1><?php echo $this->invoice->name; ?></h1>
		<div><?php echo JText::_('Project'); ?>: <a href='<?php echo $this->invoice->projectUrl; ?>'><?php echo $this->invoice->project; ?></a></div>
		
		<?php if($this->invoice->milestone): ?>
			<div><?php echo JText::_('Milestone'); ?>: <a href='<?php echo $this->invoice->milestoneUrl; ?>'><?php echo $this->invoice->milestone; ?></a></div>
		<?php endif; 
		
		if($this->invoice->checklist): ?>
			<div><?php echo JText::_('Checklist'); ?>: <a href='<?php echo $this->invoice->checklistUrl; ?>'><?php echo $this->invoice->checklist; ?></a></div>
		<?php endif; ?>
		
		<?php if($this->invoice->description): ?>
		<div class='notesArea'>
		<div class='notesTitle'><?php echo JText::_('Invoice Description'); ?></div>
			<?php echo $this->invoice->description;?>
		</div>
		<?php endif; ?>

		
        <div class='totalsArea'>
            <div class='sideBox'>
                <div class='field'>
                    <div class='key'><?php echo JText::_('Subtotal'); ?></div>
                    <span><?php echo $this->invoice->subtotal; ?></span>
                </div>
                <?php if($this->invoice->discount): ?>
                <div class='field'>
                    <div class='key'><?php echo JText::_('Discount'); ?></div>
                    <span><?php echo $this->invoice->discount; ?></span>
                </div>
                <?php endif;
				if($this->invoice->tax): ?>
                <div class='field'>
                    <div class='key'><?php echo JText::_('Tax'); ?></div>
                    <span><?php echo $this->invoice->tax; ?></span>
                </div>
                <?php endif; ?>
                <div class='fieldTotal'>
                    <div class='key'><?php echo JText::_('Total'); ?></div>
                    <span><?php echo $this->invoice->total; ?></span>
                </div>
            </div>
        </div>

	<div class="paymentForm">
    	<?php echo $this->form;?>
    </div>

	<div class='footerArea'>
	    <span class='right'><?php echo $this->owner->phone; ?></span>
		<span class='left'><strong><?php echo $this->owner->name; ?></strong></span>
        <span><?php echo $this->owner->address; ?></span>
	</div>			
</div>

