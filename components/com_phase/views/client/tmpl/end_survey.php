<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>


<?php
$pid = JRequest::getVar('pid');
$uid = JRequest::getVar('uid');
?>




<?php
foreach ($this->cnt as $cnt)
{
    $cnt = $cnt->cnt;
}
?>

<div class='contentheading'>
<?php
if($cnt == 6)
:
echo "All fields are filled - ";
?>
   <a href="index.php?option=com_phase&controller=client&action=show_phases_tasks&phase=<?=$pid?>">PRESS TO CONTINUE</a>
<?php
else: 
    echo 'Perform all tasks';
endif;
?>

</div>


<div class='tabContainer2' style="background-color:#E1FFE3">

<div class='contentheading'> How you feel </div> 
<?php
if($this->uq):
    if($this->uq == no)
    {
        echo 'None of';
    }
    else
    {
    foreach ($this->uq as $value)
    {
        echo $value->answer."<br>";
    }    
    }
    
    
    
    
    
    
    
        if($this->trackingEnd){  ?>
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
                 categories: <?php echo $this->trackingEnd->cats ?>
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
                  data: <?php echo $this->trackingEnd->opp_vals ?>
              }]
           });
        });
    </script>
    <div id="bs_container" style="width: 100%; height: 300px"></div>
<?php }
    
    
    
    
?>    
    <div class='objectTitle'>
        <a href="index.php?option=com_phase&controller=client&action=edit_body_score_survey&pid=<?=$pid?>&uid=<?=$uid?>&id=<?=$this->uqid?>&t=1">Correct the data</a>
    </div> 
      
<?php    
else:
echo 'No Information Has Been Provided Yet';
?>
        <div class='objectTitle'>
                <a href="index.php?option=com_phase&controller=client&action=end_body_score_survey&pid=<?=$pid?>&uid=<?=$uid?>">Enter data</a>
        </div>     
<?php    
endif;
?>

    
    
    
  
  
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
<div class='contentheading'> Body score </div>       
<?php
if($this->fat):

    echo '<br>';
    echo "Weight - ".$this->fat[0]."lbs";
    echo '<br>';
    echo "Body Fat - ".$this->fat[1]."%";
    echo '<br>';
    echo "PH Score - ".$this->fat[2];
    echo '<br>';

?>    
<div class='objectTitle'>
        <a href="index.php?option=com_phase&controller=client&action=edit_body_score&pid=<?=$pid?>&uid=<?=$uid?>&id=<?=$this->fatid?>&t=1">Correct the data</a>
</div> 
      
<?php    
else:
    echo 'No Information Has Been Provided Yet';
?>
    <div class='objectTitle'>
<a href="index.php?option=com_phase&controller=client&action=end_body_score&pid=<?=$pid?>&uid=<?=$uid?>">Enter data</a>
    </div>
<?php    
endif;
?>    
    
    
 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
<div class='contentheading'> Your photos </div>      
 <?php
if($this->photo):
    
echo "  <div style='font-size:15px;color:#008;'>
        <img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->photo[0]."\" width=\"200\" height=\"350\">
        <img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->photo[1]."\" width=\"200\" height=\"350\">
        </div>";

?>    
<div class='objectTitle'>
        <a href="index.php?option=com_phase&controller=client&action=edit_body_foto&pid=<?=$pid?>&uid=<?=$uid?>&id=<?=$this->photoid?>&t=1">Correct the data</a>
</div> 
      
<?php    
else:
    echo 'No Information Has Been Provided Yet';
?>
    <div class='objectTitle'>
<a href="index.php?option=com_phase&controller=client&action=end_body_foto&pid=<?=$pid?>&uid=<?=$uid?>">Enter data</a>
    </div>
<?php    
endif;
?>    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    <div class='contentheading'> Symptoms Tracking </div>    
 <?php
if($this->symptoms):
     if($this->symptoms == no)
    {
        echo 'None of';
    }
    else
    {
    foreach ($this->symptoms as $value)
    {
    echo $value->name."<br>";    
    }    
    }
   

?>    
<div class='objectTitle'>
        <a href="index.php?option=com_phase&controller=client&action=edit_symptoms&pid=<?=$pid?>&uid=<?=$uid?>&id=<?=$this->sid?>&t=1">Correct the data</a>
</div> 
      
<?php    
else:
    echo 'No Information Has Been Provided Yet';
?>
    <div class='objectTitle'>
<a href="index.php?option=com_phase&controller=client&action=end_symptoms&pid=<?=$pid?>&uid=<?=$uid?>">Enter data</a>
    </div>
<?php    
endif;
?>    
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
 
  <div class='contentheading'> Medical Tracking </div>   
 <?php
if($this->medtrack):
         if($this->medtrack == no)
    {
        echo 'None of';
    }
    else
    {
    foreach ($this->medtrack as $value)
    {
    echo $value->name."<br>";    
    }    
    }
    

?>    
<div class='objectTitle'>
        <a href="index.php?option=com_phase&controller=client&action=edit_medtrack&pid=<?=$pid?>&uid=<?=$uid?>&id=<?=$this->mid?>&t=1">Correct the data</a>
</div> 
      
<?php    
else:
    echo 'No Information Has Been Provided Yet';
?>
    <div class='objectTitle'>
<a href="index.php?option=com_phase&controller=client&action=end_medtrack&pid=<?=$pid?>&uid=<?=$uid?>">Enter data</a>
    </div>
<?php    
endif;
?>  
 
    
  
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

<div class='contentheading'> Diseases Tracking </div> 
 <?php

if($this->diseases):
         if($this->diseases == no)
    {
        echo 'None of';
    }
    else
    {
    foreach ($this->diseases as $value)
    {
    echo $value->name."<br>";    
    }    
    }
    

?>    
<div class='objectTitle'>
        <a href="index.php?option=com_phase&controller=client&action=edit_diseases&pid=<?=$pid?>&uid=<?=$uid?>&id=<?=$this->did?>&t=1">Correct the data</a>
</div> 
      
<?php    
else:
    echo 'No Information Has Been Provided Yet';
?>
    <div class='objectTitle'>
<a href="index.php?option=com_phase&controller=client&action=end_diseases&pid=<?=$pid?>&uid=<?=$uid?>">Enter data</a>
    </div>
<?php    
endif;
?>  
    
    
