<?php
/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			reports.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class JforceControllerPhase extends JController {
    
	function display() {
		// Set a default view if none exists
		if ( ! JRequest::getCmd( 'view' ) ) {
		    $default = 'survey'; 
			JRequest::setVar('view', $default );
		}
        
		parent::display();	
	}

        /**
         * Phase photos upload function
         * @author Alexander Barannikov
         */
        function photosupload() {

            if (($_FILES['start']['error']==0) || ($_FILES['end']['error']==0)) {
                foreach ($_FILES as $key=>$file) {
                    $err = '';
                    $phase_id = JRequest::getInt('pid');
                    $ext = $file['type'];
                    if(!in_array($ext,array("image/jpeg","image/pjpeg","image/png","image/gif","image/bmp"))){
                        echo $ext;
                        $err = 'Invalid image file!';
                    }
                    if ($phase_id==0) {
                        $err = 'Invalid phase id!';
                    }
                    if (!in_array($key,array("start","end"))) {
                        $err = 'Invalid photo state!';
                    }
                    if ($err=='') {
                        $model =&$this->getModel("phase");
                        $srcfile = $file["tmp_name"];
                        if($model->upload_phase_photo($srcfile,$file["name"],$phase_id,$key, true)){
                            $err = 'Can`t upload photo!';
                        }
                    }
                    if ($err!='') {
                    }
                    $this->setRedirect(base64_decode(JRequest::getString('ret')));
                }

            }

            echo "<pre>";
            print_r($_FILES);
            echo "</pre>";

        }
	
	/**
	 * Call the Save Function
	 * Model determined by Array value
	 * @return 
	 */
	
	function save() {

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$post = JRequest::get('post');
		$model =& $this->getModel($post['model']);
		$model->save($post);

		$msg = JText::_('Item successfully saved.');
		
		$referer = JRequest::getVar('ret', JURI::base());

		$this->setRedirect($referer, $msg);        
	}
    
    function photoupload(){
        //upload photo and redirect to the original location
        
        $post = JRequest::get("post");
        $file  = JRequest::get("files");
        $iserror = "";
        
        $redirect = JRequest::getUri();        
        
        // check phaseid
        //$phase_id = $post["phase_id"];
        $phase_id = JRequest::getCmd("pid");        
        
        $phasepoint = $post["type"];
        
        if($error = $file["filename"]["error"]){
            switch($error){                
                case UPLOAD_ERR_NO_FILE:                
                    $msg = "No file selected";    
                break;
                case UPLOAD_ERR_INI_SIZE:
                    $msg = "File size more than limit";
                break;
                case  UPLOAD_ERR_CANT_WRITE:
                    $msg = "Write Error, contact administrator";
                break;
                default:
                    $msg = "File upload error";
                break;
            }
            $iserror = "error";
        }else{
            $ext = $file["filename"]["type"];

            if(in_array($ext,array("image/jpeg","image/pjpeg","image/png","image/gif","image/bmp"))){

               if(!$phase_id){
                    $msg = "Please select phase to which image is uploaded and try again";
                    
                    $msg = JText::_($msg);
                    $this->setRedirect($redirect,$msg,"error");
                    return false;
                }

                if(!in_array($phasepoint,array("start","end"))){
                    $msg = "Please select where to put this image (start or end) ?";
                    
                    $msg = JText::_($msg);
                    $this->setRedirect($redirect,$msg,"error");
                    return false;
                }

                // do uploading here
                $msg = "File uploaded successfully";
                $model =&$this->getModel("phase");
                $srcfile = $file["filename"]["tmp_name"];
                if($model->upload_phase_photo($srcfile,$file["filename"]["name"],$phase_id,$phasepoint)){
                    
                }else{
                    $msg = "Probably you have already uploaded your pictures for this phase";
                    $iserror = "error";
                }
            }else{                
                $msg = "Unsupported file type - Please upload JPG,PNG,GIF or BMP files only";
                $iserror = "error";
            }
        }

        $msg = JText::_($msg);
        $this->setRedirect($redirect,$msg,$iserror);
    }
	
	function cancel()
	{
		// If the task was cancel, we go back to the item
		$referer = JRequest::getString('ret', JURI::base());

		$this->setRedirect($referer);
	}	
    
    /**
    * Task when redirection done just after registration process gets completed. 
    * 
    */
    function registration_just_complete(){
        
        // nothing to do i guess
        
        parent::display();
    }

    /*
     *  Just gather all survey saving functions into one piece
     */
    function registration_survey()
    {
        $post = JRequest::get('post');
        $phase_model = JModel::getInstance("phase","JForceModel");

        // 0
        $survey_results = $post["lookingfor"];
        $phase_model->save_survey_result("reg_looking_for",$survey_results);
        $phase_model->update_survey_status("registration_survey_0");

        // 1
        $survey_results = $post["medtrack"];
        $phase_model->save_survey_result("reg_medtrack",$survey_results);
        $phase_model->update_survey_status("registration_survey_1");
        $extraboxes = $post["medtrack_extraboxes"];
        $phase_model->save_extra_boxes($extraboxes,"medtrack");

        // 2
        $survey_results = $post["symptoms"];
        $phase_model->save_survey_result("reg_symptoms",$survey_results);
        $phase_model->update_survey_status("registration_survey_2");
        $extraboxes = $post["symptoms_extraboxes"];
        $phase_model->save_extra_boxes($extraboxes,"symptoms");

        // 3
        $survey_results = $post["diseases"];
        foreach($survey_results as $key=>$sr){
            $phase_model->save_survey_result("reg_disease_$key",$sr);
        }
        $phase_model->update_survey_status("registration_survey_3");
        $extraboxes = $post["diseases_extraboxes"];
        $phase_model->save_extra_boxes($extraboxes,"diseases");

        // 4
        $survey_results = $post["bodyscore"];
        $phase_model->save_survey_result("reg_bodyscore",$survey_results);
        $phase_model->update_survey_status("registration_survey_4");

        // intake
        $phase_model->save_survey_result('reg_intake', $post['intake']);

        // submission date
        $date = $post['submission_date'];
        $phase_model->save_survey_result('reg_submission', $date);

        // photo
        $phase_id = 0;
        $file  = JRequest::get("files");
        if(!empty($file)) {
            $srcfile = $file["filename"]["tmp_name"];
            $phase_model->upload_phase_photo($srcfile,$file["filename"]["name"], $phase_id);
        }

        parent::display();
    }

    /**
    * Task when the first registration survey is submitted
    * 
    */
    function registration_survey_0(){        
        $post = JRequest::get('post');
        $survey_results = $post["lookingfor"];
        $phase_model = JModel::getInstance("phase","JForceModel");
        $phase_model->save_survey_result("reg_looking_for",$survey_results);
        $phase_model->update_survey_status("registration_survey_0");
        parent::display();
    }
    
    /**
    * Task when the second regsitration survey is submitted
    * 
    */
    function registration_survey_1(){        
        $post = JRequest::get('post');
        $survey_results = $post["medtrack"]; 
        

        $phase_model = JModel::getInstance("phase","JForceModel");
        $phase_model->save_survey_result("reg_medtrack",$survey_results);         
        $phase_model->update_survey_status("registration_survey_1");

        $extraboxes = $post["medtrack_extraboxes"];
        $phase_model->save_extra_boxes($extraboxes,"medtrack");
        
        parent::display();
    }
    
    function registration_survey_2(){
        $post = JRequest::get('post');
        $survey_results = $post["symptoms"];
        $phase_model = JModel::getInstance("phase","JForceModel");
        $phase_model->save_survey_result("reg_symptoms",$survey_results);
        $phase_model->update_survey_status("registration_survey_2");
        
        $extraboxes = $post["symptoms_extraboxes"];
        $phase_model->save_extra_boxes($extraboxes,"symptoms");
        
        parent::display();
    }
    
    function registration_survey_3(){
        $post = JRequest::get('post');
        $survey_results = $post["diseases"];
        $phase_model = JModel::getInstance("phase","JForceModel");        
        
        foreach($survey_results as $key=>$sr){
            $phase_model->save_survey_result("reg_disease_$key",$sr);   
        }

        $phase_model->update_survey_status("registration_survey_3");
        
        $extraboxes = $post["diseases_extraboxes"];
        $phase_model->save_extra_boxes($extraboxes,"diseases");
        
        
        parent::display();
    }
    
    function registration_survey_4(){

        $post = JRequest::get('post');
        $survey_results = $post["bodyscore"];
        $phase_model = JModel::getInstance("phase","JForceModel");
        $phase_model->save_survey_result("reg_bodyscore",$survey_results);
        $phase_model->update_survey_status("registration_survey_4");
        parent::display();
        
    }
    
    function mark_step_completed(){        
        JRequest::checkToken() or die( 'Invalid Token' );        
        $post = JRequest::get("post");
        
        $get_phase_id = JRequest::getCmd("phase_id");
        $post_phase_id = $post["phase_id"];
        if($get_phase_id != $post_phase_id){
            die("Invalid Token");
        }        
        $phase_model = JModel::getInstance("phase","JForceModel");        
			
        $phase_model->mark_phase_step_completed($post);        
        return true;
    }

    function save_progress_tracking(){
        JRequest::checkToken() or die( 'Invalid Token' );
        $post = JRequest::get("post");

        global $mainframe;

        $phase_model = JModel::getInstance("phase","JForceModel");

        $result = $phase_model->save_progress_tracking($post);
        $uri = JURI::root()."index.php?option=com_jforce&view=phase&layout=evaluation&pid=".$result['cur_phase'];
        $mainframe->redirect($uri,$result['message'], $result['msgtype']);
        return true;
    }
    
    /**
    * Signoff the phase, this will send a message to the coach and make an alert to the coach
    * however, it will not make the phase complete. Coach has to sign off and mark complete manually. 
    */
    function signoff(){
        JRequest::checkToken() or die( 'Invalid Token' );        
        $post = JRequest::get("post");
        $get_phase_id = JRequest::getCmd("phase_id");
        $post_phase_id = $post["phase_id"];
        if($get_phase_id != $post_phase_id){
            die("Invalid Token");
        }        
        $phase_model = JModel::getInstance("phase","JForceModel");        
        $phase_model->proceed_sign_off($post);         
        return true;
    }
    
    function save_recommendation(){
        JRequest::checkToken() or die( 'Invalid Token' );        
        $post = JRequest::get("post");

         global $mainframe;
         $uri = JRequest::getUri();
         $uri = str_replace("task=save_recommendation","",$uri);
        
        if(!$post["product"]){
            $mainframe->redirect($uri,"Select a product to recommend","error");
        }
        $phase_model = JModel::getInstance("phase","JForceModel");
        $phase_model->save_recommendation($post);        
        
        $mainframe->redirect($uri,"Recommendation Saved successfully");
        
        return true;
    }
    function delete_recommendation(){        
        // permission will be checked by the access controller.
        $recommendation_id = JRequest::getCmd("recommendation_id");

        $phase_model = JModel::getInstance("phase","JForceModel");
        $phase_model->delete_recommendation($recommendation_id);        
        
        global $mainframe;
        $uri = JRequest::getUri();
        $uri = str_replace("task=delete_recommendation","",$uri);

        $mainframe->redirect($uri,"Deleted successfully");
        return true;
    }
    
    function make_newcoach(){
        JRequest::checkToken() or die( 'Invalid Token' );
        
        $model = JModel::getInstance("phase","JForceModel");
        $post = JRequest::get("post");
        $model->make_client_a_coach($post["coach"]);
        
        $uri = JRequest::getURI();
        global $mainframe;
        $mainframe->redirect($uri, "Coach Added");
                
        return true;
    }
    function assign_coach_to_client(){
    
        JRequest::checkToken() or die( 'Invalid Token' );
        
        $model = JModel::getInstance("phase","JForceModel");
        $post = JRequest::get("post");

        $model->assign_coach_to_client($post["coach"],$post["client"]);        
        $uri = JRequest::getURI();
        global $mainframe;
        $mainframe->redirect($uri, "Coach Added to the Client");                
        return true;
    }
    
    function admin_email(){
        
        JRequest::checkToken() or die( 'Invalid Token' );
        
        $model = JModel::getInstance("phase","JForceModel");
        $post = JRequest::get("post");
        unset($post["task"]);

        $model->admin_email($post);
        global $mainframe;
        $uri = JRequest::getURI();
        $mainframe->redirect($uri, "Admin Email Updated");
        return true;
    }
    
}