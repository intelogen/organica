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
        $phase_id = $post["phase_id"];
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
            if(in_array($ext,array("image/jpeg","image/png","image/gif","image/bmp"))){

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
    
    /**
    * Task when the first registration survey is submitted
    * 
    */
    function registration_survey_0(){
        $post = JRequest::get('post');
        $survey_results = $post["lookingfor"];
        $phase_model = JModel::getInstance("phase","JForceModel");
        $phase_model->save_survey_result("survey0_looking_for",$survey_results);
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
        $phase_model->save_survey_result("survey1_medtrack",$survey_results);        
        $phase_model->update_survey_status("registration_survey_1");
        parent::display();
    }
    
    function registration_survey_2(){
        $post = JRequest::get('post');
        $survey_results = $post["symptoms"];
        $phase_model = JModel::getInstance("phase","JForceModel");
        $phase_model->save_survey_result("survey2_symptoms",$survey_results);
        $phase_model->update_survey_status("registration_survey_2");
        parent::display();
    }
    
    function registration_survey_3(){
        $post = JRequest::get('post');
        $survey_results = $post["disease"];
        $phase_model = JModel::getInstance("phase","JForceModel");        
        
        foreach($survey_results as $key=>$sr){
            $phase_model->save_survey_result("survey3_disease_$key",$sr);   
        }

        $phase_model->update_survey_status("registration_survey_3");
        parent::display();
    }
    
    function registration_survey_4(){

        $post = JRequest::get('post');
        $survey_results = $post["bodyscore"];
        $phase_model = JModel::getInstance("phase","JForceModel");
        $phase_model->save_survey_result("survey4_bodyscore",$survey_results);
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
}