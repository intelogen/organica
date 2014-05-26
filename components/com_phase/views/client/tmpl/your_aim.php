<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>


<?php
//echo '<pre>';
//var_dump($this->aim);
?>


<form action="index.php?option=com_phase&controller=client&step=1&first=1" method="post" name="adminForm" \>

    
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "Ваша цель<br>";
?>
</div>
    
<?php
foreach ($this->aim as $value) 
: 
?>

    <input type="checkbox" name="<?="id".$value->id?>" value="<?=$value->id?>"><?=$value->question?><br>
    
    
    
    
<?php
endforeach;
?>
</div>


<p>
    <input type="submit" value="save" name="action"/>
</p>
</form>


<?='<br><br>'?>
    
<?='<br>'?>