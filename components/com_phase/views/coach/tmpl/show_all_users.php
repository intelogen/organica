<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>


<div class='tabContainer2' style="background-color:#E1FFE3">
<?php
    if($this->clients)
    {
   foreach ($this->clients as $value)
    :
    ?>
        <div class='contentheading'>
<a href="index.php?option=com_phase&controller=coach&action=show_user_info&userId=<?=$value->uid?>"><?=$value->firstname?><?=" ".$value->lastname?></a>
        </div>
    <?php
    echo '<br>';
    endforeach;
    }
?>

    </div>