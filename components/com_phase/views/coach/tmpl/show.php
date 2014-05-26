<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();?>






<div class='contentheading'>  
<?="<br>Task list:"?>
</div>
<?php
if(count($this->taskList) == 0)
:
    echo 'No task yet';
else:
?>



<form action="index.php?option=com_phase&controller=coach&task=1" method="post" name="adminForm" \>

    <?php
    if($this->taskList)
    {
    foreach ($this->taskList as $taskList)
    :
    ?>
    <div class='tabContainer2' style="background-color:#E1FFE3">
    <div class='contentheading'>
    <input type="radio" name="taskId" value="<?= $taskList->id;?> "><?=$taskList->summary;?> 
    </div>
    </div>
    
    
    
    <?php

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
<?php
endif;
?>



<div class='contentheading'>  
<?="<br>Create newt task"?>
</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
<form action="index.php?option=com_phase&controller=coach&task=1" method="post" name="adminForm" \>
 <?='Name:<br>'?>
<input type="text" size="83%" name="newSummary" value="New task name" />
  
<?='<br>Description:<br>'?>
<?php echo $editor->display('newDescription', 'Short description of task', '90%', '300', '60', '20');   ?>

<input type="hidden" name="phaseId" value="<?= $this->phaseId?>"/>

<?="<br>"?><?="<br>"?>
    
    
<input type="submit" value="Create" name="action"/>

</form>
</div>



