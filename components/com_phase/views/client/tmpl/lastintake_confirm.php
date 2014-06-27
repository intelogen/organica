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
        <td><?php if(isset($evalution[stats][heigth][0])){ echo $evalution[stats][heigth][0];} ?><?=" ft "?><?php if(isset($evalution[stats][heigth][0])){ echo $evalution[stats][heigth][1];} ?><?=" inches"?></td>
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
        <td><?php if(isset($evalution[stats][blod_pressure][0])){ echo $evalution[stats][blod_pressure][0];} ?><?=" / "?><?php if(isset($evalution[stats][blod_pressure][0])){ echo $evalution[stats][blod_pressure][1];} ?></td>
    </tr>
    <tr>
        <td><?="Blood Type"?></td>
        <td>
            <?php
            if(isset($evalution[stats][blood_type])){echo $evalution[stats][blood_type];}
            ?>
        </td>
    </tr>
</table>

</div>

<div class='contentheading'>Body Type</div> <?="Answer the questions below to help us identify your body type<br>"?>   
<div class='tabContainer2' style="background-color:#E1FFE3">    

     
<table>
    <tr>
        <td><?="1. Bone structure - "?><?php echo $evalution[body_type][bone]; ?></td>
    </tr>
    <tr>
        <td>
            
        </td>
    </tr>
    <tr>
        <td><?="2. Muscle type  - "?><?php echo $evalution[body_type][muscle]; ?></td>
    </tr>
    <tr>
        <td>
        
        </td>
    </tr>
    <tr>
        <td><?="3. Tendency to gain weight - "?><?php echo $evalution[body_type][weigth];?></td>
    </tr>
    <tr>
        <td>

        </td>
    </tr>
    <tr>
        <td><?="4. Desribes the clients apperance, knowing thei age  - "?><?php echo $evalution[body_type][age];?></td>
    </tr>
    <tr>
        <td>

        </td>
    </tr>
    <tr>
        <td><?="5. Risk of heart disease - "?><?php echo $evalution[body_type][disease]; ?></td>
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

<div class='contentheading'>Current Photo</div>    
<div class='tabContainer2' style="background-color:#E1FFE3"> 
<table>
<tr>
    <td>
        <?php
if($evalution[file][name][0])
{
?>
<input type="hidden" name="evalution[file][name][0]" value="<?=$evalution[file][name][0]?>" />
<?php
echo "  <div style='font-size:15px;color:#008;'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution[file][name][0]."\" width=\"200\" height=\"350\"></div>";
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
if($evalution[file][name][1])
{
?>
<input type="hidden" name="evalution[file][name][1]" value="<?=$evalution[file][name][1]?>" />

        
<?php
echo "  <div style='font-size:15px;color:#008;'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution[file][name][1]."\" width=\"200\" height=\"350\"></div>";
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
<?="Answer the questions below to help us identify your body type<br>"?>
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
    
   



    
    
<div class='tabContainer2' style="background-color:#E1FFE3">   
<div class='contentheading'>Allergies Tracking</div>  






<?php
if($evalution[madtrack][allergies][db_list])
{	

	foreach ($allergiesList as $value)
		{
			if(in_array($value['id'],$evalution[madtrack][allergies][db_list]))
			{
				echo " - ".$value[name]."<br>";
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
		<?= $value."<br>" ?>
		<input type="hidden" name="evalution[madtrack][allergies][extra_list][]" value="<?= $value ?>" />
	<?php	
	}
}		
?>


</div>




<div class='tabContainer2' style="background-color:#E1FFE3">   
<div class='contentheading'>Symptoms Tracking</div>    

<?php
if(isset($evalution[madtrack][symptoms][db_list]))
{	

	
	foreach ($symptomList as $value)
		{
			if(in_array($value['id'],$evalution[madtrack][symptoms][db_list]))
			{
				echo " - ".$value[name]."<br>";
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
		<?= $value."<br>" ?>
		<input type="hidden" name="evalution[madtrack][symptoms][extra_list][]" value="<?= $value ?>" />
	<?php	
	}
}		
?>




</div>


    
<div class='tabContainer2' style="background-color:#E1FFE3">   

<div class='contentheading'>Medical preparations Tracking</div>







<?php
if(isset($evalution[madtrack][drug][db_list]))
{	

	foreach ($medtrackList as $value)
		{
			if(in_array($value['id'],$evalution[madtrack][drug][db_list]))
			{
				echo " - ".$value[name]."<br>";
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
		<?= $value."<br>" ?>
		<input type="hidden" name="evalution[madtrack][drug][extra_list][]" value="<?= $value ?>" />
	<?php	
	}
}		
?>


</div>
    
    
	
<div class='tabContainer2' style="background-color:#E1FFE3">   

<div class='contentheading'>Diseases Tracking</div>






<?php
if(isset($evalution[madtrack][diseases][db_list]))
{	

    
    
	foreach ($diseasesList as $value)
		{
			if(in_array($value['id'],$evalution[madtrack][diseases][db_list]))
			{
				echo " - ".$value[name]."<br>";
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
		<?= $value."<br>" ?>
		<input type="hidden" name="evalution[madtrack][diseases][extra_list][]" value="<?= $value ?>" />
	<?php	
	}
}		
?>



</div>

</div>     


<button class="button validate" type="submit" value="save" name="action"><?= "Save information" ?></button>




</form>  
</div>