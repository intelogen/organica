<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			results.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>

<div class='contentheading'><?php echo JText::_('Phase Initial Survey'); ?></div>
		<div class='tabContainer2'>
			<?php
	 		if($this->results):
				foreach($this->results as $type => $results):
					foreach($results as $item):
					?>
                    <div class='itemHolder'>
							<div class='itemTag <?php echo $item['type']; ?>'><?php echo $item['type']; ?></div>
							<span class='listTitle'><a href="<?php echo $item['link']; ?>" /><?php echo $item['title']; ?></a></span> <?php echo JText::_('by'); ?> <?php echo $item['author']; ?>
                            <br />
                            <span class='itemText'><?php echo $item['text']; ?></span>
						</div>
                    <?php
					endforeach;
			endforeach; 
			endif;
			?>
	</div>	
