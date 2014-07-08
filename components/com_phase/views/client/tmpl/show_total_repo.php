<?php
if ($this->content){
    $content = $this->content;
}
if ($this->gols){
    $gols = $this->gols;
}
?>



<div class='contentheading'>Body History</div>  



    


    <div class='tabContainer2' style="background-color:#E1FFE3">
        
        <div class='tabContainer2 horizontal-shadow' style="background-color:#E1FFE3">
        <table id="medical" border="1">
            <tr>
                <td>PHASE</td>
                <td>WEIGHT</td>
                <td>FAT</td>
                <td>PH</td>
            </tr>
            <tr>
                <td>Intake data</td>
                <td><?=$this->content2[inteke][body][val][0]?></td>
                <td><?=$this->content2[inteke][body][val][1]?></td>
                <td><?=$this->content2[inteke][body][val][2]?></td>
            </tr>
            <?php if($this->content2[content] !== null && $this->content2[content] != ""){
                        foreach ($this->content2[content] as $key => $value) {
                            echo "<tr><td>".$key."</td><td>".$value[body][val][0]."</td><td>".$value[body][val][1]."</td><td>".$value[body][val][2]."</td></tr>";
                        }
                    } ?>
            <tr>
                <td>Goal</td>
                <td><?=$this->content2[inteke][goals_body][val][0]?></td>
                <td><?=$this->content2[inteke][goals_body][val][1]?></td>
                <td>7</td>
            </tr>
            
        </table>
        </div>
        
        
            <div id="chart_div" style="width: 650px; height: 200px;"></div>
            <div id="chart_div_2" style="width: 650px; height: 200px;"></div>
            <div id="chart_div_3" style="width: 650px; height: 200px;"></div>
    </div>



<div class='contentheading'>Symptoms Tracking</div>  
<div class='tabContainer2' style="background-color:#E1FFE3">
        <table id="symptoms" border="1">
            
                <?php
                if($this->content2 !== null){
                foreach ($this->content2[content] as $key =>  $value) {
                    $phases[] = $key; 
                    if($value[symptoms][val][0] !== "" && $value[symptoms][val][0] !==null){$symptoms = $value[symptoms][val];}
                    $status[] = $value[symptoms][status];
                }?>
                    
            <tr><td><b>Name</b></td>
                <?php
                for($i = 0; count($phases)>$i; $i++){
                    $s = $i;
                    echo "<td><b>Phase ".++$s."</b></td>";
                }
                ?>
            </tr>           
                <?php

                for($i = 0; count($symptoms)>$i; $i++){
                ?>
            <tr>
                <?php

                    foreach($this->list[symptomList] as $value){
                    $value[id];
                    if($value[id] == $symptoms[$i]){
                    echo "<td>".$value[name]."</td>";
                    }
                }

                foreach ($status as $value) {
                    if($value[$i] == ""){
                        echo "<td>no status</td>";
                    }else{
                        if($value[$i] == 'finished'){echo "<td><b>".$value[$i]."</b></td>";}else{echo "<td>".$value[$i]."</td>";}
                    }
                }
                ?>
            </tr>    
                <?php
                }
                ?>
                <?php }else{echo "No data to display";} ?>
        </table>
</div>

<div class='contentheading'>Medical preparations Tracking</div>  
<div class='tabContainer2' style="background-color:#E1FFE3">
        <table id="symptoms" border="1">
                <?php
                if($this->content2 !== null){
                foreach ($this->content2[content] as $key => $value) {
                    $phases_d[] = $key; 
                    if($value[drug][val][0] !== "" && $value[drug][val][0] !==null){$drug = $value[drug][val];}
                    $status_d[] = $value[drug][status];
                }
                ?>
            <tr><td><b>Name</b></td>
                <?php
                    for($i = 0; count($phases_d)>$i; $i++){
                        $dr = $i;
                        echo "<td><b>Phase ".++$dr."</b></td>";
                    }
                ?>
            </tr>
                <?php
                for($i = 0; count($drug)>$i; $i++){
                    ?>
            <tr>
                    <?php
                    foreach($this->list[medtrackList] as $value)
                    {
                        if($value[id] == $drug[$i])
                        {
                            echo "<td>".$value[name]."</td>";
                        }
                    }
                    foreach ($status_d as $value) {
                        if($value[$i] == ""){
                            echo "<td>no status</td>";
                        }else{
                            if($value[$i] == 'finished'){echo "<td><b>".$value[$i]."</b></td>";}else{echo "<td>".$value[$i]."</td>";}
                        }
                    }
                    ?>
            </tr>    
                <?php
                }
                ?>
              <?php }else{echo "No data to display";} ?>
        </table>
</div>

<div class='contentheading'>Diseases Tracking</div>  
<div class='tabContainer2' style="background-color:#E1FFE3">
<table id="symptoms" border="1">
            <?php
            if($this->content2 !== null){       
            foreach ($this->content2[content] as $key => $value) {

                $phases_di[] = $key; 
                if($value[diseases][val][0] !== "" && $value[diseases][val][0] !==null){$diseases = $value[diseases][val];}
                $status_di[] = $value[diseases][status];
            }
            ?>

        <tr><td><b>Name</b></td>
                    <?php
                        for($i = 0; count($phases_di)>$i; $i++){
                            $di = $i;
                            echo "<td><b>Phase ".++$di."</b></td>";
                        }
                    ?>
            </tr>
                    <?php
                    for($i = 0; count($diseases)>$i; $i++){
                        ?>
                    <tr>
                            <?php
                            foreach($this->list[diseasesList] as $value)
                            {
                                if($value[id] == $diseases[$i])
                                {
                                    echo "<td>".$value[name]."</td>";
                                }
                            }


                            foreach ($status_di as $value) {
                                if($value[$i] == ""){
                                    echo "<td>no status</td>";
                                }else{
                                    if($value[$i] == 'finished'){echo "<td><b>".$value[$i]."</b></td>";}else{echo "<td>".$value[$i]."</td>";}
                                }
                            }
                            ?>
                    </tr>    
                        <?php
                        }
                        ?>

        <?php }else{echo "No data to display";} ?>
    </table>
</div>

<div class='contentheading'>Photo History</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    <div class='contentheading'><?="Intake photo"?></div>
    <div class='current-photo horizontal-shadow'>
        <?php   if($this->content2[inteke][photo][val][0] !== "" && $this->content2[inteke][photo][val][0] !== null){
                    echo "<div class='photo-one'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->content2[inteke][photo][val][0]."\" width=\"200\" height=\"350\"></div>";
                } else {
                    echo "  <div style='font-size:15px;color:#008;'>
                            <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no1.png"."\" width=\"200\" height=\"350\">
                            </div>";        
                }
                    
                if($this->content2[inteke][photo][val][1] !== "" && $this->content2[inteke][photo][val][1] !== null){
                    echo "<div class='photo-two'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->content2[inteke][photo][val][1]."\" width=\"200\" height=\"350\"></div>";
                }else{
                    echo "  <div style='font-size:15px;color:#008;'>
                            <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no2.png"."\" width=\"200\" height=\"350\">
                            </div>";        
                } ?>
    </div>
    
    <?php
        if($this->content2 !== null && $this->content2 != ""){
                foreach ($this->content2[content] as $key => $value) {?>
                    <div class='contentheading'><?=$key?></div>
                    <div class='current-photo horizontal-shadow'>
                        
                        <?php   if($value[photo][val][0] !== "" && $value[photo][val][0] !== null){
                                    echo "<div class='photo-one'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$value[photo][val][0]."\" width=\"200\" height=\"350\"></div>";
                                } else {
                                    echo "  <div class='photo-one'>
                                            <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no1.png"."\" width=\"200\" height=\"350\">
                                            </div>";        
                                }

                                if($value[photo][val][1] !== "" && $value[photo][val][1] !== null){
                                    echo "<div class='photo-two'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$value[photo][val][1]."\" width=\"200\" height=\"350\"></div>";
                                }else{
                                    echo "  <div class='photo-two'>
                                            <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no2.png"."\" width=\"200\" height=\"350\">
                                            </div>";        
                                } ?>
                    </div>
                    <?php
                }
            }
    ?>
</div>

















<script type="text/javascript" src="https://www.google.com/jsapi"></script>

 <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$this->d?>);

        var options = {
          title: 'Weight History',
          //hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
          //vAxis: {minValue: 300},
		  //vAxis: {maxValue: 1520}
		  
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$this->d1?>);

        var options = {
          title: 'Fat History',
          //hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
          //vAxis: {minValue: 0}
		  
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div_2'));
        chart.draw(data, options);
      }
    </script>

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$this->d2?>);

        var options = {
          title: 'PH History',
         // hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
          //vAxis: {minValue: 0}
		  
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div_3'));
        chart.draw(data, options);
      }
    </script>
    
