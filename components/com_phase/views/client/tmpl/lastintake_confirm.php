<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php
$uid = $this->uid;
$pid = 0;

$loockingfor = $this->loockingfor;
?>


<?php
if($this->evalution)
{
  $evalution = $this->evalution;  
  
}
if($this->allergiesList)
{
    $allergiesList = $this->allergiesList;
}
  if($this->symptomList)
{
    $symptomList = $this->symptomList;
}
if($this->medtrackList)
{
    $medtrackList = $this->medtrackList;
}
if($this->diseasesList)
{
    $diseasesList = $this->diseasesList;
}  
?>


<form action="index.php?option=com_phase&controller=client&inc=1"  method="post" enctype="multipart/form-data">    
 
<input type="hidden" name="evalution[pid]" value="<?=$pid?>" />
<input type="hidden" name="evalution[uid]" value="<?=$uid?>" />



<div class='contentheading'>Client goals</div>
<div class='goals horizontal-shadow'>

    <?php if(isset($this->evalution[goals][weight]) && $this->evalution[goals][weight] !== ""){?>
        <div class="data-result">
            <span class="value-name"><?="Target Weight: "?></span> <span class="value"><?=$this->evalution[goals][weight]." lbs."?></span>
        </div>

    <?php
    }

    if(isset($this->evalution[goals][fat]) && $this->evalution[goals][fat] !== ""){?>
        <div class="data-result">
            <span class="value-name"><?="Target Body Fat: "?></span> <span class="value"><?=$this->evalution[goals][fat]." %"?></span>
        </div>
    <?php
    }
    ?>

    <table>
        <?php
        if($this->loockingfor && count($this->loockingfor) !== 0){ ?>
            <tr>
                <?php
                $cnt = 1;
                foreach($this->loockingfor as $value){
                    ?>
                    <td style='border:1px solid #EEE;padding:3px;' align="center" ><input type="checkbox" name="evalution[goals][question][]" value="<?=$value['id'];?>" <?php if(isset($this->evalution[goals][question])){ if(in_array($value['id'],$this->evalution[goals][question])) {echo "checked";}} ?>></td>
                    <td style='border:1px solid #EEE;padding:3px;'><?=$value['var'];?></td>
                    <?php
                    if($cnt % 4 == 0)
                    {
                        echo "</tr><tr>\n";
                    }
                    $cnt++;
                }
                ?>
            </tr>
        <?php } ?>
    </table>
</div>




<div class='contentheading'>Body stats</div>    
<div class='goals horizontal-shadow'>

                
        <div class="data-result">
            <span class="value-name"><?="Sex"?></span>
            <span class="value"><?php if(isset($evalution[stats][sex])){echo $evalution[stats][sex];}?></span>
        </div>
    <div class="data-result">
        <span class="value-name"><?="Height"?></span>   
        <span class="value"><?php if(isset($evalution[stats][heigth][0])){ echo $evalution[stats][heigth][0];} ?><?=" ft "?><?php if(isset($evalution[stats][heigth][0])){ echo $evalution[stats][heigth][1];} ?><?=" inches"?></span>
    </div>
    
    <div class="data-result">
        <span class="value-name"><?="Weight"?></span>
        <span class="value"><?php if(isset($evalution[stats][weight])){ echo $evalution[stats][weight];} ?><?="lbs"?></span>
    </div>
    
    <div class="data-result">
        <span class="value-name"><?="Body Fat"?></span>
        <span class="value"><?php if(isset($evalution[stats][fat])){ echo $evalution[stats][fat];} ?><?="%"?></span>
    </div>
    
    <div class="data-result">
        <span class="value-name"><?="PH"?></span>
        <span class="value"><?php if(isset($evalution[stats][ph])){ echo $evalution[stats][ph];} ?></span>
    </div>
    
    <div class="data-result">
        <span class="value-name"><?="Blood Pressure"?></span>
        <span class="value"><?php if(isset($evalution[stats][blod_pressure][0])){ echo $evalution[stats][blod_pressure][0];} ?><?=" / "?><?php if(isset($evalution[stats][blod_pressure][0])){ echo $evalution[stats][blod_pressure][1];} ?></span>
    </div>

    <div class="data-result">
        <span class="value-name"><?="Blood Type"?></span>
        <span class="value">
            <?php
            if(isset($evalution[stats][blood_type])){echo $evalution[stats][blood_type];}
            ?>
        </span>
    </div>


</div>



    <div class='contentheading'>Body Type</div>
    <div class='body-type horizontal-shadow'>

        <?php if($this->evalution[body_type][0] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="1. Bone structure"?></span>
            <span class="value"><?php echo $evalution[body_type][bone]; ?></span>
        </div>
            <?php }
        
        if($this->evalution[body_type][1] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="2. Muscle type"?></span>
            <span class="value"><?php echo $evalution[body_type][muscle]; ?></span>
        </div>
            <?php }
        
        if($this->evalution[body_type][2] !== ""){?>
        <div class="data-result">
                <span class="value-name"><?="3. Tendency to gain weight"?></span>
            <span class="value"><?php echo $evalution[body_type][weigth];?></span>
        </div>
            <?php }
        
        if($this->evalution[body_type][3] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="4. Describe yourself, knowing your age"?></span>
            <span class="value"><?php echo $evalution[body_type][age];?></span>
        </div>
            <?php }
        
        if($this->evalution[body_type][4] !== ""){ ?>
        <div class="data-result">
            <span class="value-name"><?="5. Risk of heart disease"?></span>
            <span class="value"><?php echo $evalution[body_type][disease]; ?></span>
        </div>
            <?php } ?>
        <div class="data-result">
            <span class="value-name"><?="6. Body shape that most resembles you own"?></span>
        </div>
        <div class="body-type-photo">
        <?php
            if($evalution[body_type][own] == "fat.png"){echo "  <div style='font-size:15px;color:#008;'>
            <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."fat.png"."\" width=\"200\" height=\"350\">
            </div>";}
            ?>
            <?php
            if($evalution[body_type][own] == "normal.png"){echo "  <div style='font-size:15px;color:#008;'> 
            <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."normal.png"."\" width=\"200\" height=\"350\">
            </div>";}
            ?>
            <?php
            if($evalution[body_type][own] == "toll.png"){echo "  <div style='font-size:15px;color:#008;'>
            <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."toll.png"."\" width=\"200\" height=\"350\">
            </div>";}
            ?> 
        </div>









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

    <div class='contentheading'>Current Photo</div>
    <div class='current-photo'>

        <?php
if($evalution[file][name][0])
{
?>
<input type="hidden" name="evalution[file][name][0]" value="<?=$evalution[file][name][0]?>" />
<?php
echo "<div class='photo-one'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution[file][name][0]."\" width=\"200\" height=\"350\"></div>";
}
else
{
echo "<div class='photo-one'>
        <img src=\"".JURI::root().'uploads_jtpl/phase_details/'."no1.png"."\" width=\"200\" height=\"350\">
        </div>";        
}
?>

        <?php
if($evalution[file][name][1])
{
?>
<input type="hidden" name="evalution[file][name][1]" value="<?=$evalution[file][name][1]?>" />

        
<?php
echo "  <div class='photo-two'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution[file][name][1]."\" width=\"200\" height=\"350\"></div>";
}
else
{
echo "  <div class='photo-two'>
        <img src=\"".JURI::root().'uploads_jtpl/phase_details/'."no2.png"."\" width=\"200\" height=\"350\">
        </div>";        
}
?>  








</div>      
      
<div class='contentheading'>Medical Tracking</div>    
<div class='tabContainer2' style="background-color:#E1FFE3">  


    <table>
        <tr>
            <td><?="1. When was your last physical exam ?"?></td>
            <td> <input type="text" name="evalution[madtrack][exem]" size="10" value="<?php if(isset($evalution[madtrack][exem])){ echo $evalution[madtrack][exem];} ?>" /><?="<br>"?></td>
            <td></td>
        </tr>
        <tr>
            <td><?="2. Are you currently undermedical treatment ?"?></td>
            <td>
                <select name="evalution[madtrack][treatment][status]">
                    <option <?php if($evalution[madtrack][treatment][status] == 'Yes'){echo 'selected ';} ?>  value='Yes'>Yes</option>
                    <option <?php if($evalution[madtrack][treatment][status] == 'NO'){echo 'selected ';} ?>   value='NO'>NO</option>
                </select> 
            </td>
            <td><input type="text" name="evalution[madtrack][treatment][note]" size="40"  value="<?php if(isset($evalution[madtrack][treatment][note])){ echo $evalution[madtrack][treatment][note];}else{echo "If YES explain";} ?>" /></td>
        </tr>
        <tr>
            <td><?="3. Have you ever had any seriousillness or operations ?"?></td>
            <td>
                <select name="evalution[madtrack][operations][status]">
        <option <?php if($evalution[madtrack][operations][status] == 'Yes'){echo 'selected ';} ?> value='Yes'>Yes</option>
        <option <?php if($evalution[madtrack][operations][status] == 'NO'){echo 'selected ';} ?>  value='NO'>NO</option>
        </select>
            </td>
            <td>        <input type="text" size="40"  name="evalution[madtrack][operations][note]" value="<?php if(isset($evalution[madtrack][operations][note])){ echo $evalution[madtrack][operations][note];}else{echo "If YES explain";} ?>" /></td>
        </tr>
        <tr>
            <td><?="4. Do you smoke ?"?></td>
            <td>
                <select name="evalution[madtrack][smoke][status]">
        <option <?php if($evalution[madtrack][smoke][status] == 'Yes'){echo 'selected ';} ?> value='Yes'>Yes</option>
        <option <?php if($evalution[madtrack][smoke][status] == 'NO'){echo 'selected ';} ?>  value='NO'>NO</option>
        </select>
            </td>
            <td>        <input type="text" size="40"  name="evalution[madtrack][smoke][note]" value="<?php if(isset($evalution[madtrack][smoke][note])){ echo $evalution[madtrack][smoke][note];}else{echo "If YES explain";} ?>" /></td>
        </tr>
        <tr>
            <td><?="5. Alcohol use ?"?></td>
            <td>
                <select name="evalution[madtrack][alcohol][status]">
        <option <?php if($evalution[madtrack][alcohol][status] == 'Yes'){echo 'selected ';} ?> value='Yes'>Yes</option>
        <option <?php if($evalution[madtrack][alcohol][status] == 'NO'){echo 'selected ';} ?> value='NO'>NO</option>

        </select>
            </td>
            <td>        <input type="text" size="40"  name="evalution[madtrack][alcohol][note]" value="<?php if(isset($evalution[madtrack][alcohol][note])){ echo $evalution[madtrack][alcohol][note];}else{echo "If YES explain";} ?>" /></td>
        </tr>
        <tr>
            <td><?="6. Do you use cocaine or drugs ?"?></td>
            <td>
                <select name="evalution[madtrack][drugs][status]">
                <option <?php if($evalution[madtrack][drugs][status] == 'Yes'){echo 'selected ';} ?> value='Yes'>Yes</option>
                <option <?php if($evalution[madtrack][drugs][status] == 'NO'){echo 'selected ';} ?> value='NO'>NO</option>
                </select>
            </td>
            <td><input type="text" size="40" name="evalution[madtrack][drugs][note]" value="<?php if(isset($evalution[madtrack][drugs][note])){ echo $evalution[madtrack][drugs][note];}else{echo "If YES explain";} ?>" /></td>
        </tr>
    </table>
    
   



    
<div class='contentheading'>Allergies Tracking</div>  
<div class='tabContainer2' style="background-color:#E1FFE3">   
<ul>
<?php
if($evalution[madtrack][allergies][db_list])
{	

	foreach ($allergiesList as $value)
		{
			if(in_array($value['id'],$evalution[madtrack][allergies][db_list]))
			{
				echo "<li>".$value[name]."</li>";
			}
		}
	foreach($evalution[madtrack][allergies][db_list] as $value)
	{
	?>

		<input type="hidden" name="evalution[madtrack][allergies][db_list][]" value="<?= $value ?>" />
	<?php	
	}
}		

if(isset($evalution[madtrack][allergies][extra_list]))
{

	foreach($evalution[madtrack][allergies][extra_list] as $value)
	{
	?>
                <li><?= $value?></li>
		<input type="hidden" name="evalution[madtrack][allergies][extra_list][]" value="<?= $value ?>" />
	<?php	
	}
}		
?>
</ul>

</div>



<div class='contentheading'>Symptoms Tracking</div>   
<div class='tabContainer2' style="background-color:#E1FFE3">   
 <ul>
<?php
if(isset($evalution[madtrack][symptoms][db_list]))
{	

	
	foreach ($symptomList as $value)
		{
			if(in_array($value['id'],$evalution[madtrack][symptoms][db_list]))
			{
				echo "<li>".$value[name]."</li>";
			}
		}
	foreach($evalution[madtrack][symptoms][db_list] as $value)
	{
	?>

		<input type="hidden" name="evalution[madtrack][symptoms][db_list][]" value="<?= $value ?>" />
	<?php	
	}
}		

if(isset($evalution[madtrack][symptoms][extra_list]))
{

	foreach($evalution[madtrack][symptoms][extra_list] as $value)
	{
	?>
                <li><?= $value?></li>
		<input type="hidden" name="evalution[madtrack][symptoms][extra_list][]" value="<?= $value ?>" />
	<?php	
	}
}		
?>
 </ul>
</div>


<div class='contentheading'>Medical preparations Tracking</div>
<div class='tabContainer2' style="background-color:#E1FFE3">   

<ul>
<?php
if(isset($evalution[madtrack][drug][db_list]))
{	

	foreach ($medtrackList as $value)
		{
			if(in_array($value['id'],$evalution[madtrack][drug][db_list]))
			{
				echo "<li>".$value[name]."</li>";
			}
		}
	foreach($evalution[madtrack][drug][db_list] as $value)
	{
	?>

		<input type="hidden" name="evalution[madtrack][drug][db_list][]" value="<?= $value ?>" />
	<?php	
	}
}		

if(isset($evalution[madtrack][drug][extra_list]))
{

	foreach($evalution[madtrack][drug][extra_list] as $value)
	{
	?>
                <li><?= $value?></li>
		<input type="hidden" name="evalution[madtrack][drug][extra_list][]" value="<?= $value ?>" />
	<?php	
	}
}		
?>

</ul>
</div>
    
    
<div class='contentheading'>Diseases Tracking</div>	
<div class='tabContainer2' style="background-color:#E1FFE3">   
<ul>
<?php
if(isset($evalution[madtrack][diseases][db_list]))
{	

    
    
	foreach ($diseasesList as $value)
		{
			if(in_array($value['id'],$evalution[madtrack][diseases][db_list]))
			{
				echo "<li>".$value[name]."</li>";
			}
		}
	foreach($evalution[madtrack][diseases][db_list] as $value)
	{
	?>

		<input type="hidden" name="evalution[madtrack][diseases][db_list][]" value="<?= $value ?>" />
	<?php	
	}
}		

if(isset($evalution[madtrack][diseases][extra_list]))
{

	foreach($evalution[madtrack][diseases][extra_list] as $value)
	{
	?>
		<li><?= $value?></li>
		<input type="hidden" name="evalution[madtrack][diseases][extra_list][]" value="<?= $value ?>" />
	<?php	
	}
}		
?>

</ul>
</div>

</div>     


<button class="button validate" type="submit" value="save" name="action"><?= "Save information" ?></button>




</form>  
