<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();?>

<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>  
<?="Client information:<br>"?>
</div>
<?php
if($this->clientInfo)
{
foreach ($this->clientInfo as $value)
:
?>
<?="name: ".$value->name."<br>"?>
<?="email: ".$value->email."<br>"?>
<?="address: ".$value->address."<br>"?>
<?="city: ".$value->city."<br>"?>
<?="state: ".$value->state."<br>"?>
<?="zip: ".$value->zip."<br>"?>   
<?="phone: ".$value->phone."<br>"?>
<?="birthday: ".$value->birthday."<br>"?>
<?="sex: ".$value->sex."<br>"?>   
        
<div class='objectTitle'>
<p>
<a href="index.php?option=com_phase&controller=client&action=show_repo&c=<?=$value->id?>">User Progress</a>
</p>
<p>
<a href="index.php?option=com_phase&controller=coach&action=show_detail_repo&c=<?=$value->id?>">Detail Progress</a>
</p>
</div>    
    

<?php
endforeach;
}
?>
</div>






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
        
            
            
            
            
          
            
<div class='tabContainer2' style="background-color:#E1FFE3">
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
</div>