<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php
$phases = $this-> phases;
$count = count($phases);
?>


<div class='contentheading phase-navigation-header'>Phases Navigation</div>
<div class='tabContainer2 phase-navigation' style="background-color:#E1FFE3">
    <ul>
        <li><a href="index.php?option=com_phase&controller=client&action=show_repo&c=<?=$uid?>">Intake Survey</a></li>

        <?php
        if ($phases && $phases[0][id] !== null && $phases[0][name] !== null )
        {
            foreach ($phases as $value)
            {
                ?>
                <li><a href="index.php?option=com_phase&controller=client&action=show_repoz&c=<?=$uid?>&pid=<?=$value[id]?>"><?=$value[name]?></a></li>
            <?php
            }
        }
        ?>
        <li><a href="index.php?option=com_phase&controller=client&action=show_total_repo&c=<?=$uid?>">Total Progress</a></li>
    </ul>
</div>


<div class='contentheading'>Intake Survey</div>

    
    <div class='contentheading'>Client goals</div>
    <div class='tabContainer2' style="background-color:#E1FFE3">
        
            <?php if(isset($this->evalution[goals][weight]) && $this->evalution[goals][weight] !== ""){?>
            <div class="value-name"><?="Target Weight: "?></div> <div class="value"><?=$this->evalution[goals][weight]." lbs."?></div>
            <?php
            }

            if(isset($this->evalution[goals][fat]) && $this->evalution[goals][fat] !== ""){?>
            <div class="value-name"><?="Target Body Fat: "?></div> <div class="value"><?=$this->evalution[goals][fat]." %"?></div>
            <?php
            }
            ?>
            
            <table>
            <?php
            if($this->loockingfor && count($this->loockingfor) !== 0){ ?>
            <tr>
                <?php
                $cnt = 1;
                foreach($this->loockingfor as $value){
                    ?>
                    <td style='border:1px solid #EEE;padding:3px;' align="center" ><input type="checkbox" name="evalution[goals][question][]" value="<?=$value['id'];?>" <?php if(isset($this->evalution[goals][question])){ if(in_array($value['id'],$this->evalution[goals][question])) {echo "checked";}} ?>></td>
                    <td style='border:1px solid #EEE;padding:3px;'><?=$value['var'];?></td>
                    <?php
                    if($cnt % 4 == 0)
                    {
                        echo "</tr><tr>\n";
                    }
                    $cnt++;
                }
                ?>
            </tr>
            <?php } ?>
        </table>
    </div>

    <div class='contentheading'>Body stats</div>
    <div class='tabContainer2' style="background-color:#E1FFE3">
        
        <?php if($this->evalution[stats][sex] !== ""){ ?>
        <div class="value-name"><?="Sex - "?></div>
        <div class="value"><?= $this->evalution[stats][sex]?></div>
        <?php }
            
        if($this->evalution[stats][height][0] !== "" && $this->evalution[stats][height][1] !== ""){ ?>
        <div class="value-name"><?="Height"?></div>
        <div class="value"><?=$this->evalution[stats][height][0]." ft ".$this->evalution[stats][height][1]." inches"?></div>
        <?php }

        if($this->evalution[stats][weight] !== ""){ ?>
        <div class="value-name"><?="Weight"?></div>
        <div class="value"><?= $this->evalution[stats][weight]."lbs"?></div>
        <?php } 
        
        if($this->evalution[stats][fat] !== ""){ ?>
        <div class="value-name"><?="Body Fat"?></div>
        <div class="value"><?=$this->evalution[stats][fat]."%"?></div>
        <?php }
        
        if($this->evalution[stats][ph] !== ""){ ?>
        <div class="value-name"><?="PH"?></div>
        <div class="value"><?=$this->evalution[stats][ph]."%"?></div>
        <?php }
        
        if($this->evalution[stats][blood_p][0] !== "" && $this->evalution[stats][blood_p][1] !== ""){ ?>
        <div class="value-name"><?="Blood Pressure"?></div>
        <div class="value"><?=$this->evalution[stats][blood_p][0]." / ".$this->evalution[stats][blood_p][1]?></div>
        <?php }
        
        if($this->evalution[stats][blood_t] !== ""){ ?>
        <div class="value-name"><?="Blood Type"?></div>
        <div class="value"><?=$this->evalution[stats][blood_t]?></div>
        <?php } ?>
    </div>

    <div class='contentheading'>Body Type</div>
    <div class='tabContainer2' style="background-color:#E1FFE3">

        <?php if($this->evalution[body_type][0] !== ""){ ?>
        <div class="value-name"><?="1. Bone structure - "?></div>
        <div class="value"><?=$this->evalution[body_type][0]?></div>
        <?php }
        
        if($this->evalution[body_type][1] !== ""){ ?>
        <div class="value-name"><?="2. Muscle type  - "?></div>
        <div class="value"><?=$this->evalution[body_type][1]?></div>
        <?php }
        
        if($this->evalution[body_type][2] !== ""){?>
        <div class="value-name"><?="3. Tendency to gain weight - "?></div>
        <div class="value"><?=$this->evalution[body_type][2]?></div>
        <?php }
        
        if($this->evalution[body_type][3] !== ""){ ?>
        <div class="value-name"><?="4. Desribes the clients apperance, knowing thei age  - "?></div>
        <div class="value"><?=$this->evalution[body_type][3];?></div>
        <?php }
        
        if($this->evalution[body_type][4] !== ""){ ?>
        <div class="value-name"><?="5. Risk of heart disease - "?></div>
        <div class="value"><?= $this->evalution[body_type][4]; ?></div>
        <?php } ?>
        
        <div class="value-name"><?="6. Body shape that most resembles you own."?></div>
        <div class="body-type-photo">
        <?php
        if($this->evalution[body_type][5] !== "" && $this->evalution[body_type][5] == "fat.png"){
            echo "<img src=\"".JURI::root().'uploads_jtpl/phase_img/'."fat.png"."\" width=\"200\" height=\"350\">";}
        
        if($this->evalution[body_type][5] !== "" && $this->evalution[body_type][5] == "normal.png"){
            echo "<img src=\"".JURI::root().'uploads_jtpl/phase_img/'."normal.png"."\" width=\"200\" height=\"350\">";}

        if($this->evalution[body_type][5] !== "" && $this->evalution[body_type][5] == "toll.png"){
            echo "<img src=\"".JURI::root().'uploads_jtpl/phase_img/'."toll.png"."\" width=\"200\" height=\"350\">";}
            ?>
        </div>
</div>
    
    <div class='contentheading'>Lifestyle analysis</div>    
    <div class='tabContainer2' style="background-color:#E1FFE3">    

    <?php
    // здесь были вопросы с галочками (отключены в виде)
    /*
    if($this->questionList):
    ?>
            <table class="allleft">
            <tr>

            <?php
            $cnt = 1;

                foreach($this->questionList as $value):


               ?>
                    <td style='border:1px solid #EEE;padding:3px;' align="center"><input type="checkbox" name="evalution[life_style][]"<?php if(isset($evalution[life_style])){ if(in_array($value['id'],$evalution[life_style])) {echo "checked";} } ?> value="<?=$value['id'];?>"></td>
                    <td style='border:1px solid #EEE;padding:3px;'><?=$value['question'];?></td>
                <?php


    <div class='contentheading'>Lifestyle analysis</div>
    <div class='tabContainer2' style="background-color:#E1FFE3">
        <?php
        if($this->questionList):
            ?>
            <table class="allleft">
                <tr>

                    <?php
                    $cnt = 1;

                    foreach($this->questionList as $value):


                        ?>
                        <td style='border:1px solid #EEE;padding:3px;' align="center"><input type="checkbox" name="evalution[life_style][]"<?php if(isset($evalution[life_style])){ if(in_array($value['id'],$evalution[life_style])) {echo "checked";} } ?> value="<?=$value['id'];?>"></td>
                        <td style='border:1px solid #EEE;padding:3px;'><?=$value['question'];?></td>
                        <?php

                        if($cnt % 2 == 0) {
                            echo "</tr><tr>\n";
                        }
                        $cnt++;
                    endforeach;
                    ?>
                </tr>
            </table>
        <?php
        endif;
        ?>

            </tr>
        </table>
    <?php
    endif;
    */
    ?>

    <?php
    if($this->qAnswers && $this->qAnswers[0][answer] !== ""){
        foreach ($this->qAnswers as $value) {
            echo "- ".$value['answer'].'<br>';
        }
    }
    ?>


        <?php

            $var = explode(",", $this->trackingStart->cats);
            foreach ($var as $value) {
                $res[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
            }

            $var2 = explode(",", $this->trackingStart->opp_vals);
            foreach ($var2 as $value) {
                $res2[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
            }

            if($res[0] !== "" && $res2[0] !== "" && count($res) == count($res2)){
                $cnt = array_combine( $res, $res2);?>
        
                <div class='contentheading'><?="Lifestyle analysis result:"?></div>

                <?php
                foreach ($cnt as $key => $value){
                    if($value > 75){
                        $val = " - NICE";
                    }
                    elseif ($value <=75 && $value > 50) {
                        $val = " - ALMOST NICE";
                    }
                    elseif($value <=50 && $value > 25){
                        $val = " - ALMOST BAD";
                    }
                    elseif($value <=25 && $value >= 0){
                        $val = " - BAD";
                    }
                    else{$val = "So-so";}
                    echo "<div class='value-name'>".$key." - ".$val."</div>";
                }
            
            } ?>
    
    </div>
    <?php
    if($this->trackingStart){  ?>
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
                        categories: <?php echo $this->trackingStart->cats ?>
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
                        data: <?php echo $this->trackingStart->opp_vals ?>
                    }]
                });
            });
        </script>
    
        
    <div id="bs_container" style="width: 100%; height: 300px"></div>
    <?php } ?>
        
    <div class='contentheading'>Current Photo</div>
    <div class='tabContainer2' style="background-color:#E1FFE3">

        <?php
        if($this->evalution[file][0] !== null && $this->evalution[file][0] !== "")
        {
            ?>
            <?php
            echo "  <div class='photo-one'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->evalution[file][0]."\" width=\"200\" height=\"350\"></div>";
        }
        else
        {
            echo "  <div class='photo-one'>
            <img src=\"".JURI::root().'uploads_jtpl/phase_imgs/'."no1.png"."\" width=\"200\" height=\"350\">
            </div>";
        }
        ?>
        <?php
        if($this->evalution[file][1] !== null && $this->evalution[file][1] !== "")
        {
            ?>


            <?php
            echo "  <div class='photo-two'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->evalution[file][1]."\" width=\"200\" height=\"350\"></div>";
        }
        else
        {
            echo "  <div class='photo-two'>
            <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no2.png"."\" width=\"200\" height=\"350\">
            </div>";
        }
        ?>

    </div>

    <div class='contentheading'>Medical Tracking</div>
    <div class='tabContainer2' style="background-color:#E1FFE3">
    <div class='tabContainer2' style="background-color:#E1FFE3">
    <?php if($this->evalution[madtrack][exem] && $this->evalution[madtrack][exem] !== null && $this->evalution[madtrack][exem] !== ""){?>
    <div class='value-name'><?="1. Your last physical exam was - "?></div>
    <div class='value'><?=$this->evalution[madtrack][exem]?></div>
    <?php }
    
    if($this->evalution[madtrack][treatment][status] && $this->evalution[madtrack][treatment][status] !== null &&$this->evalution[madtrack][treatment][status] !== ""){ ?>
    <div class='value-name'><?="2. Undermedical treatment - "?></div>
    <div class='value'><?=$this->evalution[madtrack][treatment][status]?></div>
    <div class='value'><?=$this->evalution[madtrack][treatment][note]?></div>
    <?php }
    
    if($this->evalution[madtrack][operations][status] && $this->evalution[madtrack][operations][status] !== null && $this->evalution[madtrack][operations][status] !== ""){ ?>
    <div class='value-name'><?="3. Have you ever had any seriousillness or operations ?"?></div>
    <div class='value'><?=$this->evalution[madtrack][operations][status]?></div>
    <div class='value'><?=$this->evalution[madtrack][operations][note]?></div>
    <?php }
    
    if($this->evalution[madtrack][smoke][status] && $this->evalution[madtrack][smoke][status] !== null & $this->evalution[madtrack][smoke][status] !== ""){ ?>
    <div class='value-name'><?="4. Do you smoke ?"?></div>
    <div class='value'><?=$this->evalution[madtrack][smoke][status]?></div>
    <div class='value'><?= $this->evalution[madtrack][smoke][note]?></div>
    <?php }
    
    if($this->evalution[madtrack][alcohol][status] && $this->evalution[madtrack][alcohol][status] !== null && $this->evalution[madtrack][alcohol][status] !== ""){?>
    <div class='value-name'><?="5. Alcohol use ?"?></div>
    <div class='value'><?=$this->evalution[madtrack][alcohol][status]?></div>
    <div class='value'><?=$this->evalution[madtrack][alcohol][note]?></div>
    <?php }
    
    if($this->evalution[madtrack][drugs][status] && $this->evalution[madtrack][drugs][status] !== null && $this->evalution[madtrack][drugs][status] = ""){?>
    <div class='value-name'><?="6. Do you use cocaine or drugs ?"?></div>
    <div class='value'><?=$this->evalution[madtrack][drugs][status]?></div>
    <div class='value'><?=$this->evalution[madtrack][drugs][note]?></div>
    <?php } ?>
    </div>
    
    <div class='contentheading'>Allergies Tracking</div>
    <div class='tabContainer2' style="background-color:#E1FFE3">
    <?php


        if(isset($this->evalution[madtrack][allergies]))
        {

            foreach ($this->allergiesList as $value)
            {
                if(in_array($value['id'],$this->evalution[madtrack][allergies][status]))
                {
                    echo "<div class='value'>".$value[name]."</div>";
                }
            }
        }
        ?>
    </div>
    
    <div class='contentheading'>Symptoms Tracking</div>
    <div class='tabContainer2' style="background-color:#E1FFE3">
        <?php
        if(isset($this->evalution[madtrack][symptoms]))
        {
            foreach ($this->symptomList as $value)
            {
                if(in_array($value['id'],$this->evalution[madtrack][symptoms][status]))
                {
                    echo "<div class='value'>".$value[name]."</div>";
                }
            }
        }
        ?>
    </div>
    
    <div class='contentheading'>Medical preparations Tracking</div>
    <div class='tabContainer2' style="background-color:#E1FFE3">
        <?php
        if(isset($this->evalution[madtrack][drug]))
        {
            foreach ($this->medtrackList as $value)
            {
                if(in_array($value['id'],$this->evalution[madtrack][drug][status]))
                {
                    echo "<div class='value'>".$value[name]."</div>";
                }
            }
        }
        ?>
    </div>
    
    <div class='contentheading'>Diseases Tracking</div>
    <div class='tabContainer2' style="background-color:#E1FFE3">
        <?php
        if(isset($this->evalution[madtrack][diseases]))
        {
            foreach ($this->diseasesList as $value)
            {
                if(in_array($value['id'],$this->evalution[madtrack][diseases][status]))
                {
                    echo "<div class='value'>".$value[name]."</div>";
                }
            }
        }
        ?>
    </div>
    </div>
    
    

    

    