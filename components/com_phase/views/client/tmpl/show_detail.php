<?php    
    $date[] = "Intake data";
    $weight[] = $this->gols[body][val][0]; 
    $fat[] =  $this->gols[body][val][1];
    $ph[] =  $this->gols[body][val][2];
    
if($this->content !== null){
foreach ($this->content as $value){
    $date[] = $value[date][val];
    $weight[] = $value[body][val][0];
    $fat[] = $value[body][val][1];
    $ph[] = $value[body][val][2];
}
}




    $g_name = "goal";
    $g_weight = $this->gols[goal_body][val][0]; 
    $g_fat =  $this->gols[goal_body][val][1];
    $g_ph =  "7";
    
    for($i = 0; $i < count($date); $i++){
        $t = ",['".$date[$i]."', ".$weight[$i].", ".$g_weight."]";
        $b = $b."".$t;
    }
    $a = "[['Date', 'Weight', 'Goal']";
    $c = "]";    
    $d = $a."".$b."".$c;
    
    
    
    for($i = 0; $i < count($date); $i++){
        $t1 = ",['".$date[$i]."', ".$fat[$i].", ".$g_fat."]";
        $b1 = $b1."".$t1;
    }
    $a1 = "[['Date', 'Fat', 'Goal']";
    $c1 = "]";    
    $d1 = $a1."".$b1."".$c1;
    
    
    for($i = 0; $i < count($date); $i++){
        $t2 = ",['".$date[$i]."', ".$ph[$i].", ".$g_ph."]";
        $b2 = $b2."".$t2;
    }
    $a2 = "[['Date', 'PH', 'Goal']";
    $c2 = "]";    
    $d2 = $a2."".$b2."".$c2;
    
    ?>
    
    

<script type="text/javascript" src="https://www.google.com/jsapi"></script>


    
<?php

if ($this->gols)
{
    $gols = $this->gols;
}



if ($this->list)
{
    //$list = $this->list;
}
?>
<div class='contentheading'><?=$this->name?></div>



<?php
if($this->content){
    
?>

<div class='contentheading'>Body History</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    
<div>
<div>
    <span>DATE</span>
    <span>WEIGHT</span>
    <span>FAT</span>
    <span>PH</span>
</div>
<div>
    <span>Intake data</span>
    <span><?=$gols[body][val][0]?></span>
    <span><?=$gols[body][val][1]?></span>
    <span><?=$gols[body][val][2]?></span>
</div>

<?php

foreach ($this->content as $value) 
{   
 ?> 
    <div>
        <span><?=$value[date][val]?></span>
        <span><?=$value[body][val][0]?></span>
        <span><?=$value[body][val][1]?></span>
        <span><?=$value[body][val][2]?></span>
    </div>
<?php
}

?>
    <div>
        <span>Goal</span>
        <span><?=$gols[goal_body][val][0]?></span>
        <span><?=$gols[goal_body][val][1]?></span>
        <span>7</span>
    </div>
</div>
    <div id="chart_div" style="width: 650px; height: 200px;"></div>
    <div id="chart_div_2" style="width: 650px; height: 200px;"></div>
    <div id="chart_div_3" style="width: 650px; height: 200px;"></div>
</div>  



<div class='contentheading'>Symptoms Tracking</div>  
<div class='tabContainer2' style="background-color:#E1FFE3">
    
<?php

if(count($this->content) > 0){
    
foreach($this->content as $value)
{
$symptoms = $value[symptoms][name];
$status =  $value[symptoms][status];
}


if($status[0] !== 0 && $status[0] !== null){

for($i = 0; count($status) > $i; $i++)
{
    if($status[$i] == "finished")
    {
        $result[] = $symptoms[$i];
    }
}
}

$all = count($symptoms);
$finish = count($result);

if($finish > 0){
    
    if($finish == $all)
    {
        echo "<div class='contentheading'>CONGRATULATIONS ALL SYMPTOMS ARE FINISHED !</div>";
    }                                       
    else
    {
        echo "<div class='contentheading'>CONGRATULATIONS ".$finish." OUT OF ".$all." SYMPTOMS FINISHED !</div>";
    }
?>
    <table>
    <?php
        if($result[0] !== ""){

                foreach ($this->list[symptomList] as $value)
            {


                if(in_array($value[id], $result))
                {
                ?>
                    <tr><?="<td>".$value[name]."</td><td> FINISHED ! </td>"?></tr>
                <?php
                }
            }
                       }
            ?>
    </table>
            <?php
    }else{
    echo "<div class='contentheading'>ALL SYMPTOMS IN PROGRESS !</div>";
    }
}
else{
    echo "NO DATA TO DISPLAY";
}
    ?>
</div>



<div class='contentheading'>Medical preparations Tracking</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    
<?php

if(count($this->content) > 0){
   
    foreach($this->content as $value)
    {
        $medtrack_symptoms = $value[drug][name];
        $medtrack_status =  $value[drug][status];
    }


if($medtrack_status[0] !== 0 && $medtrack_status[0] !== null){
    for($i = 0; count($medtrack_status) > $i; $i++)
    {
        if($medtrack_status[$i] == "finished")
        {
            $medtrack_result[] = $medtrack_symptoms[$i];
        }
    }

    $medtrack_all = count($medtrack_symptoms);
    $medtrack_finish = count($medtrack_result);
}

if($medtrack_finish > 0){
    if($medtrack_finish == $all)            
    {                             
        echo "<div class='contentheading'> CONGRATULATIONS, YOU HAVE FINISHED TAKING ALL MEDICINE !</div>";
    }
    else
    {
        echo "<div class='contentheading'>CONGRATULATIONS ".$medtrack_finish." OUT OF ".$medtrack_all." MEDICINE FINISHED !</div>";
    }
    ?>
    <table>
    <?php
    if($medtrack_result){
        foreach ($this->list[medtrackList] as $value)
        {
            if(in_array($value[id], $medtrack_result))
            {
            ?>
                <tr><?="<td>".$value[name]."</td><td> FINISHED ! </td>"?></tr>
            <?php
            }
        }
    }
    ?>
    </table>
   <?php
     }else{
    echo "<div class='contentheading'>ALL MEDICINE IN PROGRESS !</div>";
    }
}else{
    echo "NO DATA TO DISPLAY";
}
?>
</div>



<div class='contentheading'>Diseases Tracking</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    
<?php
if(count($this->content) > 0){
foreach($this->content as $value)
{

$diseases_symptoms = $value[diseases][name];
$diseases_status =  $value[diseases][status];
}

if($diseases_status[0] !== 0 && $diseases_status[0] !== null){

for($i = 0; count($diseases_status) > $i; $i++)
{
    if($diseases_status[$i] == "finished")
    {
        $diseases_result[] = $diseases_symptoms[$i];
    }
}
}
$diseases_all = count($diseases_symptoms);
$diseases_finish = count($diseases_result);

if($diseases_finish > 0){
if($diseases_finish == $diseases_all)
{
    echo "<div class='contentheading'> CONGRATULATIONS ALL DISEASE FINISHED !</div>";
}
else
{
    echo "<div class='contentheading'>CONGRATULATIONS ".$diseases_finish." OUT OF ".$diseases_all." DISEASES FINISHED !</div>";
}

?>
<table>
<?php
if($diseases_result){
foreach ($this->list[diseasesList] as $value)
{
    if(in_array($value[id], $diseases_result))
    {
    ?>
        <tr><?="<td>".$value[name]."</td><td> FINISHED ! </td>"?></tr>
    <?php
    }
}
}
?>
</table>
    <?php
         }else{
    echo "<div class='contentheading'>ALL DISEASES IN PROGRESS !</div>";
    }
    }else{
    echo "NO DATA TO DISPLAY";
}
    ?>
</div>

<div class='contentheading'>Photo History</div>
<?php

    if($this->content[0][date][val] !== "" && $this->content[0][date][val] !== null && $this->content[0][body][val][0] !== "" && $this->content[0][body][val][0] !== null && $this->content[0][photo][0] !== "" && $this->content[0][photo][0] !== null){
        foreach ($this->content as $value)
        {
            ?>
            <div class='tabContainer2' style="background-color:#E1FFE3">
                <div class='contentheading'><?=$value[date][val]."<br>"?></div>
                <div class='contentheading'><?="Weight - ".$value[body][val][0] ?></div>
                <div class='contentheading'><?="Fat - ".$value[body][val][1]." %" ?></div>
                <div class='contentheading'><?="PH - ".$value[body][val][2] ?></div>
                <div class='current-photo'>
                <?= "  <div class='photo-one'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$value[photo][0]."\" width=\"170\" height=\"320\"></div>";?>
                <?= "  <div class='photo-two'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$value[photo][1]."\" width=\"170\" height=\"320\"></div>";?>
                </div>
            </div>
            <?php
        }
    }
?>


















<?php
}

?>



    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$d?>);

        var options = {
          title: 'Weight History',
          //hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
          //vAxis: {minValue: 300},
		  //vAxis: {maxValue: 1520}
		  
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$d1?>);

        var options = {
          title: 'Fat History',
          //hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
          //vAxis: {minValue: 0}
		  
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div_2'));
        chart.draw(data, options);
      }
    </script>

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$d2?>);

        var options = {
          title: 'PH History',
         // hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
          //vAxis: {minValue: 0}
		  
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div_3'));
        chart.draw(data, options);
      }
    </script>
