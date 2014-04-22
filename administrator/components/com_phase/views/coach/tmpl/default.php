<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<form action="index.php" method="post" name="adminForm">
   
    

    <?php
    if($this->content)
    {
    foreach ($this->content as $key => $value)
    :
    ?>
    <input type="radio" name="answer" value="<?= $value->id;?> "><?= $value->name;?>
    
    <?php
    echo '<br>';
    endforeach;
    }
    ?>
    
    <?php echo JHTML::_('form.token'); ?>
    <input type="hidden" name="option" value="com_phase" />
    <input type="hidden" name="controller" value="coach" />
    <input type="hidden" name="task" value="" />
    
    
</form>












