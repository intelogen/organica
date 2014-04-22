<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			templates.php													*
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
	<div class='jfAdminTitle'><?php echo JText::_('Template Configuration'); ?></div>
<fieldset class="adminform">
    	<legend><?php echo JText::_('Email Template'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
				<tbody>
		           <tr> 
    	            <td class='key'>
    			        <label for='<?php echo JText::_('Email Subject'); ?>'><?php echo JText::_('Email Subject'); ?></label>
        		    </td>
                	<td>
            			<input type='text' name='emailsubject' class='inputbox' value='<?php echo $this->email['emailsubject']; ?>' class='required' />
            		</td>
                   </tr>
                <tr>
                    <td class='key'>
                    <label for='<?php echo JText::_('Email Body'); ?>'><?php echo JText::_('Email Body'); ?></label>
                    </td>
                   	 <td>
						<?php echo $this->editor->display( 'emailbody',  $this->email['emailbody'] , '100%', '200', '150', '20' ) ; ?>
                    </td>
                </tr>
            </tbody>
            </table>                                                            
</fieldset>
<fieldset class="adminform">
    	<legend><?php echo JText::_('Invoice Print Template'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
				<tbody>
                <tr>
                   	 <td>
						<?php echo $this->editor->display( 'invoicetemplate',  $this->invoicetemplate, '100%', '500', '150', '150' ) ; ?>
                    </td>
                </tr>
            </tbody>
            </table>                                                            
</fieldset>
<fieldset class="adminform">
    	<legend><?php echo JText::_('Quote Print Template'); ?></legend>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
				<tbody>
                <tr>
                   	 <td>
						<?php echo $this->editor->display( 'quotetemplate',  $this->quotetemplate, '100%', '500', '150', '150' ) ; ?>
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