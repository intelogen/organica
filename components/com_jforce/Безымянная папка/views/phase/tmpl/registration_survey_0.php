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
<form action="<?=JRoute::_("index.php?option=com_jforce&view=phase&task=registration_survey&layout=registration_survey_5");?>" enctype="multipart/form-data" method="post">

    
<div class='tabContainer2'>
        <table>
    <tr>
        <td colspan=2>
        Please tell us a little about what you wish to accomplish...
        </td>
    </tr>
    <tr>
        <td>            
             <table width=100%>     
                <tbody style="margin-left:10px;width:auto;">
                <tr>
                    <?php
                        $cnt = 1;
                        foreach($this->looking_for_questions as $q):               
                            $answers = explode(",",$this->looking_for_answers[0]->survey_value);
                            ?>
                                <td style="border:1px solid #EEE;padding:3px;margin:3px;">
                                    <span>
                                        <input type="checkbox" name="lookingfor[]" value="<?=$q->variable;?>" id="chk<?=$q->variable;?>" <?php if(in_array($q->variable,$answers)) echo "checked"; ?>/>
                                        <label style="font-weight:bold;" for="<?=$q->variable;?>"><?=$q->question;?></label>
                                    </span>
                                </td>
                            <?php
                            if($cnt % 5 == 0) {
                                echo "</tr><tr>\n";
                            }
                        $cnt++;
                        endforeach;

                    ?>
                </tr>
                </tbody>
             </table>
             
          </td>
          <td>
              <!--<img src="/images/looking_for.jpg">-->
          </td>
        </tr>
    </table>
</div>

<div class='contentheading'><?php echo JText::_('Medtrack Instructions'); ?></div>
<div class='tabContainer2'>
<div>
Please check off the medications you are currently taking and we will track them for you.
</div>
    <div id="regs1_searchform">

<table border="0" style="width: 100%">
    <TR>
    <TD><BR /></TD>
    <td><BR /></td>
    </TR>
    <tr>
        <td valign="top">
            Medtrack:<br>
            <input type="text" id="regs1_medtrack" value="" />
            <input type="button" id="regs1_med_add" value="Add" />
            <script type="text/javascript">
            var regs1_questions = [];
            <?php
            foreach($this->medtrack_questions as $q){
                echo 'regs1_questions["'.$q->question.'"] = "'.$q->variable.'";'."\n";
            }
            ?>
            </script>
            <ul id="regs1_med_list">
            </ul>
<td style="width: 20%"></td>
    <td valign="top" style="width: 320px">
        If not in the list, enter Medications you have been taking<br />

                <!--<div style="padding:10px;background-color:#EEE;border:1px solid #AAA;">-->
                    <input type="text" name="medtrack_extraboxes[1][]">
                <!--</div>-->
        <!--<img src="/images/looking_for.jpg">-->
    </td>
    </tr>
    </table>


</div>
</div>


<div class='contentheading'><?php echo JText::_('SymptomTrack Instructions'); ?></div>
<div class='tabContainer2'>
<div>


Please check off the symptoms you are currently experiencing and we will track them for you.

</div>
    <div id="regs2_searchform">

<table style="width: 100%">

 <TR><TD><BR /></TD><td><BR /></td></TR>

    <tr>
        <td valign="top">
            Symptoms:<br>

            <input type="text" id="regs2_symptom" value="" />
            <input type="button" id="regs2_sym_add" value="Add" />
            <script type="text/javascript">
            var regs2_questions = {};
            <?php
            foreach($this->symptoms_questions as $q){
                echo 'regs2_questions["'.$q->question.'"] = "'.$q->variable.'";'."\n";
            }
            ?>
            </script>
            <ul id="regs2_sym_list">
            </ul>
        </td>
        <td style="width: 20%"></td>
        <td valign="top" style="width: 320px">
            Enter if you have any symptoms other than listed<br />
                <input type="text" name="symptoms_extraboxes[1][]">
        </td>
    </tr>

</table>

</div>
</div>

<div class='contentheading'><?php echo JText::_('DiseaseTrack Instructions'); ?></div>
<div class='tabContainer2'>
<div>
Please check off the diseases you are experiencing and we will track them for you.
</div>
<br /><br />
    <div id="regs3_searchform" >

<table style="width: 100%">
    <tr>
        <td valign="top">
            Diseases:<br>

            <input type="text" id="regs3_disease" value="" />
            <input type="button" id="regs3_dis_add" value="Add" />
            <script type="text/javascript">
            var regs3_questions = [];
            <?php
            foreach($this->diseases_questions as $q){
                echo 'regs3_questions["'.$q->question.'"] = {"type": "'.$q->type.'", "var": "'.$q->variable.'"};'."\n";
            }
            ?>
            </script>
            <ul id="regs3_dis_list">
            </ul>
        </td>
        <td style="width: 20%"></td>
        <td valign="top" style="width: 320px">
            Enter if you were on diseases other than listed<br />
                <input type="text" name="diseases_extraboxes[1][]" />
            </div>
        </td>
    </tr>

</table>

</div>

</div>

<div class='contentheading'><?php echo JText::_('Body Score Survey'); ?></div>
<div class='tabContainer2'>
<div>

The next survey will give your coach a list of symptoms that you are experiencing now.

This survey takes approximately 7 to 8 minutes. This collection of information will be your health "starting point".

You will be re-taking this same survey throughout the Maxim Body Systems process.

Every time you do a Maxim Health Systems protocol recommended by the system and managed by your coach, you should see major health improvements.

</div>

<table cellpadding="20">
<tbody>

<tr><td colspan=4><strong>Please read the questions and check any that apply</strong></td></tr>
<tr>
<?php
    $cnt = 1;
    foreach($this->body_score_questions as $q):
    $answers = explode(",",$this->body_score_answers[0]->survey_value);
   ?>
        <td style='border:1px solid #EEE;padding:3px;' align="center"><input type="checkbox" name="bodyscore[]" value="<?=$q->id;?>" <?php if(in_array($q->id,$answers)) echo "checked" ?>/></td>
        <td style='border:1px solid #EEE;padding:3px;'><?=$q->question;?></td>
    <?php

    if($cnt % 2 == 0) {
        echo "</tr><tr>\n";
    }
    $cnt++;
    endforeach;
?>
</tr>
            <tr>
               <td colspan="4">

               </td>
               
            </tr>
        </tbody>
     </table>

</div>
<div class='contentheading'><?php echo JText::_('Intake Survey'); ?></div>
<div class="tabContainer2">
    <table>
        <tr>
            <td valign="top" align="center" colspan="3"><div align="left">
                    <table width="277" border="0" align="center">
                        <tbody><tr>
                            <td width="72"><b><a target="_blank">Weight</a></b></td>
                            <td width="318"><input type="text" style="width: 50px;" tabindex="1" id="txtWeight" value="<?php echo $this->tracking->intake->weight ?>" name="intake[W]" class="inputbox required validate-numeric"/>
                                <strong>lbs</strong></td>
                        </tr>
                        <tr>
                            <td><b><a target="_blank">Body Fat</a></b></td>
                            <td><input type="text" style="width: 50px;" tabindex="2" id="txtBodyFat" value="<?php echo $this->tracking->intake->fat ?>" name="intake[F]" class="inputbox required validate-numeric"/>
                            <strong>%</strong></td>
                        </tr>
                        <tr>
                            <td><b><a target="_blank">PH Score</a></b></td>
                            <td><input type="text" style="width: 50px;" tabindex="3" id="txtPHScore" value="<?php echo $this->tracking->intake->point ?>" name="intake[PH]" class="inputbox required validate-numeric"/></td>
                        </tr>
                    </tbody></table>
                </div>
            </td>
            <td valign="top">
                <h3>Current Photo</h3>
                <input type='file' name='filename' />
            </td>
            <td valign="top">
                <h3>Submission Date</h3>
                <?php echo $this->calendar; ?>
            </td>
        </tr>
    </table>
</div>
<input type="button" value="Return Back" onclick="history.back(-1)">
<input type="submit" value="Next Step">
</form>
