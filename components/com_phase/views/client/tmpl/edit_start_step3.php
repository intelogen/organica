<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>


<?php
$pid = JRequest::getVar('pid');
$uid = JRequest::getVar('uid');
$id = JRequest::getVar('id');
$tempid = JRequest::getVar('tempid');
?>

<form action="index.php?option=com_phase&controller=client&step=3&pid=<?=$pid?>&uid=<?=$uid?>&id=<?=$id?>&tempid=<?=$tempid?>"  method="post" enctype="multipart/form-data">

    
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "Retake Body Photo<br>";
?>
</div>
    
        <input type='file' name='filename' />
        <input type='file' name='filename2' />
    
</div>

    
    
    <input type="hidden" name="pid" value="<?=$pid?>" />
    <input type="hidden" name="uid" value="<?=$uid?>" />

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