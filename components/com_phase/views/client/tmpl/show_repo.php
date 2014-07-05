<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?php
$phases = $this->phases;
$count = count($phases);
?>


<div class='contentheading phase-navigation-header'>Phases Navigation</div>
<div class='tabContainer2 phase-navigation' style="background-color:#E1FFE3">
    <ul>
        <li><a href="index.php?option=com_phase&controller=client&action=show_repo&c=<?=$this->uid?>">Intake Survey</a></li>

        <?php
        if ($phases && $phases[0][id] !== null && $phases[0][name] !== null )
        {
            foreach ($phases as $value)
            {
                ?>
                <li><a href="index.php?option=com_phase&controller=client&action=show_repoz&c=<?=$this->uid?>&pid=<?=$value[id]?>"><?=$value[name]?></a></li>
            <?php
            }
        }
        ?>
        <li><a href="index.php?option=com_phase&controller=client&action=show_total_repo&c=<?=$this->uid?>">Total Progress</a></li>
    </ul>
</div>


    <div class='contentheading'>Client goals</div>
    <div class='goals horizontal-shadow'>
        <?php if($this->evalution[goals_body][val][0] !== ""){?>
                <div class="data-result">
                    <span class="value-name"><?="Target Weight: "?></span> <span class="value"><?=$this->evalution[goals_body][val][0]." lbs."?></span>
                </div>
                <?php
            }

            if($this->evalution[goals_body][val][1] !== ""){?>
                <div class="data-result">
                    <span class="value-name"><?="Target Body Fat: "?></span> <span class="value"><?=$this->evalution[goals_body][val][1]." %"?></span>
                </div>
            <?php
            } ?>
            
            <table>
            <?php
            if(count($this->loockingfor) !== 0){ ?>
                <tr>
                    <?php
                    $cnt = 1;
                    foreach($this->loockingfor as $value){                                                                     
                        ?>
                        <td style='border:1px solid #EEE;padding:3px;' align="center" ><input type="checkbox" name="evalution[goals][question][]" value="<?=$value['id'];?>" <?php if(isset($this->evalution[goals_quest][val])){ if(in_array($value['id'],$this->evalution[goals_quest][val])) {echo "checked";}} ?>></td>
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
    <div class='body-stats horizontal-shadow'>
        
        <?php if($this->evalution[stats_sex][val][0] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="Sex"?></span>
            <span class="value"><?= $this->evalution[stats_sex][val][0]?></span>
        </div>
        <?php }
            
        if($this->evalution[stats_height][val][0] !== "" && $this->evalution[stats_height][val][1] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="Height"?></span>
            <span class="value"><?=$this->evalution[stats_height][val][0]." ft ".$this->evalution[stats_height][val][1]." inches"?></span>

        </div>
            <?php }

        if($this->evalution[body][val][0] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="Weight"?></span>
            <span class="value"><?=$this->evalution[body][val][0]."lbs"?></span>
        </div>

            <?php } 
        
        if($this->evalution[body][val][1] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="Body Fat"?></span>
            <span class="value"><?=$this->evalution[body][val][1]."%"?></span>
        </div>

            <?php }
        
        if($this->evalution[body][val][2] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="PH"?></span>
            <span class="value"><?=$this->evalution[body][val][2]?></span>
        </div>

            <?php }
        
        if($this->evalution[stats_b_p][val][0] !== "" && $this->evalution[stats_b_p][val][1] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="Blood Pressure"?></span>
            <span class="value"><?=$this->evalution[stats_b_p][val][0]." / ".$this->evalution[stats_b_p][val][1]?></span>
        </div>

            <?php }
        
        if($this->evalution[stats_b_t][val][0] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="Blood Type"?></span>
            <span class="value"><?=$this->evalution[stats_b_t][val][0]?></span>
        </div>

            <?php } ?>
    </div>

    
    <div class='contentheading'>Body Type</div>
    <div class='body-type horizontal-shadow'>

        <?php if($this->evalution[body_type][val][0] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="1. Bone structure"?></span>
            <span class="value"><?=$this->evalution[body_type][val][0]?></span>
        </div>
            <?php }
        
        if($this->evalution[body_type][val][1] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="2. Muscle type"?></span>
            <span class="value"><?=$this->evalution[body_type][val][1]?></span>
        </div>
            <?php }
        
        if($this->evalution[body_type][val][2] !== ""){?>
        <div class="data-result">
                <span class="value-name"><?="3. Tendency to gain weight"?></span>
            <span class="value"><?=$this->evalution[body_type][val][2]?></span>
        </div>
            <?php }
        
        if($this->evalution[body_type][val][3] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="4. Describe yourself, knowing your age"?></span>
            <span class="value"><?=$this->evalution[body_type][val][3];?></span>
        </div>
            <?php }
        
        if($this->evalution[body_type][val][4] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="5. Risk of heart disease"?></span>
            <span class="value"><?= $this->evalution[body_type][val][4]; ?></span>
        </div>
            <?php } ?>
        <div class="data-result">
            <span class="value-name"><?="6. Body shape that most resembles you own"?></span>
        </div>
        <div class="body-type-photo">
        <?php
        if($this->evalution[body_type][val][5] !== ""){
            echo "<img src=\"".JURI::root().'uploads_jtpl/phase_img/'.$this->evalution[body_type][val][5]."\" width=\"200\" height=\"350\">";}
        ?>
        </div>
</div>
    
    <div class='contentheading'>Lifestyle analysis</div>    
    <div class='lifestyle horizontal-shadow'>
        <ul>
        <?php if($this->qAnswers && $this->qAnswers[0][answer] !== ""){
                foreach ($this->qAnswers as $value) {
                    echo "<li>".$value['answer']."</li>";
                }
                }?>
        </ul>
    </div>
    
    
    
    
    <?php if($this->d !== "" && $this->d !== null){echo '<div id="qchart_div" style="width: 690px; height: 400px;"></div>'; } ?>

    
    <div class='contentheading'>Current Photo</div>
    <div class='current-photo horizontal-shadow'>
        
        <?php if($this->evalution[photo][val][0] !== null && $this->evalution[photo][val][0] !== ""){
            echo "  <div class='photo-one'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->evalution[photo][val][0]."\" width=\"200\" height=\"350\"></div>";
        }else{
            echo "  <div class='photo-one'>
            <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no1.png"."\" width=\"200\" height=\"350\">
            </div>";
        }
        
        if($this->evalution[photo][val][1] !== null && $this->evalution[photo][val][1] !== ""){
            echo "  <div class='photo-two'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->evalution[photo][val][1]."\" width=\"200\" height=\"350\"></div>";
        }else{
            echo "  <div class='photo-two'>
            <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no2.png"."\" width=\"200\" height=\"350\">
            </div>";
        }?>

    </div>

    
    
    <div class='contentheading'>Medical Tracking</div>
    <div class='body-type horizontal-shadow'>
            
        <?php if($this->evalution[med_exem][val][0] && $this->evalution[med_exem][val][0] !== null && $this->evalution[med_exem][val][0] !== ""){?>
            <div class="data-result">
            <span class='value-name'><?="1. Your last physical exam was"?></span>
            <span class='value'><?=$this->evalution[med_exem][val][0]?></span>
            </div>
        <?php }
    
        if($this->evalution[treatment][status][0] && $this->evalution[treatment][status][0] !== null && $this->evalution[treatment][status][0] !== ""){ ?>
            <div class="data-result">
            <span class='value-name'><?="2. Undermedical treatment"?></span>
            <span class='value'><?=$this->evalution[treatment][status][0]?></span>
            </div>
            Note: <span class='value'><?=$this->evalution[treatment][note][0]?></span>
        <?php }

        if($this->evalution[operations][status][0] && $this->evalution[operations][status][0] !== null && $this->evalution[operations][status][0] !== ""){ ?>
            <div class="data-result">
            <span class='value-name'><?="3. 3. Have you ever had any seriousillness or operations ?t"?></span>
            <span class='value'><?=$this->evalution[operations][status][0]?></span>
            </div>
            Note: <span class='value'><?=$this->evalution[operations][note][0]?></span>
        <?php }
    
        if($this->evalution[smoke][status][0] && $this->evalution[smoke][status][0] !== null && $this->evalution[smoke][status][0] !== ""){ ?>
            <div class="data-result">
            <span class='value-name'><?="4. Do you smoke ?"?></span>
            <span class='value'><?=$this->evalution[smoke][status][0]?></span>
            </div>
            Note: <span class='value'><?=$this->evalution[smoke][note][0]?></span>
        <?php }
        
    if($this->evalution[alcohol][status][0] && $this->evalution[alcohol][status][0] !== null && $this->evalution[alcohol][status][0] !== ""){ ?>
            <div class="data-result">
            <span class='value-name'><?="5. Alcohol use ?"?></span>
            <span class='value'><?=$this->evalution[alcohol][status][0]?></span>
            </div>
            Note: <span class='value'><?=$this->evalution[alcohol][note][0]?></span>
        <?php }
        
        if($this->evalution[drugs][status][0] && $this->evalution[drugs][status][0] !== null && $this->evalution[drugs][status][0] !== ""){ ?>
            <div class="data-result">
            <span class='value-name'><?="6. Do you use cocaine or drugs ?"?></span>
            <span class='value'><?=$this->evalution[drugs][status][0]?></span>
            </div>
            Note: <span class='value'><?=$this->evalution[drugs][note][0]?></span>
        <?php }
        ?>
        
    </div>
            
            
    <div class='contentheading'>Allergies Tracking</div>
    <div class='tabContainer2 horizontal-shadow' style="background-color:#E1FFE3">
    <ul>
    <?php if($this->evalution[allergies][val][0] !== ""){

            foreach ($this->evalution[medtrack][allergiesList] as $value){
                if(in_array($value['id'],$this->evalution[allergies][val])){
                    echo "<li>".$value[name]."</li>";
                }
            }
        }else{
            echo "NO DATA TO DISPLAY";
        } ?>
    </ul>
    </div>
    
    
    
    
    
    <div class='contentheading'>Symptoms Tracking</div>
    <div class='tabContainer2 horizontal-shadow' style="background-color:#E1FFE3">
        <ul>
        <?php if($this->evalution[symptoms][val][0] !== ""){

            foreach ($this->evalution[medtrack][symptomList] as $value){
                if(in_array($value['id'],$this->evalution[symptoms][val])){
                    echo "<li>".$value[name]."</li>";
                }
            }
        }else{
            echo "NO DATA TO DISPLAY";
        } ?>
        </ul>
    </div>
    
    
    
    
    <div class='contentheading'>Medical preparations Tracking</div>
    <div class='tabContainer2 horizontal-shadow' style="background-color:#E1FFE3">
        <ul>
        <?php if($this->evalution[drug][val][0] !== ""){

            foreach ($this->evalution[medtrack][medtrackList] as $value){
                if(in_array($value['id'],$this->evalution[drug][val])){
                    echo "<li>".$value[name]."</li>";
                }
            }
        }else{
            echo "NO DATA TO DISPLAY";
        } ?>
        </ul>
    </div>
    
    
    
    <div class='contentheading'>Diseases Tracking</div>
    <div class='tabContainer2 horizontal-shadow' style="background-color:#E1FFE3">
        <ul>
        <?php if($this->evalution[diseases][val][0] !== ""){

            foreach ($this->evalution[medtrack][diseasesList] as $value){
                if(in_array($value['id'],$this->evalution[diseases][val])){
                    echo "<li>".$value[name]."</li>";
                }
            }
        }else{
            echo "NO DATA TO DISPLAY";
        } ?>
        </ul>
    </div>
    
    

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() { 
        var data = google.visualization.arrayToDataTable(<?=$this->d?>);

        
        var options = {
            vAxis: {minValue: 0, maxValue: 100}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('qchart_div'));
        chart.draw(data, options);
      }
    </script>