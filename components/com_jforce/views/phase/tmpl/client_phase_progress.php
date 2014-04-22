<?php

/************************************************************************************
*    @package        Joomla                                                            *
*    @subpackage     jForce, the Joomla! CRM                                            *
*    @version        2.0                                                                *
*    @file           client_phase_progress.php
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');    
?>
<style>
	div.itemTitle{
		padding-right:10px;
	}
</style>
<h1>Phase Progress Analysis</h1>
<div class='tabContainer2'>    
    <div class='companyArea'>
        <div class='logo'>
            <?php echo $this->person->image; ?>
        </div>
        <div class='companyDetails'>
            <div class="row1">
            	<div class="itemTitle"><?php echo JText::_('Name'); ?></div>
            		<?php echo $this->person->name; ?>
            </div>    
            <div class="row0">
            	<div class="itemTitle">
            		<?php echo JText::_('Username'); ?>
            	</div>
            		<?php echo $this->person->username; ?>
            </div>
    <?php if($this->person->accessrole != "Client") { ?>
            <div class="row1">
            	<div class="itemTitle">            		
            	</div>

            		<a href="<?=JRoute::_("index.php?option=com_jforce&c=people&view=person&layout=client&id=".$this->person->id."&action=progress");?>">
	            		Return to <strong><?php echo $this->person->name; ?>'s</strong> Dashboard
	            	</a>

            </div>
    <?php } ?>
        </div>
    </div>    
</div>
<br />
<div class="tabs">
    <ul id="tabMenu">
        <?php 
            $id = JRequest::getCmd("id");
        ?>
        <li id='tab-1'><a href="<?=JRoute::_("index.php?option=com_jforce&view=phase&layout=client_phase_progress&pid={$this->pid}&action=evaluation&client_id={$this->person->id}")?>">End Evaluation</a></li>
        <li id='tab-2'><a href="<?=JRoute::_("index.php?option=com_jforce&view=phase&layout=client_phase_progress&pid={$this->pid}&action=photo&client_id={$this->person->id}")?>">Progress Photo</a></li>
        <li id='tab-3'><a href="<?=JRoute::_("index.php?option=com_jforce&view=phase&layout=client_phase_progress&pid={$this->pid}&action=survey&client_id={$this->person->id}")?>">Start Surveys</a></li>
        <li id='tab-3'><a href="<?=JRoute::_("index.php?option=com_jforce&view=phase&layout=client_phase_progress&pid={$this->pid}&action=registrationsurvey&client_id={$this->person->id}")?>">Registration Surveys</a></li>        
    </ul>
</div>

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
        
        table.allleft td.alert{
            color:#800;
            font-size:14px;            
        }
        
      </style>
      <!-- Stylesheet for tables -->
      

<div class="tabContainer">
    <?php
        // OK Pick what to do according to the action defined
    
        switch($this->actionpage):
            case "registrationsurvey":
                echo "<h4>REGISTRATION TIME SURVEY</h4>";
                ?>
                    <table width='100%' class='allleft'>
                        <tr>
                            <th colspan=3 style="background-color:#008;color:white; ">Surveys Taken during registration</th>
                        </tr>
                        <tr>
                            <th colspan=3>What are you Looking For?</th>
                        </tr>
                        <tr>
                            <th>SN</th><th>Result</th><th>Question</th>                            
                        </tr>
                        <?php
                            $count = 1;                            
                            if (is_array($this->survey->registration->reg_looking_for->survey_value)):
                                foreach($this->survey->registration->reg_looking_for->survey_value as $r):
                                    ?>
                                        <tr>
                                            <td><?=$count++;?></td>
                                            <td><img src="/uploads_jtpl/icons/yes.png"></td>
                                            <td><?=$r->question;?></td>
                                        </tr>
                                    <?php
                                endforeach;
                            else:
                                 echo "<tr><td colspan=3 class='alert'>Looking For Survey results not submitted</td></tr>";
                            endif;
                        ?>
                        <tr><td colspan=3></td></tr>
                        <tr>
                            <th colspan=3>Medtrack Results</th>
                        </tr>
                        <tr>
                            <th>SN</th><th>Result</th><th>Medtrack Question</th>                            
                        </tr>
                        <?php
                            $count = 1;                            
                            if(is_array($this->survey->registration->reg_medtrack->survey_value) || is_array($this->survey->registration->extraboxes->medtrack)):
                                if(is_array($this->survey->registration->reg_medtrack->survey_value)):
                                foreach($this->survey->registration->reg_medtrack->survey_value as $r):
                                    ?>
                                        <tr>
                                            <td><?=$count++;?></td>
                                            <td><img src="/uploads_jtpl/icons/yes.png"></td>
                                            <td><?=$r->question;?></td>
                                        </tr>
                                    <?php
                                endforeach;
                                endif;
                                
                                if(is_array($this->survey->registration->extraboxes->medtrack)):
                                    foreach($this->survey->registration->extraboxes->medtrack as $r):
                                    ?>
                                        <tr>
                                            <td><?=$count++;?></td>
                                            <td><img src="/uploads_jtpl/icons/yes.png"></td>
                                            <td><?=$r->value;?></td>
                                        </tr>
                                    <?php
                                    endforeach;
                                endif;
                                
                            else:
                                 echo "<tr><td colspan=3 class='alert'>Medtrack Survey results not submitted</td></tr>";
                            endif;
                        ?>
                        <tr><td colspan=3></td></tr>
                        <tr>
                            <th colspan=3>Symptons Results</th>
                        </tr>
                        <tr>
                            <th>SN</th><th>Result</th><th>Symptoms</th>                            
                        </tr>                        
                        <?php
                            $count = 1;                            
                            if (is_array($this->survey->registration->reg_symptoms->survey_value) || is_array($this->survey->registration->extraboxes->symptoms)):
                                if (is_array($this->survey->registration->reg_symptoms->survey_value)):
                                foreach($this->survey->registration->reg_symptoms->survey_value as $r):
                                    ?>
                                        <tr>
                                            <td><?=$count++;?></td>
                                            <td><img src="/uploads_jtpl/icons/yes.png"></td>
                                            <td><?=$r->question;?></td>
                                        </tr>
                                    <?php
                                endforeach;                                
                                endif;
                                
                                if (is_array($this->survey->registration->extraboxes->symptoms)):
                                foreach($this->survey->registration->extraboxes->symptoms as $r):
                                    ?>
                                        <tr>
                                            <td><?=$count++;?></td>
                                            <td><img src="/uploads_jtpl/icons/yes.png"></td>
                                            <td><?=$r->value;?></td>
                                        </tr>
                                    <?php
                                endforeach;                                
                                endif;
                                
                            else:
                                 echo "<tr><td colspan=3 class='alert'>Symptoms survey results not submitted</td></tr>";
                            endif;
                        ?>
                        <tr><td colspan=3></td></tr>
                        <tr>
                            <th colspan=3>Diseases Questions</th>
                        </tr>
                        <tr>
                            <th>SN</th><th>Type</th><th>Diseases</th>                            
                        </tr>
                        <?php
                            $count = 1;                            
                            if(is_array($this->survey->registration->reg_diseases->survey_value) || is_array($this->survey->registration->extraboxes->diseases)):
                                if(is_array($this->survey->registration->reg_diseases->survey_value)):
                                foreach($this->survey->registration->reg_diseases->survey_value as $r):                            
                                    ?>
                                        <tr>
                                            <td><?=$count++;?></td>
                                            <td><?=strtoupper($r->type);?></td>
                                            <td><?=$r->question;?></td>
                                        </tr>
                                    <?php
                                endforeach;
                                endif;
                                
                                if(is_array($this->survey->registration->extraboxes->diseases)):
                                foreach($this->survey->registration->extraboxes->diseases as $r):                            
                                    ?>
                                        <tr>
                                            <td><?=$count++;?></td>
                                            <td><?=strtoupper("ADDED");?></td>
                                            <td><?=$r->value;?></td>
                                        </tr>
                                    <?php
                                endforeach;
                                endif;
                            else:
                                 echo "<tr><td colspan=3 class='alert'>Diseses Survey Results not submitted</td></tr>";
                            endif;
                        ?>
                        <tr><td colspan=3></td></tr>
                        <tr>
                            <th colspan=3>Body Score Survey Results</th>
                        </tr>
                        <tr>
                            <th>SN</th><th>Result</th><th>Body Score Question</th>                            
                        </tr>
                        <?php
                            $count = 1;
                            if(is_array($this->survey->registration->reg_bodyscore->survey_value)):
                                foreach($this->survey->registration->reg_bodyscore->survey_value as $r):                            
                                    ?>
                                        <tr>
                                            <td><?=$count++;?></td>
                                            <td><img src="/uploads_jtpl/icons/yes.png"></td>
                                            <td><?=$r->question;?></td>
                                        </tr>
                                    <?php
                                endforeach;
                        ?>
                                    <tr><td colspan="3">
                                            
                            <!-- Body score chart initialization -->
                            <script type="text/javascript">
                                var bodyscore_chart;
                                jQuery(document).ready(function() {
                                    bodyscore_chart = new Highcharts.Chart({
                                      chart: {
                                         renderTo: 'bs_container',
                                         defaultSeriesType: 'column'
                                      },
                                      colors: ['#89a54e', '#aa4643'],
                                      title: {
                                         text: ''
                                      },
                                      xAxis: {
                                         categories: <?php echo $this->survey->registration->reg_bodyscore->bs_cats ?>
                                      },
                                      yAxis: {
                                         min: 0,
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
                                            stacking: 'percent',
                                            enableMouseTracking: false
                                         }
                                      },
                                           series: [{
                                          data: <?php echo $this->survey->registration->reg_bodyscore->bs_opposite_vals ?>
                                      }, {
                                          data: <?php echo $this->survey->registration->reg_bodyscore->bs_percent_vals ?>
                                      }]
                                   });
                                });
                            </script>
                            
                            <div id="bs_container" style="width: 100%; height: 300px"></div>
                                </td></tr>
                        <?php
                            else:
                                 echo "<tr><td colspan=3 class='alert'>Body Score results not submitted</td></tr>";
                            endif;
                        ?>

                    </table>                    
                <?php
            break;
            case "survey":
                echo "<h4>SURVEY</h4>";
                ?>
                    <table width='100%' class='allleft'>
                        <tr>
                            <th colspan=3>Initial Survey</th>
                        </tr>
                        <tr>
                            <th>SN</th><th>Question</th><th>Reply</th>
                        </tr>
                        <? $count = 1; ?>
                        <?php if($this->survey->initial->initial_survey): ?>
                        <?php foreach($this->survey->initial->initial_survey as $q=>$s): ?>
                            <tr>
                                <td><?=$count++;?></td><td><?=$q;?></td><td><img src="/uploads_jtpl/icons/<?=$s;?>.png"></td>
                            </tr>
                        <?php endforeach;?>
                        <?php else: ?>
                            <tr><td colspan=3 class='alert'>Initial Survey has not been submitted</td></tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan=3></td>
                        </tr>
                        <tr>
                            <th colspan=3>Initial Intake Survey</th>
                        </tr>
                        <?php $count = 1;?>
                        <tr>
                            <th>SN</th><th>Question</th><th>Reply</th>
                        </tr>
                        <?php $count = 1; ?>
                        <?php if ($this->survey->initial->intake_survey): ?>
                        <?php foreach($this->survey->initial->intake_survey as $q=>$s): ?>
                            <tr>
                                <td><?=$count++;?></td><td><strong><?=$q;?></strong></td><td><?=$s;?></td>
                            </tr>
                        <?php endforeach;?>
                        <?php else: ?>
                            <tr><td colspan=3 class='alert'>Initial Intake Survey has not been submitted</td></tr>
                        <?php endif; ?>
                        
                    </table>                    
                <?php
            break;
            
            case "evaluation":
                echo "<h4>EVALUATION</h4>";
                ?>
                    <table width='100%' class='allleft'>
                        <tr>
                            <th colspan=4>End Evaluation</th>
                        </tr>
                        <tr>
                            <th>SN</th><th colspan=2>Question</th><th>Reply</th>
                        </tr>
                        <?php $count = 1; ?>
                        <?php if($this->survey->evaluation->end_evaluation): ?>
                        <?php foreach($this->survey->evaluation->end_evaluation as $q=>$s): ?>
                            <tr>
                                <td><?=$count++;?></td><td colspan=2><?=$q;?></td><td><img src="/uploads_jtpl/icons/<?=$s;?>.png"></td>
                            </tr>
                        <?php endforeach;?>
                        <?php else: ?>
                             <tr><td colspan=3 class='alert'>Evaluation Survey has not been submitted</td></tr>
                        <?php endif; ?>
                        
                        <tr>
                            <td colspan=4></td>
                        </tr>
                        <tr>
                            <th colspan=4>Body Score Survey Retake</th>
                        </tr>
                        <tr>
                            <th>SN</th><th>Result</th><th colspan=2>Body Score Question</th>                            
                        </tr>
                        <?php
                            $count = 1;
                            if(is_array($this->survey->evaluation->bodyscore->survey_value)):
                                foreach($this->survey->evaluation->bodyscore->survey_value as $r):                            
                                    ?>
                                        <tr>
                                            <td><?=$count++;?></td>
                                            <td><img src="/uploads_jtpl/icons/yes.png"></td>
                                            <td colspan=2><?=$r->question;?></td>
                                        </tr>
                                    <?php
                                endforeach;
                            else:
                                 echo "<tr><td colspan=4 class='alert'>Body Score results not submitted</td></tr>";
                            endif;
                        ?>
                        
                        <tr>
                            <th colspan=4>Intake Evaluation</th>
                        </tr>
                        <?php $count = 1;?>
                        <tr>
                            <th>SN</th><th>Question</th><th>Start of Phase</th><th>End of Phase</th>
                        </tr>
                        <? $count = 1; ?>
                        <?php if($this->survey->evaluation->intake_evaluation): ?>
                        <?php foreach($this->survey->evaluation->intake_evaluation as $q=>$s): ?>
                            <tr>
                                <td><?=$count++;?></td><td><strong><?=$q;?></strong></td><td><?=$s;?></td><td><?=$this->survey->initial->intake_survey[$q];?></td>
                            </tr>
                        <?php endforeach;?>
                        <?php else: ?>
                             <tr><td colspan=3 class='alert'>Intake Evaluation has not been submitted</td></tr>
                        <?php endif; ?>
                    </table>               
                    <table class="allleft" width="100%">
                    <tr>
                            <th colspan=3 style='background-color:#008;color:#FFF'>
                                <span id="tracking">Tracking</span>
                            </th>
                        </tr>
                        <tr>
                            <th colspan=3>Symptoms Tracking</th>
                        </tr>
                         <tr>
                                <th width="150">Symptoms</th><th>Status</th><th>Notes</th>
                         </tr>
                            <?php        
                                if($this->tracking->symptoms || $this->tracking_details->_->extra_symptoms){
                                    if($this->tracking->symptoms):
                                    foreach($this->tracking->symptoms as $s){
                                        ?>
                                            <tr>
                                                <td><?=$this->tracking->_symptoms->{$s->variable};?></td><td><?=strtoupper($this->tracking_details->symptoms->{$s->variable}->status);?></td><td><?=strtoupper($this->tracking_details->symptoms->{$s->variable}->notes);?></td>
                                            </tr>
                                        <?php
                                    }
                                    endif;
//mdie($this)                                    ;
                                    if($this->tracking_details->extra_symptoms):
                                    foreach($this->tracking_details->extra_symptoms as $s){
                                        //mdie($s);
                                        //mdie($this->tracking_extra_details->extra_symptoms);
                                        ?>
                                            <tr>
                                                <td><?=$this->tracking_extra_details->extra_symptoms[$s->tracking_variable]->value;?></td>
                                                <td><?=strtoupper($s->status);?></td>
                                                <td><?=strtoupper($s->notes);?></td>
                                            </tr>
                                        <?php
                                    }
                                    endif;
                                }else{
                                        ?>
                                            <tr>
                                                <td colspan=3 class='alert'>Symptoms Tracking has not been updated</td>
                                            </tr>
                                        <?php
                                }
                            ?>
                        <tr>
                            <th colspan=3>Diseases Tracking</th>
                        </tr>
                         <tr>                                                                      
                                <th width="150">Diseases</th><th>Status</th><th>Notes</th>
                         </tr>
                            <?php    
                                if($this->tracking->diseases || $this->tracking_details->extra_diseases){
                                    if($this->tracking->diseases):
                                    foreach($this->tracking->diseases as $s){
                                        ?>
                                            <tr>
                                                <td><?=$this->tracking->_diseases->{$s->variable};?></td><td><?=strtoupper($this->tracking_details->diseases->{$s->variable}->status);?></td><td><?=strtoupper($this->tracking_details->diseases->{$s->variable}->notes);?></td>
                                            </tr>
                                        <?php
                                    }
                                    endif;
                                    
                                    if($this->tracking_details->extra_diseases):
                                    foreach($this->tracking_details->extra_diseases as $s){
                                        //mdie($s);
                                        //mdie($this->tracking_extra_details->extra_symptoms);
                                        ?>
                                            <tr>
                                                <td><?=$this->tracking_extra_details->extra_diseases[$s->tracking_variable]->value;?></td>
                                                <td><?=strtoupper($s->status);?></td>
                                                <td><?=strtoupper($s->notes);?></td>
                                            </tr>
                                        <?php
                                    }
                                    endif;

                                    
                                }else{
                                        ?>
                                            <tr>
                                                <td colspan=3 class='alert'>Diseases Tracking has not been updated</td>
                                            </tr>
                                        <?php
                                }
                            ?>
                        <tr>
                            <th colspan=3>Medtrack Tracking</th>
                        </tr>
                         <tr>
                                <th width="150">Medtrack</th><th>Status</th><th>Notes</th>
                         </tr>
                            <?php        
                                if ($this->tracking->medtrack || $this->tracking_details->extra_medtrack){
                                    if($this->tracking->medtrack):
                                    foreach($this->tracking->medtrack as $s){
                                        ?>
                                            <tr>
                                                <td><?=$this->tracking->_medtrack->{$s->variable};?></td><td><?=strtoupper($this->tracking_details->medtrack->{$s->variable}->status);?></td><td><?=strtoupper($this->tracking_details->medtrack->{$s->variable}->notes);?></td>
                                            </tr>
                                        <?php
                                    }
                                    endif;
                                    
                                    if($this->tracking_details->extra_medtrack):
                                    foreach($this->tracking_details->extra_medtrack as $s){
                                        //mdie($s);
                                        //mdie($this->tracking_extra_details->extra_symptoms);
                                        ?>
                                            <tr>
                                                <td><?=$this->tracking_extra_details->extra_medtrack[$s->tracking_variable]->value;?></td>
                                                <td><?=strtoupper($s->status);?></td>
                                                <td><?=strtoupper($s->notes);?></td>
                                            </tr>
                                        <?php
                                    }
                                    endif;                                    
                                    
                                }else{
                                        ?>
                                            <tr>
                                                <td colspan=3 class='alert'>Medical Tracking has not been updated</td>
                                            </tr>
                                        <?php
                                }
                            ?>
                    </table>     
                    
                    
                <?php
            break;
            
            case "photo":
            default:
                echo "<h4>PROGRESS PHOTO</h4>";
                ?>
                    <table align=center>
                        <tr>
                            <th>Phase Start Photo</th><th>Phase End Photo</th>
                        </tr>
                        <style>
                            img.bordered{
                               border:3px solid #0096D6;
                               width:200px;
                               height:250px;
                               display:block;
                            }
                        </style>
                        <td><img src="<?=$this->phase_details->startphoto; ?>" class="bordered"></td>
                        <td><img src="<?=$this->phase_details->endphoto; ?>" class="bordered"></td>
                    </table>
                    <?php
                if($this->user->person->accessrole != "Client") { ?>
                    <h4>UPLOAD NEW PHOTO</h4>
                    <form action="index.php" method="post" enctype="multipart/form-data">
                        <table align="center">
                            <tr>
                                <td>Start:</td>
                                <td><input type="file" name="start" /></td>
                            </tr>
                            <tr>
                                <td>End:</td>
                                <td><input type="file" name="end" /></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="submit" name="submit" value="Upload" />
                                </td>
                            </tr>
                        </table>

                        <input type="hidden" name="option" value="com_jforce" />
                        <input type="hidden" name="c" value="phase" />
                        <input type="hidden" name="task" value="photosupload" />
                        <input type="hidden" name="ret" value="<?=base64_encode($_SERVER['REQUEST_URI']);?>" />
                        <input type="hidden" name="pid" value="<?=$this->pid;?>" />

                    </form>

                    <?php
                    }
            break;
            
        endswitch;
    ?>    
</div>