<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');


class PhaseViewClient extends JView
{
    function display($tpl = null){
        $layout = JRequest::getVar('layout');
        if ($layout){
            $this->$layout($tpl);
            return;
        }
        
        
        parent::display($tpl);
    }
    
    // use
    function deshbord($tpl = null){
        $userId = JFactory::getUser()->id;
        $model = $this->getModel();
        $userPhases = $model->getPhases($userId);
        
        if($userPhases !== null && count($userPhases) > 0){
            foreach ($userPhases as $var){   
                $pid[] = $var[id];
            }

            if($pid[0] !== ""){
                $allTaskCnt = $model->taskCnt($pid);
                $this->assignRef('count', $allTaskCnt);

                $finishCountTask = $model->allFinCnt($pid);
                $this->assignRef('finish', $finishCountTask);
            }
        
            $this->assignRef('userPhases', $userPhases);
        }
        
        parent::display($tpl);   
    }
    
    //use
    function show_phases_tasks($tpl = null){
        $phaseId = JRequest::getVar('phase');
        $model = $this->getModel();
        
        //$phaseDesc = $model->getPhasesDesc($phaseId);
        $phDesc = $model->getPhDesc($phaseId);
        $this->assignRef('phaseDesc', $phDesc);
        
        $phasesTasks = $model->getPhasesTasks($phaseId);
        $this->assignRef('phasesTasks', $phasesTasks);
        
        parent::display($tpl);
    }
    
    //use
    function show_tasks($tpl = null){
        $taskId = JRequest::getVar('task');
        $model = $this->getModel();
        $taskData = $model->getTaskData($taskId);
        $this->assignRef('taskData', $taskData);
        
        parent::display($tpl);
    }
    
    //use
    function show_my_coach($tpl = null){
        $userId = JFactory::getUser()->id;
        $model = $this->getModel();
        $coachInfo = $model->coachId($userId);
        $this->assignRef('coachInfo', $coachInfo);
        parent::display($tpl);
    }
    
    //use
    function finish_task(){
        $taskId = JRequest::getVar('taskId');
        $model = $this->getModel();
        $result = $model->finishTask($taskId);
        if ($result){
            $msg = JText::_('Task completed');
        } else{
            $msg = JText::_('Task not completed');
        }
        global $mainframe;
        $mainframe->redirect('index.php?option=com_phase&controller=client&action=deshbord', $msg);
        
        parent::display($tpl);
    }
    
    //use
    function show_my_profile($tpl =null){
        $userId = JFactory:: getUser()->id;
        $model = $this->getModel();
        $myInfo = $model->getMyInfo($userId);
        $this->assignRef('myInfo', $myInfo);
        
        parent::display($tpl);
    }
    
    //use
    function edit_my_info(){
        $model = $this->getModel();
        $result = $model->edit_user_info();
        if ($result){
            $msg = JText::_('Information has been saved');
        }   else{
                $msg = JText::_('Information has not been saved');
            }
        global $mainframe;
        $mainframe->redirect("index.php?option=com_phase&controller=client", $msg);
    }
    
    function first_survey($tpl){
        
        parent::display($tpl);
    }
    
    function your_aim($tpl){
        $model = $this->getModel();
        $aim = $model->getAim();
        $this->assignRef('aim', $aim);
        parent::display($tpl);
    }
            
    //опросс в начале фазы
    function start_survey($tpl = null){
        //графики
        $document =& JFactory::getDocument();
        $document->addStyleSheet(JURI::root().'components/com_hreport/css/autocompleter.css');
        JHTML::script('autocompleter.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('observer.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('progress_tracking.js',JURI::root().'components/com_jforce/js/phase/', true);

        // adding chart
        JHTML::script('jquery-1.7.1.min.js',JURI::root().'components/com_jforce/js/charts/');
        JHTML::script('highcharts.js',JURI::root().'components/com_jforce/js/charts/');
        //графики
        
        $model = $this->getModel();
        $pid = JRequest::getVar('pid');
        $uid = JRequest::getVar('uid');
        
        $cnt = $model->getCnt($pid, $uid);
        $this->assignRef('cnt', $cnt);
        
        
        //проверка на существования ответа на вопросы
        $questionsResult = $model->getQuestionsResult($pid);
        if (count($questionsResult) == 1)
        {
            foreach ($questionsResult as $value)
            {
                $numbers =  $value->val;
                $uqid =  $value->id;
            }
           
            if($numbers == no)
            {
                $uq = $numbers;
            }
            else
            {
                $uq = $model->getUQ($numbers);
            }
            $this->assignRef('uq', $uq);
            $this->assignRef('uqid', $uqid);  
            

            $trackingStart = $model->getProgressTrackingDetails($uid, $pid,$numbers);
            $this->assignRef('trackingStart', $trackingStart);
        }
        
        
        //проверка на существования ответа на степ вес/жир
        $fatResult = $model->getFatResult($pid);
        if (count($fatResult) == 1)
        {
            foreach ($fatResult as $value)
            {
               $fat =  $value->val;
               $fatid = $value->id;
            }
            
            $fat = explode(",", $fat);
            $this->assignRef('fat', $fat); 
            $this->assignRef('fatid', $fatid);  
        }
        
        
        //проверка на существования ответа на фото
        $photoResult = $model->getPhotoResult($pid);
        if (count($photoResult) == 1)
        {
            foreach ($photoResult as $value)
            {
                $photo =  $value->val;
                $photoid = $value->id;
            }
        
            
            $photo = explode(",", $photo);
            
            $this->assignRef('photo', $photo); 
            $this->assignRef('photoid', $photoid);
        }
        
        //проверка на существования ответа на симптомы
        $symptomsResult = $model->getSymptomsResult($pid);
        if (count($symptomsResult) == 1)
        {
            foreach ($symptomsResult as $value)
            {
                $symptomsResult =  $value->val;
                $sid = $value->id;
            }
            
            if($symptomsResult == no)
            {
                $symptoms = $symptomsResult;
            }
            else
            {
                $symptoms = $model->getSymptomsRes($symptomsResult);
            }
            $this->assignRef('symptoms', $symptoms);
            $this->assignRef('sid', $sid);
            
        }
        
        //проверка на существования ответа на препараты
        $medtrackResult = $model->getMedtrackResult($pid);
        if (count($medtrackResult) == 1)
        {
            foreach ($medtrackResult as $value)
            {
            $medtrackResult =  $value->val;
            $mid = $value->id;
            }
            
            if($medtrackResult == no)
            {
                $medtrack = $medtrackResult;
            }
            else
            {
            $medtrack = $model->getMedtrackRes($medtrackResult);
            }

            $this->assignRef('medtrack', $medtrack); 
            $this->assignRef('mid', $mid); 
        }
        
        
        //проверка на существования ответа на заболевания
        $diseasesResult = $model->getDiseasesResult($pid);
        if (count($diseasesResult) == 1)
        {
            foreach ($diseasesResult as $value)
            {
            $diseasesResult =  $value->val;
            $did = $value->id;
            }
            
            if($diseasesResult == no)
            {
                $diseases = $diseasesResult;
            }
            else
            {
            $diseases = $model->getDiseasesRes($diseasesResult);
            }
            $this->assignRef('diseases', $diseases); 
            $this->assignRef('did', $did); 
            
        }
        
        parent::display($tpl);
    }
       
    function body_score_survey($tpl){
        $model = $this->getModel();
        
        $pid = JRequest::getVar('pid');
        
        $questionsResult = $model->getQuestionsResult($pid);
        if (count($questionsResult) == 1)
        {
            foreach ($questionsResult as $value)
            {
                $numbers =  $value->survey_value;
            }
            $content = $model->getUQ($numbers);
            $this->assignRef('content', $content); 
        }
        else
        {
        $questions = $model->getQuestions();
        $this->assignRef('questions', $questions);  
        }
        
        parent::display($tpl);
    }
    
    //кнопка save
    function save($tpl)
    {
        $model = $this->getModel();
        
        //первичный опрос
        //вопросы
        if (JRequest::getVar('start') == 1 and JRequest::getVar('step') == 1)
        {
            
            
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
               
            $step1 = JRequest::get('post');

               
            if(isset($step1[bool]))
            {
                $step1 = $step1[bool];
            }
            else
            {
                $step1 = $step1[evaluation];
            
                if($step1 == null)
                {
                    global $mainframe;
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=body_score_survey&pid=$pid&uid=$uid", "Не отмечен не один пункт");
                }
               
                
                $step1 =  implode(",", $step1);
            }
            
            
            
            
            $time = "s";
            $result = $model->recordStep1($step1, $pid, $uid, $time); 
            
            if ($result)
            {
                $msg = JText::_('data save');
            }
            else
            {
                $msg = JText::_('data not save');
            }
                
            global $mainframe;
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=survey", $msg);
            
        }
        
        //вес жир пш
        if (JRequest::getVar('start') == 1 and JRequest::getVar('step') == 2)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
            $step2 = JRequest::get('post');
            
            if(empty($step2[weight]) or empty($step2[fat]) or empty($step2[ph]))
                {
                    global $mainframe;
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=start_step2&pid=$pid&uid=$uid", "Заполните все поля");
                }
            
            $step2 = $step2[weight].",".$step2[fat].",".$step2[ph];
        
            $time = 's';
            $result = $model->recordStep2($pid, $uid, $step2, $time);
            
                if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                
            
            global $mainframe;
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=survey", $msg);
                 
        }
        
        // фото
        if (JRequest::getVar('start') == 1 and JRequest::getVar('step') == 3)
        {
            
            
            global $mainframe;
            
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
            
            $time = "s";
            
            $result = $model->recordStep3($pid, $uid, $time); 
            
             
               if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                global $mainframe;
                
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=survey", $msg);
        }
        
        // симптомы
        if (JRequest::getVar('start') == 1 and JRequest::getVar('step') == 4)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
             
            $step1 = JRequest::get('post');
            
            if(isset($step1[bool]))
            {
                $step4 = $step1[bool];
            }
            else
            {

            $step1 = $step1[evaluation];
            
            if($step1 == null)
                {
                    global $mainframe;
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=symptoms&pid=$pid&uid=$uid", "Не отмечен не один пункт");
                }
               
            $step4 =  implode(",", $step1);
            
            }
            
            
            $time = "s";
            $result = $model->recordStep4($step4, $pid, $uid, $time); 
               
               if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                global $mainframe;
                
                //$mainframe->redirect("index.php?option=com_phase&controller=client&action=survey", $msg);
            
        }
        
        // препараты
        if (JRequest::getVar('start') == 1 and JRequest::getVar('step') == 5)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
             
            $step1 = JRequest::get('post');
               
            if(isset($step1[bool]))
            {
                $step5 = $step1[bool];
            }
            else
            {
            $step1 = $step1[evaluation];
               
               if($step1 == null)
                {
                    global $mainframe;
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=start_step5&pid=$pid&uid=$uid", "Не отмечен не один пункт");
                }
               
            $step5 =  implode(",", $step1);
                 
            }
            
              
            $time = "s";
            $result = $model->recordStep5($step5, $pid, $uid, $time); 
               
               if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                global $mainframe;
                
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=survey", $msg);
                
                
        }
        
        // заболевания
        if (JRequest::getVar('start') == 1 and JRequest::getVar('step') == 6)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
             
            $step1 = JRequest::get('post');
            
            if(isset($step1[bool]))
            {
                $step6 = $step1[bool];
            }
            else
            {
            $step1 = $step1[evaluation];
            if($step1 == null)
               {
                    global $mainframe;
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=start_step6&pid=$pid&uid=$uid", "Не отмечен не один пункт");
               }
            $step6 =  implode(",", $step1);
                
            }
            
               
               
               $time = "s";
               $result = $model->recordStep6($step6, $pid, $uid, $time);  
               
               if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                global $mainframe;
                
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=survey", $msg);
                
                
        }
        
        // запись результатов после опроса в конце фазы
        if (JRequest::getVar('end') == 1 and JRequest::getVar('step') == 1)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
               
                $step1 = JRequest::get('post');
            
            if(isset($step1[bool]))
            {
                $step1 = $step1[bool];
            }
            else
            {
                $step1 = $step1[evaluation];
                
                if($step1 == null)
                {
                    global $mainframe;
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_body_score_survey&pid=$pid&uid=$uid", "Не отмечен не один пункт");
                }
                
                
                $step1 =  implode(",", $step1);
                
            }
                
                $time = "e";
                $result = $model->recordStep1($step1, $pid, $uid, $time); 
            
                if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                
            global $mainframe;
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_survey&pid=$pid&uid=$uid", $msg);
        
            
        }
        
        // запись результатов после опроса в конце фазы
        if (JRequest::getVar('end') == 1 and JRequest::getVar('step') == 2)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
            $step2 = JRequest::get('post');
            
            if(empty($step2[weight]) or empty($step2[fat]) or empty($step2[ph]))
                {
                    global $mainframe;
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_body_score&pid=$pid&uid=$uid", "Заполните все поля");
                }
            
            $step2 = $step2[weight].",".$step2[fat].",".$step2[ph];
        
            $time = 'e';
            $result = $model->recordStep2($pid, $uid, $step2, $time);
            
                if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                
            
            global $mainframe;
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_survey&pid=$pid&uid=$uid", $msg);
                 
        }
        
        // запись результатов после опроса в конце фазы
        if (JRequest::getVar('end') == 1 and JRequest::getVar('step') == 3)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
             
            global $mainframe;
            
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
            
            $time = "e";
            $result = $model->recordStep3($pid, $uid, $time); 
            
            
               if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                global $mainframe;
                
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_survey&pid=$pid&uid=$uid", $msg);
            
        }
        
        // запись результатов после опроса в конце фазы
        if (JRequest::getVar('end') == 1 and JRequest::getVar('step') == 4)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
             
            $step1 = JRequest::get('post');
            
            if(isset($step1[bool]))
            {
                $step4 = $step1[bool];
            }
            else
            {
                
            
            $step1 = $step1[evaluation];
            
            
            
            if($step1 == null)
                {
                    global $mainframe;
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_symptoms&pid=$pid&uid=$uid", "Не отмечен не один пункт");
                }
            
            
            $step4 =  implode(",", $step1);
            
            }
            
            
                $time = "e";
               $result = $model->recordStep4($step4, $pid, $uid, $time); 
               
               if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                global $mainframe;
                
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_survey&pid=$pid&uid=$uid", $msg);
            
                
                }
        
        // запись результатов после опроса в конце фазы
        if (JRequest::getVar('end') == 1 and JRequest::getVar('step') == 5)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
             
            $step1 = JRequest::get('post');
            
            if(isset($step1[bool]))
            {
                $step5 = $step1[bool];
            }
            else
            {
               $step1 = $step1[evaluation];
               
               if($step1 == null)
                {
                    global $mainframe;
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_medtrack&pid=$pid&uid=$uid", "Не отмечен не один пункт");
                }
               
            $step5 =  implode(",", $step1);
                
            }
               
            $time = "e";
               $result = $model->recordStep5($step5, $pid, $uid, $time); 
               
               if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                global $mainframe;
                
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_survey&pid=$pid&uid=$uid", $msg);
                
                
        }
        
        // запись результатов после опроса в конце фазы
        if (JRequest::getVar('end') == 1 and JRequest::getVar('step') == 6)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
             
            $step1 = JRequest::get('post');
            
            if(isset($step1[bool]))
            {
                $step6 = $step1[bool];
            }
            else
            {
               $step1 = $step1[evaluation];
            if($step1 == null)
               {
                    global $mainframe;
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_diseases&pid=$pid&uid=$uid", "Не отмечен не один пункт");
               }
            $step6 =  implode(",", $step1);
                
            }
            
               
               $time = "e";
               $result = $model->recordStep6($step6, $pid, $uid, $time); 
               
               if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                global $mainframe;
                
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_survey&pid=$pid&uid=$uid", $msg);
        }
        
        if (JRequest::getVar('s') == 1)
        {
            echo '<pre>';
            
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
                         
            
            $file  = JRequest::get("files");
            $file1 = $file["filename1"];
            $file2 = $file["filename2"];
            

            $post = JRequest::get('post');
            $post = $post['evaluation'];

            
            // bodyscore
            $survey['bodycsore']['cat_name'] = "bodyscore";
            $survey['bodycsore']['step'] = 1;
            $survey['bodycsore']['status'] = null;
            $survey['bodycsore']['note'] = null;
            $survey['bodycsore']['id'] = null;
            if(isset($post["bodycsore"]))
            {
                $survey['bodycsore']['val'] = implode(",", $post["bodycsore"]);
            }
            else
            {
                $survey['bodycsore']['val'] = null;
            }
            
            
            //weigth,fat,ph
            $survey['body']['cat_name'] = "body";
            $survey['body']['step'] =2;
            $survey['body']['status'] = null;
            $survey['body']['note'] = null;
            $survey['body']['id'] = null;
            if(isset($post["body"]))
            {
                $survey['body']['val'] = implode(",", $post["body"]);
            }
            else
            {
                $survey['body']['val'] = ",,";
            }
            
            
            //photo1
            $survey['img']['cat_name'] = "photo";
            $survey['img']['step'] = 3;
            $survey['img']['status'] = null;
            $survey['img']['note'] = null;
            $survey['img']['id'] = null;
            if(!empty($file1["name"]))
            {
                $file1_name =$file1["name"];
                $survey['img']['file1']['val'] = $pid."_".$uid."_".time()."_"."_f_".$file1_name;
                $survey['img']['file1']['tmp_path'] =$file1["tmp_name"];
                
            }
            else
            {
                $survey['img']['file1']['val'] = "";
                $survey['img']['file1']['tmp_path'] = "";
            }
            
            //photo2
            if(!empty($file2["name"]))
            {
                $file2_name =$file2["name"];
                $survey['img']['file2']['val'] = $pid."_".$uid."_".time()."_"."_p_".$file2_name;
                $survey['img']['file2']['tmp_path'] =$file2["tmp_name"];
            }
            else
            {
                $survey['img']['file2']['val'] = "";
                $survey['img']['file2']['tmp_path'] = "";
            }
            
            
            //новый симптом
            $survey['symptoms']['cat_name'] = "symptoms";
            $survey['symptoms']['step'] = 4;
            $survey['symptoms']['status'] = null;
            $survey['symptoms']['note'] = null;
            $survey['symptoms']['id'] = null;
            if(!empty($post["new_symptoms"]["name"]))
            {
                $survey['symptoms']['val'] = $post["new_symptoms"]["name"];
                $survey['symptoms']['status'] = $post["new_symptoms"]["status"];
                empty($post["new_symptoms"]["note"]) ? $survey['symptoms']['note'] = "NO info" : $survey['symptoms']['note'] = $post["new_symptoms"]["note"];
            }
            else
            {
                $survey['symptoms']['val'] = null;
                $survey['symptoms']['status'] = null;
                $survey['symptoms']['note'] = null;
            }
            
            
            //новый медикаменты
            $survey['medical']['cat_name'] = "medical";
            $survey['medical']['step'] = 5;
            $survey['medical']['status'] = null;
            $survey['medical']['note'] = null;
            $survey['medical']['id'] = null;
            if(!empty($post["new_medical"]["name"]))
            {
                $survey['medical']['val'] = $post["new_medical"]["name"];
                $survey['medical']['status'] = $post["new_medical"]["status"];
                empty($post["new_medical"]["note"]) ? $survey['medical']['note'] = "NO info" : $survey['medical']['note'] = $post["new_medical"]["note"];
            }
            else
            {
                $survey['medical']['val'] = null;
                $survey['medical']['status'] = null;
                $survey['medical']['note'] = null;
            }
            
            
            //новый заболевания
            $survey['diseases']['cat_name'] = "diseases";
            $survey['diseases']['step'] = 6;
            $survey['diseases']['status'] = null;
            $survey['diseases']['note'] = null;
            $survey['diseases']['id'] = null;
            if(!empty($post["new_diseases"]["name"]))
            {
                $survey['diseases']['val'] = $post["new_diseases"]["name"];
                $survey['diseases']['status'] = $post["new_diseases"]["status"];
                empty($post["new_diseases"]["note"]) ? $survey['diseases']['note'] = "NO info" : $survey['diseases']['note'] = $post["new_diseases"]["note"];
            }
            else
            {
                $survey['diseases']['val'] = null;
                $survey['diseases']['status'] = null;
                $survey['diseases']['note'] = null;
            }
            
            
            $result = $model->recordSurvey($uid, $pid, $survey);
            
            
            global $mainframe;
            if ($result)
            {
                $msg = JText::_('data save');
            }
            else
            {
                $msg = JText::_('data not save');
            }
                
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=score&pid=$pid", $msg);
            
            
            
            
            
        }
        
        
        
        
        
        
        
        
        // первичный опросс
        if(JRequest::getVar('in') == 1){		
            session_start();
            global $mainframe;
            
            $evalution = $this->prepareData();
        
		
            
            if (
                $evalution[goals][weight] == null || 
                $evalution[goals][fat] == null || 
                $evalution[goals][question] == null || 
                $evalution[stats][sex] == null || 
                $evalution[stats][heigth] == null || 
                $evalution[stats][weight] == null || 
                $evalution[stats][fat] == null || 
                $evalution[stats][ph] == null || 
                $evalution[stats][blod_pressure][0] == null || 
                $evalution[stats][blod_pressure][0] == null  ||
                $evalution[stats][blood_type] == null || 
                $evalution[body_type][bone] == null || 
                $evalution[body_type][muscle] == null || 
                $evalution[body_type][weigth] == null || 
                $evalution[body_type][age] == null || 
                $evalution[body_type][disease] == null || 
                $evalution[body_type][own] == null || 
                $evalution[life_style] == null || 
                $evalution[file][name][0] == null || 
                $evalution[file][name][1] == null || 
                $evalution[madtrack][exem] == null || 
                $evalution[madtrack][treatment][status] == null || 
                $evalution[madtrack][operations][status] == null || 
                $evalution[madtrack][smoke][status] == null || 
                $evalution[madtrack][drugs][status] == null
                )
            {
                $_SESSION['evalution'] = $evalution;
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=lastintake","complete all required fields");
            }
            else
            {
                $_SESSION['evalution'] = $evalution;
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=lastintake_confirm","check information and save");
            }
          
		  
			
	}
        
        if(JRequest::getVar('inc') == 1)
        {
			session_start();
			global $mainframe;
			
			if(!empty($_SESSION[evalution]))
			{
			$evalution  = $_SESSION[evalution];
			
			$model = $this->getModel();
			
			$result = $model->recLastintake($evalution);




			if(result)
			{
				unset($_SESSION['evalution']);
				$mainframe->redirect("index.php?option=com_phase&controller=client", 'information has been saved');
			}
			else
			{
				$mainframe->redirect("index.php?option=com_phase&controller=client&action=lastintake");
			}

			  
			  

			}
			else
			{
				$mainframe->redirect("index.php?option=com_phase&controller=client&action=lastintake");
			}
        
        }
        
		
		
		
		
        if(JRequest::getVar('ph') == 1){
            $model = $this->getModel();
            $result =  $this->preparePhasechekDataSave();
            
            global  $mainframe;
            if(result){
                $mainframe->redirect("index.php?option=com_phase&controller=client","new information has been saved");
            }else{
                $mainframe->redirect("index.php?option=com_phase&controller=client","new information is has not survived");
            }
        }
    }
    
    function preparePhasechekDataSave()
    {
        
        $model = $this->getModel();
        $post = JRequest::get('post');
        $date =  date('Y-m-d G:i:s');
        
        $pid = $post[evalution][pid];
        $uid = $post[evalution][uid];
        
        $phases = $model->getAllUserPhases($uid);
        
        foreach ($phases as $value) {
            $cnt_p++;
            if($value[id] == $pid){$pid_n = $cnt_p;;}
        }
        



        
        if(count($post[data][content][life_style][val]) > 0 && $post[data][content][life_style][val][0] !== "")
        {
            $result[life_style] = implode(",", $post[data][content][life_style][val]);
        }
        
        $res = $model->saveLastintake($uid, $pid, "life_style", $result[life_style], null, null, 1, $date);
        if($res == false){return false;}
        
        if(isset($post[data][content][body][val][0]) && isset($post[data][content][body][val][1]) && isset($post[data][content][body][val][2]))
        {
            $result[body] = implode(",", $post[data][content][body][val]);
        }
        $res = $model->saveLastintake($uid, $pid, "body", $result[body], null, null, 2, $date);
        if($res == false){return false;}
        
        
        
        $file  = JRequest::get("files");
        
        if(!empty($file[data][name][content][new_photo][0]))
        {
            $file_1_name = $file[data][name][content][new_photo][0];
            $file_1_name = $post[evalution][pid]."_".$post[evalution][uid]."_".time()."_"."_f_".$file_1_name;
            $file_1_tmp_path = $file[data][tmp_name][content][new_photo][0];
            $result_1 = move_uploaded_file($file_1_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_1_name);
            $post[data][content][photo][0] = $file_1_name;
        }   
        if(!empty($file[data][name][content][new_photo][1]))
        {
            $file_1_name = $file[data][name][content][new_photo][1];
            $file_1_name = $post[evalution][pid]."_".$post[evalution][uid]."_".time()."_"."_f_".$file_1_name;
            $file_1_tmp_path = $file[data][tmp_name][content][new_photo][1];
            $result_1 = move_uploaded_file($file_1_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_1_name);
            $post[data][content][photo][1] = $file_1_name;
        }
        
        
        if(isset($post[data][content][photo][0]) || isset($post[data][content][photo][1]))
        {
            $result[photo] = implode(",", $post[data][content][photo]);
        }
        $res = $model->saveLastintake($uid, $pid, "photo", $result[photo], null, null, 3, $date);
        if($res == false){return false;}
        
        
        
        
        $result[symptoms] = $this->pSympa();

       
        $n_sym = explode(",", $result[symptoms][name]);
        $n_sta = explode(",", $result[symptoms][status]);
        $n_t = array_combine($n_sym, $n_sta);
        
        foreach ($n_t as $key => $value) {
            if($value == "finished"){
                $record_sym = $model->editFinished("#__jf_my_symptoms", $key, $pid_n);
            }
        }
        

        
        $res = $model->saveLastintake($uid, $pid, "symptoms", $result[symptoms][name], $result[symptoms][status], $result[symptoms][note], 4, $date);
        if($res == false){return false;}
        
        
       



        $result[drug] = $this->pDrug();
        
        $n_drug = explode(",", $result[drug][name]);
        $n_drugst = explode(",", $result[drug][status]);
        $n_drug = array_combine($n_drug, $n_drugst);


        
        foreach ($n_drug as $key => $value) {
            if($value == "finished"){
                $record_sym = $model->editFinished("#__jf_my_medtrack", $key, $pid_n);
            }
        }
        $res = $model->saveLastintake($uid, $pid, "drug", $result[drug][name], $result[drug][status], $result[drug][note], 5, $date);
        if($res == false){return false;}
        
        

        $result[diseases] = $this->pDiseases();
        $n_diseases = explode(",", $result[diseases][name]);
        $n_diseasesst = explode(",", $result[diseases][status]);
        $n_diseases = array_combine($n_diseases, $n_diseasesst);
        foreach ($n_diseases as $key => $value) {
            if($value == "finished"){
                $record_sym = $model->editFinished("#__jf_my_diseases", $key, $pid_n);
            }
        }
        
        
        $res = $model->saveLastintake($uid, $pid, "diseases", $result[diseases][name], $result[diseases][status], $result[diseases][note], 6, $date);
        if($res == false){return false;}
        

        return true;
        
    }
    
    function pSympa()
    {
       
        $post = JRequest::get('post');
           
        if(isset($post[data][content][symptoms]) && $post[data][content][symptoms][name][0] !== null)
        {
            $sympa = $post[data][content][symptoms];
            $result[name] = implode(",", $post[data][content][symptoms][name]);
            $result[status] = implode(",", $post[data][content][symptoms][status]);
            $result[note] = implode(",", $post[data][content][symptoms][note]);
        }
        



        
        if(isset($post[data][content][extra_symptoms][db_list]) && $post[data][content][extra_symptoms][db_list][name][0] !== null)
        {
            unset($post[data][content][extra_symptoms][db_list][new_name]);
            $extraSympaDb = $post[data][content][extra_symptoms][db_list];
            $extraSympaDb[name] = implode(",", $post[data][content][extra_symptoms][db_list][name]);
            $extraSympaDb[status] = implode(",", $post[data][content][extra_symptoms][db_list][status]);
            $extraSympaDb[note] = implode(",", $post[data][content][extra_symptoms][db_list][note]);
            if(isset($result[name]) && isset($result[status]) && isset ($result[note]))
            {
                $result[name] = $result[name].",".$extraSympaDb[name];
                $result[status] = $result[status].",".$extraSympaDb[status];
                $result[note] = $result[note].",".$extraSympaDb[note];
            }
            else
            {
                $result[name] = $extraSympaDb[name];
                $result[status] = $extraSympaDb[status];
                $result[note] = $extraSympaDb[note]; 
            }
        }

        if(isset($post[data][content][extra_symptoms][user_list]) && $post[data][content][extra_symptoms][user_list][name][0] !== null)
        {
            unset($post[data][content][extra_symptoms][user_list][new_name]);
            $extraSympaU = $post[data][content][extra_symptoms][user_list];
            $model = $this->getModel();
            
            
            foreach($post[data][content][extra_symptoms][user_list][name] as $value)
			{
				$extra_list[] = $model->recordNewSymptom($value);
			}
            
            $extraSympaU[name] = implode(",", $extra_list);
            $extraSympaU[status] = implode(",", $post[data][content][extra_symptoms][user_list][status]);
            $extraSympaU[note] = implode(",", $post[data][content][extra_symptoms][user_list][note]);
            if(isset($result[name]) && isset($result[status]) && isset ($result[note]))
            {
                $result[name] = $result[name].",".$extraSympaU[name];
                $result[status] = $result[status].",".$extraSympaU[status];
                $result[note] = $result[note].",".$extraSympaU[note];
            }
            else
            {
                $result[name] = $extraSympaU[name];
                $result[status] = $extraSympaU[status];
                $result[note] = $extraSympaU[note]; 
            }
        }
        
        return $result;   
       
    }
    
    function pDrug()
    {
        $post = JRequest::get('post');
        
    
        if(isset($post[data][content][drug]) && $post[data][content][drug][name][0] !== null)
        {
            $sympa = $post[data][content][drug];
            $result[name] = implode(",", $post[data][content][drug][name]);
            $result[status] = implode(",", $post[data][content][drug][status]);
            $result[note] = implode(",", $post[data][content][drug][note]);
        }

        if(isset($post[data][content][extra_drug][db_list]) && $post[data][content][extra_drug][db_list][name][0] !== null)
        {
            unset($post[data][content][extra_drug][db_list][new_name]);
            $extraSympaDb = $post[data][content][extra_drug][db_list];
            $extraSympaDb[name] = implode(",", $post[data][content][extra_drug][db_list][name]);
            $extraSympaDb[status] = implode(",", $post[data][content][extra_drug][db_list][status]);
            $extraSympaDb[note] = implode(",", $post[data][content][extra_drug][db_list][note]);
            if(isset($result[name]) && isset($result[status]) && isset ($result[note]))
            {
                $result[name] = $result[name].",".$extraSympaDb[name];
                $result[status] = $result[status].",".$extraSympaDb[status];
                $result[note] = $result[note].",".$extraSympaDb[note];
            }
            else
            {
                $result[name] = $extraSympaDb[name];
                $result[status] = $extraSympaDb[status];
                $result[note] = $extraSympaDb[note]; 
            }
        }

        if(isset($post[data][content][extra_drug][user_list]) && $post[data][content][extra_drug][user_list][name][0] !== null)
        {
            unset($post[data][content][extra_drug][user_list][new_name]);
            $extraSympaU = $post[data][content][extra_drug][user_list];
            $model = $this->getModel();
            
            
            foreach($post[data][content][extra_drug][user_list][name] as $value)
			{
				$extra_list[] = $model->recordNewDrug($value);
			}
            
            $extraSympaU[name] = implode(",", $extra_list);
            $extraSympaU[status] = implode(",", $post[data][content][extra_drug][user_list][status]);
            $extraSympaU[note] = implode(",", $post[data][content][extra_drug][user_list][note]);
            if(isset($result[name]) && isset($result[status]) && isset ($result[note]))
            {
                $result[name] = $result[name].",".$extraSympaU[name];
                $result[status] = $result[status].",".$extraSympaU[status];
                $result[note] = $result[note].",".$extraSympaU[note];
            }
            else
            {
                $result[name] = $extraSympaU[name];
                $result[status] = $extraSympaU[status];
                $result[note] = $extraSympaU[note]; 
            }
        }
        
        return $result;
  
    }
    
    function pDiseases()
    {
        $post = JRequest::get('post');
        
        
    
        if(isset($post[data][content][diseases]) && $post[data][content][diseases][name][0] !== null)
        {
            $sympa = $post[data][content][drug];
            $result[name] = implode(",", $post[data][content][diseases][name]);
            $result[status] = implode(",", $post[data][content][diseases][status]);
            $result[note] = implode(",", $post[data][content][diseases][note]);
        }

        
        if(isset($post[data][content][extra_diseases][db_list]) && $post[data][content][extra_diseases][db_list][name][0] !== null)
        {
            unset($post[data][content][extra_diseases][db_list][new_name]);
            $extraSympaDb = $post[data][content][extra_diseases][db_list];
            $extraSympaDb[name] = implode(",", $post[data][content][extra_diseases][db_list][name]);
            $extraSympaDb[status] = implode(",", $post[data][content][extra_diseases][db_list][status]);
            $extraSympaDb[note] = implode(",", $post[data][content][extra_diseases][db_list][note]);
            if(isset($result[name]) && isset($result[status]) && isset ($result[note]))
            {
                $result[name] = $result[name].",".$extraSympaDb[name];
                $result[status] = $result[status].",".$extraSympaDb[status];
                $result[note] = $result[note].",".$extraSympaDb[note];
            }
            else
            {
                $result[name] = $extraSympaDb[name];
                $result[status] = $extraSympaDb[status];
                $result[note] = $extraSympaDb[note]; 
            }
        }
        
        
        if(isset($post[data][content][extra_diseases][user_list][name]) && $post[data][content][extra_diseases][user_list][name][0] !== null)
        {
            //unset($post[data][content][extra_diseases][user_list][new_name]);
            $extraSympaU = $post[data][content][extra_diseases][user_list];
            
            $model = $this->getModel();
            
            
            foreach($post[data][content][extra_diseases][user_list][name] as $value)
			{
				$extra_list[] = $model->recordNewDiseases($value);
			}
            
            $extraSympaU[name] = implode(",", $extra_list);
            $extraSympaU[status] = implode(",", $post[data][content][extra_diseases][user_list][status]);
            $extraSympaU[note] = implode(",", $post[data][content][extra_diseases][user_list][note]);
            if(isset($result[name]) && isset($result[status]) && isset ($result[note]))
            {
                $result[name] = $result[name].",".$extraSympaU[name];
                $result[status] = $result[status].",".$extraSympaU[status];
                $result[note] = $result[note].",".$extraSympaU[note];
            }
            else
            {
                $result[name] = $extraSympaU[name];
                $result[status] = $extraSympaU[status];
                $result[note] = $extraSympaU[note]; 
            }
            
                }
        
       return $result;
        
    }
    
    function preparePhaseData()
    {
        $post = JRequest::get('post');
        $evalution = $post[evalution];
        $file  = JRequest::get("files");
        
        
        
        if(!empty($file[evalution][name][new_file][0]))
        {
            $file_1_name = $file[evalution][name][new_file][0];
            $file_1_name = $evalution[pid]."_".$evalution[uid]."_".time()."_"."_f_".$file_1_name;
            $file_1_tmp_path = $file[evalution][tmp_name][new_file][0];
            $result_1 = move_uploaded_file($file_1_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_1_name);
            $evalution[file][0] = $file_1_name;
        }   
        
        if(!empty($file[evalution][name][new_file][1]))
        {
            $file_2_name = $file[evalution][name][new_file][1];
            $file_2_name = $evalution[pid]."_".$evalution[uid]."_".time()."_"."_f_".$file_2_name;
            $file_2_tmp_path = $file[evalution][tmp_name][new_file][1];
            $result_2 = move_uploaded_file($file_2_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_2_name);
            $evalution[file][1] = $file_2_name;
        }   
        return $evalution;
        
    }
    
    function body_score($tpl = null)
    {
        parent::display($tpl);
    }
    
    function body_foto($tpl = null)
    {
        
        parent::display($tpl);
    }
    
    function symptoms($tpl = null)
    {
        $model = $this->getModel();
        $symptoms = $model->getSymptoms();
        $this->assignRef('symptoms', $symptoms);
        parent::display($tpl);
    }
    
    function medtrack($tpl = null)
    {
        $model = $this->getModel();
        $medtrack = $model->getMedtrack();
        $this->assignRef('medtrack', $medtrack);
        parent::display($tpl);
    }
    
    function diseases($tpl = null)
    {
        $model = $this->getModel();
        $diseases = $model->getDiseases();
        $this->assignRef('diseases', $diseases);
        
        parent::display($tpl);
    }
    
    function edit_body_score_survey($tpl = null)
    {
        $model = $this->getModel();
        $questions = $model->getQuestions();
        $this->assignRef('questions', $questions);  
        
        parent::display($tpl);
    }
 
    function edit_body_score($tpl = null)
    {
        $model = $this->getModel();
        
        
        $questions = $model->getQuestions();
        var_dump($questions);
        $this->assignRef('questions', $questions);  
        
        parent::display($tpl);
    }
    
    function edit_body_foto($tpl = null)
    {
        
        parent::display($tpl);
        
        
    }
    
    function edit_symptoms($tpl =null)
    {
        $model = $this->getModel();
        $symptoms = $model->getSymptoms();
        $this->assignRef('symptoms', $symptoms);
        
        parent::display($tpl);
    }
    
    function edit_medtrack($tpl = null)
    {
        $model = $this->getModel();
        $medtrack = $model->getMedtrack();
        $this->assignRef('medtrack', $medtrack);
        parent::display($tpl);
    }
    
    function edit_diseases($tpl = null)
    {
        $model = $this->getModel();
        $diseases = $model->getDiseases();
        $this->assignRef('diseases', $diseases);
        
        
        parent::display($tpl);
    }

    function add($tpl = null)
    {
        // добавление симптомов в лист юзера
        if(JRequest::getVar('task') == add_symptom)
        {
            
            global $mainframe;
            $symptoms = JRequest::get('post');
            $symptom = $symptoms['symptom'];
            $pid = $symptoms['pid'];
            $uid = $symptoms['uid'];
            echo $t = $symptoms['t'];
            
            $model = $this->getModel();
            
            $result = $model->addSymptom($symptom, $uid);
            if ($result)
                {
                if($t == 1)
                    {
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_symptoms&pid=$pid&uid=$uid");
                    }
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=start_step4&pid=$pid&uid=$uid");
                }

        }
        
        // добавление препаратов в лист юзера
        if(JRequest::getVar('task') == add_medtrack)
        {
            global $mainframe;
            $medtrack = JRequest::get('post');
            $uid =  $medtrack['uid'];
            $pid =  $medtrack['pid'];
            $t = $medtrack['t'];
            $medtrack =  $medtrack['medtrack'];
            
            
            
            $model = $this->getModel();
            $result = $model->addMedtrack($medtrack, $uid);
            
            if ($result)
                {
                
                if($t == 1)
                {
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_medtrack&pid=$pid&uid=$uid&t=1");
                }
                
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=start_step5&pid=$pid&uid=$uid");
                }       
            
        }
        
        // добавление заболеваний в лист юзера
        if(JRequest::getVar('task') == add_diseases)
        {
            global $mainframe;
            $diseases = JRequest::get('post');
            $uid =  $diseases['uid'];
            $pid =  $diseases['pid'];
            $t =  $diseases['t'];
            
            $diseases =  $diseases['diseases'];
            
            
            
            
            $model = $this->getModel();
            $result = $model->addDiseases($diseases, $uid);
            
            if ($result)
                {
                if($t == 1)
                {
                   $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_diseases&pid=$pid&uid=$uid&t=1"); 
                }
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=start_step6&pid=$pid&uid=$uid");
                }       
            
        }
        
        // добавление симптомов в лист юзера при редактировании
        if(JRequest::getVar('task') == ed_symptom)
        {
            global $mainframe;
            $symptoms = JRequest::get('post');
            $symptom = $symptoms['symptom'];
            $pid = $symptoms['pid'];
            $uid = $symptoms['uid'];
            $id = JRequest::getVar('id');
            $t =   $symptoms['t'];
            $tempid = JRequest::getVar('tempid');
            
            
            
            $model = $this->getModel();
            $result = $model->addSymptom($symptom, $uid);
            if ($result)
                {
                if($t == 1)
                {
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_symptoms&pid=$pid&uid=$uid&id=$id&t=1");
                }
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_start_step4&pid=$pid&uid=$uid&id=$id&tempid=$tempid");
                }
            
        }
        
        // добавление препаратов в лист юзера при редактировании
        if(JRequest::getVar('task') == ed_medtrack)
        {
            global $mainframe;
            $medtrack = JRequest::get('post');
            $uid =  $medtrack['uid'];
            $pid =  $medtrack['pid'];
            $t = $medtrack['t'];
            $medtrack =  $medtrack['medtrack'];
            $id = JRequest::getVar('id');
            $tempid = JRequest::getVar('tempid');
            
            
            $model = $this->getModel();
            $result = $model->addMedtrack($medtrack, $uid);
            
            if ($result)
                {
                if($t == 1)
                {
                  $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_medtrack&pid=$pid&uid=$uid&id=$id&t=1");  
                }
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_start_step5&pid=$pid&uid=$uid&id=$id&tempid=$tempid");
                }       
            
        }
        
        // добавление заболеваний в лист юзера при редактировании
        if(JRequest::getVar('task') == ed_diseases)
        {
            global $mainframe;
            $diseases = JRequest::get('post');
            $uid =  $diseases['uid'];
            $pid =  $diseases['pid'];
            $t =  $diseases['t'];
            $tempid = JRequest::getVar('tempid');
            
            $diseases =  $diseases['diseases'];
            $id = JRequest::getVar('id');
            
            
            
            $model = $this->getModel();
            $result = $model->addDiseases($diseases, $uid);
            
            if ($result)
                {
                if($t == 1)
                {
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_diseases&pid=$pid&uid=$uid&id=$id&t=1");
                }
                
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_start_step6&pid=$pid&uid=$uid&id=$id&tempid=$tempid");
                }       
            
        }
        
        
        // первичный опросс
        if(JRequest::getVar('in') == 1)
        {
            session_start();
            global $mainframe;
            
            $evalution = $this->prepareData();
            
            
           $_SESSION['evalution'] = $evalution;
            
            
           $mainframe->redirect("index.php?option=com_phase&controller=client&action=lastintake");
            
        }
        
        if(JRequest::getVar('ph') == 1)
        {
            session_start();
            global $mainframe;
           
            
            $data[content] = $this->preparePhasechek();
            
            
            $pid = $data[content][pid];
            
            $_SESSION['data'] = $data[content];
            
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=phasechek&pid=$pid"); 
            
        }
        
        
        parent::display($tpl);
    }
    
    function preparePhasechek()
    {
        $post = JRequest::get(post);
        $data[content] = $post[data][content];
        
        $data[content][pid] = $post[evalution][pid];
        $data[content][uid] = $post[evalution][uid];

        
        $file  = JRequest::get("files");
        
        if(!empty($file[data][name][content][new_photo][0]))
        {
            $file_1_name = $file[data][name][content][new_photo][0];
            $file_1_name = $post[evalution][pid]."_".$post[evalution][uid]."_".time()."_"."_f_".$file_1_name;
            $file_1_tmp_path = $file[data][tmp_name][content][new_photo][0];
            $result_1 = move_uploaded_file($file_1_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_1_name);
            $data[content][photo][0] = $file_1_name;
        }   
        if(!empty($file[data][name][content][new_photo][1]))
        {
            $file_1_name = $file[data][name][content][new_photo][1];
            $file_1_name = $post[evalution][pid]."_".$post[evalution][uid]."_".time()."_"."_f_".$file_1_name;
            $file_1_tmp_path = $file[data][tmp_name][content][new_photo][1];
            $result_1 = move_uploaded_file($file_1_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_1_name);
            $data[content][photo][1] = $file_1_name;
        }
        
        //extra_symptoms
        if(isset($data[content][extra_symptoms][db_list][new_name][0]) && $data[content][extra_symptoms][db_list][new_name][0] !== "")
        {
            $data[content][extra_symptoms][db_list][name][] = $data[content][extra_symptoms][db_list][new_name][0];
            unset($data[content][extra_symptoms][db_list][new_name]);
            unset($data[content][extra_symptoms][user_list][new_name]);
            
        }
        elseif(isset($data[content][extra_symptoms][user_list][new_name][0]) && $data[content][extra_symptoms][user_list][new_name][0] !== "")
        {
            $data[content][extra_symptoms][user_list][name][] = $data[content][extra_symptoms][user_list][new_name][0];
            unset($data[content][extra_symptoms][db_list][new_name]);
            unset($data[content][extra_symptoms][user_list][new_name]);
        }
        else
        {
            unset($data[content][extra_symptoms][db_list][new_name]);
            unset($data[content][extra_symptoms][user_list][new_name]);
        }
            
        //extra_drug
        if(isset($data[content][extra_drug][db_list][new_name][0]) && $data[content][extra_drug][db_list][new_name][0] !== "")
        {
            $data[content][extra_drug][db_list][name][] = $data[content][extra_drug][db_list][new_name][0];
            unset($data[content][extra_drug][db_list][new_name]);
            unset($data[content][extra_drug][user_list][new_name]);
            
        }
        elseif(isset($data[content][extra_drug][user_list][new_name][0]) && $data[content][extra_drug][user_list][new_name][0] !== "")
        {
            $data[content][extra_drug][user_list][name][] = $data[content][extra_drug][user_list][new_name][0];
            unset($data[content][extra_drug][db_list][new_name]);
            unset($data[content][extra_drug][user_list][new_name]);
        }
        else
        {
            unset($data[content][extra_drug][db_list][new_name]);
            unset($data[content][extra_drug][user_list][new_name]);
        }
        
        //extra_diseases
        if(isset($data[content][extra_diseases][db_list][new_name][0]) && $data[content][extra_diseases][db_list][new_name][0] !== "")
        {
            $data[content][extra_diseases][db_list][name][] = $data[content][extra_diseases][db_list][new_name][0];
            unset($data[content][extra_diseases][db_list][new_name]);
            unset($data[content][extra_diseases][user_list][new_name]);
            
        }
        elseif(isset($data[content][extra_diseases][user_list][new_name][0]) && $data[content][extra_diseases][user_list][new_name][0] !== "")
        {
            $data[content][extra_diseases][user_list][name][] = $data[content][extra_diseases][user_list][new_name][0];
            unset($data[content][extra_diseases][db_list][new_name]);
            unset($data[content][extra_diseases][user_list][new_name]);
        }
        else
        {
            unset($data[content][extra_diseases][db_list][new_name]);
            unset($data[content][extra_diseases][user_list][new_name]);
        }
        
        return $data[content]; 
    }
    
    function prepareData()
    {
        $post = JRequest::get('post');
        $evalution = $post[evalution];
		
		
		
		
        $file  = JRequest::get("files");    
            
			
			

                         if(!empty($evalution[madtrack][allergies][new_allergies][name]))
                        {
                            
                            //список id симпомов из базы
                             $evalution[madtrack][allergies][db_list] = $evalution[madtrack][allergies][new_allergies][name];
                        }
			if(!empty($evalution[madtrack][allergies][extra_allergies][name]))
			{
					//список имён новых симпомов
                                $evalution[madtrack][allergies][extra_list] = $evalution[madtrack][allergies][extra_allergies][name];
			}
			
			unset($evalution[madtrack][allergies][new_allergies]);
			unset($evalution[madtrack][allergies][extra_allergies]);
			
                        
                            
			
			
			
			
			
                        if(!empty($evalution[madtrack][symptoms][new_symptoms][name]))
                        {
                                            //список id симпомов из базы
                            $evalution[madtrack][symptoms][db_list] = $evalution[madtrack][symptoms][new_symptoms][name];
                        }
                        if(!empty($evalution[madtrack][symptoms][extra_symptoms][name]))
                        {
                                                //список имён новых симпомов
                                $evalution[madtrack][symptoms][extra_list] = $evalution[madtrack][symptoms][extra_symptoms][name];
                        }

                        unset($evalution[madtrack][symptoms][new_symptoms]);
                        unset($evalution[madtrack][symptoms][extra_symptoms]);

                        
			
                        
                        
                        
                        
			if(!empty($evalution[madtrack][drug][new_drug][name]))
                        {
				//список id симпомов из базы
                              $evalution[madtrack][drug][db_list] = $evalution[madtrack][drug][new_drug][name];
                         }
			if(!empty($evalution[madtrack][drug][extra_drug][name]))
				{
					//список имён новых симпомов
                	$evalution[madtrack][drug][extra_list] = $evalution[madtrack][drug][extra_drug][name];
				}
			
			
			unset($evalution[madtrack][drug][new_drug]);
			unset($evalution[madtrack][drug][extra_drug]);
                        
                        
            
                        
                        

			if(!empty($evalution[madtrack][diseases][new_diseases][name]))
                        {
                                            //список id симпомов из базы
                                $evalution[madtrack][diseases][db_list] = $evalution[madtrack][diseases][new_diseases][name];
                        }
			if(!empty($evalution[madtrack][diseases][extra_diseases][name]))
                        {
					//список имён новых симпомов
                        	$evalution[madtrack][diseases][extra_list] = $evalution[madtrack][diseases][extra_diseases][name];
			}
			
			
			unset($evalution[madtrack][diseases][new_diseases]);
			unset($evalution[madtrack][diseases][extra_diseases]);
                        
                        

			
                        
            if(!empty($file[evalution][name][new_file][0]))
            {
                $file_1_name = $file[evalution][name][new_file][0];
                $file_1_name = $evalution[pid]."_".$evalution[uid]."_".time()."_"."_f_".$file_1_name;
                $file_1_tmp_path = $file[evalution][tmp_name][new_file][0];
                $result_1 = move_uploaded_file($file_1_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_1_name);
                $evalution[file][name][0] = $file_1_name;
            }   
            
            if(!empty($file[evalution][name][new_file][1]))
            {
                $file_2_name = $file[evalution][name][new_file][1];
                $file_2_name = $evalution[pid]."_".$evalution[uid]."_".time()."_"."_p_".$file_2_name;
                $file_2_tmp_path = $file[evalution][tmp_name][new_file][1];
                $result_2 = move_uploaded_file($file_2_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_2_name);
                $evalution[file][name][1] = $file_2_name;
            }  
        return $evalution;
        
    }
    
    function edit($tpl = null)
    {
        $model = $this->getModel();
        // запись результатов после редактирования
        if (JRequest::getVar('step') == 1)
        {
            
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
            $id = JRequest::getVar('id');
            $t = JRequest::getVar('t');
            $tempid = JRequest::getVar('tempid');
            
            $step1 = JRequest::get('post');
            
            
            if(isset($step1[bool]))
            {
                $step1 = $step1[bool];
            }
            else
            {
               $step1 = $step1[evaluation];
                
                if($step1 == null)
                {
                    global $mainframe;
                    
                    if($t == 1)
                    {
                       $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_body_score_survey&pid=$pid&uid=$uid&id=$id&t=1", "Не отмечен не один пункт"); 
                    }
                    
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_start_step1&pid=$pid&uid=$uid&id=$id&tempid=$tempid", "Не отмечен не один пункт");
                }
                

            $step1 =  implode(",", $step1);
             
            }

            
            
 
                $result = $model->editStep1($step1, $id, $tempid); 
            
                if ($result)
                {
                $msg = JText::_('data update');
                }
                else
                {
                $msg = JText::_('data not update');
                }
                
            global $mainframe;
            
            if($t == 1)
            {
              $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_survey&pid=$pid&uid=$uid", $msg);  
            }
            
            
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=survey", $msg);

            
        }
        
        // запись результатов после редактирования
        if ( JRequest::getVar('step') == 2)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
            $id = JRequest::getVar('id');
            $step2 = JRequest::get('post');
            $t = JRequest::getVar('t');
            $tempid = JRequest::getVar('tempid');

            if(empty($step2[weight]) or empty($step2[fat]) or empty($step2[ph]))
                {
                    global $mainframe;
                    if($t == 1)
                    {
                       $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_body_score&pid=$pid&uid=$uid&id=$id&t=1", "Не отмечен не один пункт"); 
                    }
                    
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_start_step2&pid=$pid&uid=$uid&id=$id&tempid=$tempid", "Заполните все поля");
                }
            
            $step2 = $step2[weight].",".$step2[fat].",".$step2[ph];
            
            
            $result = $model->editStep2($step2, $id, $tempid);
            
                if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                

            global $mainframe;
            if($t == 1)
                    {
                       $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_survey&pid=$pid&uid=$uid", $msg);
                    }
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=survey", $msg);

        }
        
        // запись результатов после редактирования
        if (JRequest::getVar('step') == 3)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
            $id = JRequest::getVar('id');
            $t = JRequest::getVar('t');
            $tempid = JRequest::getVar('tempid');
            

            $result = $model->editStep3($pid, $uid, $id, $tempid); 
            
            
               if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                global $mainframe;
                
                if($t == 1)
                {
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_survey&pid=$pid&uid=$uid", $msg);
                }
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=survey", $msg);
            
        }
        
        // запись результатов после редактирования
        if (JRequest::getVar('step') == 4)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
            $id =  JRequest::getVar('id');
            $t =  JRequest::getVar('t');
            $tempid = JRequest::getVar('tempid');
            
            
            
            $step1 = JRequest::get('post');
            
            
            
            
            if(isset($step1[bool]))
            {
                $step4 = $step1[bool];
            }
            else
            {
            $step1 = $step1[evaluation];   
            if($step1 == null)
                {
                    global $mainframe;
                    
                    if($t == 1)
                    {
                      $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_symptoms&pid=$pid&uid=$uid&id=$id&t=1", "Не отмечен не один пункт");  
                    }
                            
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_start_step4&pid=$pid&uid=$uid&id=$id&tempid=$tempid", "Не отмечен не один пункт");
                }
            
            
            $step4 =  implode(",", $step1);
                
                
            }
            
           
               $result = $model->editStep1($step4, $id, $tempid); 
               
               if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                global $mainframe;
                
                if($t == 1)
                    {
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_survey&pid=$pid&uid=$uid", $msg);  
                    }
                
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=survey", $msg);
           
                
        }
        
        // запись результатов после редактирования
        if (JRequest::getVar('step') == 5)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
            $id =  JRequest::getVar('id');
            $t = JRequest::getVar('t');
            $step1 = JRequest::get('post');
            $tempid = JRequest::getVar('tempid');
            
            if(isset($step1[bool]))
            {
                $step5 = $step1[bool];
            }
            else
            {
            $step1 = $step1[evaluation];
               global $mainframe;

               
               if($step1 == null)
                {
                   if($t == 1)
                   {
                     $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_medtrack&pid=$pid&uid=$uid&id=$id&t=1", "Не отмечен не один пункт");  
                   }
                    
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_start_step5&pid=$pid&uid=$uid&id=$id&tempid=$tempid", "Не отмечен не один пункт");
                }
               
            $step5 =  implode(",", $step1);
                
            }
            
              
            $result = $model->editStep1($step5, $id, $tempid); 
               
               if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                global $mainframe;
                if ($t == 1)
                {
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_survey&pid=$pid&uid=$uid", $msg);
                }
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=survey", $msg);
                
                
        }
        
        // запись результатов после редактирования
        if (JRequest::getVar('step') == 6)
        {
            $pid = JRequest::getVar('pid');
            $uid = JRequest::getVar('uid');
            $id = JRequest::getVar('id');
            $t =  JRequest::getVar('t');
            $tempid = JRequest::getVar('tempid');
            
            
            $step1 = JRequest::get('post');
            
            if(isset($step1[bool]))
            {
                $step6 = $step1[bool];
            }
            else
            {
            $step1 = $step1[evaluation];
            if($step1 == null)
               {
                    global $mainframe;
                    
                    if($t == 1)
                    {
                        $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_diseases&pid=$pid&uid=$uid&id=$id&t=1", "Не отмечен не один пункт");
                    }
                    
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=edit_start_step6&pid=$pid&uid=$uid&id=$id&tempid=$tempid", "Не отмечен не один пункт");
               }
            $step6 =  implode(",", $step1);
                 
            }
              
            
               $result = $model->editStep1($step6, $id, $tempid); 
               
               if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                global $mainframe;
                
                if($t == 1)
                {
                    $mainframe->redirect("index.php?option=com_phase&controller=client&action=end_survey&pid=$pid&uid=$uid", $msg);
                }
                
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=survey", $msg);
            
                
        }
        
        parent::display($tpl);
    }
    
    function end_survey($tpl = null)
    {
                //графики
        $document =& JFactory::getDocument();
        $document->addStyleSheet(JURI::root().'components/com_hreport/css/autocompleter.css');
        JHTML::script('autocompleter.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('observer.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('progress_tracking.js',JURI::root().'components/com_jforce/js/phase/', true);

        // adding chart
        JHTML::script('jquery-1.7.1.min.js',JURI::root().'components/com_jforce/js/charts/');
        JHTML::script('highcharts.js',JURI::root().'components/com_jforce/js/charts/');
        //графики
        $model = $this->getModel();
        $pid = JRequest::getVar('pid');
        $uid = JRequest::getVar('uid');
        
        $cnt = $model->getEndCnt($pid, $uid);
        $this->assignRef('cnt', $cnt);
        

        //проверка на существования ответа на вопросы
        $questionsResult = $model->getEndQuestionsResult($pid);
        if (count($questionsResult) == 1)
        {
            foreach ($questionsResult as $value)
            {
                $numbers =  $value->val;
                $uqid =  $value->id;
            }
            
            if($numbers == no)
            {
                $uq = $numbers;
            }
            else
            {
            $uq = $model->getUQ($numbers);
            }
            
            $this->assignRef('uq', $uq);
            $this->assignRef('uqid', $uqid);  
            
            $trackingEnd = $model->getProgressTrackingDetails($uid, $pid,$numbers);
            $this->assignRef('trackingEnd', $trackingEnd);
            
        }
        
        
        //проверка на существования ответа на степ вес/жир
        $fatResult = $model->getEndFatResult($pid);
        if (count($fatResult) == 1)
        {
            foreach ($fatResult as $value)
            {
               $fat =  $value->val;
               $fatid = $value->id;
            }
            
            $fat = explode(",", $fat);
            $this->assignRef('fat', $fat); 
            $this->assignRef('fatid', $fatid);  
        }
        
        
        //проверка на существования ответа на фото
        $photoResult = $model->getEndPhotoResult($pid);
        if (count($photoResult) == 1)
        {
            foreach ($photoResult as $value)
            {
                $photo =  $value->val;
                $photoid = $value->id;
            }
           
            $photo = explode(",", $photo);
            
            $this->assignRef('photo', $photo); 
            $this->assignRef('photoid', $photoid);
        }
        

        //проверка на существования ответа на симптомы
        $symptomsResult = $model->getEndSymptomsResult($pid);
        if (count($symptomsResult) == 1)
        {
            foreach ($symptomsResult as $value)
            {
               $symptomsResult =  $value->val;
               $sid = $value->id;
            }
            if($symptomsResult == no)
                {
                $symptoms = $symptomsResult;
                }
            else
                {
                $symptoms = $model->getSymptomsRes($symptomsResult);
                }
            $this->assignRef('symptoms', $symptoms);
            $this->assignRef('sid', $sid);
            
        }
        
        //проверка на существования ответа на препараты
        $medtrackResult = $model->getEndMedtrackResult($pid);
        if (count($medtrackResult) == 1)
        {
            foreach ($medtrackResult as $value)
            {
            $medtrackResult =  $value->val;
            $mid = $value->id;
            }
            if($medtrackResult == no)
            {
                $medtrack = $medtrackResult;
            }
            else
            {
            $medtrack = $model->getMedtrackRes($medtrackResult);
            }
            $this->assignRef('medtrack', $medtrack); 
            $this->assignRef('mid', $mid); 
        }
        
     
        //проверка на существования ответа на заболевания
        $diseasesResult = $model->getEndDiseasesResult($pid);
        if (count($diseasesResult) == 1)
        {
            foreach ($diseasesResult as $value)
            {
            $diseasesResult =  $value->val;
            $did = $value->id;
            }
            if($diseasesResult == no)
            {
                $diseases = $diseasesResult;
            }
            else
            {
            $diseases = $model->getDiseasesRes($diseasesResult);
            }
            $this->assignRef('diseases', $diseases); 
            $this->assignRef('did', $did); 
            
        }

        parent::display($tpl);
    }
    
    function end_body_score_survey($tpl)
    {
        $model = $this->getModel();
        
        $pid = JRequest::getVar('pid');
        
        $questionsResult = $model->getEndQuestionsResult($pid);
        if (count($questionsResult) == 1)
        {
            foreach ($questionsResult as $value)
            {
                $numbers =  $value->survey_value;
            }
            $content = $model->getUQ($numbers);
            $this->assignRef('content', $content); 
        }
        else
        {
        $questions = $model->getQuestions();
        $this->assignRef('questions', $questions);  
        }
        
        parent::display($tpl);
    }
    
     function end_body_score($tpl = null)
    {
        parent::display($tpl);
    }
    
    function end_body_foto($tpl = null)
    {
        
        parent::display($tpl);
    }
        
    function end_symptoms($tpl = null)
    {
        $model = $this->getModel();
        $symptoms = $model->getSymptoms();
        $this->assignRef('symptoms', $symptoms);
        parent::display($tpl);
    }
    
    function end_medtrack($tpl = null)
    {
        $model = $this->getModel();
        $medtrack = $model->getMedtrack();
        $this->assignRef('medtrack', $medtrack);
        parent::display($tpl);
    }
    
    function end_diseases($tpl = null)
    {
        $model = $this->getModel();
        $diseases = $model->getDiseases();
        $this->assignRef('diseases', $diseases);
        parent::display($tpl);
    }
    
    function show_evalution($tpl = null)
    {

        if(JRequest::getVar('c'))
        {
           $uid = JRequest::getVar('c');
        }
        else
        {
        $user =& JFactory::getUser();
        $uid = $user->id;
        }
        
        $model = $this->getModel();
        $phases = $model->getUP($uid);
        $this->assignRef('phases', $phases);
        
        
        if(!JRequest::getVar('pid'))
        {
            $pid = 0;
            /*
            $fp = $model->getFP($uid);
            foreach ($fp as $value)
            {
                $pid = $value->id;    
            }
            */
        }
        else
        {
            $pid = JRequest::getVar('pid');
        }
        
        
        
        if(isset($pid))
        {
            //имя фазы
            $start = $model->getStartResul($pid);
            $this->assignRef('start', $start);
        
        // проверка первичных данных
        //проверка на существования ответа на вопросы
        $questionsResult = $model->getQuestionsResult($pid);
        if (count($questionsResult) == 1)
        {
            foreach ($questionsResult as $value)
            {
                $numbers =  $value->val;
                $uqid =  $value->id;
            }
            if($numbers == no)
            {
                $uq = $numbers;
            }  
            else
            {
            $uq = $model->getUQ($numbers);
            }
            $this->assignRef('uq', $uq);
            
            
            
            
            
                            //графики
        $document =& JFactory::getDocument();
        $document->addStyleSheet(JURI::root().'components/com_hreport/css/autocompleter.css');
        JHTML::script('autocompleter.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('observer.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('progress_tracking.js',JURI::root().'components/com_jforce/js/phase/', true);

        // adding chart
        JHTML::script('jquery-1.7.1.min.js',JURI::root().'components/com_jforce/js/charts/');
        JHTML::script('highcharts.js',JURI::root().'components/com_jforce/js/charts/');
                //графики
            
            
            
            
            
            
            
            
            
            
            $trackingStart = $model->getProgressTrackingDetails($uid, $pid,$numbers);
            $this->assignRef('trackingStart', $trackingStart);
            
        }
        
        
        //проверка на существования ответа на степ вес/жир
        $fatResult = $model->getFatResult($pid);
        if (count($fatResult) == 1)
        {
            foreach ($fatResult as $value)
            {
               $fat =  $value->val;
               $fatid = $value->id;
            }
            
            $fat = explode(",", $fat);
            $this->assignRef('fat', $fat);  
        }
        
        
        //проверка на существования ответа на фото
        $photoResult = $model->getPhotoResult($pid);
        if (count($photoResult) == 1)
        {
            foreach ($photoResult as $value)
            {
                $photo =  $value->val;
                $photoid = $value->id;
            }
        
            
            $photo = explode(",", $photo);
            
            $this->assignRef('photo', $photo); 
        }
        
        //проверка на существования ответа на симптомы
        $symptomsResult = $model->getSymptomsResult($pid);
        if (count($symptomsResult) == 1)
        {
            foreach ($symptomsResult as $value)
            {
               $symptomsResult =  $value->val;
               $sid = $value->id;
            }
            if($symptomsResult == no)
            {
                $symptoms = $symptomsResult;
            } 
            else
            {
            $symptoms = $model->getSymptomsRes($symptomsResult);
            }
            $this->assignRef('symptoms', $symptoms);
            
        }
        
        //проверка на существования ответа на препараты
        $medtrackResult = $model->getMedtrackResult($pid);
        if (count($medtrackResult) == 1)
        {
            foreach ($medtrackResult as $value)
            {
            $medtrackResult =  $value->val;
            $mid = $value->id;
            }
            if($medtrackResult == no)
            {
                $medtrack = $medtrackResult;
            } 
            else
            {
            $medtrack = $model->getMedtrackRes($medtrackResult);
            }
            $this->assignRef('medtrack', $medtrack); 
        }
        
        
        //проверка на существования ответа на заболевания
        $diseasesResult = $model->getDiseasesResult($pid);
        if (count($diseasesResult) == 1)
        {
            foreach ($diseasesResult as $value)
            {
            $diseasesResult =  $value->val;
            $did = $value->id;
            }
            if($diseasesResult == no)
            {
                $diseases = $diseasesResult;
            }
            else
            {
            $diseases = $model->getDiseasesRes($diseasesResult);
            }
            $this->assignRef('diseases', $diseases); 
            
        }
        // проверка первичных данных
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        //проверка на существования ответа на вопросы
        $equestionsResult = $model->getEndQuestionsResult($pid);
        if (count($equestionsResult) == 1)
        {
            foreach ($equestionsResult as $value)
            {
                $enumbers =  $value->val;
                $euqid =  $value->id;
            }
             if($enumbers == no)
            {
                $euq = $enumbers;
            } 
            else
            {
            $euq = $model->getUQ($enumbers);
            }
            $this->assignRef('euq', $euq);
            
            
            
                        
            
            
            
            
                            //графики
        $document =& JFactory::getDocument();
        $document->addStyleSheet(JURI::root().'components/com_hreport/css/autocompleter.css');
        JHTML::script('autocompleter.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('observer.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('progress_tracking.js',JURI::root().'components/com_jforce/js/phase/', true);

        // adding chart
        JHTML::script('jquery-1.7.1.min.js',JURI::root().'components/com_jforce/js/charts/');
        JHTML::script('highcharts.js',JURI::root().'components/com_jforce/js/charts/');
                //графики
            
            
            
            
            
            
            
            
            
            
            $trackingEnd = $model->getProgressTrackingDetails($uid, $pid,$numbers);
            $this->assignRef('trackingEnd', $trackingEnd);

        }
        
        
        //проверка на существования ответа на степ вес/жир
        $efatResult = $model->getEndFatResult($pid);
        if (count($efatResult) == 1)
        {
            foreach ($efatResult as $value)
            {
               $efat =  $value->val;
               $efatid = $value->id;
            }
            
            $efat = explode(",", $efat);
            $this->assignRef('efat', $efat); 
        }
        
        
        //проверка на существования ответа на фото
        $ephotoResult = $model->getEndPhotoResult($pid);
        if (count($ephotoResult) == 1)
        {
            foreach ($ephotoResult as $value)
            {
                $ephoto =  $value->val;
                $ephotoid = $value->id;
            }
           
            $ephoto = explode(",", $ephoto);
            
            $this->assignRef('ephoto', $ephoto); 
        }
        

        //проверка на существования ответа на симптомы
        $esymptomsResult = $model->getEndSymptomsResult($pid);
        if (count($esymptomsResult) == 1)
        {
            foreach ($esymptomsResult as $value)
            {
               $esymptomsResult =  $value->val;
               $esid = $value->id;
            }
             if($esymptomsResult == no)
            {
                $esymptoms = $esymptomsResult;
            } 
            else
            {
            $esymptoms = $model->getSymptomsRes($esymptomsResult);
            }
            $this->assignRef('esymptoms', $esymptoms);
            
        }
        
        //проверка на существования ответа на препараты
        $emedtrackResult = $model->getEndMedtrackResult($pid);
        if (count($emedtrackResult) == 1)
        {
            foreach ($emedtrackResult as $value)
            {
            $emedtrackResult =  $value->val;
            $emid = $value->id;
            }
             if($emedtrackResult == no)
            {
                $emedtrack = $emedtrackResult;
            }
            else
            {
            $emedtrack = $model->getMedtrackRes($emedtrackResult);
            }
            $this->assignRef('emedtrack', $emedtrack); 
        }
        
     
        //проверка на существования ответа на заболевания
        $ediseasesResult = $model->getEndDiseasesResult($pid);
        if (count($ediseasesResult) == 1)
        {
            foreach ($ediseasesResult as $value)
            {
            $ediseasesResult =  $value->val;
            $edid = $value->id;
            }
             if($ediseasesResult == no)
            {
                $ediseases = $ediseasesResult;
            }
            else
            {
            $ediseases = $model->getDiseasesRes($ediseasesResult);
            }
            $this->assignRef('ediseases', $ediseases); 
            
        }

        }
        
        parent::display($tpl);
    }
    
    function survey($tpl = null)
    {
        $model = $this->getModel();
        
        $pid = 0;
        $this->assignRef('pid', $pid);

        $user =& JFactory:: getUser();
        $userId = $user->id;
        $this->assignRef('uid', $userId);
        
        
        //графики
        $document =& JFactory::getDocument();
        $document->addStyleSheet(JURI::root().'components/com_hreport/css/autocompleter.css');
        JHTML::script('autocompleter.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('observer.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('progress_tracking.js',JURI::root().'components/com_jforce/js/phase/', true);

        // adding chart
        JHTML::script('jquery-1.7.1.min.js',JURI::root().'components/com_jforce/js/charts/');
        JHTML::script('highcharts.js',JURI::root().'components/com_jforce/js/charts/');
        //графики
        
        
        //проверка на существования ответа на вопросы
        $questionsResult = $model->getQuestionsResult($pid, $userId);
        if (count($questionsResult) == 1)
        {
            foreach ($questionsResult as $value)
            {
                $numbers =  $value->val;
                $uqid =  $value->id;
            }
           
            if($numbers == no)
            {
                $uq = $numbers;
            }
            else
            {
                $uq = $model->getUQ($numbers);
            }
            
            $step = 1;
            $tempuqid = $model->checkTemp($userId, $step);
            $this->assignRef('tempuqid', $tempuqid); 
            
            
            $this->assignRef('uq', $uq);
            $this->assignRef('uqid', $uqid);  
             

            
            $trackingStart = $model->getProgressTrackingDetails($uid, $pid, $numbers);
            
            $this->assignRef('trackingStart', $trackingStart);
        }
        
        //проверка на существования ответа на степ вес/жир
        $fatResult = $model->getFatResult($pid, $userId);
        if (count($fatResult) == 1)
        {
            foreach ($fatResult as $value)
            {
               $fat =  $value->val;
               $fatid = $value->id;
            }
            
            $step = 2;
            $tempfatid = $model->checkTemp($userId, $step);
            $this->assignRef('tempfatid', $tempfatid); 
            
            $fat = explode(",", $fat);
            $this->assignRef('fat', $fat); 
            $this->assignRef('fatid', $fatid);  
        }
        
        //проверка на существования ответа на фото
        $photoResult = $model->getPhotoResult($pid, $userId);
        if (count($photoResult) == 1)
        {
            foreach ($photoResult as $value)
            {
                $photo =  $value->val;
                $photoid = $value->id;
            }
        
            $step = 3;
            $tempphotoid = $model->checkTemp($userId, $step);
            $this->assignRef('tempphotoid', $tempphotoid); 
            
            $photo = explode(",", $photo);
            
            $this->assignRef('photo', $photo); 
            $this->assignRef('photoid', $photoid);
        }
        
        //проверка на существования ответа на симптомы
        $symptomsResult = $model->getSymptomsResult($pid, $userId);
        if (count($symptomsResult) == 1)
        {
            foreach ($symptomsResult as $value)
            {
                $symptomsResult =  $value->val;
                $sid = $value->id;
            }
            
            if($symptomsResult == no)
            {
                $symptoms = $symptomsResult;
            }
            else
            {
                $symptoms = $model->getSymptomsRes($symptomsResult);
            }
            
            $step = 4;
            $tempsid = $model->checkTemp($userId, $step);
            $this->assignRef('tempsid', $tempsid); 
            
            $this->assignRef('symptoms', $symptoms);
            $this->assignRef('sid', $sid);
            
        }
        
        //проверка на существования ответа на препараты
        $medtrackResult = $model->getMedtrackResult($pid, $userId);
        if (count($medtrackResult) == 1)
        {
            foreach ($medtrackResult as $value)
            {
            $medtrackResult =  $value->val;
            $mid = $value->id;
            }
            
            if($medtrackResult == no)
            {
                $medtrack = $medtrackResult;
            }
            else
            {
            $medtrack = $model->getMedtrackRes($medtrackResult);
            }

            $step = 5;
            $tempmid = $model->checkTemp($userId, $step);
            $this->assignRef('tempmid', $tempmid); 
            
            $this->assignRef('medtrack', $medtrack); 
            $this->assignRef('mid', $mid); 
        }
        
        //проверка на существования ответа на заболевания
        $diseasesResult = $model->getDiseasesResult($pid, $userId);
        if (count($diseasesResult) == 1)
        {
            foreach ($diseasesResult as $value)
            {
            $diseasesResult =  $value->val;
            $did = $value->id;
            }
            
            if($diseasesResult == no)
            {
                $diseases = $diseasesResult;
            }
            else
            {
            $diseases = $model->getDiseasesRes($diseasesResult);
            }
            
            $step = 6;
            $tempdid = $model->checkTemp($userId, $step);
            $this->assignRef('tempdid', $tempdid);
            
            $this->assignRef('diseases', $diseases); 
            $this->assignRef('did', $did); 
            
        }

        parent::display($tpl);
    }
    
    function start_step1($tpl = null)
    {
        $model = $this->getModel();
        
        
        $questions = $model->getQuestions();
        $this->assignRef('questions', $questions);  
        
        parent::display($tpl);
    }
    
    function edit_start_step1($tpl = null)
    {
        $model = $this->getModel();
        $questions = $model->getQuestions();
        $this->assignRef('questions', $questions);  
        
        parent::display($tpl);
    }
    
    function start_step2($tpl = null)
    {
        
        parent::display($tpl);
    }
    
    function edit_start_step2($tpl = null)
    {
        parent::display($tpl);   
    }
    
    function start_step3($tpl =null)
    {
        parent::display($tpl);
    }
    
    function edit_start_step3($tpl = null)
    {
        parent::display($tpl);
    }
    
    function start_step4($tpl = null)
    {
        $model = $this->getModel();
        $symptoms = $model->getSymptoms();
        $this->assignRef('symptoms', $symptoms);
        parent::display($tpl);
    }
    
    function edit_start_step4($tpl = null)
    {
        $model = $this->getModel();
        $symptoms = $model->getSymptoms();
        $this->assignRef('symptoms', $symptoms);
        
        parent::display($tpl);
    }
    
    function start_step5($tpl =null)
    {
        $model = $this->getModel();
        $medtrack = $model->getMedtrack();
        $this->assignRef('medtrack', $medtrack);
        parent::display($tpl);
    }
    
    function edit_start_step5($tpl = null)
    {
        $model = $this->getModel();
        $medtrack = $model->getMedtrack();
        $this->assignRef('medtrack', $medtrack);
        parent::display($tpl);
    }
    
    function start_step6($tpl = null)
    {
        $model = $this->getModel();
        $diseases = $model->getDiseases();
        $this->assignRef('diseases', $diseases);
        parent::display($tpl);
    }
    
    function edit_start_step6($tpl = null)
    {
        $model = $this->getModel();
        $diseases = $model->getDiseases();
        $this->assignRef('diseases', $diseases);
        parent::display($tpl);
    }
    
    function progress($tpl = null)
    {
        $user =& JFactory::getUser();
        $uid = $user->id;
        $pid = JRequest::getVar('pid');
        $model = $this->getModel();
        
        $finishCheck = $model->finishCheck($pid, $uid);
        
        if($finishCheck == 0)
        {
            $bodycsore = $model->getTempDataBodyscore($uid);
        }
        
        if($finishCheck == 1)
        {
            
        }
        
        parent::display($tpl);
    }
    
    function score($tpl = null)
    {
        $model = $this->getModel();
        
        $user =& JFactory::getUser();
        $uid = $user->id;
        $this->assignRef('uid', $uid);
                        
        $pid = JRequest::getVar('pid');
        if($pid == null) $pid = 0;
        $this->assignRef('pid', $pid);
                
        $questionList = $model->questionList();
        $this->assignRef('questionList', $questionList);
                
        
        $finish = $model->phaseFin($uid, $pid);
        
        // если нулл, то это первый опрос
        if($finish == null)
        {
            //проверим основную таблицу на ответы
            $mainTest = $model->mainTest($uid, $pid);
            
            //если нулл то опроса небыло - выводим пустую страницу опроса
            if($mainTest == null)
            {
                parent::display($tpl);
            }
            else
            {
                //обработка вытащеного ответа
                $parseData = $this->parseData($mainTest);
                /*
                //если pid == 0 (это значит что это первичныый опрос, данные пишуться сразу в 2 таблицы при изминении данных нужно изменять тоже две поэтому достаём айдишники из темповой таблицы)
                if($parseData['bodyscore']['pid']     == 0 
                    || $parseData['body']['pid']      == 0 
                    || $parseData['photo']['pid']     == 0 
                    || $parseData['symptoms']['pid']  == 0 
                    || $parseData['medical']['pid']   == 0 
                    || $parseData['diseases']['pid']  == 0)
                {
                    foreach ($parseData as $value)
                    {
                        $value['tid'] = $model->getTid($value['uid'], $value['step']);
                        $parseData[$value['name']] = $value;
                    }
                }
                */
                
                $this->assignRef('survey', $parseData);
                parent::display($tpl);
            }
                
        }
        
        
        
        
    }
    
    function parseData($mainTest)
    {
        $survey['bodyscore'] = $this->parse($mainTest[0]);
        $survey['body'] = $this->parse($mainTest[1]);
        $survey['photo'] = $this->parse($mainTest[2]);
        $survey['symptoms'] = $this->parse($mainTest[3]);
        $survey['medical'] = $this->parse($mainTest[4]);
        $survey['diseases'] = $this->parse($mainTest[5]);
        
        return $survey;
        
    }
    
    function parse($data)
    {
        $data['val'] = explode(",", $data['val']);
        $data['status'] = explode(",", $data['status']);
        $data['note'] = explode(",", $data['note']);
        return $data;
    }
    
    function lastintake($tpl = null)
    {
        session_start();
        $model = $this->getModel();
        
        if(!empty($_SESSION[evalution]))
        {
        $evalution  = $_SESSION[evalution];
        $this->assignRef('evalution', $evalution);
        unset($_SESSION['evalution']);
        }
        
		
		
		
		
        $user =& JFactory::getUser();
        $uid = $user->id;
        $this->assignRef('uid', $uid);
        
        $test = $model->lastintakeTest($uid);
        if($test != 0)
        {
            global $mainframe;
            $mainframe->redirect('index.php?option=com_phase&controller=client&action=show_repo');
        }
        
        $loockingfor = $model->loockingfor();
        $this->assignRef('loockingfor', $loockingfor);
        
        $questionList = $model->questionList();
        $this->assignRef('questionList', $questionList);
        

		//Взять список алергий
		$allergiesList = $model->getAllergiesList();
        $this->assignRef('allergiesList', $allergiesList);
		
        
        //Взять список симпомов
        $symptomList = $model->getSymptomList();
        $this->assignRef('symptomList', $symptomList);
        
        //Взять список препараты
        $medtrackList = $model->getMedtrackList();
        $this->assignRef('medtrackList', $medtrackList);
        
        
        //Взять список заболеваний
        $diseasesList = $model->getDiseasesList();
        $this->assignRef('diseasesList', $diseasesList);
        
        
        

        
        
        
        parent::display($tpl);
    }
    
    function lastintake_confirm()
    {
        session_start();
        $model = $this->getModel();
        
        if(!empty($_SESSION[evalution]))
        {
        $evalution  = $_SESSION[evalution];
        $this->assignRef('evalution', $evalution);
        //unset($_SESSION['evalution']);
        }

        
        $user =& JFactory::getUser();
        $uid = $user->id;
        $this->assignRef('uid', $uid);
        
        $loockingfor = $model->loockingfor();
        $this->assignRef('loockingfor', $loockingfor);
        
        
        $questionList = $model->questionList();
        $this->assignRef('questionList', $questionList);
        
		//Взять список алергий
		$allergiesList = $model->getAllergiesList();
        $this->assignRef('allergiesList', $allergiesList);
		
		
		//Взять список симпомов
        $symptomList = $model->getSymptomList();
        $this->assignRef('symptomList', $symptomList);
        
        //Взять список препараты
        $medtrackList = $model->getMedtrackList();
        $this->assignRef('medtrackList', $medtrackList);
        
        
        //Взять список заболеваний
        $diseasesList = $model->getDiseasesList();
        $this->assignRef('diseasesList', $diseasesList);
		
        parent::display($tpl);
    }
    
    //new
    function medtrackList(){
        
        $model = $this->getModel();
        // вопросы lifestyle
        $data[questionList] = $model->questionList();
        
        //Взять список симпомов
        $data[symptomList] = $model->getSymptomList();
        
        //Взять список препараты
        $data[medtrackList] = $model->getMedtrackList();
        
        //Взять список заболеваний
        $data[diseasesList] = $model->getDiseasesList();
        return $data;
    }
    
    //use
    function phasechek($tpl = null){
        
        session_start();
        $model = $this->getModel();
        $pid = JRequest::getVar('pid'); 
        $uid = JFactory::getUser()->id;
        
        if($pid !== "" && $pid !== null && $uid !== "" && $uid !== null){
            
            $data = $this->medtrackList();
            // тест на наличие данных первичного опроса
            $test = $model->getFirstData($uid);
            // если их нет -> редирект на первичный опрос
            if(count($test) == 0){
                global $mainframe;
                $mainframe->redirect('index.php?option=com_phase&controller=client&action=lastintake',"Enter intake data");
            }else{
                // проверка на наличие данных по конкретной фазе
                $phaseData = $model->testPhaseData($uid, $pid);

                if(count($phaseData) == 0){
                    //если данных по фазе нет -> берём данные по последней дате
                    $data[dirty_content] = $model->getIntakeData($uid);
                } else{
                    // если есть -> берём данные по конкретной фазе и по последнему числу
                    $data[dirty_content] = $phaseData;
                }
            }

            // розбор данных из базы
            if(isset($data[dirty_content]) && $data[dirty_content] !== null){
                $data[content] = $this->parse_dirty_content($data[dirty_content]);
                unset($data[dirty_content]);
            }
        }else{
            global $mainframe;
            $mainframe->redirect('index.php?option=com_phase&controller=client',"System error");
        }
        $this->assignRef('uid', $uid);
        $this->assignRef('pid', $pid);
        $this->assignRef('data', $data);
        
        parent::display($tpl);
    }
    
    //new
    function parse_dirty_content($var){
        foreach ($var as $value){
            $test[$value[name]][val] = explode(",", $value[val]);
            $test[$value[name]][status] = explode(",", $value[status]);
            $test[$value[name]][note] = explode(",", $value[note]);
        }
        return $test;
    }
    
    //new
    function build_life_chart($trackingStart){
        $var = explode(",", $trackingStart->cats);
            foreach ($var as $value) {
                if($value == ""){$value = "VAR";}
                $cat[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
            }

            $var2 = explode(",", $trackingStart->opp_vals);
            foreach ($var2 as $value) {
                if($value == "" || $value == "0"){$value = 1;}
                $cat2[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
            }

            foreach ($cat2 as $value){
                if($value > 75){
                        $color[] = "green";
                    }
                    elseif ($value <=75 && $value > 50) {
                        $color[] = "blue";
                    }
                    elseif($value <=50 && $value > 25){
                        $color[] = "orange";
                    }
                    elseif($value <=25 && $value >= 0){
                        $color[] = "red";
                    }
                    else{$color[] = "blue";}
            }

            $a = "[['Element', 'results', { role: 'style' }]";
            for($i=0; $i<count($color); $i++){
                $b = $b.", ['".$cat[$i]."', ".$cat2[$i].", '".$color[$i]."']";
            }
            $c = "]";    
            $d = $a."".$b."".$c;
            if(count($var) !== 9 || count($var2) !== 9){
                $d="[['Element', 'results', { role: 'style' }], ['Digestive', 100, 'green'], ['Intestinal', 100, 'green'], ['Circulatory', 100, 'green'], ['Nervous', 100, 'green'], ['Immune', 100, 'green'], ['Respiratory', 100, 'green'], ['Urinary', 100, 'green'], ['Glandular', 100, 'green'], ['Structural', 100, 'green']]";
            }
            return $d;
    }
    
    //use
    function show_repo($tpl = null){
        $model = $this->getModel();
        $uid = JFactory::getUser()->id;
        
        if(JRequest::getVar('c') && JRequest::getVar('c') != ""){
            $uid = JRequest::getVar('c');
        }
        
        if($uid == "" || $uid == null){
            global $mainframe;
            $mainframe->redirect('index.php?option=com_phase&controller=client',"System error");
        }
        
        //результаты первичного опроса
        $content = $model->getFirstContent($uid);
        if(count($content) == 0 || !$content){
            global $mainframe;
            $mainframe->redirect('index.php?option=com_phase&controller=client&action=lastintake',"Enter intake data");
        }else{
            //берём названия фаз для меню
            $phases_id = $model->getPhasesId($uid);
            $loockingfor = $model->loockingfor();
            

            $content = $this->parse_dirty_content($content);
            
            if($content[life_style][val] && count($content[life_style][val]) !== 0){
                $res = implode(",", $content[life_style][val]);
                $qAnswers = $model->getQAnswers($res);
                $trackingStart = $model->getProgressTrackingDetails($uid, $pid, $res);
                $this->assignRef('qAnswers', $qAnswers);
            }
            
            $data_for_chart = $this->build_life_chart($trackingStart);

            $content[medtrack] = $this->medtrackList();
            $content[medtrack][allergiesList] = $model->getAllergiesList();
        $this->assignRef('d', $data_for_chart);
        $this->assignRef('uid', $uid);
        $this->assignRef('loockingfor', $loockingfor);
        $this->assignRef('phases', $phases_id);
        $this->assignRef('evalution', $content);
        }
         
        parent::display($tpl);
    }
    
    //use
    function show_repoz($tpl = null)
    {
        $pid = JRequest::getVar('pid');
        $model = $this->getModel();
        $uid = JFactory::getUser()->id;
        if(JRequest::getVar('c') && JRequest::getVar('c') != ""){
            $uid = JRequest::getVar('c');
        }
        
        if($uid == "" || $uid == null || $pid =="" || $pid == null){
            global $mainframe;
            $mainframe->redirect('index.php?option=com_phase&controller=client',"System error");
        }else{
            $content = $model->testPhaseData($uid, $pid);
            if($content == null || count($content) == 0){
                global $mainframe;
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=show_repo&c=$uid", "you don't have result for this phase");
            }

            $evalution = $this->parse_dirty_content($content);
            if($evalution[life_style][val][0] !== ""  && $evalution[life_style][val][0] !== null){
                    $res = implode(",", $evalution[life_style][val]);
                    $qAnswers = $model->getQAnswers($res);
                    $trackingStart = $model->getProgressTrackingDetails($uid, $pid, $res);
                    $data_for_chart = $this->build_life_chart($trackingStart);
                    $this->assignRef('d', $data_for_chart);
                    $this->assignRef('qAnswers', $qAnswers);
            }


            $phases_id = $model->getPhasesId($uid);
            $this->assignRef('phases', $phases_id);

            $evalution[medtrack] = $this->medtrackList();
            $this->assignRef('evalution', $evalution);
        }
        
        parent::display($tpl);
    }
    
    function prepoContent($content)
    {
        $temp = explode(",", $content[0][val]);
        
        $data[goals][weight] = $temp[0];
        $data[goals][fat] = $temp[1];
        $data[goals][question] = explode(",", $content[1][val]);
        
        $data[stats][sex] = $content[2][val];
        $data[stats][height] = explode(",", $content[3][val]);
        $temp = explode(",", $content[4][val]);
        $data[stats][weight] = $temp[0];
        $data[stats][fat] = $temp[1];
        $data[stats][ph] = $temp[2];
         
        
        $data[stats][blood_p] = explode(",", $content[5][val]);
        $data[stats][blood_t] = $content[6][val];
        
        $data[body_type] = explode(",", $content[7][val]);
        $data[life_style] = explode(",", $content[8][val]);
        $data[file] = explode(",", $content[9][val]);
        
        
        $data[madtrack][exem] = $content[10][val];
        
        $data[madtrack][treatment][status] = $content[11][status];
        $data[madtrack][treatment][note] = $content[11][note];
        
        $data[madtrack][operations][status] = $content[12][status];
        $data[madtrack][operations][note] = $content[12][note];
        
        $data[madtrack][smoke][status] = $content[13][status];
        $data[madtrack][smoke][note] = $content[13][note];
        
        $data[madtrack][alcohol][status] = $content[14][status];
        $data[madtrack][alcohol][note] = $content[14][note];
        
        $data[madtrack][drugs][status] = $content[15][status];
        $data[madtrack][drugs][note] = $content[15][note];
        
        $data[madtrack][allergies][status] = explode(",", $content[16][val]);
        $data[madtrack][allergies][note] = explode(",", $content[16][note]);
        
        $data[madtrack][symptoms][status] = explode(",", $content[17][val]);
        $data[madtrack][symptoms][note] = explode(",", $content[17][note]);
        
        $data[madtrack][drug][status] = explode(",", $content[18][val]);
        $data[madtrack][drug][note] = explode(",", $content[18][note]);
        
        $data[madtrack][diseases][status] = explode(",", $content[19][val]);
        $data[madtrack][diseases][note] = explode(",", $content[19][note]);
        
        return $data;
    }
    
    // use depricated
    function prepContent($content)
    {
            
        $temp = explode(",", $content[0][val]);
        
        $data[goals][weight] = $temp[0];
        $data[goals][fat] = $temp[1];
        $data[goals][question] = explode(",", $content[1][val]);
        
        $data[stats][sex] = $content[2][val];
        $data[stats][height] = explode(",", $content[3][val]);
        $temp = explode(",", $content[4][val]);
        $data[stats][weight] = $temp[0];
        $data[stats][fat] = $temp[1];
        $data[stats][ph] = $temp[2];
        
        
        $data[stats][blood_p] = explode(",", $content[5][val]);
        $data[stats][blood_t] = $content[6][val];
        
        $data[body_type] = explode(",", $content[7][val]);
        $data[life_style] = explode(",", $content[8][val]);
        $data[file] = explode(",", $content[9][val]);
        
        
        $data[madtrack][exem] = $content[10][val];
        
        $data[madtrack][treatment][status] = $content[11][status];
        $data[madtrack][treatment][note] = $content[11][note];
        
        $data[madtrack][operations][status] = $content[12][status];
        $data[madtrack][operations][note] = $content[12][note];
        
        $data[madtrack][smoke][status] = $content[13][status];
        $data[madtrack][smoke][note] = $content[13][note];
        
        $data[madtrack][alcohol][status] = $content[14][status];
        $data[madtrack][alcohol][note] = $content[14][note];
        
        $data[madtrack][drugs][status] = $content[15][status];
        $data[madtrack][drugs][note] = $content[15][note];
        
        
		
		
		$data[madtrack][allergies][status] = explode(",", $content[16][val]);
        
		
        $data[madtrack][symptoms][status] = explode(",", $content[17][val]);
        
		
        $data[madtrack][drug][status] = explode(",", $content[18][val]);
        
		
        $data[madtrack][diseases][status] = explode(",", $content[19][val]);
        
		return $data;
    }
    
    function show_repo_total($tpl = null)
    {
        $model = $this->getModel();
        
        if(JRequest::getVar('c')){
            $uid = JRequest::getVar('c');
        }else{
            $user =& JFactory::getUser();
            $uid = $user->id;
        }
        
        $target = $model->getTargets($uid);
        $target = $this->parseTargets($target);
        $this->assignRef('target', $target);
        
        $current = $model->getIntakeData($uid);
        
        $result[body] = explode(",", $current[1][val]);
        $this->assignRef('current', $result);
        
        $bodyHistory = $model->getBodyHistory($uid, "body");
        $this->assignRef('bodyHistory', $bodyHistory);
        
        parent::display($tpl);
    }
    
    function parseTargets($target)
    {
        $result[target_height] = explode(",", $target[3][val]);
        $result[target_body] = explode(",", $target[0][val]);
        $result[blood_type] = $target[6][val];
        $result[target_bmi] = "18,5 - 25";
        return $result;
    }
    
    //use
    function show_detail($tpl = null){
        $post = Jrequest::get(post);
        $pid = $post[pid];
        $uid = $post[uid];
        $model = $this->getModel();
        
        //Имя фазы
        $name = $model->getPhaseName($pid);
        $this->assignRef('name', $name);
           
        // выбираем уникальные даты по фазе        
        $phaseDates = $model->getPhaseDates($pid);

        // если что-то есть - формируем контент
        if(count($phaseDates) !== 0){
            //первичная инфа(goals & pid=0)
            $inteke = $model->getFirstContent($uid);
            
            
            $inteke2 = $model->getDefaultContent($uid);
            $content2[goal] = $this->parse_dirty_content($inteke2);
            
            
            for($i=0;  count($phaseDates)>$i; $i++){
                $date = $phaseDates[$i][date];
                $data = $model->getC($date, $pid);
                $content2[content][$i] = $this->parse_dirty_content($data);
                $content2[content][$i][body][val][] = $date;
            }
            
            if($content2 == null){
                global $mainframe;
                $mainframe->redirect("index.php?option=com_phase&controller=client&action=show_repo&c=$uid", "impossible show this phase");
            }
            
            $list = $this->medtrackList();
            
            $this->assignRef('content2', $content2);
            $this->assignRef('list', $list);
        }else {
            global $mainframe;
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=show_repo&c=$uid", "impossible show this phase");
        }

        $dates[] = "Intake data";
        $weight[] = $content2[goal][body][val][0]; 
        $fat[] =  $content2[goal][body][val][1];
        $ph[] =  $content2[goal][body][val][2];
    
        if($content2 !== null){
            foreach ($content2[content] as $value){
                $dates[] = $value[body][val][3];
                $weight[] = $value[body][val][0];
                $fat[] = $value[body][val][1];
                $ph[] = $value[body][val][2];
            }
        }


        $g_name = "goal";
        $g_weight = $content2[goal][goals_body][val][0]; 
        $g_fat =  $content2[goal][goals_body][val][1];
        $g_ph =  "7";

        $d = $this->buidCharFortDeteil($dates, $weight, $g_weight, 'Weight');
        $this->assignRef('d', $d);

        $d1 = $this->buidCharFortDeteil($dates, $fat, $g_fat, 'Fat');
        $this->assignRef('d1', $d1);

        $d2 = $this->buidCharFortDeteil($dates, $ph, $g_ph, 'Fat');
        $this->assignRef('d2', $d2);
    
    
        parent::display($tpl);
    }
    
    //new
    function buidCharFortDeteil($dates, $weight, $g_weight, $name){
        
        for($i = 0; $i < count($dates); $i++){
            $t = ",['".$dates[$i]."', ".$weight[$i].", ".$g_weight."]";
            $b = $b."".$t;
        }
        $a = "[['Date', '".$name."', 'Goal']";
        $c = "]";    
        $d = $a."".$b."".$c;
        
        return $d;
    }
    
    
    
    function show_total_repo($tpl = null)
    {
        
        $model = $this->getModel();
        $uid = JRequest::getvar('c');
    

        
        //первичная инфа(goals & pid=0)
        $inteke = $model->getFirstContent($uid);
                
        if(count($inteke) !== 0 && $inteke !== null && $inteke)
            {
                
                foreach ($inteke as $value){
                    if($value[name] == "goals_body"){
                        $res[goal_body] = explode(",", $value[val]);
                        $res[date] = $value[date];
                    }

                    if($value[name] == "photo"){
                        $res[photo] = explode(",", $value[val]);
                    }
                    
                    if($value[name] == "body"){
                        $res[body] = explode(",", $value[val]);
                    }
                    
                }
                
                if (isset($res[goal_body])){
                        $gols[goal_body][date] = $res[date];
                        $gols[goal_body][val] = $res[goal_body];
                    }
                
                if (isset($res[photo])){
                        $gols[photo][date] = $res[date];
                        $gols[photo][val] = $res[photo];
                    }
                
                if (isset($res[body])){
                        $gols[body][date] = $res[date];
                        $gols[body][val] = $res[body];
                    }
                
                $this->assignRef('gols', $gols);
                   
        }
        else{
            global $mainframe;
            $mainframe->redirect('index.php?option=com_phase&controller=client&action=lastintake',"Enter intake data");
        }
        
        
        // id фаз
        $phases_id = $model->getPhasesId($uid);
        

        
        if($phases_id && count($phases_id) !== 0 && $phases_id !== null){



            foreach($phases_id as $value){
                $pid =  $value[id];
                $pn = $model->getPhaseName($pid);

                $data[$pn] = $model->testPhaseData($uid, $pid);
                }
        
        



        foreach ($data as $key => $value) {
            foreach ($value as $value) {
                if($value[name] == "life_style"){
                $content[$key][life_style][val] = explode(",", $value[val]);
                }
                
                if($value[name] == "body"){
                    $content[$key][body][val] = explode(",", $value[val]);
                }
                
                if($value[name] == "photo"){
                    $content[$key][photo][val] = explode(",", $value[val]);
                }
                
                if($value[name] == "symptoms"){
                    $content[$key][symptoms][val][name] = explode(",", $value[val]);
                    $content[$key][symptoms][val][status] = explode(",", $value[status]);
                    $content[$key][symptoms][val][note] = explode(",", $value[note]);    
                }
                
                if($value[name] == "drug"){
                    $content[$key][drug][val][name] = explode(",", $value[val]);
                    $content[$key][drug][val][status] = explode(",", $value[status]);
                    $content[$key][drug][val][note] = explode(",", $value[note]);  
                }

                if($value[name] == "diseases"){
                    $content[$key][diseases][val][name] = explode(",", $value[val]);
                    $content[$key][diseases][val][status] = explode(",", $value[status]);
                    $content[$key][diseases][val][note] = explode(",", $value[note]);  
                }
            }
        }
        
        
            $this->assignRef('content', $content);
        }    
    

    
        //Взять список симпомов
        $list[symptomList] = $model->getSymptomList();

        //Взять список препараты
        $list[medtrackList] = $model->getMedtrackList();
        
        //Взять список заболеваний
        $list[diseasesList] = $model->getDiseasesList();

        $this->assignRef('list', $list);

        $this->assignRef('content', $content);
     
        parent::display($tpl);
    }
    
    //use
    function compare($tpl = null){
        $model = $this->getModel();
        $post = Jrequest::get(post);
        $uid = $post[uid];
        $this->assignRef('uid', $uid);
        $pid_1 = $post[phaseId][0];
        $pid_2 = $post[phaseId][1];
        
        $phases_id = $model->getPhasesId($uid);
        $this->assignRef('phases', $phases_id);
        global $mainframe;
        if($pid_1 == $pid_2){
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=show_repo&c=$uid", "impossible to compare the same phase");
        }
        
        
        $dirty_content_1 = $model->testPhaseData($uid, $pid_1);
        $dirty_content_2 = $model->testPhaseData($uid, $pid_2);
        if($dirty_content_1 == null || $dirty_content_2 == null){
            global $mainframe;
            $mainframe->redirect('index.php?option=com_phase&controller=client',"System error");
        }
        else{
            $evalution_1 = $this->parse_dirty_content($dirty_content_1);
            $evalution_2 = $this->parse_dirty_content($dirty_content_2);
            
            if($pid_1 == 0) {$evalution_1[name] = 'Phase 0 - Intake Survey';}
            else {$evalution_1[name] = $model->getPhaseName($pid_1);}

            if($pid_2 == 0) {$evalution_2[name] = 'Phase 0 / Intake Survey';}
            else {$evalution_2[name] = $model->getPhaseName($pid_2);}

            if($evalution_1[life_style][val][0] !== "" || $evalution_1[life_style][val][0] !== null){
                $res = implode(",", $evalution_1[life_style][val]);
                $qAnswers1 = $model->getQAnswers($res);
                $this->assignRef('qAnswers1', $qAnswers1);
                $trackingStart1 = $model->getProgressTrackingDetails($uid, $pid_1, $res);
            }
            
            if($evalution_2[life_style][val][0] !== "" || $evalution_2[life_style][val][0] !== null){
                $res2 = implode(",", $evalution_2[life_style][val]);
                $qAnswers2 = $model->getQAnswers($res2);
                $this->assignRef('qAnswers2', $qAnswers2);
                $trackingStart2 = $model->getProgressTrackingDetails($uid, $pid_2, $res2);
            }
            
            $this->assignRef('evalution_1', $evalution_1);
            $this->assignRef('evalution_2', $evalution_2);
                
            $medtrack = $this->medtrackList();
            $this->assignRef('list', $medtrack);
        }
        
        
        if(count($evalution_1[body][val]) == 3 && count($evalution_2[body][val]) == 3){
            
            $a = "[['Weigth', 'Phase 1', 'Phase 2']";
            $b = ",['Weigth',  ".$evalution_1[body][val][0].",  ".$evalution_2[body][val][0]."]";
            $c = "]";    
            $d[] = $a."".$b."".$c;
            
            $a2 = "[['Fat', 'Phase 1', 'Phase 2']";
            $b2 = ",['Fat',  ".$evalution_1[body][val][1].",  ".$evalution_2[body][val][1]."]";
            $c2 = "]";    
            $d[] = $a2."".$b2."".$c2;
            
            $a3 = "[['Ph', 'Phase 1', 'Phase 2']";
            $b3 = ",['Ph',  ".$evalution_1[body][val][2].",  ".$evalution_2[body][val][2]."]";
            $c3 = "]";    
            $d[] = $a3."".$b3."".$c3;
            
            $this->assignRef('charts', $d);
        }
            
        if($trackingStart1->cats !== null){
            $vari = explode(",", $trackingStart1->cats);
        }else{
            $str = "Digestive,Intestinal,Circulatory,Nervous,Immune,Respiratory,Urinary,Glandular,Structural";
            $vari = explode(",", $str);
        }


        foreach ($vari as $value) {
            $resi[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
        }


        $vari2 = explode(",", $trackingStart1->opp_vals);
        foreach ($vari2 as $value) {
           $resi2[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
        }

        if($resi2[0] == ""){
            unset ($resi2);
            for($i = 0; $i<9; $i ++){$resi2[] = 100;}
        }

        $vari3 = explode(",", $trackingStart2->opp_vals);
        foreach ($vari3 as $value) {
           $resi3[] = preg_replace ("/[^a-zA-ZА-Яа-я0-9\s]/","",$value);
        }

        if($resi3[0] == "")
        {
            unset ($resi3);
            for($i = 0; $i<9; $i ++){$resi3[] = 100;}
        }

        for($i = 0; $i < count($resi); $i++){
            $ti = ",['".$resi[$i]."', ".$resi2[$i].", ".$resi3[$i]."]";
            $bi = $bi."".$ti;
        }
        $ai = "[['step', '".$this->evalution_1[name]."', '".$this->evalution_2[name]."']";
        $ci = "]";    
        $di = $ai."".$bi."".$ci;
        $this->assignRef('charts_life', $di);
        
        if(count($evalution_1[symptoms][status] > 0) && $evalution_1[symptoms][status][0] !== "" ){
            $s1 = $this->data_for_medtrack_charts($evalution_1[symptoms][status]);
            $this->assignRef('s1', $s1);
	}
        
        if(count($evalution_2[symptoms][status] > 0) && $evalution_2[symptoms][status][0] !== "" ){
            $s2 = $this->data_for_medtrack_charts($evalution_2[symptoms][status]);
            $this->assignRef('s2', $s2);
        }
	
        if(count($evalution_1[drug][status] > 0) && $evalution_1[drug][status][0] !== "" ){
            $m1 = $this->data_for_medtrack_charts($evalution_1[drug][status]);
            $this->assignRef('m1', $m1);
        }
		
        if(count($evalution_2[drug][status] > 0) && $evalution_2[drug][status][0] !== "" ){
            $m2 = $this->data_for_medtrack_charts($evalution_2[drug][status]);
            $this->assignRef('m2', $m2);
        }

        if(count($evalution_1[diseases][status] > 0) && $evalution_1[diseases][status][0] !== "" ){
            $d1 = $this->data_for_medtrack_charts($evalution_1[diseases][status]);
            $this->assignRef('d1', $d1);
        }
		
        if(count($evalution_2[diseases][status] > 0) && $evalution_2[diseases][status][0] !== "" ){
            $d2 = $this->data_for_medtrack_charts($evalution_2[diseases][status]);
            $this->assignRef('d2', $d2);
        }

        parent::display($tpl);
    }
    
    //new
    function data_for_medtrack_charts($var){
        $cnt_s1_new = 0;
                    $cnt_s1_progres = 0;
                    $cnt_s1_fin = 0;
                    foreach($var as $val){
                            if($val == "finished"){$cnt_s1_fin++;}
                            elseif($val == "new"){$cnt_s1_new++;}
                            else{$cnt_s1_progres++;}
                    }

                    $s1 =	"[
                                    ['Task', 'cnt'],
                                    ['New',    ".$cnt_s1_new."],
                                    ['In progress',    ".$cnt_s1_progres."],
                                    ['Finished',     ".$cnt_s1_fin."]
                                    ]";
                    return $s1;
    }
            
}