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

<div class='contentheading'><?php echo JText::_('What are you looking for ?'); ?></div>
<div class='tabContainer2'>
    <form action="<?=JRoute::_("index.php?option=com_jforce&view=phase&task=application&layout=registration_survey_1");?>" method="post">
     <table width=100%>
        <tbody style="margin-left:10px;width:auto;">
            <tr>
                <td>
                    Please tell us a little about what you wish to accomplish...
                </td>
            </tr>
            <tr>
                <td style="width: 154px;">
                </td>
            </tr>
            <tr>
                <td style="width: 154px;">
                    <span style="width: 150px;"><input type="checkbox" name="chkmenergy" id="chkmenergy"/><label for="chkmenergy">More Energy</label></span></td>
            </tr>
            <tr>
                <td style="width: 154px;">
                    <span style="width: 150px;"><input type="checkbox" name="chkfatloss" id="chkfatloss"/><label for="chkfatloss">Fat Loss</label></span></td>
            </tr>
            <tr>
                <td style="width: 154px;">
                    <span style="width: 150px;"><input type="checkbox" name="chkmtone" id="chkmtone"/><label for="chkmtone">Muscle Tone</label></span></td>
            </tr>
            <tr>
                <td style="width: 154px;">
                    <span style="width: 150px;"><input type="checkbox" name="chkmgain" id="chkmgain"/><label for="chkmgain">Muscle Gain</label></span></td>
            </tr>
            <tr>
                <td style="width: 154px;">
                    <span style="width: 150px;"><input type="checkbox" name="chktskin" id="chktskin"/><label for="chktskin">Tighter Skin</label></span></td>
            </tr>
            <tr>
                <td style="width: 154px; height: 22px;">
                    <span style="width: 150px;"><input type="checkbox" name="chkbsleep" id="chkbsleep"/><label for="chkbsleep">Better Sleep</label></span></td>
            </tr>
            <tr>
                <td style="width: 154px; height: 23px;">
                    <span style="width: 150px;"><input type="checkbox" name="chksgains" id="chksgains"/><label for="chksgains">Strength Gains</label></span></td>
            </tr>
            <tr>
                <td style="width: 154px; height: 22px;">
                    <span style="width: 150px;"><input type="checkbox" name="chkmendurance" id="chkmendurance"/><label for="chkmendurance">More Endurance</label></span></td>
            </tr>
            <tr>
                <td style="width: 154px;">
                    <span style="width: 150px;"><input type="checkbox" name="chkfastmet" id="chkfastmet"/><label for="chkfastmet">Faster Metabolism</label></span></td>
            </tr>
            <tr>
                <td style="width: 154px; height: 22px;">
                    <span style="width: 150px;"><input type="checkbox" name="chkappetite" id="chkappetite"/><label for="chkappetite">Appetite Control</label></span></td>
            </tr>
            <tr>
                <td style="width: 154px; height: 22px;">
                    <span style="width: 150px;"><input type="checkbox" name="chkblibido" id="chkblibido"/><label for="chkblibido">Better Libido</label></span></td>
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
