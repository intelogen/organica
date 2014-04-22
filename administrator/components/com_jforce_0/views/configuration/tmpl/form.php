<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			form.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<form action='index.php' method='post' name='adminForm'>
<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
<tr>
				<td class='key'>
					<?php echo JText::_('Field Name'); ?></td><td>
					<input type='text' name='field' size='35' class='inputbox required' value='<?php echo $this->customfield->field;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Field Type'); ?></td><td>
					<?php echo $this->lists['fieldtypes'];?>
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Type'); ?></td><td>
					<?php echo $this->lists['type'];?>
				</td>
			</tr>
            <tr>
				<td class='key'>
					<?php echo JText::_('Required'); ?></td><td>
					<?php echo $this->lists['required'];?>
				</td>
			</tr>
            <tr>
				<td class='key'>
					<?php echo JText::_('Public Access'); ?></td><td>
					<?php echo $this->lists['public'];?>
				</td>
			</tr>
            <tr id="valueRow">
				<td class='key' valign="top">
					<?php echo JText::_('Values'); ?></td><td id="valuesHolder"><a href="#" id="addValue"><?php echo JText::_('Add Value');?></a><br />
                    <?php for ($i=0; $i<count($this->customfield->_values); $i++) : ?>
						<input type='text' name='values[]' size='35' class='inputbox' value='<?php echo $this->customfield->_values[$i];?>' /><br />
                    <?php endfor; ?>
                    
				</td>
			</tr>
		</table>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->customfield->id; ?>' />
<input type="hidden" name="c" value="customfield" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="" />
<input type="hidden" name="layout" value="" />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
