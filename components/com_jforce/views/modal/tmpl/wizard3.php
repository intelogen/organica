<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			wizard3.php														*
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
	<div class='contentheading'><?php echo JText::_('Conversion Wizard: Step 3'); ?></div>
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
					<label for='<?php echo JText::_('Project Information'); ?>' class='key required'><?php echo JText::_('Project Information'); ?></label>			
					<?php # echo $this->lists['projects']; ?>
				</div>
		</div>
		<div class='companyContainer'>
			<div class='editField'>					
			<label for='<?php echo JText::_('Name'); ?>' class='key required'><?php echo JText::_('Name'); ?></label>			
			<input type='text' id='name' name='name' size='60' class='inputbox required' value='' />
			</div>
        	<div class='editField'>
            <label for='<?php echo JText::_('Status'); ?>' class='key required'><?php echo JText::_('Status'); ?></label>
            <?php echo $this->lists['projectstatus']; ?>
            </div>                        
			<div class='editField'>
			<label for='<?php echo JText::_('Description'); ?>' class='key'><?php echo JText::_('Description'); ?></label>			
			<textarea id='description' name='description' size='60' class='inputbox required'></textarea>
			</div>            			
		</div>
    <input type='hidden' name='option' value='com_jforce' />
    <input type="hidden" name='c' value='people' />
    <input type='hidden' name='model' value='person' />
    <input type='hidden' name='stage' value='3' />
    <input type='hidden' name='company' value='<?php echo $this->person->companyid; ?>' />
    <input type='hidden' name='person' value='<?php echo $this->person->id; ?>' />
    <input type='hidden' name='task' value='' />
    <input type='hidden' name='view' value='modal' />
    <?php echo JHTML::_('form.token'); ?>
    </form>
    <?php echo JHTML::_('behavior.keepalive'); ?>	        
	</div>