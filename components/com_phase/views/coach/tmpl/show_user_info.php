<?php
defined( '_JEXEC' ) or die( 'Restricted access' ); 
$editor = & JFactory::getEditor();
?>

<div class='tabContainer2' style="background-color:#E1FFE3">
    <div class='contentheading'>  <?="Client information:"?> </div>

    <?php
    if($this->clientInfo)
        {
        foreach ($this->clientInfo as $value)
            :
        ?>
            <div class='user-info-conteiner'>
            <div class="user-name">
            <?="name: ".$value->name?>
            </div>
            <div class="user-data">
            <?="email: ".$value->email?>
            </div>
            <div class="user-data">
            <?="address: ".$value->address?>
            </div>
            <div class="user-data">
            <?="city: ".$value->city?>
            </div>
            <div class="user-data">
            <?="state: ".$value->state?>
            </div>
            <div class="user-data">
            <?="zip: ".$value->zip?>   
            </div>
            <div class="user-data">
            <?="phone: ".$value->phone?>
            </div>
            <div class="user-data">
            <?="birthday: ".$value->birthday?>
            </div>
            <div class="user-data">
            <?="sex: ".$value->sex?>   
            </div>
            </div>
            
    
                <div class='objectTitle'>
                    <a href="index.php?option=com_phase&controller=coach&action=show_user_phases&userId=<?=$value->id?>">Client Phases and tasks</a>
                </div>
                <div class='objectTitle'>
                    <a href="index.php?option=com_phase&controller=coach&action=edit_client_info&c=<?=$value->id?>">Edit intake data(not working - in progress)</a>
                </div>
                <div class='objectTitle'>
                    <a href="index.php?option=com_phase&controller=client&action=show_repo&c=<?=$value->id?>">User Progress</a>
                </div>
                
    

        <?php
        endforeach;
        }
    ?>
</div>





