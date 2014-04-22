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

<table cellpadding="20" style="width: 525px;">
<tbody>

<tr><td colspan=2><strong>Please read the questions and check any that apply</strong></td></tr>

<tr>
<td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="1"/></td>
<td valign="top">Do you have any lack of energy or a need for more?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="2"/></td>
<td valign="top">Do you drink a caffeinated beverage before breakfast or for breakfast ex. coffee, soda, tea?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="3"/></td>
<td valign="top">Do you wait more than an hour before eating a qualified breakfast after waking up?</td></tr>
<tr>
<td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="4"/></td>
<td valign="top">
    Do you have lack of a balanced diet? Not eating every couple of hours or at least 5 to 7 times including snacks?<br />
</td>
</tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="5"/></td>
<td valign="top">Do you eat any type of dairy products, including cheese, cream or milk?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="6"/></td>
<td valign="top">Do you eat pork? Do you eat regular chicken and beef from grocery stores or restaurants?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="7"/></td>
<td valign="top">Have you used any antibiotics in the last 2 years or been on long dose antibiotics for more than 1 week in the last 10 years?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="8"/></td>
<td valign="top">Do you wake up in the middle of the night to go to the bathroom?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="9"/></td>
<td valign="top">Do you crave sweets, salt or junk food even after you eat a meal?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="10"/></td>
<td valign="top">Do you have any skin or complexion problems, such as, exema, psoriasis, irregular growths?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="11"/></td>
<td valign="top">Do you have indigestion, acid reflux or belching after meals?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="12"/></td>
<td valign="top">Do you have a body fat problem or excess body mass or weight gain?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="13"/></td>
<td valign="top">Do you have sore or painful joints and lower back or neck pain?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="14"/></td>
<td valign="top">Do you have more than 3 alcohol drinks per week?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="15"/></td>
<td valign="top">Do you have silver or amalgam fillings in your teeth?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="16"/></td>
<td valign="top">Do you suffer from aches or pain in your knees, shoulders, back, feet, hands or anywhere else?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="17"/></td>
<td valign="top">Do you get sick at least 1x per year or more?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="18"/></td>
<td valign="top">Do you have less than 2 or 3 bowel movements per day?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="19"/></td>
<td valign="top">Are you sometimes tired after you eat? Or do you need a nap in the afternoon or after you eat?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="20"/></td>
<td valign="top">Do you suffer from any stress, anxiety or apprehension about work, relationships or life?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="21"/></td>
<td valign="top">Do you seem to have poor resistance to colds and flu's</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="22"/></td>
<td valign="top">Do you have any discoloration or fungus on your toe nails or finger nails?</td></tr>
<tr><td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="23"/></td>
<td valign="top">Do you have a respiratory allergy, snoring, sinus or post nasal problem?</td></tr>
<tr>
<td valign="top" align="center"><input type="checkbox" name="bodyscore[]" value="24"/></td>
<td valign="top">Do you  exercise less than 3 days per week, walking not included?<br />
    </td>
</tr>

            <tr>
                <td>
                    <input type="submit" value="Next Step">
                </td>
            </tr>
        </tbody>
     </table>
     </form>
</div>

