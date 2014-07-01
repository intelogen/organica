
<script type="text/javascript" src="https://www.google.com/jsapi"></script>




    
    
    
<?php



defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php
$uid = $this->uid;
$pid = $this->pid;
$phases = $this->phases;

if(JRequest::getVar('c') && JRequest::getVar('c') != "")
        {
            $uid = JRequest::getVar('c');
        }
?>


<?php

if($this->evalution_1)
{
    $evalution = $this->evalution_1; 


}

if($this->evalution_2)
{
    $evalution_2 = $this->evalution_2; 


}


if($this->list)
{
    $list = $this->list; 
}
 
$uid = $this->uid;
$pid = $this->pid;
$phases = $this->phases;


?>




<div class='contentheading phase-navigation-header'>Phases Navigation</div>
<div class='tabContainer2 phase-navigation' style="background-color:#E1FFE3">
    <ul>
        <li><a href="index.php?option=com_phase&controller=client&action=show_repo&c=<?=$uid?>">Intake Survey</a></li>

        <?php
        if ($phases && $phases[0][id] !== null && $phases[0][name] !== null )
        {
            foreach ($phases as $value)
            {
                ?>
                <li><a href="index.php?option=com_phase&controller=client&action=show_repoz&c=<?=$uid?>&pid=<?=$value[id]?>"><?=$value[name]?></a></a></li>
            <?php
            }
        }
        ?>
        <li><a href="index.php?option=com_phase&controller=client&action=show_total_repo&c=<?=$uid?>">Total Progress</a></li>
    </ul>
</div>




















    
<table>
    <tr>
        <td><div id="name1" class='contentheading'><?=$this->evalution_1[name]?></div></td>
        <td><div id="name2" class='contentheading'><?=$this->evalution_2[name]?></div></td>
    </tr>
    <tr><td colspan="2"><div class='contentheading'>Body Tracking</div></td></tr>
    <tr>
        <td>
                        <div class='tabContainer2' style="background-color:#E1FFE3">
               <table width="50%">
                <tr>
                    <td><?="Weight"?></td>
                    <td><?php if(isset($evalution[body][0])){ echo $evalution[body][0];} ?><?="lbs"?></td>
                </tr>
                <tr>
                    <td><?="Body Fat"?></td>
                    <td><?php if(isset($evalution[body][1])){ echo $evalution[body][1];} ?><?="%"?></td>
                </tr>
                <tr>
                    <td><?="PH"?></td>
                    <td><?php if(isset($evalution[body][2])){ echo $evalution[body][2];} ?><?="%"?></td>
                </tr>

            </table> 
                            
            </div>
        </td>
        <td>
            <div class='tabContainer2' style="background-color:#E1FFE3">
               <table width="50%">
                <tr>
                    <td><?="Weight"?></td>
                    <td><?php if(isset($evalution_2[body][0])){ echo $evalution_2[body][0];} ?><?="lbs"?></td>
                </tr>
                <tr>
                    <td><?="Body Fat"?></td>
                    <td><?php if(isset($evalution_2[body][1])){ echo $evalution_2[body][1];} ?><?="%"?></td>
                </tr>
                <tr>
                    <td><?="PH"?></td>
                    <td><?php if(isset($evalution_2[body][2])){ echo $evalution_2[body][2];} ?><?="%"?></td>
                </tr>

            </table> 


            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">
    <div class="body-chart">
        <div id="chart_div2" style="width: 200px; height: 400px;"></div>
        <div id="chart_div3" style="width: 200px; height: 400px;"></div>
        <div id="chart_div4" style="width: 200px; height: 400px;"></div>
    </div>
        </td>
    </tr>
    <tr>
        <tr><td colspan="2"><div class='contentheading'>Lifestyle analysis:</div></td></tr>
        <td>
             <ul>               <?php

     if($this->qAnswers1 && $this->qAnswers1 !== null){
                   foreach ($this->qAnswers1 as $value) {
                       echo "<li>".$value['answer']."</li>";
                   }
               }else{echo"CONGRATULATIONS, YOU'VE ACHIEVED THE GOAL";}
            
                   ?>
		</ul>
        </td>
        <td>
		<ul>
                            <?php


               if($this->qAnswers2 && $this->qAnswers2 !== null){
                   foreach ($this->qAnswers2 as $value) {
                       echo "<li>".$value['answer']."</li>";
                   }
               }else{echo"CONGRATULATIONS, YOU'VE ACHIEVED THE GOAL";}
            
                   ?>
        </ul>
		</td>
    </tr>
          
    <tr><td colspan="2"><div id="chart_div" style="width: 750px; height: 300px;"></div></td></tr>
    <tr>
        <td colspan="2"><div class='contentheading'>Current Photo</div></td>
    </tr>
    <tr>
        <td>
                        <div class='tabContainer2' style="background-color:#E1FFE3"> 
                    <?php
                    if($evalution[photo][0])
                    {
                        ?>

                        <?php
                        echo "<img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution[photo][0]."\" width=\"200\" height=\"350\">";
                    }
                    else
                    {
                        echo "  <div style='font-size:15px;color:#008;'>
                                <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no1.png"."\" width=\"200\" height=\"350\">
                                </div>";        
                    }
                    ?>

                    <?php
                    if($evalution[photo][1])
                    {
                        ?>

                        <?php
                        echo "<img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution[photo][1]."\" width=\"200\" height=\"350\">";
                    }
                    else
                    {
                        echo "  <div style='font-size:15px;color:#008;'>
                                <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no2.png"."\" width=\"200\" height=\"350\">
                                </div>";        
                    }
                    ?>

            </div>
        </td>
        <td>
                        <div class='tabContainer2' style="background-color:#E1FFE3"> 
                
                    <?php
                    if($evalution_2[photo][0])
                    {
                        ?>

                        <?php
                        echo "<img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution_2[photo][0]."\" width=\"200\" height=\"350\">";
                    }
                    else
                    {
                        echo "  <div style='font-size:15px;color:#008;'>
                                <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no1.png"."\" width=\"200\" height=\"350\">
                                </div>";        
                    }
                    ?>

                
                
                    <?php
                    if($evalution_2[photo][1])
                    {
                        ?>

                        <?php
                        echo "<img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution_2[photo][1]."\" width=\"200\" height=\"350\">";
                    }
                    else
                    {
                        echo "  <div style='font-size:15px;color:#008;'>
                                <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no2.png"."\" width=\"200\" height=\"350\">
                                </div>";        
                    }
                    ?>

            
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2"><div class='contentheading'>Symptoms Tracking</div></td>
    </tr>
    <tr>
        <td>    <div id="symptom-1" style="width: 350px; height: 350px;"></div></td>
        <td>    <div id="symptom-2" style="width: 350px; height: 350px;"></div></td>
    </tr>
    <tr>
        <td>
 
<ul>
<?php
if (isset($evalution[symptoms]))
{
    for ($i = 0; $i < count($evalution[symptoms][val]); $i++)
    {
    ?>
    <li>
        <span>
            <?php
            foreach($list[symptomList] as $value)
            {
                if($value[id] == $evalution[symptoms][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </span><span><?=$evalution[symptoms][status][$i]?></span>
        </li>
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
</ul>
        </td>
        <td>

            
            
            
<ul>

<?php
if (isset($evalution_2[symptoms]))
{
			
    for ($i = 0; $i < count($evalution_2[symptoms][val]); $i++)
    {
    ?>
    <li>
        <span>
            <?php
                foreach($list[symptomList] as $value){
                    if($value[id] == $evalution_2[symptoms][val][$i]){
                        echo $value[name];
                    }
                }
            ?>
        </span><span><?=$evalution_2[symptoms][status][$i]?></span>
        </li>
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
</ul>
            
            
            
            
        </td>
    </tr>
    <tr>
        <td colspan="2"><div class='contentheading'>Medical preparations Tracking</div></td>
    </tr>
    <tr>
        <td>   <div id="drug-1" style="width: 350px; height: 350px;"></div></td>
        <td>   <div id="drug-2" style="width: 350px; height: 350px;"></div> </td>
    </tr>

        <td>

<ul>

<?php
if (isset($evalution[drug]))
{
    for ($i = 0; $i < count($evalution[drug][val]); $i++)
    {
    ?>
    <li>
        <span>
            <?php
            foreach($list[medtrackList] as $value)
            {
                if($value[id] == $evalution[drug][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </span><span><?=$evalution[drug][status][$i]?></span>
        </li>
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
</ul>
        </td>
        <td>
            
<ul>

<?php
if (isset($evalution_2[drug]))
{
    for ($i = 0; $i < count($evalution_2[drug][val]); $i++)
    {
    ?>
        <li>
        <span>
            <?php
            foreach($list[medtrackList] as $value)
            {
                if($value[id] == $evalution_2[drug][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>            
        </span><span><?=$evalution_2[drug][status][$i]?></span>
        </li>
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
</ul>
        </td>
    </tr>
    <tr>
        <td colspan="2"><div class='contentheading'>Diseases Tracking</div></td>
    </tr>
        <tr>
        <td>   <div id="dis-1" style="width: 350px; height: 350px;"></div></td>
        <td>   <div id="dis-2" style="width: 350px; height: 350px;"></div> </td>
    </tr>
    <tr>
        <td>

<ul>
<?php
if (isset($evalution[diseases]))
{
    for ($i = 0; $i < count($evalution[diseases][val]); $i++)
    {
    ?>
       <li>
        <span>
            <?php
            foreach($list[diseasesList] as $value)
            {
                if($value[id] == $evalution[diseases][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </span><span><?=$evalution[diseases][status][$i]?></span>
        </li>
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
</ul>

        </td>
        <td>

<ul>

<?php
if (isset($evalution_2[diseases]))
{
    for ($i = 0; $i < count($evalution_2[diseases][val]); $i++)
    {
    ?>
        <li>
        <span>
            <?php
            foreach($list[diseasesList] as $value)
            {
                if($value[id] == $evalution_2[diseases][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </span><span><?=$evalution_2[diseases][status][$i]?></span>
        </li>
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
</ul>
        </td>
    </tr>
</table>

    
        <script type="text/javascript">
     
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
        function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$this->charts_life?>);
        
        
        
        var options = {
            vAxis: {minValue: 0, maxValue: 100}
          //title: 'Lifestyle analysis',
          //hAxis: {title: 'Year', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      
      
    </script>

    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$this->charts[0]?>);

        var options = {
          title: 'Weight Compair',
          vAxis: {minValue: 0}
          //hAxis: {title: 'Year', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$this->charts[1]?>);

        var options = {
          title: 'Fat Compair',
          vAxis: {minValue: 0}
          //hAxis: {title: 'Year', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div3'));
        chart.draw(data, options);
      }
    </script>

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$this->charts[2]?>);

        var options = {
          title: 'Ph Compair',
          vAxis: {minValue: 0}
          //hAxis: {title: 'Year', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div4'));
        chart.draw(data, options);
      }
    </script>
    
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$this->s1?>);

        var options = {
        legend: 'none',
        pieSliceText: 'label',
        title: 'Symptoms Result',
        pieStartAngle: 100,
         };

        var chart = new google.visualization.PieChart(document.getElementById('symptom-1'));
        chart.draw(data, options);
      }
    </script>
    
	
	
				
	
	

	
	
	
	
	
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$this->s2?>);

        var options = {
        legend: 'none',
        pieSliceText: 'label',
        title: 'Symptoms Result',
        pieStartAngle: 100,
         };

        var chart = new google.visualization.PieChart(document.getElementById('symptom-2'));
        chart.draw(data, options);
      }
    </script>
				
				
				

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$this->m1?>);

        var options = {
        legend: 'none',
        pieSliceText: 'label',
        title: 'Medical Preparations Result',
        pieStartAngle: 100,
         };

        var chart = new google.visualization.PieChart(document.getElementById('drug-1'));
        chart.draw(data, options);
      }
    </script>
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$this->m2?>);

        var options = {
        legend: 'none',
        pieSliceText: 'label',
        title: 'Medical Preparations Result',
        pieStartAngle: 100,
         };

        var chart = new google.visualization.PieChart(document.getElementById('drug-2'));
        chart.draw(data, options);
      }
    </script>


    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$this->d1?>);

        var options = {
        legend: 'none',
        pieSliceText: 'label',
        title: 'Diseases Result',
        pieStartAngle: 100,
         };

        var chart = new google.visualization.PieChart(document.getElementById('dis-1'));
        chart.draw(data, options);
      }
    </script>
    
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$this->d2?>);

        var options = {
        legend: 'none',
        pieSliceText: 'label',
        title: 'Diseases Result',
        pieStartAngle: 100,
         };

        var chart = new google.visualization.PieChart(document.getElementById('dis-2'));
        chart.draw(data, options);
      }
    </script>

