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

<form action='index.php' method='post' name='adminForm'>
<div id='cpanel'>
	<?php for($i=0;$i<count($this->buttons);$i++): 
			$button = $this->buttons[$i];
			?>
	<div style="float:left;">
			<div class="icon jforce<?php echo $button['name']; ?>">
				<a href="<?php echo $button['link']; ?>">
                	<?php echo $button['image']; ?>
					<span><?php echo $button['name']; ?></span></a>
			</div>
	</div>
    <?php endfor; ?>
</div>
		<input type='hidden' name='task' value='' />
		<input type='hidden' name='option' value='com_jforce' />
        <input type='hidden' name='c' value='configuration' />
		<input type='hidden' name='boxchecked' value='0' />
        <input type="hidden" name="view" value="" />
		<input type="hidden" name="layout" value="" />
</form> 