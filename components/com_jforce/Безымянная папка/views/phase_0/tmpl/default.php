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
<div class='contentheading'><?php echo JText::_('What are you looking for'); ?></div>

<!--
<div class='quickLinks'>
	<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=project&layout=form'); ?>' class='button'><?php echo JText::_('New Phase'); ?></a>
</div>
<div class='tabs'>
    <ul id="tabMenu">
	<?php for($i=0;$i<count($this->statusOptions);$i++):
		$status = $this->statusOptions[$i];
	?>
      <li id="tab-<?php echo $i; ?>"><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=project&status='.$status); ?>' class='<?php echo $this->activeStatus==$status ? 'active' : ''; ?>'><?php echo JText::_($status); ?></a></li>
	<?php endfor; ?>
    </ul>
</div>
-->


<div class='tabs'>
    <ul id="tabMenu">
    </ul>
</div>
<div class='tabContainer'>
<form name="" action="<?=JRoute::_('index.php?option=com_jforce&c=phase&task=step2');?>" method="post">
<table>
            <tr>
                <td style="width: 43px;">
                </td>
                <td style="width: 154px;">
                    <span style="width: 150px;"><input id="chkmenergy" name="chklookingfor[]" value="chkmenergy" type="checkbox"><label for="chkmenergy">More Energy</label></span></td>

            </tr>
            <tr>
                <td style="width: 43px;">
                </td>
                <td style="width: 154px;">
                    <span style="width: 150px;"><input id="chkfatloss" name="chklookingfor[]" value="chkfatloss" type="checkbox"><label for="chkfatloss">Fat Loss</label></span></td>
            </tr>
            <tr>

                <td style="width: 43px;">
                </td>
                <td style="width: 154px;">
                    <span style="width: 150px;"><input id="chkmtone" name="chklookingfor[]" value="chkmtone" type="checkbox"><label for="chkmtone">Muscle Tone</label></span></td>
            </tr>
            <tr>
                <td style="width: 43px;">
                </td>

                <td style="width: 154px;">
                    <span style="width: 150px;"><input id="chkmgain" name="chklookingfor[]" value="chkmgain" type="checkbox"><label for="chkmgain">Muscle Gain</label></span></td>
            </tr>
            <tr>
                <td style="width: 43px;">
                </td>
                <td style="width: 154px;">
                    <span style="width: 150px;"><input id="chktskin" name="chklookingfor[]" value="chktskin" type="checkbox"><label for="chktskin">Tighter Skin</label></span></td>

            </tr>
            <tr>
                <td style="width: 43px; height: 22px;">
                </td>
                <td style="width: 154px; height: 22px;">
                    <span style="width: 150px;"><input id="chkbsleep" name="chklookingfor[]" value="chkbsleep" type="checkbox"><label for="chkbsleep">Better Sleep</label></span></td>
            </tr>
            <tr>

                <td style="width: 43px; height: 23px;">
                </td>
                <td style="width: 154px; height: 23px;">
                    <span style="width: 150px;"><input id="chksgains" name="chklookingfor[]" value="chksgains" type="checkbox"><label for="chksgains">Strength Gains</label></span></td>
            </tr>
            <tr>
                <td style="width: 43px; height: 22px;">
                </td>

                <td style="width: 154px; height: 22px;">
                    <span style="width: 150px;"><input id="chkmendurance" name="chklookingfor[]" value="chkmendurance" type="checkbox"><label for="chkmendurance">More Endurance</label></span></td>
            </tr>
            <tr>
                <td style="width: 43px;">
                </td>
                <td style="width: 154px;">
                    <span style="width: 150px;"><input id="chkfastmet" name="chklookingfor[]" value="chkfastmet" type="checkbox"><label for="chkfastmet">Faster Metabolism</label></span></td>

            </tr>
            <tr>
                <td style="width: 43px; height: 22px;">
                </td>
                <td style="width: 154px; height: 22px;">
                    <span style="width: 150px;"><input id="chkappetite" name="chklookingfor[]" value="chkappetite" type="checkbox"><label for="chkappetite">Appetite Control</label></span></td>
            </tr>
            <tr>

                <td style="width: 43px; height: 22px;">
                </td>
                <td style="width: 154px; height: 22px;">
                    <span style="width: 150px;"><input id="chkblibido" name="chklookingfor[]" value="chkblibido" type="checkbox"><label for="chkblibido">Better Libido</label></span></td>
            </tr>
            
            <tr>
                <td style="width: 43px; height: 22px;">
                </td>
                <td style="width: 154px; height: 22px;">
                    <input id="submit" name="submit" value="Next" type="submit"></td>
            </tr>
            
</table>
</form>
<?php
/**
			<?php
	 		for($i=0; $i<count($this->projects); $i++) :
				$project = $this->projects[$i];
				$k = $i%2;
			?>
            
            <div class='row<?php echo $k; ?>'>
				<div class="progressHolder">
					<span class='progressBar'><?php echo $project->progressBar; ?></span>
					<span><?php echo $project->taskStatus; ?></span>
				</div>
				<div class="listLogo">
					<?php echo $project->imagethumb; ?>
				</div>
				<div class="listTitle">
					<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=project&layout=project&pid='.$project->id); ?>'><?php echo $project->name; ?></a>
				</div>
				<div class="subheading"><?php echo JText::_('Leader'); ?>: <a href='<?php echo $project->leaderUrl; ?>' ><?php echo $project->leader; ?></a></div>
				<div class="subheading"><?php echo JText::_('Client'); ?>: <a href='<?php echo $project->companyUrl; ?>' ><?php echo $project->company; ?></a></div>				
			</div>
		<?php endfor; ?>
	<div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>
	<?php echo $this->startupText; ?>
    
    **/
    ?>
</div>