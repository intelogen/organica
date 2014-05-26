<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');


class PhaseViewClient extends JView
{
    function display($tpl = null)
    {
        
        $layout = JRequest::getVar('layout');
        
        
        
        if ($layout)
        {
            $this->$layout($tpl);
            return;
            
        }
         
        parent::display($tpl);
    }
    
    function deshbord($tpl = null)
    {
        $user =& JFactory::getUser();
        $userId = $user->id;
        $model = $this->getModel();
        $userPhases = $model->getUserPhases($userId);
        $userPhases2 = $model->getUserPhases($userId);
        
        //echo '<pre>';
        //var_dump($userPhases2);
        $i = 0;
        foreach ($userPhases2 as $userPhases2)
        {   
            $i++;
            $pid[$i] = $userPhases2->id."<br>";
        }
        $allCountTask = $model->getCount($pid);
        $this->assignRef('count', $allCountTask);
        $finishCountTask = $model->getFinishCount($pid);
        $this->assignRef('finishCountTask', $finishCountTask);
        
        
        
        if ($userPhases == null){ echo 'You dont have any phase yet';}
        $this->assignRef('userPhases', $userPhases);
        parent::display($tpl);
    }
    
    function show_phases_tasks($tpl = null)
    {
        $phaseId = JRequest::getVar('phase');
        $model = $this->getModel();
        $phasesTasks = $model->getPhasesTasks($phaseId);
        $this->assignRef('phasesTasks', $phasesTasks);
        parent::display($tpl);
    }
    
    function show_tasks($tpl = null)
    {
        $taskId = JRequest::getVar('task');
        $model = $this->getModel();
        $taskData = $model->getTaskData($taskId);
        $this->assignRef('taskData', $taskData);
        
        
        parent::display($tpl);
    }
    
    function show_my_coach($tpl = null)
    {
        $user =& JFactory::getUser();
        $userId = $user->id;
        $model = $this->getModel();
        $companyId = $model->getCompanyId($userId);
        foreach ($companyId as $companyId) { $companyId = $companyId->company;}
        $coachInfo = $model->getCoachInfo($companyId);
        $this->assignRef('coachInfo', $coachInfo);
        parent::display($tpl);
    }
    
    
    function finish_task($tpl = null)
    {
        $taskId = JRequest::getVar('taskId');
        $model = $this->getModel();
        $result = $model->finishTask($taskId);
        if ($result)
        {
            $msg = JText::_('Task completed');
        }
        else
        {
            $msg = JText::_('Task not completed');
        }
        global $mainframe;
        $mainframe->redirect('index.php?option=com_phase&controller=client&action=deshbord', $msg);
        
        parent::display($tpl);
    }
    
    
    function first_survey($tpl)
    {
        
        parent::display($tpl);
    }
    
    
    function your_aim($tpl)
    {
        $model = $this->getModel();
        $aim = $model->getAim();
        $this->assignRef('aim', $aim);
        parent::display($tpl);
    }
            
    //опросс в начале фазы
    function start_survey($tpl = null)
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
       
    
    
    
    function body_score_survey($tpl)
    {
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
        if(JRequest::getVar('in') == 1)
        {
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
            
            
            //echo "<pre>";
            //var_dump($evalution);
            //echo '</pre>';
             
            /*
            $_SESSION['evalution'] = $evalution;
            
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=lastintake_confirm");
            */
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
            $mainframe->redirect("index.php?option=com_phase&controller=client");
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
        
        if(JRequest::getVar('ph') == 1)
        {
            $model = $this->getModel();
            
            $data =  $this->preparePhaseData();
            
           
            $result = $model->recPhasaData($data);
            
            global  $mainframe;
            if(result)
            {
                $mainframe->redirect("index.php?option=com_phase&controller=client","yra");
            }
            else
            {
                $mainframe->redirect("index.php?option=com_phase&controller=client","gora");
            }
            
        }
        
        parent::display($tpl);
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
        
        
        
        
        parent::display($tpl);
    }
    
    function prepareData()
    {
        $post = JRequest::get('post');
        $evalution = $post[evalution];
        $file  = JRequest::get("files");    
            if(!empty($evalution[madtrack][new_allergies][name]))
            {
                $evalution[madtrack][allergies][name][] = $evalution[madtrack][new_allergies][name];
                $evalution[madtrack][allergies][note][] = $evalution[madtrack][new_allergies][note];
            }
            
            if(!empty($evalution[madtrack][new_symptoms][name]))
            {
                $evalution[madtrack][symptoms][name][] = $evalution[madtrack][new_symptoms][name];
                $evalution[madtrack][symptoms][note][] = $evalution[madtrack][new_symptoms][note];
            }
                        
            if(!empty($evalution[madtrack][new_diseases][name]))
            {
                $evalution[madtrack][diseases][name][] = $evalution[madtrack][new_diseases][name];
                $evalution[madtrack][diseases][note][] = $evalution[madtrack][new_diseases][note];
            }
            
            if(!empty($evalution[madtrack][new_drug][name]))
            {
                $evalution[madtrack][drug][name][] = $evalution[madtrack][new_drug][name];
                $evalution[madtrack][drug][note][] = $evalution[madtrack][new_drug][note];
            }
            
            
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
    
    function show_my_profile($tpl =null)
    {
        $user =& JFactory:: getUser();
        $userId = $user->id;
        $model = $this->getModel();
        $myInfo = $model->getMyInfo($userId);
        
        
        $this->assignRef('myInfo', $myInfo);
        
        parent::display($tpl);
    }
    
    function edit_my_info($tpl = null)
    {
        parent::display($tpl);
        $model = $this->getModel();
        $result = $model->edit_my_info(JRequest::get('post'));
        
        if ($result)
                {
                $msg = JText::_('data save');
                }
                else
                {
                $msg = JText::_('data not save');
                }
                global $mainframe;
                
                $mainframe->redirect("index.php?option=com_phase&controller=client", $msg);
               
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
    
    
    
    
    
    
    //fuck
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
        
        parent::display($tpl);
    }
    
    function phasechek($tpl = null)
    {
        $model = $this->getModel();
        
        $pid = JRequest::getVar('pid'); 
        $user =& JFactory::getUser();
        $uid = $user->id;
        $this->assignRef('uid', $uid);
        $this->assignRef('pid', $pid);
        
        $questionList = $model->questionList();
        $this->assignRef('questionList', $questionList);
        
        
        $test = $model->getIntakeData($uid);
        
        if(count($test) == 0)
        {
            global $mainframe;
            $mainframe->redirect('index.php?option=com_phase&controller=client&action=lastintake',"Enter intake data");
        }
        else
        {
            $phaseData = $model->testPhaseData($uid, $pid);
            
            
            if(count($phaseData) == 0)
            {
                $data = $model->getIntakeData($uid);
            }
            else
            {
                $data = $phaseData;
            }
            
            
        }
        
        
        
        
        
            
        
        
        
        $evalution[life_style] = explode(",", $data[0][val]);
        $evalution[body] = explode(",", $data[1][val]);
        $evalution[photo] = explode(",", $data[2][val]);
        
        $evalution[symptoms][val] = explode(",", $data[3][val]);
        $evalution[symptoms][status] = explode(",", $data[3][status]);
        $evalution[symptoms][note] = explode(",", $data[3][note]);
        
        $evalution[drug][val] = explode(",", $data[4][val]);
        $evalution[drug][status] = explode(",", $data[4][status]);
        $evalution[drug][note] = explode(",", $data[4][note]);
        
        $evalution[diseases][val] = explode(",", $data[5][val]);
        $evalution[diseases][status] = explode(",", $data[5][status]);
        $evalution[diseases][note] = explode(",", $data[5][note]);
        
        $this->assignRef('evalution', $evalution);
        
        
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
        
        
        
        $numbers = implode(",", $evalution[life_style]);
        $trackingStart = $model->getProgressTrackingDetails($uid, $pid, $numbers);
        $this->assignRef('trackingStart', $trackingStart);
        
        
        
        
        parent::display($tpl);
    }
    
    
    function show_repo($tpl = null)
    {
        
        $model = $this->getModel();
        
        $user =& JFactory::getUser();
        $uid = $user->id;
        if(JRequest::getVar('c') && JRequest::getVar('c') != "")
        {
            $uid = JRequest::getVar('c');
        }
        
        $this->assignRef('uid', $uid);
        
        $loockingfor = $model->loockingfor();
        $this->assignRef('loockingfor', $loockingfor);
        
        $questionList = $model->questionList();
        $this->assignRef('questionList', $questionList);
        
        
        
        $content = $model->getFirstContent($uid);
        
        
        
        if(count($content) == 0)
        {
            global $mainframe;
            $mainframe->redirect('index.php?option=com_phase&controller=client&action=lastintake',"Enter intake data");
        }
        else
        {
            $content = $this->prepoContent($content);
            $this->assignRef('evalution', $content);
        }
        
        $phases_id = $model->getPhasesId($uid);
        $this->assignRef('phases', $phases_id);
        
        
        
        
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
        

        
        $numbers = implode(",", $content[life_style]);
        $trackingStart = $model->getProgressTrackingDetails($uid, $pid, $numbers);
        $this->assignRef('trackingStart', $trackingStart);
        
        
        
        
        
        
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
    
    function show_repoz($tpl = null)
    {
        $pid = JRequest::getVar('pid');
        $model = $this->getModel();
        $user =& JFactory::getUser();
        $uid = $user->id;
        if(JRequest::getVar('c') && JRequest::getVar('c') != "")
        {
            $uid = JRequest::getVar('c');
        }
        
        
        $questionList = $model->questionList();
        $this->assignRef('questionList', $questionList);
        
        $content = $model->testPhaseData($uid, $pid);
        
        
        $evalution[life_style] = explode(",", $content[0][val]);
        $evalution[body] = explode(",", $content[1][val]);
        $evalution[photo] = explode(",", $content[2][val]);
        
        $evalution[symptoms][val] = explode(",", $content[3][val]);
        $evalution[symptoms][status] = explode(",", $content[3][status]);
        $evalution[symptoms][note] = explode(",", $content[3][note]);
        
        $evalution[drug][val] = explode(",", $content[4][val]);
        $evalution[drug][status] = explode(",", $content[4][status]);
        $evalution[drug][note] = explode(",", $content[4][note]);
        
        
        $evalution[diseases][val] = explode(",", $content[5][val]);
        $evalution[diseases][status] = explode(",", $content[5][status]);
        $evalution[diseases][note] = explode(",", $content[5][note]);
        
        
        $this->assignRef('evalution', $evalution);
        
        
        
        
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
        
        
        
        $numbers = $content[0][val];
        $trackingStart = $model->getProgressTrackingDetails($uid, $pid, $numbers);
        $this->assignRef('trackingStart', $trackingStart);
        
        $phases_id = $model->getPhasesId($uid);
        $this->assignRef('phases', $phases_id);
        
        
        
        
        
        
        
        
        parent::display($tpl);
    }
    
    
    
}