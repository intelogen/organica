<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>


<?php
$pid = JRequest::getVar('pid');
$uid = JRequest::getVar('uid');
?>


<form action="index.php?option=com_phase&controller=client&step=6&start=1&pid=<?=$pid?>&uid=<?=$uid?>" method="post" name="adminForm" \>

    
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "Retake Intake Survey<br>";
?>
</div>

    
<?php
foreach ($this->diseases as $value) 
: 
?>

    <input type="checkbox" name="evaluation[]" value="<?=$value->id?>"><?=$value->name?><br>

<?php
endforeach;
?>
   
</div>

<div class='tabContainer2' style="background-color:#E1FFE3">
    <input type="checkbox" name="bool" value="no">I do not feel any symptoms<br>
</div>

<p>
    <input type="submit" id="test" value="save" name="action"/>
</p>
</form>






<form action="index.php?option=com_phase&controller=client&task=add_diseases" method="post" name="adminForm" \>

    
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "Add medtrack<br>";
?>
</div>
    
    <?='Diseases'?> <input type="text" name="diseases"    value="" />
    <input type="submit" value="add" name="action"/>
    
    
</div>

    <input type="hidden" name="pid" value="<?=$pid?>" />
    <input type="hidden" name="uid" value="<?=$uid?>" />
    

    
</form>