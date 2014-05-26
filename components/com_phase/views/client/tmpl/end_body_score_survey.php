<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php
//echo '<pre>';
//var_dump($this->questions);
?>
<?php
$pid = JRequest::getVar('pid');
$uid = JRequest::getVar('uid');

?>



<form action="index.php?option=com_phase&controller=client&step=1&end=1&pid=<?=$pid?>&uid=<?=$uid?>" method="post" name="adminForm" \>
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "Retake Body Score Survey<br>";
?>
</div>
    
<?php
$a = array ();
$i = 0;
foreach ($this->questions as $value) 
: 
?>

    <input type="checkbox" name="evaluation[]" value="<?=$value->id?>"><?=$value->question?><br>

<?php
$i++;
endforeach;
?>
</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    <input type="checkbox" name="bool" value="no">NONE OF<br>
</div>

<p>
    
    <input type="submit" id="test" value="save" name="action"/>
    
    
</p>
</form>


