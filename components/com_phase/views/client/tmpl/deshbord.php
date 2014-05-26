<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();?>



<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<a href="index.php?option=com_phase&controller=client&action=lastintake">First survey</a>    
</div>
</div>
<?="<br>"?>



<form action="index.php?option=com_phase&controller=client&phase=1" method="post" name="adminForm" \>

    <?php
    if($this->userPhases)
    {
    foreach ($this->userPhases as $userPhases)
    :
    ?>
    
    
    <div class='tabContainer2' style="background-color:#E1FFE3">
    <div class='contentheading'>
        
        
        
        
    <a href="index.php?option=com_phase&controller=client&action=show_phases_tasks&phase=<?= $userPhases->id;?>"><?=$userPhases->name;?></a>
    </div>

    <?php
    
    foreach ($this->finishCountTask[$userPhases->id] as $finishCountTask)
    {
    echo "Tasks - ".$finishCountTask->allCount;    
    }

    foreach ($this->count[$userPhases->id] as $allCountTasks)
    {
    echo " / ".$allCountTasks->allCount;    
    }
    
    echo '<br>';
    if ($finishCountTask->allCount == $allCountTasks->allCount)
    {
        echo "Status: Phase is finish" ;    
    }
    else
    {
       echo "Status: Phase in progress" ;    
    }
    
    echo '<br>Description : ';
    echo $userPhases->description;
    ?>
    
    </div>
    <?php
    echo '<br>';
    endforeach;
    }
    ?>

    <?php 
    JHTML::_('form.token'); 
    echo '<br>';
    ?>

</form>



      
