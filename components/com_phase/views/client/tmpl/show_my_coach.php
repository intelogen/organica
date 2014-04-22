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
<?= $coachInfo->address."<br>";?>
<?= $coachInfo->phone."<br>";?>
<?= $coachInfo->fax."<br>";?>
<?= $coachInfo->homepage."<br>";?>
<?= $coachInfo->image."<br>";?>

<?php
endforeach;

?>
</div>