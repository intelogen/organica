<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>


<?php
$pid = JRequest::getVar('pid');
$uid = JRequest::getVar('uid');
$id = JRequest::getVar('id');
$tempid = JRequest::getVar('tempid');
?>



<form action="index.php?option=com_phase&controller=client&step=2&pid=<?=$pid?>&uid=<?=$uid?>&id=<?=$id?>&tempid=<?=$tempid?>" method="post" name="adminForm" \>
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "Retake Intake Survey<br>";
?>
</div>

    
    
<?=' Weight '?> <input type="text"   name="weight" value="" /> <?='lbs<br>'?>
<?='Body Fat'?> <input type="text" name="fat"    value="" /> <?='%<br>'?>
<?='PH Score'?> <input type="text" name="ph"     value="" /> <?='lbs<br>'?>
</div>


<?php
if($t == 1):
?>    
<input type="hidden" name="t" value="1"/>
<?php  
endif;
?>
    
    
<p>
    <input type="submit" id="test" value="edit" name="action"/>
</p>
</form>
<?php}?>