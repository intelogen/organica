
<?php

                    //$this->trackingStart1->cats
                    //$this->trackingStart1->opp_vals

                       $var = explode(",", $this->trackingStart1->cats);

                       foreach ($var as $value) {
                           $res[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
                       }
                       


                        $var2 = explode(",", $this->trackingStart1->opp_vals);
                        foreach ($var2 as $value) {
                           $res2[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
                        }
                        
                        $var3 = explode(",", $this->trackingStart2->opp_vals);
                        foreach ($var3 as $value) {
                           $res3[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
                        }
                        
                        







                        for($i = 0; $i < count($res); $i++){
                            $t = ",['".$res[$i]."', ".$res2[$i].", ".$res3[$i]."]";
                            $b = $b."".$t;
                        }
                        
                        $a = "[['step', '".$this->evalution_1[name]."', '".$this->evalution_2[name]."']";
                        
                        //$b = ",['1',  100,  100]";
                        
                        $c = "]";    
                        
                        $d = $a."".$b."".$c;
                        
                        
    
                        
       
                           
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        /*
        $(function(){
                                
            var x = "1";
        
        
            //проверка
            if(x.length > 0) console.log('X = Селектор есть, кол-во = '+ x.length);
            else console.log('X = Селектора нет');
            console.log(x);
        });
      */

      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
        function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$d?>);
        
        
        
        var options = {
          //title: 'Lifestyle analysis',
          //hAxis: {title: 'Year', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      
      
    </script>







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
        <tr><td colspan="2"><div class='contentheading'>Lifestyle analysis:</div></td></tr>
        <td>
                            <?php


               if($this->qAnswers1){
                   foreach ($this->qAnswers1 as $value) {
                       echo "- ".$value['answer'].'<br>';
                   }
               }
            
                   ?>
        </td>
        <td>
                            <?php


               if($this->qAnswers2){
                   foreach ($this->qAnswers2 as $value) {
                       echo "- ".$value['answer'].'<br>';
                   }
               }
            
                   ?>
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
    <tr><td colspan="2"><div id="chart_div" style="width: 750px; height: 500px;"></div></td></tr>
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
        <td>
 
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
            <?php
            foreach($list[symptomList] as $value)
            {
                if($value[id] == $evalution[symptoms][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </td>
        <td>
            <?=$evalution[symptoms][status][$i];?>
        </td>
        <td>
            <?=$evalution[symptoms][note][$i];?>
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
        </td>
        <td>

<table border="1">
    <tr><td>Name</td><td>Status</td><td>Note</td></tr>
<?php
if (isset($evalution_2[symptoms]))
{
    for ($i = 0; $i < count($evalution_2[symptoms][val]); $i++)
    {
    ?>
        <tr>
        <td>
            <?php
            foreach($list[symptomList] as $value)
            {
                if($value[id] == $evalution_2[symptoms][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </td>
        <td>
            <?=$evalution_2[symptoms][status][$i];?>
        </td>
        <td>
            <?=$evalution_2[symptoms][note][$i];?>
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
        </td>
    </tr>
    <tr>
        <td colspan="2"><div class='contentheading'>Medical preparations Tracking</div></td>
    </tr>
    <tr>
        <td>

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
            <?php
            foreach($list[medtrackList] as $value)
            {
                if($value[id] == $evalution[drug][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </td>
        <td>
            <?=$evalution[drug][status][$i];?>
        </td>
        <td>
            <?=$evalution[drug][note][$i];?>
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
        </td>
        <td>
            
<table border="1">
    <tr><td>Name</td><td>Status</td><td>Note</td></tr>
<?php
if (isset($evalution_2[drug]))
{
    for ($i = 0; $i < count($evalution_2[drug][val]); $i++)
    {
    ?>
        <tr>
        <td>
            <?php
            foreach($list[medtrackList] as $value)
            {
                if($value[id] == $evalution_2[drug][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>            
        </td>
        <td>
            <?=$evalution_2[drug][status][$i];?>
        </td>
        <td>
            <?=$evalution_2[drug][note][$i];?>
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
        </td>
    </tr>
    <tr>
        <td colspan="2"><div class='contentheading'>Diseases Tracking</div></td>
    </tr>
    <tr>
        <td>

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
            <?php
            foreach($list[diseasesList] as $value)
            {
                if($value[id] == $evalution[diseases][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </td>
        <td>
            <?=$evalution[diseases][status][$i];?>
        </td>
        <td>
            <?=$evalution[diseases][note][$i];?>
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

        </td>
        <td>

<table border="1">
    <tr><td>Name</td><td>Status</td><td>Note</td></tr>
<?php
if (isset($evalution_2[diseases]))
{
    for ($i = 0; $i < count($evalution_2[diseases][val]); $i++)
    {
    ?>
        <tr>
        <td>
            <?php
            foreach($list[diseasesList] as $value)
            {
                if($value[id] == $evalution_2[diseases][val][$i])
                {
                    echo $value[name];
                }
            }
            ?>
        </td>
        <td>
            <?=$evalution_2[diseases][status][$i];?>
        </td>
        <td>
            <?=$evalution_2[diseases][note][$i];?>
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
        </td>
    </tr>
</table>





