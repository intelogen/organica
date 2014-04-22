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
            .$this->_db->nameQuote("author")." = ".$this->_db->Quote($user_id);
        
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
    
    function upload_phase_photo($src,$filename,$phase_id,$phasepoint){
        if(!$filename){
            return false;
        }
        if($src && file_exists($src)){
            $user = JFactory::getUser();            
            $destination = $user->id."__".time()."__".$filename;            
            move_uploaded_file($src,"uploads_jtpl/phase_details/".$destination);                        
            // TODO
            // write the uploaded filename to database
            $this->_db->setQuery(
                        "insert into #__jf_jtpl_phasedetails ("
                        .$this->_db->nameQuote("phase_id")
                        .",".$this->_db->nameQuote($phasepoint."photo")
                        .")"
                        ."VALUES ("
                        .$this->_db->Quote($phase_id)
                        .",".$this->_db->Quote($destination)
                        .")");
            
            $this->_db->query();
            if($this->_db->getErrorNum() == 1062){// if exists, update
                $this->_db->setQuery(
                        "update #__jf_jtpl_phasedetails SET "
                        .$this->_db->nameQuote($phasepoint."photo")."=".$this->_db->Quote($destination)
                        ." WHERE "
                        .$this->_db->nameQuote("phase_id") ." = ".$this->_db->Quote($phase_id)
                        ." AND "
                        .$this->_db->nameQuote($phasepoint."photo") ." = ".$this->_db->Quote("")
                        );
             
             $this->_db->query();           
             if( $this->_db->getAffectedRows() == 0);
                return false;
            }           
                
            return true;
        }
        return false;
    }

	// get phase details for a particular phase	
    // JTPL HACK
	function get_phase_details(){
		//$this->_db->setQuery("SELECT * FROM #__jf_projects WHERE 1");
		//return $this->_db->loadObjectList		
		// current user
        $project_model =& JModel::getInstance('Project','JForceModel');
        $project_model->setId(JRequest::getCmd($this->_pid));
        $project_model->getProject();
        
        $db = JFactory::getDBO( );
        $query = "SELECT * FROM #__jf_jtpl_phasedetails WHERE ".$db->nameQuote(phase_id)." = ".$db->Quote(JRequest::getCmd("phase_id"))." LIMIT 1";
        
        $db->setQuery($query);
        $db->query();        
        
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
    }
                              
    function get_all_survey(){
        $user = JFactory::getUSer();
        $this->_db->setQuery("SELECT * from #__jf_jtpl_survey_details WHERE "
        .$this->_db->nameQuote("user_id")." = "
        .$this->_db->Quote($user->id))
        ."LIMIT 1";
        
        $this->_db->query();
        return $this->_db->loadObjectList();
    }   
    
    function get_registration_survey_status(){
        $user = JFactory::getUSer();
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
            // populate alerts for coach
        }
        
        return $alerts;
    }
    
    function get_user_alerts(){
        // checks current user and finds if anything has to be alerted for the user or not
        
        $user = JFactory::getUser();
        $alerts = array();
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
        
        if($project->leader == $coach_id){
            return true;
        }else
            return false;
        
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
    
    /**
    * This function will just mark the step completed and store information on who did the completion
    * 
    * @param mixed $post_array
    */
    function mark_phase_step_completed($post_array){        
        global $mainframe;
        
        $time = time();
        
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

}