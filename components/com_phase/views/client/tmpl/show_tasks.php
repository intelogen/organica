<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>


<?php
if ($this->taskData[0] !== null){
    foreach ($this->taskData as $taskData)
    { ?>
        <div class='contentheading'><?=$taskData->summary;?></div>

        <?php
        if($taskData->completed == 1){
            echo "<div class='contentheading'>Status: Target passed</div>";
        } else{
        echo "<div class='contentheading'><a href='index.php?option=com_phase&controller=client&action=finish_task&taskId=$taskData->id'>Finish the task</a></div>";    
        }    
        ?>



        <div class='tabContainer2' style="background-color:#E1FFE3"><?= $taskData->description?></div>
    <?php
    } 
} else{echo "<div class='contentheading'>No description to this task</div>";}
?>