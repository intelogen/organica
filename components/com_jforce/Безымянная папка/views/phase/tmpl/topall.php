<?php

/************************************************************************************
*    @package        Joomla                                                            *
*    @subpackage        jForce, the Joomla! CRM                                            *
*    @author        Dhruba,JTPL
*    @license        GNU/GPL, see jforce.license.php                                    *
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');    
?>

<div class='contentheading'><?php echo JText::_('Medtrack Instructions'); ?></div>
<div class='tabContainer2'>
<div>
Please check off the medications you are currently taking and we will track them for you.
</div>
    <form action="<?=JRoute::_("index.php?option=com_jforce&view=phase&task=application&layout=registration_survey_2");?>" method="post">

