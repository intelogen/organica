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

<div class='contentheading'><?php echo JText::_('Sign Off by Your Coach'); ?></div>
<div class='tabContainer2'>
    <table cellpadding=5 style='font-size:15px;'>
        <tr>
            <td>
                <a href="<?= JRoute::_("index.php?option=com_jforce&c=project&status=Not+Started") ?>">Your signoff request has been sent to your coach. Click to return where you were.</a>
            </td>
        </tr>
    </table>
</div>