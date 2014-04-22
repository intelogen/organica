<?php
/**
 * Health Report for Joomla! 1.5
 * @author Alexander Barannikov
 * @copyright 2010 Seanetix Company
 */

defined('_JEXEC') or die('Access denied.');

?>
<h1>Search testimonials:</h1>
<form id="searchform" action="index.php?option=com_hreport&c=search&task=results" method="post">
<table class="hreport_search_table">
    <tr>
        <td id="hreport_sex">
            Sex:
            <select name="sex">
                <option value="1">Male</option>
                <option value="0">Female</option>
                <option value="-1">All</option>
            </select>
        </td>
        <td id="hreport_physics">
            Physical:
            <?php echo $this->look_for; ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Diseases:<br>
            <ul id="dis_list">
            </ul>
            <input type="text" id="hreport_disease" value="" />
            <input type="button" id="dis_add" value="Add" />
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Symptoms:<br>
            <ul id="sym_list">
            </ul>
            <input type="text" id="hreport_symptom" value="" />
            <input type="button" id="sym_add" value="Add" />
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Medtrack:<br>
            <ul id="med_list">
            </ul>
            <input type="text" id="hreport_medtrack" value="" />
            <input type="button" id="med_add" value="Add" />
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="submit" value="Search" />
        </td>
    </tr>
</table>
</form>
