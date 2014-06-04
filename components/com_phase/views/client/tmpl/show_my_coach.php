<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>

<div class='tabContainer2' style="background-color:#E1FFE3">
<?php

foreach ($this->coachInfo as $coachInfo)
:
?>

    <div class='user-name'>
<?= $coachInfo->name."<br>";?>
    </div>

    <div class='user-data'>
<?= "Phone - ".$coachInfo->phone."<br>";?>
    </div>
    <div class='user-data'>
<?= "Fax - ".$coachInfo->fax."<br>";?>
    </div>
    <div class='user-data'>
<?= "Homepage - ".$coachInfo->homepage."<br>";?>
    </div>
    <div class='user-data'>
<?= "IMG - ".$coachInfo->image."<br>";?>
    </div>
    <div class='user-img'>
    <?php
    if($coachInfo->image):
    echo "  <div style='font-size:15px;color:#008;'>
        <img src=\"".JURI::root().'uploads_jtpl/coaches/'.$coachInfo->image."\" width=\"250\" height=\"250\">
        </div>";
    endif;
    ?> 
    
<?php
endforeach;

?>
        </div>
</div>