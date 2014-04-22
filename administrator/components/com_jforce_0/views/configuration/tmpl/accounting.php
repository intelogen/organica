<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			accounting.php													*
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

<form action='index.php' method='post' name='adminForm'>
<div id='cpanel'>
	<div class='jfAdminTitle'><?php echo JText::_('Accounting Options'); ?></div>
<fieldset class="adminform">
    	<legend><?php echo JText::_('Currency Mode'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
				<tbody>
                <tr>
                	<td class="key"><?php echo JText::_('Currency'); ?></td>
                   	 <td>
						<?php echo $this->currency; ?>
                    </td>
                </tr>
            </tbody>
            </table>                                                            
</fieldset>

<fieldset class="adminform">
    	<legend><?php echo JText::_('Quote & Invoice Print Template'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
				<tbody>
                <tr>
                   	 <td>
						<?php echo $this->editor->display( 'printtemplate',  $this->printtemplate, '100%', '500', '150', '150' ) ; ?>
                    </td>
                </tr>
            </tbody>
            </table>                                                            
</fieldset>
</div>
		<input type='hidden' name='task' value='' />
		<input type='hidden' name='option' value='com_jforce' />
        <input type='hidden' name='c' value='configuration' />
		<input type='hidden' name='boxchecked' value='0' />
        <input type="hidden" name="view" value="" />
		<input type="hidden" name="layout" value="" />
        <input type="hidden" name="ret" value="<?php echo JRoute::_('index.php?option=com_jforce'); ?>" />
        <?php echo JHTML::_('form.token'); ?>
</form> 