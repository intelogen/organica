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
    <div>
        <strong>
            This step will depend on all steps above. At this phase, you will inform your coach to sign off you from this phase and proceed to next phase. However, coach will decide this based upon your surveys and progress you have submitted as in your report.         
        </strong>
    </div>
    <br />
    <table cellpadding=5 style='font-size:15px;'>
        <tr>
            <td>Phase Status</td><td style='color:<?=$this->phase_status_color;?>'><?= JText::_($this->phase_status_message);?></td>
        </tr>
        <tr>
            <td>Instructions</td><td><?= JText::_($this->phase_instructions);?></td>
        </tr>
        <?php if ($this->phase_signoff_link == "yes"):?>
            <tr>
                <td colspan=2>
                    <a href="<?= JRoute::_("index.php?option=com_jforce&view=phase&task=signoff&pid=".$this->pid)."&layout=signoff2" ?>">Click to request for sign off</a>
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>