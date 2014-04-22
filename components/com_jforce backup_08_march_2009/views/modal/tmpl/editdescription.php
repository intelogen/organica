<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			editdescription.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<div id="modalPage">
    <div class='notesTitle'><?php echo JText::_('Edit Service Description'); ?></div>
    <div class="modalService">
        <form action="index.php" method="post">
            <textarea id="descriptionText" name="descriptionText"></textarea>
        <div id="modalToolbar">
            <input type="button" class="button" name="save" id="saveButton" value="Save" />
            <input type="button" class="button" name="cancel" id="cancelButton" value="Cancel" />
        </div>
        <input type="hidden" name="i" id="i" value="<?php echo $this->i;?>" />
        </form>
    </div>
</div>