<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<?php
$uid = $this->uid;
$pid = 0;
$loockingfor = $this->loockingfor;
?>

<?php
if($this->evalution){
    $evalution = $this->evalution; 
}

if($this->allergiesList){
    $allergiesList = $this->allergiesList;
}

if($this->symptomList){
    $symptomList = $this->symptomList;
}

if($this->medtrackList){
    $medtrackList = $this->medtrackList;
}

if($this->diseasesList){
    $diseasesList = $this->diseasesList;
}
?>


<form action="index.php?option=com_phase&controller=client&in=1"  method="post" enctype="multipart/form-data">    
 
<input type="hidden" name="evalution[pid]" value="<?=$pid?>" />
<input type="hidden" name="evalution[uid]" value="<?=$uid?>" />
    
 
<div class='contentheading'>Client goals</div>   
<div class='goals horizontal-shadow'>
    <?php    
    if($loockingfor):   
    ?>
    
        <div class="data-result">
            <span class="value-name"><?="Target Weight"?></span>
            <input type="text" name="evalution[goals][weight]" size="2"  value="<?php if(isset($evalution[goals][weight])){ echo $evalution[goals][weight];} ?>" /><?="lbs."?>
        </div>
    
        <div class="data-result">
            <span class="value-name"><?="Target Body Fat"?></span>
            <input type="text" name="evalution[goals][fat]" size="2"  value="<?php if(isset($evalution[goals][fat])){ echo $evalution[goals][fat];} ?>" /><?="%"?></span> 
       </div>
        
        
    <table>
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
<div class='goals horizontal-shadow'>
    <div class="data-result">
            <span class="value-name"><?="Sex"?></span>
            <select name="evalution[stats][sex]">
                <option <?php if($evalution[stats][sex] == 'male'){echo 'selected ';} ?>  value='male'>Male</option>
                <option <?php if($evalution[stats][sex] == 'female'){echo 'selected ';} ?> value='female'>Female</option>
            </select>
    </div>
   
    <div class="data-result">
            <span class="value-name"><?="Height"?></span>
            <input type="text" name="evalution[stats][heigth][]" size="2" value="<?php if(isset($evalution[stats][heigth][0])){ echo $evalution[stats][heigth][0];} ?>" /><?="ft"?><input type="text" name="evalution[stats][heigth][]" size="2" value="<?php if(isset($evalution[stats][heigth][0])){ echo $evalution[stats][heigth][1];} ?>" /><?="inches"?>
    </div>
    
    <div class="data-result">
            <span class="value-name"><?="Weight"?></span>
            <input type="text" name="evalution[stats][weight]" size="2" value="<?php if(isset($evalution[stats][weight])){ echo $evalution[stats][weight];} ?>" /><?="lbs"?>
    </div>
    
    <div class="data-result">
            <span class="value-name"><?="Body Fat"?></span>
            <input type="text" name="evalution[stats][fat]" size="1" value="<?php if(isset($evalution[stats][fat])){ echo $evalution[stats][fat];} ?>" /><?="%"?>
    </div>
    
    <div class="data-result">
            <span class="value-name"><?="PH"?></span>
            <input type="text" name="evalution[stats][ph]" size="1" value="<?php if(isset($evalution[stats][ph])){ echo $evalution[stats][ph];} ?>" />
    </div>
    
    <div class="data-result">
            <span class="value-name"><?="Blood Pressure"?></span>
            <input type="text" name="evalution[stats][blod_pressure][]" size="1" value="<?php if(isset($evalution[stats][blod_pressure][0])){ echo $evalution[stats][blod_pressure][0];} ?>" /><?="/"?><input type="text" name="evalution[stats][blod_pressure][]" size="1" value="<?php if(isset($evalution[stats][blod_pressure][0])){ echo $evalution[stats][blod_pressure][1];} ?>" />
    </div>
    
    <div class="data-result">
            <span class="value-name"><?="Blood Type"?></span>
            <select name="evalution[stats][blood_type]">
                <option <?php if($evalution[stats][blood_type] == 'A'){echo 'selected ';} ?> value='A'>A</option>
                <option <?php if($evalution[stats][blood_type] == 'B'){echo 'selected ';} ?>  value='B'>B</option>
                <option <?php if($evalution[stats][blood_type] == 'AB'){echo 'selected ';} ?>   value='AB'>AB</option>
                <option <?php if($evalution[stats][blood_type] == 'O'){echo 'selected ';} ?>    value='O'>O</option>
            </select>
    </div>


</div>



<div class='contentheading'>Body Type</div> <?="Answer the questions below to help us identify your body type<br>"?>   
<div class='tabContainer2' style="background-color:#E1FFE3">    

     
<table>
    <tr>
        <td><?="1. Which best desribes the clients bone structure ?"?></td>
    </tr>
    <tr>
        <td>
            <input type="radio" name="evalution[body_type][bone]" <?php if($evalution[body_type][bone] == 'small'){echo 'checked';} ?>    value="small"> small
            <input type="radio" name="evalution[body_type][bone]" <?php if($evalution[body_type][bone] == 'medium'){echo 'checked';} ?>   value="medium"> medium
            <input type="radio" name="evalution[body_type][bone]" <?php if($evalution[body_type][bone] == 'large'){echo 'checked';} ?>    value="large"> large
        </td>
    </tr>
    <tr>
        <td><?="2. Which best desribes the clients muscle type ?"?></td>
    </tr>
    <tr>
        <td>
            <input type="radio" name="evalution[body_type][muscle]" <?php if($evalution[body_type][muscle] == 'light'){echo 'checked';} ?>  value="light"> light
            <input type="radio" name="evalution[body_type][muscle]" <?php if($evalution[body_type][muscle] == 'hard'){echo 'checked';} ?>   value="hard"> hard
            <input type="radio" name="evalution[body_type][muscle]" <?php if($evalution[body_type][muscle] == 'Under Developed'){echo 'checked';} ?>    value="Under Developed"> Under Developed
        </td>
    </tr>
    <tr>
        <td><?="3. What is the client tendency to gain weight ?"?></td>
    </tr>
    <tr>
        <td>
            <input type="radio" name="evalution[body_type][weigth]" <?php if($evalution[body_type][weigth] == 'hard'){echo 'checked';} ?>   value="hard"> hard
            <input type="radio" name="evalution[body_type][weigth]" <?php if($evalution[body_type][weigth] == 'normal'){echo 'checked';} ?>   value="normal"> normal
            <input type="radio" name="evalution[body_type][weigth]" <?php if($evalution[body_type][weigth] == 'easily'){echo 'checked';} ?>    value="easily"> easily
        </td>
    </tr>
    <tr>
        <td><?="4. Which best desribes the clients apperance, knowing thei age ?"?></td>
    </tr>
    <tr>
        <td>
            <input type="radio" name="evalution[body_type][age]" <?php if($evalution[body_type][age] == 'young'){echo 'checked';} ?>  value="young"> young
            <input type="radio" name="evalution[body_type][age]" <?php if($evalution[body_type][age] == 'older'){echo 'checked';} ?>  value="older"> older
            <input type="radio" name="evalution[body_type][age]" <?php if($evalution[body_type][age] == 'normal'){echo 'checked';} ?> value="normal"> normal</td>
    </tr>
    <tr>
        <td><?="5. Risk of heart disease ?"?></td>
    </tr>
    <tr>
        <td>
            <input type="radio" name="evalution[body_type][disease]" <?php if($evalution[body_type][disease] == 'none'){echo 'checked';} ?>      value="none"> none
            <input type="radio" name="evalution[body_type][disease]" <?php if($evalution[body_type][disease] == 'small to medium'){echo 'checked';} ?> value="small to medium"> small to medium
            <input type="radio" name="evalution[body_type][disease]" <?php if($evalution[body_type][disease] == 'hight'){echo 'checked';} ?> value="hight"> hight
        </td>
    </tr>
    <tr>
        <td><?="6. Select the body shape that most resembles you own."?></td>
    </tr>
    <tr>
        <td>
            <input type="radio" name="evalution[body_type][own]" <?php if($evalution[body_type][own] == "fat.png"){echo 'checked';} ?> value="fat.png"> 1 
            <input type="radio" name="evalution[body_type][own]" <?php if($evalution[body_type][own] == "normal.png"){echo 'checked';} ?> value="normal.png"> 2 
            <input type="radio" name="evalution[body_type][own]" <?php if($evalution[body_type][own] == "toll.png"){echo 'checked';} ?> value="toll.png"> 3 
            <?= "  <div style='font-size:15px;color:#008;'>
        <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."fat.png"."\" width=\"200\" height=\"350\">
        <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."normal.png"."\" width=\"200\" height=\"350\">
        <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."toll.png"."\" width=\"200\" height=\"350\">
                
        </div>";?>   
            
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
    <div class='current-photo'>
<table>
<tr>
    <td>
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
        <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no1.png"."\" width=\"200\" height=\"350\">
        </div>";        
}
?>
<input type='file' name="evalution[new_file][0]" />
    </td>
    <td>
        <?php
if($evalution[file][name][1])
{
?>
<input type="hidden" name="evalution[file][name][1]" value="<?=$evalution[file][name][1]?>" />

        
<?php
echo "<div class='photo-two'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$evalution[file][name][1]."\" width=\"200\" height=\"350\"></div>";
}
else
{
echo "<div class='photo-two'>
        <img src=\"".JURI::root().'uploads_jtpl/phase_img/'."no2.png"."\" width=\"200\" height=\"350\">
        </div>";        
}
?><input type='file' name="evalution[new_file][1]" />    
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
            <td><input type="text" placeholder="If YES explain" name="evalution[madtrack][treatment][note]" size="40" /></td>
        </tr>
        <tr>
            <td><?="3. Have you ever had any seriousillness or operations ?"?></td>
            <td>
                <select name="evalution[madtrack][operations][status]">
        <option <?php if($evalution[madtrack][operations][status] == 'Yes'){echo 'selected ';} ?> value='Yes'>Yes</option>
        <option <?php if($evalution[madtrack][operations][status] == 'NO'){echo 'selected ';} ?>  value='NO'>NO</option>
        </select>
            </td>
            <td>        <input type="text" placeholder="If YES explain" size="40"  name="evalution[madtrack][operations][note]"  /></td>
        </tr>
        <tr>
            <td><?="4. Do you smoke ?"?></td>
            <td>
                <select name="evalution[madtrack][smoke][status]">
        <option <?php if($evalution[madtrack][smoke][status] == 'Yes'){echo 'selected ';} ?> value='Yes'>Yes</option>
        <option <?php if($evalution[madtrack][smoke][status] == 'NO'){echo 'selected ';} ?>  value='NO'>NO</option>
        </select>
            </td>
            <td>        <input type="text" placeholder="If YES explain" size="40"  name="evalution[madtrack][smoke][note]"  /></td>
        </tr>
        <tr>
            <td><?="5. Alcohol use ?"?></td>
            <td>
                <select name="evalution[madtrack][alcohol][status]">
        <option <?php if($evalution[madtrack][alcohol][status] == 'Yes'){echo 'selected ';} ?> value='Yes'>Yes</option>
        <option <?php if($evalution[madtrack][alcohol][status] == 'NO'){echo 'selected ';} ?> value='NO'>NO</option>

        </select>
            </td>
            <td>        <input type="text" placeholder="If YES explain" size="40"  name="evalution[madtrack][alcohol][note]" /></td>
        </tr>
        <tr>
            <td><?="6. Do you use cocaine or drugs ?"?></td>
            <td>
                <select name="evalution[madtrack][drugs][status]">
                <option <?php if($evalution[madtrack][drugs][status] == 'Yes'){echo 'selected ';} ?> value='Yes'>Yes</option>
                <option <?php if($evalution[madtrack][drugs][status] == 'NO'){echo 'selected ';} ?> value='NO'>NO</option>
                </select>
            </td>
            <td><input type="text" placeholder="If YES explain" size="40" name="evalution[madtrack][drugs][note]" /></td>
        </tr>
    </table>
    </div>
   



    
    <div class='contentheading'>Allergies Tracking</div>  
<div class='tabContainer2' style="background-color:#E1FFE3">   



  
    
 
    <div class='tabContainer2' style="background-color:#E1FFE3"> 
<?php
if(isset($allergiesList))
{
?>
    <div>
		<?= "Choose from the list :";?>
		
		<select id="a_list">
			<?php 
			foreach ($allergiesList as $value)
			{
			?>
			<option value="<?= $value[id]?>"><?=$value[name]?></option>
			<?php
			}
			?>   
		</select>
        <button id="add_a_list" ty>Add</button>
    </div>   
<?php    
}
?>
    <!--инпут для собственных симптомов-->
    <div>
        <?="+ Add New:"?>
        <input type="text" id="a_extra"/>
        
        <!--Кнопка добавления своих симптомов-->
        <button id="add_a_extra">Add</button>
    </div>
    
    
    <!--результат выборки-->
    <div id="alergies_list"><ul></ul></div>
</div>

  
    
    <!--Название раздела-->
    <div class='contentheading'>Symptoms Tracking</div>
    <div class='tabContainer2' style="background-color:#E1FFE3"> 
    <!--список симптомов-->
    <?php
    if(isset($symptomList))
    {
    ?>
        <div>
            
Choose from the list :
                    <select id="s_list">
                            <?php 
                            foreach ($symptomList as $value)
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


    
    <!--Название раздела-->
    <div class='contentheading'>Medical preparations Tracking</div>    
    <div class='tabContainer2' style="background-color:#E1FFE3">   
<?php
if(isset($medtrackList))
{
    
?>
    <div>
    <?= "Choose from the list :";?>
    <select id="dr_list">
    <?php 
    foreach ($medtrackList as $value)
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


    
    <!--Название раздела-->
    <div class='contentheading'>Diseases Tracking</div>   
    <div class='tabContainer2' style="background-color:#E1FFE3">   
<?php
if(isset($diseasesList))
{   
?>
    <div>
    <?= "Choose from the list :";?>
    <select id="d_list">
    <?php 
    foreach ($diseasesList as $value)
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



<button class="button validate" type="submit" value="save" name="action"><?= "Save" ?></button>



</form>   




<script type="text/javascript">
    $(function(){
        var x;
        
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
                                                    var div = $('div#symptom_list ul').append("<li>"+txt+"</li>");
                                                    //добавляем скрытое поле с значением
                                                    $('form').append("<input type='hidden' name='evalution[madtrack][symptoms][new_symptoms][name][]' value='"+id+"' />");
                                                    return false;
                                                });
       
       x = $('button#add_s_extra').on('click', function(){
                                                    var sel = $('input[type="text"]#s_extra');
                                                    //выбираем текст
                                                    var txt = sel.val();
                                                    //если текста нет возвращаем фолс
                                                    if(txt.length < 1)return false;
                                                    //добавляем текст на страницу в див new_sym_list
                                                    var div = $('div#symptom_list ul').append("<li>"+txt+"</li>");
                                                    //добавляем скрытое поле с значением
                                                    $('form').append("<input type='hidden' name='evalution[madtrack][symptoms][extra_symptoms][name][]' value='"+txt+"' />");
                                                    //чистим инпут
                                                    sel.val('');
                                                    return false;
                                                });
        
        
        
        x = $('button#add_a_list').on('click', function() {
                                                    
                                                    var sel = $('select#a_list option:selected');
                                                    //выбираем id
                                                    var id = sel.val();
                                                    //если id нет возвращаем фолс
                                                    if(id.length < 1)return false;
                                                    //выбираем текст    
                                                    var txt = sel.text();
                                                    //грохаем выбраный елемент   
                                                    sel.remove('');    
                                                    //добавляем текст на страницу в див new_sym_list
                                                    var div = $('div#alergies_list ul').append("<li>"+txt+"</li>");
                                                    //добавляем скрытое поле с значением
                                                    $('form').append("<input type='hidden' name='evalution[madtrack][allergies][new_allergies][name][]' value='"+id+"' />");
                                                    return false;
                                                });
       
       x = $('button#add_a_extra').on('click', function(){
                                                    var sel = $('input[type="text"]#a_extra');
                                                    //выбираем текст
                                                    var txt = sel.val();
                                                    //если текста нет возвращаем фолс
                                                    if(txt.length < 1)return false;
                                                    //добавляем текст на страницу в див new_sym_list
                                                    var div = $('div#alergies_list ul').append("<li>"+txt+"</li>");
                                                    //добавляем скрытое поле с значением
                                                    $('form').append("<input type='hidden' name='evalution[madtrack][allergies][extra_allergies][name][]' value='"+txt+"' />");
                                                    //чистим инпут
                                                    sel.val('');
                                                    return false;
                                                });
        
        
        
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
                                                    var div = $('div#drug_list ul').append("<li>"+txt+"</li>");
                                                    //добавляем скрытое поле с значением
                                                    $('form').append("<input type='hidden' name='evalution[madtrack][drug][new_drug][name][]' value='"+id+"' />");
                                                    return false;
                                                });
       
       x = $('button#add_dr_extra').on('click', function(){
                                                    var sel = $('input[type="text"]#dr_extra');
                                                    //выбираем текст
                                                    var txt = sel.val();
                                                    //если текста нет возвращаем фолс
                                                    if(txt.length < 1)return false;
                                                    //добавляем текст на страницу в див new_sym_list
                                                    var div = $('div#drug_list ul').append("<li>"+txt+"</li>");
                                                    //добавляем скрытое поле с значением
                                                    $('form').append("<input type='hidden' name='evalution[madtrack][drug][extra_drug][name][]' value='"+txt+"' />");
                                                    //чистим инпут
                                                    sel.val('');
                                                    return false;
                                                });
        
        
        
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
                                                    var div = $('div#diseases_list ul').append("<li>"+txt+"</li>");
                                                    //добавляем скрытое поле с значением
                                                    $('form').append("<input type='hidden' name='evalution[madtrack][diseases][new_diseases][name][]' value='"+id+"' />");
                                                    return false;
                                                });
       
       x = $('button#add_d_extra').on('click', function(){
                                                    var sel = $('input[type="text"]#d_extra');
                                                    //выбираем текст
                                                    var txt = sel.val();
                                                    //если текста нет возвращаем фолс
                                                    if(txt.length < 1)return false;
                                                    //добавляем текст на страницу в див new_sym_list
                                                    var div = $('div#diseases_list ul').append("<li>"+txt+"</li>");
                                                    //добавляем скрытое поле с значением
                                                    $('form').append("<input type='hidden' name='evalution[madtrack][diseases][extra_diseases][name][]' value='"+txt+"' />");
                                                    //чистим инпут
                                                    sel.val('');
                                                    return false;
                                                });
        
        

        
        /*
        if(x.length > 0) console.log('Селектор есть, кол-во = '+ x.length);
        else console.log('Селектора нет');

        console.log(x);
        */
    });
</script>

