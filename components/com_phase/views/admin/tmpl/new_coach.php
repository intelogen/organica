<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php
//echo '<pre>';
//var_dump($this->userList);
echo '<br>Choose new coach from the list:<br><br>';
?>

<form action="index.php?option=com_phase&controller=admin&action=add_coach" method="post" name="adminForm" \>
    <select name="userId">
        <option disabled>click the user</option>
        <?php
        foreach ($this->userList as $value):
        ?>
            <option value="<?=$value->id;?>"><?=$value->name?></option>
        <?php
        endforeach;
        ?>
    </select>
    <?php echo JHTML::_('form.token'); ?>
    <input type="submit" value="Create" />
</form>