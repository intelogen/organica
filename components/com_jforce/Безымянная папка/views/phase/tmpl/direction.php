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

<div class='contentheading'><?php echo JText::_('Directions for the phase'); ?></div>
<div class='tabContainer2'>
    <div>
        <p>
            <strong>Please read the directions...</strong>
        </p>
        <p>Then notify us as to whether or not you comprehend them by selecting from the checkbox below and clicking submit. 
        </p>
        
        <p style="font-size:1.4em;border:1px solid #DDD;background-color:#EfEfEf">
            <a href="/uploads_jtpl/phase_directions/Phase<?=$this->phase_number;?>_Directions.pdf" title="Download directions for this phase"  target="_blank"><img src="/uploads_jtpl/icons/general/download.jpg" align="middle" > Directions for Phase <?=$this->phase_number;?></a>
        </p>
        
        <p>
            <form method="post" action="<?=$this->step_action_link;?>">
                <?php echo JHTML::_( 'form.token' ); ?>
                <input type="hidden" name="step_redirection_link" value="<?=$this->step_redirection_link; ?>" >
                <input type="hidden" name="phase_id" value="<?=$this->phase_id ?>" >
                <input type="submit" value="Mark Step as Completed">
            </form>
        </p>
    </div>
</div>
