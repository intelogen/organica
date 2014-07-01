<?php
if ($this->content){
    $content = $this->content;
}
if ($this->gols){
    $gols = $this->gols;
}
if ($this->last_list){
    $last_list = $this->last_list;
}
if ($this->list){
    $list = $this->list;
}
?>



<div class='contentheading'>Body History</div>  

    <div class='tabContainer2' style="background-color:#E1FFE3">
    <div class="tabContainer2' style="background-color:#E1FFE3">
        <div><span>PHASE</span> - <span>WEIGHT</span> - <span>FAT</span> - <span>PH</span></div>
        <?php
        if($this->gols[body][val][0] !== "" && $this->gols[body][val][1] !== "" && $this->gols[body][val][2] !== ""){
            $date[] = "PRIMARY DATA";
            $weight[] = $this->gols[body][val][0];
            $fat[] = $this->gols[body][val][1];
            $ph[] = $this->gols[body][val][2];
            echo "<div><span>PRIMARY DATA</span> - <span>".$this->gols[body][val][0]."</span> - <span>".$this->gols[body][val][1]."</span> - <span>".$this->gols[body][val][2]."</span></div>";
        }
        ?>
        
        <?php
        if($this->content !== null && $this->content != ""){
            foreach ($this->content as $key => $value) {
                $date[] = "$key";
                $weight[] = $value[body][val][0];
                $fat[] = $value[body][val][1];
                $ph[] = $value[body][val][2];
                echo "<div><span>".$key."</span> - <span>".$value[body][val][0]."</span> - <span>".$value[body][val][1]."</span> - <span>".$value[body][val][2]."</span></div>";
            }
        }
        ?>
        <?php
        if($this->gols[goal_body][val][0] !== "" && $this->gols[goal_body][val][1] !== ""){
            $g_weight = $this->gols[goal_body][val][0];
            $g_fat =  $this->gols[goal_body][val][1];
            $g_ph =  7;
            echo "<div><span>CLIENT GOAL</span> - <span>".$this->gols[goal_body][val][0]."</span> - <span>".$this->gols[goal_body][val][1]."</span> - <span>7</span></div>";
        }
        
        ?>
    </div>
            <div id="chart_div" style="width: 650px; height: 200px;"></div>
            <div id="chart_div_2" style="width: 650px; height: 200px;"></div>
            <div id="chart_div_3" style="width: 650px; height: 200px;"></div>
    </div>
    <?php
        for($i = 0; $i < count($date); $i++){
            $t = ",['".$date[$i]."', ".$weight[$i].", ".$g_weight."]";
            $b = $b."".$t;
        }
        $a = "[['Phase', 'Weight', 'Goal']";
        $c = "]";    
        $d = $a."".$b."".$c;
        
        for($i = 0; $i < count($date); $i++){
            $t1 = ",['".$date[$i]."', ".$fat[$i].", ".$g_fat."]";
            $b1 = $b1."".$t1;
        }
        $a1 = "[['Date', 'Fat', 'Goal']";
        $c1 = "]";    
        $d1 = $a1."".$b1."".$c1;
    
        for($i = 0; $i < count($date); $i++){
            $t2 = ",['".$date[$i]."', ".$ph[$i].", ".$g_ph."]";
            $b2 = $b2."".$t2;
        }
        $a2 = "[['Date', 'PH', 'Goal']";
        $c2 = "]";    
        $d2 = $a2."".$b2."".$c2;
?>

<div class='contentheading'>Symptoms Tracking</div>  
<div class='tabContainer2' style="background-color:#E1FFE3">
        <?php
        if($this->content !== null){
        foreach ($this->content as $key => $value) {
            $phases[] = $key; 
            $symptoms = $value[symptoms][val][name];
            $status[] = $value[symptoms][val][status];
        }

        ?>
        <div>
            <div><span>Symptoms/Phases</span>
                <?php
                    for($i = 0; count($phases)>$i; $i++){
                        $s = $i;
                        echo "-<span>Phase ".++$s."</span>";
                    }
                ?>
            </div>
                <?php
                for($i = 0; count($symptoms)>$i; $i++){
                    ?>
                <div>
                        <?php
                        foreach($list[symptomList] as $value){
                            if($value[id] == $symptoms[$i]){
                            echo "<span>".$value[name]."</span>";
                            }
                        }

                        foreach ($status as $value) {
                            if($value[$i] == ""){
                                echo "-<span>no status</span>";
                            }else{
                                echo "-<span>".$value[$i]."</span>";
                            }
                        }
                        ?>
                </div>    
                    <?php
                    }
                    ?>
    </div>
        <?php }else{echo "No data to display";} ?>
</div>

<div class='contentheading'>Medical preparations Tracking</div>  
<div class='tabContainer2' style="background-color:#E1FFE3">
        <?php
        if($this->content !== null){
        foreach ($this->content as $key => $value) {
            $phases_d[] = $key; 
            $drug = $value[drug][val][name];
            $status_d[] = $value[drug][val][status];
        }
        ?>
        <div>
            <div><span>Drugs/Phases</span>
                <?php
                    for($i = 0; count($phases_d)>$i; $i++){
                        $dr = $i;
                        echo "-<span>Phase ".++$dr."</span>";
                    }
                ?>
            </div>
                <?php
                for($i = 0; count($drug)>$i; $i++){
                    ?>
                <div>
                        <?php
                        foreach($list[medtrackList] as $value)
                        {
                            if($value[id] == $drug[$i])
                            {
                                echo "<span>".$value[name]."</span>";
                            }
                        }
                        foreach ($status_d as $value) {
                            if($value[$i] == ""){
                                echo "-<span>no status</span>";
                            }else{
                                echo "-<span>".$value[$i]."</span>";
                            }
                        }
                        ?>
                </div>    
                    <?php
                    }
                    ?>
    </div>
    <?php }else{echo "No data to display";} ?>
</div>

<div class='contentheading'>Diseases Tracking</div>  
<div class='tabContainer2' style="background-color:#E1FFE3">
        <?php
        if($this->content !== null){       
        foreach ($this->content as $key => $value) {
            
            $phases_di[] = $key; 
            $diseases = $value[diseases][val][name];
            $status_di[] = $value[diseases][val][status];
        }
        ?>
        <div>
            <div><span>Diseases/Phases</span>
                <?php
                    for($i = 0; count($phases_di)>$i; $i++){
                        $di = $i;
                        echo "-<span>Phase ".++$di."</span>";
                    }
                ?>
            </div>
                <?php
                for($i = 0; count($diseases)>$i; $i++){
                    ?>
                <div>
                        <?php
                        foreach($list[diseasesList] as $value)
                        {
                            if($value[id] == $diseases[$i])
                            {
                                echo "<span>".$value[name]."</span>";
                            }
                        }


                        foreach ($status_di as $value) {
                            if($value[$i] == ""){
                                echo "-<span>no status</span>";
                            }else{
                                echo "-<span>".$value[$i]."</span>";
                            }
                        }
                        ?>
                </div>    
                    <?php
                    }
                    ?>
    </div>
    <?php }else{echo "No data to display";} ?>
</div>

<div class='contentheading'>Photo History</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    
    <div class='contentheading'><?="Intake photo"?></div>
    <div class='current-photo'>
        <?= "<div class='photo-one'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$gols[photo][val][0]."\" width=\"200\" height=\"350\"></div>";?>
        <?= "  <div class='photo-two'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$gols[photo][val][1]."\" width=\"200\" height=\"350\"></div>";?>
    </div>
    <?php
        if($this->content !== null && $this->content != ""){
                foreach ($this->content as $key => $value) {
                    ?>
                    <div class='contentheading'><?=$key?></div>
                    <div class='current-photo'>
                    <?= "<div class='photo-one'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$value[photo][val][0]."\" width=\"200\" height=\"350\"></div>";?>
                    <?= "  <div class='photo-two'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$value[photo][val][1]."\" width=\"200\" height=\"350\"></div>";?>
                    </div>
                    <?php
                }
            }
    ?>
</div>


<?php           
                
                
                

?>















<script type="text/javascript" src="https://www.google.com/jsapi"></script>

 <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$d?>);

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
        var data = google.visualization.arrayToDataTable(<?=$d1?>);

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
        var data = google.visualization.arrayToDataTable(<?=$d2?>);

        var options = {
          title: 'PH History',
         // hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
          //vAxis: {minValue: 0}
		  
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div_3'));
        chart.draw(data, options);
      }
    </script>
    
