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


<?php JHTMLBehavior::formvalidation(); ?>
<script language="javascript">
function myValidate(f) {
        if (document.formvalidator.isValid(f)) {
                f.check.value='<?php echo JUtility::getToken(); ?>';//send token
                return true; 
        }
        else {
                alert('Please fill the fields with appropriate information');
        }
        return false;
}
</script>
    <!-- Stylesheet for tables -->
    <style>
        table.allleft{
            text-align:left;
            border:1px solid #EFEFEF;
        }
        table.allleft th{
            border:1px solid #DDD;
            padding:4px;
            background-color:#EEE;
        }
        table.allleft tr,
        table.allleft td { padding:4px; }
        
      </style>
      <!-- Stylesheet for tables -->


<div class='contentheading'><?php echo JText::_('Progress Tracking - Phase '.$this->pid); ?>
    <div style="float:right"><?php echo $this->tracking->submission; ?></div>
</div>
      
<div class="tabs">
    <ul id="tabMenu">
        <?php for($i=10; $i>0; $i--) { ?>
        <li id='tab-<?php echo $i; ?>'>
            <a href="index.php?option=com_jforce&view=phase&layout=evaluation&pid=<?php echo $i; ?>"><?php echo $i; ?></a>
        </li>
    <?php } ?>
    </ul>
</div>
<!-- Step 1 -->
<form method="post" action="index.php?option=com_jforce&view=phase&task=save_progress_tracking" enctype="multipart/form-data" onSubmit="return myValidate(this)">
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="step_redirection_link" value="<?=$this->step_redirection_link; ?>" >
<input type="hidden" name="phase_id" value="<?=$this->phase_id ?>" >
        
<!-- Step 2 -->
<div class="tabContainer2">
    <div>
        <h3>Retake Body Score Survey</h3>
    </div>
    <table class="allleft">
        <?php
          /*  foreach($this->body_score_questions as $q):
            ?>
            <tr>
                <td valign="top" align="center"><input type="checkbox" name="evaluation[bodyscore][]" value="<?=$q->id;?>"/></td>
                <td valign="top"><?=$q->question;?></td>
            </tr>
            <?
            endforeach;
            */
        ?>
        <tr>
        <?php
            $cnt = 1;
            foreach($this->body_score_questions as $q):
            $answers = $this->tracking->bodyscore->answers;
           ?>
                <td style='border:1px solid #EEE;padding:3px;' align="center"><input type="checkbox" name="evaluation[bodyscore][]" value="<?=$q->id;?>" <?php if(in_array($q->id,$answers)) {echo "checked";} ?>/></td>
                <td style='border:1px solid #EEE;padding:3px;'><?=$q->question;?></td>
            <?php

            if($cnt % 2 == 0) {
                echo "</tr><tr>\n";
            }
            $cnt++;
            endforeach;
        ?>
        </tr>
    </table>
    

    
    <?php if($this->tracking->bodyscore->chart) { ?>
    <!-- Body score chart initialization -->
    <script type="text/javascript">
        var bodyscore_chart;
        jQuery(document).ready(function() {
            bodyscore_chart = new Highcharts.Chart({
              chart: {
                 renderTo: 'bs_container',
                 defaultSeriesType: 'column'
              },
              colors: ['#0096D6'],
              title: {
                 text: ''
              },
              xAxis: {
                 categories: <?php echo $this->tracking->bodyscore->chart->cats ?>
              },
              yAxis: {
                 min: 0,
                 max: 100,
                 title: {
                    text: 'Percentage'
                 },
                 tickInterval: 10
              },
              tooltip: {
                  enabled: false
              },
              legend: {
                  enabled: false
              },
              credits: {
                  enabled: false
              },
              plotOptions: {
                 column: {
                    enableMouseTracking: false
                 }
              },
                   series: [{
                  data: <?php echo $this->tracking->bodyscore->chart->opp_vals ?>
              }]
           });
        });
    </script>
    <div id="bs_container" style="width: 100%; height: 300px"></div>
    <?php } ?>
</div>


<div>
    &nbsp;
</div>

<!-- Step 3 -->
<div class="tabContainer2">
    <div>
        <h3>
            Retake Intake Survey
        </h3>
    </div>
    <table>
        <tr>
            <td valign="top" align="center" colspan="3"><div align="left">
                    <table width="277" border="0" align="center">
                        <tbody><tr>
                            <td width="72"><b><a target="_blank">Weight</a></b></td>
                            <td width="318"><input type="text" style="width: 50px;" tabindex="1" id="txtWeight" value="<?php echo $this->tracking->intake->weight ?>" name="evaluation[intake][W]" class="inputbox required validate-numeric"/>
                                <strong>lbs</strong></td>
                        </tr>
                        <tr>
                            <td><b><a target="_blank">Body Fat</a></b></td>
                            <td><input type="text" style="width: 50px;" tabindex="2" id="txtBodyFat" value="<?php echo $this->tracking->intake->fat ?>" name="evaluation[intake][F]" class="inputbox required validate-numeric"/>
                            <strong>%</strong></td>
                        </tr>
                        <tr>
                            <td><b><a target="_blank">PH Score</a></b></td>
                            <td><input type="text" style="width: 50px;" tabindex="3" id="txtPHScore" value="<?php echo $this->tracking->intake->point ?>" name="evaluation[intake][PH]" class="inputbox required validate-numeric"/></td>
                        </tr>
                    </tbody></table>
                </div>
            </td>

        </tr>
    </table>
    <table>
        <tr>
            <td valign="top">
                <h3>Submission Date</h3>
                <?php echo $this->calendar; ?>
            </td>
        </tr>
    </table>
</div>
<div>
    &nbsp;
</div>

<!-- Step 4 -->
<div class="tabContainer2">
    <h3>Current Photo</h3>
    <div>
        
        <?php 
            if ($this->tracking->photo):
                // display link to phase end photo upload form
                echo "<div style='font-size:15px;color:#008;'>
                            <img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->tracking->photo."\" />
                </div>";
            else :
                echo "<div style='font-size:15px;color:#800;'>
                        Photo has not been uploaded.
                        <br />

                </div>";
            endif;                                                                
        ?>
        <input type='file' name='filename' />
    </div>    
</div>
<div>
    &nbsp;
</div>

<!-- Step 5 -->
<div class="tabContainer2">
    <h3>Update Tracking</h3>
    <style>
        .subtitle{
            font-size:15px;color:#008;
        }
    </style>
    <?php
    $selected = 'selected="true"';
    $options = "<option value='same'>Same</option>
        <option value='eliminated'>Eliminated</option>
        <option value='better'>Better</option>
        <option value='new'>New</option>
        ";
    ?>
    <br />
    <div class='subtitle'>
        Symptoms Tracking
    </div>
    <div>
        <table class="allleft" width="100%">
            <tr>
                <th width="150">Symptoms</th><th>Status</th><th>Notes</th>
            </tr>
        <?php
        if($this->tracking->symptoms || $this->tracking->extra_symptoms):
            if($this->tracking->symptoms) {
                foreach($this->tracking->symptoms as $s){
                    $options = '';
                    foreach($this->opts as $v) {
                        $options .= '<option value="'.$v.'" '.($s->status == $v ? $selected : '').'>'.ucfirst($v).'</option>';
                    }
                    $options_html = "<select name=\"tracking[symptoms][$s->variable][status]\">
                                    {$options}
                                </select>
                                ";
                    ?>
                        <tr>
                            <td><?=$s->question;?></td><td><?=$options_html;?></td><td><input type='text' value="<?php echo $s->notes; ?>" name="tracking[symptoms][<?=$s->variable?>][notes]"></td>
                        </tr>
                    <?php
                }
            }

            if($this->tracking->extra_symptoms):
                foreach($this->tracking->extra_symptoms as $s){
                    $options_html = "<select name=\"tracking[extra_symptoms][$s->id][status]\">
                                    {$options}
                                </select>
                                ";
                    ?>
                        <tr>
                            <td><?=$s->value;?></td>
                            <td><?=$options_html;?></td>
                            <td><input type='text' name="tracking[extra_symptoms][<?=$s->id?>][notes]"></td>
                        </tr>
                    <?php
                }
            endif;

        else:
        ?>
            <tr>
                <td colspan=4 class=alert>You have not selected any symptoms</td>
            </tr>
        <?php
        endif;
        ?>
        </table>  
    </div>
    <br/>
  
    <div class='subtitle'>
        Medical Tracking
    </div>
    
    
    <div>
        <table class="allleft" width="100%">
            <tr>
                <th width="150">Medtrack</th><th>Status</th><th>Notes</th>
            </tr>
        <?php
            if($this->tracking->medtrack || $this->tracking->extra_medtrack):
                if($this->tracking->medtrack) {
                    foreach($this->tracking->medtrack as $s){
                        $options = '';
                        foreach($this->opts as $v) {
                            $options .= '<option value="'.$v.'" '.($s->status == $v ? $selected : '').'>'.ucfirst($v).'</option>';
                        }
                        $options_html = "<select name=\"tracking[medtrack][$s->variable][status]\">
                                        {$options}
                                    </select>
                                    ";
                        ?>
                            <tr>
                                <td><?=$s->question;?></td><td><?=$options_html;?></td><td><input type='text' value="<?php echo $s->notes; ?>" name="tracking[medtrack][<?=$s->variable?>][notes]"></td>
                            </tr>
                        <?php
                    }
                }

                if($this->tracking->extra_medtrack):
                foreach($this->tracking->extra_medtrack as $s){
                    $options_html = "<select name=\"tracking[extra_medtrack][$s->id][status]\">
                                    {$options}
                                </select>
                                ";
                    ?>
                        <tr>
                            <td><?=$s->value;?></td>
                            <td><?=$options_html;?></td>
                            <td><input type='text' name="tracking[extra_medtrack][<?=$s->id?>][notes]"></td>
                        </tr>
                    <?php
                }
                endif;

            else:
            ?>
                <tr>
                    <td colspan=4 class=alert>You have not selected any medical trackings</td>
                </tr>
            <?php
            endif;
        ?>
        </table>
    </div>
    <br />
    
    
    
    
    
    
    
    <div class='subtitle'>
        Diseases Tracking
    </div>
    <div>
        <table class="allleft" width="100%">
            <tr>
                <th width="150">Diseases</th><th>Status</th><th>Notes</th>
            </tr>
        <?php
            if($this->tracking->diseases || $this->tracking->extra_diseases):
                if($this->tracking->diseases):
                    foreach($this->tracking->diseases as $s){
                        $options = '';
                        foreach($this->opts as $v) {
                            $options .= '<option value="'.$v.'" '.($s->status == $v ? $selected : '').'>'.ucfirst($v).'</option>';
                        }
                        $options_html = "<select name=\"tracking[diseases][$s->variable][status]\">
                                        {$options}
                                    </select>
                                    ";
                        ?>
                            <tr>
                                <td><?=$s->question;?></td><td><?=$options_html;?></td><td><input type='text' value="<?php echo $s->notes; ?>" name="tracking[diseases][<?=$s->variable?>][notes]"></td>
                            </tr>
                        <?php
                    }
                endif;

                if($this->tracking->extra_diseases):
                foreach($this->tracking->extra_diseases as $s){
                    $options_html = "<select name=\"tracking[extra_diseases][$s->id][status]\">
                                    {$options}
                                </select>
                                ";
                    ?>
                        <tr>
                            <td><?=$s->value;?></td>
                            <td><?=$options_html;?></td>
                            <td><input type='text' name="tracking[extra_diseases][<?=$s->id?>][notes]"></td>
                        </tr>
                    <?php
                }
                endif;
            else:
            ?>
                <tr>
                    <td colspan=4 class=alert>You have not selected any diseases</td>
                </tr>
            <?php
            endif;
        ?>
        </table>
       <!-- <input type="text" id="tracking-medtrack" value="" />
        <input type="button" id="tracking-med-add" value="Add" />-->
    </div>
</div>

<br />
<div class="tabContainer2">
    <input type="hidden" name="form_type" value="evaluation">
    <input type="submit" name="save" value="Save" />
    <input type="submit" name="save_as_new" value="Save as new phase" <?php echo $this->pid >= 10 ? 'disabled="true"' : ''; ?> />
    <input type="hidden" name="pid" value="<?php echo $this->pid; ?>" />
</div>

</form>