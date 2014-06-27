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

?>

<div class='contentheading'><?="Total progress"?></div>

<div class='contentheading'>Body History</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
<ul>
<li><div>
    <span>Date</span>
    <span>weight</span>
    <span>fat</span>
    <span>ph</span>
</div></li>
<li><div>
    <span>Intake data</span>
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
        <span>Goal</span>
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
$status =  $last_list[symptoms][status];


if(count($status) > 0){
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

if($finish == $all)
{
    echo "<div class='contentheading'> CONGRATULATIONS all the symptoms FINISHED !</div>";
}
elseif($finish > 0)
{
    echo "<div class='contentheading'>CONGRATULATIONS ".$finish." out of ".$all." symptoms FINISHED !</div>";
}
else{
    echo "<div class='contentheading'>NO ONE SYMPTON IS FINISHID</div>";
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
