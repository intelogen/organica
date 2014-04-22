<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			wizard2.php														*
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
	<div class='contentheading'><?php echo JText::_('Conversion Wizard: Step 2'); ?></div>
	<div class='quickLinks'>
		<button type='button' id='back' class='button'>
				<?php echo JText::_('Back') ?>
			</button>
			<button type='button' onclick="submitbutton('convertLead')" class='button'>
				<?php echo JText::_('Continue') ?>
			</button>
	</div>
	<div class='tabContainer2'>
  <form action='index.php' method='post' name='adminForm'>  
		<div class='companySelector'>
				<div class='editFieldSingle'>					
					<label for='<?php echo JText::_('Select Company'); ?>' class='key required'><?php echo JText::_('Select Company'); ?></label>			
					<?php echo $this->lists['company']; ?>
				</div>
		</div>
		<div class='companyContainer'>
			<div class='editField'>					
			<label for='<?php echo JText::_('Name'); ?>' class='key required'><?php echo JText::_('Name'); ?></label>			
			<input type='text' id='name' name='name' size='60' class='inputbox required' value='<?php echo $this->person->lead_company; ?>' />
			</div>            
			<div class='editField'>								
			<label for='<?php echo JText::_('Address'); ?>' class='key'><?php echo JText::_('Address'); ?></label>			
			<input type='text' id='address' name='address' size='60' class='inputbox required' value='' />
			</div>            
			<div class='editField'>								
			<label for='<?php echo JText::_('Phone'); ?>' class='key required'><?php echo JText::_('Phone'); ?></label>			
			<input type='text' id='phone' name='phone' size='60' class='inputbox required' value='' />
			</div>            
			<div class='editField'>								
			<label for='<?php echo JText::_('Fax'); ?>' class='key'><?php echo JText::_('Fax'); ?></label>			
			<input type='text' id='fax' name='fax' size='60' class='inputbox required' value='' />
			</div>            
			<div class='editField'>								
			<label for='<?php echo JText::_('Homepage'); ?>' class='key'><?php echo JText::_('Homepage'); ?></label>			
			<input type='text' id='homepage' name='homepage' size='60' class='inputbox' value='' />
			</div>            			
		</div>
    <input type='hidden' name='option' value='com_jforce' />
    <input type="hidden" name='c' value='people' />
    <input type='hidden' name='model' value='person' />
    <input type='hidden' name='stage' value='2' />
    <input type='hidden' name='person' value='<?php echo $this->person->id; ?>' />
    <input type='hidden' name='uid' value='<?php echo $this->person->uid; ?>' />
    <input type='hidden' name='task' value='' />
    <input type='hidden' name='view' value='modal' />
    <?php echo JHTML::_('form.token'); ?>
    </form>
    <?php echo JHTML::_('behavior.keepalive'); ?>	        
	</div>