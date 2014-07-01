<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>

<div class='tabContainer2' style="background-color:#E1FFE3">
<?php

echo "<pre>";
var_dump($this->coachInfo);
echo "</pre>";

foreach ($this->coachInfo as $coachInfo)
:
?>
    <div class='user-info-holder'>

    <div class='user-name'>
<?= $coachInfo->name."<br>";?>
    </div>

    <div class='user-data'>
<?= "<span class='response-name'>Phone - </span>"."<span class='response-data'>".$coachInfo->phone."</span>";?>
    </div>
    <div class='user-data'>
<?= "<span class='response-name'>Fax - </span>"."<span class='response-data'>".$coachInfo->fax."</span>";?>
    </div>
    <div class='user-data'>
<?= "<span class='response-name'>Homepage - </span>"."<span class='response-data'>"."<a href='$coachInfo->homepage'>".$coachInfo->homepage."</a></span>";?>
    </div>
    <div class='user-data'>
<?= "<span class='response-name'>IMG - </span>"."<span class='response-data'>".$coachInfo->image."</span>";?>
    </div>
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