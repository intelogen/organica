<?php 

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			view.html.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view'); 

class JforceViewPhase extends JView {
	
    function display($tpl = null) {
        global $mainframe;

        $document =& JFactory::getDocument();
		$layout = $this->getLayout();
        $model = &$this->getModel();
		$uri	=& JFactory::getURI();
        $user =& JFactory::getUser();
        
        $pid = JRequest::getCmd("pid");
        $phase_id = JRequest::getCmd("phase_id");
        $phase_number = $model->get_phase_number($pid);
        $this->assign("phase_number",$phase_number);
        $this->assign("step_redirection_link",JRoute::_("index.php?option=com_jforce&view=checklist&pid={$pid}"));            
        $this->assign("step_action_link",JRoute::_("index.php?option=com_jforce&view=phase&pid={$pid}&task=mark_step_completed&phase_id={$phase_id}"));
        
        $this->assign("pid",$pid);
        $this->assign("phase_id",$phase_id);
            
        
        // default action for all if not overridden
        $action = 'index.php?option=com_jforce&view=phase&layout=results';
        
        
        // survey, photoupload, direction, purchase, evaluation, signoff
		if($layout=='survey'):
            // generate the display variables
            
            $survey_name = $model->get_phase_survey_name($phase_number, "start");
            $survey_questions = $model->get_phase_survey_questions($phase_number, "start");
            
            $this->assign("survey_name",$survey_name);
            $this->assignRef("survey_questions",$survey_questions);
			$this->_display_survey($tpl);
            return;
        elseif($layout == "photoupload"):
            $this->_display_photoupload($tpl);
            return;
        elseif($layout == "direction"):
            $this->_display_direction($tpl);
            return;
        elseif($layout == "purchase"):

            $project_model = JModel::getInstance("project","JforceModel");
            $project = $project_model->getProject();
            $this->assign("phase_name",$project->name);
            
            // also identify the shopping cart link provided by virtuemart
            $product_id = 27+$phase_number;
            $link = "index.php?page=shop.product_details&flypage=flypage.tpl&product_id={$product_id}&category_id=31&option=com_virtuemart";            
            //$phase_to_category_id = $project_model->get_product_category_for_phase();
            //$link .= $phase_to_category_id;
            $this->assign("shopping_cart_link",$link);
            
            $this->_display_purchase($tpl);
            return;
            
            
            
            
            
            
        elseif($layout == "evaluation"):
            // scripts for ajax adding of medtracks, symptoms etc.
            $document->addStyleSheet(JURI::root().'components/com_hreport/css/autocompleter.css');
            JHTML::script('autocompleter.js',JURI::root().'components/com_hreport/js/', true);
            JHTML::script('observer.js',JURI::root().'components/com_hreport/js/', true);
            JHTML::script('progress_tracking.js',JURI::root().'components/com_jforce/js/phase/', true);

            // adding chart
            JHTML::script('jquery-1.7.1.min.js',JURI::root().'components/com_jforce/js/charts/');
            JHTML::script('highcharts.js',JURI::root().'components/com_jforce/js/charts/');

            $pid = JRequest::getInt("pid");
            $pid = $pid ? $pid : 1;
            $this->assignRef('pid', $pid);
            //$survey_name = $model->get_phase_survey_name($phase_number, "end");
            //$survey_questions = $model->get_phase_survey_questions($phase_number, "end");
            
            //$this->assign("survey_name",$survey_name);
            //$this->assignRef("survey_questions",$survey_questions);
            
            
            $this->assignRef("body_score_questions",$model->get_body_score_questions("",true));
            //$this->assignRef("body_score_answers",$model->get_body_score_answers());

            $this->_display_evaluation($tpl);
            return;
            
            
            
            
            
        elseif($layout == "signoff"):
            $this->_display_signoff($tpl);
            return;
        elseif($layout == "registration_survey_0"):

            $this->_displayRegistrationSurvey();
            /*
            $this->assignRef("looking_for_questions",$model->get_looking_for_questions("",true));
            $this->assignRef("looking_for_answers",$model->get_looking_for_answers());
            */
        elseif($layout == "registration_survey_1"):
            $document->addStyleSheet(JURI::root().'components/com_hreport/css/autocompleter.css');
            JHTML::script('autocompleter.js',JURI::root().'components/com_hreport/js/', true);
            JHTML::script('observer.js',JURI::root().'components/com_hreport/js/', true);
            JHTML::script('reg_survey_1.js',JURI::root().'components/com_jforce/js/phase/', true);
            $this->assignRef("medtrack_questions",$model->get_medtrack_questions("",true));
            $this->assignRef("medtrack_answers",$model->get_medtrack_answers());
            $extraboxes = $model->get_four_extra_boxes("medtrack");
            $box_code = $this->_get_extra_boxes_code($extraboxes, "medtrack");
            $this->assignRef("extraboxes_code",$box_code);

        elseif($layout == "registration_survey_2"):
            $document->addStyleSheet(JURI::root().'components/com_hreport/css/autocompleter.css');
            JHTML::script('autocompleter.js',JURI::root().'components/com_hreport/js/', true);
            JHTML::script('observer.js',JURI::root().'components/com_hreport/js/', true);
            JHTML::script('reg_survey_2.js',JURI::root().'components/com_jforce/js/phase/', true);
            $this->assignRef("symptoms_questions",$model->get_symptoms_questions("",true));
            $this->assignRef("symptoms_answers",$model->get_symptoms_answers());
            $extraboxes = $model->get_four_extra_boxes("symptoms");
            $box_code = $this->_get_extra_boxes_code($extraboxes, "symptoms");
            $this->assignRef("extraboxes_code",$box_code);
            
        elseif($layout == "registration_survey_3"):
            $document->addStyleSheet(JURI::root().'components/com_hreport/css/autocompleter.css');
            JHTML::script('autocompleter.js',JURI::root().'components/com_hreport/js/', true);
            JHTML::script('observer.js',JURI::root().'components/com_hreport/js/', true);
            JHTML::script('reg_survey_3.js',JURI::root().'components/com_jforce/js/phase/', true);
            $this->assignRef("diseases_questions",$model->get_diseases_questions("",true));            
            $answers = $model->get_diseases_answers();
            $x = array();
            foreach($answers as $a){
                $x[] = $a->survey_value;
            }
            $x = implode(",",$x);
            $this->assignRef("diseases_answers",$x);
            $extraboxes = $model->get_four_extra_boxes("diseases");
            $box_code = $this->_get_extra_boxes_code($extraboxes, "diseases");
            $this->assignRef("extraboxes_code",$box_code);
            
        elseif($layout == "registration_survey_4"):
            $this->assignRef("body_score_questions",$model->get_body_score_questions("",true));
            $this->assignRef("body_score_answers",$model->get_body_score_answers());
        elseif($layout == "registration_survey_5"):
            // adding chart
            JHTML::script('jquery-1.7.1.min.js',JURI::root().'components/com_jforce/js/charts/');
            JHTML::script('highcharts.js',JURI::root().'components/com_jforce/js/charts/');

            $results_obj = $model->get_reg_survey_results();

            // get body score calculated results
            $this->assignRef('bs_percents', $model->getBodyScoreResults($user->id));

            // get body score categories & percent values for chart
            $chartdata = $model->getBodyScoreChartData($this->bs_percents);

            $this->assignRef("bs_cats", json_encode($chartdata['cats']));
            $this->assignRef("bs_percent_vals", json_encode($chartdata['vals']));
            $this->assignRef("bs_opposite_vals", json_encode($chartdata['opp_vals']));
            $this->assignRef("all_survey_results",$results_obj);
            $this->assignRef("username", $user->name);

        elseif($layout == "recommend_products"):
            $action = "index.php?option=com_jforce&view=phase&layout=recommend_products&pid=".JRequest::getCmd('pid')."&client_id=".JRequest::getCmd('client_id')."&task=save_recommendation"; 
            $this->_display_recommended_products($tpl);
        elseif($layout == "client_phase_progress"):
            $this->_display_client_phase_progress($tpl);
            
        elseif($layout == "newcoach"):            
            $model = & $this->getModel();
            $all_users = $model->get_all_clients();            
            $this->assign("coach_selectable_users",$all_users);

        elseif($layout == "assigncoach"):            
            $model = & $this->getModel();
            $all_users = $model->get_all_clients();
            $all_coaches = $model->get_all_coaches();

            $this->assign("clients",$all_users);
            $this->assign("coaches",$all_coaches);
            
        elseif($layout == "admin_email"):
            $model = & $this->getModel();
            $admin_email = $model->admin_email();
            $this->assign("current_admin_email", $admin_email);
        endif;
        
		
		//$lists = $model->buildLists();
		
		
		$this->assign('action', JRoute::_($action));
		$this->assignRef('lists',$lists);
				
      parent::display($tpl);		
	}	

    function _displayRegistrationSurvey()
    {
        $document =& JFactory::getDocument();
        $model = &$this->getModel();

        $document->addStyleSheet(JURI::root().'components/com_hreport/css/autocompleter.css');
        JHTML::script('autocompleter.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('observer.js',JURI::root().'components/com_hreport/js/', true);

// -------------------------------
        $this->assignRef("looking_for_questions",$model->get_looking_for_questions("",true));
        $this->assignRef("looking_for_answers",$model->get_looking_for_answers());

// -------------------------------
        JHTML::script('reg_survey_1.js',JURI::root().'components/com_jforce/js/phase/', true);
        $this->assignRef("medtrack_questions",$model->get_medtrack_questions("",true));
        $this->assignRef("medtrack_answers",$model->get_medtrack_answers());
        $extraboxes = $model->get_four_extra_boxes("medtrack");
        $box_code = $this->_get_extra_boxes_code($extraboxes, "medtrack");
        $this->assignRef("extraboxes_code",$box_code);

// -------------------------------
        JHTML::script('reg_survey_2.js',JURI::root().'components/com_jforce/js/phase/', true);
        $this->assignRef("symptoms_questions",$model->get_symptoms_questions("",true));
        $this->assignRef("symptoms_answers",$model->get_symptoms_answers());
        $extraboxes = $model->get_four_extra_boxes("symptoms");
        $box_code = $this->_get_extra_boxes_code($extraboxes, "symptoms");
        $this->assignRef("extraboxes_code",$box_code);
// -------------------------------

        JHTML::script('reg_survey_3.js',JURI::root().'components/com_jforce/js/phase/', true);
        $this->assignRef("diseases_questions",$model->get_diseases_questions("",true));
        /*
        $answers = $model->get_diseases_answers();
        $x = array();
        foreach($answers as $a){
            $x[] = $a->survey_value;
        }
        $x = implode(",",$x);
        $this->assignRef("diseases_answers",$x);
        */
        $extraboxes = $model->get_four_extra_boxes("diseases");
        $box_code = $this->_get_extra_boxes_code($extraboxes, "diseases");
        $this->assignRef("extraboxes_code",$box_code);

// -------------------------------
        //$calendar = JHTML::calendar(date('d-m-Y'), 'submission_date', 'submission_date', '%d-%m-%Y');
        $calendar = JHTML::calendar(date('d-m-Y'), 'submission date', 'submission date', '%d-%m-%Y');

        $this->assignRef('calendar', $calendar);
        $this->assignRef("body_score_questions",$model->get_body_score_questions("",true));
        $this->assignRef("body_score_answers",$model->get_body_score_answers());
    }

    function _displayResults($tpl)
	{
        $model = &$this->getModel();
		
        $results = &$model->getSearchResults();
		
		$keyword = JRequest::getVar('keyword');
                
		$this->assignRef('keyword',$keyword);		
        $this->assignRef('results', $results);

		parent::display($tpl);                
	}
    
    function _display_survey($tpl){
        parent::display($tpl);    
    }
    function _display_photoupload($tpl){
		$model = &$this->getModel();
		$phase_details = $model->get_phase_details();
        
        if($phase_details->startphoto == ""){
            $phase_details->startphoto = "picture_not_found.jpg";
        }
        if($phase_details->endphoto == ""){
            $phase_details->endphoto = "picture_not_found.jpg";
        }
        
        $phase_details->startphoto = "/uploads_jtpl/phase_details/".$phase_details->startphoto;
        $phase_details->endphoto = "/uploads_jtpl/phase_details/".$phase_details->endphoto;        
        
        $this->assignRef("phase_details",$phase_details);
        
		parent::display($tpl);
    }
    function _display_direction($tpl){
        parent::display($tpl);
    }
    function _display_purchase($tpl){
        parent::display($tpl);
    }
    
    
    
    
    function _display_evaluation($tpl){
        $model = &$this->getModel();                         

        $user = JFactory::getUser();
        if($user->person->accessrole == "Coach"){
            //$client_id = JRequest::getCmd("client_id");    
            //$client = $model->get_client_information($client_id);
            //$user_id = $client->uid;
            $user_id = $user->jtpl->current_client->uid;
        }else{
            $user_id = $user->id;
        }
                        
        $phase_id = $this->pid;

        $tracking = $model->getProgressTrackingDetails($user_id, $phase_id);
        
        
        //mdie($tracking);
        $options = array('same', 'eliminated', 'better', 'new');

        $calendar = JHTML::calendar(($tracking->submission ? $tracking->submission : date('d-m-Y')),
            'evaluation[submission]', 'submission_date', '%d-%m-%Y');

        $this->assignRef("calendar", $calendar);

        $this->assignRef("tracking", $tracking);
        //$this->assignRef('tvals', $model->getProgressTrackingDetails());
        $this->assignRef('opts', $options);
        
        parent::display($tpl);
    }
    
    
    
    
    
    
    
    
    function _display_signoff($tpl){
        $model = &$this->getModel();
        
        if($model->count_incomplete_steps()){
            $this->assign("phase_status_message","Phase still incomplete");
            $this->assign("phase_status_color","#800000");
            $this->assign("phase_instructions","Go through the previous steps and check any step which is incomplete.");            
        }else{
            $this->assign("phase_status_message","Phase Complete");
            $this->assign("phase_status_color","#008000");
            if($model->is_phase_signed_off()){                
                $this->assign("phase_instructions","This phase has already signed off by coach. Please proceed with other phases.");
            }else{
                $this->assign("phase_signoff_link","yes");
                $this->assign("pid",JRequest::getCmd("pid"));
                $this->assign("phase_instructions","Your steps are complete. Click the link below to ask your coach to sign off for this phase.");
            }
        }
       
        parent::display($tpl);                
    }
    
    function _display_client_phase_progress($tpl){
        $model = &$this->getModel();
        $person = $model->get_client_information(JRequest::getCmd("client_id"));
        $this->assignRef("person",$person);
        $user = JFactory::getUser();
        $this->assignRef("user",$user);

        $this->assign("pid",JRequest::getCmd("pid"));
        
        $phase_id = JRequest::getCmd("pid");
        $client_id = JRequest::getCmd("client_id");
        $phase_number = $model->get_phase_number($phase_id);
        
        $client = $model->get_client_information($client_id);
        
        
        // track the actions
        $action = JRequest::getCmd("action");        
        $this->assign("actionpage",$action);        

        $yesno = array("Y"=>"yes","N"=>"no");
        $intake_q = array("W"=>"Weight (lbs)","F"=>"Fat (%)","PH"=>"PH Score");                

        switch($action):
            case "registrationsurvey":

                // adding chart
                JHTML::script('jquery-1.7.1.min.js',JURI::root().'components/com_jforce/js/charts/');
                JHTML::script('highcharts.js',JURI::root().'components/com_jforce/js/charts/');

                $survey = new stdClass();

                $results = $model->get_registration_survey_results($client->uid);                
                
                $diseases_results = new stdClass();
                $diseases_arr = array();
                
                foreach($results as $r){
                    $survey->registration->{$r->survey_variable} = $r;                    
                    if(substr($r->survey_variable,0,12) == "reg_disease_"){
                        $disease_type = str_replace("reg_disease_","",$r->survey_variable);
                        
                        $disease_name = $r->survey_value;
                        $diseases_results->{$disease_type} = $disease_name;
                        $diseases_arr[] = $disease_name;
                    }
                }                
                $survey->registration->diseases = $diseases_results;                
                $diseases_csv = implode(",",$diseases_arr);
                
                
                $looking_for_results = $model->get_looking_for_questions($survey->registration->reg_looking_for->survey_value,false);
                
                $survey->registration->reg_looking_for->survey_value = $looking_for_results;                
                
                $medtrack_results = $model->get_medtrack_questions($survey->registration->reg_medtrack->survey_value);
                $survey->registration->reg_medtrack->survey_value = $medtrack_results;
                
                $symptoms_results = $model->get_symptoms_questions($survey->registration->reg_symptoms->survey_value);
                $survey->registration->reg_symptoms->survey_value = $symptoms_results;

                $diseases_results = $model->get_diseases_questions($diseases_csv);
                $survey->registration->reg_diseases->survey_value = $diseases_results;
         
                $body_score_results = $model->get_body_score_questions($survey->registration->reg_bodyscore->survey_value);
                $survey->registration->reg_bodyscore->survey_value = $body_score_results;

                $chartdata = $model->getBodyScoreChartData($model->getBodyScoreResults($client_id));
                $survey->registration->reg_bodyscore->bs_cats = json_encode($chartdata['cats']);
                $survey->registration->reg_bodyscore->bs_percent_vals = json_encode($chartdata['vals']);
                $survey->registration->reg_bodyscore->bs_opposite_vals = json_encode($chartdata['opp_vals']);
                
                $extraboxes = $model->get_four_extra_boxes();
                //mdie($extraboxes);
                foreach($extraboxes as $b){
                    $survey->registration->extraboxes->{$b->page}[] = $b;
                }
                
                $this->assignRef("survey",$survey);
                
                //mdie($survey->registration);
            break;
            case "survey":
                $survey = new stdClass();
                
                $initial_survey = $model->get_phase_initial_survey($client->uid,$phase_id);
                //$evaluation_survey = $model->get_phase_evaluation_survey($client->uid,$phase_id);
                
                foreach($initial_survey as $a){
                    $survey->initial->{$a->survey_variable} = $a->survey_value;                    
                }
                
                $initial_survey = $model->split_csv($survey->initial->initial_survey);
                
                $questions = $model->get_phase_survey_questions($phase_number, "start");
                foreach($questions as $q){
                    $questions[$q->variable] = $q->question;
                }
                $temp = array();                
                foreach($initial_survey as $k=>$v){
                    $temp[$questions[$k]] = $yesno[$v];                    
                }
                
                $survey->initial->initial_survey = $temp;
                
                $temp = array();
                $intake_survey = $model->split_csv($survey->initial->intake_survey);
                foreach($intake_survey as $k=>$v){
                    $temp[$intake_q[$k]] = $v;
                }
                
                $survey->initial->intake_survey = $temp;

                $this->assignRef("survey",$survey);
            break;
            case "evaluation":
                $survey = new stdClass();
                $tracking = new stdClass();
                
                // get the initial intake survey for this phase
                $initial_survey = $model->get_phase_initial_survey($client->uid,$phase_id);
                
                $questions = $model->get_phase_survey_questions($phase_number, "end");
                foreach($questions as $q){
                    $questions[$q->variable] = $q->question;
                }
                
                foreach($initial_survey as $a){
                    $survey->initial->{$a->survey_variable} = $a->survey_value;                    
                }
                
                $temp = array();
                $intake_survey = $model->split_csv($survey->initial->intake_survey);
                foreach($intake_survey as $k=>$v){
                    $temp[$intake_q[$k]] = $v;
                }
                
                $survey->initial->intake_survey = $temp;
                
                // now get the end evaluation

                $evaluation = $model->get_phase_end_evaluation($client->uid,$phase_id);
                
                foreach($evaluation as $e){
                    $survey->evaluation->{$e->survey_variable} = $e->survey_value;               
                }
                
                $end_evaluation = $model->split_csv($survey->evaluation->end_evaluation);
                $intake_evaluation = $model->split_csv($survey->evaluation->intake_evaluation);
                $bodyscore_evaluation = $model->split_csv($survey->evaluation->bodyscore_evaluation);
                
                $body_score_results = $model->get_body_score_questions($survey->evaluation->bodyscore_evaluation);
                $survey->evaluation->bodyscore->survey_value = $body_score_results;
                
                $questions = $model->get_phase_survey_questions($phase_number, "end");
                foreach($questions as $q){
                    $questions[$q->variable] = $q->question;
                }
                $temp = array();
                foreach($end_evaluation as $k=>$v){
                    $temp[$questions[$k]] = $yesno[$v];
                }
                
                $survey->evaluation->end_evaluation = $temp;
                
                $temp = array();
                foreach($intake_evaluation as $k=>$v){
                    $temp[$intake_q[$k]] = $v;
                }
                
                $survey->evaluation->intake_evaluation = $temp;

                $this->assignRef("survey",$survey);
                
                $tracking_results = $model->get_tracking($phase_id, $client->uid);

                $tracking->medtrack = array();
                $tracking->diseases = array();
                $tracking->symptoms = array();
                
                $track = new stdClass();
                /**
                $track->medtrack = array();
                $track->diseases = array();
                $track->symptoms = array();
                
                $track->_medtrack = array();
                $track->_diseases = array();
                $track->_symptoms = array();
                **/
                foreach($tracking_results as $t){
                    $track->_->{$t->tracking_category}[$t->tracking_variable] = $t->tracking_variable;
                    $track->{$t->tracking_category}->{$t->tracking_variable} = $t;                    
                }
                
                $track->_symptoms = implode(",",$track->_->symptoms);
                $track->_diseases = implode(",",$track->_->diseases);
                $track->_medtrack = implode(",",$track->_->medtrack);
                
                $medtrack_results = $model->get_medtrack_questions($track->_medtrack);
                $tracking->medtrack = $medtrack_results;
                
                $symptoms_results = $model->get_symptoms_questions($track->_symptoms);
                $tracking->symptoms = $symptoms_results;

                $diseases_results = $model->get_diseases_questions($track->_diseases);
                $tracking->diseases = $diseases_results;
                
                foreach($tracking->diseases as $d){
                    $tracking->_diseases->{$d->variable} = $d->question;
                }
                foreach($tracking->symptoms as $d){
                    $tracking->_symptoms->{$d->variable} = $d->question;
                }
                foreach($tracking->medtrack as $d){
                    $tracking->_medtrack->{$d->variable} = $d->question;
                }
                
                $extraboxes = $model->get_four_extra_boxes();
                
                foreach($extraboxes as $eb){
                    $tr_cat = "extra_".$eb->page;
                    //mdie($track->_->{$tr_cat});
                    
                    //mdie($eb);
                    $tracking_extra_details->{$tr_cat}[$eb->id] = $eb;
                }
                //mdie($tracking_extra_details);
                
                //$extraboxes_tracking = $model->get_four_extra_boxes_tracking();
                
                //mdie($extraboxes);                
                
//                foreach($extraboxes as $b){
//                    $tracking->extraboxes->{$b->page}[] = $b;
//                }
                
                $this->assignRef("tracking",$tracking);
                $this->assignRef("tracking_details",$track);

//                $this->assignRef("tracking_extra",$tracking_extra_details);                
                $this->assignRef("tracking_extra_details",$tracking_extra_details);
                
            break;
            case "photo":
            
            default:
                $phase_details = $model->get_phase_details();
                
                if($phase_details->startphoto == ""){
                    $phase_details->startphoto = "picture_not_found.jpg";
                }
                if($phase_details->endphoto == ""){
                    $phase_details->endphoto = "picture_not_found.jpg";
                }
                
                $phase_details->startphoto = "/uploads_jtpl/phase_details/".$phase_details->startphoto;
                $phase_details->endphoto = "/uploads_jtpl/phase_details/".$phase_details->endphoto;        
                
                $this->assignRef("phase_details",$phase_details);
        
                //mdie(get_class_methods($model));
            break;
        endswitch;
    }
    function _display_recommended_products($tpl){
        $model = &$this->getModel();
        $this->assignRef("recommended_products",$model->get_recommended_products());
        $this->assignRef("products_list",$model->get_virtuemart_products());
        
        $person = $model->get_client_information(JRequest::getCmd("client_id"));
        $this->assignRef("person",$person);
    }
    
    function _get_extra_boxes_code($boxes_arr, $page){
        //mdie($boxes_arr);
        $count = count($boxes_arr);
        $sort = 4 - $count;
        
        
        $box = "<div style='padding:10px;background-color:#EEE;border:1px solid #AAA;'>";
        foreach($boxes_arr as $b){            
$box.="<input type='text' name='{$page}_extraboxes[0][{$b->id}]' value='".$b->value."' /><br />
<br />
";
        }
        
        for($i=0;$i<$sort;$i++){
            $box.="<input type='text' name='{$page}_extraboxes[1][]'><br /><br />";
        }
        
        $box.="</div>";
        return $box;
    }

}