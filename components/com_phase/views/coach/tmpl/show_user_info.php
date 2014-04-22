<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();?>



<?="Client information:<br>"?>
<?php
if($this->clientInfo)
{
//echo '<pre>';
//var_dump($this->clientInfo);
foreach ($this->clientInfo as $value)
:
?>
<div class='contentheading'>    
<?="Client name: ".$value->name?>
</div>
<?=" Client email: ".$value->email?>

<?php
endforeach;
}
?>







<div class='contentheading'>  
<?="<br>Phases list:"?>
</div>
<?php
if($this->phases)
{
//echo '<pre>';
//var_dump($this->phases);
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
<?php    echo '<br><br>Description :<br>'.$phases->description;?>
<?='<br>'?>
<?php 
JHTML::_('form.token'); 
echo '<br>';
?>
 <input type="hidden" name="userId" value="<?= $value->id ?>"/> 
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
        
            
            
            
            
          
            

<form action="index.php?option=com_phase&controller=coach&phase=1" method="post" name="adminForm" \>
<?php 
JHTML::_('form.token'); 
?>
    <div class='contentheading'>
<?="<br>CREATE NEW PHASE"?>
    </div>
<?='Name:<br>'?>
<input type="text" size="83%" name="newName" value="New phase name" />
<?='<br>Description:<br>'?>
<?php echo $editor->display('newDescription', 'Short description of phase', '90%', '300', '60', '20');   ?>
<?php
$user =& JFactory::getUser();
$coachId = $user->id;
?>
<input type="hidden" name="coachId" value="<?= $coachId ?>"/>
<input type="hidden" name="userId" value="<?= $value->id ?>"/>
<?="<br>"?><?="<br>"?>
<input type="submit" value="Create" name="action"/>
</form>
