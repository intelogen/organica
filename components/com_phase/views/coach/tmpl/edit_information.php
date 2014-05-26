<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>



<form action="index.php?option=com_phase&controller=coach&action=edit_coach"  method="post" enctype="multipart/form-data">
   
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
    
    <?php
    if($this->row->image):
    echo "  <div style='font-size:15px;color:#008;'>
        <img src=\"".JURI::root().'uploads_jtpl/coaches/'.$this->row->image."\" width=\"250\" height=\"250\">
        </div>";
    endif;
    ?> 
        
        
    <?='<br>'?>
    <input type='file' name='filename' />
    
    <?='<br>'?>
    
    <?='<br>'?>
    
    
    <input type="hidden" name="owner" value="<?=$this->row->owner?>" />
    <input type="hidden" name="author" value="<?=$this->row->author?>" />
    <input type="hidden" name="created" value="<?=$this->row->created?>" />
    <input type="hidden" name="modified" value="<?=date('Y-m-d G:i:s')?>" />
    <input type="hidden" name="admin" value="<?=$this->row->admin?>" />
    <input type="hidden" name="published" value="<?=$this->row->published?>" />
    
    
    <?php echo JHTML::_('form.token'); ?>
    
    
    
    
    <button class="button validate" type="submit" value="Save"><?= "Save information" ?></button>
    <button class="button validate" type="submit" value="Cancel"><?= "Cancel" ?></button>
    
    
    
    
    
    
    
    
    
    
</form>





