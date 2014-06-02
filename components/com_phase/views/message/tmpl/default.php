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
<div class='message-title'>
    new message
</div>
<?php
if($this->newMessage and $this->newMessage > 0)
{
    foreach ($this->newMessage as $value)
    {
        if(empty($value->subject))
        {
        $value->subject = "Read massege";
        }
        ?>
        <div class='message-user'>
        <?=$this->usersIdName[$value->mfrom]?>
        </div>
        <div class='message-subject'>
        <?= "<a href='index.php?option=com_phase&controller=message&action=read_messages&id=$value->id'>$value->subject</a>";?>
        </div>
        <div class='message-date'>
        <?= $value->created ?>
        </div>
<?php
    }
}
else
{
    echo "you don't have any new message now";
}
?> 
</div>
</div>
