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
<div class='contentheading'><?php echo JText::_('Invoices'); ?></div>
<div class='quickLinks'>
	<?php echo $this->newInvoiceLink; ?>
</div>	
<div class='tabs'>
	<ul id="tabMenu">
	  <li id="tab-1"><a href='<?php echo JRoute::_('index.php?option=com_jforce&c=accounting&view=invoice&pid='.$this->pid.'&status=2'); ?>' class='<?php echo $this->status=='2' ? 'active' : ''; ?>'><?php echo JText::_('Refunded'); ?></a></li>
	  <li id="tab-2"><a href='<?php echo JRoute::_('index.php?option=com_jforce&c=accounting&view=invoice&pid='.$this->pid.'&status=1'); ?>' class='<?php echo $this->status=='1' ? 'active' : ''; ?>'><?php echo JText::_('Paid'); ?></a></li>
	  <li id="tab-3"><a href='<?php echo JRoute::_('index.php?option=com_jforce&c=accounting&view=invoice&pid='.$this->pid); ?>' class='<?php echo $this->status=='' ? 'active' : ''; ?>'><?php echo JText::_('Active'); ?></a></li>
	</ul>
</div>
<div class='tabContainer'>
			<?php
	 		for($i=0; $i<count($this->invoices); $i++) :
				$invoice = $this->invoices[$i];
				$k = $i%2;
			?>
			<div class='row<?php echo $k; ?>'>
            	<div class='itemTotal'><?php echo $invoice->total; ?></div>
                <div class='itemDate'><span class='hasTip' title='<?php echo $invoice->created; ?>'><?php echo $invoice->date; ?></span></div>
                <div class='logo'>
                	<?php echo $invoice->read; ?>
                </div>
				<div class='listTitle'><a href='<?php echo $invoice->link; ?>'><?php echo $invoice->name;?></a></div>
                <div class='subheading'><a href='<?php echo $invoice->projectlink; ?>'><?php echo $invoice->project; ?></a></div>
			</div>
		<?php endfor; ?>
       <div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>
       <?php echo $this->startupText; ?>
	</div>	
