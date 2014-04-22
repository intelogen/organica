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

<div class='contentheading'><?php echo JText::_('Assign Client to a Coach'); ?></div>
<div class="tabContainer2">
    Select an unassigned user from the user list and assign him/her to a coach.     
    <br />
    
    <form name="add_new_coach_form" action="<?=JRoute::_("index.php?option=com_jforce&view=phase&layout=assigncoach")?>" method="post">
    <?php echo JHTML::_( 'form.token' ); ?>	
			
			<strong>Client</strong>
			<br />		
        <select name="client">
            <?php
                foreach($this->clients as $u){
                		if(!intval($u->company))
                    		echo "<option value='{$u->id}'>{$u->name} ({$u->username}) </option>";
                }
            ?>
        </select>
			<br />
			<br />
			<strong>Coach</strong>
			<br />
        <select name="coach">
            <?php
                foreach($this->coaches as $u){
                    echo "<option value='{$u->id}'>{$u->name}</option>";
                }
            ?>
        </select>
        
        <br />
        <br />
        <input type="submit" value="Assign">
        <input type="hidden" name="task" value="assign_coach_to_client">        
    </FORM>         
</div>