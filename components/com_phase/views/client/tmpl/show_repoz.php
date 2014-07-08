<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?php
$uid = $this->uid;
$pid = $this->pid;
$phases = $this->phases;

if(JRequest::getVar('c') && JRequest::getVar('c') != "")
        {
            $uid = JRequest::getVar('c');
        }                                
?>


<div class='contentheading phase-navigation-header'>Phases Navigation</div>
<div class='tabContainer2 phase-navigation' style="background-color:#E1FFE3">
    <ul>
        <li><a href="index.php?option=com_phase&controller=client&action=show_repo&c=<?=$uid?>">Intake Survey</a></li>

        <?php if ($phases && $phases[0][id] !== null && $phases[0][name] !== null ){
            foreach ($phases as $value){?>
                <li><a href="index.php?option=com_phase&controller=client&action=show_repoz&c=<?=$uid?>&pid=<?=$value[id]?>"><?=$value[name]?></a></a></li>
            <?php
            }
        } ?>
        <li><a href="index.php?option=com_phase&controller=client&action=show_total_repo&c=<?=$uid?>">Total Progress</a></li>
    </ul>
</div>

<?php if ($phases && $phases[0][id] !== null && $phases[0][name] !== null ){?>
<div class='contentheading'>Compare The Phases</div>   
<div class='tabContainer2' style="background-color:#E1FFE3">
    <form action="index.php?option=com_phase&controller=client&compare=1"  method="post" enctype="multipart/form-data"> 
<input type="hidden" name="uid" value="<?=$uid?>"/>
        <select name="phaseId[0]">
                    <option value= "0" > Intake Survey </option>
                    <?php
                    foreach ($phases as $value)
                    {
                    ?>
                        <option value= "<?=$value[id]?>"><?=$value[name]?></option>
                    <?php
                    }
                    ?>
        </select>
    and
<select name="phaseId[1]">
                    <option value= "0" > Intake Survey </option>
                    <?php
                    foreach ($phases as $value)
                    {
                    ?>
                        <option value= "<?=$value[id]?>"><?=$value[name]?></option>
                    <?php
                    }
                    ?>
</select>
    <button class="button validate" type="submit" id="test" value="compare" name="action"><?= "Compare" ?></button>
    </form>
</div>
<?php } ?>

<?php if ($phases && $phases[0][id] !== null && $phases[0][name] !== null ){?>
<div class='contentheading'>Show Detailed Report Of Phase</div>   
<div class='tabContainer2' style="background-color:#E1FFE3">
<form action="index.php?option=com_phase&controller=client&show_detail=1"  method="post" enctype="multipart/form-data">    
    <input type="hidden" name="uid" value="<?=$uid?>"/>
    <select name="pid">
                    <?php
                    foreach ($phases as $value)
                    {
                    ?>
                        <option value= "<?=$value[id]?>"><?=$value[name]?></option>
                    <?php
                    }
                    ?>
</select>
        <button class="button validate" type="submit" id="test" value="show_detail" name="action"><?= "Show" ?></button>
</form>
</div>
<?php } ?>

 <div class='contentheading'>Body stats</div>
    <div class='body-stats horizontal-shadow'>
        <div class="data-result">
            <span class="value-name"><?="Weight"?></span>
            <span class="value"><?=$this->evalution[body][val][0]?><?=" lbs"?></span>
        </div>
        
        <div class="data-result">
            <span class="value-name"><?="Body Fat"?></span>
            <span class="value"><?=$this->evalution[body][val][1]?><?=" %"?></span>
        </div>
        
        <div class="data-result">
            <span class="value-name"><?="PH"?></span>
            <span class="value"><?=$this->evalution[body][val][2]?></span>
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
        else{echo "CONGRATULATIONS, YOU'VE ACHIEVED THE GOAL";}
        ?>
        </ul>
    </div>
<?php if($this->d !== "" && $this->d !== null){?>
<div id="qchart_div" style="width: 690px; height: 400px;"></div>
<?php } ?>
 

    <div class='contentheading'>Current Photo</div>
    <div class='current-photo horizontal-shadow'>

        <?php
        if($this->evalution[photo][val][0] !== ""){
            echo "<div class='photo-one'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->evalution[photo][val][0]."\" width=\"200\" height=\"350\"></div>";
        } else {
            echo "<div class='photo-one'>
                    <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no1.png"."\" width=\"200\" height=\"350\">
                    </div>";        
        }?>
 

        <?php
        if($this->evalution[photo][val][1] !== ""){
           echo "<div class='photo-two'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->evalution[photo][val][1]."\" width=\"200\" height=\"350\"></div>";
        } else{
            echo "<div class='photo-two'>
                    <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no2.png"."\" width=\"200\" height=\"350\">
                    </div>";        
        }?>

</div>      

    
<div class='contentheading'>Symptoms Tracking</div>    
<div class='tabContainer2 horizontal-shadow' style="background-color:#E1FFE3">
    <table id="medical" border="1">
        <?php if ($this->evalution[symptoms][val][0] !== "" && $this->evalution[symptoms][status][0] !== "")
            {?>
                <tr>
                    <td><b>№</b></td>
                    <td><b>Name</b></td>
                    <td><b>Status</b></td>
                    <td><b>Note</b></td>
                </tr>
            <?php
            $cnt = 1;
            for ($i = 0; $i < count($this->evalution[symptoms][val]); $i++)
            {
            ?>
                <tr>
                <td><?=$cnt++?></td>
                <td>
                    <?php
                    foreach($this->evalution[medtrack][symptomList] as $value)
                    {
                        if($value[id] == $this->evalution[symptoms][val][$i])
                        {
                            echo $value[name];
                        }
                    }
                    ?>
                </td>
                <td>
                    <?=$this->evalution[symptoms][status][$i];?>
                </td>
                <td>
                    <?=$this->evalution[symptoms][note][$i];?>
                </td>
                </div></li></tr>
            <?php    
            }
    }else{ echo "NO DATA TO DISPLAY"; }?>
    </table>
  
</div>




<div class='contentheading'>Medical preparations Tracking</div>
<div class='tabContainer2 horizontal-shadow' style="background-color:#E1FFE3">
    <table id="medical" border="1">
<?php if ($this->evalution[drug][val][0] !== "" && $this->evalution[drug][status][0] !== ""){?>
                <tr>
                    <td><b>№</b></td>
                    <td><b>Name</b></td>
                    <td><b>Status</b></td>
                    <td><b>Note</b></td>
                </tr>
            <?php
    $cnt = 1;
    for ($i = 0; $i < count($this->evalution[drug][val]); $i++){?>
        <tr>
            <td><?=$cnt++?></td>
        <td>
            <?php
            foreach($this->evalution[medtrack][medtrackList] as $value){
                if($value[id] == $this->evalution[drug][val][$i]){
                    echo $value[name];
                }
            } ?>
        </td>
        <td>
            <?=$this->evalution[drug][status][$i]?>
        </td>
        <td>
            <?=$this->evalution[drug][note][$i];?>
        </td>
        </tr>
    <?php    
    }
} else{ echo "NO DATA TO DISPLAY";}?>
        </table>
</div>

<div class='contentheading'>Diseases Tracking</div>
<div class='tabContainer2 horizontal-shadow' style="background-color:#E1FFE3">
    <table id="medical" border="1">
<?php if ($this->evalution[diseases][val][0] !== "" && $this->evalution[diseases][status][0] !== ""){?>
                <tr>
                    <td><b>№</b></td>
                    <td><b>Name</b></td>
                    <td><b>Status</b></td>
                    <td><b>Note</b></td>
                </tr>
            <?php
        $cnt = 1;
        for ($i = 0; $i < count($this->evalution[diseases][val]); $i++){ ?>
            <tr>
                <td><?=$cnt++?></td>
            <td>
                <?php
                foreach($this->evalution[medtrack][diseasesList] as $value){
                    if($value[id] == $this->evalution[diseases][val][$i]){
                        echo $value[name];
                    }
                }
                ?>
            </td>
            <td>
                <?=$this->evalution[diseases][status][$i];?>
            </td>
            <td>
                <?=$this->evalution[diseases][note][$i];?>
            </td>
            </tr>
        <?php    
        } 
        }else { echo "NO DATA TO DISPLAY";}?>
        </table>
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



