<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php
$uid = $this->uid;
$pid = 0;

$loockingfor = $this->loockingfor;


if($this->evalution)
{
    $evalution = $this->evalution; 
}


$phases = $this-> phases;
$count = count($phases);

?>
<div class='contentheading'>Phases Navigation</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
<a href="index.php?option=com_phase&controller=client&action=show_repo&c=<?=$uid?>">Intake Survey</a>
<?php
$numb = 1;
for ($i = 0; $i < count($phases); $i++)
{
?>
    <a href="index.php?option=com_phase&controller=client&action=show_repoz&c=<?=$uid?>&pid=<?=$phases[$i][id]?>"><?=" Phase-".$numb." "?></a>
<?php    
$numb ++;
}
?>
<a href="index.php?option=com_phase&controller=client&action=show_repo&c=<?=$uid?>">Total Progress</a>
</div>
    
<div class='contentheading'>Intake Survey</div>   
<div class='tabContainer2' style="background-color:#E1FFE3">
<form action="index.php?option=com_phase&controller=client&inc=1"  method="post" enctype="multipart/form-data">    
 
<input type="hidden" name="evalution[pid]" value="<?=$pid?>" />
<input type="hidden" name="evalution[uid]" value="<?=$uid?>" />


<div class='contentheading'>Client goals</div>   
<div class='tabContainer2' style="background-color:#E1FFE3">

    
    
    
<?php    
if($loockingfor):   
?>
<table>
    <tr colspan="2">
        <td><?="Target Weight = "?></td>
        <td><?php if(isset($evalution[goals][weight])){ echo $evalution[goals][weight];} ?><?=" lbs."?></td>
    </tr>
    <tr colspan="2">
        <td><?="Target Body Fat = "?></td>
        <td><?php if(isset($evalution[goals][fat])){ echo $evalution[goals][fat];} ?><?=" %"?></td>
    </tr>
    <tr>
    <?php
    $cnt = 1;    
    foreach($loockingfor as $value):
    ?>
                <td style='border:1px solid #EEE;padding:3px;' align="center" ><input type="checkbox" name="evalution[goals][question][]" value="<?=$value['id'];?>" <?php if(isset($evalution[goals][question])){ if(in_array($value['id'],$evalution[goals][question])) {echo "checked";}} ?>></td>
                <td style='border:1px solid #EEE;padding:3px;'><?=$value['var'];?></td>
    <?php
    if($cnt % 4 == 0)
    {
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
</div>

<div class='contentheading'>Body stats</div>    
<div class='tabContainer2' style="background-color:#E1FFE3">
<table width="50%">
    <tr>
        <td><?="Sex - "?></td>
        <td>
            <?php if(isset($evalution[stats][sex])){echo $evalution[stats][sex];}?>
        </td>
    </tr>
    <tr>
        <td><?="Height"?></td>   
        <td><?php if(isset($evalution[stats][height][0])){ echo $evalution[stats][height][0];} ?><?=" ft "?><?php if(isset($evalution[stats][height][0])){ echo $evalution[stats][height][1];} ?><?=" inches"?></td>
    </tr>
    <tr>
        <td><?="Weight"?></td>
        <td><?php if(isset($evalution[stats][weight])){ echo $evalution[stats][weight];} ?><?="lbs"?></td>
    </tr>
    <tr>
        <td><?="Body Fat"?></td>
        <td><?php if(isset($evalution[stats][fat])){ echo $evalution[stats][fat];} ?><?="%"?></td>
    </tr>
    <tr>
        <td><?="PH"?></td>
        <td><?php if(isset($evalution[stats][ph])){ echo $evalution[stats][ph];} ?><?="%"?></td>
    </tr>
    <tr>
        <td><?="Blood Pressure"?></td>
        <td><?php if(isset($evalution[stats][blood_p][0])){ echo $evalution[stats][blood_p][0];} ?><?=" / "?><?php if(isset($evalution[stats][blood_p][0])){ echo $evalution[stats][blood_p][1];} ?></td>
    </tr>
    <tr>
        <td><?="Blood Type"?></td>
        <td>
            <?php
            if(isset($evalution[stats][blood_t])){echo $evalution[stats][blood_t];}
            ?>
        </td>
    </tr>
</table>

</div>

<div class='contentheading'>Body Type</div> 
<div class='tabContainer2' style="background-color:#E1FFE3">    


    
<table>
    <tr>
        <td><?="1. Bone structure - "?><?php echo $evalution[body_type][0]; ?></td>
    </tr>
    <tr>
        <td>
            
        </td>
    </tr>
    <tr>
        <td><?="2. Muscle type  - "?><?php echo $evalution[body_type][1]; ?></td>
    </tr>
    <tr>
        <td>
        
        </td>
    </tr>
    <tr>
        <td><?="3. Tendency to gain weight - "?><?php echo $evalution[body_type][2];?></td>
    </tr>
    <tr>
        <td>

        </td>
    </tr>
    <tr>
        <td><?="4. Desribes the clients apperance, knowing thei age  - "?><?php echo $evalution[body_type][3];?></td>
    </tr>
    <tr>
        <td>

        </td>
    </tr>
    <tr>
        <td><?="5. Risk of heart disease - "?><?php echo $evalution[body_type][4]; ?></td>
    </tr>
    <tr>
        <td>

        </td>
    </tr>
    <tr>
        <td><?="6. Body shape that most resembles you own."?></td>
    </tr>
    <tr>
        <td>
            <?php
            if($evalution[body_type][5] == "fat.png"){echo "  <div style='font-size:15px;color:#008;'>
            <img src=\"".JURI::root().'uploads_jtpl/phase_details/'."fat.png"."\" width=\"200\" height=\"350\">
            </div>";}
            ?>
            <?php
            if($evalution[body_type][5] == "normal.png"){echo "  <div style='font-size:15px;color:#008;'> 
            <img src=\"".JURI::root().'uploads_jtpl/phase_details/'."normal.png"."\" width=\"200\" height=\"350\">
            </div>";}
            ?>
            <?php
            if($evalution[body_type][5] == "toll.png"){echo "  <div style='font-size:15px;color:#008;'>
            <img src=\"".JURI::root().'uploads_jtpl/phase_details/'."toll.png"."\" width=\"200\" height=\"350\">
            </div>";}
            ?> 
        </td>
    </tr>
</table>
</div>
        
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
</div>



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



<div class='contentheading'>Current Photo</div>    
<div class='tabContainer2' style="background-color:#E1FFE3"> 
<table>
<tr>
    <td>
        <?php
if($evalution[file][0])
{
?>
<?php
echo "  <div style='font-size:15px;color:#008;'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution[file][0]."\" width=\"200\" height=\"350\"></div>";
}
else
{
echo "  <div style='font-size:15px;color:#008;'>
        <img src=\"".JURI::root().'uploads_jtpl/phase_details/'."no1.png"."\" width=\"200\" height=\"350\">
        </div>";        
}
?>

    </td>
    <td>
        <?php
if($evalution[file][1])
{
?>
        
        
<?php
echo "  <div style='font-size:15px;color:#008;'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution[file][1]."\" width=\"200\" height=\"350\"></div>";
}
else
{
echo "  <div style='font-size:15px;color:#008;'>
        <img src=\"".JURI::root().'uploads_jtpl/phase_details/'."no2.png"."\" width=\"200\" height=\"350\">
        </div>";        
}
?>  
    </td>
</tr>
    
    
    </table>







</div>      
      
<div class='contentheading'>Medical Tracking</div>    
<div class='tabContainer2' style="background-color:#E1FFE3">    
    <table>
        <tr>
            <td><?="1. Your last physical exam was - "?><?php if(isset($evalution[madtrack][exem])){ echo $evalution[madtrack][exem];} ?></td>
            <td> </td>
            <td></td>
        </tr>
        <tr>
            <td><?="2. Undermedical treatment - "?></td>
            <td>
                <?php echo $evalution[madtrack][treatment][status];?> 
            </td>
            <td><?php if(isset($evalution[madtrack][treatment][note])){ echo $evalution[madtrack][treatment][note];} ?></td>
        </tr>
        <tr>
            <td><?="3. Have you ever had any seriousillness or operations ?"?></td>
            <td>
                <?php echo $evalution[madtrack][operations][status];?>
            </td>
            <td><?php if(isset($evalution[madtrack][operations][note])){ echo $evalution[madtrack][operations][note];} ?></td>
        </tr>
        <tr>
            <td><?="4. Do you smoke ?"?></td>
            <td>
                <?php echo $evalution[madtrack][smoke][status]; ?>
            </td>
            <td><?php if(isset($evalution[madtrack][smoke][note])){ echo $evalution[madtrack][smoke][note];} ?></td>
        </tr>
        <tr>
            <td><?="5. Alcohol use ?"?></td>
            <td>
                <?php echo $evalution[madtrack][alcohol][status]; ?>
            </td>
            <td><?php if(isset($evalution[madtrack][alcohol][note])){ echo $evalution[madtrack][alcohol][note];}?></td>
        </tr>
        <tr>
            <td><?="6. Do you use cocaine or drugs ?"?></td>
            <td>
                <?php echo $evalution[madtrack][drugs][status];?>
            </td>
            <td><?php if(isset($evalution[madtrack][drugs][note])){ echo $evalution[madtrack][drugs][note];}?></td>
        </tr>
    </table>
    
   



    
    
<div class='tabContainer2' style="background-color:#E1FFE3">   

    
<div class='contentheading'>Allergies Tracking</div>    
<?php
if(isset($evalution[madtrack][allergies]))
{
?>
<table>
            <tr>
            <td>
            <?php
            foreach ($evalution[madtrack][allergies][status] as $value)
            {
            ?>
                Name: <?=$value?><?="<br>"?>
            <?php
            }
            ?>
            </td>
           
            <td>    
            <?php
            foreach ($evalution[madtrack][allergies][note] as $value)
            {
            ?>
                Note: <?=$value?><?="<br>"?>
            <?php
            }
            ?>
            </td>
            </tr>
</table>
<?php
}
echo '<br>';
?>





<div class='contentheading'>Symptoms Tracking</div>    
<?php
if(isset($evalution[madtrack][symptoms]))
{
?>
<table>
            <tr>
            <td>
            <?php
            foreach ($evalution[madtrack][symptoms][status] as $value)
            {
            ?>
                Name: <?=$value?><?="<br>"?>
            <?php
            }
            ?>
            </td>
           
            <td>    
            <?php
            foreach ($evalution[madtrack][symptoms][note] as $value)
            {
            ?>
                Note: <?=$value?><?="<br>"?>
            <?php
            }
            ?>
            </td>
            </tr>
</table>
<?php
}
echo '<br>';
?>





<div class='contentheading'>Medical preparations Tracking</div>
<?php
if(isset($evalution[madtrack][drug]))
{
?>
<table>
            <tr>
            <td>
            <?php
            foreach ($evalution[madtrack][drug][status] as $value)
            {
            ?>
                Name: <?=$value?><?="<br>"?>
            <?php
            }
            ?>
            </td>
           
            <td>    
            <?php
            foreach ($evalution[madtrack][drug][note] as $value)
            {
            ?>
                Note: <?=$value?><?="<br>"?>
            <?php
            }
            ?>
            </td>
            </tr>
</table>
<?php
}
echo '<br>';
?>






<div class='contentheading'>Diseases Tracking</div>
<?php
if(isset($evalution[madtrack][diseases]))
{
?>
<table>
            <tr>
            <td>
            <?php
            foreach ($evalution[madtrack][diseases][status] as $value)
            {
            ?>
                Name: <?=$value?>"<?="<br>"?>
            <?php
            }
            ?>
            </td>
           
            <td>    
            <?php
            foreach ($evalution[madtrack][diseases][note] as $value)
            {
            ?>
                Note: <?=$value?><?="<br>"?>
            <?php
            }
            ?>
            </td>
            </tr>
</table>
<?php
}
echo '<br>';
?>

</div>

</div>     

</form>   
</div>