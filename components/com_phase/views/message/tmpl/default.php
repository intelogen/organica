<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>


<div class='contentheading'>
<?="My Message<br>"?>
</div>

<a href="index.php?option=com_phase&controller=message&action=create_message">Create message -</a>
<a href="index.php?option=com_phase&controller=message&action=inbox_messages">Inbox messages -</a>
<a href="index.php?option=com_phase&controller=message&action=sent_messages">Sent messages</a>  

<div class='tabContainer2' style="background-color:#E1FFE3">
new message
<?php
echo '<br>';
if($this->newMessage and $this->newMessage > 0)
{
    foreach ($this->newMessage as $value)
    {
        if(empty($value->subject))
        {
        $value->subject = "Read massege";
        }
        echo $this->usersIdName[$value->mfrom];
        echo "<a href='index.php?option=com_phase&controller=message&action=read_messages&id=$value->id'>$value->subject</a>";
        echo $value->created."<br>";
    }
}
else
{
    echo "you don't have any new message now";
}
?>   
</div>
