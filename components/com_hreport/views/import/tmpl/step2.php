<?php
/**
 * Health Report for Joomla! 1.5
 * @author Alexander Barannikov
 * @copyright 2010 Seanetix Company
 */

defined('_JEXEC') or die('Access denied.');
?>
<div class="tabs">
    <ul id="tabMenu">
        <li id='tab-10'><a href="javascript: togglephase(10);">10</a></li>
        <li id='tab-9'><a href="javascript: togglephase(9);">9</a></li>
        <li id='tab-8'><a href="javascript: togglephase(8);">8</a></li>
        <li id='tab-7'><a href="javascript: togglephase(7);">7</a></li>
        <li id='tab-6'><a href="javascript: togglephase(6);">6</a></li>
        <li id='tab-5'><a href="javascript: togglephase(5);">5</a></li>
        <li id='tab-4'><a href="javascript: togglephase(4);">4</a></li>
        <li id='tab-3'><a href="javascript: togglephase(3);">3</a></li>
        <li id='tab-2'><a href="javascript: togglephase(2);">2</a></li>
        <li id='tab-1'><a href="javascript: togglephase(1);">1</a></li>
    </ul>
</div>
<form action="index.php" method="post" enctype="multipart/form-data">
<?php
for ($zzi=1;$zzi<=10;$zzi++) {
    $phase = $this->phases[$zzi];
?>
<div class="tabContainer" id="phase<?=$zzi;?>" style="display:<?=$zzi==1?'block':'none';?>">
    phase #<?=$zzi;?>
    <h4>Update Your photo:</h4>
    Start photo:
    <input type="file" name="phase[<?=$zzi;?>][startphoto]" /><br />
    End photo:
    <input type="file" name="phase[<?=$zzi;?>][endphoto]" />
    <h4>Start survey</h4>
    Weight:
    <input type="text" name="phase[<?=$zzi;?>][st_weight]" /> lbs.<br />
    Fat:
    <input type="text" name="phase[<?=$zzi;?>][st_fat]" />%<br />
    PH Score:
    <input type="text" name="phase[<?=$zzi;?>][st_phscore]" /><br />
    <br />
    <?php
    foreach ($phase->start_q as $q) {
        echo $q->q."<input type='radio' name='phase[$zzi][st_question][$q->v]' value='Y'>Yes <input type='radio' name='phase[$zzi][st_question][$q->v]' value='N'>No<br />";
    }
    ?>
    
    <h4>Evaluation</h4>
    Weight:
    <input type="text" name="phase[<?=$zzi;?>][ed_weight]" /> lbs.<br />
    Fat:
    <input type="text" name="phase[<?=$zzi;?>][ed_fat]" />%<br />
    PH Score:
    <input type="text" name="phase[<?=$zzi;?>][ed_phscore]" /><br />
    <br />
    <?php
    foreach ($phase->end_q as $q) {
        echo $q->q."<input type='radio' name='phase[$zzi][ed_question][$q->v]' value='Y'>Yes <input type='radio' name='phase[$zzi][ed_question][$q->v]' value='N'>No<br />";
    }
    ?>
    <h5>BodyScore:</h5>
    <?php
    foreach ($this->bodyscore as $bs) {
        echo '<input type="checkbox" name="phase['.$zzi.'][ed_bodyscore][]" value="'.$bs->id.'" /> '.$bs->question.'<br />';
    }
    ?>
    <h5>Tracking (medtrack):</h5>
    <?php
    if (count($this->medtrack)>0)
    foreach ($this->medtrack as $item) {
        echo $item->q.' <select name="phase['.$zzi.'][medtrack]['.$item->v.']"><option value="same">Same</option><option value="better">Better</option><option value="eliminated">Eliminated</option><option value="new">New</option></select>';
    }
    ?>
    <h5>Tracking (symptoms):</h5>
    <?php
    if (count($this->symptoms)>0)
    foreach ($this->symptoms as $item) {
        echo $item->q.' <select name="phase['.$zzi.'][symptoms]['.$item->v.']"><option value="same">Same</option><option value="better">Better</option><option value="eliminated">Eliminated</option><option value="new">New</option></select>';
    }
    ?>
    <h5>Tracking (diseases):</h5>
    <?php
    if (count($this->diseases)>0)
    foreach ($this->diseases as $item) {
        echo $item->q.' <select name="phase['.$zzi.'][diseases]['.$item->v.']"><option value="same">Same</option><option value="better">Better</option><option value="eliminated">Eliminated</option><option value="new">New</option></select>';
    }
    ?>
    <input type="hidden" name="phase[<?=$zzi;?>][id]" value="<?=$this->projects[$zzi-1];?>" />
</div>

<?php
}
?>
<input type="hidden" name="option" value="com_hreport" />
<input type="hidden" name="c" value="import" />
<input type="hidden" name="task" value="nextstep" />
<input type="submit" />
</form>
