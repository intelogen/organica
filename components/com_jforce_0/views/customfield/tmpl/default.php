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
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=customfield&layout=form'); ?>'><?php echo JText::_('New Customfield'); ?></a></li>	
</ul>

		<div>
			<?php
	 		for($i=0; $i<count($this->customfields); $i++) :
				$customfield = $this->customfields[$i];
				$k = $i%2;
			?>
			<div>
				<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=customfield&layout=customfield&id='.$customfield->id); ?>'><?php echo JText::_('View Customfield'); ?></a><br />
		<span class='title'><?php echo JText::_('Field'); ?></span>:  
					<?php echo $customfield->field;?><br />
				<span class='title'><?php echo JText::_('Values'); ?></span>:  
					<?php echo $customfield->values;?><br />
				<span class='title'><?php echo JText::_('Type'); ?></span>:  
					<?php echo $customfield->type;?><br />
				
			</div>
		<?php endfor; ?>
	</div>	
