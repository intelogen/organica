<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 jimport('joomla.application.component.model');
 
 
class PhaseModelClient extends JModel
{
         
    function __construct(){
        parent::__construct();
    }
    
    //use depricated
    function getCompanyId($userId){
        $query = "SELECT company FROM #__jf_persons WHERE uid = $userId";
        return $this->_getList($query);
    }
    
    //use depricated
    function getCoachInfo($companyId){
        $query = "SELECT * FROM #__jf_companies WHERE id = $companyId";
        return $this->_getList($query);

    }
    
    // new = getCompanyId + getCoachInfo
    function coachId($userId){
        $query = "SELECT * FROM #__jf_companies WHERE id = (SELECT company FROM #__jf_persons WHERE uid = $userId)";
        return $this->_getList($query);
    }
    
    //use
    function getMyInfo($userId){
        $row = & JTable::getInstance('Users');
        $row->load($userId);
        return $row;
    }
    
    //use - depricated
    function edit_my_info($var){
        $row = & JTable::getInstance('Users');
        $row->load($var[id]);
        
        $data = $var;
        
        
        if (!$row->bind($data))
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
        
        return true;
    }
    
    // new = edit_my_info
    function edit_user_info(){
        $row = & JTable::getInstance('Users');
        $row->load(JRequest::get('post')->id);
        
        if (!$row->bind(JRequest::get('post'))){
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if (!$row->check()){
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        if (!$row->store()){
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        return true;
    }
     
    //use - dipricated
    function getUserPhases($userId){
         $query = "SELECT * FROM #__jf_projects WHERE leader = $userId AND published =1 ORDER BY id";
         return $this->_getList($query);
    }
    
    // new = getUserPhases
    function getPhases($var){
        $query = "SELECT id, name FROM #__jf_projects WHERE leader = $var AND published =1 ORDER BY id";
        $db =& JFactory::getDBO();
        $db->setQuery($query);
        return $db->loadAssocList();
        }
        
    // use - depricated
    function getCount($pid){
        for ($i = 1; $i<=count($pid); $i++)
        {
            $c = (int)$pid[$i];
            $countTask[$c] = $this->cnt((int)$pid[$i]);
        }
        return $countTask;
     }
    
    //use - depricated
    function cnt($idp){
        $query = "SELECT COUNT('id') as allCount FROM #__jf_checklists WHERE pid = $idp";
        return $this->_getList($query);
    }
    
    // new = getCount + cnt
    function taskCnt($var){
        $db =& JFactory::getDBO();
            foreach ($var as $value){
                $query = "SELECT COUNT('id') AS taskCnt FROM #__jf_checklists WHERE pid = $value";
                $db->setQuery($query);
                $taskCnt[] = $db->loadResult();
            }
        return $taskCnt;
    }
    
    //use - depricated
    function getFinishCount($pid){
        for ($i = 1; $i<=count($pid); $i++)
        {
            $c = (int)$pid[$i];
            $countTask[$c] = $this->fcnt((int)$pid[$i]);
        }
        return $countTask;
     }
    
     //use - depricated
    function fcnt($idp){
        $query = "SELECT COUNT('id') as allCount FROM #__jf_checklists WHERE pid = $idp AND completed = 1";
        return $this->_getList($query);
    }
    
    // new = getFinishCount + fcnt
    function allFinCnt($var){
        $db =& JFactory::getDBO();
            foreach ($var as $value){
                $query = "SELECT COUNT('id') as allCount FROM #__jf_checklists WHERE pid = $value AND completed = 1";
                $db->setQuery($query);
                $taskCnt[] = $db->loadResult();
            }
        return $taskCnt;
    }
    
    // use
    function getPhasesTasks($phaseId)
     {
         $query = "SELECT * FROM #__jf_checklists WHERE pid = $phaseId ORDER BY id";
         return $this->_getList($query);
     }
     
    //use - dipricated
    function getPhasesDesc($phaseId){
        $db =& $this->_db;
        $query = "SELECT * FROM  #__jf_projects WHERE id = $phaseId";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return  $db->loadAssocList();
    }
    
    //new = getPhasesDesc
    function getPhDesc($var){
        $db =& $this->_db;
        $query = "SELECT name, description FROM  #__jf_projects WHERE id = $var";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return  $db->loadAssocList();
    }
     
    // use
    function getTaskData($taskId){
         $query = "SELECT * FROM #__jf_checklists WHERE id = $taskId";
         return $this->_getList($query);
    }
     
    // use
    function finishTask($taskId){
        $row = & JTable::getInstance('Checklist');
        $row->load($taskId);
        $row->set('completed', 1);
        if(!$row->store()){
            $this->setError($this->_db->getErrorMsg());
            return false;  
        }
  
        return true;
     }
    
     
     
    
    
    
    
    
    
    
    
    
    function getQuestions()
    {
        $query = "SELECT * FROM #__jf_jtpl_survey_body_score ORDER BY id";
        return $this->_getList($query);
    }
    
    function getMedic()
    {
        $query = "SELECT * FROM #__jf_jtpl_survey_medtrack";
        return $this->_getList($query);
    }
    
    function getAim()
    {
        $query = "SELECT * FROM #__jf_jtpl_survey_looking_for";
        return $this->_getList($query);
    }
    
    function saveFirstAim($aim, $key, $userId)
    {
        $row = & JTable::getInstance('Survey');
        
        $row->load();
        $row->user_id = $userId;
        $row->survey_variable = "aim";
        $row->survey_value = $aim;
        $row->key  = $key;
        
        echo '<pre>';
        var_dump($row);
        
        if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        
        }
    
        
        
        
    }
    
    function recordStep1($step1, $pid, $uid, $time)
    {
        
        
        $name = "bodyscore";
        $step = 1;
        
        $id = $this->checkTemp($uid, $step);
        
        $temp = $this->tempRecord($id, $step1, $pid, $uid, $time, $name, $step);
        
        if($temp)
        {
            

                $row = & JTable::getInstance('Bodyscore');
                $row->load();

                $row->user_id = $uid;
                $row->pid = $pid;
                $row->name = $name;
                $row->val= $step1;
                $row->time= $time;
                $row->step = $step;





            if (!$row->check())
                {
                $this->setError($this->_db->getErrorMsg());
                return false;
                }

            if (!$row->store()) 
                {
                $this->setError($this->_db->getErrorMsg());
                return false;
                }

            return true;
        }
        else
        {
         return false;   
        }
    }
    
    function checkTemp($uid, $step)
    {
        $db =& JFactory::getDBO();
        $sql = "SELECT id FROM #__jf_my_temp_bodyscore WHERE user_id = $uid AND step = $step ";
        $db->setQuery($sql);
        $ids = $db->loadResult();
        
        if($ids == null)
        {
            return false;
        }
        else
        {
            return $ids;
        }

    }
    
    function tempRecord($id, $val, $pid, $uid, $time, $name, $step)
    {
        $temp = & JTable::getInstance('Tempbodyscore');
        
        $id ? $temp->load($id) : $temp->load();
        
        $temp->user_id = $uid;
        $temp->pid = $pid;
        $temp->name = $name;
        $temp->val= $val;
        $temp->time= $time;
        $temp->step = $step;
        
        if (!$temp->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$temp->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
    
    return true;
        
    }
    
    function tempRecordSurvay($uid, $pid, $name, $val)
    {
        $val = explode(",", $val);
        
        
        for ($i = 0; $i<count($val); $i++)
        {
            $db =& $this->_db;
            $query = "SELECT name FROM #__jf_my_symptoms WHERE owner = $uid AND id = $val[$i]";
            $ids = $this->_getList($query);
            $db->setQuery($query);
            $res =  $db->loadResult();
            $res == null ? $res = "no" : $res = $res;
            
            $temp = & JTable::getInstance('Tempmysurv');
            $temp->load();
            
            $temp->user_id = $uid;
            $temp->project_id = $pid;
            $temp->cat = $name;
            $temp->val = $res;
            $temp->check();
            $temp->store();
        }
        
        //echo '<pre>';
        //var_dump($temp);
    }
    
    
    
    
    
    
    
    function recordStep2($pid, $uid, $step2, $time)
    {
        $name = "fat";
        $step = 2;
        
        $id = $this->checkTemp($uid, $step);
        
        $temp = $this->tempRecord($id, $step2, $pid, $uid, $time, $name, $step);
        
        if($temp)
        {
            
            $row = & JTable::getInstance('Bodyscore');
            $row->load();

            $row->user_id = $uid;
            $row->pid = $pid;
            $row->name = $name;
            $row->val= $step2;
            $row->time= $time;
            $row->step = $step;

            if (!$row->check())
            {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }

            if (!$row->store()) 
            {
                $this->setError($this->_db->getErrorMsg());
                return false;
            }

            return true;
        }
        else
        {
         return false;   
        }
        
    }
    
    function recordStep3($pid, $uid, $time)
    {
        
        
        $file  = JRequest::get("files");
        
        $file_1_name =$file["filename"]["name"];
        $file_1_name = $pid."_".$uid."_".time()."_"."_f_".$file_1_name;
        $file_1_tmp_path =$file["filename"]["tmp_name"];
        
        
        
        
        $file_2_name =$file["filename2"]["name"];
        $file_2_name = $pid."_".$uid."_".time()."_"."_p_".$file_2_name;
        $file_2_tmp_path =$file["filename2"]["tmp_name"];
        
        
        
        $result_1 = move_uploaded_file($file_1_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_1_name);
        $result_2 = move_uploaded_file($file_2_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_2_name);
        
        
        
        
        $val = $file_1_name.",".$file_2_name;
        
        
        
        
        
        
        $name = "photo";
        $step = 3;
        
        $id = $this->checkTemp($uid, $step);
        
        $temp = $this->tempRecord($id, $val, $pid, $uid, $time, $name, $step);
        
        if($temp)
        {
            $row = & JTable::getInstance('Bodyscore');
            $row->load();

            $row->user_id = $uid;
            $row->pid = $pid;
            $row->name = $name;
            $row->val= $val;
            $row->time= $time;
            $row->step = $step;

            if (!$row->check())
            {
            $this->setError($this->_db->getErrorMsg());
            return false;
            }

            if (!$row->store()) 
            {
            $this->setError($this->_db->getErrorMsg());
            return false;
            }

            return true;
        }
        else
        {
         return false;   
        }
    }
    
    
    function getSymptoms()
    {
        $user =& JFactory::getUser();
        $userId = $user->id;
        $query = "SELECT * FROM #__jf_my_symptoms WHERE owner = $userId ";
        return $this->_getList($query);
    }
    
    function addSymptom($symptom, $uid)
    {
        $row = & JTable::getInstance('Symptoms');
        $row->load();
        $row->name = $symptom;
        $row->owner = $uid;
        
        if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
    
    return true;
        
        
    }
    
    function recordStep4($step4, $pid, $uid, $time)
    {
        $name = "symptoms";
        $step = 4;
        
        $id = $this->checkTemp($uid, $step);
        
        //$temp = $this->tempRecord($id, $step4, $pid, $uid, $time, $name, $step);
        $temp2 = $this->tempRecordSurvay($uid, $pid, $name, $step4);
        /*
        if($temp)
        {
        

            $row = & JTable::getInstance('Bodyscore');
            $row->load();

            $row->user_id = $uid;
            $row->pid = $pid;
            $row->name = $name;
            $row->val= $step4;
            $row->time= $time;
            $row->step = $step;

            if (!$row->check())
            {
            $this->setError($this->_db->getErrorMsg());
            return false;
            }

            if (!$row->store()) 
            {
            $this->setError($this->_db->getErrorMsg());
            return false;
            }

            return true;
        }
        else
        {
         return false;   
        }
        */
    }
    
    function getMedtrack()
    {
        $user =& JFactory::getUser();
        $userId = $user->id;
        $query = "SELECT * FROM #__jf_my_medtrack where owner = $userId";
        return $this->_getList($query);
    }
    
    function addMedtrack($medtrack, $uid)
    {
        
        
        $row = & JTable::getInstance('Medtrack');
        $row->load();
        
        $row->name= $medtrack;
        $row->owner = $uid;
        if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
    
        return true;
        
    
    }
    
    function recordStep5($step5, $pid, $uid, $time)
    {
        $name = "medtrack";
        $step = 5;
        
        $id = $this->checkTemp($uid, $step);
        
        $temp = $this->tempRecord($id, $step5, $pid, $uid, $time, $name, $step);
        
        if($temp)
        {
            $row = & JTable::getInstance('Bodyscore');
            $row->load();

            $row->user_id = $uid;
            $row->pid = $pid;
            $row->name = $name;
            $row->val= $step5;
            $row->time= $time;
            $row->step = $step;

            if (!$row->check())
            {
            $this->setError($this->_db->getErrorMsg());
            return false;
            }

            if (!$row->store()) 
            {
            $this->setError($this->_db->getErrorMsg());
            return false;
            }

            return true;
        }
        else
        {
         return false;   
        }
    }
    
    function getDiseases()
    {
        $user =& JFactory::getUser();
        $userId = $user->id;
        $query = "SELECT * FROM #__jf_my_diseases where owner = $userId";
        return $this->_getList($query);
    }
    
    function addDiseases($diseases, $uid)
    {
        $row = & JTable::getInstance('Diseases');
        $row->load();
        $row->name = $diseases;
        $row->owner = $uid;
        
        if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
    
    return true;
        
        
    }
    
    function recordStep6($step6, $pid, $uid, $time)
    {
        $name = "diseases";
        $step = 6;
        
        $id = $this->checkTemp($uid, $step);
        
        $temp = $this->tempRecord($id, $step6, $pid, $uid, $time, $name, $step);
        
        if($temp)
        {
            $row = & JTable::getInstance('Bodyscore');
            $row->load();

            $row->user_id = $uid;
            $row->pid = $pid;
            $row->name = $name;
            $row->val= $step6;
            $row->time= $time;
            $row->step = $step;

            if (!$row->check())
            {
            $this->setError($this->_db->getErrorMsg());
            return false;
            }

            if (!$row->store()) 
            {
            $this->setError($this->_db->getErrorMsg());
            return false;
            }

            return true;
        }
        else
        {
         return false;   
        }
    }
    
    function getQuestionsResult($pid, $userId)
    {
        $query = "SELECT * FROM #__jf_my_bodyscore WHERE pid = $pid AND step = 1 AND time = 's' AND user_id = $userId";
        return $this->_getList($query);
    }
    
    function getUQ($numbers)
    { 
        
        $query = "SELECT * FROM #__jf_jtpl_survey_body_score WHERE id IN ($numbers)";
        return  $this->_getList($query);
    }
     
    function getFatResult($pid, $userId)
    {
        $query = "SELECT * FROM #__jf_my_bodyscore WHERE pid = $pid AND step = 2 AND time = 's' AND user_id = $userId";
        return $this->_getList($query);
    }
    
    function getPhotoResult($pid, $userId)
    {
        $query = "SELECT * FROM #__jf_my_bodyscore WHERE pid = $pid AND step = 3 AND time = 's' AND user_id = $userId";
        return $this->_getList($query);
    }
    
    function getSymptomsResult($pid, $userId)
    {
        $query = "SELECT * FROM #__jf_my_bodyscore WHERE pid = $pid AND step = 4 AND time = 's' AND user_id = $userId";
        return $this->_getList($query);
    }
    
    function getSymptomsRes($symptomsResult)
    {
        $query = "SELECT * FROM #__jf_my_symptoms WHERE id IN ($symptomsResult)";
        return  $this->_getList($query);
    }
    
    function getMedtrackResult($pid, $userId)
    {
        $query = "SELECT * FROM #__jf_my_bodyscore WHERE pid = $pid AND step = 5 AND time = 's' AND user_id = $userId";
        return  $this->_getList($query);
    }
    
    function getMedtrackRes($medtrackResult)
    {
        $query = "SELECT * FROM #__jf_my_medtrack WHERE id IN ($medtrackResult)";
        return  $this->_getList($query);
    }
    
    function getDiseasesResult($pid, $userId)
    {
       $query = "SELECT * FROM #__jf_my_bodyscore WHERE pid = $pid AND step = 6 AND time = 's' AND user_id = $userId";
       return  $this->_getList($query); 
    }
    
    function getDiseasesRes($diseasesResult)
    {
        $query = "SELECT * FROM #__jf_my_diseases WHERE id IN ($diseasesResult)";
        return $this->_getList($query);
    }
    
    function getCnt($pid, $uid)
    {
        $query = "SELECT COUNT(id) as cnt FROM #__jf_my_bodyscore WHERE pid = $pid AND time = 's'";
        return $this->_getList($query);
    }
    
    function tempRecord2($tempid, $val)
    {
        $temp = & JTable::getInstance('Tempbodyscore');
        $temp->load($tempid);
        
        $temp->val= $val;

        if (!$temp->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$temp->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
    
    return true;
        
    }
    
    function editStep1($step1, $id, $tempid)
    {
        
        $temp = $this->tempRecord2($tempid, $step1);
        
        if($temp)
        {
        
        
  
        $row = & JTable::getInstance('Bodyscore');
        $row->load($id);
        
        
        $row->val= $step1;
    
    if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
    
    return true;
        }
        else
        {
            return false;
        }
    }
    
    function getEndCnt($pid, $uid)
    {
        $query = "SELECT COUNT(id) as cnt FROM #__jf_my_bodyscore WHERE pid = $pid AND time = 'e'";
        return $this->_getList($query);
    }
    
    function getEndQuestionsResult($pid)
    {
        $query = "SELECT * FROM #__jf_my_bodyscore WHERE pid = $pid AND step = 1 AND time = 'e'";
        return $this->_getList($query);
    }
    
    function getEndFatResult($pid)
    {
        $query = "SELECT * FROM #__jf_my_bodyscore WHERE pid = $pid AND step = 2 AND time = 'e'";
        return $this->_getList($query);
    }
    
    function getEndPhotoResult($pid)
    {
        $query = "SELECT * FROM #__jf_my_bodyscore WHERE pid = $pid AND step = 3 AND time = 'e'";
        return $this->_getList($query);
    }
    
    function getEndSymptomsResult($pid)
    {
        $query = "SELECT * FROM #__jf_my_bodyscore WHERE pid = $pid AND step = 4 AND time = 'e'";
        return $this->_getList($query);
    }
    
    function getEndMedtrackResult($pid)
    {
        $query = "SELECT * FROM #__jf_my_bodyscore WHERE pid = $pid AND step = 5 AND time = 'e'";
        return  $this->_getList($query);
    }
    
    function getEndDiseasesResult($pid)
    {
       $query = "SELECT * FROM #__jf_my_bodyscore WHERE pid = $pid AND step = 6 AND time = 'e'";
       return  $this->_getList($query); 
    }
    
    function save_progress_tracking($post_array)
    {
        global $mainframe;
        
        
        // saving uploaded photo
        
        $file  = JRequest::get("files");
        
        echo '<pre>';
        var_dump($file);
        
        
        
        $srcfile = $file["filename"]["tmp_name"];
        
        
        
        
        //$this->upload_phase_photo($srcfile,$file["filename"]["name"]);
        
    }

    function upload_phase_photo($src,$filename)
    {
        
        if(!$filename){
            
            return false;
        }
        
        if($src && file_exists($src))
            {
        

            $user = JFactory::getUser();            
            
            //имя будущего файла
            $destination = $user->id."__".time()."__".$filename;   
            
                      
            //перемещение фотки из временной папки
            $result = move_uploaded_file($src,"uploads_jtpl".DS."phase_details".DS.$destination);
            
            }
    }
    
    function editStep3($pid, $uid, $id, $tempid)
    {
        
        
        $file  = JRequest::get("files");
        
        
        
        
        $file_1_name =$file["filename"]["name"];
        $file_1_name = $pid."_".$uid."_".time()."_"."_f_".$file_1_name;
        $file_1_tmp_path =$file["filename"]["tmp_name"];
        
        
        
        
        $file_2_name =$file["filename2"]["name"];
        $file_2_name = $pid."_".$uid."_".time()."_"."_p_".$file_2_name;
        $file_2_tmp_path =$file["filename2"]["tmp_name"];
        
        
        
        $result_1 = move_uploaded_file($file_1_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_1_name);
        $result_2 = move_uploaded_file($file_2_tmp_path,"uploads_jtpl".DS."phase_details".DS.$file_2_name);
        
        $val = $file_1_name.",".$file_2_name;
        
        
        
        
        $temp = $this->tempRecord2($tempid, $val);
        
        if($temp)
        {
        
        
        $row = & JTable::getInstance('Bodyscore');
        $row->load($id);
        

        $row->val= $val;

        
        if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
        
    return true;
        }
        else
        {
            return false;
        }

    }

    function getUP($uid)
    {
        $query = "SELECT id, leader FROM #__jf_projects WHERE leader = $uid ORDER BY id";
        return $this->_getList($query);
    }
    
    function getStartResul($pid)
    {
        $query = "SELECT name FROM #__jf_projects WHERE id = $pid";
        return $this->_getList($query);
    }
    
    function getFP($uid)
    {
        $query = "SELECT id FROM #__jf_projects WHERE leader = $uid ORDER BY id LIMIT 1";
        return $this->_getList($query);
    }
    
    
    
    function getProgressTrackingDetails($user_id, $phase_id, $numbers) {

        $db =& JFactory::getDBO();

        $user_id = (int)$user_id;
        $phase_id = (int)$phase_id;

        /*
                // get bodyscore retake
                $sql = "SELECT val FROM #__jf_my_bodyscore WHERE name = 'bodyscore' AND user_id = $user_id AND pid = $phase_id";
                $db->setQuery($sql);
                $ids = $db->loadResult();
        */

        // get data for chart
        
        if($numbers)
            {
            $percents = $this->_getBodyScorePercents($numbers);
            
            
            
            $chartdata = $this->getBodyScoreChartData($percents);
            
            
            $bs_chart = new stdClass();
            $bs_chart->cats = json_encode($chartdata['cats']);
            $bs_chart->vals = json_encode($chartdata['vals']);
            $bs_chart->opp_vals = json_encode($chartdata['opp_vals']);
            return $phaseBodyscoreChart = $bs_chart;
            }
            else
            {
            return $phaseBodyscoreChart = false;
            }

        
    }
    
    function _getBodyScorePercents($answers_str)
    {
        
        $db =& $this->_db;
        // get categories rankings based on obtained answers
        $cat_query = "SELECT category_id AS catid, COUNT(*) AS amount FROM #__jf_jtpl_survey_bs_xref
                  WHERE question_id IN ($answers_str)
                  GROUP BY category_id";
        $db->setQuery($cat_query);
        $cats_q_ranks = $db->loadAssocList();
        
        

        
        
        // get categories max rankings
        $max_query = "SELECT category_id AS catid, bs_c.category_name AS catname,
                          bs_c.vm_category_id AS vm_catid, COUNT(*) AS amount
                      FROM #__jf_jtpl_survey_bs_xref bs_x
                      LEFT JOIN #__jf_jtpl_survey_bs_cats bs_c ON bs_x.category_id = bs_c.id
                      GROUP BY category_id";
        $db->setQuery($max_query);
        $cats_max_ranks = $db->loadAssocList();
        

        // calculating percentage for each category
        $percents = array();
        $cats_len = count($cats_max_ranks);
        for($i = 0; $i < $cats_len; $i++)
        {
            $q_rank = $cats_q_ranks[$i];
            $q_amount = $q_rank !== null ? $q_rank['amount'] : 0;
            $percents[$cats_max_ranks[$i]['catid']] = array(
                'catname' => $cats_max_ranks[$i]['catname'],
                'vm_catid' => $cats_max_ranks[$i]['vm_catid'],
                'percent' => round(($q_amount / $cats_max_ranks[$i]['amount']) * 100)
            );
        }
        
       
        
        return $percents;
       
    }
    
    function getBodyScoreChartData($percents)
    {
        $bs_cats = array();
        $bs_percent_vals = array();
        $bs_opposite_vals = array();
        foreach($percents as $v) {
            $bs_cats[] = $v['catname'];
            $bs_percent_vals[] = $v['percent'];
            $bs_opposite_vals[] = 100 - $v['percent'];
        }

        return array('cats'=>$bs_cats, 'vals'=>$bs_percent_vals, 'opp_vals'=>$bs_opposite_vals);
    }

    function getQuestion()
    {
        $query = "SELECT * FROM #__jf_jtpl_survey_body_score ORDER BY id";
        return $this->_getList($query);
    }
    
    function editStep2($step2, $id, $tempid)
    {
        $temp = $this->tempRecord2($tempid, $step2);
        
        if($temp)
        {
        
        $row = & JTable::getInstance('Bodyscore');
        $row->load($id);
        
        $row->val= $step2;
        
    if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
    
    return true;
        }
        else
        {
            return false;
        }
        }
    
    function finishCheck($pid, $uid)
    {
        $db =& $this->_db;
        $sql = "SELECT status FROM #__jf_projects WHERE id = $pid";
        $db->setQuery($sql);
        return $db->loadResult();
        
        
        /*
            $query = "SELECT * FROM #__jf_my_temp_bodyscore WHERE user_id = $uid AND step = 1";
            $ids = $this->_getList($query);
            $db->setQuery($query);
            $ids = $db->loadAssocList();
        */
    }
    function getTempDataBodyscore($uid)
    {
        
        $step = 1;
        $step1 = $this->getTempStep($uid, $step);
        $step1 = explode(",", $step1);
        $result['bodyscore'] = $step1;
        
        $step++;
        $step2 = $this->getTempStep($uid, $step);
        $step2 = explode(",", $step2);
        $result['body'] = $step2;
        
        $step++;
        $step3 = $this->getTempStep($uid, $step);
        $step3 = explode(",", $step3);
        $result['photo'] = $step3;
        
        $step++;
        $step4 = $this->getTempStep($uid, $step);
        
        
        
        
        
        $step++;
        $step5 = $this->getTempStep($uid, $step);
        
        $step++;
        $step6 = $this->getTempStep($uid, $step);
        
        echo '<pre>';
        var_dump($step4);
        //var_dump($result['']);
        
    }
    
    function getTempStep($uid, $step)
    {
        $db =& $this->_db;
        $query = "SELECT val FROM #__jf_my_temp_bodyscore WHERE user_id = $uid AND step = $step";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadResult();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    function phaseFin($uid, $pid)
    {
        $db =& $this->_db;
        $query = "SELECT status FROM #__jf_projects WHERE leader = $uid AND id = $pid";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadResult();
    }
    
    function mainTest($uid, $pid)
    {
        $db =& $this->_db;
        $query = "SELECT * FROM #__jf_my_res WHERE uid = $uid AND pid = $pid";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        $res = $db->loadAssocList();
        
        if(count($res) == 0)
        {
            return null;
        }
        else
        {
            return $res;
        }
    }
    
    function questionList()
    {
        $db =& $this->_db;
        $query = "SELECT id, question FROM #__jf_jtpl_survey_body_score ORDER BY id";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadAssocList();
       
    }
    
    function getQAnswers($val)
    {
        $db =& $this->_db;
        $query = "SELECT answer FROM #__jf_jtpl_survey_body_score WHERE id IN($val) ORDER BY id";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadAssocList();
       
    }
    
    function recordSurvey($uid, $pid, $survey)
    {
        
        foreach ($survey as $value)
        {
            if($value['cat_name'] == "photo")
            {
                $this->imgProcessor($uid, $pid, $value);
            }
            else
            {
                $this->surveyProcessor($uid, $pid, $value);
            }
        }
        return true;
        
    }
    
    function saveTempSurvay($id, $uid, $pid, $name, $val, $status, $note, $step)
    {
        
        if($pid == 0)
        {
            $this->saveSurvay($id, $uid, $pid, $name, $val, $status, $note, $step);
        }
        
    
        $row = & JTable::getInstance('Mysurvreztemp');
        $row->load();
        
        $row->uid    = $uid;
        $row->pid    = $pid;
        $row->name   = $name;
        $row->val    = $val;
        $row->status = $status;
        $row->note   = $note;
        $row->step   = $step;
        
    if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
    
    //return true;
         
        /*
        echo '<pre>';
        echo 'id = ';var_dump($id);
        echo 'ud = ';var_dump($uid);
        echo 'pid = ';var_dump($pid);
        echo 'name = ';var_dump($name);
        echo 'val = ';var_dump($val);
        echo 'status = ';var_dump($status);
        echo 'note = ';var_dump($note);
        echo 'step = ';var_dump($step);
        */
    }
    
    function saveSurvay($id, $uid, $pid, $name, $val, $status, $note, $step)
    {
        $row = & JTable::getInstance('Mysurvrez');
        
        $row->load();
        
        $row->uid    = $uid;
        $row->pid    = $pid;
        $row->name   = $name;
        $row->val    = $val;
        $row->status = $status;
        $row->note   = $note;
        $row->step   = $step;
        
    if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
        
    }
            
    function surveyProcessor($uid, $pid, $data)
    {
        $this->saveTempSurvay($data['id'], $uid, $pid, $data['cat_name'], $data['val'], $data['status'], $data['note'], $data['step']);
    }
    
    function imgProcessor($uid, $pid, $img)
    {
        
        $result = $this->movePhasesImg($img['file1']['tmp_path'], $img['file1']['val']);
        $result2 = $this->movePhasesImg($img['file2']['tmp_path'], $img['file2']['val']);
        
        $val=$img[file1][val].",".$img[file2][val];
        $this->saveTempSurvay($img['id'], $uid, $pid, $img['cat_name'], $val, $img['status'], $img['note'], $img['step']);
    }
    
    function movePhasesImg($tmpPath, $name)
    {
        if(!empty($tmpPath) && !empty($name))
        {
            $result = move_uploaded_file($tmpPath,"uploads_jtpl".DS."phase_details".DS.$name);
            if($result)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        return true;
    }
    
    
    function getTid($uid, $step)
    {
        $db =& $this->_db;
        $query = "SELECT id FROM #__jf_my_temp_res WHERE uid = $uid AND step = $step";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadResult();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    function loockingfor()
    {
        $db =& $this->_db;
        $query = "SELECT * FROM #__jf_my_lookingfor ORDER BY id";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadAssocList(); 
    }
    
    function recLastintake($evalution)
    {
        $uid = $evalution[uid];
        $pid = $evalution[pid];
        $date =  date('Y-m-d G:i:s');
        

        $goals_body = $evalution[goals][weight].",".$evalution[goals][fat];
        $result = $this->saveLastintake($uid, $pid, "goals_body", $goals_body, null, null, null, $date);
        if($result == false){return false;}
        
        $goals_quest = implode(",", $evalution[goals][question]);
        $result = $this->saveLastintake($uid, $pid, "goals_quest", $goals_quest, null, null, null, $date);
        if($result == false){return false;}
        
        
        $stats_sex = $evalution[stats][sex];
        $result = $this->saveLastintake($uid, $pid, "stats_sex", $stats_sex, null, null, null, $date);
        if($result == false){return false;}
        
        $stats_height = $evalution[stats][heigth][0].",".$evalution[stats][heigth][1];
        $result = $this->saveLastintake($uid, $pid, "stats_height", $stats_height, null, null, null, $date);
        if($result == false){return false;}
        
        $body = $evalution[stats][weight].",".$evalution[stats][fat].",".$evalution[stats][ph];
        $result = $this->saveLastintake($uid, $pid, "body", $body, null, null, 2, $date);
        if($result == false){return false;}
        
        $stats_b_p = $evalution[stats][blod_pressure][0].",".$evalution[stats][blod_pressure][1]; 
        $result = $this->saveLastintake($uid, $pid, "stats_b_p", $stats_b_p, null, null, null, $date);
        if($result == false){return false;}
        
        $stats_b_t = $evalution[stats][blood_type];
        $result = $this->saveLastintake($uid, $pid, "stats_b_t", $stats_b_t, null, null, null, $date);
        if($result == false){return false;}
        
        $body_type = implode(",", $evalution[body_type]);
        $result = $this->saveLastintake($uid, $pid, "body_type", $body_type, null, null, null, $date);
        if($result == false){return false;}
        
        $life_style = implode(",", $evalution[life_style]);
        $result = $this->saveLastintake($uid, $pid, "life_style", $life_style, null, null, 1, $date);
        if($result == false){return false;}
        
        $photo = implode(",", $evalution[file][name]);
        $result = $this->saveLastintake($uid, $pid, "photo", $photo, null, null, 3, $date);
        if($result == false){return false;}
        
        $med_exem = $evalution[madtrack][exem];
        $result = $this->saveLastintake($uid, $pid, "med_exem", $med_exem, null, null, null, $date);
        if($result == false){return false;}

        
        $treatment = $evalution[madtrack][treatment];
        $result = $this->saveLastintake($uid, $pid, "treatment", null, $treatment[status], $treatment[note], null, $date);
        if($result == false){return false;}
        
        $operations = $evalution[madtrack][operations];
        $result = $this->saveLastintake($uid, $pid, "operations", null, $operations[status], $operations[note], null, $date);
        if($result == false){return false;}
        
        $smoke = $evalution[madtrack][smoke];
        $result = $this->saveLastintake($uid, $pid, "smoke", null, $smoke[status], $smoke[note], null, $date);
        if($result == false){return false;}
        
        $alcohol = $evalution[madtrack][alcohol];
        $result = $this->saveLastintake($uid, $pid, "alcohol", null, $alcohol[status], $alcohol[note], null, $date);
        if($result == false){return false;}
        
        $drugs = $evalution[madtrack][drugs];
        $result = $this->saveLastintake($uid, $pid, "drugs", null, $drugs[status], $drugs[note], null, $date);
        if($result == false){return false;}

		
		
		
		
		
		

        $allergies = $evalution[madtrack][allergies];
        $allergies = $this->parseAllergies($allergies);
		$result = $this->saveLastintake($uid, $pid, "allergies", $allergies, null, null, null, $date);
        if($result == false){return false;}


            $symptoms = $evalution[madtrack][symptoms];
            $symptoms = $this->parseSymptoms($symptoms);
            $result = $this->saveLastintake($uid, $pid, "symptoms", $symptoms[name], $symptoms[status], $symptoms[note], 4, $date);
            if($result == false){return false;}


              $drug = $evalution[madtrack][drug];
              $drug = $this->parseDrug($drug);


              $result = $this->saveLastintake($uid, $pid, "drug", $drug[name], $drug[status], $drug[note], 5, $date);
              if($result == false){return false;}


              $diseases = $evalution[madtrack][diseases];
              $diseases = $this->parseDiseases($diseases);
              $result = $this->saveLastintake($uid, $pid, "diseases", $diseases[name], $diseases[status], $diseases[note], 6, $date);
              if($result == false){return false;}





              return true;

    }
    
    function parse($val)
    {
        $val[name] = implode(",", $val[name]);
        $val[note] = implode(",", $val[note]);
        return $val;
    }
    
	function parseAllergies($symptoms)
	{
		if(count($symptoms[db_list]) > 0)
		{
			$db_list = implode(",", $symptoms[db_list]);
		}
		
		if(count($symptoms[extra_list]) > 0)
		{
			foreach($symptoms[extra_list] as $value)
			{
				$extra_list[] = $this->recordNewAllergies($value);
			}
			$extra_list = implode(",", $extra_list);
		}
		
		if(isset($db_list) && isset($extra_list))
		{
			$result = $db_list.",".$extra_list;
		}
		elseif(isset($db_list))
		{
			$result = $db_list;
		}
		elseif(isset($extra_list))
		{
			$result = $extra_list;
		}
		
		return $result;
	}
	
	function recordNewAllergies($value)
	{
		
		$query = "INSERT INTO #__jf_my_allergies (`name`) VALUES ('$value') ";
		$this->_db->setQuery($query);
        $result = $this->_db->query();
		if ($result)
		{
			$q = "SELECT id FROM `jos_jf_my_allergies` ORDER BY `id` DESC LIMIT 1";
			$db =& $this->_db;
			$db->setQuery($q);
			$res = $db->loadResult();
			
		}
		return $res;
	}
	
	function parseSymptoms($symptoms)
	{
		if(count($symptoms[db_list]) > 0)
		{
			$db_list = implode(",", $symptoms[db_list]);
		}
		
		if(count($symptoms[extra_list]) > 0)
		{
			foreach($symptoms[extra_list] as $value)
			{
				$extra_list[] = $this->recordNewSymptom($value);
			}
			$extra_list = implode(",", $extra_list);
		}
		
		if(isset($db_list) && isset($extra_list))
		{
			$result[name] = $db_list.",".$extra_list;
        }
		elseif(isset($db_list))
		{
			$result[name] = $db_list;
		}
		elseif(isset($extra_list))
		{
			$result[name] = $extra_list;
		}



        if(!is_null($result[name]))
        {
            $temp = explode(",",$result[name]);
            foreach($temp as $value)
            {
                $count[] = "new";
            }
            $result[status] = implode   (",",$count );

            $temp = explode(",",$result[name]);
            foreach($temp as $value)
            {
                $count2[] = "no info";
            }
            $result[note] = implode   (",",$count2 );
        }


		return $result;
	}
	
	function recordNewSymptom($value)
	{
		
		$query = "INSERT INTO #__jf_my_symptoms (`name`) VALUES ('$value') ";
		$this->_db->setQuery($query);
        $result = $this->_db->query();
		if ($result)
		{
			$q = "SELECT id FROM `jos_jf_my_symptoms` ORDER BY `id` DESC LIMIT 1";
			$db =& $this->_db;
			$db->setQuery($q);
			$res = $db->loadResult();
			
		}
		return $res;
	}
	
	function parseDrug($symptoms)
	{
		if(count($symptoms[db_list]) > 0)
		{
			$db_list = implode(",", $symptoms[db_list]);
		}
		
		if(count($symptoms[extra_list]) > 0)
		{
			foreach($symptoms[extra_list] as $value)
			{
				$extra_list[] = $this->recordNewDrug($value);
			}
			$extra_list = implode(",", $extra_list);
		}
		
		if(isset($db_list) && isset($extra_list))
		{
			$result[name] = $db_list.",".$extra_list;
		}
		elseif(isset($db_list))
		{
			$result[name] = $db_list;
		}
		elseif(isset($extra_list))
		{
			$result[name] = $extra_list;
		}

        if(!is_null($result[name]))
        {
            $temp = explode(",",$result[name]);
            foreach($temp as $value)
            {
                $count[] = "new";
            }
            $result[status] = implode   (",",$count );

            $temp = explode(",",$result[name]);
            foreach($temp as $value)
            {
                $count2[] = "no info";
            }
            $result[note] = implode   (",",$count2 );
        }

		return $result;
	}
	
	function recordNewDrug($value)
	{
		
		$query = "INSERT INTO #__jf_my_medtrack (`name`) VALUES ('$value') ";
		$this->_db->setQuery($query);
        $result = $this->_db->query();
		if ($result)
		{
			$q = "SELECT id FROM `jos_jf_my_medtrack` ORDER BY `id` DESC LIMIT 1";
			$db =& $this->_db;
			$db->setQuery($q);
			$res = $db->loadResult();
			
		}
		return $res;
	}
	
	function parseDiseases($symptoms)
	{
		if(count($symptoms[db_list]) > 0)
		{
			$db_list = implode(",", $symptoms[db_list]);
		}
		
		if(count($symptoms[extra_list]) > 0)
		{
			foreach($symptoms[extra_list] as $value)
			{
				$extra_list[] = $this->recordNewDiseases($value);
			}
			$extra_list = implode(",", $extra_list);
		}
		
		if(isset($db_list) && isset($extra_list))
		{
			$result[name] = $db_list.",".$extra_list;
		}
		elseif(isset($db_list))
		{
			$result[name] = $db_list;
		}
		elseif(isset($extra_list))
		{
			$result[name] = $extra_list;
		}

        if(!is_null($result[name]))
        {
            $temp = explode(",",$result[name]);
            foreach($temp as $value)
            {
                $count[] = "new";
            }
            $result[status] = implode   (",",$count );

            $temp = explode(",",$result[name]);
            foreach($temp as $value)
            {
                $count2[] = "no info";
            }
            $result[note] = implode   (",",$count2 );
        }

		return $result;
	}
	
	function recordNewDiseases($value)
	{
		
		$query = "INSERT INTO #__jf_my_diseases (`name`) VALUES ('$value') ";
		$this->_db->setQuery($query);
        $result = $this->_db->query();
		if ($result)
		{
			$q = "SELECT id FROM `jos_jf_my_diseases` ORDER BY `id` DESC LIMIT 1";
			$db =& $this->_db;
			$db->setQuery($q);
			$res = $db->loadResult();
			
		}
		return $res;
	}
	
	
	
	
	
	
    function saveLastintake($uid, $pid, $name, $val, $status, $note, $step, $date)
    {
        $row = & JTable::getInstance('Lastintake');
        
        $row->load();
        
        $row->uid    = $uid;
        $row->pid    = $pid;
        $row->name   = $name;
        $row->val    = $val;
        $row->status = $status;
        $row->note   = $note;
        $row->step   = $step;
        $row->date   = $date;
        
        if (!$row->check())
            {
            $this->setError($this->_db->getErrorMsg());
            return false;
            }

        if (!$row->store()) 
            {
            $this->setError($this->_db->getErrorMsg());
            return false;
            }
        return true;    
    }
    
    function lastintakeTest($uid)
    {
        $db =& $this->_db;
        $query = "SELECT COUNT(id) FROM #__jf_my_lastintake WHERE uid = $uid AND pid = 0";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadResult();
    }
    
    //use
    function testPhaseData($uid, $pid){
        $db =& $this->_db;
        $query = "SELECT * FROM  #__jf_my_lastintake WHERE uid = $uid AND pid = $pid AND step IN (1,2,3,4,5,6) AND date = (SELECT DISTINCT date FROM  #__jf_my_lastintake WHERE uid = $uid AND pid = $pid ORDER BY date DESC LIMIT 1)  ORDER BY step" ;
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return  $db->loadAssocList();
    }
    
    
    //use
    function getFirstData($uid){
        $db =& $this->_db;
        $query = "SELECT * FROM  #__jf_my_lastintake WHERE uid = $uid AND step IN (1,2,3,4,5,6) AND pid = 0 ORDER BY step";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return  $db->loadAssocList();
    }
    
    function getAllData($uid){
        
        $db =& $this->_db;
        $query = "SELECT * FROM  #__jf_my_lastintake WHERE uid = $uid";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return  $db->loadAssocList();
        
    }
    
    //use
    function getIntakeData($uid){
        $db =& $this->_db;
        $query = "SELECT * FROM  #__jf_my_lastintake WHERE uid = $uid AND step IN (1,2,3,4,5,6) AND date = (SELECT DISTINCT date FROM  #__jf_my_lastintake WHERE uid = $uid ORDER BY date DESC LIMIT 1) ORDER BY step";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return  $db->loadAssocList();
    }
    
    
        function recPhasaData($evalution)
    {
        $uid = $evalution[uid];
        $pid = $evalution[pid];
        $date =  date('Y-m-d G:i:s');
        
        $life_style = implode(",", $evalution[life_style]);
        $result = $this->saveLastintake($uid, $pid, "life_style", $life_style, null, null, 1, $date);
        if($result == false){return false;}
        
        $body = $evalution[body][weight].",".$evalution[body][fat].",".$evalution[body][ph];
        $result = $this->saveLastintake($uid, $pid, "body", $body, null, null, 2, $date);
        if($result == false){return false;}
        
        $photo = implode(",", $evalution[file]);
        $result = $this->saveLastintake($uid, $pid, "photo", $photo, null, null, 3, $date);
        if($result == false){return false;}
        

        $symptoms = $evalution[symptoms];
        $symptoms = $this->parsePhaseData($symptoms);
        $result = $this->saveLastintake($uid, $pid, "symptoms", $symptoms[val], $symptoms[status], $symptoms[note], 4, $date);
        if($result == false){return false;}
        
        $drug = $evalution[drug];
        $drug = $this->parsePhaseData($drug);
        $result = $this->saveLastintake($uid, $pid, "drug", $drug[val], $drug[status], $drug[note], 5, $date);
        if($result == false){return false;}
        
        $diseases = $evalution[diseases];
        $diseases = $this->parsePhaseData($diseases);
        
        $result = $this->saveLastintake($uid, $pid, "diseases", $diseases[val], $diseases[status], $diseases[note], 6, $date);
        if($result == false){return false;}
        
        return true;
    }
    
    function parsePhaseData($data)
    {
        $data[val] = implode(",", $data[val]);
        $data[status] = implode(",", $data[status]);
        $data[note] = implode(",", $data[note]);
        return $data;
    }
    
    //use
    function getFirstContent($uid){
        $db =& $this->_db;
        $query = "SELECT * FROM  #__jf_my_lastintake WHERE uid = $uid AND pid = 0 AND date = (SELECT DISTINCT date FROM  #__jf_my_lastintake WHERE uid = $uid AND pid = 0 ORDER BY date DESC LIMIT 1)";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return  $db->loadAssocList();
    }
    
    function getDefaultContent($uid){
        $db =& $this->_db;
        $query = "SELECT * FROM  #__jf_my_lastintake WHERE uid = $uid AND pid = 0 AND name IN ('goals_body', 'body') AND date = (SELECT DISTINCT date FROM  #__jf_my_lastintake WHERE uid = $uid AND pid = 0 ORDER BY date DESC LIMIT 1)";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return  $db->loadAssocList();
    }
    
    function getPhasesId($uid)
    {
        $db =& $this->_db;
        $query = "SELECT id, name FROM  #__jf_projects WHERE leader = $uid ORDER BY id";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return  $db->loadAssocList();
    }

    
    function getTargets($uid)
    {
        $db =& $this->_db;
        $query = "SELECT name, val FROM  #__jf_my_lastintake WHERE uid = $uid AND pid = 0";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return  $db->loadAssocList(); 
    }
    
    
    function getBodyHistory($uid, $name)
    {
        $db =& $this->_db;
        $query = "SELECT val, date, pid FROM  #__jf_my_lastintake WHERE uid = $uid AND name = '$name' ";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadAssocList(); 
    }
    
	function getAllergiesList()
	{
		$db =& $this->_db;
        $query = "SELECT * FROM  #__jf_my_allergies ORDER BY name";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadAssocList();
	}
	
    function getSymptomList()
    {
        $db =& $this->_db;
        $query = "SELECT * FROM  #__jf_my_symptoms ORDER BY name";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    
    function getMedtrackList()
    {
        $db =& $this->_db;
        $query = "SELECT * FROM  #__jf_my_medtrack ORDER BY name";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    
    function getDiseasesList()
    {
        $db =& $this->_db;
        $query = "SELECT * FROM  #__jf_my_diseases ORDER BY name";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadAssocList();
    }
    
    function getPhaseDates($pid)
    {
        $db =& $this->_db;
        $query = "SELECT DISTINCT(date) FROM  #__jf_my_lastintake WHERE pid = $pid";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadAssocList(); 
    }
    
    function getC($date, $pid)
    {
        $db =& $this->_db;
        $query = "SELECT val, status, note, date, name FROM  #__jf_my_lastintake WHERE pid = $pid and date = '$date'";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadAssocList(); 
     }
    
     function getShowTotal($pid)
     {
         $result = $this->getPhaseDat($pid);
         
         foreach ($result as $value)
         {
            $date = $value[date];
            $pid = $value[pid];
            $re[] = $this->getC($date, $pid);
         }
         
         
        return $re;
         
     }
     
    function getPhaseDat($pid)
    {
        $db =& $this->_db;
        $query = "SELECT DISTINCT(date),pid FROM  #__jf_my_lastintake WHERE pid = $pid";
        $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadAssocList(); 
    }
    
    function getPhaseName($pid)
    {
        $db =& $this->_db;
        $query = "SELECT name FROM #__jf_projects WHERE id = $pid";
        $db->setQuery($query);
	$result = $db->loadResult();
        return $result;
    }
    
    function getAllUserPhases($userId)
     {
        $db =& $this->_db;
        $query = "SELECT id FROM #__jf_projects WHERE leader = $userId ORDER BY id";
         $ids = $this->_getList($query);
        $db->setQuery($query);
        return $db->loadAssocList(); 
     }
    
    function editFinished($road, $key, $pid_n){

        $db =& $this->_db;
        $query = "SELECT fin FROM $road WHERE id = $key";
        $db->setQuery($query);
	$result = $db->loadResult();




        $result = $result."".$pid_n.",";
            
        $query = "UPDATE $road SET `fin` = '$result' WHERE `id` = $key;";
        $this->_db->setQuery($query);
        $this->_db->query();
        return true;

    }
}