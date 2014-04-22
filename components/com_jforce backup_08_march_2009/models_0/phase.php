<?php

/********************************************************************************
*	@package		Joomla														*
*	@subpackage		jForce, the Joomla! CRM										*
*	@version		2.0															*
*	@file			phase.php													*
*	@updated		2008-12-15													*
*	@copyright		Copyright (C) 2008 - 2009 JoomPlanet. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								*
********************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelPhase extends JModel {
	
	var $_id			= null;
	var $_uid			= null;
	var $_phase			= null;
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
		$this->_phase	= null;
	}	

	function setUid($uid) {
		$this->_uid = $uid;
		return true;
	}

	function &getPhase()
	{
		global $mainframe;
		// Load the Category data
		if ($this->_loadPhase())
		{
			//	$this->_loadPhaseParams();
			$this->getPhaseDetails($this->_phase);
			$mainframe->triggerEvent('onLoadPhase', array($this->_phase));

		}
		else
		{
			$phase =& JTable::getInstance('Phase');
			$phase->parameters	= new JParameter( '' );
			$phase->leaderid = null;
			$phase->companyid = null;
			$this->_phase			= $phase;
		}

		return $this->_phase;
	}

	function save($data)
	{
		global $mainframe;	
		$user = &JFactory::getUser();
		$phase  =& JTable::getInstance('Phase');

		$addNewPeople = false;

		// Bind the form fields to the web link table
		if (!$phase->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		// sanitise id field
		$phase->id = (int) $phase->id;
		
		if (!$phase->id) :
			$phase->author = $user->get('id');
			$phase->created = gmdate("Y-m-d H:i:s");
			$phase->published = 1;
			$phase->key = JForceHelper::generateKey();
			$addNewPeople = true;
			$isNew = true;
		else :
			$phase->modified = gmdate("Y-m-d H:i:s");
			$isNew = false;
		endif;
		$phase->description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		// Make sure the table is valid
		if (!$phase->check()) {
			$this->setError($phase->getError());
			return false;
		}
			
		$mainframe->triggerEvent('onBeforePhaseSave',array($phase,$isNew));
	
		// Store the article table to the database
		if (!$phase->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_phase	=& $phase;

		if ($addNewPeople) :
			$this->autoAddPeople($phase);
		endif;

		$mainframe->triggerEvent('onAfterPhaseSave',array($this->_phase,$isNew));
		return $this->_phase;
	}
	
	function listPhases() {	
		global $mainframe;
		
		$where = $this->_buildWhere();

			$query = 'SELECT b.*, u.name as leader, c.name as company, b.company as companyid, p.id as leaderid'.
					' FROM #__jf_phases AS b' .
					' LEFT JOIN #__jf_persons AS p on b.leader = p.id '.
					' LEFT JOIN #__users AS u ON p.uid = u.id' .
					' LEFT JOIN #__jf_companies AS c on b.company = c.id' .
					' LEFT JOIN #__jf_phaseroles_cf AS cf ON cf.pid = b.id'.
					$where;
		// Get the pagination request variables
		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

        $phases = $this->_getList($query, $limitstart, $limit);
		
		for($i=0;$i<count($phases);$i++):
			$phase = $phases[$i];
			$this->getPhaseDetails($phase);
			$mainframe->triggerEvent('onLoadPhase', array($phase));			
		endfor;
		
		$this->list =$phases;
        return $this->list;
    }
	
	function getTotal() 
	{
	
		$where = $this->_buildWhere();

		$query = 'SELECT COUNT(*)'.
				' FROM #__jf_phases AS b' .
				' LEFT JOIN #__jf_persons AS p on b.leader = p.id '.
				' LEFT JOIN #__users AS u ON p.uid = u.id' .
				' LEFT JOIN #__jf_companies AS c on b.company = c.id' .
				$where;
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		
		return $total;
	
	}

	function autoAddPeople($phase) {
		
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
			$cf = JTable::getInstance('Phaserolecf', 'JTable');
			$cf->bind($accessrole);
			$cf->id = '';
			$cf->uid = $person->uid;
			$cf->pid = $phase->id;
			$cf->role = $accessrole->id;
			$cf->store();
		endfor;
		
	}

	function getStatusOptions() {
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$statusOptions = $configModel->getConfig('status',true);
	
		return $statusOptions;
	}
	function _loadPhase()
	{

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_phase))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT b.*, u.name as leader, c.name as company, b.leader as leaderid, b.company as companyid '.
					' FROM #__jf_phases AS b' .
					' LEFT JOIN #__jf_persons AS p on b.leader = p.id '.
					' LEFT JOIN #__users AS u ON p.uid = u.id' .
					' LEFT JOIN #__jf_companies AS c on b.company = c.id' .	
					' LEFT JOIN #__jf_phaseroles_cf AS cf ON cf.pid = b.id'.
					$where;
					
			$this->_db->setQuery($query);
			$this->_phase = $this->_db->loadObject();

			if ( ! $this->_phase ) {
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
		$lists['status'] = JForceListsHelper::getStatusList($this->_phase->status);
		$lists['company'] = JForceListsHelper::getClientList($this->_phase->companyid);	
		$lists['leader'] = JForceListsHelper::getLeaderList($this->_phase->leaderid);
	
		return $lists;
		
	}
	
	function getPhaseDetails($phase) {
	
		if($phase->imagethumb):
			$phase->imagethumb = '<img src="'.JURI::base().'jf_phases/phase_icons/thumbs/'.$phase->imagethumb.'" />';
		else:
			$phase->imagethumb = '<img src="'.JURI::root().'components/com_jforce/images/phase_icons/default.png" />';
		endif;
		
		$phase->completedTasks = $this->getCompletedTasks($phase->id);
		$phase->totalTasks = $this->getTotalTasks($phase->id);
		
		if($phase->totalTasks != 0):
			$phase->percentComplete = round(($phase->completedTasks / $phase->totalTasks) * 100,0);
		else:
			$phase->percentComplete = 0;
		endif;
		
		$phase->progressBar = '<span class="progress" style="width:'.$phase->percentComplete.'%;">&nbsp;</span>';
		
		$phase->taskStatus = "<div class='progressText'><strong>".$phase->completedTasks."</strong> ".
								JText::_('tasks done of')." <strong>".$phase->totalTasks."</strong> ".
								JText::_('in the phase')." (<strong>".$phase->percentComplete."%</strong> ".JText::_('done').")</div>";
	
		$phase->leaderUrl = JRoute::_('index.php?option=com_jforce&view=person&layout=person&id='.$phase->leaderid);
		$phase->companyUrl = JRoute::_('index.php?option=com_jforce&view=company&layout=company&id='.$phase->companyid);
	
		return $phase;
		
	}
	
	function getCompletedTasks($phase) {
		
		$milestoneModel =& JModel::getInstance('Milestone','JForceModel');
		$milestones = $milestoneModel->getCountMilestones($phase,true);

		$taskModel =& JModel::getInstance('Task','JForceModel');
		$tasks = $taskModel->getCountTasks($phase, true);

		$totalCompleted = $milestones + $tasks;
		
		return $totalCompleted;
	}

	function getTotalTasks($phase) {
		
		$milestoneModel =& JModel::getInstance('Milestone','JForceModel');
		$milestones = $milestoneModel->getCountMilestones($phase);
		
		$taskModel =& JModel::getInstance('Task','JForceModel');
		$tasks = $taskModel->getCountTasks($phase);
		
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
	
	function copyPhase() {
		$phase = JTable::getInstance('Phase');
		$phase->load($this->_id);
		$phase->id = null;
		$phase->name = JText::_('Copy of').' '.$phase->name;
		$phase->store();
		
		$milestoneModel = &JModel::getInstance('Milestone', 'JforceModel');
		$milestones = $milestoneModel->listMilestones();
		$milestones = array_merge($milestones['late'], $milestones['active'], $milestones['completed']);
		
		for ($i=0; $i<count($milestones); $i++) :
			$id = $milestones[$i]->id;
			$m = JTable::getInstance('Milestone');
			$m->load($id);
			$m->id = null;
			$m->pid = $phase->id;
			$m->store();
		endfor;
		
		$checklistModel = &JModel::getInstance('Checklist', 'JforceModel');
		$checklists = $checklistModel->listChecklists();
		
		for ($i=0; $i<count($checklists); $i++) :
			$id = $checklists[$i]->id;
			$c = JTable::getInstance('Checklist');
			$c->load($id);
			$c->id = null;
			$c->pid = $phase->id;
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
				$task->pid = $phase->id;
				$task->store();
			endfor;
			
		endfor;
		
		return $phase->id;
		
	}

	function ical() {

		global $mainframe;
		include(JPATH_COMPONENT.DS.'lib'.DS.'calendar'.DS.'ical.class.php');
		
		jimport('joomla.filesystem.file');
		
		$phase = $this->getPhase();
		$all = false;
		$activity = $this->latestActivity($all);
		
		$site = JURI::base();
		$calendar = new vcalendar();                          // initiate new CALENDAR
		$calendar->setConfig( 'unique_id', $site );             // config with site domain
		$calendar->setProperty( 'X-WR-CALNAME', $phase->name );          // set some X-properties, name, content.. .
		$calendar->setProperty('METHOD','PUBLISH');
		$calendar->setProperty( 'X-WR-CALDESC', strip_tags($phase->description) );
		
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

		$filename = JFile::makeSafe($phase->name.'.ics');
		
		header('Content-Type: text/Calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		ob_clean();
		flush();

		echo $output;
	}		
	
}
