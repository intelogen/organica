<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>


<div class='contentheading'>
My Message
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


<div class='message-conteiner'>
<?php
if($this->sent and $this->sent > 0)
{
    foreach ($this->sent as $value)
    {
        if(empty($value->subject))
        {
        $value->subject = "Read massege";
        }
    ?>    
        <div class='message-user'>
        <?= $this->usersIdName[$value->mto] ?>
        </div>
        <div class='message-subject'>
        <?= "<a href='index.php?option=com_phase&controller=message&action=read_messages&id=$value->id&sent=1'>$value->subject</a>" ?>
        </div>
        <div class='message-date'>
        <?= $value->created ?>
        </div>
    <?php    
    }
}
else
{
?>
    <div class='message-title'>
    <?= "you don't have any sent message now" ?>
    </div>
<?php
}
?>   
</div>