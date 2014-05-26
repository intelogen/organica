<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<div class='contentheading'>
<a href="index.php?option=com_phase&controller=admin&action=new_coach">Create new coach</a>
<?='<br>'?>
</div>

<?php
//var_dump($this->allCoaches);
echo '<br>List of the coaches:<br><br>';
?>
<div class='tabContainer2' style="background-color:#E1FFE3">
<form action="index.php?option=com_phase&controller=admin" method="post" name="adminForm" \>
    <?php
    if($this->allCoaches)
    {
    foreach ($this->allCoaches as $value)
    :
    ?>
    <div class='contentheading'>
    <input type="radio" name="userId" value="<?= $value->id;?> "><?= $value->name;?>
    </div>
    <?php
    echo '<br>';
    endforeach;
    }
    ?>
    
    <?php echo JHTML::_('form.token'); ?>
    
    <input type="submit" value="Delete" name="action"/>
    <input type="submit" value="Edit" name="action"/>
    
</form>
</div>




