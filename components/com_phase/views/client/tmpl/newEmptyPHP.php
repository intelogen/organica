
        

        <div class="bd-table">
            <div class="bd">
                <span class="bd-name">Goal</span>
                <span class="bd-value"><?=$this->content[goals_body][val][0][2]?></span>
                <span class="bd-value"><?=$this->content[goals_body][val][0][1]?></span>
                <span class="bd-value"><?=$this->content[goals_body][val][0][2]?></span>
            </div>
<!--
<?php

if ($this->content)
{
    $content = $this->content;
}
if ($this->gols)
{
    $gols = $this->gols;
}
if ($this->last_list)
{
    $last_list = $this->last_list;
}
if ($this->list)
{
    $list = $this->list;
}
echo '<br>';
?>

<div class='contentheading'><?="Total progress"?></div>
<div class='contentheading'>Body History</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
<table border ='1'>
<tr>
    <td><div class='contentheading'>date</div></td>
    <td><div class='contentheading'>weight</div></td>
    <td><div class='contentheading'>fat</div></td>
    <td><div class='contentheading'>ph</div></td>
</tr>
<tr>
    <td><div class='contentheading'>Intake data</div></td>
    <td><div class='contentheading'><?=$gols[body][val][0]?></div></td>
    <td><div class='contentheading'><?=$gols[body][val][1]?></div></td>
    <td><div class='contentheading'><?=$gols[body][val][2]?></div></td>
</tr>
<?php
if($content){
foreach ($content as $value) 
{
?>    
    <tr>
        <td><div class='contentheading'><?=$value[date][val]?></div></td>
        <td><div class='contentheading'><?=$value[body][val][0]?></div></td>
        <td><div class='contentheading'><?=$value[body][val][1]?></div></td>
        <td><div class='contentheading'><?=$value[body][val][2]?></div></td>
    </tr>
<?php
}
}
?>
        <tr>
        <td><div class='contentheading'>Goal</div></td>
        <td><div class='contentheading'><?=$gols[goal_body][val][0]?></div></td>
        <td><div class='contentheading'><?=$gols[goal_body][val][1]?></div></td>
        <td><div class='contentheading'>7</div></td>
    </tr>
</table>
</div>

<div class='contentheading'>Symptoms Tracking</div> 
<div class='tabContainer2' style="background-color:#E1FFE3">
    
<?php


$symptoms = $last_list[symptoms][name];
$status =  $last_list[symptoms][status];



for($i = 0; count($status) > $i; $i++)
{
    if($status[$i] == "finished")
    {
        $result[] = $symptoms[$i];
    }
}

$all = count($symptoms);
$finish = count($result);
if($finish == $all)
{
    echo "<div class='contentheading'> CONGRATULATIONS all the symptoms FINISHED !</div>";
}
else
{
    echo "<div class='contentheading'>CONGRATULATIONS ".$finish." out of ".$all." symptoms FINISHED !</div>";
}
?>
<table>
<?php
if($list[symptomList]){
foreach ($list[symptomList] as $value)
{
    if(in_array($value[id], $result))
    {
    ?>
        <tr><?="<td>".$value[name]."</td><td> - FINISHED ! </td>"?></tr>
    <?php
    }
}
}
?>
</table>
</div>

<div class='contentheading'>Medical preparations Tracking</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    
<?php


$medtrack_symptoms = $last_list[drug][name];
$medtrack_status =  $last_list[drug][status];



for($i = 0; count($medtrack_status) > $i; $i++)
{
    if($medtrack_status[$i] == "finished")
    {
        $medtrack_result[] = $medtrack_symptoms[$i];
    }
}

$medtrack_all = count($medtrack_symptoms);
$medtrack_finish = count($medtrack_result);
if($medtrack_finish == $all)
{
    echo "<div class='contentheading'> CONGRATULATIONS all the medical preparations FINISHED !</div>";
}
else
{
    echo "<div class='contentheading'>CONGRATULATIONS ".$finish." out of ".$all." medical preparations FINISHED !</div>";
}
?>
<table>
<?php
if($list[medtrackList]){
foreach ($list[medtrackList] as $value)
{
    if(in_array($value[id], $medtrack_result))
    {
    ?>
        <tr><?="<td>".$value[name]."</td><td> - FINISHED ! </td>"?></tr>
    <?php
    }
}
}
?>
</table>
</div>



<div class='contentheading'>Diseases Tracking</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    
<?php


    $diseases_symptoms = $last_list[diseases][name];
    $diseases_status =  $last_list[diseases][status];

    


for($i = 0; count($diseases_status) > $i; $i++)
{
    if($diseases_status[$i] == "finished")
    {
        $diseases_result[] = $diseases_symptoms[$i];
    }
}

$diseases_all = count($symptoms);
$diseases_finish = count($result);
if($diseases_finish == $diseases_all)
{
    echo "<div class='contentheading'> CONGRATULATIONS all diseases  FINISHED !</div>";
}
else
{
    echo "<div class='contentheading'>CONGRATULATIONS ".$finish." out of ".$all." diseases  FINISHED !</div>";
}
?>
<table>
<?php
if($list[diseasesList]){
foreach ($list[diseasesList] as $value)
{
    if(in_array($value[id], $diseases_result))
    {
    ?>
        <tr><?="<td>".$value[name]."</td><td> - FINISHED ! </td>"?></tr>
    <?php
    }
}
}
?>
</table>
</div>










<div class='contentheading'>Photo History</div>
<div class='tabContainer2' style="background-color:#E1FFE3">

        <div class='contentheading'><?="Intake photo - ".$gols[photo][date]?></div>
    <div class='contentheading'><?="Weight - ".$gols[body][val][0] ?></div>
    <div class='contentheading'><?="Fat - ".$gols[body][val][1]." %" ?></div>
    <div class='contentheading'><?="PH - ".$gols[body][val][2] ?></div>
        <?= "  <div style='font-size:15px;color:#008;'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$gols[photo][val][0]."\" width=\"200\" height=\"350\">";?>
        <?= "  <img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$gols[photo][val][1]."\" width=\"200\" height=\"350\"></div>";?>

<?php
if($content){
foreach ($content as $value)
{
?>
    <div class='tabContainer2' style="background-color:#E1FFE3">
        <div class='contentheading'><?=$value[date][val]."<br>"?></div>
        <div class='contentheading'><?="Weight - ".$value[body][val][0] ?></div>
        <div class='contentheading'><?="Fat - ".$value[body][val][1]." %" ?></div>
        <div class='contentheading'><?="PH - ".$value[body][val][2] ?></div>
        <?= "  <div style='font-size:15px;color:#008;'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$value[photo][0]."\" width=\"170\" height=\"320\">";?>
        <?= "  <img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$value[photo][1]."\" width=\"170\" height=\"320\"></div>";?>
    </div>
<?php
}
}
?>
</div>
-->


///////////////////////////////////////////////////
show detail








<div class='contentheading'>Diseases Tracking</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    
<?php

foreach($this->content as $value)
{

$diseases_symptoms = $value[diseases][name];
$diseases_status =  $value[diseases][status];
}



for($i = 0; count($diseases_status) > $i; $i++)
{
    if($diseases_status[$i] == "finished")
    {
        $diseases_result[] = $diseases_symptoms[$i];
    }
}

$diseases_all = count($symptoms);
$diseases_finish = count($result);
if($diseases_finish == $diseases_all)
{
    echo "<div class='contentheading'> CONGRATULATIONS all Diseases  FINISHED !</div>";
}
else
{
    echo "<div class='contentheading'>CONGRATULATIONS ".$finish." out of ".$all." diseases FINISHED !</div>";
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
        <tr><?="<td>".$value[name]."</td><td> - FINISHED ! </td>"?></tr>
    <?php
    }
}
}
?>
</table>
</div>

/////////////// show total


<div class='contentheading'>Body History</div>
<div class='tabContainer2' style="background-color:#E1FFE3">

<ul>
<li><div>
    <span>DATE</span>
    <span>WEIGHT</span>
    <span>FAT</span>
    <span>PH</span>
</div></li>
<li><div>
    <span>The initial information</span>
    <span><?=$gols[body][val][0]?></span>
    <span><?=$gols[body][val][1]?></span>
    <span><?=$gols[body][val][2]?></span>
</div></li>
<?php
if($content){
foreach ($content as $value) 
{
    if($value[date][val] !== "" && $value[date][val] !== null
            &&  $value[body][val][0] !== "" &&  $value[body][val][0] !== null
            && $value[body][val][1] !== "" && $value[body][val][1] !== null 
            && $value[body][val][2] !== "" && $value[body][val][2] !== null)
    {
    ?>    
    <li><div>
        <span><?=$value[date][val]?></span>
        <span'><?=$value[body][val][0]?></span>
        <span><?=$value[body][val][1]?></span>
        <span><?=$value[body][val][2]?></span>
    </div></li>
<?php
    }

}
}
?>
       <li> <div>
        <span>Your goal is</span>
        <span><?=$gols[goal_body][val][0]?></span>
        <span><?=$gols[goal_body][val][1]?></dspan>
        <span>7</span>
    </div></li>
</ul>
</div>


<div class='contentheading'>Symptoms Tracking</div> 
<div class='tabContainer2' style="background-color:#E1FFE3">
    
<?php


$symptoms = $last_list[symptoms][name];
$status = $last_list[symptoms][status];

if(count($status) > 0 && $status[0] !== ""){
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

if($symptoms[0] == ""){
    echo "<div class='contentheading'>No information to display</div>";
}
else{
if($finish == $all)
{
    echo "<div class='contentheading'>CONGRATULATIONS, ALL SYMPTOMS ARE FINISHED !</div>";
}
elseif($finish > 0)
{
    echo "<div class='contentheading'>CONGRATULATIONS ".$finish." OUT OF ".$all." SYMPTOMS ARE FINISHED !</div>";
}
else{
    echo "<div class='contentheading'>ALL SYMPTOMS IN PROGRESS</div>";
}
}
?>

<ul>
<?php


if($list[symptomList] && $list[symptomList][0] !== "" && $list[symptomList][name][0] !== "" && $result !== null){

foreach ($list[symptomList] as $value)
{
    
    
    if(in_array($value[id], $result))
    {
    ?>
        <div><?="<li>".$value[name]."</td><td> - FINISHED ! </li>"?></div>
    <?php
    }
    
}

}
?>
</ul>
</div>


<div class='contentheading'>MEDICAL PREPARATIONS TRACKING</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    
<?php


$medtrack_symptoms = $last_list[drug][name];
$medtrack_status =  $last_list[drug][status];


if(count($medtrack_status) > 0){
for($i = 0; count($medtrack_status) > $i; $i++)
{
    if($medtrack_status[$i] == "finished")
    {
        $medtrack_result[] = $medtrack_symptoms[$i];
    }
}
}

$medtrack_all = count($medtrack_symptoms);
$medtrack_finish = count($medtrack_result);
if($medtrack_symptoms[0] == ""){
    echo "<div class='contentheading'>No information to display</div>";
}else{
if($medtrack_finish == $all)
{                                     
    echo "<div class='contentheading'> CONGRATULATIONS, ALL MEDICAL PREPARATIONS ARE FINISHED !</div>";
}
elseif($medtrack_finish > 0)
{
    echo "<div class='contentheading'>CONGRATULATIONS ".$medtrack_finish." OUT OF ".$medtrack_all." MEDICAL PREPARATION ARE FINISHED !</div>";
}                                     
else{
    echo "<div class='contentheading'>NO ONE MEDICAL PREPARATIONS ARE FINISHED</div>";
}                                  
}
?>
<table>
<?php
if($list[medtrackList] && $list[medtrackList][0] !== "" && $list[medtrackList][name][0] !== "" && $result !== null){
foreach ($list[medtrackList] as $value)
{
    if(in_array($value[id], $medtrack_result))
    {
    ?>
        <tr><?="<td>".$value[name]."</td><td> - FINISHED ! </td>"?></tr>
    <?php
    }
}
}
?>
</table>
</div>


<div class='contentheading'>Diseases Tracking</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    
<?php


    $diseases_symptoms = $last_list[diseases][name];
    $diseases_status =  $last_list[diseases][status];

    

if(count($diseases_status) > 0){
for($i = 0; count($diseases_status) > $i; $i++)
{
    if($diseases_status[$i] == "finished")
    {
        $diseases_result[] = $diseases_symptoms[$i];
    }
}
}

$diseases_all = count($symptoms);

$diseases_finish = count($diseases_status );
if($diseases_status[0] == ""){
        echo "<div class='contentheading'>No information to display </div>";
}else{
if($diseases_finish == $diseases_all)
{
    echo "<div class='contentheading'> CONGRATULATIONS all diseases  FINISHED !</div>";
}
elseif($diseases_finish > 0)
{
    echo "<div class='contentheading'>CONGRATULATIONS ".$diseases_finish." out of ".$diseases_all." symptoms FINISHED !</div>";
}
else{
    echo "<div class='contentheading'>NO ONE Medical preparations IS FINISHID</div>";
}                                       
}

?>
<table>
<?php
if($list[diseasesList] && $list[diseasesList][0] !== "" && $list[diseasesList][name][0] !== "" && $result !== null){
foreach ($list[diseasesList] as $value)
{
    if(in_array($value[id], $diseases_result))
    {
    ?>
        <tr><?="<td>".$value[name]."</td><td> - FINISHED ! </td>"?></tr>
    <?php
    }
}
}
?>
</table>
</div>

<div class='contentheading'>Photo History</div>
<div class='tabContainer2' style="background-color:#E1FFE3">

        <div class='contentheading'><?="The initial photo - ".$gols[photo][date]?></div>
    <div class='contentheading'><?="WEIGHT - ".$gols[body][val][0] ?></div>
    <div class='contentheading'><?="FAT  - ".$gols[body][val][1]." %" ?></div>
    <div class='contentheading'><?="PH - ".$gols[body][val][2] ?></div>
        <?= "  <div style='font-size:15px;color:#008;'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$gols[photo][val][0]."\" width=\"200\" height=\"350\">";?>
        <?= "  <img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$gols[photo][val][1]."\" width=\"200\" height=\"350\"></div>";?>

<?php

if($content){
foreach ($content as $value)
{
    
    if($value[date][val] !== null && $value[body][val][0] !== "" && $value[body][val][1] !== "" && $value[body][val][2] !== ""){
    ?>
    <div class='tabContainer2' style="background-color:#E1FFE3">
        <div class='contentheading'><?=$value[date][val]."<br>"?></div>
        <div class='contentheading'><?="Weight - ".$value[body][val][0] ?></div>
        <div class='contentheading'><?="Fat - ".$value[body][val][1]." %" ?></div>
        <div class='contentheading'><?="PH - ".$value[body][val][2] ?></div>
        <?= "  <div style='font-size:15px;color:#008;'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$value[photo][0]."\" width=\"170\" height=\"320\">";?>
        <?= "  <img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$value[photo][1]."\" width=\"170\" height=\"320\"></div>";?>
    </div>
<?php
}
}
}

?>
</div>



