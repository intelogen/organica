<?php
/**
 * Health Report for Joomla! 1.5
 * @author Alexander Barannikov
 * @copyright 2010 Seanetix Company
 */

defined('_JEXEC') or die('Access denied.');
?>
<h1>Import new person information</h1>
<form action="index.php" method="post" id="searchform">
    <h4>What are you looking for?</h4>
        <ul id="lf_list">
        </ul>
        <input type="text" id="hreport_lookfor" value="" />
        <input type="button" id="lf_add" value="Add" />
    <h4>Medtrack Instructions</h4>
        <ul id="med_list">
        </ul>
        <input type="text" id="hreport_medtrack" value="" />
        <input type="button" id="med_add" value="Add" />
    <h4>Symptom Tracking</h4>
        <ul id="sym_list">
        </ul>
        <input type="text" id="hreport_symptom" value="" />
        <input type="button" id="sym_add" value="Add" />
    <h4>Diseases Tracking</h4>
        <ul id="dis_list">
        </ul>
        <input type="text" id="hreport_disease" value="" />
        <input type="button" id="dis_add" value="Add" />
    <h4>Body score survey</h4>
        <?php
        foreach ($this->bodyscore as $item) {
            echo '<input type="checkbox" name="bodyscore[]" value="'.$item->id.'" /> '.$item->question.'<br />';
        }
        ?>
    <input type="hidden" name="option" value="com_hreport" />
    <input type="hidden" name="c" value="import" />
    <input type="hidden" name="task" value="step" />
<input type="submit" />
</form>