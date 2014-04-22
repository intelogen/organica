<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			access.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
class JForceControllerAccess extends JController {

	function checkAccess() {
		$view 	= JRequest::getVar('view', 'project');
		$layout = JRequest::getVar('layout', 'default');
		$task 	= JRequest::getVar('task', '');
		$c		= JRequest::getVar('c','');
		
		if ($c == '') :
			$c = $this->getController($view);
		endif;

		$user = $this->_loadUser();
		## CHECK PUBLIC ACCESS ##
		if ($this->_isPublic($task,$c,$view,$layout)) :
			return true;
		endif;

		$this->_checkGeneralAccess($user,$c,$task,$view,$layout);
		switch($c) :
			
			case 'accounting':
			$this->_checkAccountingAccess($user,$task,$view,$layout);
			break;
				
			case 'sales':
			$this->_checkSalesAccess($user,$task,$view,$layout);
			break;
			
			case 'people':
			$this->_checkPeopleAccess($user,$task,$view,$layout);
			break;
			
			case 'ajax':
			$this->_checkAjaxAccess($user,$task,$view,$layout);
			break;
			
			case 'reports':
			$this->_checkReportsAccess($user,$task,$view,$layout);
			break;
			
			case 'message':
			$this->_checkMessageAccess($user,$task,$view,$layout);
			break;
			
			case 'project':
            // hack the project access roles
            // this is required to allow an user who is the coach of particular user to access client's projects
			$this->_checkProjectAccess($user,$task,$view,$layout);
			break;
			
			case 'search':
			$this->_checkSearchAccess($user,$task,$view,$layout);
			break;
            
            case "phase":
            // JTPL HACK
            // right now it uses project access
            // so it might require to create another function for phase access
            // however, since much of the things are similar to project as phase is just an implementation over project
            // this might not require to. But it would be better to mark this as a TODO
            //$this->_checkProjectAccess($user,$task,$view,$layout);
            $this->_checkPhaseAccess($user, $task, $view, $layout);
            break;
	
			default:
			break;
	
		endswitch;
		
	}

	function _loadUser() {
		$user = &JFactory::getUser();
		$pid = JRequest::getVar('pid', '');
		if (!$user->get('role')) :
			$accessRoleModel = JModel::getInstance('Accessrole', 'JforceModel');
			$role = $accessRoleModel->loadUserAccessRole($user->id);
			$role->quote = $role->global_quote;
			$role->invoice = $role->global_invoice;
			$role->ticket = $role->global_ticket;
			$user->set('systemrole',$role);
		endif;
		
		if(!$user->get('person')) :
			$personModel = &JModel::getInstance('Person', 'JForceModel');
			$personModel->setId(null);
			$personModel->setPid(null);
			$personModel->setUserid($user->id);
			$person = $personModel->getPerson();
			$user->set('person',$person);
		endif;
		
		if($pid) :
			$projectaccess = $user->get('projectaccess') ? $user->get('projectaccess') : array();
			if (!isset($projectaccess[$pid])) :
				$personModel = &JModel::getInstance('Person', 'JForceModel');
				$personModel->setUserid($user->id);
				$permissions = $personModel->loadProjectPermissions($pid);
				$projectaccess[$pid] = $permissions;
				$user->set('projectaccess',$projectaccess);
			endif;
		endif;
		
		return $user;
	}

	function _checkPeopleAccess($user,$task,$view,$layout) {
        global $mainframe;
        $_id = JRequest::getCmd("id");
        
        if($layout == "person" || $layout == "client"){
            $table = JTable::getInstance("Person");
            if(!$table->load($_id)){
                $mainframe->redirect(JRoute::_("?option=com_jforce&view=dashboard"),"Person Not Found","error");
                return false;
            }
            
            if($layout == "client"){
                // check current coach and permission
                if($user->systemrole->name == "Coach"){
                    if($user->person->companyid == $table->company){
                        // allow access to this coach only
                        return true;
                    }else{
                        // deny access to all other coaches
                        $companyid = $user->person->companyid;
                        $mainframe->redirect(JRoute::_("?option=com_jforce&c=people&view=company&layout=company&id=".$companyid),"Insufficient Permissions","error");
                        return false;
                    }
                }
            }
        }
        
        //view=person&layout=client&id=83&action=progress
        if($layout == "form"){
            if($user->systemrole->name != "Administrator" || $user->systemrole->name != "Coach"){
                $company_table = JTable::getInstance("Company");
                $c_id = JRequest::getCmd("id");
                if($view  == "company"){
                    $x = $company_table->load($c_id);                    
                    if($x){
                        //if($company_table)
                        //mdie($company_table);
                        if($company_table->owner == $user->id){
                            return true;
                        }else{
                            JForceHelper::lockOut();
                        }
                    }else {
                        JForceHelper::lockOut();
                    }
                }
            }else{
                JForceHelper::lockOut();
            }
        }
        if($view =="person" && $layout == "clients"){
            $cl_id = JRequest::getCmd("id");
            $company_table = JTable::getInstance("Company");
            
        }
        //die();
		$systemrole = $user->get('systemrole');

		$possibleViews = array('person');
		$specials = array('company', 'modal');
		$level = $this->determineAccessLevel($task,$layout);
		$continue = false;

		## VERY TEMPORARY WORK AROUND ## IF YOU HAVE ANY SUGGESTIONS, PLEASE LET US KNOW
		if($task) :
			$continue = true;
		endif;
		
		if ($systemrole && in_array($view, $possibleViews)) :
			if ($level <= $systemrole->$view) :
				$continue = true;
			endif;
		elseif(in_array($view,$specials)) :
			$continue = true;
		endif;

		if (!$continue) :
			JForceHelper::lockOut();
		endif;
		
	}
	
	function _checkSalesAccess($user,$task,$view,$layout) {
            JForceHelper::lockOut();
		
			$systemrole = $user->get('systemrole');
			
			$possibleViews = array('lead', 'potential', 'campaign');
			$specials = array('modal');
			$level = $this->determineAccessLevel($task,$layout);
			$continue = false;
	
			## VERY TEMPORARY WORK AROUND ## IF YOU HAVE ANY SUGGESTIONS, PLEASE LET US KNOW
			if($task) :
				$continue = true;
			endif;
	
			if ($systemrole && in_array($view, $possibleViews)) :
				if ($level <= $systemrole->$view) :
					$continue = true;
				endif;
			elseif(in_array($view,$specials)) :
				$continue = true;
			endif;
	
			if (!$continue) :
				JForceHelper::lockOut();
			endif;
		}

	function _checkAccountingAccess($user,$task,$view,$layout) {
        JForceHelper::lockOut();
		$systemrole = $user->get('systemrole');
		
		$possibleViews = array('invoice', 'quote');
		$specials = array('modal');
		$level = $this->determineAccessLevel($task,$layout);
		$continue = false;

		## VERY TEMPORARY WORK AROUND ## IF YOU HAVE ANY SUGGESTIONS, PLEASE LET US KNOW
		if($task) :
			$continue = true;
		endif;

		if ($systemrole && in_array($view, $possibleViews)) :
			if ($level <= $systemrole->$view) :
				$continue = true;
			endif;
		elseif(in_array($view,$specials)) :
			$continue = true;
		endif;

		if (!$continue) :
			JForceHelper::lockOut();
		endif;
		
	}
	
	function _checkSupportAccess($user,$task,$view,$layout) {
        JForceHelper::lockOut();
		$systemrole = $user->get('systemrole');
		
		$possibleViews = array('ticket');
		$specials = array('modal');
		$level = $this->determineAccessLevel($task,$layout);
		$continue = false;

		## VERY TEMPORARY WORK AROUND ## IF YOU HAVE ANY SUGGESTIONS, PLEASE LET US KNOW
		if($task) :
			$continue = true;
		endif;

		if ($systemrole && in_array($view, $possibleViews)) :
			if ($level <= $systemrole->$view) :
				$continue = true;
			endif;
		elseif(in_array($view,$specials)) :
			$continue = true;
		endif;

		if (!$continue) :
			JForceHelper::lockOut();
		endif;
		
	}
	
	function _checkAjaxAccess($user,$task,$view,$layout) {
		
		
	}
	
	function _checkReportsAccess($user,$task,$view,$layout) {
		$systemrole = $user->get('systemrole');
		if (!$systemrole->can_view_reports) :
			JForceHelper::notAuth();
			return false;
		endif;
		
	}
	
	function _checkMessageAccess($user,$task,$view,$layout) {
		$systemrole = $user->get('systemrole');
		if (!$systemrole->can_access_messages) :
			JForceHelper::notAuth();
			return false;
		endif;
	}

	function _checkSearchAccess($user,$task,$view,$layout) {
		return true;	
	}
	
	function _checkPhaseAccess($user, $task, $view, $layout){



        //http://maximhealthsystem.com/index.php?option=com_jforce&view=phase&layout=client_phase_progress&pid=262&client_id=127
        
        $pid = JRequest::getCmd("pid"); // this is the project id
        $client_id = JRequest::getCmd("client_id"); // this is the personid
        $phase_id = JRequest::getCmd("phase_id"); // this is the checklist id
        $layout = $layout ? $layout : JRequest::getVar('layout');
        $task = $task ? $task : JRequest::getVar('task');
        global $mainframe;

        // check access for Progress Tracking page
        if($task == 'save_progress_tracking' || $layout == 'evaluation') {
            return true;
        }

        if (JRequest::getCmd("task")=='photosupload') {
            return true;
        }
        
        if(in_array($layout, array("admin_email","newcoach","assigncoach"))){
            if ($user->systemrole->name == "Administrator"){
                return true;
            }else{
                global $mainframe;
                $mainframe->redirect(JRoute::_("?option=com_jforce&view=dashboard"),"Insufficient Permissions","error");
                return false;
            }
        }        
        
        $project= JTable::getInstance("Project");
        $client= JTable::getInstance("Person");
        $phase_checklist = JTable::getInstance("Checklist");
        
        if(in_array($layout, array("registration_survey_0","registration_survey_1","registration_survey_2","registration_survey_3","registration_survey_4","registration_survey_5"))){
            return true;
        }

        if(!$project->load($pid)){
            $mainframe->redirect(JRoute::_("?option=com_jforce&view=dashboard"),"Invalid Phase","error"); 
        }
        
        if($user->systemrole->name == "Client"){
            if($project->author != $user->id)
                $mainframe->redirect(JRoute::_("?option=com_jforce&view=dashboard"),"Insufficient Permissions","error"); 
        }

        if($layout != "client_phase_progress" && $layout != "recommend_products") {
            // check project-checklist association

            if(!$phase_checklist->load($phase_id)){
                $mainframe->redirect(JRoute::_("?option=com_jforce&view=dashboard"),"Invalid Phase Step","error");
            }

            if($project->id != $phase_checklist->pid) {
                $mainframe->redirect(JRoute::_("?option=com_jforce&view=dashboard"),"Error in attempt","error");
            }
        }
        
        if($layout == "client_phase_progress") {
            $pid = JRequest::getCmd("pid");
            $client_id = JRequest::getCmd("client_id");
            
            // allow to client
            if($project->author == $user->id && $client_id == $user->id)
                return true;
                
            // allow to coach
            if($user->systemrole->name == "Coach"){
                if($user->jtpl->current_project->company == $user->person->companyid)
                    return true;
                else
                    return false;
            }
            
            if($user->systemrole->name =="Administrator")
                return true;
                            
            $mainframe->redirect(JRoute::_("?option=com_jforce&view=dashboard"),"Insufficient Permissions","error");
        } else if($layout == "recommend_products") {
            if(!$client_id || !$pid)
                $mainframe->redirect(JRoute::_("?option=com_jforce&view=dashboard"),"Insufficient Permissions","error"); 
            else{
                // check project first, if it is really associated to the particular client or not
                $project= JTable::getInstance("Project");
                if(!$project->load($pid)){
                    $mainframe->redirect(JRoute::_("?option=com_jforce&view=dashboard"),"Invalid Attempt","error"); 
                }

                $client= JTable::getInstance("Person");
                if(!$client->load($client_id)){
                    $mainframe->redirect(JRoute::_("?option=com_jforce&view=dashboard"),"Invalid Attempt","error"); 
                }
                
                if($project->author != $client->uid){
                    $mainframe->redirect(JRoute::_("?option=com_jforce&view=dashboard"),"Invalid Attempt","error"); 
                }

                if($user->systemrole->name == "Administrator")
                    return true;
                elseif($user->systemrole->name == "Coach"){
                    $phase_model = JModel::getInstance("Phase","JForceModel");
                    if($phase_model->check_phase_access_right_to_coach($user->id)){
                        return true;
                    }else
                        return false;
                }
            }
        } else {
            return true;
        }
        
	}

	function _checkProjectAccess($user,$task,$view,$layout) {

		global $mainframe;
        
        if($user->systemrole->name == "Coach" && $view == "project" && $layout == "default"){
            JError::raiseWarning("403","Sorry, no phase progress for coach.");
            $mainframe->redirect("?option=com_jforce&view=dashboard");            
            die();
        }
           
		$pid = JRequest::getVar('pid', '');
		$systemrole = $user->get('systemrole');
		$projectaccess = $user->get('projectaccess');
		$permissions = array();
		$level = $this->determineAccessLevel($task,$layout);
		
		$continue = false;
        
        // if has no access to any projects        
		if (!$systemrole->project) :
			JForceHelper::lockOut();
			return false;
		endif;
        
		if (isset($projectaccess[$pid])) :
			$permissions = $projectaccess[$pid];
		endif;
		
		## VERY TEMPORARY WORK AROUND ## IF YOU HAVE ANY SUGGESTIONS, PLEASE LET US KNOW
		if($task == 'downloadFile') :
			$view = 'document';
			$layout = 'document';
		endif;
		
		if ($view == 'project') :
			$this->_checkProjectView($systemrole,$permissions,$layout,$level);            
			return;
		endif;
		
		if ($task) :
			$continue = true;
		endif;
		
		## TASK PERMISSIONS HANDLED BY CHECKLIST ##
		$view = $view == 'task' ? 'checklist' : $view;
		$view = $view == 'file' ? 'document' : $view;
			
		$possibleViews = array('milestone', 'checklist', 'timetracker', 'ticket', 'discussion', 'document', 'invoice', 'quote', 'task');
		$specials = array('calendar','modal','dashboard','person');
        
		if (!empty($permissions) && in_array($view, $possibleViews)) :
			if ($level <= $permissions->$view) :
				$continue = true;
			endif;
		elseif(in_array($view,$specials)) :
			$continue = true;
		endif;
        
        
        // JTPL Hack
        // after all permissions have been checked, 
        // let me enforce my own checking
        
        // disable editing checklist by default
        
        if($user->systemrole->name == "Administrator"){
            $continue = true;
        }
        
        if($user->systemrole->name == "Coach" || $user->systemrole->name == "Client"){
            // check ownership of the coach to the particular checklist
                        
            $phase_model = JModel::getInstance("Phase","JForceModel");
            $view = JRequest::getCmd("view");
            if($view  == "checklist" || $layout == "client_phase_progress"){
                if($user->systemrole->name == "Coach"){
                    if($phase_model->check_phase_access_right_to_coach($user->id)){
                        $continue = true;                                          
                    }else{
                        $continue = false;
                        if($user->systemrole->name == "Coach"){
                            $mainframe->redirect($user->person->companyLink,"Insufficient Permissions","error");
                        }
                    }
                }else if($user->systemrole->name == "Client"){
                    // check client's access to the particular phase and checklist
                    
                    $project = JTable::getInstance("Project");
                    if($project->load($pid)){
                        if($user->id == $project->author)
                            return true;
                        else
                            $mainframe->redirect(JRoute::_("?option=com_jforce&c=project&status=Active"),"Insufficient Permissions","error");
                    }else{
                        $mainframe->redirect(JRoute::_("?option=com_jforce&c=project&status=Active"),"Insufficient Permissions","error");
                    }
                }
            }else if($view == "project"){
                // mdie("i am here");
            }
        }
        
        /**
        else if($user->systemrole->name == "Client"){
            // just deny edit access to client
            $view = JRequest::getCmd("view");
            $layout = JRequest::getCmd("layout");            
            if($view == "checklist" && $layout == "form"){
                $continue = false;
            }
        }        
        **/
        
        if (!$continue) :
            //JForceHelper::lockOut();
            $mainframe->redirect(JRoute::_("?option=com_jforce&view=checklist&layout=checklist&pid={$pid}&id=".JRequest::getCmd("id")),"Clients cannot edit their phase steps","error");
            return false;
        endif;
		
	}

	function _checkProjectView($systemrole,$permissions,$layout,$level) {
		$continue = false;

		if($layout == 'default' && $systemrole->project) :
			$continue = true;
		elseif($level <= $systemrole->project) :
			$continue = true;
		endif;
		
        // JTPL HACK
        // check coach/client permission here
        
        global $mainframe;
        if($systemrole->name == "Administrator")
            $mainframe->redirect(JRoute::_("?option=com_jforce&view=dashboard"),"Invalid page access","error");
        
        $user = JFactory::getUser();
        if($user->systemrole->name == "Coach" || $user->systemrole->name == "Administrator"){
            // check ownership of the coach to the particular project
            $project_table = JTable::getInstance("Project");
            $project_id = JRequest::getCmd("pid");
            $view = JRequest::getCmd("view");
            if($view  == "project"){
                $project_table->load($project_id);
                if($user->id == $project_table->leader && $user->systemrole->name == "Coach"){
                    $continue = true;
                }
            }                
        }else if($user->systemrole->name == "Client"){
            $continue = $continue;            
        }
        
		if (!$continue) :
			JForceHelper::lockOut();
			return false;
		endif;
	}

	function _checkGeneralAccess($user,$c,$task,$view,$layout) {
		$systemrole = $user->get('systemrole');
				
		/* REVISIT BECAUSE OF FORM ACTIONS */
		## LOCK OUT TASK OVERRIDE HACK ##
		if ($view != '' && $task != '') :
			#JForceHelper::lockOut();
			#return false;
		endif;
		/**********************************/
		
		## FORCE USER LOGIN ##
		if (!$user->id) :
			JForceHelper::loginRedirect();
			return false;
		endif;
		
		if(!$systemrole->system_access) :
			JForceHelper::lockOut();
			return false;
		endif;
		
		return true;
	}
	
	function _isPublic($task,$c,$view,$layout) {
		$public = false;	
		
		if ($view == 'lead' && $layout == 'new') :
			$public = true;
		endif;
		
		if ($c == 'sales' && $task == 'save') :
			$public = true;
		endif;

		if ($c == 'phase' && $task == 'photosupload') :
			$public = true;
		endif;

		return $public;
		
	}
	
	function determineAccessLevel($task, $layout) {
		$id = JRequest::getVar('id', '');
	
		if ($layout == 'form' && !$id) :
			$level = 3;
		elseif ($layout == 'form' && $id) :
			$level = 4;
		elseif ($task == 'trash') :
			$level = 4;
		else :
			$level = 1;
		endif;
		
		return $level;
	
	}
	
	function getController($view) {
		
		$map = array(
				'lead' 		=> 'sales',
				'potential'	=> 'sales',
				'campaign'	=> 'sales',
				'quote'		=> 'accounting',
				'invoice'	=> 'accounting',
				'ticket'	=> 'support',
				'report'	=> 'reports',
				'person'	=> 'people',
				'company'	=> 'people',
				'message'	=> 'message',
				'search'	=> 'search',
                'phase'     => 'phase'
				);
		
		if (isset($map[$view])) :
			$c = $map[$view];
		else:
			$c = 'project';
		endif;
		
		JRequest::setVar('c',$c, 'get');
		
		return $c;
	}
	
	
}