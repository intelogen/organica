<?php
/**
 * Health Report for Joomla! 1.5
 * @author Alexander Barannikov
 * @copyright 2010 Seanetix Company
 */
// print_r($this->items);
if (count($this->items)<=0) {
    echo "<h1>No persons found</h1>";
} else {
foreach ($this->items as $item) :
?>
<div class="plate">
    <a href="<?=JRoute::_('index.php?option=com_hreport&view=report&uid='.$item->userid);?>"><h1><?php echo ucfirst($item->firstname).($item->lastname ? ", ".ucfirst($item->lastname) : ''); ?></h1></a>
<div class="whiteplate">
    <table>
<tr>
<td><p>
    <img src="<?php echo '/uploads_jtpl/phase_details/'.$item->startphoto; ?>" />
    <img src="<?php echo '/uploads_jtpl/phase_details/'.$item->endphoto; ?>" />
    </p>
</td>
<td>

        <table width="95%" align="center">
            <tr>
                <td align="center" valign="top">
                    <h4>Age:</h4>
                    <?php echo $item->age ? $item->age : 'N/A'; ?>
                </td>
                <td align="center">
                    <h4>Weight:</h4>
                    Start: <?=$item->startweight;?> lbs.<br />
                    Last: <?=$item->lastweight;?> lbs.
                </td>
                <td align="center">
                    <h4>Fat:</h4>
                    Start: <?=$item->startfat;?>%.<br />
                    Last: <?=$item->lastfat;?>%.
                </td>
                <td align="center">
                    <h4>PH Score:</h4>
                    Start: <?=$item->startph;?>.<br />
                    Last: <?=$item->lastph;?>.
                </td>
            </tr>
        </table>
        <center>
            <h4>Eliminated:</h4>
        </center>
        <table width="95%" align="center">
            <tr>
                <td align="center"><?=$item->diseaseseliminated;?> diseases eliminated.</td>
                <td align="center"><?=$item->medicationseliminated;?> medications eliminated.</td>
            </tr>
        </table>
        <div class="hreport_righttext">
            <a href="<?=JRoute::_('index.php?option=com_hreport&view=report&uid='.$item->userid);?>">More details...</a>
        </div>

</td>
</tr>
</table>
    </div>
</div>
<?php
endforeach;
}
?>