<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>




    
    
    
    
<?php
    //echo '<pre>';
    //var_dump($this->allCoaches);
    ?>

<form action="index.php?option=com_phase&controller=admin" method="post" name="adminForm" \>
    
    Users list:
    <?php
    //echo '<pre>';
    //var_dump($this->allUsers);
    ?>
    
    <select name="userId">
    <?php
    if($this->allUsers)
    {
    foreach ($this->allUsers as $value)
    :
    ?>
    <option value="<?= $value->id;?>"><?= $value->firstname;?><?=" ".$value->lastname;?></option>
    
    <?php
    echo '<br>';
    endforeach;
    }
    ?>
    </select>
    
    Coach list:  
    <select name="coachId">
      
    <?php
    if($this->allCoaches)
    {
    foreach ($this->allCoaches as $value)
    :
    ?>
    <option value="<?= $value->id;?>"><?= $value->name;?></option>
    
    <?php
    echo '<br>';
    endforeach;
    }
    ?>
    </select>






    <?php echo JHTML::_('form.token'); ?>
    <p>
    <input type="submit" value="Assign" name="action"/>
    </p>
    
</form>