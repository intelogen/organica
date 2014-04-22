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

# no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<div class='contentheading'><?php echo JText::_('Time'); ?></div>
<div class='quickLinks'>
		<a href='<?php echo $this->newTimetrackerLink; ?>' class='button'><?php echo JText::_('New Time'); ?></a>
</div>
<div class='tabContainer2'>
	<?php
	 		for($i=0; $i<count($this->timetrackers); $i++) :
				$timetracker = $this->timetrackers[$i];
				$k = $i%2;
			?>
			<div class='row<?php echo $k; ?>'>
            	<div class='timeEdit'>
                	<a href='<?php echo $timetracker->editUrl; ?>'><img src='<?php echo JURI::root().'components/com_jforce/images/edit_icon.png'; ?>' border='0' /></a>
                </div>
                <div class='timeBillable'>
                	<?php echo $timetracker->billableImg; ?>
                </div>
                <div class='timeBilled'>
                	<?php echo $timetracker->billed; ?>
                </div>
                <div class='timeHours'>
                    <?php echo $timetracker->hours; ?> <?php echo JText::_('Hours'); ?>
                </div>
                <div class='timeList'> </div>
                <div class='timeTitle'><?php echo $timetracker->user; ?></div>
                <div class='subheading'>
                   <span class='hasTip' title='<?php echo $timetracker->summary; ?>'><?php echo $timetracker->summarySnippet; ?></span> <?php echo JText::_('on'); ?> <?php echo $timetracker->date; ?>
                </div>
            </div>
		<?php endfor; ?>
    <div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>
    <?php echo $this->startupText; ?>
</div>