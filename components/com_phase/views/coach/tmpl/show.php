<?php
defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();
?>

<div class='contentheading'>  <?="<br>Task list:"?> </div>
<?php
if(count($this->taskList) == 0)
:
    echo 'No task yet';
else:
    if($this->taskList)
    {
        foreach ($this->taskList as $taskList)
        :
        ?>
            <form action="index.php?option=com_phase&controller=coach&task=1" method="post" name="adminForm" \>
                <div class='tabContainer2' style="background-color:#E1FFE3">
                <div class='contentheading'>
                <input type="hidden" name="taskId" value="<?= $taskList->id;?>">
                <input type="hidden" name="pid" value="<?= $taskList->pid;?>">
                
                <?=$taskList->summary;?>
                </div>
                <?=$taskList->description?>
                <?="<br>"?>
                <input type="submit" value="Edit" name="action"/>
                <input type="submit" value="Delete" name="action"/>
                </div>
                <?phpJHTML::_('form.token');?>
            </form>
        <?php
        endforeach;
    }
    ?>

    
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



