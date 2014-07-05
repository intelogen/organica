<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
?>



<div class='tabContainer2' style="background-color:#E1FFE3">
    <div class='contentheading'> <a href="index.php?option=com_phase&controller=client&action=lastintake">First survey</a></div>
</div>

 <?php
 if($this->userPhases !== null){
    for($i=0; count($this->userPhases)>$i; $i++){?>
        <div class='tabContainer2' style="background-color:#E1FFE3">
            <div class='contentheading'> <a href="index.php?option=com_phase&controller=client&action=show_phases_tasks&phase=<?=$this->userPhases[$i][id]?>"><?=$this->userPhases[$i][name]?></a></div>
            
            <?php
            echo "<span class='fin-task'>Completed tasks - ".$this->finish[$i].' off '.$this->count[$i]."</span>";
            
            if ($this->finish[$i] == $this->count[$i]) {
                echo "<span class='fin-status'>Status - Phase is finish</span>";
            }else{ echo "<span class='fin-status'>Status - Phase in progress</span>";}    
            ?>
            
        </div>
    <?php
    }
 }else{}
    ?>
    