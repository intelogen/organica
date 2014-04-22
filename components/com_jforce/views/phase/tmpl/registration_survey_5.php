<?php

/************************************************************************************
*    @package        Joomla                                                            *
*    @subpackage        jForce, the Joomla! CRM                                            *
*    @author        Dhruba,JTPL
*    @license        GNU/GPL, see jforce.license.php                                    *
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');    

$res = $this->all_survey_results;

// preparing 'looking for' output
$lf_text = array();
if($res->looking_for) {
    foreach($res->looking_for as $v) {
        $lf_text[] = '<strong>'.strtolower($v->question).'</strong>';
    }
    $lf_text = implode(', ', $lf_text);
} else {
    $lf_text = 'nothing';
}

// preparing 'symptoms' output
$sym_text = array();
if($res->symptoms) {
    foreach($res->symptoms as $v) {
        $sym_text[] = '<strong>'.strtolower($v->question).'</strong>';
    }
$sym_text = 'Your symptoms are '.implode(', ', $sym_text);
} else {
    $sym_text = 'You have no symptoms';
}

// preparing 'medtrack' output
$med_text = array();
if($res->medtrack) {
    foreach($res->medtrack as $v) {
        $med_text[] = '<strong>'.$v->question.'</strong>';
    }
$med_text = implode(', ', $med_text);
} else {
    $med_text = 'nothing';
}

// preparing 'diseases' output
$dis_text = array();
if($res->disease) {
    foreach($res->disease as $v) {
        $dis_text[] = '<strong>'.strtolower($v->question).'</strong>';
    }
$dis_text = "Currently you have the following diseases: ".implode(', ', $dis_text);
} else {
    $dis_text = "Currently you don't have any diseases";
}

?>

<div class='contentheading'><?php echo JText::_('Survey Results'); ?></div>
<div class='tabContainer2'>
    <div>
<p class="sr_message">
Dear <strong><?php echo $this->username ?></strong>, thank you for completing your survey. This is the most important part of your health journey.
You will be contacted for a review of your results by one of our staff members shortly.
</p>
<p class="sr_message">

You're looking for <?php echo $lf_text ?>. <?php echo $sym_text ?>.
    You mentioned you are taking <?php echo $med_text ?>. <?php echo $dis_text ?>.
</p>
<p class="sr_message">
Please review your body score results below, and purchase the recommended products based on your results.
</p>
    </div>
   
    <!-- Body score chart initialization -->
    <script type="text/javascript">
        var bodyscore_chart;
        jQuery(document).ready(function() {
            bodyscore_chart = new Highcharts.Chart({
              chart: {
                 renderTo: 'bs_container',
                 defaultSeriesType: 'column'
              },
              colors: ['#0096D6'],
              title: {
                 text: ''
              },
              xAxis: {
                 categories: <?php echo $this->bs_cats ?>
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
                  data: <?php echo $this->bs_opposite_vals ?>
              }]
           });
        });
    </script>
    <div id="bs_container" style="width: 100%; height: 300px"></div>
    <form action="<?=JRoute::_("index.php?option=com_jforce&view=dashboard");?>" method="post">
        <table style="width: 100%; font-size: 15px;">
            <tbody>
                <tr>
                  <td rowspan="2" colspan="4">
                  </td>
                </tr>
                <tr>
                  <td align="right" style="width: 13%;"></td>
                  <td style="width: 2%;"></td>
                  <td align="left" style="width: 85%;"></td>
                </tr>
                <?php foreach($this->bs_percents as $v) { ?>
                <tr>
                  <td align="right">
                      <span style="font-weight: bold; font-family: Verdana;" id="lbl<?php echo $v['catname'] ?>Link"><b><?php echo $v['catname'] ?></b></span>
                  </td>
                  <td></td>
                  <td align="left">
                      <span style="font-weight: bold; font-family: Verdana;" id="lbl<?php echo $v['catname'] ?>"><?php echo $v['percent'] ?>%</span>
                      <?php
                      // show recommended products category link
                      if($v['percent'] >= 50) { ?>
                      <span class="bodyscore_recommended">Recommended Products:
                          <a href="index.php?option=com_virtuemart&page=shop.browse&category_id=<?php echo $v['vm_catid'] ?>" target="_blank">link</a>
                      </span>
                      <?php } ?>
                  </td>
                </tr>
                <?php } ?>
                <tr>
                  <td align="right" style="width: 13%;"></td>
                  <td style="width: 2%;"></td>
                  <td align="left" style="width: 85%;"></td>
                </tr>
            </tbody>
        </table>
                          
        <br />
        <input type="button" value="Return Back" onclick="history.back(-1)">
        &nbsp;         
        <input type="submit" value="Continue">
        
    </form>
</div>

