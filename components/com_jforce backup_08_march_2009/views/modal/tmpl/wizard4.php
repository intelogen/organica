<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			wizard4.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<script language='javascript' type='text/javascript'>
<!--
function submitbutton(pressbutton) {
	var form = document.adminForm;
	form.task.value=pressbutton;
	form.submit();
}
//-->
</script>

<div class='modalContainer'>
	<div class='contentheading'><?php echo JText::_('Conversion Wizard: Step 4'); ?></div>
	<div class='quickLinks'>
		<button type='button' id='back' class='button'>
				<?php echo JText::_('Back') ?>
			</button>
			<button type='button' onclick="submitbutton('convertLeadFinal')" id='complete' class='button'>
				<?php echo JText::_('Complete') ?>
			</button>
	</div>
	<div class='tabContainer2'>
  <form action='index.php' method='post' name='adminForm'>  
		<div class='companySelector'>
				<div class='editFieldSingle'>					
					<label for='<?php echo JText::_('Select Project Role'); ?>' class='key required'><?php echo JText::_('Select Project Role'); ?></label>			
					<?php echo $this->lists['projectroles']; ?>
				</div>
		</div>
		<div id="customProjectRoles">
			<?php echo $this->lists['customProjectRoles']; ?>
		</div>            			
		</div>
    <input type='hidden' name='option' value='com_jforce' />
    <input type="hidden" name='c' value='people' />
    <input type='hidden' name='model' value='person' />
    <input type='hidden' name='stage' value='4' />
    <input type='hidden' name='id' value='<?php echo $this->person->id; ?>' />
    <input type='hidden' name='person' value='<?php echo $this->person->id; ?>' />
    <input type='hidden' name='pid' value='<?php echo $this->pid; ?>' />
    <input type='hidden' name='task' value='' />
    <input type='hidden' name='view' value='modal' />
    <?php echo JHTML::_('form.token'); ?>
    </form>
    <?php echo JHTML::_('behavior.keepalive'); ?>	        
	</div>