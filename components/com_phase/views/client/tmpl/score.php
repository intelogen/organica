<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<?php

$uid = $this->uid;
$pid = $this->pid;

$survey = $this->survey;
?>



<div class='contentheading'>Start survey</div>   
<div class='tabContainer2' style="background-color:#E1FFE3">
<form action="index.php?option=com_phase&controller=client&s=1"  method="post" enctype="multipart/form-data">    

    
<?php //Body score survey ?>
<div class='tabContainer2' style="background-color:#E1FFE3">    
<div class='contentheading'>Body score survey</div>

<?php
$bodyscore = $survey['bodyscore'];
//echo '<pre>';
//var_dump($bodyscore);
?>
    
    <?php
    if($this->questionList):
    $a = array ();
    $i = 0;
    foreach ($this->questionList as $value) 
    : 
    ?>

        <input type="checkbox" name="evaluation[bodycsore][]" value="<?=$value['id']?>" <?php if(in_array($value['id'],$bodyscore['val'])) {echo "checked";} ?> >
        <?=$value['question']?><br>

    <?php
    $i++;
    endforeach;
    endif;
?>
</div>   

    
    
<?php //Body score ?>   
<div class='tabContainer2' style="background-color:#E1FFE3">    
<div class='contentheading'>Body score</div>  

<?php
$body = $survey['body'];
//echo '<pre>';
//var_dump($body);
?>
<?=' Weight '?> <input type="text" name="evaluation[body][weight]" value="<?php if(isset($body['val'][0])){echo $body['val'][0];} else{ echo "";}?>" /> <?='lbs<br>'?>
<?='Body Fat'?> <input type="text" name="evaluation[body][fat]"    value="<?php if(isset($body['val'][0])){echo $body['val'][1];} else{ echo "";}?>" /> <?='%<br>'?>
<?='PH Score'?> <input type="text" name="evaluation[body][ph]"     value="<?php if(isset($body['val'][0])){echo $body['val'][2];} else{ echo "";}?>" />


</div>

    
    
<?php //Current Photo ?>
<div class='tabContainer2' style="background-color:#E1FFE3">    
<div class='contentheading'>Current Photo</div>  
<?php
$photo = $survey['photo'];
//echo '<pre>';
//var_dump($photo['val']);
?>        

 <?php
    if($photo['val']):
    echo "  <div style='font-size:15px;color:#008;'>
        <img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$photo['val'][0]."\" width=\"200\" height=\"350\">
        <img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$photo['val'][1]."\" width=\"200\" height=\"350\">
        </div>";
endif;
?>         
        <input type='file' name="filename1" />
        <input type='file' name="filename2" />

</div>

    
    
    
<?php //Symptoms ?>
<div class='tabContainer2' style="background-color:#E1FFE3">    
<div class='contentheading'>Symptoms Tracking</div>  

<?php
$symptoms = $survey['symptoms'];
echo '<pre>';
var_dump($symptoms['val']);
//var_dump($symptoms['status']);
//var_dump($symptoms['note']);
?>   

<?php

if (isset($symptoms['val']) && !empty($symptoms['val'][0]))
{
    echo 'ssssssssssssssssd';
}
?> 




<?='Add Symptoms'?> 
<input type="text" name="evaluation[new_symptoms][name]" value="<?=null?>" />

<?='Status'?>
<select name="evaluation[new_symptoms][status]">
    <option value='new'>New</option>
</select>

<?='Note'?>
<input type="text" name="evaluation[new_symptoms][note]" value="<?="No info"?>" />

<input type="submit" id="test" value="save" name="action"/>

</div>

    
    
    
<?php //Medical ?>
<div class='tabContainer2' style="background-color:#E1FFE3">    
<div class='contentheading'>Medical Tracking</div>  
<?php
$medical = $survey['medical'];
echo '<pre>';
var_dump($medical['val']);
var_dump($medical['status']);
var_dump($medical['note']);
?>   










<?='Add Medical'?> 
<input type="text" name="evaluation[new_medical][name]" value="<?=null?>" />

<?='Status'?>
<select name="evaluation[new_medical][status]">
    <option value='new'>New</option>
</select>

<?='Note'?>
<input type="text" name="evaluation[new_medical][note]" value="<?="No info"?>" />

<input type="submit" id="test" value="save" name="action"/>

</div>

<?php //Diseases ?>
<div class='tabContainer2' style="background-color:#E1FFE3">    
<div class='contentheading'>Diseases Tracking</div>  
<?php
$diseases = $survey['diseases'];
echo '<pre>';
var_dump($diseases['val']);
var_dump($diseases['status']);
var_dump($diseases['note']);
?>   

<?php
if (isset($diseases['val']) && !empty($diseases['val'][0]))
{
    echo 'ssssssssssssssssd';
}

?>




<?='Add Diseases'?> 
<input type="text" name="evaluation[new_diseases][name]" value="<?=null?>" />

<?='Status'?>
<select name="evaluation[new_diseases][status]">
    <option value='new'>New</option>
</select>

<?='Note'?>
<input type="text" name="evaluation[new_diseases][note]" value="<?="No info"?>" />

<input type="submit" id="test" value="save" name="action"/>

</div>
    
 
    
    
<input type="hidden" name="pid" value="<?=$pid?>" />
<input type="hidden" name="uid" value="<?=$uid?>" />
    
    
<p>
    <input type="submit" id="test" value="save" name="action"/>
</p>    
  

</form>   
</div>