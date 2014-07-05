<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>

<form action="index.php?option=com_phase&controller=client&ph=1"  method="post" enctype="multipart/form-data">    
 

    <div class='contentheading'>Body Tracking</div>    
    <div class='tabContainer2' style="background-color:#E1FFE3">
        <table width="50%">
            <tr>
                <td><?="Weight"?></td>
                <td><input type="text" name="data[content][body][val][0]" size="2" value="<?= $this->data[content][body][val][0]?>" /><?=" lbs"?></td>
            </tr>
            <tr>
                <td><?="Body Fat"?></td>
                <td><input type="text" name="data[content][body][val][1]" size="1" value="<?= $this->data[content][body][val][1]?>" /><?=" %"?></td>
            </tr>
            <tr>
                <td><?="PH"?></td>
                <td><input type="text" name="data[content][body][val][2]" size="1" value="<?= $this->data[content][body][val][2]?>" /></td>
            </tr>
        </table> 
    </div>   

    <div class='contentheading'>Lifestyle analysis</div>    
    <div class='tabContainer2' style="background-color:#E1FFE3">    

    <?php
    if($this->data[questionList][0][id] !== ""){?>
            <table class="allleft">
            <tr>
                <?php
                $cnt = 1;
                foreach($this->data[questionList] as $value){?>
                    <td style='border:1px solid #EEE;padding:3px;' align="center"><input type="checkbox" name="data[content][life_style][val][]"<?php if(isset($this->data[content][life_style][val])){if(in_array($value['id'],$this->data[content][life_style][val])){echo "checked";}}?> value="<?=$value['id'];?>"></td>
                    <td style='border:1px solid #EEE;padding:3px;'><?=$value['question'];?></td>
                    <?php
                    if($cnt % 2 == 0) {
                        echo "</tr><tr>\n";
                    }
                    $cnt++;
                }?>
            </tr>
        </table>
    <?php
    }
    ?>
    </div>


        <div class='contentheading'>Current Photo</div>
        <div class='current-photo'>
        <table>
            <tr>
                <td>
                    <?php if($this->data[content][photo][val][0] !== ""){?>
                                <input type="hidden" name="data[content][photo][0]" value="<?=$this->data[content][photo][val][0]?>" />
                                <?php
                                echo "<div class='photo-one'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->data[content][photo][val][0]."\" width=\"200\" height=\"350\"></div>";
                            } else {
                                 echo "<div class='photo-one'>
                                <img src=\"".JURI::root().'uploads_jtpl/phase_details/'."no1.png"."\" width=\"200\" height=\"350\">
                                </div>";        
                            }?>
                    <input type='file' name="data[content][new_photo][0]" />     
                </td>
                <td>
                    <?php if($this->data[content][photo][val][1] !== ""){?>
                                <input type="hidden" name="data[content][photo][1]" value="<?=$this->data[content][photo][val][1]?>" />
                                <?php
                                echo "<div class='photo-two'><img src=\"".JURI::root().'uploads_jtpl/phase_details/'.$this->data[content][photo][val][1]."\" width=\"200\" height=\"350\"></div>";
                            } else {
                                echo "<div class='photo-two'>
                                        <img src=\"".JURI::root().'uploads_jtpl/phase_details/'."no2.png"."\" width=\"200\" height=\"350\">
                                        </div>";        
                            } ?>
                    <input type='file' name="data[content][new_photo][1]" />
                </td>
            </tr>
        </table>
    </div>      



    <div class='contentheading'>Symptoms Tracking</div>    
    <div class='tabContainer2' style="background-color:#E1FFE3">
        <table id="symptoms" border="1">
            <tr>
                <td>Name</td>
                <td>Status</td>
                <td>Note</td>
            </tr>
        <?php if(isset($this->data[content][symptoms][val]) && $this->data[content][symptoms][val][0] !== "" && isset($this->data[symptomList])){

            for ($i=0; $i < count($this->data[content][symptoms][val]); $i++){?>
                <tr>
                    <td>
                    <?php            
                    foreach ($this->data[symptomList] as $value){ ?>
                        <?php
                        if($value['id'] == $this->data[content][symptoms][val][$i]){?>    
                            <input type="hidden" name="data[content][symptoms][name][<?=$i?>]" value="<?=$this->data[content][symptoms][val][$i]?>" />
                            <?=$value[name]?>
                        <?php
                        }
                    }?>            
                    </td>
                    <td>
                        <select name="data[content][symptoms][status][<?=$i?>]">
                            <option <?php if($this->data[content][symptoms][status][$i] == 'same' || $this->data[content][symptoms][status][$i] == 'new'){echo "selected";} ?> value= "same" > Same </option>
                            <option <?php if($this->data[content][symptoms][status][$i] == 'better'){echo "selected";} ?> value= "better" > Better </option>
                            <option <?php if($this->data[content][symptoms][status][$i] == 'worse'){echo "selected";} ?> value= "worse" > Worse </option>
                            <option <?php if($this->data[content][symptoms][status][$i] == 'finished'){echo "selected";} ?> value= "finished" > Finished </option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="data[content][symptoms][note][<?=$i?>]" value="<?=$this->data[content][symptoms][note][$i]?>" />
                    </td>
                </tr>
            <?php
            }
        }else{
        ?>
            <tr><td colspan="3">NO DATA TO DISPLAY</td></tr>
        <?php
        } ?>
        </table>

        <div class='tabContainer2' style="background-color:#E1FFE3">   
            
            <?php if(isset($this->data[symptomList])){?>
                <div>
                    <select id="s_list">
                            <?php 
                            foreach ($this->data[symptomList] as $value){?>
                            <option value="<?= $value[id]?>"><?=$value[name]?></option>
                            <?php } ?>   
                    </select>

                    <!--Кнопка добавления симптомов из списка-->
                    <button id="add_s_list">Add</button>
                </div>   
            <?php    
            }?>

            <div> + Add New:
                <input type="text" id="s_extra"/>

                <!--Кнопка добавления своих симптомов-->
                <button id="add_s_extra">Add</button>
            </div>
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
        <?php if($this->data[content][drug][val][0] !== "" && isset($this->data[medtrackList])){
                    for ($i=0; $i < count($this->data[content][drug][val]); $i++){?>
                        <tr>
                            <td>
                            <?php foreach ($this->data[medtrackList] as $value){
                            ?>
                                <?php
                                if($value['id'] == $this->data[content][drug][val][$i])
                                { ?>
                                    <input type="hidden" name="data[content][drug][name][<?=$i?>]" value="<?=$this->data[content][drug][val][$i]?>" />
                                    <?= $value[name]?>
                                <?php
                                }
                            } ?>            
                            </td>
                            <td>
                                <select name="data[content][drug][status][<?=$i?>]">
                                    <option <?php if($this->data[content][drug][status][$i] == 'same' || $this->data[content][drug][status][$i] == 'new'){echo "selected";} ?> value= "same" > Same </option>
                                    <option <?php if($this->data[content][drug][status][$i] == 'better'){echo "selected";} ?> value= "better" > Better </option>
                                    <option <?php if($this->data[content][drug][status][$i] == 'worse'){echo "selected";} ?> value= "worse" > Worse </option>
                                    <option <?php if($this->data[content][drug][status][$i] == 'finished'){echo "selected";} ?> value= "finished" > Finished </option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="data[content][drug][note][<?=$i?>]" value="<?= $this->data[content][drug][note][$i]?>" />
                            </td>
                        </tr>
                    <?php
                    }
                }else{ ?>
                <tr><td colspan="3">No info was edit yet</td></tr>
                <?php
                } ?>
        </table>
    
        <div class='tabContainer2' style="background-color:#E1FFE3">   

            <!--Название раздела-->
            <?php if(isset($this->data[medtrackList])){ ?>
                <div>
                <select id="dr_list">
            <?php foreach ($this->data[medtrackList] as $value){?>
                <option value="<?= $value[id]?>"><?=$value[name]?></option>
            <?php
            }?>   
            </select>
                <button id="add_dr_list">Add</button>
            </div>


                <?php    
                } ?>
            <!--инпут для собственных симптомов-->
            <div> + Add New:
                <input type="text" id="dr_extra"/>

                <!--Кнопка добавления своих симптомов-->
                <button id="add_dr_extra">Add</button>
            </div>
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
            <?php if($this->data[content][diseases][val][0] !== "" && isset($this->data[diseasesList])){
                    for ($i=0; $i < count($this->data[content][diseases][val]); $i++){?>
                    <tr>
                        <td>
                        <?php            
                        foreach ($this->data[diseasesList] as $value)
                        { ?>
                            <?php
                            if($value['id'] == $this->data[content][diseases][val][$i])
                            {
                            ?>
                                <input type="hidden" name="data[content][diseases][name][<?=$i?>]" value="<?=$this->data[content][diseases][val][$i]?>" />
                                <?=$value[name]?>
                            <?php
                            } 
                        } ?>            
                        </td>
                        <td>
                            <select name="data[content][diseases][status][<?=$i?>]">
                                <option <?php if($this->data[content][diseases][status][$i] == 'same' || $this->data[content][diseases][status][$i] == 'new'){echo "selected";} ?> value= "same" > Same </option>
                                <option <?php if($this->data[content][diseases][status][$i] == 'better'){echo "selected";} ?> value= "better" > Better </option>
                                <option <?php if($this->data[content][diseases][status][$i] == 'worse'){echo "selected";} ?> value= "worse" > Worse </option>
                                <option <?php if($this->data[content][diseases][status][$i] == 'finished'){echo "selected";} ?> value= "finished" > Finished </option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="data[content][diseases][note][<?=$i?>]" value="<?= $this->data[content][diseases][note][$i]?>" />
                        </td>
                    </tr>
                    <?php
                    }
            } else { ?>
                    <tr><td colspan="3">No info was edit yet</td></tr>
            <?php
            } ?>
    </table>



        <div class='tabContainer2' style="background-color:#E1FFE3">   

            <!--Название раздела-->
            <?php if(isset($this->data[diseasesList])) { ?>
                    <div>
                        <select id="d_list">
                        <?php 
                        foreach ($this->data[diseasesList] as $value) { ?>
                            <option value="<?= $value[id]?>"><?=$value[name]?></option>
                        <?php
                        } ?>   
                        </select>
                        <button id="add_d_list">Add</button>
                    </div>
                <?php    
                } ?>
            <!--инпут для собственных симптомов-->
            <div>
                <?="+ Add New:"?>
                <input type="text" id="d_extra"/>
                <!--Кнопка добавления своих симптомов-->
                <button id="add_d_extra">Add</button>
            </div>

        </div>
    </div>

    <input type="hidden" name="evalution[pid]" value="<?=$this->pid?>" />
    <input type="hidden" name="evalution[uid]" value="<?=$this->uid?>" />

    <input type="submit" value="save" name="action"/>

</form>   












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


