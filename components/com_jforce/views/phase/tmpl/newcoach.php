<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			results.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>

<div class='contentheading'><?php echo JText::_('Add New Coach'); ?></div>
<div class="tabContainer2">
    Select an user from the user list and mark it as a coach.
    
    <br /><br />
    Note : Displayed as Name (username)
    <br />
    
    <form name="add_new_coach_form" action="<?=JRoute::_("index.php?option=com_jforce&view=phase&layout=newcoach")?>" method="post">
    <?php echo JHTML::_( 'form.token' ); ?>
        <select name="coach">
            <?php
                foreach($this->coach_selectable_users as $u){
                    echo "<option value='{$u->id}'>{$u->name} ({$u->username}) </option>";
                }
            ?>
        </select>
        <br />
        <br />
        <input type="submit" value="Add Coach">
        <input type="hidden" name="task" value="make_newcoach">
    </FORM>         
</div>