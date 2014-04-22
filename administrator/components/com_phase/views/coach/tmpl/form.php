<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

Форма добавления нового тренера


<form action="index.php" method="post" name="adminForm">
    
    <p>
        <select name="userId">
    <option disabled>click the user</option>
    <?php
    foreach ($this->coach as $value):
    ?>
    <option value="<?=$value->id;?>"><?=$value->name;?></option>
    <?php
    endforeach;
    ?>
        </select>
    </p>
    
    
    <?php echo JHTML::_('form.token'); ?>
    
    
    <input type="hidden" name="option" value="com_phase" />
    <input type="hidden" name="action" value="addcoach" />
    <input type="hidden" name="controller" value="coach" />
    <input type="hidden" name="task" value="" />
    
    
</form>

