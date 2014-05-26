<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>

<?php
//echo '<pre>';
//var_dump($this->coachInfo);
?>
<div class='tabContainer2' style="background-color:#E1FFE3">

<?php

foreach ($this->coachInfo as $coachInfo)
:
?>
            <div class='contentheading'>
<?= $coachInfo->name."<br>";?>
            </div>
<?= "Phone - ".$coachInfo->phone."<br>";?>
<?= "Fax - ".$coachInfo->fax."<br>";?>
<?= "Homepage - ".$coachInfo->homepage."<br>";?>
<?= "IMG - ".$coachInfo->image."<br>";?>

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