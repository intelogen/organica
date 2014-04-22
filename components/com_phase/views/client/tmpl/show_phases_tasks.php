<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();?>

<?php
//echo '<pre>';
//var_dump($this->phasesTasks);
?>

<?php
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