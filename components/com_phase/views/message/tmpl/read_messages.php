<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();?>



<div class='contentheading'>
<?="My Message<br>"?>
</div>

<div class='message-menu-conteiner'>
<div class='message-menu'>
<a href="index.php?option=com_phase&controller=message&action=create_message">Create message</a>
</div>
<div class='message-menu'>
<a href="index.php?option=com_phase&controller=message&action=inbox_messages">Inbox messages</a>
</div>
<div class='message-menu'>
<a href="index.php?option=com_phase&controller=message&action=sent_messages">Sent messages</a>  
</div>
</div>




<div class='contentheading'>
<?="My Message<br>"?>
</div>


    
<div class='message-conteiner'>
<?php
if($this->result and $this->result > 0)
{
    if(empty($this->result->subject))
    {
    ?>    
    <div class='message-subject'>
        <?= "Subject: no subject" ?>
    </div>
    <?php    
    }
    else
    {
    ?>    
    <div class='message-subject'>
        <?= "Subject: ".$this->result->subject ?>
    </div>
    <?php
    }
?>
    <div class='message-date'>
    <?= "Created: ".$this->result->created ?>
    </div>
    <div class='message-body'>
    <?= "Body: ".$this->result->body ?>
    </div>
<?php
}
?> 
</div>



<?php
if(!JRequest::getVar('sent'))
:
?>

<div class='contentheading'>
<?="Quick answer<br>"?>
</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    
 <form action="index.php?option=com_phase&controller=message&action=send_message"  method="post" enctype="multipart/form-data">

         
    <?='<br>Subject:'?>
    <input type="text" name="subject" size=73 value="<?="[Answer]-".$this->result->subject?>"/>
    <?php echo $editor->display('body', "<br><br><br>Original msg:".$this->result->body." <br>From : ".$this->sendUserInfo, '90%', '300', '60', '20');   ?>
    <?="<br>"?>
    
    
    <input type="hidden" name="mto" value="<?=$this->result->mfrom?>" />
    <input type="hidden" name="mfrom" value="<?=$this->result->mto?>" />
    
    
    
    <?php echo JHTML::_('form.token'); ?>
    
    
    <button class="button validate" type="submit" value="send"><?= "Send Message" ?></button>
    
    
    
</form>   
    
    
</div>
<?php
endif;
?>