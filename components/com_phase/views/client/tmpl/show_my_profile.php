<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>




<form action="index.php?option=com_phase&controller=client&action=edit_my_info"  method="post" enctype="multipart/form-data">
   
    <div class='user-name'>
    <input type="hidden" name="id" value="<?=$this->myInfo->id?>" />
    <?="Username : ".$this->myInfo->username?>
    </div>
    <div class='user-data'>
    <?='Name:'?>
    <input type="text" name="name" value="<?=$this->myInfo->name?>" />
    </div>
    
    <div class='user-data'>
    <?='Email:'?>
    <input type="text" name="email" value="<?=$this->myInfo->email?>" />
    </div>
    
    <div class='user-data'>
    <?='address:'?>
    <input type="text" name="address" value="<?=$this->myInfo->address?>" />
    </div>
    
    <div class='user-data'>
    <?='city:'?>
    <input type="text" name="city" value="<?=$this->myInfo->city?>" />
    </div>
    
    <div class='user-data'>
    <?='state:'?>
    <input type="text" name="state" value="<?=$this->myInfo->state?>" />
    </div>
    
    <div class='user-data'>
    <?='zip:'?>
    <input type="text" name="zip" value="<?=$this->myInfo->zip?>" />
    </div>
    
    <div class='user-data'>
    <?='phone:'?>
    <input type="text" name="phone" value="<?=$this->myInfo->phone?>" />
    </div>
    
    <div class='user-data'>
    <?='birthday:'?>
    <input type="text" name="birthday" value="<?=$this->myInfo->birthday?>" />
    </div>
    
    <div class='user-data'>
    male<input name="sex" type="radio" value="1" <?php if($this->myInfo->sex == 1)echo 'checked';?>> 
    female<input name="sex" type="radio" value="0" <?php if($this->myInfo->sex == 0)echo 'checked';?>>
    </div>
    
    <?php echo JHTML::_('form.token'); ?>
    
    <button class="button validate" type="submit" value="Save"><?= "Save information" ?></button>
    
</form>





