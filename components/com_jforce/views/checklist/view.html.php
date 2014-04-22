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

class JforceViewChecklist extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();
        $user = &JFactory::getUser();

		if ($layout == 'checklist') {
			$this->_displayChecklist($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}
		
		if($layout == 'taskform') {
			$this->_displayTaskForm($tpl);
			return;
		}


        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		
		$checklists = $model->listChecklists();

		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$checklists):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;
		
		$pid = JRequest::getVar('pid', '');
		
		$link = "index.php?option=com_jforce&view=checklist&layout=form&pid=".$pid;
		$newChecklistLink = "<a href='".JRoute::_($link)."' class='button'>".JText::_('New Checklist')."</a>";
		
		$status = JRequest::getVar('status');
		
		$this->assignRef('pid',$pid);
		$this->assignRef('status',$status);
		$this->assignRef('startupText',$startupText);
		$this->assignRef('checklists', $checklists);
		$this->assignRef('newChecklistLink', $newChecklistLink);
		$this->assignRef('pagination', $pagination);
        //$this->assignRef('person', $user);

        if($user->person->accessrole == 'Client') {
            $client_id = $user->id;

        } else {
            $client_id = JRequest::getInt('client_id');
        }
        $this->assignRef('client_id', $client_id);

        parent::display($tpl);		
	}	
	
	function _displayChecklist($tpl) {
        global $mainframe, $option;

		$uri		=& JFactory::getURI();	
		$document =& JFactory::getDocument();	
		$user = &JFactory::getUser();
		JHTML::_('behavior.modal');
		
        $model = &$this->getModel();
		$pid = JRequest::getVar('pid');
		
        $checklist = &$model->getChecklist();
		
		$taskModel = &JModel::getInstance('Task', 'JForceModel');
		JForceHelper::initValidation($taskModel->_required);
		$tasks = &$model->loadTasks();
		
		$checklist->completed = $checklist->completed == 1 ? JText::_('Yes') : JText::_('No');

		#$tasks = &$model->loadTasks();
		
		$link = "index.php?option=com_jforce&view=checklist&layout=form&pid=".$pid;
		$newChecklistLink = "<a href='".JRoute::_($link)."' class='button'>".JText::_('New Checklist')."</a>";
		
		$link = "index.php?option=com_jforce&view=checklist&layout=form&pid=".$pid."&id=".$checklist->id;
		$editChecklistLink = "<a href='".JRoute::_($link)."' class='button'>".
                                "<img src='uploads_jtpl/icons/edit.png' align=top> "
                                .JText::_('Edit Step')."</a>";
						
		$js = "window.addEvent('domready', function(){
				$('newTaskArea').setStyle('height','auto');
				var taskSlider = new Fx.Slide('newTaskArea').hide();  //starts the panel in closed state
			 
				//Show-Hide login panel when you click the link 'login' on top of the page
				$('addTask').addEvent('click', function(e){
					e = new Event(e);
					taskSlider.toggle(); //show-hide login panel
					e.stop();
				});
			 
				//Hide login panel when you click the button close on the upper-right corner of the login panel
				$('cancelTask').addEvent('click', function(e){
					e = new Event(e);
					taskSlider.slideOut();
					e.stop();
				});
				
				$$('input.taskbox').addEvent('click', function(e) {
					toggleTask(this.value);											 
				});
				
				$('ajaxAddTask').addEvent('submit', function(e) {
					
					new Event(e).stop();
					if (validateForm()) {
						this.send({
							onComplete: function(response) {
								createTask(response);
								taskSlider.slideOut();
							}
						});
					}
				});
				
				$('subscribeLink').addEvent('click',function(e) {
					e = new Event(e);
					subscribeMe('".$checklist->id."','checklist', '".$checklist->pid."');
					e.stop();										
				});
		
				$('remindLink').addEvent('click',function(e) {
						e = new Event(e);
						remindPeople('".$checklist->id."','checklist');
						e.stop();										
					});
		
				$$('a.taskSubscribeLinks').addEvent('click',function(e) {
					e = new Event(e);
					subscribeMeTask(this.id,'task', '".$checklist->pid."');
					e.stop();										
				});
				
			});";
					
		$document->addScriptDeclaration($js);
		
		$taskModel =& JModel::getInstance('Task','JForceModel');
		$task = &$taskModel->getTask();
		$lists = $taskModel->buildLists();

		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('task');
		
		$subscriptionModel->setType('assignment');
		$assignmentFields = $subscriptionModel->buildSubscriptionFields();
		$assignmentLink = 'index.php?tmpl=component&option=com_jforce&view=modal&action=task&type=assignment&pid='.$checklist->pid;

		$tabMenu = JForceTabHelper::getTabMenu($checklist);

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');		
	
		$this->assignRef('tabMenu',$tabMenu);
		$this->assign('action', 	$uri->toString());
        $this->assignRef('checklist', $checklist);
		$this->assignRef('lists',$lists);
		$this->assignRef('assignmentFields',$assignmentFields);
		$this->assignRef('assignmentLink',$assignmentLink);
		$this->assignRef('tasks',$tasks);
        $this->assignRef('option', $option);
		$this->assignRef('newChecklistLink', $newChecklistLink);
		$this->assignRef('editChecklistLink', $editChecklistLink);
		$this->assignRef('newTaskLink', $newTaskLink);
        
        
        // after everything done, check for permission if the particular owner has permission to the checklist or not
        
        // Since checklist can be viewed by the owner and his/her own coach this point will be reached only if access allows. 
        // so just check if the user is coach or client
        
        $user = JFactory::getUser();        
        if($user->systemrole->name == "Coach"){
            $this->assign("show_edit_link","1");            
            $this->assign("show_view_progress_link","1");
            
            //mdie($user);
            $tag = strip_tags($checklist->tags);
            if($tag == "survey" || $tag == "evaluation"){
					$this->assign("viewProgressLink",
            			"<a href='".JRoute::_("index.php?option=com_jforce&view=phase&layout=client_phase_progress&pid={$checklist->pid}&action={$tag}&client_id={$user->jtpl->current_client->id}")."'>View Client's Response here</a>");	            
            }
            
        }
        
        // JTPL HACK
        
        // check the tag name and if it is purchase tag than check for product recommendations for the phase
        $tagname = strip_tags($checklist->tags);
        if($tagname == 'purchase'):
            $phase_model = JModel::getInstance("Phase","JForceModel");
            $products = $phase_model->get_recommended_products();
            $this->assign("product_recommendations",$products);
        endif;
        
		parent::display($tpl);
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
		$milestone	=& JRequest::getVar('milestone', '');
		$privateAccess = $user->systemrole->can_see_private_objects;
		
		// Load the JEditor object
		$editor =& JFactory::getEditor();

		// Initialize variables
        $model = &$this->getModel();
		JForceHelper::initValidation($model->_required);
		$model->setMid($milestone);
        $checklist = &$model->getChecklist();
		$lists = $model->buildLists();
		
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('checklist');
		$subscriptionFields = $subscriptionModel->buildSubscriptionFields();
		
		$subscriptionLink = 'index.php?tmpl=component&option=com_jforce&view=modal&action=checklist&pid='.$checklist->pid;
		if ($checklist->id) $subscriptionLink .= '&id='.$checklist->id;
		
		// Build the page title string
		$title = $checklist->id ? JText::_('Edit Checklist') : JText::_('New Checklist');			

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');	
		JHTML::_('behavior.modal', 'a.modal');
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('checklist',	$checklist);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);	
		$this->assignRef('lists',	$lists);
		$this->assignRef('subscriptionLink',	$subscriptionLink);
		$this->assignRef('subscriptionFields',	$subscriptionFields);
		$this->assignRef('privateAccess', $privateAccess);
        
		parent::display($tpl);			
	}
	
	function _displayTaskForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
			
		// Load the JEditor object
		$editor =& JFactory::getEditor();

		// Initialize variables
        $model = &$this->getModel();
		
        $checklist = &$model->getChecklist();
		$lists = $model->buildLists();
		
		
		// Build the page title string
		$title = $checklist->id ? JText::_('Edit Checklist') : JText::_('New Checklist');			

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');		
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('checklist',	$checklist);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);	
		$this->assignRef('lists',	$lists);	
		
		parent::display($tpl);			
	}
	
}