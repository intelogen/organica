<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php
$uid = $this->uid;
$pid = $this->pid;
?>


<?php
if (isset($this->data))
{
    $data = $this->data;
}
?>

<div class='tabContainer2 phase-navigation' style="background-color:#E1FFE3"></div>

<div class='contentheading'>Intake Survey</div>   
<div class='tabContainer2' style="background-color:#E1FFE3">
<form action="index.php?option=com_phase&controller=client&ph=1"  method="post" enctype="multipart/form-data">    
 
<input type="hidden" name="evalution[pid]" value="<?=$pid?>" />
<input type="hidden" name="evalution[uid]" value="<?=$uid?>" />


        
<div class='contentheading'>Lifestyle analysis</div>    
<div class='tabContainer2' style="background-color:#E1FFE3">    
<?php
//lifestyle
if($data[questionList])
{
?>
        <table class="allleft">
        <tr>
            
        <?php
        $cnt = 1;
            
            foreach($data[questionList] as $value):

            
            ?>
            <td style='border:1px solid #EEE;padding:3px;' align="center"><input type="checkbox" name="data[content][life_style][val][]"<?php if(isset($data[content][life_style][val])){if(in_array($value['id'],$data[content][life_style][val])){echo "checked";}}?> value="<?=$value['id'];?>"></td>
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
}
?>
    
<?php
//chart
if($this->trackingStart)
{

//echo $this->trackingStart->cats;
$this->trackingStart->cats = '["Digestive","Intestinal","Circulatory","Nervous","Immune","Respiratory","Urinary","Glandular","Structural"]';
?>
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
<?php
}
?>
</div>


<div class='contentheading'>Body Tracking</div>    
<div class='tabContainer2' style="background-color:#E1FFE3">
   <table width="50%">
    <tr>
        <td><?="Weight"?></td>
        <td><input type="text" name="data[content][body][val][0]" size="2" value="<?php if(isset($data[content][body][val][0])){ echo $data[content][body][val][0];} ?>" /><?="lbs"?></td>
    </tr>
    <tr>
        <td><?="Body Fat"?></td>
        <td><input type="text" name="data[content][body][val][1]" size="1" value="<?php if(isset($data[content][body][val][1])){ echo $data[content][body][val][1];} ?>" /><?="%"?></td>
    </tr>
    <tr>
        <td><?="PH"?></td>
        <td><input type="text" name="data[content][body][val][2]" size="1" value="<?php if(isset($data[content][body][val][2])){ echo $data[content][body][val][2];} ?>" /><?="%"?></td>
    </tr>
    
</table> 
    
    
</div>    


<div class='contentheading'>Current Photo</div>    
<div class='tabContainer2' style="background-color:#E1FFE3"> 
<table>
<tr>
    <td>
        <?php
        if($data[content][photo][0])
        {
            ?>
            <input type="hidden" name="data[content][photo][0]" value="<?=$data[content][photo][0]?>" />
            <?php
            echo "  <div style='font-size:15px;color:#008;'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$data[content][photo][0]."\" width=\"200\" height=\"350\"></div>";
        }
        else
        {
            echo "  <div style='font-size:15px;color:#008;'>
                    <img src=\"".JURI::root().'uploads_jtpl/phase_details/'."no1.png"."\" width=\"200\" height=\"350\">
                    </div>";        
        }
        ?>
        <input type='file' name="data[content][new_photo][0]" />     
    </td>
    <td>
        <?php
        if($data[content][photo][1])
        {
            ?>
            <input type="hidden" name="data[content][photo][1]" value="<?=$data[content][photo][1]?>" />
            <?php
            echo "  <div style='font-size:15px;color:#008;'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$data[content][photo][1]."\" width=\"200\" height=\"350\"></div>";
        }
        else
        {
            echo "  <div style='font-size:15px;color:#008;'>
                    <img src=\"".JURI::root().'uploads_jtpl/phase_details/'."no2.png"."\" width=\"200\" height=\"350\">
                    </div>";        
        }
        ?>
        <input type='file' name="data[content][new_photo][1]" />
    </td>
</tr>
    
    
    </table>
</div>      
 
 
 
 
 
<div class='contentheading'>Medical Tracking</div>    
<div class='tabContainer2' style="background-color:#E1FFE3">    


<div class='contentheading'>Symptoms Tracking</div>    
<div class='tabContainer2' style="background-color:#E1FFE3">

<table id="symptoms" border="1">
        <tr>
            <td>Name</td>
            <td>Status</td>
            <td>Note</td>
        </tr>
<?php
if(isset($data[content][symptoms][name]) && $data[content][symptoms][name][0] !== "" && isset($data[symptomList]))
{
?>
        <?php
        for ($i=0; $i < count($data[content][symptoms][name]); $i++)
        {
        ?>
        <tr>
            <td>
            <?php            
            foreach ($data[symptomList] as $value)
            {
            ?>
                <?php
                if($value['id'] == $data[content][symptoms][name][$i])
                {
                ?>    
                    <input type="hidden" name="data[content][symptoms][name][<?=$i?>]" value="<?=$data[content][symptoms][name][$i]?>" />
                    <?=$value[name]?>
                <?php
                }
                ?>
            <?php
            }
            ?>            
            </td>
            <td>
                <select name="data[content][symptoms][status][<?=$i?>]">
                    <option <?php if(isset($data[content][symptoms][status][$i]) && $data[content][symptoms][status][$i] == 'new'){echo "selected";} ?> value= "new" > New </option>
                    <option <?php if(isset($data[content][symptoms][status][$i]) && $data[content][symptoms][status][$i] == 'same'){echo "selected";} ?> value= "same" > Same </option>
                    <option <?php if(isset($data[content][symptoms][status][$i]) && $data[content][symptoms][status][$i] == 'better'){echo "selected";} ?> value= "better" > Better </option>
                    <option <?php if(isset($data[content][symptoms][status][$i]) && $data[content][symptoms][status][$i] == 'worse'){echo "selected";} ?> value= "worse" > Worse </option>
                    <option <?php if(isset($data[content][symptoms][status][$i]) && $data[content][symptoms][status][$i] == 'finished'){echo "selected";} ?> value= "finished" > Finished </option>
                </select>
            </td>
            <td>
                <input type="text" name="data[content][symptoms][note][<?=$i?>]" value="<?php if(isset($data[content][symptoms][note][$i])){echo $data[content][symptoms][note][$i];}else{echo "no info";}?>" />
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
        <tr><td colspan="3">No info was edit yet</td></tr>
<?php
}
?>
</table>

    <?php

    
    if(isset($data[content][extra_symptoms][db_list][name]) && $data[content][extra_symptoms][db_list][name][0] !== "")
    {
    ?>    
    <table border="1">
    <?php
    if(isset($data[content][extra_symptoms][db_list][name]) && $data[content][extra_symptoms][db_list][name][0] !== "" && isset($data[symptomList]))
    {
    ?>
            <?php
            for ($i=0; $i < count($data[content][extra_symptoms][db_list][name]); $i++)
            {
            ?>
            <tr>
                <td>
                <?php            
                foreach ($data[symptomList] as $value)
                {
                ?>
                    <?php
                    if($value['id'] == $data[content][extra_symptoms][db_list][name][$i])
                    {
                    ?>    
                        <input type="hidden" name="data[content][extra_symptoms][db_list][name][<?=$i?>]" value="<?=$data[content][extra_symptoms][db_list][name][$i]?>" />
                        <?=$value[name]?>
                    <?php
                    }
                    ?>
                <?php
                }
                ?>            
                </td>
                <td>
                    <select name="data[content][extra_symptoms][db_list][status][<?=$i?>]">
                        <option  value= "new" > New </option>
                    </select>
                </td>
                <td>
                    <input type="text" name="data[content][extra_symptoms][db_list][note][<?=$i?>]" value="<?php if(isset($data[content][extra_symptoms][db_list][note][$i])){echo $data[content][extra_symptoms][db_list][note][$i];}else{echo "no info";}?>" />
                </td>
            </tr>
            <?php
            }

            ?>
    <?php
    }
    ?>
    </table>
    <?php    
    }
    if(isset($data[content][extra_symptoms][user_list][name]) && $data[content][extra_symptoms][user_list][name][0] !== "")
    {
    ?>    
    <table border="1">
    <?php
    if(isset($data[content][extra_symptoms][user_list][name]) && $data[content][extra_symptoms][user_list][name][0] !== "" && isset($data[symptomList]))
    {
    ?>
            <?php
            for ($i=0; $i < count($data[content][extra_symptoms][user_list][name]); $i++)
            {
            ?>
            <tr>
                <td>
                    <input type="hidden" name="data[content][extra_symptoms][user_list][name][<?=$i?>]" value="<?=$data[content][extra_symptoms][user_list][name][$i]?>" />
                    <?=$data[content][extra_symptoms][user_list][name][$i]?>
                </td>
                <td>
                    <select name="data[content][extra_symptoms][user_list][status][<?=$i?>]">
                        <option  value= "new" > New </option>
                    </select>
                </td>
                <td>
                    <input type="text" name="data[content][extra_symptoms][user_list][note][<?=$i?>]" value="<?php if(isset($data[content][extra_symptoms][user_list][note][$i])){echo $data[content][extra_symptoms][user_list][note][$i];}else{echo "no info";}?>" />
                </td>
            </tr>
            <?php
            }
            ?>
    <?php
    }
    ?>
    </table>
    <?php    
    }  
    ?>
    
<div>
<?="<br>+ Edit New:"?> 
</div>
    
<!--
<?php
if(isset($data[symptomList]))
{
?>
    <div>
		<?= "Choose from the list :";?>
		
		<select name="data[content][extra_symptoms][db_list][new_name][]">
			<option selected value= "" > Click to show </option>
			<?php 
			foreach ($data[symptomList] as $value)
			{
			?>
			<option value="<?= $value[id]?>"><?=$value[name]?></option>
			<?php
			}
			?>   
		</select>
<button class="button validate" type="submit" id="test" value="add" name="action"><?= "Add" ?></button>
    </div>   
<?php    
}
?>
<div>
    <?= "Or, if not found";?>
</div>
<?="+ Add New:"?>
<input type="text" name="data[content][extra_symptoms][user_list][new_name][]" value="<?=null?>" />
<button class="button validate" type="submit" id="test" value="add" name="action"><?= "Add" ?></button>
-->


<div class='tabContainer2' style="background-color:#E1FFE3">   
    
    <!--Название раздела-->
    <div class='contentheading'>Symptoms Tracking</div>
    
    <!--список симптомов-->
    
    <?php
    if(isset($data[symptomList]))
    {
    ?>
        <div>
            

                    <select id="s_list">
                            <?php 
                            foreach ($data[symptomList] as $value)
                            {
                            ?>
                            <option value="<?= $value[id]?>"><?=$value[name]?></option>
                            <?php
                            }
                            ?>   
                    </select>
        
        <!--Кнопка добавления симптомов из списка-->
        <button id="add_s_list">Add</button>
        </div>   
    <?php    
    }
    ?>

    
    
    <!--инпут для собственных симптомов-->
    <div>
        <?="+ Add New:"?>
        <input type="text" id="s_extra"/>
        
        <!--Кнопка добавления своих симптомов-->
        <button id="add_s_extra">Add</button>
    </div>
    
    
    <!--результат выборки-->
    <div id="symptom_list"><ul></ul></div>
    
</div>


</div>




<div class='contentheading'>Medical preparations Tracking</div>
<div class='tabContainer2' style="background-color:#E1FFE3">


<table id="medical" border="1">
        <tr>
            <td>Name</td>
            <td>Status</td>
            <td>Note</td>
        </tr>
<?php
if(isset($data[content][drug][name]) && $data[content][drug][name][0] !== "" && isset($data[medtrackList]))
{
?>
        <?php
        for ($i=0; $i < count($data[content][drug][name]); $i++)
        {
        ?>
        <tr>
            <td>
            <?php            
            foreach ($data[medtrackList] as $value)
            {
            ?>
                <?php
                if($value['id'] == $data[content][drug][name][$i])
                {
                ?>
                    <input type="hidden" name="data[content][drug][name][<?=$i?>]" value="<?=$data[content][drug][name][$i]?>" />
                    <?= $value[name]?>
                <?php
                }
                ?>
            <?php
            }
            ?>            
            </td>
            <td>
                <select name="data[content][drug][status][<?=$i?>]">
                    <option <?php if(isset($data[content][drug][status][$i]) && $data[content][drug][status][$i] == 'new'){echo "selected";} ?> value= "new" > New </option>
                    <option <?php if(isset($data[content][drug][status][$i]) && $data[content][drug][status][$i] == 'same'){echo "selected";} ?> value= "same" > Same </option>
                    <option <?php if(isset($data[content][drug][status][$i]) && $data[content][drug][status][$i] == 'better'){echo "selected";} ?> value= "better" > Better </option>
                    <option <?php if(isset($data[content][drug][status][$i]) && $data[content][drug][status][$i] == 'worse'){echo "selected";} ?> value= "worse" > Worse </option>
                    <option <?php if(isset($data[content][drug][status][$i]) && $data[content][drug][status][$i] == 'finished'){echo "selected";} ?> value= "finished" > Finished </option>
                </select>
            </td>
            <td>
                <input type="text" name="data[content][drug][note][<?=$i?>]" value="<?php if(isset($data[content][drug][note][$i])){echo $data[content][drug][note][$i];}else{echo "no info";}?>" />
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
        <tr><td colspan="3">No info was edit yet</td></tr>
<?php
}
?>
</table>
        <?php

    
    if(isset($data[content][extra_drug][db_list][name]) && $data[content][extra_drug][db_list][name][0] !== "")
    {
    ?>    
    <table border="1">
    <?php
    if(isset($data[content][extra_drug][db_list][name]) && $data[content][extra_drug][db_list][name][0] !== "" && isset($data[medtrackList]))
    {
    ?>
            <?php
            for ($i=0; $i < count($data[content][extra_drug][db_list][name]); $i++)
            {
            ?>
            <tr>
                <td>
                <?php            
                foreach ($data[medtrackList] as $value)
                {
                ?>
                    <?php
                    if($value['id'] == $data[content][extra_drug][db_list][name][$i])
                    {
                    ?>    
                        <input type="hidden" name="data[content][extra_drug][db_list][name][<?=$i?>]" value="<?=$data[content][extra_drug][db_list][name][$i]?>" />
                        <?=$value[name]?>
                    <?php
                    }
                    ?>
                <?php
                }
                ?>            
                </td>
                <td>
                    <select name="data[content][extra_drug][db_list][status][<?=$i?>]">
                        <option  value= "new" > New </option>
                    </select>
                </td>
                <td>
                    <input type="text" name="data[content][extra_drug][db_list][note][<?=$i?>]" value="<?php if(isset($data[content][extra_drug][db_list][note][$i])){echo $data[content][extra_drug][db_list][note][$i];}else{echo "no info";}?>" />
                </td>
            </tr>
            <?php
            }

            ?>
    <?php
    }
    ?>
    </table>
    <?php    
    }
    if(isset($data[content][extra_drug][user_list][name]) && $data[content][extra_drug][user_list][name][0] !== "")
    {
    ?>    
    <table border="1">
    <?php
    if(isset($data[content][extra_drug][user_list][name]) && $data[content][extra_drug][user_list][name][0] !== "" && isset($data[medtrackList]))
    {
    ?>
            <?php
            for ($i=0; $i < count($data[content][extra_drug][user_list][name]); $i++)
            {
            ?>
            <tr>
                <td>
                    <input type="hidden" name="data[content][extra_drug][user_list][name][<?=$i?>]" value="<?=$data[content][extra_drug][user_list][name][$i]?>" />
                    <?=$data[content][extra_drug][user_list][name][$i]?>
                </td>
                <td>
                    <select name="data[content][extra_drug][user_list][status][<?=$i?>]">
                        <option  value= "new" > New </option>
                    </select>
                </td>
                <td>
                    <input type="text" name="data[content][extra_drug][user_list][note][<?=$i?>]" value="<?php if(isset($data[content][extra_drug][user_list][note][$i])){echo $data[content][extra_drug][user_list][note][$i];}else{echo "no info";}?>" />
                </td>
            </tr>
            <?php
            }
            ?>
    <?php
    }
    ?>
    </table>
    <?php    
    }  
    ?>
<div>
<?="<br>+ Edit New:"?> 
</div>

<!--
<?php
if(isset($data[medtrackList]))
{
    
?>
    <div>
    <?= "Choose from the list :";?>
    <select name="data[content][extra_drug][db_list][new_name][]">
        <option selected value= "" > Click to show </option>
    <?php 
    foreach ($data[medtrackList] as $value)
    {
    ?>
        <option value="<?= $value[id]?>"><?=$value[name]?></option>
    <?php
    }
    ?>   
    </select>
<button class="button validate" type="submit" id="test" value="add" name="action"><?= "Add" ?></button>
    </div>
        
    
<?php    
}

?>
<div>
    <?= "Or, if not found";?>
</div>

<?="+ Add New:"?>


<input type="text" name="data[content][extra_drug][user_list][new_name][]" value="<?=null?>" />


<button class="button validate" type="submit" id="test" value="add" name="action"><?= "Add" ?></button>
-->


<div class='tabContainer2' style="background-color:#E1FFE3">   
    
    <!--Название раздела-->
    <div class='contentheading'>Medical preparations Tracking</div>    
<?php
if(isset($data[medtrackList]))
{
    
?>
    <div>
    <?= "Choose from the list :";?>
    <select id="dr_list">
    <?php 
    foreach ($data[medtrackList] as $value)
    {
    ?>
        <option value="<?= $value[id]?>"><?=$value[name]?></option>
    <?php
    }
    ?>   
    </select>
        <button id="add_dr_list">Add</button>
    </div>
        
    
<?php    
}

?>
    <!--инпут для собственных симптомов-->
    <div>
        <?="+ Add New:"?>
        <input type="text" id="dr_extra"/>
        
        <!--Кнопка добавления своих симптомов-->
        <button id="add_dr_extra">Add</button>
    </div>
    
    
    <!--результат выборки-->
    <div id="drug_list"><ul></ul></div>
</div>


</div>











<div class='contentheading'>Diseases Tracking</div>
<div class='tabContainer2' style="background-color:#E1FFE3">
<table id="diseases" border="1">
                <tr>
                    <td>Name</td>
                    <td>Status</td>
                    <td>Note</td>
                </tr>
        <?php
        if(isset($data[content][diseases][name]) && $data[content][diseases][name][0] !== "" && isset($data[diseasesList]))
        {
        ?>
                <?php
                for ($i=0; $i < count($data[content][diseases][name]); $i++)
                {
                ?>
                <tr>
                    <td>
                    <?php            
                    foreach ($data[diseasesList] as $value)
                    {
                    ?>
                        <?php
                        if($value['id'] == $data[content][diseases][name][$i])
                        {
                        ?>
                            <input type="hidden" name="data[content][diseases][name][<?=$i?>]" value="<?=$data[content][diseases][name][$i]?>" />
                            <?=$value[name]?>
                        <?php
                        }
                        ?>
                    <?php
                    }
                    ?>            
                    </td>
                    <td>
                        <select name="data[content][diseases][status][<?=$i?>]">
                            <option <?php if(isset($data[content][diseases][status][$i]) && $data[content][diseases][status][$i] == 'new'){echo "selected";} ?> value= "new" > New </option>
                            <option <?php if(isset($data[content][diseases][status][$i]) && $data[content][diseases][status][$i] == 'same'){echo "selected";} ?> value= "same" > Same </option>
                            <option <?php if(isset($data[content][diseases][status][$i]) && $data[content][diseases][status][$i] == 'better'){echo "selected";} ?> value= "better" > Better </option>
                            <option <?php if(isset($data[content][diseases][status][$i]) && $data[content][diseases][status][$i] == 'worse'){echo "selected";} ?> value= "worse" > Worse </option>
                            <option <?php if(isset($data[content][diseases][status][$i]) && $data[content][diseases][status][$i] == 'finished'){echo "selected";} ?> value= "finished" > Finished </option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="data[content][diseases][note][<?=$i?>]" value="<?php if(isset($data[content][diseases][note][$i])){echo $data[content][diseases][note][$i];}else{echo "no info";}?>" />
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
                <tr><td colspan="3">No info was edit yet</td></tr>
        <?php
        }
        ?>
</table>
    
    
<?php

    if(isset($data[content][extra_diseases][db_list][name]) && $data[content][extra_diseases][db_list][name][0] !== "")
    {
    ?>    
    
    <table border="1">
    <?php
    if(isset($data[content][extra_diseases][db_list][name]) && $data[content][extra_diseases][db_list][name][0] !== "" && isset($data[diseasesList]))
    {
    ?>
            <?php
            for ($i=0; $i < count($data[content][extra_diseases][db_list][name]); $i++)
            {
            ?>
            <tr>
                <td>
                <?php            
                foreach ($data[diseasesList] as $value)
                {
                ?>
                    <?php
                    if($value['id'] == $data[content][extra_diseases][db_list][name][$i])
                    {
                    ?>    
                        <input type="hidden" name="data[content][extra_diseases][db_list][name][<?=$i?>]" value="<?=$data[content][extra_diseases][db_list][name][$i]?>" />
                        <?=$value[name]?>
                    <?php
                    }
                    ?>
                <?php
                }
                ?>            
                </td>
                <td>
                    <select name="data[content][extra_diseases][db_list][status][<?=$i?>]">
                        <option  value= "new" > New </option>
                    </select>
                </td>
                <td>
                    <input type="text" name="data[content][extra_diseases][db_list][note][<?=$i?>]" value="<?php if(isset($data[content][extra_diseases][db_list][note][$i])){echo $data[content][extra_diseases][db_list][note][$i];}else{echo "no info";}?>" />
                </td>
            </tr>
            <?php
            }

            ?>
    <?php
    }
    ?>
    </table>
    
    <?php    
    }
    if(isset($data[content][extra_diseases][user_list][name]) && $data[content][extra_diseases][user_list][name][0] !== "")
    {
    ?>    
    <table border="1">
    <?php
    if(isset($data[content][extra_diseases][user_list][name]) && $data[content][extra_diseases][user_list][name][0] !== "" && isset($data[diseasesList]))
    {
    ?>
            <?php
            for ($i=0; $i < count($data[content][extra_diseases][user_list][name]); $i++)
            {
            ?>
            <tr>
                <td>
                    <input type="hidden" name="data[content][extra_diseases][user_list][name][<?=$i?>]" value="<?=$data[content][extra_diseases][user_list][name][$i]?>" />
                    <?=$data[content][extra_diseases][user_list][name][$i]?>
                </td>
                <td>
                    <select name="data[content][extra_diseases][user_list][status][<?=$i?>]">
                        <option  value= "new" > New </option>
                    </select>
                </td>
                <td>
                    <input type="text" name="data[content][extra_diseases][user_list][note][<?=$i?>]" value="<?php if(isset($data[content][extra_diseases][user_list][note][$i])){echo $data[content][extra_diseases][user_list][note][$i];}else{echo "no info";}?>" />
                </td>
            </tr>
            <?php
            }
            ?>
    <?php
    }
    ?>
    </table>
    <?php    
    }  
    ?>
<div>
    
    
    
<?="<br>+ Edit New:"?> 
</div>
<!--
<?php
if(isset($data[diseasesList]))
{
    
?>
    <div>
    <?= "Choose from the list :";?>
    <select name="data[content][extra_diseases][db_list][new_name][]">
        <option selected value= "" > Click to show </option>
    <?php 
    foreach ($data[diseasesList] as $value)
    {
    ?>
        <option value="<?= $value[id]?>"><?=$value[name]?></option>
    <?php
    }
    ?>   
    </select>
<button class="button validate" type="submit" id="test" value="add" name="action"><?= "Add" ?></button>
    </div>
        
    
<?php    
}

?>
<div>
    <?= "Or, if not found";?>
</div>

<?="+ Add New:"?>


<input type="text" name="data[content][extra_diseases][user_list][new_name][]" value="<?=null?>" />


<button class="button validate" type="submit" id="test" value="add" name="action"><?= "Add" ?></button>

-->

<div class='tabContainer2' style="background-color:#E1FFE3">   
    
    <!--Название раздела-->
    <div class='contentheading'>Diseases Tracking</div>    
<?php
if(isset($data[diseasesList]))
{   
?>
    <div>
    <?= "Choose from the list :";?>
    <select id="d_list">
    <?php 
    foreach ($data[diseasesList] as $value)
    {
    ?>
        <option value="<?= $value[id]?>"><?=$value[name]?></option>
    <?php
    }
    ?>   
    </select>
        <button id="add_d_list">Add</button>
    </div>
        
    
<?php    
}

?>
    <!--инпут для собственных симптомов-->
    <div>
        <?="+ Add New:"?>
        <input type="text" id="d_extra"/>
        
        <!--Кнопка добавления своих симптомов-->
        <button id="add_d_extra">Add</button>
    </div>
    
    
    <!--результат выборки-->
    <div id="diseases_list"><ul></ul></div>
</div>

</div>




</div>

<input type="submit" value="save" name="action"/>

</form>   
</div>











<script type="text/javascript">
    $(function(){
        var x;
        
        //////////////////////////////////////////////////   symptoms
        x = $('button#add_s_list').on('click', function() {
                                                    
                                                    var sel = $('select#s_list option:selected');
                                                    //выбираем id
                                                    var id = sel.val();
                                                    //если id нет возвращаем фолс
                                                    if(id.length < 1)return false;
                                                    //выбираем текст    
                                                    var txt = sel.text();
                                                    //грохаем выбраный елемент   
                                                    sel.remove('');    
                                                    //добавляем текст на страницу в див new_sym_list
                                                    //var div = $('div#symptom_list ul').append("<li>"+txt+"</li>");
                                                    var tbl = $('#symptoms');
                                                    tbl.append('<tr>\n\
                                                                    <td>'+txt+'<input type="hidden" name="data[content][symptoms][name][]" value="'+id+'" /></td>\n\
                                                                    <td> <select name="data[content][symptoms][status][]"> <option  value= "new" >New</option> </select></td>\n\
                                                                    <td><input type="text" name="data[content][symptoms][note][]" value="no info"" /></td>\n\
                                                                </tr>');
                                                     
                                                    //добавляем скрытое поле с значением
                                                    //$('form').append("<input type='hidden' name='data[content][extra_symptoms][db_list][new_name][]' value='"+id+"' />");
                                                    return false;
                                                });
       
        x = $('button#add_s_extra').on('click', function(){
                                                    var sel = $('input[type="text"]#s_extra');
                                                    //выбираем текст
                                                    var txt = sel.val();
                                                    //если текста нет возвращаем фолс
                                                    if(txt.length < 1)return false;
                                                    //добавляем текст на страницу в див new_sym_list
                                                    //var div = $('div#symptom_list ul').append("<li>"+txt+"</li>");
                                                    var tbl = $('#symptoms').append('<tr>\n\
                                                                                        <td>'+txt+' <input type="hidden" name="data[content][extra_symptoms][user_list][name][]" value="'+txt+'" /></td>\n\
                                                                                        <td> <select name="data[content][extra_symptoms][user_list][status][]"> <option  value= "new" >New</option> </select></td>\n\
                                                                                        <td><input type="text" name="data[content][extra_symptoms][user_list][note][]" value="no info"/></td>\n\
                                                                                    </tr>');  
                                                    //добавляем скрытое поле с значением
                                                    //$('form').append("<input type='hidden' name='data[content][extra_symptoms][user_list][new_name][]' value='"+txt+"' />");
                                                    //чистим инпут
                                                    sel.val('');
                                                    return false;
                                                });
        
        
        
        //////////////////////////////////////////////////
        ////////////////////////////////////////////////// medical
        x = $('button#add_dr_list').on('click', function() {
                                                    
                                                    var sel = $('select#dr_list option:selected');
                                                    //выбираем id
                                                    var id = sel.val();
                                                    //если id нет возвращаем фолс
                                                    if(id.length < 1)return false;
                                                    //выбираем текст    
                                                    var txt = sel.text();
                                                    //грохаем выбраный елемент   
                                                    sel.remove('');    
                                                    //добавляем текст на страницу в див new_sym_list
                                                    //var div = $('div#drug_list ul').append("<li>"+txt+"</li>");
                                                    var tbl = $('#medical');
                                                    tbl.append('<tr>\n\
                                                                    <td>'+txt+'<input type="hidden" name="data[content][drug][name][]" value="'+id+'" /></td>\n\
                                                                    <td> <select name="data[content][drug][status][]"> <option  value= "new" >New</option> </select></td>\n\
                                                                    <td><input type="text" name="data[content][drug][note][]" value="no info"" /></td>\n\
                                                                </tr>');
                                                     
                                                    //добавляем скрытое поле с значением
                                                    //$('form').append("<input type='hidden' name='data[content][extra_drug][db_list][new_name][]' value='"+id+"' />");
                                                    return false;
                                                });
       
        x = $('button#add_dr_extra').on('click', function(){
                                                    var sel = $('input[type="text"]#dr_extra');
                                                    //выбираем текст
                                                    var txt = sel.val();
                                                    //если текста нет возвращаем фолс
                                                    if(txt.length < 1)return false;
                                                    //добавляем текст на страницу в див new_sym_list
                                                    //var div = $('div#drug_list ul').append("<li>"+txt+"</li>");
                                                    var tbl = $('#medical').append('<tr>\n\
                                                                                        <td>'+txt+' <input type="hidden" name="data[content][extra_drug][user_list][name][]" value="'+txt+'" /></td>\n\
                                                                                        <td> <select name="data[content][extra_drug][user_list][status][]"> <option  value= "new" >New</option> </select></td>\n\
                                                                                        <td><input type="text" name="data[content][extra_drug][user_list][note][]" value="no info"/></td>\n\
                                                                                    </tr>');    
                                                    //добавляем скрытое поле с значением
                                                    //$('form').append("<input type='hidden' name='data[content][extra_drug][user_list][new_name][]' value='"+txt+"' />");
                                                    //чистим инпут
                                                    sel.val('');
                                                    return false;
                                                });
        
        ///////////////////////////////////////////
        ///////////////////////////////////////////   diseases
        x = $('button#add_d_list').on('click', function() {
                                                    
                                                    var sel = $('select#d_list option:selected');
                                                    //выбираем id
                                                    var id = sel.val();
                                                    //если id нет возвращаем фолс
                                                    if(id.length < 1)return false;
                                                    //выбираем текст    
                                                    var txt = sel.text();
                                                    //грохаем выбраный елемент   
                                                    sel.remove('');    
                                                    //добавляем текст на страницу в див new_sym_list
                                                    //var div = $('div#diseases_list ul').append("<li>"+txt+"</li>");
                                                    var tbl = $('#diseases');
                                                    tbl.append('<tr>\n\
                                                                    <td>'+txt+'<input type="hidden" name="data[content][diseases][name][]" value="'+id+'" /></td>\n\
                                                                    <td> <select name="data[content][diseases][status][]"> <option  value= "new" >New</option> </select></td>\n\
                                                                    <td><input type="text" name="data[content][diseases][note][]" value="no info"" /></td>\n\
                                                                </tr>');
                                                                        
                                                    //добавляем скрытое поле с значением
                                                    //$('form').append("<input type='hidden' name='data[content][extra_diseases][db_list][new_name][]' value='"+id+"' />");
                                                    return false;
                                                });
       
        x = $('button#add_d_extra').on('click', function(){
                                                    var sel = $('input[type="text"]#d_extra');
                                                    //выбираем текст
                                                    var txt = sel.val();
                                                    //если текста нет возвращаем фолс
                                                    if(txt.length < 1)return false;
                                                    //добавляем текст на страницу в див new_sym_list
                                                    //var div = $('div#diseases_list ul').append("<li>"+txt+"</li>");
                                                    var tbl = $('#diseases').append('<tr>\n\
                                                                                        <td>'+txt+' <input type="hidden" name="data[content][extra_diseases][user_list][name][]" value="'+txt+'" /></td>\n\
                                                                                        <td> <select name="data[content][extra_diseases][user_list][status][]"> <option  value= "new" >New</option> </select></td>\n\
                                                                                        <td><input type="text" name="data[content][extra_diseases][user_list][note][]" value="no info"/></td>\n\
                                                                                    </tr>');                        
                                                    //добавляем скрытое поле с значением
                                                    //$('form').append("<input type='hidden' name='data[content][extra_diseases][user_list][new_name][]' value='"+txt+"' />");
                                                    //чистим инпут
                                                    sel.val('');
                                                    return false;
                                                });
        /////////////////////////////////////
      

        
        
        if(x.length > 0) console.log('Селектор есть, кол-во = '+ x.length);
        else console.log('Селектора нет');

        console.log(x);
        
    });
</script>


