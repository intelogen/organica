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
		
		$layout = $this->getLayout();
        $model = &$this->getModel();
		$uri	=& JFactory::getURI();
        
        $pid = JRequest::getCmd("pid");
        $phase_id = JRequest::getCmd("phase_id");
        $phase_number = $model->get_phase_number($pid);
        $this->assign("phase_number",$phase_number);
        $this->assign("step_redirection_link",JRoute::_("index.php?option=com_jforce&view=checklist&pid={$pid}"));            
        $this->assign("step_action_link",JRoute::_("index.php?option=com_jforce&view=phase&pid={$pid}&task=mark_step_completed&phase_id={$phase_id}"));
        
        $this->assign("pid",$pid);
        $this->assign("phase_id",$phase_id);
        
            
            
        
        // survey, photoupload, direction, purchase, evaluation, signoff
		if($layout=='survey'):
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
            $link = "index.php?page=shop.browse&option=com_virtuemart&category_id=";
            $phase_to_category_id = $project_model->get_product_category_for_phase();
            $link .= $phase_to_category_id;
            $this->assign("shopping_cart_link",$link);
            
            $this->_display_purchase($tpl);
            return;
        elseif($layout == "evaluation"):        
            $this->_display_evaluation($tpl);
            return;
        elseif($layout == "signoff"):
            $this->_display_signoff($tpl);
            return;
        elseif($layout == "registration_survey_5"):
            $this->assignRef("all_survey_results",$model->get_all_survey());
		endif;
    
		
		//$lists = $model->buildLists();
		
		$action = JRoute::_('index.php?option=com_jforce&view=phase&layout=results');
		
		$this->assign('action', $action);
		$this->assignRef('lists',$lists);
				
      parent::display($tpl);		
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

}