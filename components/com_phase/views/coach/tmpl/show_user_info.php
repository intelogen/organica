<?php
defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();
?>

<div class='tabContainer2' style="background-color:#E1FFE3">
    <div class='contentheading'>  <?="Client information:<br>"?> </div>

    <?php
    if($this->clientInfo)
        {
        foreach ($this->clientInfo as $value)
            :
        ?>
            <?="name: ".$value->name."<br>"?>
            <?="email: ".$value->email."<br>"?>
            <?="address: ".$value->address."<br>"?>
            <?="city: ".$value->city."<br>"?>
            <?="state: ".$value->state."<br>"?>
            <?="zip: ".$value->zip."<br>"?>   
            <?="phone: ".$value->phone."<br>"?>
            <?="birthday: ".$value->birthday."<br>"?>
            <?="sex: ".$value->sex."<br>"?>   

            <div class='objectTitle'>
                <p>
                <a href="index.php?option=com_phase&controller=client&action=show_repo&c=<?=$value->id?>">User Progress</a>
                </p>
                <p>
                <a href="index.php?option=com_phase&controller=coach&action=show_detail_repo&c=<?=$value->id?>">Detail Progress</a>
                </p>
                <p>
                <a href="index.php?option=com_phase&controller=coach&action=show_user_phases&userId=<?=$value->id?>">Client Phases & tasks</a>
                </p>
            </div>    

        <?php
        endforeach;
        }
    ?>
</div>





