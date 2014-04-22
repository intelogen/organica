<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			addpeople.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<form action="index.php" method="post" id="addPeopleForm">
<div id="modalPage">
	<div class='modalContainer'>
        <div id="selectBoxHolder"><?php echo $this->peopleList['unsubscribed']; ?></div>
        <div id="selectButtonHolder"><a id="selectMove"><img src='components/com_jforce/images/select_arrow.png' /></a></div>
        <div id="selectedOptionsHolder"><div id="subSelect"><?php //echo $this->lists['subscribed'];?></div></div>    
	</div>
    <?php echo $this->lists['projectroles']; ?>
    <div id="customProjectRoles">
	    <?php echo $this->roleOptions; ?>
    </div>
    <div id="modalToolbar">
        <input type="button" class="button" name="save" id="saveButton" value="Save" />
        <input type="button" class="button" name="cancel" id="cancelButton" value="Cancel" />
    </div>
    <input type="hidden" id="type" name="type" value="<?php echo $this->type;?>" />
    <input type="hidden" id="option" name="option" value="com_jforce" />
    <input type="hidden" id="task" name="task" value="addPeople" />
    <input type="hidden" id="c" name="c" value="people" />
    <input type="hidden" id="pid" name="pid" value="<?php echo $this->pid;?>" />
    <input type="hidden" id="tmpl" name="tmpl" value="component" />
    <?php echo JHTML::_('form.token'); ?>
    </form>
</div>