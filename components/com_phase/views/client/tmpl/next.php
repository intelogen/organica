<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>


<?php
//echo '<pre>';
//var_dump($this->symptoms);

if($this->symptoms)
{
?>
<form action="index.php?option=com_phase&controller=client&step=2&start=1" method="post" name="adminForm" \>
    
    
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "Symptoms Tracking<br>";
?>
</div>
    
<?php
foreach ($this->symptoms as $value) 
: 
?>

    <input type="checkbox" name="<?="qid=".$value->id?>" value="<?=$value->id?>"><?=$value->question?><br>

<?php
endforeach;
?>
</div>

<?php echo JHTML::_('form.token'); ?>
<p>
<input type="submit" value="next" name="action"/>
</p>
    
</form>
<?php
}
?>







<?php
//echo '<pre>';
//var_dump($this->medic);

if($this->medic)
{
?>
<form action="index.php?option=com_phase&controller=client&step=3&start=1" method="post" name="adminForm" \>
    
    
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "Medical Tracking<br>";
?>
</div>
    
<?php
foreach ($this->medic as $value) 
: 
?>

    <input type="checkbox" name="<?="qid=".$value->id?>" value="<?=$value->id?>"><?=$value->question?><br>

<?php
endforeach;
?>
</div>

<?php echo JHTML::_('form.token'); ?>
<p>
<input type="submit" value="next" name="action"/>
</p>
    
</form>
<?php
}
?>
