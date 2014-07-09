 <?php 
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');


class PhaseViewClient extends JView{
    
    function display($tpl = null){
        $layout = JRequest::getVar('layout');
        if ($layout){
            $this->$layout($tpl);
            return;
        }
        
        parent::display($tpl);
    }
    
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
    
    function show_phases_tasks($tpl = null){
        $phaseId = JRequest::getVar('phase');
        $model = $this->getModel();
        
        $phDesc = $model->getPhDesc($phaseId);
        $this->assignRef('phaseDesc', $phDesc);
        
        $phasesTasks = $model->getPhasesTasks($phaseId);
        $this->assignRef('phasesTasks', $phasesTasks);
        
        parent::display($tpl);
    }
    
    function show_tasks($tpl = null){
        $taskId = JRequest::getVar('task');
        $model = $this->getModel();
        $taskData = $model->getTaskData($taskId);
        $this->assignRef('taskData', $taskData);
        
        parent::display($tpl);
    }
    
    function show_my_coach($tpl = null){
        $userId = JFactory::getUser()->id;
        $model = $this->getModel();
        $coachInfo = $model->coachId($userId);
        $this->assignRef('coachInfo', $coachInfo);
        parent::display($tpl);
    }

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

    function show_my_profile($tpl =null){
        $userId = JFactory:: getUser()->id;
        $model = $this->getModel();
        $myInfo = $model->getMyInfo($userId);
        $this->assignRef('myInfo', $myInfo);
        
        parent::display($tpl);
    }

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

    function save($tpl){
        $model = $this->getModel();
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
        
        if(JRequest::getVar('inc') == 1){
            session_start();
            global $mainframe;

            if(!empty($_SESSION[evalution])){
            $evalution  = $_SESSION[evalution];
            $model = $this->getModel();
            $result = $model->recLastintake($evalution);
                if(result) {
                    unset($_SESSION['evalution']);
                    $mainframe->redirect("index.php?option=com_phase&controller=client", 'information has been saved');
                } else {
                        $mainframe->redirect("index.php?option=com_phase&controller=client&action=lastintake");
                    }
            } else {
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
    
    function preparePhasechekDataSave(){
        
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
        
        if(count($post[data][content][life_style][val]) > 0 && $post[data][content][life_style][val][0] !== ""){
            $result[life_style] = implode(",", $post[data][content][life_style][val]);
        }
        
        $res = $model->saveLastintake($uid, $pid, "life_style", $result[life_style], null, null, 1, $date);
        if($res == false){return false;}
        
        if(isset($post[data][content][body][val][0]) && isset($post[data][content][body][val][1]) && isset($post[data][content][body][val][2])){
            $result[body] = implode(",", $post[data][content][body][val]);
        }
        
        $res = $model->saveLastintake($uid, $pid, "body", $result[body], null, null, 2, $date);
        if($res == false){return false;}
        
        $file  = JRequest::get("files");
        
        if(!empty($file[data][name][content][new_photo][0])){
            $file_1_name = $file[data][name][content][new_photo][0];
            $file_1_name = $post[evalution][pid]."_".$post[evalution][uid]."_".time()."_"."_f_".$file_1_name;
            $file_1_tmp_path = $file[data][tmp_name][content][new_photo][0];
            $result_1 = move_uploaded_file($file_1_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_1_name);
            $post[data][content][photo][0] = $file_1_name;
        }   
        
        if(!empty($file[data][name][content][new_photo][1])){
            $file_1_name = $file[data][name][content][new_photo][1];
            $file_1_name = $post[evalution][pid]."_".$post[evalution][uid]."_".time()."_"."_f_".$file_1_name;
            $file_1_tmp_path = $file[data][tmp_name][content][new_photo][1];
            $result_1 = move_uploaded_file($file_1_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_1_name);
            $post[data][content][photo][1] = $file_1_name;
        }
        
        
        if(isset($post[data][content][photo][0]) || isset($post[data][content][photo][1])){
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
    
    function pSympa(){
        $post = JRequest::get('post');
           
        if(isset($post[data][content][symptoms]) && $post[data][content][symptoms][name][0] !== null){
            $sympa = $post[data][content][symptoms];
            $result[name] = implode(",", $post[data][content][symptoms][name]);
            $result[status] = implode(",", $post[data][content][symptoms][status]);
            $result[note] = implode(",", $post[data][content][symptoms][note]);
        }
        
        if(isset($post[data][content][extra_symptoms][db_list]) && $post[data][content][extra_symptoms][db_list][name][0] !== null){
            unset($post[data][content][extra_symptoms][db_list][new_name]);
            $extraSympaDb = $post[data][content][extra_symptoms][db_list];
            $extraSympaDb[name] = implode(",", $post[data][content][extra_symptoms][db_list][name]);
            $extraSympaDb[status] = implode(",", $post[data][content][extra_symptoms][db_list][status]);
            $extraSympaDb[note] = implode(",", $post[data][content][extra_symptoms][db_list][note]);
            if(isset($result[name]) && isset($result[status]) && isset ($result[note])){
                $result[name] = $result[name].",".$extraSympaDb[name];
                $result[status] = $result[status].",".$extraSympaDb[status];
                $result[note] = $result[note].",".$extraSympaDb[note];
            } else{
                $result[name] = $extraSympaDb[name];
                $result[status] = $extraSympaDb[status];
                $result[note] = $extraSympaDb[note]; 
            }
        }

        if(isset($post[data][content][extra_symptoms][user_list]) && $post[data][content][extra_symptoms][user_list][name][0] !== null){
            unset($post[data][content][extra_symptoms][user_list][new_name]);
            $extraSympaU = $post[data][content][extra_symptoms][user_list];
            $model = $this->getModel();
            
            foreach($post[data][content][extra_symptoms][user_list][name] as $value){
				$extra_list[] = $model->recordNewSymptom($value);
            }
            
            $extraSympaU[name] = implode(",", $extra_list);
            $extraSympaU[status] = implode(",", $post[data][content][extra_symptoms][user_list][status]);
            $extraSympaU[note] = implode(",", $post[data][content][extra_symptoms][user_list][note]);
            if(isset($result[name]) && isset($result[status]) && isset ($result[note])){
                $result[name] = $result[name].",".$extraSympaU[name];
                $result[status] = $result[status].",".$extraSympaU[status];
                $result[note] = $result[note].",".$extraSympaU[note];
            } else{
                $result[name] = $extraSympaU[name];
                $result[status] = $extraSympaU[status];
                $result[note] = $extraSympaU[note]; 
            }
        }
        
        return $result;   
    }
    
    function pDrug(){
        $post = JRequest::get('post');
        
        if(isset($post[data][content][drug]) && $post[data][content][drug][name][0] !== null){
            $sympa = $post[data][content][drug];
            $result[name] = implode(",", $post[data][content][drug][name]);
            $result[status] = implode(",", $post[data][content][drug][status]);
            $result[note] = implode(",", $post[data][content][drug][note]);
        }

        if(isset($post[data][content][extra_drug][db_list]) && $post[data][content][extra_drug][db_list][name][0] !== null){
            unset($post[data][content][extra_drug][db_list][new_name]);
            $extraSympaDb = $post[data][content][extra_drug][db_list];
            $extraSympaDb[name] = implode(",", $post[data][content][extra_drug][db_list][name]);
            $extraSympaDb[status] = implode(",", $post[data][content][extra_drug][db_list][status]);
            $extraSympaDb[note] = implode(",", $post[data][content][extra_drug][db_list][note]);
            if(isset($result[name]) && isset($result[status]) && isset ($result[note])){
                $result[name] = $result[name].",".$extraSympaDb[name];
                $result[status] = $result[status].",".$extraSympaDb[status];
                $result[note] = $result[note].",".$extraSympaDb[note];
            } else {
                $result[name] = $extraSympaDb[name];
                $result[status] = $extraSympaDb[status];
                $result[note] = $extraSympaDb[note]; 
            }
        }

        if(isset($post[data][content][extra_drug][user_list]) && $post[data][content][extra_drug][user_list][name][0] !== null){
            unset($post[data][content][extra_drug][user_list][new_name]);
            $extraSympaU = $post[data][content][extra_drug][user_list];
            $model = $this->getModel();
            
            
            foreach($post[data][content][extra_drug][user_list][name] as $value){
				$extra_list[] = $model->recordNewDrug($value);
            }
            
            $extraSympaU[name] = implode(",", $extra_list);
            $extraSympaU[status] = implode(",", $post[data][content][extra_drug][user_list][status]);
            $extraSympaU[note] = implode(",", $post[data][content][extra_drug][user_list][note]);
            if(isset($result[name]) && isset($result[status]) && isset ($result[note])){
                $result[name] = $result[name].",".$extraSympaU[name];
                $result[status] = $result[status].",".$extraSympaU[status];
                $result[note] = $result[note].",".$extraSympaU[note];
            } else {
                $result[name] = $extraSympaU[name];
                $result[status] = $extraSympaU[status];
                $result[note] = $extraSympaU[note]; 
            }
        }
        
        return $result;
    }
    
    function pDiseases(){
        $post = JRequest::get('post');
        
        if(isset($post[data][content][diseases]) && $post[data][content][diseases][name][0] !== null){
            $sympa = $post[data][content][drug];
            $result[name] = implode(",", $post[data][content][diseases][name]);
            $result[status] = implode(",", $post[data][content][diseases][status]);
            $result[note] = implode(",", $post[data][content][diseases][note]);
        }

        if(isset($post[data][content][extra_diseases][db_list]) && $post[data][content][extra_diseases][db_list][name][0] !== null){
            unset($post[data][content][extra_diseases][db_list][new_name]);
            $extraSympaDb = $post[data][content][extra_diseases][db_list];
            $extraSympaDb[name] = implode(",", $post[data][content][extra_diseases][db_list][name]);
            $extraSympaDb[status] = implode(",", $post[data][content][extra_diseases][db_list][status]);
            $extraSympaDb[note] = implode(",", $post[data][content][extra_diseases][db_list][note]);
            if(isset($result[name]) && isset($result[status]) && isset ($result[note])){
                $result[name] = $result[name].",".$extraSympaDb[name];
                $result[status] = $result[status].",".$extraSympaDb[status];
                $result[note] = $result[note].",".$extraSympaDb[note];
            } else {
                $result[name] = $extraSympaDb[name];
                $result[status] = $extraSympaDb[status];
                $result[note] = $extraSympaDb[note]; 
            }
        }
        
        if(isset($post[data][content][extra_diseases][user_list][name]) && $post[data][content][extra_diseases][user_list][name][0] !== null){
            //unset($post[data][content][extra_diseases][user_list][new_name]);
            $extraSympaU = $post[data][content][extra_diseases][user_list];
            $model = $this->getModel();
            
            foreach($post[data][content][extra_diseases][user_list][name] as $value){
				$extra_list[] = $model->recordNewDiseases($value);
            }
            
            $extraSympaU[name] = implode(",", $extra_list);
            $extraSympaU[status] = implode(",", $post[data][content][extra_diseases][user_list][status]);
            $extraSympaU[note] = implode(",", $post[data][content][extra_diseases][user_list][note]);
            if(isset($result[name]) && isset($result[status]) && isset ($result[note])){
                $result[name] = $result[name].",".$extraSympaU[name];
                $result[status] = $result[status].",".$extraSympaU[status];
                $result[note] = $result[note].",".$extraSympaU[note];
            } else {
                $result[name] = $extraSympaU[name];
                $result[status] = $extraSympaU[status];
                $result[note] = $extraSympaU[note]; 
            }
            
        }
        
       return $result;
    }
    
    function prepareData(){
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
    
    function lastintake($tpl = null){
        session_start();
        $model = $this->getModel();
        
        if(!empty($_SESSION[evalution])){
        $evalution  = $_SESSION[evalution];
        $this->assignRef('evalution', $evalution);
        unset($_SESSION['evalution']);
        }
        
        $user =& JFactory::getUser();
        $uid = $user->id;
        $this->assignRef('uid', $uid);
        
        $test = $model->lastintakeTest($uid);
        if($test != 0){
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
    
    function lastintake_confirm(){
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

    function parse_dirty_content($var){
        foreach ($var as $value){
            $test[$value[name]][val] = explode(",", $value[val]);
            $test[$value[name]][status] = explode(",", $value[status]);
            $test[$value[name]][note] = explode(",", $value[note]);
        }
        return $test;
    }

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

    function show_repoz($tpl = null){
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

    function show_total_repo($tpl = null){
        $model = $this->getModel();
        $uid = JRequest::getvar('c');
    
        $inteke2 = $model->getFirstContent($uid);
        $content2[inteke] = $this->parse_dirty_content($inteke2);
        $phases_id2 = $model->getPhasesId($uid);
        if(count($phases_id2) !== 0 && $phases_id2 !== null){
            foreach($phases_id2 as $value){
                $pid2 =  $value[id];
                $pn2 = $value[name];
                $data2 = $model->testPhaseData($uid, $pid2);
                $content2[content][$pn2] = $this->parse_dirty_content($data2);
            }
        }
        $this->assignRef('content2', $content2);
        
        $list = $this->medtrackList();
        $this->assignRef('list', $list);

        if($content2[inteke][body][val][0] !== "" && $content2[inteke][body][val][1] !== "" && $content2[inteke][body][val][2] !== ""){
                $date[] = "Intake data";
                $weight[] = $content2[inteke][body][val][0];
                $fat[] = $content2[inteke][body][val][1];
                $ph[] = $content2[inteke][body][val][2];
        }

            
        if($content2[content] !== null){
            foreach ($content2[content] as $key => $value) {
                $date[] = "$key";
                $weight[] = $value[body][val][0];
                $fat[] = $value[body][val][1];
                $ph[] = $value[body][val][2];
            }
        }
            
        if($content2[inteke][goals_body][val][0] !== "" && $content2[inteke][goals_body][val][1] !== ""){
            $g_weight = $content2[inteke][goals_body][val][0];
            $g_fat =  $content2[inteke][goals_body][val][1];
            $g_ph =  7;
        } 

        $d = $this->buidCharFortDeteil($date, $weight, $g_weight, 'Weight');
        $this->assignRef('d', $d);
        
        $d1 = $this->buidCharFortDeteil($date, $fat, $g_fat, 'Fat');
        $this->assignRef('d1', $d1);
        
        $d2 = $this->buidCharFortDeteil($date, $ph, $g_ph, 'Ph');
        $this->assignRef('d2', $d2);
     
        parent::display($tpl);
    }

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
            $mainframe->redirect("index.php?option=com_phase&controller=client&action=show_repo&c=$uid", "impossible to compare the same phase");
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