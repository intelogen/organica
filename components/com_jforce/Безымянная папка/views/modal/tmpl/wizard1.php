<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			wizard1.php														*
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
	<div class='contentheading'><?php echo JText::_('Conversion Wizard: Step 1'); ?></div>
	<div class='quickLinks'>
		<button type='button' id='cancel' class='button'>
				<?php echo JText::_('Cancel') ?>
			</button>
			<button type='button' onclick="submitbutton('convertLead')" class='button'>
				<?php echo JText::_('Continue') ?>
			</button>
	</div>
	<div class='tabContainer2'>
  <form action='index.php' method='post' name='adminForm'>  
		<div class='companySelector'>
				<div class='editFieldSingle'>					
					<label for='<?php echo JText::_('Review User'); ?>' class='key required'><?php echo JText::_('Review User'); ?></label>			
				</div>
		</div>
		<div class='companyContainer'>
			<div class='editField'>					
			<label for='<?php echo JText::_('First Name'); ?>' class='key required'><?php echo JText::_('First Name'); ?></label>			
			<input type='text' id='firstname' name='firstname' size='60' class='inputbox required' value='<?php echo $this->lead->firstname; ?>' />
			</div>            
			<div class='editField'>								
			<label for='<?php echo JText::_('Last Name'); ?>' class='key'><?php echo JText::_('Last Name'); ?></label>			
			<input type='text' id='lastname' name='lastname' size='60' class='inputbox required' value='<?php echo $this->lead->lastname; ?>' />
			</div>            
			<div class='editField'>								
			<label for='<?php echo JText::_('Username'); ?>' class='key required'><?php echo JText::_('Username'); ?></label>			
			<input type='text' id='username' name='username' size='60' class='inputbox required' value='<?php echo $this->lead->username; ?>' />
			</div>                            
			<div class='editField'>								
			<label for='<?php echo JText::_('Email'); ?>' class='key'><?php echo JText::_('Email'); ?></label>			
			<input type='text' id='email' name='email' size='60' class='inputbox required' value='<?php echo $this->lead->email; ?>' />
			</div>            
			<div class='editField'>								
			<label for='<?php echo JText::_('System Role'); ?>' class='key'><?php echo JText::_('System Role'); ?></label>			
			<?php echo $this->lists['systemroles']; ?>
			</div>            			
		</div>
    <input type='hidden' name='option' value='com_jforce' />
    <input type="hidden" name='c' value='people' />
    <input type='hidden' name='model' value='person' />
    <input type='hidden' name='stage' value='1' />
    <input type='hidden' name='person' value='<?php echo $this->lead->id; ?>' />
    <input type='hidden' name='task' value='' />
    <input type='hidden' name='view' value='modal' />
    <?php echo JHTML::_('form.token'); ?>
    </form>
    <?php echo JHTML::_('behavior.keepalive'); ?>	        
	</div>