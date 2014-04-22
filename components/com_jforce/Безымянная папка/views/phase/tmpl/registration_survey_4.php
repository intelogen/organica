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

<div class='contentheading'><?php echo JText::_('Body Score Survey'); ?></div>
<div class='tabContainer2'>
<div>

The next survey will give your coach a list of symptoms that you are experiencing now.

This survey takes approximately 7 to 8 minutes. This collection of information will be your health "starting point".

You will be re-taking this same survey throughout the Maxim Body Systems process.

Every time you do a Maxim Health Systems protocol recommended by the system and managed by your coach, you should see major health improvements. 

</div>
<form action="<?=JRoute::_("index.php?option=com_jforce&view=phase&task=registration_survey_4&layout=registration_survey_5");?>" method="post">

<table cellpadding="20">
<tbody>

<tr><td colspan=2><strong>Please read the questions and check any that apply</strong></td></tr>

<?php
    foreach($this->body_score_questions as $q):
    $answers = explode(",",$this->body_score_answers[0]->survey_value);
   ?>
    <tr>
        <td style='border:1px solid #EEE;padding:3px;' width="30" align="center"><input type="checkbox" name="bodyscore[]" value="<?=$q->id;?>" <?php if(in_array($q->id,$answers)) echo "checked" ?>/></td>
        <td style='border:1px solid #EEE;padding:3px;'><?=$q->question;?></td>
    </tr>
    <?php
    endforeach;
?>
            <tr>
               <td>
                <input type="button" value="Return Back" onclick="history.back(-1)">
               </td>
               <td>
                <input type="submit" value="Next Step">
                </td>
            </tr>
        </tbody>
     </table>
     </form>
</div>

