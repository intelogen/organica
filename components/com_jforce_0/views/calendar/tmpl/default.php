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
<table width="100%">
<thead>
        <tr>
            <td class="calendarHeading"><a href="<?php echo $this->calendar['prevLink']; ?>" class="calMonthLink"><?php echo $this->calendar['lastMonth'];?></a></td>
            <td colspan="5" class="calendarHeading" align="center">
                <?php echo $this->calendar['monthname'] . " " .  $this->calendar['year']; ?>
            </td>
            <td class="calendarHeading" align="right"><a href="<?php echo $this->calendar['nextLink']; ?>" class="calMonthLink"><?php echo $this->calendar['nextMonth'];?></a></td>
		</tr>
        </thead>
</table>
<table class="calendarTable" cellspacing="0">
		
		<tr>
            <td class="calendarHeaders"><?php echo JText::_('Sunday'); ?></td>
            <td class="calendarHeaders"><?php echo JText::_('Monday'); ?></td>
            <td class="calendarHeaders"><?php echo JText::_('Tuesday'); ?></td>
            <td class="calendarHeaders"><?php echo JText::_('Wednesday'); ?></td>
            <td class="calendarHeaders"><?php echo JText::_('Thursday'); ?></td>
            <td class="calendarHeaders"><?php echo JText::_('Friday'); ?></td>
            <td class="calendarHeaders"><?php echo JText::_('Saturday'); ?></td>
		</tr>
    
    <?php foreach($this->calendar['weeks'] as $num=>$week) : ?>
    
    	<tr>
        	<?php
			foreach($week['days'] as $day) :
				echo $day;
			endforeach;
			?>
        </tr>
    
    <?php endforeach; ?>
    
</table>

<?php
