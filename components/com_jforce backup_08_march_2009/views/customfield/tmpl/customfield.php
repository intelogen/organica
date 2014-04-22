<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			customfield.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<ul>
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=customfield&layout=form&id='.$this->customfield->id); ?>'><?php echo JText::_('Edit Customfield'); ?></a></li>	
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=customfield&layout=form'); ?>'><?php echo JText::_('New Customfield'); ?></a></li>	
</ul>

		<div>
		Field: <?php echo $this->customfield->field;?><br />
					Values: <?php echo $this->customfield->values;?><br />
					Type: <?php echo $this->customfield->type;?><br />
					
		</div>	
