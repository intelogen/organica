<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>


<?php
$pid = JRequest::getVar('pid');
$uid = JRequest::getVar('uid');

?>

<div class='tabContainer2' style="background-color:#E1FFE3">

    <?php
    echo 'info:<br>';
    echo 'answer the questions';
    
    
    ?>

</div>



<form action="index.php?option=com_phase&controller=client&step=1&first=1&pid=<?=$pid?>&uid=<?=$uid?>" method="post" name="adminForm" \>
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "How you feel :";
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