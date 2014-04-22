<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			service.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<ul>
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=service&layout=form&id='.$this->service->id); ?>'><?php echo JText::_('Edit Service'); ?></a></li>	
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=service&layout=form'); ?>'><?php echo JText::_('New Service'); ?></a></li>	
</ul>

		<div>
		Name: <?php echo $this->service->name;?><br />
					Description: <?php echo $this->service->description;?><br />
					Price: <?php echo $this->service->price;?><br />
					Tax: <?php echo $this->service->tax;?><br />
					Created: <?php echo $this->service->created;?><br />
					Modified: <?php echo $this->service->modified;?><br />
					Author: <?php echo $this->service->author;?><br />
					
		</div>	
