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
<div class='contentheading'><?php echo JText::_('Quotes'); ?></div>
<div class='quickLinks'>
	<?php echo $this->newQuoteLink; ?>
</div>	
<div class='tabs'>
	<ul id="tabMenu">
	  <li id="tab-1"><a href='<?php echo JRoute::_('index.php?option=com_jforce&c=accounting&view=quote&pid='.$this->pid.'&status=2'); ?>' class='<?php echo $this->status=='2' ? 'active' : ''; ?>'><?php echo JText::_('Denied'); ?></a></li>
	  <li id="tab-2"><a href='<?php echo JRoute::_('index.php?option=com_jforce&c=accounting&view=quote&pid='.$this->pid.'&status=1'); ?>' class='<?php echo $this->status=='1' ? 'active' : ''; ?>'><?php echo JText::_('Accepted'); ?></a></li>
	  <li id="tab-3"><a href='<?php echo JRoute::_('index.php?option=com_jforce&c=accounting&view=quote&pid='.$this->pid); ?>' class='<?php echo $this->status=='' ? 'active' : ''; ?>'><?php echo JText::_('Active'); ?></a></li>
	</ul>
</div>
<div class='tabContainer'>
			<?php
	 		for($i=0; $i<count($this->quotes); $i++) :
				$quote = $this->quotes[$i];
				$k = $i%2;
			?>
			<div class='row<?php echo $k; ?>'>
            	<div class='itemTotal'><?php echo $quote->total; ?></div>
                <div class='itemDate'><span class='hasTip' title="<?php echo $quote->created; ?>"><?php echo $quote->date; ?></span></div>
                <div class='logo'>
                	<?php echo $quote->read; ?>
                </div>
				<div class='listTitle'><a href='<?php echo $quote->link; ?>'><?php echo $quote->name;?></a></div>
                <div class='subheading'><a href='<?php echo $quote->projectlink; ?>'><?php echo $quote->project; ?></a></div>
			</div>
		<?php endfor; ?>
   <div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>
   <?php echo $this->startupText; ?>
</div>	