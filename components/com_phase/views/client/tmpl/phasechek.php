<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php
$uid = $this->uid;
$pid = $this->pid;
?>


<?php
if($this->evalution)
{
    $evalution = $this->evalution; 
/*
    echo '<pre>';
    var_dump($evalution);
    echo '</pre>';
*/
}
?>



<div class='contentheading'>Intake Survey</div>   
<div class='tabContainer2' style="background-color:#E1FFE3">
<form action="index.php?option=com_phase&controller=client&ph=1"  method="post" enctype="multipart/form-data">    
 
<input type="hidden" name="evalution[pid]" value="<?=$pid?>" />
<input type="hidden" name="evalution[uid]" value="<?=$uid?>" />


        
<div class='contentheading'>Lifestyle analysis</div>    
<div class='tabContainer2' style="background-color:#E1FFE3">    
<?php
if($this->questionList):
?>
        <table class="allleft">
        <tr>
            
        <?php
        $cnt = 1;
            
            foreach($this->questionList as $value):

            
           ?>
            <td style='border:1px solid #EEE;padding:3px;' align="center"><input type="checkbox" name="evalution[life_style][]"<?php if(isset($evalution[life_style])){ if(in_array($value['id'],$evalution[life_style])) {echo "checked";} } ?> value="<?=$value['id'];?>"></td>
                <td style='border:1px solid #EEE;padding:3px;'><?=$value['question'];?></td>
            <?php

            if($cnt % 2 == 0) {
                echo "</tr><tr>\n";
            }
            $cnt++;
            endforeach;
        ?>
        </tr>
    </table>
<?php
endif;
?>
    
<?php
if($this->trackingStart){  ?>
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
                 categories: <?php echo $this->trackingStart->cats ?>
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
                  data: <?php echo $this->trackingStart->opp_vals ?>
              }]
           });
        });
    </script>
    <div id="bs_container" style="width: 100%; height: 300px"></div>
<?php }?>
</div>


<div class='contentheading'>Body Tracking</div>    
<div class='tabContainer2' style="background-color:#E1FFE3">
   <table width="50%">
    <tr>
        <td><?="Weight"?></td>
        <td><input type="text" name="evalution[body][weight]" size="2" value="<?php if(isset($evalution[body][0])){ echo $evalution[body][0];} ?>" /><?="lbs"?></td>
    </tr>
    <tr>
        <td><?="Body Fat"?></td>
        <td><input type="text" name="evalution[body][fat]" size="1" value="<?php if(isset($evalution[body][1])){ echo $evalution[body][1];} ?>" /><?="%"?></td>
    </tr>
    <tr>
        <td><?="PH"?></td>
        <td><input type="text" name="evalution[body][ph]" size="1" value="<?php if(isset($evalution[body][2])){ echo $evalution[body][2];} ?>" /><?="%"?></td>
    </tr>
    
</table> 
    
    
</div>    


<div class='contentheading'>Current Photo</div>    
<div class='tabContainer2' style="background-color:#E1FFE3"> 
<table>
<tr>
    <td>
        <?php
        if($evalution[photo][0])
        {
            ?>
            <input type="hidden" name="evalution[file][]" value="<?=$evalution[photo][0]?>" />
            <?php
            echo "  <div style='font-size:15px;color:#008;'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution[photo][0]."\" width=\"200\" height=\"350\"></div>";
        }
        else
        {
            echo "  <div style='font-size:15px;color:#008;'>
                    <img src=\"".JURI::root().'uploads_jtpl/phase_details/'."no1.png"."\" width=\"200\" height=\"350\">
                    </div>";        
        }
        ?>
        <input type='file' name="evalution[new_file][0]" />     
    </td>
    <td>
        <?php
        if($evalution[photo][1])
        {
            ?>
            <input type="hidden" name="evalution[file][]" value="<?=$evalution[photo][1]?>" />
            <?php
            echo "  <div style='font-size:15px;color:#008;'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution[photo][1]."\" width=\"200\" height=\"350\"></div>";
        }
        else
        {
            echo "  <div style='font-size:15px;color:#008;'>
                    <img src=\"".JURI::root().'uploads_jtpl/phase_details/'."no2.png"."\" width=\"200\" height=\"350\">
                    </div>";        
        }
        ?>
        <input type='file' name="evalution[new_file][1]" />
    </td>
</tr>
    
    
    </table>
</div>      
 
<div class='contentheading'>Medical Tracking</div>    
<div class='tabContainer2' style="background-color:#E1FFE3">    

<div class='contentheading'>Symptoms Tracking</div>    
<div class='tabContainer2' style="background-color:#E1FFE3">

<table border="1">
    <tr><td>Name</td><td>Status</td><td>Note</td></tr>
<?php
if (isset($evalution[symptoms]))
{
    for ($i = 0; $i < count($evalution[symptoms][val]); $i++)
    {
    ?>
        <tr>
        <td>
            <input type="hidden" name="evalution[symptoms][val][]" value="<?=$evalution[symptoms][val][$i]?>" />
            <?=$evalution[symptoms][val][$i];?>
        </td>
        <td>
            <select name="evalution[symptoms][status][]">
                <option value='Same'>Same2</option>
                <option value='Better'>Better</option>
                <option value='Worse'>Worse</option>
                <option value='Finished'>Finished</option>
            </select>
        </td>
        <td>
            <input type="text" name="evalution[symptoms][note][]" value="<?=$evalution[symptoms][note][$i];?>"/>
        </td>
        </tr>
    <?php    
    }
    ?>
<?php
}
else
{
?>
        <tr><td colspan="3">You dont have any symptoms</td></tr>
<?php
}
?>
</table>
</div>

<div class='contentheading'>Medical preparations Tracking</div>
<div class='tabContainer2' style="background-color:#E1FFE3">

<table border="1">
    <tr><td>Name</td><td>Status</td><td>Note</td></tr>
<?php
if (isset($evalution[drug]))
{
    for ($i = 0; $i < count($evalution[drug][val]); $i++)
    {
    ?>
        <tr>
        <td>
            <input type="hidden" name="evalution[drug][val][]" value="<?=$evalution[drug][val][$i]?>" />
            <?=$evalution[drug][val][$i];?>
        </td>
        <td>
            <?php
            if(isset($evalution[drug][status][$i]) && !empty($evalution[drug][status][$i]))
            {
            ?>
            <select name="evalution[drug][status][]">
                <option value='Same'>Same1</option>
                <option value='Better'>Better</option>
                <option value='Worse'>Worse</option>
                <option value='Finished'>Finished</option>
            </select>
            <?php
            }
            else
            {
            ?>
            <select name="evalution[drug][status][]">
                <option value='Same'>Same2</option>
                <option value='Better'>Better</option>
                <option value='Worse'>Worse</option>
                <option value='Finished'>Finished</option>
            </select>
            <?php
            }
            ?>
        </td>
        <td>
            <input type="text" name="evalution[drug][note][]" value="<?=$evalution[drug][note][$i];?>"/>
        </td>
        </tr>
    <?php    
    }
    ?>
<?php
}
else
{
?>
        <tr><td colspan="3">You dont have any drug</td></tr>
<?php
}
?>
</table>
</div>

<div class='contentheading'>Diseases Tracking</div>
<div class='tabContainer2' style="background-color:#E1FFE3">

<table border="1">
    <tr><td>Name</td><td>Status</td><td>Note</td></tr>
<?php
if (isset($evalution[diseases]))
{
    for ($i = 0; $i < count($evalution[diseases][val]); $i++)
    {
    ?>
        <tr>
        <td>
            <input type="hidden" name="evalution[diseases][val][]" value="<?=$evalution[diseases][val][$i]?>" />
            <?=$evalution[drug][val][$i];?>
        </td>
        <td>
            <?php
            if(isset($evalution[diseases][status][$i]) && !empty($evalution[diseases][status][$i]))
            {
            ?>
            <select name="evalution[diseases][status][]">
                <option value='Same'>Same1</option>
                <option value='Better'>Better</option>
                <option value='Worse'>Worse</option>
                <option value='Finished'>Finished</option>
            </select>
            <?php
            }
            else
            {
            ?>
            <select name="evalution[diseases][status][]">
                <option value='Same'>Same2</option>
                <option value='Better'>Better</option>
                <option value='Worse'>Worse</option>
                <option value='Finished'>Finished</option>
            </select>
            <?php
            }
            ?>
        </td>
        <td>
            <input type="text" name="evalution[diseases][note][]" value="<?=$evalution[diseases][note][$i];?>"/>
        </td>
        </tr>
    <?php    
    }
    ?>
<?php
}
else
{
?>
        <tr><td colspan="3">You dont have any drug</td></tr>
<?php
}
?>
</table>
</div>

</div>

<input type="submit" value="save" name="action"/>

</form>   
</div>