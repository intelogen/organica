<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php
if($this->phaseDesc[0][name] !== "" && $this->phaseDesc[0][name] !== null){
    echo "<div class='contentheading'>".$this->phaseDesc[0][name]."</div>";
    echo "<div class='tabContainer2'>".$this->phaseDesc[0][description]."</div>";
}?>

<?php
if($this->phasesTasks !== null && $this->phasesTasks[0] !== null){
    
    foreach ($this->phasesTasks as $phasesTasks){?>
        <div class='tabContainer2' style="background-color:#E1FFE3">
            <div class='contentheading'><a href="index.php?option=com_phase&controller=client&action=show_tasks&task=<?= $phasesTasks->id;?>"><?= $phasesTasks->summary;?></a></div>


            <?php 
            if($phasesTasks->completed == 1){
                echo 'Status: Target passed<br>';
            }else{echo 'Status: Not completed<br>';}
            ?>
        </div>
    <?php } ?>

    <?php
    if(JRequest::getvar('phase') !== "" && JRequest::getvar('phase') !== null){ ?>
        <div class='tabContainer2' style="background-color:#E1FFE3">
            <div class='contentheading'>
                <a href="index.php?option=com_phase&controller=client&action=phasechek&pid=<?=JRequest::getvar('phase')?>">Progress report </a> 
            </div>
        </div>
    <?php } ?>

<?php
}else{ echo "<div class='contentheading'>No tasks to this phase</div>";}
?>