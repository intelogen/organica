<?php

/********************************************************************************
*	@package		Joomla														*
*	@subpackage		jForce, the Joomla! CRM										*
*	@version		2.0															*
*	@file			project.php													*
*	@updated		2008-12-15													*
*	@copyright		Copyright (C) 2008 - 2009 JoomPlanet. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								*
********************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelProject extends JModel {
	
	var $_id			= null;
	var $_uid			= null;
	var $_project			= null;
	var $_published		= 1;


    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('pid', 0, '', 'int');
		$this->setId((int)$id);
		
		$user = &JFactory::getUser();
		$this->setUid($user->id);
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_project	= null;
	}	

	function setUid($uid) {
		$this->_uid = $uid;
		return true;
	}

	function &getProject()
	{
		global $mainframe;
		// Load the Category data
		if ($this->_loadProject())
		{
			//	$this->_loadProjectParams();
			$this->getProjectDetails($this->_project);
			$mainframe->triggerEvent('onLoadProject', array($this->_project));

		}
		else
		{
			$project =& JTable::getInstance('Project');
			$project->parameters	= new JParameter( '' );
			$project->leaderid = null;
			$project->companyid = null;
			$this->_project			= $project;
		}

		return $this->_project;
	}

	function save($data)
	{
		global $mainframe;	
		$user = &JFactory::getUser();
		$project  =& JTable::getInstance('Project');

		$addNewPeople = false;

		// Bind the form fields to the web link table
		if (!$project->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		// sanitise id field
		$project->id = (int) $project->id;
		
		if (!$project->id) :
			$project->author = $user->get('id');
			$project->created = gmdate("Y-m-d H:i:s");
			$project->published = 1;
			$project->key = JForceHelper::generateKey();
			$addNewPeople = true;
			$isNew = true;
		else :
			$project->modified = gmdate("Y-m-d H:i:s");
			$isNew = false;
		endif;
		$project->description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		// Make sure the table is valid
		if (!$project->check()) {
			$this->setError($project->getError());
			return false;
		}
			
		$mainframe->triggerEvent('onBeforeProjectSave',array($project,$isNew));
	
		// Store the article table to the database
		if (!$project->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_project	=& $project;

		if ($addNewPeople) :
			$this->autoAddPeople($project);
		endif;

		$mainframe->triggerEvent('onAfterProjectSave',array($this->_project,$isNew));
		return $this->_project;
	}
	
	function listProjects() {	
		global $mainframe;
		
		$where = $this->_buildWhere();

			$query = 'SELECT b.*, u.name as leader, c.name as company, b.company as companyid, p.id as leaderid'.
					' FROM #__jf_projects AS b' .
					' LEFT JOIN #__jf_persons AS p on b.leader = p.id '.
					' LEFT JOIN #__users AS u ON p.uid = u.id' .
					' LEFT JOIN #__jf_companies AS c on b.company = c.id' .
					' LEFT JOIN #__jf_projectroles_cf AS cf ON cf.pid = b.id'.
					$where;
		// Get the pagination request variables
		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

        $projects = $this->_getList($query, $limitstart, $limit);
		
		for($i=0;$i<count($projects);$i++):
			$project = $projects[$i];
			$this->getProjectDetails($project);
			$mainframe->triggerEvent('onLoadProject', array($project));			
		endfor;
		
		$this->list =$projects;
        return $this->list;
    }
	
	function getTotal() 
	{
	
		$where = $this->_buildWhere();

		$query = 'SELECT COUNT(*)'.
				' FROM #__jf_projects AS b' .
				' LEFT JOIN #__jf_persons AS p on b.leader = p.id '.
				' LEFT JOIN #__users AS u ON p.uid = u.id' .
				' LEFT JOIN #__jf_companies AS c on b.company = c.id' .
				$where;
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		
		return $total;
	
	}

	function autoAddPeople($project) {
		
		$personModel = JModel::getInstance('Person', 'JForceModel');
		$personModel->setId(null);
		$personModel->setPid(null);
		$personModel->setCompany(null);
		$personModel->setAutoAdd(true);
		
		$people = $personModel->listPersons();
		
		for($i=0; $i<count($people); $i++) :
			$person = $people[$i];
			$accessrole = JTable::getInstance('Accessrole', 'JTable');
			$accessrole->load($person->systemrole);
			$cf = JTable::getInstance('Projectrolecf', 'JTable');
			$cf->bind($accessrole);
			$cf->id = '';
			$cf->uid = $person->uid;
			$cf->pid = $project->id;
			$cf->role = $accessrole->id;
			$cf->store();
		endfor;
		
	}

	function getStatusOptions() {
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$statusOptions = $configModel->getConfig('status',true);
	
		return $statusOptions;
	}
	function _loadProject()
	{

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_project))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT b.*, u.name as leader, c.name as company, b.leader as leaderid, b.company as companyid '.
					' FROM #__jf_projects AS b' .
					' LEFT JOIN #__jf_persons AS p on b.leader = p.id '.
					' LEFT JOIN #__users AS u ON p.uid = u.id' .
					' LEFT JOIN #__jf_companies AS c on b.company = c.id' .	
					' LEFT JOIN #__jf_projectroles_cf AS cf ON cf.pid = b.id'.
					$where;
					
			$this->_db->setQuery($query);
			$this->_project = $this->_db->loadObject();

			if ( ! $this->_project ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function loadMilestones()
	{
		$milestoneModel = JModel::getInstance('Milestone','JForceModel');
		$milestones = $milestoneModel->listMilestones();
		
		return $milestones;
	}
	
	function _buildWhere()
	{	
		$state = JRequest::getVar('status','Active');
		
		$where = ' WHERE b.published = '. (int) $this->_published;
	
		if ($this->_uid) :
			$where .= ' AND cf.uid = '.(int)$this->_uid;
		endif;
	
		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR b.id = ',$this->_id);
				$where .= ' AND (b.id = '. $ids.')';
			else:
				$where .=' AND b.id = '.(int) $this->_id;
			endif;
		else:
			$where .= ' AND b.status = "'.$state.'"';
		endif;
		
		return $where;
	}	
	
	function buildLists() {
		$lists['status'] = JForceListsHelper::getStatusList($this->_project->status);
		$lists['company'] = JForceListsHelper::getClientList($this->_project->companyid);	
		$lists['leader'] = JForceListsHelper::getLeaderList($this->_project->leaderid);
	
		return $lists;
		
	}
	
	function getProjectDetails($project) {
	
		if($project->imagethumb):
			$project->imagethumb = '<img src="'.JURI::base().'jf_projects/project_icons/thumbs/'.$project->imagethumb.'" />';
		else:
			$project->imagethumb = '<img src="'.JURI::root().'components/com_jforce/images/project_icons/default.png" />';
		endif;
		
		$project->completedTasks = $this->getCompletedTasks($project->id);
		$project->totalTasks = $this->getTotalTasks($project->id);
		
		if($project->totalTasks != 0):
			$project->percentComplete = round(($project->completedTasks / $project->totalTasks) * 100,0);
		else:
			$project->percentComplete = 0;
		endif;
		
		$project->progressBar = '<span class="progress" style="width:'.$project->percentComplete.'%;">&nbsp;</span>';
		
		$project->taskStatus = "<div class='progressText'><strong>".$project->completedTasks."</strong> ".
								JText::_('tasks done of')." <strong>".$project->totalTasks."</strong> ".
								JText::_('in the project')." (<strong>".$project->percentComplete."%</strong> ".JText::_('done').")</div>";
	
		$project->leaderUrl = JRoute::_('index.php?option=com_jforce&view=person&layout=person&id='.$project->leaderid);
		$project->companyUrl = JRoute::_('index.php?option=com_jforce&view=company&layout=company&id='.$project->companyid);
	
		return $project;
		
	}
	
	function getCompletedTasks($project) {
		
		$milestoneModel =& JModel::getInstance('Milestone','JForceModel');
		$milestones = $milestoneModel->getCountMilestones($project,true);

		$taskModel =& JModel::getInstance('Task','JForceModel');
		$tasks = $taskModel->getCountTasks($project, true);

		$totalCompleted = $milestones + $tasks;
		
		return $totalCompleted;
	}

	function getTotalTasks($project) {
		
		$milestoneModel =& JModel::getInstance('Milestone','JForceModel');
		$milestones = $milestoneModel->getCountMilestones($project);
		
		$taskModel =& JModel::getInstance('Task','JForceModel');
		$tasks = $taskModel->getCountTasks($project);
		
		$totalTasks = $milestones + $tasks;
		
		return $totalTasks;
	}
	
	function latestActivity($all = true) {
		
		# Milestones
		$milestoneModel =& JModel::getInstance('Milestone','JForceModel');
		$milestones = $milestoneModel->listMilestones(1);
		
		$activity = array();
		if($milestones['active']):
			foreach($milestones['active'] as $m):
				$activity['milestone'][]=$m;
			endforeach;
		endif;
		
		if ($all) :
			$activityType = array(
							'checklist',
							'task',
							'comment',
							'discussion',
							'ticket',
							'document',
							'quote',
							'invoice'
							);
		else :
			$activityType = array(
							'task'
							);
		endif;
		
		foreach($activityType as $act):
			$model = $act.'Model';
			$function = 'list'.ucwords($act).'s';
			
			$model =& JModel::getInstance(ucwords($act),'JForceModel');
			$items = $model->$function();
			
			if($items):
				foreach($items as $i):
					$activity[$act][] = $i;
				endforeach;
			endif;		
		endforeach;

		if($activity && $all):
			$activity = JForceHelper::sortArray($activity,'created', '30');
		else:
			$activity = JForceHelper::sortArray($activity,'duedate');
		endif;
		
		return $activity;

	}
	
	function copyProject() {
		$project = JTable::getInstance('Project');
		$project->load($this->_id);
		$project->id = null;
		$project->name = JText::_('Copy of').' '.$project->name;
		$project->store();
		
		$milestoneModel = &JModel::getInstance('Milestone', 'JforceModel');
		$milestones = $milestoneModel->listMilestones();
		$milestones = array_merge($milestones['late'], $milestones['active'], $milestones['completed']);
		
		for ($i=0; $i<count($milestones); $i++) :
			$id = $milestones[$i]->id;
			$m = JTable::getInstance('Milestone');
			$m->load($id);
			$m->id = null;
			$m->pid = $project->id;
			$m->store();
		endfor;
		
		$checklistModel = &JModel::getInstance('Checklist', 'JforceModel');
		$checklists = $checklistModel->listChecklists();
		
		for ($i=0; $i<count($checklists); $i++) :
			$id = $checklists[$i]->id;
			$c = JTable::getInstance('Checklist');
			$c->load($id);
			$c->id = null;
			$c->pid = $project->id;
			$c->store();
			
			$taskModel = &JModel::getInstance('Task', 'JForceModel');
			$taskModel->setCid($id);
			$taskModel->setPid(null);
			$tasks = $taskModel->listTasks();
			
			for ($k=0; $k<count($tasks); $k++) :
				$tid = $tasks[$k]->id;
				$task = JTable::getInstance('Task');
				$task->load($tid);
				$task->id = null;
				$task->cid = $c->id;
				$task->pid = $project->id;
				$task->store();
			endfor;
			
		endfor;
		
		return $project->id;
		
	}

	function ical() {

		global $mainframe;
		include(JPATH_COMPONENT.DS.'lib'.DS.'calendar'.DS.'ical.class.php');
		
		jimport('joomla.filesystem.file');
		
		$project = $this->getProject();
		$all = false;
		$activity = $this->latestActivity($all);
		
		$site = JURI::base();
		$calendar = new vcalendar();                          // initiate new CALENDAR
		$calendar->setConfig( 'unique_id', $site );             // config with site domain
		$calendar->setProperty( 'X-WR-CALNAME', $project->name );          // set some X-properties, name, content.. .
		$calendar->setProperty('METHOD','PUBLISH');
		$calendar->setProperty( 'X-WR-CALDESC', strip_tags($project->description) );
		
		if ($activity) :
			foreach ($activity as $act) :
				for ($i=0; $i<count($act); $i++) :
					$a = $act[$i];
					$a['text'] = JForceHelper::snippet($a['text'], 300);
	
					#$title = ucwords($a['type']).': '.$a['title'];
					$category = ucwords($a['type']);
					$title = $a['title'];
					$link = null;
					$linkURI = JURI::getInstance($a['link']);
					$queryString = $linkURI->getQuery();
					$link = $site.'index.php?'.$queryString;

					$date = getdate(strtotime($a['duedate']));
					$event = new vevent();
					$event->setProperty( 'categories',$category );
					$event->setProperty( 'dtstart', $date['year'], $date['mon'], $date['mday'], 00, 00, 00 );
					$event->setProperty( 'summary', $title );
					$event->setProperty( 'description', $a['text'] );
					$event->setProperty( 'url', $link ); 
					$calendar->setComponent( $event );
				endfor;
			endforeach;
		endif;
		
		$output = $calendar->createCalendar();

		$filename = JFile::makeSafe($project->name.'.ics');
		
		header('Content-Type: text/Calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		ob_clean();
		flush();

		echo $output;
	}		
	
}
