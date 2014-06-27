
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
 
?>

























    
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


               if($this->qAnswers1){
                   foreach ($this->qAnswers1 as $value) {
                       echo "<li>".$value['answer']."</li>";
                   }
               }
            
                   ?>
		</ul>
        </td>
        <td>
		<ul>
                            <?php


               if($this->qAnswers2){
                   foreach ($this->qAnswers2 as $value) {
                       echo "<li>".$value['answer']."</li>";
                   }
               }
            
                   ?>
        </ul>
		</td>
    </tr>
    <tr><td colspan="2"><div class='contentheading'>Result</div></td></tr>
    <tr>
        <td>
            <?php   
            
                       $var = explode(",", $this->trackingStart1->cats);

                       foreach ($var as $value) {
                           $res[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
                       }

                       $var2 = explode(",", $this->trackingStart1->opp_vals);
                       foreach ($var2 as $value) {
                           $res2[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
                       }

                       if(count($res) == count($res2))
                           {
                               $cnt = array_combine( $res, $res2);

                           }



                       
                       foreach ($cnt as $key => $value) {
                           echo "<li>".$key;

                           if($value > 75)
                           {
                               echo " - NICE";
                           }
                           elseif ($value <=75 && $value > 50) {
                               echo " - ALMOST NICE</li>";
                           }
                           elseif($value <=50 && $value > 25){
                               echo " - ALMOST BAD</li>";
                           }
                           elseif($value <=25 && $value >= 0){
                               echo " - BAD</li>";
                           }

                       }
                        echo "</ul>";
            
            ?>
        </td>
        <td>
            <?php

                       $var = explode(",", $this->trackingStart2->cats);

                       foreach ($var as $value) {
                           $res[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
                       }

                       $var2 = explode(",", $this->trackingStart2->opp_vals);
                       foreach ($var2 as $value) {
                           $res2[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
                       }

                       if(count($res) == count($res2))
                           {
                               $cnt = array_combine( $res, $res2);

                           }



                       
                       foreach ($cnt as $key => $value) {
                           echo "<li>".$key;

                           if($value > 75)
                           {
                               echo " - NICE";
                           }
                           elseif ($value <=75 && $value > 50) {
                               echo " - ALMOST NICE</li>";
                           }
                           elseif($value <=50 && $value > 25){
                               echo " - ALMOST BAD</li>";
                           }
                           elseif($value <=25 && $value >= 0){
                               echo " - BAD</li>";
                           }

                       }
                        echo "</ul>";
            ?>
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
    <li><div><span>Name</span><span>Status</span><span>Note</span></div></li>
<?php
if (isset($evalution[symptoms]))
{
    for ($i = 0; $i < count($evalution[symptoms][val]); $i++)
    {
    ?>
    <li><div>
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
        </span>
        <span>
            <?=$evalution[symptoms][status][$i];?>
        </span>
        <span
            <?=$evalution[symptoms][note][$i];?>
        </span>
        </div></li>
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
    <li><div><span>Name</span><span>Status</span><span>Note</span></div></li>
<?php
if (isset($evalution_2[symptoms]))
{
			
    for ($i = 0; $i < count($evalution_2[symptoms][val]); $i++)
    {
    ?>
    <li><div>
        <span>
            <?php
			foreach($list[symptomList] as $value)
            {
                if($value[id] == $evalution_2[symptoms][val][$i])
                {
                    echo $value[name];
                }
            }
			
            ?>
        </span>
        <span>
            <?=$evalution_2[symptoms][status][$i];?>
        </span>
        <span>
            <?=$evalution_2[symptoms][note][$i];?>
        </span>
        </div></li>
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
    <li><div><span>Name</span><span>Status</span><span>Note</span></div></li>
<?php
if (isset($evalution[drug]))
{
    for ($i = 0; $i < count($evalution[drug][val]); $i++)
    {
    ?>
    <li><div>
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
        </span>
        <span>
            <?=$evalution[drug][status][$i];?>
        </span>
        <span>
            <?=$evalution[drug][note][$i];?>
        </span>
        </div></li>
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
    <li><div><span>Name</span><span>Status</span><span>Note</span></div></li>
<?php
if (isset($evalution_2[drug]))
{
    for ($i = 0; $i < count($evalution_2[drug][val]); $i++)
    {
    ?>
        <li><div>
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
        </span>
        <span>
            <?=$evalution_2[drug][status][$i];?>
        </span>
        <span>
            <?=$evalution_2[drug][note][$i];?>
        </span>
        </div></li>
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
    <li><div><span>Name</span><span>Status</span><span>Note</span></div></li>
<?php
if (isset($evalution[diseases]))
{
    for ($i = 0; $i < count($evalution[diseases][val]); $i++)
    {
    ?>
       <li><div>
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
        </span>
        <span>
            <?=$evalution[diseases][status][$i];?>
        </span>
        <span>
            <?=$evalution[diseases][note][$i];?>
        </span>
        </div></li>
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
    <li><div><span>Name</span><span>Status</span><span>Note</span></div></li>
<?php
if (isset($evalution_2[diseases]))
{
    for ($i = 0; $i < count($evalution_2[diseases][val]); $i++)
    {
    ?>
        <li><div>
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
        </span>
        <span>
            <?=$evalution_2[diseases][status][$i];?>
        </span>
        <span>
            <?=$evalution_2[diseases][note][$i];?>
        </span>
        </div></li>
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
          title: 'Weight Compair',
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

