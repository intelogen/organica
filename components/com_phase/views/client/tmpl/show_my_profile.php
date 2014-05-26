<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>


<?php
//echo '<pre>';
//var_dump($this->myInfo);

?>




<form action="index.php?option=com_phase&controller=client&action=edit_my_info"  method="post" enctype="multipart/form-data">
   
    
    
    
    <input type="hidden" name="id" value="<?=$this->myInfo->id?>" />
    <?="<br>Username : ".$this->myInfo->username?>
    
    <?='<br>Name:'?>
    <input type="text" name="name" value="<?=$this->myInfo->name?>" />
    
    <?='<br>Email:'?>
    <input type="text" name="email" value="<?=$this->myInfo->email?>" />
    
    <?='<br>address:'?>
    <input type="text" name="address" value="<?=$this->myInfo->address?>" />
    
    <?='<br>city:'?>
    <input type="text" name="city" value="<?=$this->myInfo->city?>" />
    
    <?='<br>state:'?>
    <input type="text" name="state" value="<?=$this->myInfo->state?>" />
    
    <?='<br>zip:'?>
    <input type="text" name="zip" value="<?=$this->myInfo->zip?>" />
    
    <?='<br>phone:'?>
    <input type="text" name="phone" value="<?=$this->myInfo->phone?>" />
    
    <?='<br>birthday:'?>
    <input type="text" name="birthday" value="<?=$this->myInfo->birthday?>" />
    
    
    
    <?='<br>'?>
    male<input name="sex" type="radio" value="1" <?php if($this->myInfo->sex == 1)echo 'checked';?>> 
    female<input name="sex" type="radio" value="0" <?php if($this->myInfo->sex == 0)echo 'checked';?>>
    
    
    <?='<br><br>'?>
    
    
    
    <?php echo JHTML::_('form.token'); ?>
    
    
    
    
    <button class="button validate" type="submit" value="Save"><?= "Save information" ?></button>
    
    
    
    
    
    
    
    
    
    
</form>





