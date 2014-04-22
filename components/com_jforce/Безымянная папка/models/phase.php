<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			search.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

define("SIGN_OFF_BY_COACH","Sign off by coach");

require_once(JPATH_ROOT.DS.'components'.DS.'com_hreport'.DS.'models'.DS.'report.php');

class JforceModelPhase extends JModel {
	
	var $_keyword	= null;
	var $_matches	= null;
	var $_phrase 	= null;
	var $_ordering 	= null;
    var $_pid = null;
	
    function __construct() {    	
        parent::__construct();		
	
		$keyword = JRequest::getVar('keyword','');
		$this->setKeyword($keyword);
		
		$phrase = JRequest::getVar('phrase','');
		$this->setPhrase($phrase);
		
		$ordering = JRequest::getVar('ordering','');
		$this->setOrdering($ordering);
		
		$pid = JRequest::getVar('pid', 0, '', 'int');
		$this->setPid((int)$pid);        
	}
    
    function get_available_phases(){
        $project_model =& JModel::getInstance('Project','JForceModel');
        $lists = $project_model->listProjects();
        return $lists;
    }
    
    function get_projects($user_id){
        $query = 
            "SELECT * FROM #__jf_projects WHERE "
            .$this->_db->nameQuote("author")." = ".$this->_db->Quote($user_id)." ORDER BY id ASC";
        
            /**
            $query = 'SELECT b.*, u.name as leader, c.name as company, b.company as companyid, p.id as leaderid'.
                    ' FROM #__jf_projects AS b' .
                    ' LEFT JOIN #__jf_persons AS p on b.leader = p.id '.
                    ' LEFT JOIN #__users AS u ON p.uid = u.id' .
                    ' LEFT JOIN #__jf_companies AS c on b.company = c.id' .
                    ' LEFT JOIN #__jf_projectroles_cf AS cf ON cf.pid = b.id'.
                    $where;
            **/
        // Get the pagination request variables

        $projects = $this->_getList($query, $limitstart, $limit);

        $this->list = $projects;

        return $this->list;
    }
    
    function upload_phase_photo($src,$filename,$phase_id,$coach = false){
        if(!$filename){
            
            return false;
        }
        if($src && file_exists($src)){

            $user = JFactory::getUser();            
            $destination = $user->id."__".time()."__".$filename;            
            $result = move_uploaded_file($src,"uploads_jtpl".DS."phase_details".DS.$destination);

            // get to know if such photo record already exists
            $this->_db->setQuery("SELECT * FROM #__jf_jtpl_progress_tracking
                WHERE user_id = {$this->_db->Quote($user->id)} AND phase_id = {$this->_db->Quote($phase_id)}");
            $this->_db->query();
            $exists = (bool)$this->_db->getNumRows();

            if(!$exists) {
                // write the uploaded filename to database
                $this->_db->setQuery(
                            "insert into #__jf_jtpl_progress_tracking ("
                            .$this->_db->nameQuote("user_id").","
                            .$this->_db->nameQuote("phase_id").","
                            .$this->_db->nameQuote("photo")
                            .")"
                            ."VALUES ("
                            .$this->_db->Quote($user->id).","
                            .$this->_db->Quote($phase_id).","
                            .$this->_db->Quote($destination)
                            .")");

            } else { // if exists, update
                $this->_db->setQuery("update #__jf_jtpl_progress_tracking SET "
                        .$this->_db->nameQuote("photo")."=".$this->_db->Quote($destination)
                        ." WHERE "
                        .$this->_db->nameQuote("phase_id") ." = ".$this->_db->Quote($phase_id)." AND "
                        .$this->_db->nameQuote("user_id") ." = ".$this->_db->Quote($user->id));
                /*if (!$coach) {
                    $query .=" AND "
                        .$this->_db->nameQuote($phasepoint."photo") ." = ".$this->_db->Quote("");
                } */
            }
            $this->_db->query();

            return true;
        }
        return false;
    }

	// get phase details for a particular phase	
    // JTPL HACK
    
    // has to be modified....
	function get_phase_details($phase_id = 0){
		//$this->_db->setQuery("SELECT * FROM #__jf_projects WHERE 1");
		//return $this->_db->loadObjectList		
		// current user
        /**
        $project_model =& JModel::getInstance('Project','JForceModel');
        $project_model->setId(JRequest::getCmd($this->_pid));
        $project_model->getProject();
        
        **/
        
        $phase_id = ($phase_id)?$phase_id : JRequest::getCmd("pid");
        
        $db = JFactory::getDBO( );
        $query = "SELECT * FROM #__jf_jtpl_phasedetails WHERE ".$db->nameQuote("phase_id")." = ".$db->Quote($phase_id)." LIMIT 1";
        
        $db->setQuery($query);
        $db->query();        
        
        return $db->loadObject();
	}

    function get_user_progress_details($user_id = 0, $phase_id = 0){
		
        $db = JFactory::getDBO();
        $query = "SELECT * FROM #__jf_jtpl_progress_tracking WHERE user_id = ".(int)$user_id." AND phase_id = ".(int)$phase_id." LIMIT 1";

        $db->setQuery($query);
        return $db->loadObject();
	}
    
    /**
    * for the particular user currently logged in check all phases have been completed or not
    *  it is assumed that user is logged in
    */
    function count_incomplete_steps(){
        $user = JFactory::getUser();
        if($user->id){
            $query = "SELECT * FROM  #__jf_checklists WHERE "
            .$this->_db->nameQuote("pid")." = " . $this->_db->Quote(JRequest::getCmd("pid"))
            ." AND ".$this->_db->nameQuote("summary")." <> ".$this->_db->Quote(SIGN_OFF_BY_COACH)
            ." AND ".$this->_db->nameQuote("completed")." = ".$this->_db->Quote(0);

            $this->_db->setQuery($query);
            $this->_db->query();
            
            return $this->_db->getNumRows();
        }
    }
    
    function is_phase_signed_off(){
        $query = "SELECT * FROM  #__jf_checklists WHERE "
        .$this->_db->nameQuote("pid")." = " . $this->_db->Quote(JRequest::getCmd("pid"))
        ." AND ".$this->_db->nameQuote("summary")." = ".$this->_db->Quote(SIGN_OFF_BY_COACH);
        $this->_db->setQuery($query);
        $this->_db->query();
        $result = $this->_db->loadObjectList();
        if(count($result) != 1){
            $this->redirect("","No such phase found", "error");
        }else{
            return $result[0]->completed;
        }
    }
    
    /**
    * The ignore_csv flag is used to check whether to list all fields or track as per the csv filter
    * 
    * @param mixed $tablename
    * @param mixed $csv_filter
    * @param mixed $field
    * @param mixed $ignore_csv
    */
    private function get_registration_survey_questions($tablename, $csv_filter = "", $field = "id", $ignore_csv = false){
        $query = "SELECT * FROM  #__jf_jtpl_survey_{$tablename} WHERE ";
        if($csv_filter && !$ignore_csv){
            $query.= " FIND_IN_SET({$this->_db->nameQuote($field)}, ({$this->_db->Quote($csv_filter)}))";
        }else if(!$csv_filter && $ignore_csv){
            $query.=" 1";
        }else{
            return null;
        }
        
        $this->_db->setQuery($query);
        
        $this->_db->query();
        
        //mdie($this->_db);
        
        $questions = $this->_db->loadObjectList();

        return $questions;
    }
    
    /** 
    * Body Score Survey Questions
    */
    function get_body_score_questions($csv_filter = "",$ignore_csv = false){        
        $questions = $this->get_registration_survey_questions("body_score",$csv_filter,"id",$ignore_csv);
        return $questions;
    }

    /** 
    * Body Looking For Questions
    */
    function get_looking_for_questions($csv_filter = "",$ignore_csv = false){        
        $questions = $this->get_registration_survey_questions("looking_for",$csv_filter,"variable",$ignore_csv);
        return $questions;
    }
    
    /** 
    * Body Medtrack Questions
    */
    function get_medtrack_questions($csv_filter = "",$ignore_csv = false){        
        $questions = $this->get_registration_survey_questions("medtrack",$csv_filter,"variable",$ignore_csv);
        return $questions;
    }
    
    /** 
    * Symptons Questions
    */
    function get_symptoms_questions($csv_filter = "",$ignore_csv = false){        
        $questions = $this->get_registration_survey_questions("symptoms",$csv_filter,"variable",$ignore_csv);
        return $questions;
    }    

    /** 
    * Body Diseases Questions
    */
    function get_diseases_questions($csv_filter = "",$ignore_csv = false){        
        $questions = $this->get_registration_survey_questions("diseases",$csv_filter,"variable",$ignore_csv);
        return $questions;
    }
    
    function get_looking_for_answers(){
        return $this->get_registration_survey_answers(0,"looking_for");
    }
    
    function get_medtrack_answers(){
        return $this->get_registration_survey_answers(0,"medtrack");
    }
    
    function get_symptoms_answers(){
        return $this->get_registration_survey_answers(0,"symptoms");    
    }
    
    function get_diseases_answers(){
        return $this->get_registration_survey_answers(0,"disease");
    }
    
    function get_body_score_answers(){
        return $this->get_registration_survey_answers(0,"bodyscore");
    }                       
    
    function get_registration_survey_answers($user_id = 0,$survey = ""){

        $obj = $this->get_registration_survey_status($user_id);
        
        if($obj){
            switch($survey){
                case "bodyscore":
                    if($obj["registration_survey_4"] == 0)
                        return null;
                break;
                case "disease":
                    if($obj["registration_survey_3"] == 0)                    
                        return null;
                break;
                case "symptoms":
                    if($obj["registration_survey_2"] == 0)
                        return null;
                break;
                case "medtrack":
                    if($obj["registration_survey_1"] == 0)
                        return null;
                break;
                case "looking_for":                    
                    if($obj["registration_survey_0"] == 0)
                        return null;
                break;
                default:
                return null;
                break;
            }            
            return $this->get_registration_survey_results($user_id,$survey);       
        }else{
            return null;
        }
    }           

    
    /**
    * Get Registration Survey Results
    */
    function get_registration_survey_results($user_id,$filter = ""){
        if($user_id)
            $user = JFactory::getUSer($user_id);
        else
            $user = JFactory::getUser();
            
        $user_id = $user->id;

        $this->_db->setQuery("SELECT * from #__jf_jtpl_survey_details WHERE "
        .$this->_db->nameQuote("user_id")." = "
        .$this->_db->Quote($user_id)
        ." AND "
        .$this->_db->nameQuote("project_id")." = "
        .$this->_db->Quote(0)
        ." AND "
        .$this->_db->nameQuote("survey_variable")." LIKE "
        .$this->_db->Quote("reg_%".$filter."%"));

        $this->_db->query();
        //mdie($this->_db->loadObjectList());
        
        return $this->_db->loadObjectList();    
    }
    
    
    
    /**
    * Generic function to save a survey result
    * 
    * @param mixed $survey_name - an unique name for the user's survey which will be an identifer for the survey
    * @param mixed $values_arr - array values for the survey results, stored as CSV
    */
    
    function save_survey_result($survey_name, $values_arr){        
        if(!$survey_name){
            return false;
        }
        
        if(is_array($values_arr)){
            $values_csv = implode(",",$values_arr);
        } else{
            $values_csv = $values_arr;
        }
        
        $current_user = JFactory::getUser();
        $uid = $current_user->id;
        
        if(!$uid){            
            return false;
        }
        
        $query = "insert  into #__jf_jtpl_survey_details ("
        .$this->_db->nameQuote("user_id").","
        .$this->_db->nameQuote("survey_variable").","
        .$this->_db->nameQuote("survey_value")        
        .") VALUES("
        .$this->_db->Quote($uid).","
        .$this->_db->Quote($survey_name).","
        .$this->_db->Quote($values_csv)
        .") ";        
        
        $this->_db->setQuery($query);        
        
        $this->_db->query();
        
        if($this->_db->_errorNum == 1062){
               $query = "UPDATE #__jf_jtpl_survey_details SET "                
                .$this->_db->nameQuote("survey_value") ." = ". $this->_db->Quote($values_csv).' WHERE '
                
                .$this->_db->nameQuote("user_id")."=".$this->_db->Quote($uid)." AND "
                .$this->_db->nameQuote("survey_variable")."=".$this->_db->Quote($survey_name)
                ." LIMIT 1 ";
                
                $this->_db->setQuery($query);
                
                $this->_db->query();
        }
    }
                              
    function get_all_survey($uid = null){
        $user = JFactory::getUser();
        $user_id = $uid ? $uid : $user->id;
        $this->_db->setQuery("SELECT * from #__jf_jtpl_survey_details WHERE "
        .$this->_db->nameQuote("user_id")." = "
        .$this->_db->Quote($user_id))
        ."LIMIT 1";
        
        $this->_db->query();
        return $this->_db->loadObjectList();
    }

    function get_reg_survey_results($uid = null)
    {
        $results = $this->get_all_survey($uid);
        $results_obj = new stdClass();
        $results_obj->disease = array();
        foreach($results as $r) {
            $k = $r->survey_variable;
            if(substr($k,0,11) == "reg_disease"){
                $results_obj->disease[] = $r->survey_value;
            }else{
                switch($k){
                    case "reg_bodyscore":
                        $results_obj->bodyscore = $this->get_body_score_questions($r->survey_value,false);
                    break;
                    case "reg_medtrack":
                        $results_obj->medtrack = $this->get_medtrack_questions($r->survey_value,false);
                    break;
                    case "reg_symptoms":
                        $results_obj->symptoms = $this->get_symptoms_questions($r->survey_value,false);
                    break;
                    case "reg_looking_for":
                        $results_obj->looking_for = $this->get_looking_for_questions($r->survey_value,false);
                    break;
                }
            }
        }

        $results_obj->disease = $this->get_diseases_questions(implode(",",$results_obj->disease),false);

        return $results_obj;
    }
    
    function get_registration_survey_status($user_id = 0){
        if($user_id)
            $user = JFactory::getUser($user_id);
        else
            $user = JFactory::getUser();

        $this->_db->setQuery("SELECT * from #__jf_jtpl_survey_status WHERE "
        .$this->_db->nameQuote("user_id")." = "
        .$this->_db->Quote($user->id))
        ."LIMIT 1";
        
        $this->_db->query();
        return $this->_db->loadAssoc();
    }
    
    function update_survey_status($survey){
        $user = JFactory::getUser();
        
        if($user->systemrole->name == "Client"){
            // first make insert attempt and then if duplicate error occurs, then update the record
            $query = "INSERT INTO #__jf_jtpl_survey_status ("
                    .$this->_db->nameQuote("user_id").","
                    .$this->_db->nameQuote($survey).") "
                    ." Values ("
                    .$this->_db->Quote($user->id).","
                    .$this->_db->Quote("1")
                    .") ";
            $this->_db->setQuery($query);
            $this->_db->query();
            
            if($this->_db->getErrorNum() == 1062){
                $query = "UPDATE #__jf_jtpl_survey_status SET "                    
                    .$this->_db->nameQuote($survey)." =  "
                    .$this->_db->Quote("1")
                    ." WHERE "
                    .$this->_db->nameQuote("user_id")." =  "
                    .$this->_db->Quote($user->id). " LIMIT 1";
            
                $this->_db->setQuery($query);
                $this->_db->query();                
            }
            
        }else if($user->systemrole->name == "Coach"){
            
        }
        
        return $alerts;
    }
    
    function get_user_alerts(){
        // checks current user and finds if anything has to be alerted for the user or not
        
        $user = JFactory::getUser();
        $alerts = array();
        // count unread messages in the inbox
        $query = "SELECT count(".$this->_db->nameQuote("id").") as `unreadmessages` FROM #__jf_messages WHERE "
                .$this->_db->nameQuote("to")." = ".$this->_db->Quote($user->id)." AND ".$this->_db->nameQuote("read")." = ".$this->_db->Quote("0");                
        $this->_db->setQuery($query);        
        $this->_db->query();
        $count = $this->_db->loadObject()->unreadmessages;
        if($count):
            $alerts["You have <strong style='color:#800000;' >{$count} Unread</strong> Messaage(s)"] = JRoute::_("index.php?option=com_jforce&c=message&view=message");
        endif;
        
        if($user->systemrole->name == "Client"){                  
            // populate alerts for client       
            $survey = $this->get_registration_survey_status();
            for($i=0;$i<5;$i++){
                if($survey["registration_survey_$i"] == 0){
                    $name = $this->get_survey_name($i);                    
                    $alerts["$name Survey taken during registration is not complete."] = JRoute::_("index.php?option=com_jforce&view=phase&layout=registration_survey_$i");
                }
            }
        }else if($user->systemrole->name == "Coach"){
            // populate alerts for coach
        }
        
        return $alerts;
    }
    
    
    function get_survey_name($i){
        $survey_name = array("What are you looking for?",
                "Medtrack",
                "Symptoms",
                "Diseases",
                "Body Score"
                );
                
        return $survey_name[$i];
    }                            
    
    function get_progress_tracking($user_id){
        return $this->get_projects($user_id);
    }
    
    // only coach can access this function
    function get_coach_client_messages($client_id){
        $user = JFactory::getUser();
        if($user->systemrole->name == "Coach"){
            // burrow messages between coach and the respective client
            $message_model = JModel::getInstance("Message","JForceModel");
            $messages = $message_model->get_coach_client_messages($user->id,$client_id);
            foreach($messages as &$m){
                if($m->from == $user->id){
                    $m->direction = "sent";
                }else
                    $m->direction = "received";
            }
            return $messages;
        }else{
            global $mainframe;
            $mainframe->redirect(JRoute::_("index.php?option=com_jforce&c=message&view=message"),"You  must be coach to access the client messages","error");
        }
    }

    function check_phase_access_right_to_coach($coach_id){
        
        $project_id = JRequest::getCmd("pid");

        $query = "SELECT * FROM #__jf_projects WHERE `id` = '$project_id' LIMIT 1";
        $this->_db->setQuery($query);
        $this->_db->query();
        $project = $this->_db->loadObject();
        //mdie($project);
        //$table = JTable::getInstance("Person");
        //$table->load($project->author);
        //mdie($table);
        
        $user = JFactory::getUser();

        $user->jtpl->current_project = $project;
        
        if($project->leader == $coach_id){
        		$client_user_id = $project->author;
        		$query = "SELECT * FROM #__jf_persons WHERE `uid` = '$client_user_id' LIMIT 1";
        		$this->_db->setQuery($query);
        		$this->_db->query();
        		$client_person = $this->_db->loadObject();
        		$user->jtpl->current_client = $client_person;        		
            return true;
        }else{
            return false;
        }
        
        //mdie($user);
        //return true;
        
    }
    
    function get_phase_number($project_id){
        $query = "SELECT phase_number FROM #__jf_jtpl_phase_numbers WHERE ".$this->_db->nameQuote("project_id")." = ".$this->_db->Quote($project_id)." LIMIT 1";
        $this->_db->setQuery($query);
        $this->_db->query();
        $phase_number = $this->_db->loadObject()->phase_number;
        if($phase_number){
            return $phase_number;
        }else
            return false;
    }

    function save_progress_tracking($post_array)
    {
        global $mainframe;

        //$time = time();
        $user = JFactory::getUser();

        // check the phase type, if it is survey or evaluation or photo upload proceed accordingly
        //$phase_step_type = $post_array["form_type"];

        $pid = $post_array['pid'] ? $post_array['pid'] : 1;

        $phases_count = 10;

        if(isset($post_array['save_as_new'])) {
            // this form submission should be saved as new phase
            $pid++;
        }

        if($pid > $phases_count) {
            return array('msgtype'=>'error', 'message'=>'Number of phases is exceeded', 'cur_phase'=>$phases_count);
        }
        
        if($user->jtpl->current_client){
        		$user_id = $user->jtpl->current_client->uid;
        }else{
        		$user_id = $user->id;
        }


        $submission_var = "submission_evaluation";
        $intake_var = "intake_evaluation";
        $bodyscore_var = "bodyscore_evaluation";

        $intake_post = $post_array["evaluation"]["intake"];
        $bodyscore_post = $post_array["evaluation"]["bodyscore"];

        $submission_str = $post_array["evaluation"]["submission"];
        $intake_str = implode(",",$intake_post);
        $bodyscore_str = implode(",",$bodyscore_post);

        $this->_db->setQuery("DELETE FROM #__jf_jtpl_survey_details WHERE user_id =".$this->_db->Quote($user_id)."
        AND project_id = ".$this->_db->Quote($pid));
        $this->_db->query();

        $query = "INSERT INTO #__jf_jtpl_survey_details (user_id,project_id,survey_variable,survey_value)
            values (".$this->_db->Quote($user_id).","
                .$this->_db->Quote($pid).","
                .$this->_db->Quote($intake_var).","
                .$this->_db->Quote($intake_str).") ,"

            ."(".$this->_db->Quote($user_id).","
                .$this->_db->Quote($pid).","
                .$this->_db->Quote($bodyscore_var).","
                .$this->_db->Quote($bodyscore_str)."), "
            ."(".$this->_db->Quote($user_id).","
                .$this->_db->Quote($pid).","
                .$this->_db->Quote($submission_var).","
                .$this->_db->Quote($submission_str).")";

        $this->_db->setQuery($query);
;
        $this->_db->query();

        $this->_db->setQuery("DELETE FROM #__jf_jtpl_survey_tracking WHERE user_id =".$this->_db->Quote($user_id)." AND project_id = ".$this->_db->Quote($pid));
        $this->_db->query();

        $tracking = $post_array["tracking"];
        $tracking_query = "INSERT INTO #__jf_jtpl_survey_tracking
                                (user_id,
                                project_id,
                                tracking_category,
                                tracking_variable,
                                status,
                                notes) VALUES";

        $tracking_values_arr = array();

        if(is_array($tracking)){
            foreach($tracking as $t_category=>$t_results){
                foreach($t_results as $t_variable=>$t_value){
                    $tracking_values_arr[] = "(
                                        {$this->_db->Quote($user_id)},
                                        {$this->_db->Quote($pid)},
                                        {$this->_db->Quote($t_category)},
                                        {$this->_db->Quote($t_variable)},
                                        {$this->_db->Quote($t_value["status"])},
                                        {$this->_db->Quote($t_value["notes"])}
                                        )";
                }
            }

            $tracking_query .= implode(",",$tracking_values_arr);


            $this->_db->setQuery($tracking_query);
            $this->_db->query();
        }

        // saving uploaded photo

        $file  = JRequest::get("files");
        if(!empty($file)) {
            $srcfile = $file["filename"]["tmp_name"];
            $this->upload_phase_photo($srcfile,$file["filename"]["name"],$pid);
        }

        //$mainframe->redirect($post_array["step_redirection_link"]);
        //mdie($post_array);
        return array('msgtype'=>'message', 'message'=>'Data is saved successfully', 'cur_phase'=>$pid);

    }

    /**
    * This function will just mark the step completed and store information on who did the completion
    * 
    * @param mixed $post_array
    */
    function mark_phase_step_completed($post_array){                
        global $mainframe;
        
        $time = time();
        $user = JFactory::getUser();
        
        // check the phase type, if it is survey or evaluation or photo upload proceed accordingly
        $phase_step_type = $post_array["form_type"];
        
        $pid = JRequest::getCmd("pid");
        
        if($user->jtpl->current_client){
        		$user_id = $user->jtpl->current_client->uid;
        }else{
        		$user_id = $user->id;
        }

        switch($phase_step_type){
            case "evaluation":
                $eval_var = "end_evaluation";
                $intake_var = "intake_evaluation";                
                $bodyscore_var = "bodyscore_evaluation";                
                
                
                $eval_post = $post_array["evaluation"]["end"];
                $intake_post = $post_array["evaluation"]["intake"];
                $bodyscore_post = $post_array["evaluation"]["bodyscore"];
                
                $eval_arr = array();                
                if(is_array($eval_post)){
                    foreach ($eval_post as $key=>$val){
                        $eval_arr[] = $key.":".$val;
                    }
                }
                
                $intake_arr = array();
                if(is_array($intake_post)){
                    foreach ($intake_post as $key=>$val){
                        $intake_arr[] = $key.":".$val;                    
                    }
                }
                               
                $intake_str = implode(",",$intake_arr);
                $eval_str = implode(",",$eval_arr);
                $bodyscore_str = implode(",",$bodyscore_post);
                
                
                $this->_db->setQuery("DELETE FROM #__jf_jtpl_survey_details WHERE user_id =".$this->_db->Quote($user_id)." AND project_id = ".$this->_db->Quote($pid)." AND FIND_IN_SET(`survey_variable`,".$this->_db->Quote($eval_var.",".$intake_var.",".$bodyscore_var).")");                
                $this->_db->query();
                        
                $query = "INSERT INTO #__jf_jtpl_survey_details (user_id,project_id,survey_variable,survey_value) 
                    values(".$this->_db->Quote($user_id).","                    
                        .$this->_db->Quote($pid).","
                        .$this->_db->Quote($eval_var).","
                        .$this->_db->Quote($eval_str).") ,"                        
                        
                    ."(".$this->_db->Quote($user_id).","
                        .$this->_db->Quote($pid).","
                        .$this->_db->Quote($intake_var).","
                        .$this->_db->Quote($intake_str).") ,"

                    ."(".$this->_db->Quote($user_id).","
                        .$this->_db->Quote($pid).","
                        .$this->_db->Quote($bodyscore_var).","
                        .$this->_db->Quote($bodyscore_str).") ";
                        
                $this->_db->setQuery($query);
                //mdie($this->_db);                
                $this->_db->query();
                
                $tracking = $post_array["tracking"];
                $tracking_query = "INSERT INTO #__jf_jtpl_survey_tracking 
                                        (user_id, 
                                        project_id, 
                                        tracking_category,
                                        tracking_variable,
                                        status,
                                        notes) VALUES";
                
                $tracking_values_arr = array();
                
                if(is_array($tracking)){                
	                foreach($tracking as $t_category=>$t_results){
	                    foreach($t_results as $t_variable=>$t_value){
	                        $tracking_values_arr[] = "(
	                                            {$this->_db->Quote($user_id)},
	                                            {$this->_db->Quote($pid)},
	                                            {$this->_db->Quote($t_category)},
	                                            {$this->_db->Quote($t_variable)},
	                                            {$this->_db->Quote($t_value["status"])},
	                                            {$this->_db->Quote($t_value["notes"])}
	                                            )";
	                    }
	                }
	                
	                $tracking_query .= implode(",",$tracking_values_arr);
	                
	                
	                $this->_db->setQuery($tracking_query);
	                $this->_db->query();
                    
	             }
                
            break;
            
            case "survey":

                $intake_var = "intake_survey";
                $start_var = "initial_survey";
                
                $survey_values = "";
                
                $intake_post = $post_array["survey"]["intake"];
                $start_post = $post_array["survey"]["start"];
                
                $intake_arr = array();
                $start_arr = array();
                
                if(is_array($intake_post)){
                    foreach ($intake_post as $key=>$val){
                        $intake_arr[] = $key.":".$val;
                    }
                }
                
                if(is_array($start_post)){
                    foreach ($start_post as $key=>$val){
                        $start_arr[] = $key.":".$val;
                    }
                }
                
                $intake_str = implode(",",$intake_arr);
                $start_str = implode(",",$start_arr);

                $this->_db->setQuery("DELETE FROM #__jf_jtpl_survey_details WHERE user_id =".$this->_db->Quote($user_id)." AND project_id = ".$this->_db->Quote($pid)." AND FIND_IN_SET(`survey_variable`,".$this->_db->Quote($start_var.",".$intake_var).")");                
                $this->_db->query();
                
                $query = "INSERT INTO #__jf_jtpl_survey_details (user_id,project_id,survey_variable,survey_value) 
                    values(".$this->_db->Quote($user_id).","
                        .$this->_db->Quote($pid).","
                        .$this->_db->Quote($intake_var).","
                        .$this->_db->Quote($intake_str).") ,"
                        
                    ."(".$this->_db->Quote($user_id).","
                        .$this->_db->Quote($pid).","
                        .$this->_db->Quote($start_var).","
                        .$this->_db->Quote($start_str).") ";
                        
                $this->_db->setQuery($query);
                $this->_db->query();

            break;
            
            case "photo_upload":
            //...
            break;
            
            default:
            break;
        }
        
        $user = JFactory::getUser();                
        $checklist_table = JTable::getInstance("Checklist");                   
        
        $checklist_table->load($post_array["phase_id"]);
        
        $checklist_table->completed = 1;        
        $checklist_table->datecompleted = gmdate("Y-m-d h:i:s",$time);
        $checklist_table->completedby = $user->id;        
        
        $checklist_table->store();
        
        $mainframe->redirect($post_array["step_redirection_link"]);
        //mdie($post_array);
    
    }
    
    function compose_message($from,$to,$subject,$body,$created = ""){
        // default admin
        $admin = 62;        
        
        $msg = JTable::getInstance("Message");        
        // FROM
        $msg->from = $from?$from:$admin;
        // TO
        $msg->to = $to;
        // SUBJECT
        $msg->subject = $subject;
        
        // BODY
        $msg->body = $body;
                
        // CREATED
        $msg->created = ($created)?($created):gmdate("Y-m-d H:i:s",time()); 
        // READ
        $msg->read = 0;        
        // PUBLISHED
        $msg->published = 0;        
        
        $msg->store();                
        
    }
    
    
    function proceed_sign_off($post){
        global $mainframe;
        
        $user = JFactory::getUser();
        $user_id = $user->id;
        
        $usertable = JTable::getInstance("Person"); 
        $usertable->id = $user->person->id;        
        $usertable->load();
        
        $company = JTable::getInstance("Company"); 
        
        $company->id = $usertable->company;
        $company->load();
        
        $coach_id = $company->owner;
        
        $coach = "";        
        $client_url = JRoute::_("index.php?option=com_jforce&c=people&view=person&layout=client&id={$user->person->id}");
        $phase_url = JRoute::_("index.php?option=com_jforce&view=checklist&pid={$post["pid"]}&client_id={$user->person->id}");
        
        // SUBJECT
        $subject = "[SIGNOFF REQUEST] Received from Client '{$user->name}' having username '{$user->username}'";
        
        // BODY        
        $body = "Dear {$company->name}, <br />A Signoff request has been received from a client with following details. 
                    <br />
                    Username : <strong>{$user->username}</strong><br />
                    Fullname : <strong>{$user->name}</strong><br />
                    User Id : <strong>{$user->id}</strong><br />
                    Client URL : <a href={$client_url}>{$client_url}</a><br />
                    Phase Requested for Signoff : <a href={$phase_url}>{$phase_url}</a><br />
                    
                    <br />
                    To signoff the phase, visit the phase via Phase URL link above, and edit the Sign off step as completed.                     
                    ";
        

        $this->compose_message($admin,$coach_id,$subject,$body);
        
        $mainframe->redirect($post["step_redirection_link"]);
    }
    
    function get_virtuemart_products($product_id = 0){
        if($product_id):
            $query = "SELECT * from #__vm_product WHERE ".$this->_db->nameQuote("product_id")." = ".$this->_db->Quote($product_id)." LIMIT 1";
            
            $this->_db->setQuery($query);
            $this->_db->query();
            $product = $this->_db->loadObject();
            return $product;
        else:
            $query = "SELECT "
                .$this->_db->nameQuote("product_id").","
                .$this->_db->nameQuote("product_name")." from #__vm_product WHERE 1";         
                
            $this->_db->setQuery($query);
            $this->_db->query();
            $products = $this->_db->loadObjectList();
            return $products;
        endif;
    }
    
    function get_recommended_products(){
        $current_person_id = JFactory::getUser()->person->id;        

        $person_t = JTable::getInstance("Person");
        
        $client_id = JRequest::getCmd("client_id");
        $client_id = ($client_id)?$client_id:$current_person_id;
        
        $person_t->id = $client_id;        
        
        $person_t->load();
        
        $_client_id = $this->_db->Quote($person_t->uid);
        $project_id = $this->_db->Quote(JRequest::getCmd("pid"));
        
        $query = "SELECT "
                .$this->_db->nameQuote("recommendation_id").","
                .$this->_db->nameQuote("product_id").","
                .$this->_db->nameQuote("product_name")."," 
                .$this->_db->nameQuote("quantity")."," 
                .$this->_db->nameQuote("recommendation_notes")."," 
                .$this->_db->nameQuote("recommendation_date")."                 
                
                    FROM #__vm_product v 
                    NATURAL JOIN #__jf_jtpl_product_recommendations r 
                    WHERE v.product_id = r.product_id 
                    AND r.client_user_id = {$_client_id}
                    
                    AND r.project_id = {$project_id}
                    
                    ORDER BY r.recommendation_date DESC
                    ";
                    
                    
        $this->_db->setQuery($query);                   
        $this->_db->query();
        $products = $this->_db->loadObjectList();
        return $products;
    }
    
    function save_recommendation($post){
        $coach = JFactory::getUser();
        $coach_id = $coach->id;
        
        $person_t = JTable::getInstance("Person");
        $person_t->id = JRequest::getCmd("client_id");
        $person_t->load();        
        $client_user_id = $person_t->uid;
        
        $recommended_date = gmdate("Y-m-d H:i:s",time()); 
        
        $product = $this->get_virtuemart_products($post["product"]);
        $product_url = JRoute::_("index.php?option=com_virtuemart&page=shop.product_details&product_id=".$product->product_id);


        $query = "INSERT INTO #__jf_jtpl_product_recommendations (product_id, 
                                                        project_id, 
                                                        client_user_id, 
                                                        coach_user_id,
                                                        quantity, 
                                                        recommendation_notes, 
                                                        recommendation_date) 
            values(".$this->_db->Quote($post["product"]).","
                .$this->_db->Quote(JRequest::getCmd("pid")).","
                .$this->_db->Quote($client_user_id).","
                .$this->_db->Quote($coach_id).","
                .$this->_db->Quote($post["quantity"]).","
                .$this->_db->Quote($post["notes"]).","
                .$this->_db->Quote($recommended_date)
                .") ";
                
        $this->_db->setQuery($query);
        $this->_db->query();        
        
        // Compose the message for client to notify about the recommendation
        
        // SUBJECT
        $subject = "[PRODUCT RECOMMENDATION] Coach '{$coach->name}' has recommended you a product";
        
        // BODY        
        $body = "Dear {$person_t->firstname} {$person_t->lastname}, <br />Coach {$coach->name} has recommended you a product for your phase currently active. 
        <br />
            You are suggested to communicate with your coach regarding the product recommendation. 
        <br />
                    <br />
                    Product Name : <strong>{$product->product_name}</strong><br />
                    Product URL : <a href='{$product_url}'>{$product_url}</a><br />
                    Recommended Quantity : <strong>{$post["quantity"]}</strong><br />
                    Recommendation Note : {$post["notes"]}<br />
                    Recommendation Date: {$recommended_date}<br />
                    ";
        

        $this->compose_message(0,$client_user_id,$subject,$body);
        return true;
    }
    
    function delete_recommendation($recommendation_id){

        $query = "DELETE FROM #__jf_jtpl_product_recommendations WHERE 
                    ".$this->_db->nameQuote("recommendation_id")." = "
                        .$this->_db->Quote($recommendation_id);
                $this->_db->setQuery($query);
                $this->_db->query();
                return true;
    }
    
    function get_client_information($client_id){
        $model = JModel::getInstance("Person","JForceModel");
        $model->_id = $client_id;
        $model->_pid = 0;
        $person = &$model->getPerson();
        return $person;;
    }    
    
    function get_registration_survey($user_id){
        $results = array();
        return $results;
    }
    
    private function get_phase_survey($user_id, $phase_id, $keyword){
        $query = "SELECT * FROM #__jf_jtpl_survey_details WHERE 
                {$this->_db->nameQuote("user_id")} = {$this->_db->Quote($user_id)} 
                AND 
                {$this->_db->nameQuote("project_id")} = {$this->_db->Quote($phase_id)} 
                AND 
                {$this->_db->nameQuote("survey_variable")} LIKE {$this->_db->Quote($keyword)} 
                ";
                
        $this->_db->setQuery($query);
        $this->_db->query();        
        return $this->_db->loadObjectList();
    }
    function get_phase_initial_survey($user_id,$phase_id){
        return $this->get_phase_survey($user_id,$phase_id,"%survey");
    }
    
    function get_phase_end_evaluation($user_id,$phase_id){
        return $this->get_phase_survey($user_id,$phase_id,"%evaluation");
    }
    
    function split_csv($csv_string,$delimitter = ":"){
        if(!strlen($csv_string)){
            return null;
        }
        $csv_arr = explode(",",$csv_string);
        

        foreach($csv_arr as $a){
            $var = explode($delimitter,$a);
            $split_arr[$var[0]] = $var[1];
        }        
        return $split_arr;
    }
    
    function get_phase_survey_name($phase_number, $step){
        $query = "SELECT name FROM #__jf_jtpl_surveys WHERE 
                {$this->_db->nameQuote("phase_number")} = {$this->_db->Quote($phase_number)} 
                AND 
                {$this->_db->nameQuote("step")} = {$this->_db->Quote($step)} 
                LIMIT 1
                ";
                
        $this->_db->setQuery($query);
        $this->_db->query();        
        $result = $this->_db->loadObject();
        return $result->name;
    }
    
    function get_phase_survey_questions($phase_number, $step){
        $query = "SELECT * FROM #__jf_jtpl_survey_questions WHERE 
                {$this->_db->nameQuote("phase_number")} = {$this->_db->Quote($phase_number)} 
                AND 
                {$this->_db->nameQuote("step")} = {$this->_db->Quote($step)} 
                ";
                
        $this->_db->setQuery($query);
        $this->_db->query();        
        return $this->_db->loadObjectList();
    }
    
    function get_tracking($phase_id, $user_id){
        $query = "SELECT * FROM #__jf_jtpl_survey_tracking WHERE 
                {$this->_db->nameQuote("project_id")} = {$this->_db->Quote($phase_id)} 
                AND 
                {$this->_db->nameQuote("user_id")} = {$this->_db->Quote($user_id)} 
                ";
                
        $this->_db->setQuery($query);
        $this->_db->query();        
        return $this->_db->loadObjectList();
    }
    
    function get_all_clients(){
        $query = "SELECT * FROM #__users as u
                JOIN #__jf_persons as p
                WHERE 
                u.block = {$this->_db->Quote(0)} 
                AND u.activation = {$this->_db->Quote('')} 
                AND u.id = p.uid AND p.systemrole = '4' ";
                
        $this->_db->setQuery($query);
        
        $this->_db->query();     

        return $this->_db->loadObjectList();    
    }
    
    /**
    * user_id is the person_id
    * 
    * @param mixed $user_id
    */
    function make_client_a_coach($user_id){
    	// fetch the user
        
        global $mainframe;
        $person = JTable::getInstance(("Person"));
        if(!$person->load($user_id)){
            $mainframe->redirect(JRoute::_("?option=com_jforce&view=phase&layout=newcoach"),"User not found","error");
            return false;
        }
        
        $user_id = $person->uid;
        $name = $person->firstname." ".$person->lastname;
        
        // create a company
        $query = "INSERT INTO #__jf_companies (name, owner, author, created, modified, published)
        			VALUES ('{$name}','$user_id','$user_id',NOW(), NOW(), '1') ";
                
        $this->_db->setQuery($query);        
        $this->_db->query();
        
        if(!$this->_db->getErrorNum()){
            $new_company = $this->_db->insertid();
            
            // update the role and company
            $query = "UPDATE #__jf_persons SET  
                    systemrole = '2', company = '$new_company' WHERE 
                    uid = '{$user_id}'  
                    LIMIT 1";
                    
            $this->_db->setQuery($query);        
            $this->_db->query();
            
            $query = "SELECT * FROM #__jf_persons WHERE uid = ".$this->_db->Quote($user_id)." limit 1";
                
            $this->_db->setQuery($query);        
            $this->_db->query();
            
            $person = $this->_db->loadObject();
            
            return true;
        }
    }
    
    function assign_coach_to_client($coach_company_id, $client_user_id){    
        
        global $mainframe; 
        
        $query = "SELECT * FROM #__jf_companies WHERE id = '$coach_company_id' LIMIT 1 ";
        $this->_db->setQuery($query);
        $this->_db->query();
        $company = $this->_db->loadObject();
        
        if($company){
        	$coach_id = $company->owner;
        }else{
            $mainframe->redirect("?option=com_jforce&view=dashboard","Coach does not exist","error");
        }

        // update the projects
        $query = "UPDATE #__jf_projects SET leader='$coach_id', company='$coach_company_id' WHERE author = '$client_user_id' ";
        $this->_db->setQuery($query);
        $this->_db->query();
        
        //mdie($this->_db);
        
        // UPDATE PROJECT ROLES
		  $query = "UPDATE #__jf_projectroles_cf SET uid = '$coach_id' WHERE uid = '0' AND pid IN (SELECT id FROM #__jf_projects WHERE author='$client_user_id' )";        
        $this->_db->setQuery($query);
        $this->_db->query();
        
        //mdie($this->_db);
        
        // update the checklists
		  $query = "UPDATE #__jf_checklists SET author = '$coach_id' WHERE pid IN (SELECT id FROM #__jf_projects WHERE author='$client_user_id' )";
        $this->_db->setQuery($query);
        $this->_db->query();
        
        //mdie($this->_db);        
                
        // add company id for the client as the coach's company
        $query = "UPDATE #__jf_persons SET company = '$coach_company_id' WHERE uid = '$client_user_id' LIMIT 1";
        $this->_db->setQuery($query);
        $this->_db->query();
        
        //mdie($this->_db);
        
    }
    
    function get_all_coaches(){
        $query = "SELECT * FROM #__jf_companies WHERE published = '1' ";
        $this->_db->setQuery($query);
        $this->_db->query();
        return $this->_db->loadObjectList();    
    	
    }
    
    /**
    * Checks current page and generates the four extra boxes if not listed
    * 
    * Layout options are from the following 
    * a) medtrack
    * b) symptoms
    * c) diseases
    * 
    * All extra details will be included in a single table - _jf_jtpl_extraboxes
    * 
    * 
    * 
    */
    function get_four_extra_boxes($layout = ""){
        $boxes = true;
        $where = "";
        $user = JFactory::getUser();
        if($user->systemrole->name == "Client"){
            $user_id = $user->id;
        }else if($user->systemrole->name == "Coach"){
            
            // only clients can access the registration time survey boxes
            // when coach has to see, its only the tracking case and will be dealt
            // the next function 
            // get_four_extra_boxes_tracking($layout)
            
            $this->check_phase_access_right_to_coach($user->id);
            if($user->jtpl->current_client){
                $user_id = $user->jtpl->current_client->uid;
            }else            
                return false;
        }

        switch($layout){
            case "medtrack":                        
            case "symptoms":
            case "diseases":
            case "":
                $boxes = true;                
            break;
            default:
                $boxes = false;
            break;
        }
        
        if($boxes){
            $where = "WHERE ";
            if($layout != ""):
                $where .= $this->_db->nameQuote("page")." = ".$this->_db->Quote($layout).
                " AND ";
            endif;
                
            $where.= $this->_db->nameQuote("user_id")." = ".$this->_db->Quote($user_id);
                    
            $this->_db->setQuery("SELECT * FROM #__jf_jtpl_survey_extraboxes $where");
            $this->_db->query();

            //mdie($user);        
            return $this->_db->loadObjectList();
            
//            mdie($this->_db);
        }
        return $boxes; 
    }                                     


    function save_extra_boxes($data,$page){
        switch($page){
            case "medtrack":
            case "diseases":
            case "symptoms":
                // proceed in these cases
            break;
            default:
                // nothing to do return now. 
                return false;
            break;
        }
        
        $user = JFactory::getUser();
        if($user->systemrole->name=="Client"){
            $user_id = $user->id;
        }else
            return false;
        
        
        $update = $data[0];
        $insert = $data[1];
        foreach($update as $i=>$u){
            if($u):
                $this->_db->setQuery("UPDATE #__jf_jtpl_survey_extraboxes SET value = ".$this->_db->Quote($u)." WHERE id = ".$this->_db->Quote($i)."");
                $this->_db->query();
            elseif ($u == ""):
                $this->_db->setQuery("DELETE FROM #__jf_jtpl_survey_extraboxes WHERE id = ".$this->_db->Quote($i)."");
                $this->_db->query();
            endif;
            
        }
        
        foreach($insert as $i=>$in){
            if($in){
                $this->_db->setQuery("INSERT INTO #__jf_jtpl_survey_extraboxes (page,value,user_id) VALUES (".$this->_db->Quote($page).",".$this->_db->Quote($in).",".$user_id.")"); 
                $this->_db->query();
            }
        }
        return true;
    }                                        
    
    function admin_email($data = null){
        if(!$data){
            // return current admin email
            //$this->_db->setQuery("SELECT * FROM #__jf_jtpl_prefs WHERE variable = 'admin_email' LIMIT 1");
            $mailer = JFactory::getMailer();
            return $mailer->From;
        }else{
            // proceed updating admin email
            if(is_array($data)){
                if($data["new_email_1"] == $data["new_email_2"]){
                    /**
                    * Update store email
                    */
                    $this->_db->setQuery("update #__vm_vendor set contact_email=".$this->_db->Quote($data["new_email_1"])." LIMIT 1"); 
                    $this->_db->query();
                    //mdie($this->_db);
                    /**
                    * Update the config file
                    */
                    $config_file = implode("",file("configuration.php"));
                    //mdie($config_file);
                    //$x = preg_replace("/var/","char",$config_file,1);
                    //e($x);
                    
                    //var $mailfrom = 'info@maximhealthsystem.com';

                    
                    //mdie($config_file);
                    //$patterns = '/^\s*(\w+)\s*=/';
                    //$patterns = "/\s*\$(mailfrom)\s*=/";
                    //$patterns = "/\s*(var)\s*\$\w*=/";
                    //$patterns = "/^\s*(\w+)\s*/";
                    $patterns = "/var(.*)mailfrom(.*)=(.*)'(.*)'/";
                    $replace = "var \$mailfrom = '".$data["new_email_1"]."'";
                    $new_config = preg_replace($patterns, $replace, $config_file);
                    
                    $fp = fopen("configuration.php","w");
                    fwrite($fp, $new_config, strlen($new_config));
                    fclose($fp);
                    //echo $config_file;
                }
            }else
                return false;
        }
            
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
	function setKeyword($keyword = null)
	{
		$this->_keyword = $keyword;	
	}
	
	function setPhrase($phrase)
	{
		$this->_phrase = $phrase;	
	}

	function setOrdering($ordering) 
	{	
		$this->_ordering = $ordering;	
	}
    
	
	function setPid($pid){
		$this->_pid		= $pid;
	}
	
	function getSearchResults() {	
		
		$types = array('checklist',
					   'comment',
					   'company',
					   'discussion',
					   'document',
					   'invoice',
					   'quote',
					   'message',
					   'milestone',
					   'service',
					   'task',
					   'ticket'
					   );
		
		$matches = array();
		
		foreach($types as $type):

			switch($type) :
					case 'milestone':
						$title = 'summary';
						$text = 'notes';
					break;
					
					case 'task':
						$title = 'summary';
						$text = null;
					break;
					
					case 'comment':
						$title = 'message';
						$text = null;
					break;
						
					case 'discussion':
						$title = 'summary';
						$text = 'message';
					break;
					
					case 'ticket':
					case 'checklist':
						$title = 'summary';
						$text = 'description';
					break;
						
					case 'quote':
					case 'invoice':
					case 'document':
						$title = 'name';
						$text = 'description';
					break;
						
				endswitch;
												
			  $wheres = array();
			
				if($this->_keyword!='') { 
				
				  switch ($this->_phrase) {
					
				  }
				}
				  $morder = '';
				  switch ($this->_ordering) {
					case 'newest':
					default: 
					$order = 't.created DESC';
				  break;
					case 'oldest':
					$order = 't.created ASC';
					break;
					case 'alpha':
					$order = 't.'.$title.' ASC';
					break;
				  }
	
		
		endforeach;
		if($matches):	
			$matches = JForceHelper::sortArray($matches,'created');
		else:
			$matches = null;
		endif;
		
		
	$this->_matches = $matches;
	
	return $this->_matches;

    }
	
	function buildLists()
	{
		$lists['projects'] = JForceListsHelper::getProjectList();	

		return $lists;
	}

    function getBodyScoreResults($user_id)
    {
        $db =& $this->_db;
        $query = "SELECT survey_value FROM #__jf_jtpl_survey_details
                  WHERE user_id = $user_id AND survey_variable = 'reg_bodyscore'
                  LIMIT 1";
        $db->setQuery($query);
        $answers = $db->loadResult();

        return $this->_getBodyScorePercents($answers);
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
        for($i = 0; $i < $cats_len; $i++) {
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

    function getBodyScoreChartData($percents) {
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

    function getProgressTrackingDetails($user_id, $phase_id) {

        $db =& JFactory::getDBO();

        $user_id = (int)$user_id;
        $phase_id = (int)$phase_id;

        if($phase_id == 1) {
            // check if we have available saved 1st phase
            $db->setQuery("SELECT * FROM #__jf_jtpl_survey_details WHERE user_id = $user_id AND project_id = 1");
            $db->query();
            $has = (bool)$db->getNumRows();
            if(!$has) {
                return $this->getRegistrationTrackingDetails($user_id);
            }
        }

        $phase = new stdClass();

        // get phase photos
        $sql = "SELECT photo FROM #__jf_jtpl_progress_tracking WHERE user_id = $user_id AND phase_id = ".$phase_id;
        $db->setQuery($sql);
        $phase->photo = $db->loadResult();

        //get symptoms tracking
        $sql = "SELECT s.question, s.variable, t.status, t.notes FROM #__jf_jtpl_survey_tracking t LEFT JOIN #__jf_jtpl_survey_symptoms s ON s.variable = t.tracking_variable WHERE `project_id` = $phase_id AND user_id = $user_id AND `tracking_category` = 'symptoms'";
        $db->setQuery($sql);
        $phase->symptoms = $db->loadObjectList();

        //get diseases tracking
        $sql = "SELECT s.question, s.variable, t.status, t.notes FROM #__jf_jtpl_survey_tracking t LEFT JOIN #__jf_jtpl_survey_diseases s ON s.variable = t.tracking_variable WHERE `project_id` = $phase_id AND user_id = $user_id AND `tracking_category` = 'diseases'";
        $db->setQuery($sql);
        $phase->diseases = $db->loadObjectList();

        //get medtrack tracking
        $sql = "SELECT s.question, s.variable, t.status, t.notes FROM #__jf_jtpl_survey_tracking t LEFT JOIN #__jf_jtpl_survey_medtrack s ON s.variable = t.tracking_variable WHERE  `project_id` = $phase_id AND user_id = $user_id AND `tracking_category` = 'medtrack'";
        $db->setQuery($sql);
        $phase->medtrack = $db->loadObjectList();

        // get bodyscore retake
        $sql = "SELECT survey_value FROM #__jf_jtpl_survey_details WHERE survey_variable = 'bodyscore_evaluation' AND user_id = $user_id AND project_id = $phase_id";
        $db->setQuery($sql);
        $ids = $db->loadResult();

        $phase->bodyscore = new stdClass();
        $phase->bodyscore->answers = explode(',', $ids);
        // get data for chart
        if($ids) {
            $percents = $this->_getBodyScorePercents($ids);
            $chartdata = $this->getBodyScoreChartData($percents);

            $bs_chart = new stdClass();
            $bs_chart->cats = json_encode($chartdata['cats']);
            $bs_chart->vals = json_encode($chartdata['vals']);
            $bs_chart->opp_vals = json_encode($chartdata['opp_vals']);
            $phase->bodyscore->chart = $bs_chart;
        } else {
            $phase->bodyscore->chart = false;
        }

        // get intake evaluation
        // intake
        $phase->intake = new stdClass();
        $query = "SELECT survey_value FROM #__jf_jtpl_survey_details
                  WHERE survey_variable = 'intake_evaluation' AND project_id = $phase_id AND user_id = $user_id";
        $db->setQuery($query);
        $intake_vars = explode(',', $db->loadResult());
        $phase->intake->weight = $intake_vars[0];
        $phase->intake->fat = $intake_vars[1];
        $phase->intake->point = $intake_vars[2];

        // submission date
        $query = "SELECT survey_value FROM #__jf_jtpl_survey_details
                  WHERE survey_variable = 'submission_evaluation' AND project_id = $phase_id AND user_id = $user_id";
        $db->setQuery($query);
        $phase->submission = $db->loadResult();

        // select current photo or the closest phase photo
        $sql = "SELECT photo FROM #__jf_jtpl_progress_tracking t WHERE user_id = $user_id AND phase_id = (
                    SELECT MAX(phase_id) FROM #__jf_jtpl_progress_tracking WHERE user_id = $user_id AND phase_id <= $phase_id)";
        $db->setQuery($sql);
        $phase->photo = $db->loadResult();

        return $phase;
    }

    function getRegistrationTrackingDetails($user_id)
    {
        $db =& JFactory::getDBO();

        $user_id = (int)$user_id;

        $phase = new stdClass();

        $prefix_len = strlen('reg_');
        $vars = array(
            "'reg_medtrack'",
            "'reg_symptoms'",
            "'reg_bodyscore'"
        );
        $query = "SELECT survey_variable, survey_value FROM #__jf_jtpl_survey_details
                  WHERE survey_variable IN (".implode(',', $vars).") AND project_id = 0 AND user_id = $user_id";
        $db->setQuery($query);
        $data = $db->loadObjectList();

        foreach($data as $v) {
            $current_var = substr($v->survey_variable, $prefix_len);

            if($current_var == 'bodyscore') {
                $phase->$current_var = new stdClass();
                $phase->$current_var->answers = explode(',', $v->survey_value);

                // get data for chart
                if($phase->$current_var->answers) {
                    $percents = $this->_getBodyScorePercents($v->survey_value);
                    $chartdata = $this->getBodyScoreChartData($percents);

                    $bs_chart = new stdClass();
                    $bs_chart->cats = json_encode($chartdata['cats']);
                    $bs_chart->vals = json_encode($chartdata['vals']);
                    $bs_chart->opp_vals = json_encode($chartdata['opp_vals']);
                    $phase->$current_var->chart = $bs_chart;
                } else {
                    $phase->$current_var->chart = false;
                }

            } else {
                // get values human-friendly names
                $vals = explode(',', $v->survey_value);
                foreach($vals as &$k) {
                    $k = $db->Quote($k);
                }
                $sql = "SELECT variable, question FROM #__jf_jtpl_survey_".$current_var." WHERE variable IN (".implode(',',$vals).")";

                $db->setQuery($sql);
                $phase->$current_var = $db->loadObjectList();
            }
        }

        // retrieving diseases as their storage method differs
        $query = "SELECT survey_value FROM #__jf_jtpl_survey_details
                  WHERE survey_variable LIKE 'reg_disease_%' AND project_id = 0 AND user_id = $user_id";
        $db->setQuery($query);
        $vals = $db->loadResultArray();
        foreach($vals as &$k) {
            $k = $db->Quote($k);
        }
        $sql = "SELECT variable, question FROM #__jf_jtpl_survey_diseases WHERE variable IN (".implode(',',$vals).")";
        $db->setQuery($sql);
        $phase->diseases = $db->loadObjectList();

        // intake
        $phase->intake = new stdClass();
        $query = "SELECT survey_value FROM #__jf_jtpl_survey_details
                  WHERE survey_variable = 'reg_intake' AND project_id = 0 AND user_id = $user_id";
        $db->setQuery($query);
        $intake_vars = explode(',', $db->loadResult());
        $phase->intake->weight = $intake_vars[0];
        $phase->intake->fat = $intake_vars[1];
        $phase->intake->point = $intake_vars[2];

        // submission date
        $query = "SELECT survey_value FROM #__jf_jtpl_survey_details
                  WHERE survey_variable = 'reg_submission' AND project_id = 0 AND user_id = $user_id";
        $db->setQuery($query);
        $phase->submission = $db->loadResult();

        // photo
        $sql = "SELECT photo FROM #__jf_jtpl_progress_tracking WHERE user_id = $user_id AND phase_id = 0";
        $db->setQuery($sql);
        $phase->photo = $db->loadResult();

        return $phase;
    }
}