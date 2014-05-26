<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php
//echo '<pre>';
//var_dump($this->questions);
?>
<?php
$pid = JRequest::getVar('pid');
$uid = JRequest::getVar('uid');
$id = JRequest::getVar('id');
$t = JRequest::getVar('t');
?>



<form action="index.php?option=com_phase&controller=client&step=1&id=<?=$id?>&pid=<?=$pid?>&uid=<?=$uid?>" method="post" name="adminForm" \>
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "Retake Body Score Survey<br>";
?>
</div>
    
<?php
$a = array ();
foreach ($this->questions as $value) 
: 
?>

    
    <input type="checkbox" name="evaluation[]" value="<?=$value->id?>"><?=$value->question?><br>

    
    
    
    
<?php
    if($t == 1):
    ?>    
    <input type="hidden" name="t" value="1"/>
    <?php  
    endif;


endforeach;
?>
</div>

    
    
   <div class='tabContainer2' style="background-color:#E1FFE3">
    <input type="checkbox" name="bool" value="no">NONE OF<br>
</div> 
    
    

<p>
    <input type="submit" value="edit" name="action"/>
    
    
</p>
</form>


