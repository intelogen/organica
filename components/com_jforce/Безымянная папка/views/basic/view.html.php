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

class JforceViewProject extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if ($layout == 'project') {
			$this->_displayProject($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}

        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		
		$projects = $model->listProjects();
		
		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$projects):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;
		
		
		$statusOptions = $model->getStatusOptions();
		
		$this->assignRef('startupText',$startupText);
			
		$this->assignRef('projects', $projects);
		$this->assignRef('statusOptions',$statusOptions);
		$this->assignRef('pagination',	$pagination);
		
        
        parent::display($tpl);		
	}	
	
	function _displayProject($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		#$model->autoAddPeople();
        $project = &$model->getProject();
		
		$milestones = &$model->loadMilestones();

		$latestActivity = $model->latestActivity();
		
		$trashLink = JForceHelper::getTrashLink($project->id, 'project', $project->id);

		$this->assignRef('trashLink',$trashLink);
		$this->assignRef('milestones',$milestones);
        $this->assignRef('project', $project);
		$this->assignRef('latestActivity',$latestActivity);		
        $this->assignRef('option', $option);

		parent::display($tpl);		
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
			
		// Load the JEditor object
		//$editor =& JFactory::getEditor();
		// Initialize variables
		
        $model = &$this->getModel();
		
        $project = &$model->getProject();
		
		// Build Select Lists
		$lists = &$model->buildLists();
		
		// Build the page title string
		$title = $project->id ? JText::_('Edit '.$project->name) : JText::_('New Project');			

		// Add the Calendar includes to the document <head> section
		JHTML::_('behavior.calendar');				
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem(JText::_('List Projects'), 'index.php?option=com_jforce&view=project');			
		$pathway->addItem('Edit '.$project->name, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('project',	$project);
		$this->assignRef('user',	$user);
		$this->assignRef('lists',	$lists);
		
		parent::display($tpl);			
	}		
}