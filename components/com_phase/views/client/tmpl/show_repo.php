<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?php
$phases = $this-> phases;
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
        
            <?php if(isset($this->evalution[goals][weight]) && $this->evalution[goals][weight] !== ""){?>
            <div class="data-result">
                <span class="value-name"><?="Target Weight: "?></span> <span class="value"><?=$this->evalution[goals][weight]." lbs."?></span>
            </div>
                <?php
            }

            if(isset($this->evalution[goals][fat]) && $this->evalution[goals][fat] !== ""){?>
            <div class="data-result">
            <span class="value-name"><?="Target Body Fat: "?></span> <span class="value"><?=$this->evalution[goals][fat]." %"?></span>
            </div>
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
    <div class='body-stats horizontal-shadow'>
        
        <?php if($this->evalution[stats][sex] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="Sex"?></span>
            <span class="value"><?= $this->evalution[stats][sex]?></span>
        </div>
        <?php }
            
        if($this->evalution[stats][height][0] !== "" && $this->evalution[stats][height][1] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="Height"?></span>
            <span class="value"><?=$this->evalution[stats][height][0]." ft ".$this->evalution[stats][height][1]." inches"?></span>

        </div>
            <?php }

        if($this->evalution[stats][weight] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="Weight"?></span>
            <span class="value"><?= $this->evalution[stats][weight]."lbs"?></span>
        </div>

            <?php } 
        
        if($this->evalution[stats][fat] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="Body Fat"?></span>
            <span class="value"><?=$this->evalution[stats][fat]."%"?></span>
        </div>

            <?php }
        
        if($this->evalution[stats][ph] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="PH"?></span>
            <span class="value"><?=$this->evalution[stats][ph]?></span>
        </div>

            <?php }
        
        if($this->evalution[stats][blood_p][0] !== "" && $this->evalution[stats][blood_p][1] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="Blood Pressure"?></span>
            <span class="value"><?=$this->evalution[stats][blood_p][0]." / ".$this->evalution[stats][blood_p][1]?></span>
        </div>

            <?php }
        
        if($this->evalution[stats][blood_t] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="Blood Type"?></span>
            <span class="value"><?=$this->evalution[stats][blood_t]?></span>
        </div>

            <?php } ?>
    </div>

    <div class='contentheading'>Body Type</div>
    <div class='body-type horizontal-shadow'>

        <?php if($this->evalution[body_type][0] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="1. Bone structure"?></span>
            <span class="value"><?=$this->evalution[body_type][0]?></span>
        </div>
            <?php }
        
        if($this->evalution[body_type][1] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="2. Muscle type"?></span>
            <span class="value"><?=$this->evalution[body_type][1]?></span>
        </div>
            <?php }
        
        if($this->evalution[body_type][2] !== ""){?>
        <div class="data-result">
                <span class="value-name"><?="3. Tendency to gain weight"?></span>
            <span class="value"><?=$this->evalution[body_type][2]?></span>
        </div>
            <?php }
        
        if($this->evalution[body_type][3] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="4. Describe yourself, knowing your age"?></span>
            <span class="value"><?=$this->evalution[body_type][3];?></span>
        </div>
            <?php }
        
        if($this->evalution[body_type][4] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="5. Risk of heart disease"?></span>
            <span class="value"><?= $this->evalution[body_type][4]; ?></span>
        </div>
            <?php } ?>
        <div class="data-result">
            <span class="value-name"><?="6. Body shape that most resembles you own"?></span>
        </div>
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
    <div class='lifestyle horizontal-shadow'>
        <ul>
        <?php
        if($this->qAnswers && $this->qAnswers[0][answer] !== ""){
            foreach ($this->qAnswers as $value) {
                echo "<li>".$value['answer']."</li>";
            }
        }
        ?>
        </ul>
    </div>
    
    <div id="qchart_div" style="width: 690px; height: 400px;"></div>
    
    <div class='contentheading'>Current Photo</div>
    <div class='current-photo horizontal-shadow'>

        <?php
        if($this->evalution[file][0] !== null && $this->evalution[file][0] !== "")
        {
            ?>
            <?php
            echo "<div class='photo-one'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->evalution[file][0]."\" width=\"200\" height=\"350\"></div>";
        }
        else
        {
            echo "<div class='photo-one'>
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
    <div class='body-type horizontal-shadow'>
            
    <?php if($this->evalution[madtrack][exem] && $this->evalution[madtrack][exem] !== null && $this->evalution[madtrack][exem] !== ""){?>
        <div class="data-result">
        <span class='value-name'><?="1. Your last physical exam was"?></span>
        <span class='value'><?=$this->evalution[madtrack][exem]?></span>
        </div>
    <?php }
    
    if($this->evalution[madtrack][treatment][status] && $this->evalution[madtrack][treatment][status] !== null &&$this->evalution[madtrack][treatment][status] !== ""){ ?>
        <div class="data-result">
        <span class='value-name'><?="2. Undermedical treatment"?></span>
        <span class='value'><?=$this->evalution[madtrack][treatment][status]?></span>
        </div>
        Note: <span class='value'><?=$this->evalution[madtrack][treatment][note]?></span>
        
    <?php }
    
    if($this->evalution[madtrack][operations][status] && $this->evalution[madtrack][operations][status] !== null && $this->evalution[madtrack][operations][status] !== ""){ ?>
        <div class="data-result">
        <span class='value-name'><?="3. Have you ever had any seriousillness or operations ?"?></span>
        <span class='value'><?=$this->evalution[madtrack][operations][status]?></span>
        </div>
        Note: <span class='value'><?=$this->evalution[madtrack][operations][note]?></span>
    <?php }
    
    if($this->evalution[madtrack][smoke][status] && $this->evalution[madtrack][smoke][status] !== null & $this->evalution[madtrack][smoke][status] !== ""){ ?>
            <div class="data-result">
            <span class='value-name'><?="4. Do you smoke ?"?></span>
            <span class='value'><?=$this->evalution[madtrack][smoke][status]?></span>
            </div>
            Note: <span class='value'><?= $this->evalution[madtrack][smoke][note]?></span>
    <?php }
    
    if($this->evalution[madtrack][alcohol][status] && $this->evalution[madtrack][alcohol][status] !== null && $this->evalution[madtrack][alcohol][status] !== ""){?>
        <div class="data-result">
            <span class='value-name'><?="5. Alcohol use ?"?></span>
        <span class='value'><?=$this->evalution[madtrack][alcohol][status]?></span>
        </div>
        Note: <span class='value'><?=$this->evalution[madtrack][alcohol][note]?></span>
    <?php }
    

    if($this->evalution[madtrack][drugs][status] && $this->evalution[madtrack][drugs][status] !== null && $this->evalution[madtrack][drugs][status] !== ""){?>
        <div class="data-result">
            <span class='value-name'><?="6. Do you use cocaine or drugs ?"?></span>
        <span class='value'><?=$this->evalution[madtrack][drugs][status]?></span>
        </div>
        Note: <span class='value'><?=$this->evalution[madtrack][drugs][note]?></span>
    <?php } ?>
        
    </div>
            
            
    <div class='contentheading'>Allergies Tracking</div>
    <div class='tabContainer2 horizontal-shadow' style="background-color:#E1FFE3">
    <ul>
    <?php
    if($this->evalution[madtrack][allergies][status][0] !== "")
        {

            foreach ($this->allergiesList as $value)
            {
                if(in_array($value['id'],$this->evalution[madtrack][allergies][status]))
                {
                    echo "<li>".$value[name]."</li>";
                }
            }
        }
        else{
            echo "NO DATA TO DISPLAY";
        }
    ?>
    </ul>
    </div>
    
    <div class='contentheading'>Symptoms Tracking</div>
    <div class='tabContainer2 horizontal-shadow' style="background-color:#E1FFE3">
        <ul>
        <?php
        if($this->evalution[madtrack][symptoms][status][0] !== "")
        {
            foreach ($this->symptomList as $value)
            {
                if(in_array($value['id'],$this->evalution[madtrack][symptoms][status]))
                {
                    echo "<li>".$value[name]."</li>";
                }
            }
        }
        else{
            echo "NO DATA TO DISPLAY";
        }
        ?>
        </ul>
    </div>
    
    <div class='contentheading'>Medical preparations Tracking</div>
    <div class='tabContainer2 horizontal-shadow' style="background-color:#E1FFE3">
        <ul>
        <?php
        if($this->evalution[madtrack][drug][status][0] !== "")
        {
            foreach ($this->medtrackList as $value)
            {
                if(in_array($value['id'],$this->evalution[madtrack][drug][status]))
                {
                    echo "<li>".$value[name]."</li>";
                }
            }
        }
        else{
            echo "NO DATA TO DISPLAY";
        }
        ?>
        </ul>
    </div>
    
    <div class='contentheading'>Diseases Tracking</div>
    <div class='tabContainer2 horizontal-shadow' style="background-color:#E1FFE3">
        <ul>
        <?php
        if($this->evalution[madtrack][diseases][status][0] !== "")
        {
            foreach ($this->diseasesList as $value)
            {
                if(in_array($value['id'],$this->evalution[madtrack][diseases][status]))
                {
                    echo "<li>".$value[name]."</li>";
                } 
            }
        }
        else{
            echo "NO DATA TO DISPLAY";
        }
        ?>
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