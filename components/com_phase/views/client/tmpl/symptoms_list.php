<form action="index.php?option=com_phase&controller=client&task=ed_symptom&id=<?=$id?>" method="post" name="adminForm" \>

    
<div class='tabContainer2' style="background-color:#E1FFE3">
<div class='contentheading'>
<?php
echo "Add symptom<br>";
?>
</div>
    
    <?='Symptom'?> <input type="text" name="symptom"    value="" />
    <input type="submit" value="add" name="action"/>
    
    
</div>

    <input type="hidden" name="pid" value="<?=$pid?>" />
    <input type="hidden" name="uid" value="<?=$uid?>" />
    <input type="hidden" name="id" value="<?=$id?>" />
    
        
    <?php
    if($t == 1):
    ?>
    <input type="hidden" name="t" value="1" />
    <?php
    endif;
    ?>

    
</form>