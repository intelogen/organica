<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();?>

<?php
//echo '<pre>';
//var_dump($this->taskData);
?>

<?php
foreach ($this->taskData as $taskData)
:
?>
<div class='contentheading'>
<?php    echo $taskData->summary;
?>
</div>

<?php
if($taskData->completed == 1)
{
    echo 'Status: Target passed<br>';
}
else
{
echo "<a href='index.php?option=com_phase&controller=client&action=finish_task&taskId=$taskData->id'>Finish the task</a>";    
}    
?>



  <div class='tabContainer2' style="background-color:#E1FFE3">
<?php
    echo $taskData->description;
    echo '<br>';
?> 
  </div>

    
<?php
endforeach;
?>

