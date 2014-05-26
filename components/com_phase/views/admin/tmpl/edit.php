<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php
//echo '<pre>';
//var_dump($this->row);

?>


<form action="index.php?option=com_phase&controller=admin&action=edit_coach" method="post" name="adminForm" \>
    
    <input type="hidden" name="id" value="<?=$this->row->id?>" />
    <?='Name:<br>'?>
    <input type="text" name="name" value="<?=$this->row->name?>" />
    
    <?='<br>Address:<br>'?>
    <input type="text" name="address" value="<?=$this->row->address?>" />
    <?='<br>Phone:<br>'?>
    <input type="text" name="phone" value="<?=$this->row->phone?>" />
    <?='<br>Fax:<br>'?>
    <input type="text" name="fax" value="<?=$this->row->fax?>" />
    <?='<br>Homepage:<br>'?>
    <input type="text" name="homepage" value="<?=$this->row->homepage?>" />
    <?='<br>Image:<br>'?>
    <input type="text" name="image" value="<?=$this->row->image?>" />
    <?='<br>'?>
    <input type="hidden" name="owner" value="<?=$this->row->owner?>" />
    <input type="hidden" name="author" value="<?=$this->row->author?>" />
    <input type="hidden" name="created" value="<?=$this->row->created?>" />
    <input type="hidden" name="modified" value="<?=date('Y-m-d G:i:s')?>" />
    <input type="hidden" name="admin" value="<?=$this->row->admin?>" />
    <input type="hidden" name="published" value="<?=$this->row->published?>" />
    
    
    <?php echo JHTML::_('form.token'); ?>
    
    <input type="submit" value="Save" />
    <input type="submit" value="Cancel" name="cancel" />
    
</form>