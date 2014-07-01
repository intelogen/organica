<?php
defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();
?>



<?php
foreach ($this->phasesTasks as $value)
{
$pid = $value->pid;    
}
$user =& JFactory::getUser();
$userId = $user->id;
?>
<?php
if($this->phaseDesc)
{
    $phaseDesc = $this->phaseDesc[0];
    
?>    
    <div class='contentheading'>
    <?= $phaseDesc[name]."<br>"?>
    </div>
<div class='tabContainer2' style="background-color:#E1FFE3">
<?php
    echo $phaseDesc[description];
}
?>
</div>



<?= "<br>" ?>





<?php


if($this->phasesTasks !== null && $this->phasesTasks[0] !== null){
    

    foreach ($this->phasesTasks as $phasesTasks)
:
?>
  <div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<a href="index.php?option=com_phase&controller=client&action=show_tasks&task=<?= $phasesTasks->id;?>"><?=$phasesTasks->summary;?></a>    
</div>
<?php 
if($phasesTasks->completed == 1)
{
    echo 'Status: Target passed<br>';
}
 else
{
    echo 'Status: Not completed<br>';
}
?>

</div>
<?php
echo '<br>';
endforeach;
?>



<div class='tabContainer2' style="background-color:#E1FFE3">
    
<div class='contentheading'>
<?php
if(isset($pid))
{
?>
<a href="index.php?option=com_phase&controller=client&action=phasechek&pid=<?=$pid?>">Progress report </a> 
<?php
}
}else{echo "<div class='contentheading'>No tasks to this phase</div>";}
?>
</div>
    
</div>