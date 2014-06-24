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