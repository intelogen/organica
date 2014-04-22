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
<ul>
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=service&layout=form'); ?>'><?php echo JText::_('New Service'); ?></a></li>	
</ul>

		<div>
			<?php
	 		for($i=0; $i<count($this->services); $i++) :
				$service = $this->services[$i];
				$k = $i%2;
			?>
			<div>
				<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=service&layout=service&id='.$service->id); ?>'><?php echo JText::_('View Service'); ?></a><br />
		<span class='title'><?php echo JText::_('Name'); ?></span>:  
					<?php echo $service->name;?><br />
				<span class='title'><?php echo JText::_('Description'); ?></span>:  
					<?php echo $service->description;?><br />
				<span class='title'><?php echo JText::_('Price'); ?></span>:  
					<?php echo $service->price;?><br />
				<span class='title'><?php echo JText::_('Tax'); ?></span>:  
					<?php echo $service->tax;?><br />
				<span class='title'><?php echo JText::_('Created'); ?></span>:  
					<?php echo $service->created;?><br />
				<span class='title'><?php echo JText::_('Modified'); ?></span>:  
					<?php echo $service->modified;?><br />
				<span class='title'><?php echo JText::_('Author'); ?></span>:  
					<?php echo $service->author;?><br />
				
			</div>
		<?php endfor; ?>
	</div>	
