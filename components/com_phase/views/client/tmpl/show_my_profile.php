<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<form action="index.php?option=com_phase&controller=client&action=edit_my_info"  method="post" enctype="multipart/form-data">
   
    <input type="hidden" name="id" value="<?=$this->myInfo->id?>" />    
    
    <div class='contentheading'> <?="Name:".$this->myInfo->name?></div>
    
    <div class='contentheading'><span class="user-info">Email: </span><input type="text" name="email" value="<?=$this->myInfo->email?>"/></div>
    
    <div class='contentheading'><span class="user-info">Address: </span><input type="text" name="address" value="<?=$this->myInfo->address?>"/></div>
    
    <div class='contentheading'><span class="user-info">City: </span><input type="text" name="city" value="<?=$this->myInfo->city?>"/></div>
    
    <div class='contentheading'><span class="user-info">State: </span><input type="text" name="state" value="<?=$this->myInfo->state?>"/></div>
    
    <div class='contentheading'><span class="user-info">Zip: </span><input type="text" name="zip" value="<?=$this->myInfo->zip?>"/></div>
    
    <div class='contentheading'><span class="user-info">Phone: </span><input type="text" name="phone" value="<?=$this->myInfo->phone?>"/></div>
    
    <div class='contentheading'><span class="user-info">Birthday: </span><input type="text" name="birthday" value="<?=$this->myInfo->birthday?>"/></div>
    
    <div class='contentheading'><span class="user-info">Sex: </span>
        Male <input name="sex" type="radio" value="1" <?php if($this->myInfo->sex == 1)echo 'checked';?>> 
        Female <input name="sex" type="radio" value="0" <?php if($this->myInfo->sex == 0)echo 'checked';?>>
    </div>
    
    <button class="button validate" type="submit" value="Save">Save information</button>
    
</form>