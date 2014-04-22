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
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=task&layout=form'); ?>'><?php echo JText::_('New Task'); ?></a></li>	
</ul>

		<div>
			<?php
	 		if($this->trash):
				foreach($this->trash as $t):
			print_r($t);
			endforeach; 
			endif;
			?>
	</div>	
