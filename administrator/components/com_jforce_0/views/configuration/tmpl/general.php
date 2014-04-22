<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			general.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>

<form action='index.php' method='post' name='adminForm'>
<div id='cpanel'>
	<div class='jfAdminTitle'><?php echo JText::_('General Configuration'); ?></div>
<fieldset class="adminform">
    	<legend><?php echo JText::_('Settings'); ?></legend>
				<table class="admintable">
				<tbody>
		           <tr> 
                        <td class='key'>
                            <label for='currency'><?php echo JText::_('Show Help Text'); ?></label>
                        </td>
                        <td>
                            <?php echo $this->lists['showhelp'];?>
                        </td>
                   </tr>
                  <!-- <tr> 
                        <td class='key'>
                            <label for='currency'><?php echo JText::_('Enable Tax'); ?></label>
                        </td>
                        <td>
                            <?php echo $this->lists['taxenabled'];?>
                        </td>
                   </tr> -->
                   <tr> 
                        <td class='key'>
                            <label for='currency'><?php echo JText::_('Currency'); ?></label>
                        </td>
                        <td>
                            <?php echo $this->lists['currency'];?>
                        </td>
                   </tr>
                   <tr>
                        <td class='key' valign="top">
                            <?php echo JText::_('Tax Rates'); ?>
                        </td>
                        <td id="taxHolder"><a href="#" id="addTaxValue"><?php echo JText::_('Add Tax');?></a><br />
                            <?php for ($i=0; $i<count($this->tax); $i++) : ?>
                                <input type='text' name='tax[]' size='35' class='inputbox separate' value='<?php echo $this->tax[$i];?>' />
                            <?php endfor; ?>
                        </td>
					</tr>
            </tbody>
            </table>                                                            
</fieldset>
<fieldset class="adminform">
    	<legend><?php echo JText::_('Owner Company'); ?></legend>
				<table class="admintable">
				<tbody>
		           <tr> 
    	            <td class='key'>
    			        <label for='name'><?php echo JText::_('Name'); ?></label>
        		    </td>
                	<td>
            			<input type='text' name='company[name]' class='inputbox' value='<?php echo $this->company->name; ?>' class='required' />
            		</td>
                   </tr>
                <tr>
                    <td class='key'>
                    <label for='address'><?php echo JText::_('Address'); ?></label>
                    </td>
                    <td>
                    <input type='text' name='company[address]' class='inputbox' value='<?php echo $this->company->address; ?>' class='required' />
                    </td>
                </tr>
                <tr>
                    <td class='key'>
                    <label for='phone'><?php echo JText::_('Phone'); ?></label>
                    </td>
                    <td>
                    <input type='text' name='company[phone]' class='inputbox' value='<?php echo $this->company->phone; ?>' class='required' />
                    </td>
                </tr>
                <tr>
                    <td class='key'>
                    <label for='fax'><?php echo JText::_('Fax'); ?></label>
                    </td>
                    <td>
                    <input type='text' name='company[fax]' class='inputbox' value='<?php echo $this->company->fax; ?>' class='required' />
                    </td>
                </tr>
                <tr>
                    <td class='key'>
                    <label for='homepage'><?php echo JText::_('Homepage'); ?></label>
                    </td>
                    <td>
                    <input type='text' name='company[homepage]' class='inputbox' value='<?php echo $this->company->homepage; ?>' class='required' />
                    </td>
                  </tr>
            </tbody>
            </table>                                                            
</fieldset>

</div>
		<input type='hidden' name='task' value='' />
		<input type='hidden' name='option' value='com_jforce' />
        <input type='hidden' name='c' value='configuration' />
        <input type='hidden' name='admin' value='1' />
        <input type='hidden' name='company[id]' value='<?php echo $this->company->id;?>' />
        <input type="hidden" name="view" value="" />
		<input type="hidden" name="layout" value="" />
        <input type="hidden" name="ret" value="index.php?option=com_jforce" />
        <input type="hidden" name="model" value="configuration" />
		<?php echo JHTML::_('form.token'); ?>
</form> 