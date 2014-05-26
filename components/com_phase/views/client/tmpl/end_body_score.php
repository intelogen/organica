<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php
//echo '<pre>';
//var_dump($this->questions);
?>
<?php
$pid = JRequest::getVar('pid');
$uid = JRequest::getVar('uid');
?>

<?php if($this->questions) ?>
<form action="index.php?option=com_phase&controller=client&step=2&end=1&pid=<?=$pid?>&uid=<?=$uid?>" method="post" name="adminForm" \>
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "Retake Intake Survey<br>";
?>
</div>

    
    
<?=' Weight '?> <input type="text"   name="weight" value="" /> <?='lbs<br>'?>
<?='Body Fat'?> <input type="text" name="fat"    value="" /> <?='%<br>'?>
<?='PH Score'?> <input type="text" name="ph"     value="" />
</div>
    
    


<p>
    <input type="submit" id="test" value="save" name="action"/>
</p>
</form>
<?php}?>