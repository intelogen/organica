<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			categories.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<form action='index.php' method='post' name='adminForm'>
	<div class='jfAdminTitle'><?php echo JText::_('Categories'); ?></div>
	<fieldset class="adminform">
    	<legend><?php echo JText::_('Support Categories'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
            <tr>
				<td class='key' valign="top">
					<?php echo JText::_('Values'); ?></td><td id="supportcategoriesHolder"><a href="#" id="addSupportValue"><?php echo JText::_('Add Category');?></a><br />
                    <?php for ($i=0; $i<count($this->support); $i++) : ?>
						<input type='text' name='supportcategories[]' size='35' class='inputbox separate' value='<?php echo $this->support[$i];?>' />
                    <?php endfor; ?>
                    
				</td>
			</tr>
		</table>
	</fieldset>
	<fieldset class="adminform">
    	<legend><?php echo JText::_('General Categories'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
            <tr>
				<td class='key' valign="top">
					<?php echo JText::_('Values'); ?></td><td id="discussioncategoriesHolder"><a href="#" id="addDiscussionValue"><?php echo JText::_('Add Category');?></a><br />
                    <?php for ($i=0; $i<count($this->discussion); $i++) : ?>
						<input type='text' name='generalcategories[]' size='35' class='inputbox separate' value='<?php echo $this->discussion[$i];?>' />
                    <?php endfor; ?>
                    
				</td>
			</tr>
		</table>
	</fieldset>	
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='ret' value='index.php?option=com_jforce' />
<input type="hidden" name="c" value="configuration" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="" />
<input type="hidden" name="layout" value="" />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
