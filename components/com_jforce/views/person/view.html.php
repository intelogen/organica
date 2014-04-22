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

class JforceViewPerson extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

        if ($layout == 'person') {
            $this->_displayPerson($tpl);
            return;    
        }
        
        if ($layout == 'client') {
            $this->_displayClient($tpl);
            return;    
        }
        
		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}
		
		if($layout == 'leadform') {
			$this->_displayLeadForm($tpl);
			return;
		}
		
		$pid = JRequest::getVar('pid');
		if($pid):
			JHTML::_('behavior.modal', 'a.modal');
			$link = 'index.php?option=com_jforce&c=people&tmpl=component&view=modal&layout=addpeople&pid='.$pid;
			$newLink = '<a href="'.JRoute::_($link).'" class="modal button" rel="{handler: \'iframe\', size: {x: 650, y: 600}}">'.JText::_('Add People').'</a>';
			$showLinks = true;
		else :
			$link = 'index.php?option=com_jforce&c=people&view=person&layout=leadform';
			$newLink = '<a href="'.JRoute::_($link).'" class="button">'.JText::_('New Lead').'</a>';
			$showLinks = false;
		endif;

        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		$persons = $model->listPersons();
		
		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$persons):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;
		
		$this->assignRef('startupText',$startupText);
		$this->assignRef('persons', $persons);
		$this->assignRef('newLink',$newLink);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('pid',$pid);
		$this->assignRef('showLinks',$showLinks);
        
        parent::display($tpl);		
	}	
	
	function _displayPerson($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		
        $person = &$model->getPerson();
		
		JHTML::_('behavior.modal');
        
		$pathway =& $mainframe->getPathway();
		$pathway->addItem(JText::_('List Persons'), 'index.php?option=com_jforce&c=people&view=person');	
		$pathway->addItem(JText::_('Person'));	
		
		$tabMenu = JForceTabHelper::getTabMenu($person, false, false);

		$this->assignRef('tabMenu',$tabMenu);
		$this->assignRef('trashLink',$trashLink);
        $this->assignRef('person', $person);
        $this->assignRef('option', $option);   
        
        // 

		parent::display($tpl);		
	}
    
    function _displayClient($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();        
        
        $person = &$model->getPerson();
        
        JHTML::_('behavior.modal');
        
        $pathway =& $mainframe->getPathway();
        $pathway->addItem(JText::_('List Persons'), 'index.php?option=com_jforce&c=people&view=person');    
        $pathway->addItem(JText::_('Person'));    
        
        $tabMenu = JForceTabHelper::getTabMenu($person, false, false);

        $this->assignRef('tabMenu',$tabMenu);
        $this->assignRef('trashLink',$trashLink);
        $this->assignRef('person', $person);        
        $this->assign("client_id",$person->id);
        $this->assignRef('option', $option);   
        
        // now start tracking client according to action
        $action = JRequest::getCmd("action","progress"); // read action and default to progress page
        $this->assign("action",$action);
        
        switch($action){            
            case "message":
                // pick the client phases and populate links to those phases
                $phase_model = JModel::getInstance("Phase","JForceModel");
                $messages = $phase_model->get_coach_client_messages($person->uid);            
                $this->assignRef("messages",$messages);
            break;
         
            case "progress":
            default:
                // pick the client phases and populate links to those phases
                $phase_model = JModel::getInstance("Phase","JForceModel");
                $progress_tracking = $phase_model->get_progress_tracking($person->uid);
                $this->assignRef("progress_tracking",$progress_tracking);
            break;
        }
                

        parent::display($tpl);        
    }
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
		// Load the JEditor object
		$editor =& JFactory::getEditor();
		jimport('joomla.html.pane');
		$tabs = JPane::getInstance('tabs');

		$js = "window.addEvent('domready', function() {
			initProjectRoles();	
			toggleCustomProjectRoles();

			if ($('removeLink')) {
				$('removeLink').addEvent('click', function() {
					removeIcon('person');										   
				});
			}
			
			if ($('uidList')) {
				$('uidList').addEvent('change', function() {
					toggleJUserBlock();										 
				});
			}
			
		});";
		$document->addScriptDeclaration($js);

		// Initialize variables
        $model = &$this->getModel();
		JForceHelper::initValidation($model->_required);
		
        $person = &$model->getPerson();
		$company = JRequest::getVar('company', '0');
		$person->company = $person->id ? $person->company : $company;
		
		$customFieldModel = JModel::getInstance('Customfield', 'JforceModel');
	
		$customFields = $customFieldModel->loadCustomFields(0, $person->id);
		
		$lists = $model->buildLists();
		
		$accessRoleModel = &JModel::getInstance('Accessrole', 'JForceModel');
		$accessRoleModel->loadUserAccessRole($person->uid);
		$projectroleoptions = $accessRoleModel->buildProjectRoleOptions();
		$systemroleoptions = $accessRoleModel->buildSystemRoleOptions();
		
		// Create Modal Link for Profile Picture
		$person->uploadProfileUrl = JRoute::_('index.php?option=com_jforce&c=people&view=modal&layout=profilepic&id='.$person->id.'&tmpl=component&model=person');
		
		// Build the page title string
		$title = $person->id ? JText::_('Edit Person') : JText::_('New Person');			
				
		JHTML::_('behavior.modal', 'a.modal');
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('person',	$person);
		$this->assignRef('editor',	$editor);
		$this->assignRef('customFields',	$customFields);	
		$this->assignRef('lists',	$lists);
		$this->assignRef('projectroleoptions',	$projectroleoptions);
		$this->assignRef('systemroleoptions',	$systemroleoptions);
		$this->assignRef('tabs',	$tabs);
		
		parent::display($tpl);			
	}		
	function _displayLeadForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$uri		=& JFactory::getURI();	
		// Load the JEditor object
		$editor =& JFactory::getEditor();

		// Initialize variables
        $model = &$this->getModel();
		
        $person = &$model->getPerson();
		
		$customFieldModel = JModel::getInstance('Customfield', 'JforceModel');
	
		$customFields = $customFieldModel->loadCustomFields(0);
		
		$lists = $model->buildLists();
		
		// Build the page title string
		$title = JText::_('New Lead');			
			
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('person',	$person);
		$this->assignRef('editor',	$editor);
		$this->assignRef('customFields',	$customFields);	
		$this->assignRef('lists',	$lists);
		
		parent::display($tpl);			
	}		
		
}