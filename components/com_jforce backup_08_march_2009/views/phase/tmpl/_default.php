<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			default.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>

<div class='contentheading'><?php echo JText::_('Phasewise Applications'); ?></div>
<form action='index.php' method='get'>

<div class='quickLinks'>
    <button type='button' onclick="this.form.submit();" class='button'>
        <?php echo JText::_('Search') ?>
    </button>
</div>
<div class="tabContainer2">
			<div class='editField'>
			<label for='<?php echo JText::_('Project'); ?>' class='key required'><?php echo JText::_('Project'); ?></label>			
					<?php echo $this->lists['projects']; ?>
			</div>
			<div class='editField'>
			<label for='<?php echo JText::_('Search Words'); ?>' class='key required'><?php echo JText::_('Search Word'); ?></label>			
					<input type='text' name='keyword' size='50' class='inputbox required' value='' />
			</div>
            <div class='editField'>
            <input name="phrase" id="searchphraseany" value="any" type="radio">
                <label for="searchphraseany"><?php echo JText::_('Any Word'); ?></label>
                <input name="phrase" id="searchphraseall" value="all" type="radio">
                <label for="searchphraseall"><?php echo JText::_('All Words'); ?></label>
                <input name="phrase" id="searchphraseexact" value="exact" type="radio">
                <label for="searchphraseexact"><?php echo JText::_('Exact Phrase'); ?></label>
            </div>
            <div class='editField'>
            <?php echo JText::_('Ordering'); ?>: <select name="ordering" class="inputbox">
                <option value="newest" selected="selected"><?php echo JText::_('Newest First'); ?></option>
                <option value="oldest"><?php echo JText::_('Oldest First'); ?></option>
                <option value="alpha"><?php echo JText::_('Alphabetical'); ?></option>
            </select>
			</div>
            
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='view' value='search' />
<input type='hidden' name='layout' value='results' />
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
</div>
