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
<div class='contentheading'>Reports</div>
<div class='quickLinks'>
	<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=report&layout=form'); ?>' class='button'><?php echo JText::_('New Report'); ?></a>	
</div>
<div class='tabs'>
	<ul id="tabMenu">
	  <li id="tab-1"><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=report&category=Leads'); ?>'><?php echo JText::_('Leads'); ?></a></li>
	  <li id="tab-2"><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=report&category=Sales'); ?>'><?php echo JText::_('Sales'); ?></a></li>
	  <li id="tab-3"><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=report&category=Projects'); ?>'><?php echo JText::_('Projects'); ?></a></li>
	  <li id="tab-2"><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=report&category=Support'); ?>'><?php echo JText::_('Support'); ?></a></li>
	</ul>
</div>
<div class='tabContainer'>
    <?php
    for($i=0; $i<count($this->reports); $i++) :
        $report = $this->reports[$i];
        $k = $i%2;
    ?>
        <div class='row<?php echo $k; ?>'>
            <div class='logo'>
                <?php echo $report->icon; ?>
            </div>
            <div class='listTitle'>
                <a href='<?php echo JRoute::_('index.php?option=com_jforce&view=report&layout=report&id='.$report->id); ?>'><?php echo $report->name;?></a>
            </div>
            <div class='subheading'>
                <?php echo $report->description;?>
            </div>
        </div>
	<?php endfor; ?>
</div>