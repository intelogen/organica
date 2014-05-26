<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>


<div class='contentheading'>Start survey</div>   
<div class='tabContainer2' style="background-color:#E1FFE3">

    
<?php //Body score survey ?>
<div class='tabContainer2' style="background-color:#E1FFE3">    
<div class='contentheading'>Body score survey</div>


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
<?php }
    
    
?>    
    <div class='objectTitle'>
        <a href="index.php?option=com_phase&controller=client&action=edit_start_step1&pid=<?=$this->pid?>&uid=<?=$this->uid?>&id=<?=$this->uqid?>&tempid=<?=$this->tempuqid?>">Correct the data</a>
    </div> 
      
<?php    
else:
    echo 'No Information Has Been Provided Yet';
?>
    
        <div class='objectTitle'>
                <a href="index.php?option=com_phase&controller=client&action=start_step1&pid=<?=$this->pid?>&uid=<?=$this->uid?>">Enter data</a>
        </div>     
<?php    
endif;
?>


</div>   

<?php //Body score ?>   
<div class='tabContainer2' style="background-color:#E1FFE3">    
<div class='contentheading'>Body score</div>  


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
    <a href="index.php?option=com_phase&controller=client&action=edit_start_step2&pid=<?=$this->pid?>&uid=<?=$this->uid?>&id=<?=$this->fatid?>&tempid=<?=$this->tempfatid?>">Correct the data</a>
</div> 
      
<?php    
else:
echo 'No Information Has Been Provided Yet';
?>
    <div class='objectTitle'>
    <a href="index.php?option=com_phase&controller=client&action=start_step2&pid=<?=$this->pid?>&uid=<?=$this->uid?>">Enter data</a>
    </div>
<?php    
endif;
?>  

</div>

<?php //Current Photo ?>
<div class='tabContainer2' style="background-color:#E1FFE3">    
<div class='contentheading'>Current Photo</div>  

<?php
if($this->photo):
echo "  <div style='font-size:15px;color:#008;'>
        <img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->photo[0]."\" width=\"200\" height=\"350\">
        <img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->photo[1]."\" width=\"200\" height=\"350\">
        </div>";

?>    
<div class='objectTitle'>
        <a href="index.php?option=com_phase&controller=client&action=edit_start_step3&pid=<?=$pid?>&uid=<?=$uid?>&id=<?=$this->photoid?>&tempid=<?=$this->tempphotoid?>">Correct the data</a>
</div> 
      
<?php    
else:
echo 'No Information Has Been Provided Yet';
?>
    <div class='objectTitle'>
<a href="index.php?option=com_phase&controller=client&action=start_step3&pid=<?=$this->pid?>&uid=<?=$this->uid?>">Enter data</a>
    </div>
<?php    
endif;
?>   
</div>

<?php //Symptoms ?>
<div class='tabContainer2' style="background-color:#E1FFE3">    
<div class='contentheading'>Symptoms Tracking</div>  


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
    <a href="index.php?option=com_phase&controller=client&action=edit_start_step4&pid=<?=$this->pid?>&uid=<?=$this->uid?>&id=<?=$this->sid?>&tempid=<?=$this->tempsid?>">Correct the data</a>
</div> 
      
<?php    
else:
echo 'No Information Has Been Provided Yet';
?>
    <div class='objectTitle'>
<a href="index.php?option=com_phase&controller=client&action=start_step4&pid=<?=$this->pid?>&uid=<?=$this->uid?>">Enter data</a>
    </div>
<?php    
endif;
?>   

</div>

<?php //Medical ?>
<div class='tabContainer2' style="background-color:#E1FFE3">    
<div class='contentheading'>Medical Tracking</div>  


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
        <a href="index.php?option=com_phase&controller=client&action=edit_start_step5&pid=<?=$this->pid?>&uid=<?=$this->uid?>&id=<?=$this->mid?>&tempid=<?=$this->tempmid?>">Correct the data</a>
</div> 
      
<?php    
else:
echo 'No Information Has Been Provided Yet';
?>
    <div class='objectTitle'>
<a href="index.php?option=com_phase&controller=client&action=start_step5&pid=<?=$this->pid?>&uid=<?=$this->uid?>">Enter data</a>
    </div>
<?php    
endif;
?>  



</div>

<?php //Diseases ?>
<div class='tabContainer2' style="background-color:#E1FFE3">    
<div class='contentheading'>Diseases Tracking</div>  


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
        <a href="index.php?option=com_phase&controller=client&action=edit_start_step6&pid=<?=$this->pid?>&uid=<?=$this->uid?>&id=<?=$this->did?>&tempid=<?=$this->tempdid?>">Correct the data</a>
</div> 
      
<?php    
else:
echo 'No Information Has Been Provided Yet';
?>
    <div class='objectTitle'>
<a href="index.php?option=com_phase&controller=client&action=start_step6&pid=<?=$this->pid?>&uid=<?=$this->uid?>">Enter data</a>
    </div>
<?php    
endif;
?>  


</div>
    
    
</div>