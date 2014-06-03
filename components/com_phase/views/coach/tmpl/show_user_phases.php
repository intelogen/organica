<?php
defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();
?>



<?php
$clientId = $this->clientId;
$coachId = $this->coachId;
?>


<div class='contentheading'>  
<?="Phases list:"?>
</div>
<?php

if(count($this->phases) == 0)
{
    echo 'No phases yet';
}
{
    foreach ($this->phases as $phases)
    :
    ?>

    <form action="index.php?option=com_phase&controller=coach&phase=1" method="post" name="adminForm" \>
        <div class='tabContainer2' style="background-color:#E1FFE3">
    <input type="hidden" name="phaseId" value="<?= $phases->id;?>">
    <div class='contentheading'>  
    <?=$phases->name;?> 
    </div>
        <?php if($phases->published == 1){echo "<br>Phase is visible for client";} else {echo "<br>Phase is not visible for client";}?>
    <?php    echo $phases->description;?>
    <?='<br>'?>
    <?php 
    JHTML::_('form.token'); 
    echo '<br>';
    ?>
    <input type="hidden" name="userId" value="<?= $clientId ?>"/> 
    <input type="hidden" name="coachId" value="<?= $coachId ?>"/>
    <input type="submit" value="Edit" name="action"/>
    <input type="submit" value="Delete" name="action"/>
    <input type="submit" value="Show" name="action"/>

        </div>
    </form>
    <?php
    echo '<br>';
    endforeach;
}
?>        
        
            
            
            
            
          
           
<div class='tabContainer2' style="background-color:#E1FFE3">
    <form action="index.php?option=com_phase&controller=coach&phase=1" method="post" name="adminForm" \>
    <?php 
    JHTML::_('form.token'); 
    ?>
    <div class='contentheading'> <?="<br>CREATE NEW PHASE"?> </div>
    <?='Name:<br>'?>
    <input type="text" size="83%" name="newName" value="New phase name" />
    <?='<br>Description:<br>'?>
    <?php echo $editor->display('newDescription', '<p><b style="color: rgb(102, 102, 102); font-family: Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.3em;" mce_style="color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 16px; line-height: 1.3em;">Description</b><span style="color: rgb(102, 102, 102); font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: bold; line-height: 1.3em;" mce_style="color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: bold; line-height: 1.3em;">:</span></p><p><br></p><h1><b><hr>Goals:</b></h1><p><br></p><h1><b><hr>Duration:</b></h1><p><br></p><h1><b><hr>Supplements:</b></h1><p><br></p><p></p><hr><p><br></p><p></p>', '90%', '500', '60', '20');   ?>
    <input type="hidden" name="coachId" value="<?= $coachId ?>"/>
    <input type="hidden" name="userId" value="<?= $clientId ?>"/>
    <?="<br>"?><?="<br>"?>
    <input type="submit" value="Create" name="action"/>
    </form>
</div>