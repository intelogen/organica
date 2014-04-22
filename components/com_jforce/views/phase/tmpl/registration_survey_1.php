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
    <form id="regs1_searchform" action="<?=JRoute::_("index.php?option=com_jforce&view=phase&task=registration_survey_1&layout=registration_survey_2");?>" method="post">

    <table>
    <tr>
    <td>
    
<table border="0">    
    <tbody>
    <TR>
    <TD><BR /></TD>
    <td><BR /></td>
    </TR>
    <!--<tr>
        <td colspan=2>
            <a href="#A">A</a>
            <a href="#B">B</a>                                     <a href="#C">C</a>
            <a href="#D">D</a>                                     <a href="#E">E</a>
            <a href="#F">F</a>                                     <a href="#G">G</a>                                     
            <a href="#H">H</a>
            <a href="#I">I</a>                                     <a href="#J">J</a>
                    <a href="#K">K</a>                                     <a href="#L">L</a>
                    <a href="#M">M</a>                                     <a href="#N">N</a>
                    <a href="#O">O</a>                                     <a href="#P">P</a>
                    <a href="#Q">Q</a>                                     <a href="#R">R</a>
                    <a href="#S">S</a>                                     <a href="#T">T</a>
                    <a href="#U">U</a>                                     <a href="#V">V</a>
                    <a href="#W">W</a>                                     <a href="#X">X</a>
                    <a href="#Y">Y</a>                                     <a href="#Z">Z</a>
                </td>
            </tr>-->
    <tr>
        <td colspan="2">
            Medtrack:<br>
            <ul id="regs1_med_list">
            </ul>
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
        </td>
    </tr>
            <!--<tr STYLE="FONT-SIZE:1.1EM">
               <td width=80>
                <strong>Category</strong>
               </td>
               <td>
                <strong>Name</strong>
               </td>        
            </tr>
            -->
            <?php /*
                $med_category = "";
                $answers = explode(",",$this->medtrack_answers[0]->survey_value);
                */
                /**
                foreach($this->medtrack_questions as $q){
                    echo "<tr>";
                    $this_category = strtoupper(substr($q->question,0,1));
                    if($this_category == $med_category){
                        echo "<td>&nbsp;</td>";
                    }else{
                        echo '<td><a href="#" name="'.$this_category.'"></a><strong>'.$this_category.'</strong></td>';
                        $med_category = $this_category;
                    }
                    ?>
                        <td style='border:1px solid #EEE;padding:3px;'><input type='checkbox' name='medtrack[]' value="<?=$q->variable;?>" <?if(in_array($q->variable,$answers)) echo "checked"; ?> /><label><?=$q->question;?></label></td>
                        </tr>
                    <?
                }
                
                **/
                
                
                /*
                $column_count = 0;
                $colors = array("#EEEEEE","#FFFFFF");
                $color_pos = 0;        
                foreach($this->medtrack_questions as $q){
                    $this_category = strtoupper(substr($q->question,0,1));
                    if($this_category == $med_category){
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
                        $med_category = $this_category;
                        $column_count = 0;
                    }            
                    
                    if($column_count == 0){
                        echo "<tr style='background-color:".$colors[$color_pos]."'>";
                        $color_pos ++;
                        $color_pos%=2;
                    }
                    
                    ?>
                        <td style='border:1px solid #EEE;padding:3px;'><input type='checkbox' name='medtrack[]' value="<?=$q->variable;?>" <?if(in_array($q->variable,$answers)) echo "checked"; ?> /><label><?=$q->question;?></label></td>
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
                    <td colspan=3><h2>If not listed above, enter Medications you have been taking. </h2>

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
            </tbody></table>
            
        </td>
    <td valign="top">
        <img src="/images/looking_for.jpg">
    </td>
    </tr>
    </table>
    
    
</form>
</div>