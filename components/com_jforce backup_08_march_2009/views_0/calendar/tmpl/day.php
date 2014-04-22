<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			day.php															*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<ul>
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=person&layout=form&id='.$this->person->id); ?>'><?php echo JText::_('Edit Person'); ?></a></li>	
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=person&layout=form'); ?>'><?php echo JText::_('New Person'); ?></a></li>	
</ul>

		<div>
		Uid: <?php echo $this->person->uid;?><br />
					Cid: <?php echo $this->person->cid;?><br />
					Address: <?php echo $this->person->address;?><br />
					Role: <?php echo $this->person->role;?><br />
					Office_phone: <?php echo $this->person->office_phone;?><br />
					Im: <?php echo $this->person->im;?><br />
					Image: <?php echo $this->person->image;?><br />
					Auto_add: <?php echo $this->person->auto_add;?><br />
					Created: <?php echo $this->person->created;?><br />
					Modified: <?php echo $this->person->modified;?><br />
					Author: <?php echo $this->person->author;?><br />
					
		</div>	