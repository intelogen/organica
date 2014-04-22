<?php
/**
 * Health Report for Joomla! 1.5
 * @author Alexander Barannikov
 * @copyright 2010 Seanetix Company
 */
?>
<h1>Person details:</h1>
<div class="photos">
    <img class="bordered" src="/uploads_jtpl/phase_details/<?=$this->person->startphoto;?>" width="200" height="250" />
    <img class="bordered" src="/uploads_jtpl/phase_details/<?=$this->person->endphoto;?>" width="200" height="250" />
</div>
<div class="bio">
    <table style="width: 272px;">
        <tr>
            <td>Name:</td>
            <td><?=$this->person->firstname;?></td>
        </tr>
        <tr>
            <td>Last name:</td>
            <td><?=$this->person->lastname;?></td>
        </tr>
        <tr>
            <td>Gender:</td>
            <td><?=$this->person->gender;?></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td>Weight loss:</td>
            <td><?=$this->person->wl;?> lbs.</td>
        </tr>
        <tr>
            <td>Fat loss:</td>
            <td><?=$this->person->fl;?>%</td>
        </tr>
        <tr>
            <td>Age:</td>
            <td><?php echo $this->person->age ? $this->person->age : 'N/A';?></td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                <h4>Eliminated:</h4>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table width="95%" align="center">
                    <tr>
                        <td align="center"><?php echo $this->person->diseaseseliminated; ?> diseases<br />eliminated.</td>
                        <td align="center"><?php echo $this->person->medicationseliminated; ?> medications<br />eliminated.</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<div style="clear: both;"></div>
<div>
<p class="sr_message">
You're looking for <?php echo $this->person->reg->lf_text ?>. <?php echo $this->person->reg->sym_text ?>.
    You mentioned you are taking <?php echo $this->person->reg->med_text ?>. <?php echo $this->person->reg->dis_text ?>.
</p>
</div>
<h4>Phases details:</h4>
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
<?php
for ($zzi=1;$zzi<=10;$zzi++) {
    $phase = $this->phase[$zzi];
?>
<div class="tabContainer" id="phase<?=$zzi;?>" style="display:<?=$zzi==1?'block':'none';?>">
    <h4>Phase <?=$zzi;?><span style="float: right"><?php echo isset($phase->submission) ? $phase->submission : ''; ?></span></h4>
    <div style="overflow: hidden">
        <img class="bordered" style="float: left;" src="/uploads_jtpl/phase_details/<?=$phase->photo ? $phase->photo : 'picture_not_found.jpg';?>" width="200" height="250" />
        <div class="improvements" style="float: left; width: 440px; padding-left: 20px; color: #008000; font-size: 16px;">
            <?php if(!empty($phase->bodyscore->improvements)) {
            echo implode('<br />', $phase->bodyscore->improvements);
            } else { ?>
            No improvements were made yet.
            <?php } ?>
            <?php if(!empty($phase->eliminated->diseases)) { ?>
            <h4 style="font-size: 14px;">Eliminated diseases:</h4>
            <?php echo implode(', ', $phase->eliminated->diseases);?>
            <?php } ?>

            <?php if(!empty($phase->eliminated->medications)) { ?>
            <h4 style="font-size: 14px;">Eliminated medications:</h4>
            <?php echo implode(', ', $phase->eliminated->medications);?>
            <?php } ?>
        </div>
    </div>
    <h4>Body Score Survey Retake</h4>
    <?php
    if($phase->bodyscore->chart) { ?>
    <!-- Body score chart initialization -->
    <div id="bs_container_<?php echo $zzi ?>" style="width: 680px; height: 300px"></div>
    <script type="text/javascript">
        var bodyscore_chart_<?php echo $zzi ?> = new Highcharts.Chart({
              chart: {
                 renderTo: 'bs_container_<?php echo $zzi ?>',
                 defaultSeriesType: 'column'
              },
              colors: ['#0096D6'],
              title: {
                 text: ''
              },
              xAxis: {
                 categories: <?php echo $phase->bodyscore->chart->cats ?>
              },
              yAxis: {
                 min: 0,
                 max: 100,
                 title: {
                    text: 'Percentage'
                 },
                 tickInterval: 10
              },
              tooltip: {
                  enabled: false
              },
              legend: {
                  enabled: false
              },
              credits: {
                  enabled: false
              },
              plotOptions: {
                 column: {
                    enableMouseTracking: false
                 }
              },
                   series: [{
                  data: <?php echo $phase->bodyscore->chart->opp_vals ?>
              }]
           });
    </script>

    <?php
    } else { ?>
    <span>No survey was taken.</span>
<?php
    }
?>
</div>
<?php
}
?>