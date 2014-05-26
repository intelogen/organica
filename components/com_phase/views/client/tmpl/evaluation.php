<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php
//echo '<pre>';
//var_dump($this->questions);
?>



<form action="index.php?option=com_phase&controller=client&questions=1&start=1" method="post" name="adminForm" \>
<div class='tabContainer2' style="background-color:#E1FFE3">

    
<div class='contentheading'>
<?php
echo "Retake Body Score Survey<br>";
?>
</div>
    
<?php
foreach ($this->questions as $value) 
: 
?>

    <input type="checkbox" name="<?="id=".$value->id?>" value="<?=$value->id?>"><?=$value->question?><br>

<?php
endforeach;
?>
</div>

<div class='tabContainer2' style="background-color:#E1FFE3">  
<div class='contentheading'><?php echo "Retake Intake Survey";?></div>
Weight: <input type="text" name="weight" value=""/>lbs<br>
Body Fat: <input type="text" name="body_fat" value=""/>%<br>
PH Score: <input type="text" name="ph_score" value=""/>
<div class='contentheading'><?php echo "Submission Date";?></div>

</div>

<div class='tabContainer2' style="background-color:#E1FFE3">    
<div class='contentheading'>
<?php echo "Current Photo";?>
</div>
</div>







<?php echo JHTML::_('form.token'); ?>
<p>
<input type="submit" value="next" name="action"/>
</p>
</form>
