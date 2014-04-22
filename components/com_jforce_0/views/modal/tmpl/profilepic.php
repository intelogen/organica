<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			profilepic.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>
<div id="modalPage">
        <div class='tabContainer2'>
        <form action="index.php" method="post" id="uploadForm" enctype="multipart/form-data">
        <span class='key'><?php echo JText::_('Image'); ?>:</span>
            <input type="file" name="file" id="file" size="35" />
        <div id="modalToolbar">
            <input type="button" class="button" name="save" id="saveButton" value="Save" />
            <input type="button" class="button" name="cancel" id="cancelButton" value="Cancel" />
        </div>
    <input type="hidden" name="option" id="option" value="com_jforce" />
    <input type="hidden" name="task" id="task" value="uploadProfilePic" />
    <input type="hidden" name="c" id="c" value="people" />
    <input type="hidden" name="tmpl" id="tmpl" value="component" />
    <input type="hidden" name="model" id="model" value="<?php echo $this->model;?>" />
    <input type="hidden" name="id" id="id" value="<?php echo $this->id; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
    </form>
    </div>
</div>