<?php

/************************************************************************************
*    @package        Joomla                                                            *
*    @subpackage        jForce, the Joomla! CRM                                            *
*    @version        2.0                                                                *
*    @file            results.php                                                        *
*    @updated        2008-12-15                                                        *
*    @copyright        Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.    *
*    @license        GNU/GPL, see jforce.license.php                                    *
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');    
?>

<?php JHTMLBehavior::formvalidation(); ?>
<script language="javascript">
    function myValidate(f) {
        if(f.new_email_1.value == f.new_email_2.value){
            // do nothing
        }else{
            alert('Please enter same email address in both fieds');
            return false
        }
        
        if (document.formvalidator.isValid(f)) {
            f.check.value='<?php echo JUtility::getToken(); ?>';//send token
        }
        else {
            alert('Invalid Email Address Supplied');
        }
        
        return false;
}
</script>

<div class='contentheading'><?php echo JText::_('Admin Email'); ?></div>
<div class="tabContainer2">
    Change Admin Email Address . Admin email is used when email is sent by the system. It modifies the following. 
    <ul>
        <li>System Email</l1>
        <li>Store Email (Virtuemart)</li>
    </ul>
    
    <br />     <br />     
    
    <form name="add_new_coach_form" action="<?=JRoute::_("index.php?option=com_jforce&view=phase&layout=admin_email")?>" method="post" onsubmit="return myValidate(this)">
    <?php echo JHTML::_( 'form.token' ); ?>    
            
            <table>
                <tr>
                    <td><strong>Current Email Address</strong></td>
                    <td><?= $this->current_admin_email;?></td>
                </tr>
                <tr>
                    <td><strong>New Email Address</strong></td>
                    <td><input type="text" name="new_email_1" class="required validate-email"></td>
                </tr>
                <tr>
                    <td><strong>Confirm New Email Address</strong></td>
                    <td><input type="text" name="new_email_2" class="required validate-email"></td>
                </tr>
                
            </table>            
            
        <input type="submit" value="Update Admin Email">
        <input type="hidden" name="task" value="admin_email">        
    </FORM>         
</div>