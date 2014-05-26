<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php


if($this->phaseData)
{
    //echo '<pre>';
    //var_dump($this->phaseData);
    $editor = & JFactory::getEditor();
?>    
<form action="index.php?option=com_phase&controller=coach&action=edit_phase" method="post" name="adminForm" \>
    
    <input type="hidden" name="id" value="<?=$this->phaseData->id?>" />
    
        <?='Name:<br>'?>
    <input type="text" size="83%" name="name" value="<?=$this->phaseData->name?>" />
    
    <?='<br><br>'?>
    Published:
    <input type="radio" name="published" value="1" <?php if($this->phaseData->published == 1):?> checked <?php endif; ?>><?="Yes";?>
    <input type="radio" name="published" value="0" <?php if($this->phaseData->published == 0):?> checked <?php endif; ?>><?="No";?>
    <?='<br>'?>
    
    <?='<br>Description:<br>'?>
    <?php echo $editor->display('description', $this->phaseData->description, '90%', '300', '60', '20');   ?>
    
    
    
    
    <input type="hidden" name="userId" value="<?=$this->phaseData->leader?>"/>
    
    <?php echo JHTML::_('form.token'); ?>
    <?="<br>"?>
    <input type="submit" value="Save" />
    <input type="submit" value="Cancel" name="cancel" />
    
</form>
<?php    
}
?>

<?php
//echo '<pre>';
//var_dump($this->taskContent);
?>
<?php


if($this->taskContent)
{
    $editor = & JFactory::getEditor();
?>    
<form action="index.php?option=com_phase&controller=coach&action=edit_task" method="post" name="adminForm" \>
    
    <input type="hidden" name="id" value="<?=$this->taskContent->id?>" />
    
        <?='Name:<br>'?>
    <input type="text" size="83%" name="name" value="<?=$this->taskContent->summary?>" />
    
        <?='<br>Description:<br>'?>
    <?php echo $editor->display('description', $this->taskContent->description, '90%', '300', '60', '20');   ?>
    

    
    <?php echo JHTML::_('form.token'); ?>
    <?="<br>"?>
    <input type="submit" value="Save" />
    <input type="submit" value="Cancel" name="cancel" />
    
</form>
<?php    
}
?>
