<?php

/************************************************************************************
*    @package        Joomla                                                            *
*    @subpackage     jForce, the Joomla! CRM                                            *
*    @version        2.0                                                                *
*    @file           client_phase_progress.php
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');    
?>

<h1>Client Phase Progress</h1>
<div class='tabContainer2'>    
    <div class='companyArea'>
        <div class='logo'>
            <?php echo $this->person->image; ?>
        </div>
        <div class='companyDetails'>
            <div class="row1"><div class="itemTitle"><?php echo JText::_('Name'); ?></div><?php echo $this->person->name; ?></div>    
            <div class="row0"><div class="itemTitle"><?php echo JText::_('Username'); ?></div><?php echo $this->person->username; ?></div>
        </div>
    </div>    
</div>
<br />
<div class="tabs">
    <ul id="tabMenu">
        <?php 
            $id = JRequest::getCmd("id");
        ?>
        <li id='tab-1'><a href="<?=JRoute::_("index.php?option=com_jforce&c=people&view=person&layout=client&id=$id&action=message")?>">Survey</a></li>        
    </ul>
</div>
<div class="tabContainer">
    
</div>