<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>


<?php
$pid = JRequest::getVar('pid');
$uid = JRequest::getVar('uid');
?>


<form action="index.php?option=com_phase&controller=client&step=3&end=1&pid=<?=$pid?>&uid=<?=$uid?>"  method="post" enctype="multipart/form-data">
  
    
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
    

<p>
    <input type="submit" id="test" value="save" name="action"/>
</p>


</form>