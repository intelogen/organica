<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>


<?php
$pid = JRequest::getVar('pid');
$uid = JRequest::getVar('uid');
?>


<form action="index.php?option=com_phase&controller=client&step=5&start=1&pid=<?=$pid?>&uid=<?=$uid?>" method="post" name="adminForm" \>

    
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "medtrack<br>";
?>
</div>
    
<?php
foreach ($this->medtrack as $value) 
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
    <input type="submit" value="save" name="action"/>
</p>
</form>



<form action="index.php?option=com_phase&controller=client&task=add_medtrack" method="post" name="adminForm" \>

    
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "Add medtrack<br>";
?>
</div>
    
    <?='Medtrack'?> <input type="text" name="medtrack"    value="" />
    <input type="submit" value="add" name="action"/>
    
    
</div>

    <input type="hidden" name="pid" value="<?=$pid?>" />
    <input type="hidden" name="uid" value="<?=$uid?>" />
    

    
</form>