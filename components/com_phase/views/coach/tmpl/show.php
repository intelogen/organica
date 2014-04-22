<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();?>

<?php
//echo '<pre>';
//var_dump($this->taskList);
?>





<form action="index.php?option=com_phase&controller=coach&task=1" method="post" name="adminForm" \>

    <?php
    if($this->taskList)
    {
    foreach ($this->taskList as $taskList)
    :
    ?>
    <div class='contentheading'>
    <input type="radio" name="taskId" value="<?= $taskList->id;?> "><?=$taskList->summary;?> 
    </div>
    <?php echo '<br>'; ?>
    
    
    
    <?php
    echo '<br>';
    endforeach;
    }
    ?>



<?php 
JHTML::_('form.token'); 
echo '<br>';
?>


    
    
<input type="submit" value="Edit" name="action"/>
<input type="submit" value="Delete" name="action"/>
</form>



<form action="index.php?option=com_phase&controller=coach&task=1" method="post" name="adminForm" \>
   <?='<br><br>Name:<br>'?>
<input type="text" size="83%" name="newSummary" value="New task name" />
  
<?='<br>Description:<br>'?>
<?php echo $editor->display('newDescription', 'Short description of task', '90%', '300', '60', '20');   ?>

<input type="hidden" name="phaseId" value="<?= $this->phaseId?>"/>

<?="<br>"?><?="<br>"?>
    
    
<input type="submit" value="Create" name="action"/>

</form>




