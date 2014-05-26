<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();?>


<div class='contentheading'>
<?="My Message<br>"?>
</div>

<a href="index.php?option=com_phase&controller=message&action=create_message">Create message -</a>
<a href="index.php?option=com_phase&controller=message&action=inbox_messages">Inbox messages -</a>
<a href="index.php?option=com_phase&controller=message&action=sent_messages">Sent messages</a>  



<div class='contentheading'>
<?="New Message<br>"?>
</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    
 <form action="index.php?option=com_phase&controller=message&action=send_message"  method="post">

    <?php
    if($this->clientInfo)
    :
    echo 'Select the client';    
    ?>
        <select name="mto">
        <?php
        foreach ($this->clientInfo as $value)
            :
        ?>
            <option value="<?=$value->uid?>"><?=$value->firstname." ".$value->lastname?> </option>
        <?php
        endforeach;
        ?>
        </select>
    <?php
    endif;
    ?>
    


    <?='<br>Subject:'?>
    <input type="text" name="subject" size=73 />
    <?='<br>Body:'?>
    <?php echo $editor->display('body', " <br>From : ".$this->sendUserInfo, '90%', '300', '60', '20');   ?>
    <?="<br>"?>
    
    
    
    <input type="hidden" name="mfrom" value="<?=$this->userId?>" />
    <?php
    if($this->mto)
    :
    ?>
    <input type="hidden" name="mto" value="<?=$this->mto?>" />    
    <?php
    endif;
    ?>
    
    <?php echo JHTML::_('form.token'); ?>
    
    
    <button class="button validate" type="submit" value="send"><?= "Send Message" ?></button>
    
</form>   
    
    
</div>
