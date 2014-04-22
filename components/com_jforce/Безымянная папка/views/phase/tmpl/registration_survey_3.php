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

<div class='contentheading'><?php echo JText::_('DiseaseTrack Instructions'); ?></div>
<div class='tabContainer2'>
<div>
Please check off the diseases you are experiencing and we will track them for you.
</div>
<br /><br />
    <form id="regs3_searchform" action="<?=JRoute::_("index.php?option=com_jforce&view=phase&task=registration_survey_3&layout=registration_survey_4");?>" method="post">


<table>
    <tr>
        <td colspan="2">
            Diseases:<br>
            <ul id="regs3_dis_list">
            </ul>
            <input type="text" id="regs3_disease" value="" style="width: 250px" />
            <input type="button" id="regs3_dis_add" value="Add" />
            <script type="text/javascript">
            var regs3_questions = [];
            <?php
            foreach($this->diseases_questions as $q){
                echo 'regs3_questions["'.$q->question.'"] = {"type": "'.$q->type.'", "var": "'.$q->variable.'"};'."\n";
            }
            ?>
            </script>
        </td>
    </tr>
<?php
   /* $disease_category = "";
    
    $answers = explode(",",$this->diseases_answers);
   */
/**    
        foreach($this->diseases_questions as $q){
            
            echo "<tr>";
            $this_category = $q->type;
            if($this_category == $disease_category){
                echo "<td>&nbsp;</td>";
            }else{
                echo '<td><a href="#" name="'.$this_category.'"></a><strong>'.strtoupper($this_category).'</strong></td>';
                $disease_category = $this_category;
            }
            ?>
                <td style='border:1px solid #EEE;padding:3px;'><input type='checkbox' name='diseases[<?=$this_category;?>][]' value="<?=$q->variable;?>" <? if (in_array($q->variable,$answers)) echo "checked"; ?>/><label><?=$q->question;?></label></td>
                </tr>
            <?
        }
        
**/


/*
                $column_count = 0;
                $colors = array("#EEEEEE","#FFFFFF");
                $color_pos = 0;        
                $disease_category = "";
                foreach($this->diseases_questions as $q){
                    $this_category = $q->type;
                    if($this_category == $disease_category){
                        // do nothing
                    }else{
                        
                        if($column_count != 0){
                            for(;$column_count < 3;$column_count++ ){
                                echo "<td style='border:1px solid #EEE;padding:3px;'>&nbsp;</td>";
                            }
                        }
                        
                        if($column_count > 0)
                            echo "</tr>";
                        echo '<tr><td colspan=3><a href="#" name="'.$this_category.'"></a><strong style="font-size:2em;line-height:2.1em;">'.$this_category.'</strong></td></tr>';
                        $disease_category = $this_category;
                        $column_count = 0;
                    }            
                    
                    if($column_count == 0){
                        echo "<tr style='background-color:".$colors[$color_pos]."'>";
                        $color_pos ++;
                        $color_pos%=2;
                    }
                    
                    ?>
                        <td style='border:1px solid #EEE;padding:3px;'>
                            <input type='checkbox' name='diseases[<?=$this_category;?>][]' value="<?=$q->variable;?>" <? if (in_array($q->variable,$answers)) echo "checked"; ?>/><label><?=$q->question;?></label></td>
                    <?
                    if($column_count == 2){
                        echo "</tr>";
                    }
                    
                    $column_count++;
                    $column_count %= 3;
                }
*/
    ?>
    
    
    <tr>
        <td colspan=3>
            <h2>Enter if you were on diseases other than listed above </h2>
            <?=$this->extraboxes_code;?>
        </td>
    </tr>
    
    
    
    <tr>
        <td>
           <input type="button" value="Return Back" onclick="history.back(-1)">
        </td>
        <td>
            <input type="submit" name="submit" value="Next Step">
        </td>
    </tr>
</table>




</form>

</div>


