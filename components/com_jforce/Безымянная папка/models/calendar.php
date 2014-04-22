<?php

/********************************************************************************
*	@package		Joomla														*
*	@subpackage		jForce, the Joomla! CRM										*
*	@version		2.0															*
*	@file			calendar.php												*
*	@updated		2008-12-15													*
*	@copyright		Copyright (C) 2008 - 2009 JoomPlanet. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								*
********************************************************************************/

class JforceModelCalendar extends JModel {
	
	var $_data				= null;
	var $_date				= null;
	var $_datestamp			= null;
	var $_month				= null;
	var $_year				= null;
	var $_day				= null;
	var $_display			= null;
	var $_pid				= null;


    function __construct() {
    	
        parent::__construct();
		
		$date['year']	 = JRequest::getVar('y', '0');
		$date['month']	 = JRequest::getVar('m', '0');
		$date['day']	 = JRequest::getVar('d', '0');
		
		$this->setDate($date);
		
		$display = JRequest::getVar('display', 'month');
		$this->setDisplay($display);
		
		$pid = JRequest::getVar('pid', 0);
		$this->setPid($pid);
		
	} 

	function setDisplay($display) {
		$this->_display = $display;
		return true;
	}	
	
	function setPid($pid) {
		$this->_pid = $pid;
		return true;
	}

	function setDate($date = null) {
		
		$date['year'] 	= $date['year'] != 0 ? $date['year'] : date('Y');
		$date['month'] 	= $date['month'] != 0 ? $date['month'] : date('m');
		$date['day'] 	= $date['day'] != 0 ? $date['day'] : date('d');
		
		$this->_year	= $date['year'];
		$this->_month	= $date['month'];
		$this->_day		= $date['day'];
		
		$this->_date		= implode("-", $date);
		$this->_datestamp	= strtotime($this->_date);
		
		
		
	}

	function buildCalendar() {
		switch($this->_display) :
		
			case 'month':
			$calendar = $this->_buildMonthlyCalendar();
			break;
			
			case 'week':
			$calendar = $this->_buildWeeklyCalendar();
			break;
			
			case 'day':
			$calendar = $this->_buildDailyCalendar();
			break;
		
		endswitch;
		
		return $calendar;
		
	}

	function _buildMonthlyCalendar() {
		
		$pid					= JRequest::getVar('pid', 0);
		$data['monthname']		= date("F", $this->_datestamp);
		$data['year']			= $this->_year;
		
		$firstDayStamp			= mktime(0,0,0, $this->_month, 1, $this->_year);
		$data['startingDay']	= date('w', $firstDayStamp);
		
		$numDays 				= date("t", $this->_datestamp);
		$data['numrows'] 		= ceil(($numDays + $data['startingDay']) / 7);
		
		$data['firstDay']		= $this->_year.'-'.$this->_month."-01";
		$data['lastDay'] 		= date("d",mktime (0, 0, 0, ($this->_month + 1), 0, $this->_year));
		
		$nextMonth				= getdate(mktime(0,0,0,($this->_month+1), 1, $this->_year));
		$lastMonth				= getdate(mktime(0,0,0,($this->_month-1), 1, $this->_year));
		
		$lastMonth['mon']		= (intval($lastMonth['mon']) < 10) ? '0'.$lastMonth['mon'] : $lastMonth['mon'];
		$nextMonth['mon']		= (intval($nextMonth['mon']) < 10) ? '0'.$nextMonth['mon'] : $nextMonth['mon'];
		
		$data['prevLink'] 		= JRoute::_('index.php?option=com_jforce&view=calendar&pid='.$pid.'&y='.$lastMonth['year'].'&m='.$lastMonth['mon']);
		$data['nextLink'] 		= JRoute::_('index.php?option=com_jforce&view=calendar&pid='.$pid.'&y='.$nextMonth['year'].'&m='.$nextMonth['mon']);
		
		$data['nextMonth']		= JText::_($nextMonth['month']).' '.$nextMonth['year'].' >>';
		$data['lastMonth']		= '<< '.JText::_($lastMonth['month']).' '.$lastMonth['year'];
		
		
		$activity = $this->compileActivity($data);

		$row = 0;
		$k = 0;
		for ($i=0; $i<($data['numrows']*7); $i++) :
			$data['weeks'][$row]['days'][$i] = $this->buildDay($k, $data, $activity);
			$k++;
			if ($i > 0 && ($i%7 == 6)) :
				$row++;		 
			endif;
		endfor;

		$this->_calendar = $data;
		return $this->_calendar;
	}
	
	function _buildWeeklyCalendar() {
		
	}
	
	function _buildDailyCalendar() {
		
	}

	function getNumTableRows() {
			
	}
	
	function buildDay($i, $data, $activity) {
		
		$label = ($i+1) - $data['startingDay'];
		
		if ($label < 1 || $label>$data['lastDay']) :
			$html = $this->_renderInactiveDay();
			return $html;
		endif;
		
		$day = $label<10 ? '0'.$label : $label;
		$date = $this->_year.'-'.$this->_month.'-'.$day;
		
		$dayActivity = $this->renderActivity($activity, $date);
		
        $html = '<td class="calendarDay" id="day_'.$label.'">';
		$html .= '<div class="dayLabel">'.$label.'</div>';
		$html .= $dayActivity;
		$html .= '</td>';
		
		return $html;
   
	}
	
	function _renderInactiveDay() {
		
		$html = '<td class="day inactive">';
        $html .= '</td>';
        
		return $html;
	}

	function renderActivity($activity, $date) {
		$dayActivity = null;
		
		if (isset($activity[$date])) :
			for ($i=0; $i<count($activity[$date]);$i++) :
				$a = $activity[$date][$i];
				$letter = strtoupper(substr($a['type'],0,1));
				$completedClass = $a['completed'] ? 'itemCompleted' : '';
				
				$hasTip = null;
				$title = null;
				if ($a['text']) :
					$hasTip = 'hasTip';
					$title = 'title="'.$a['title'].'::'.$a['text'].'"';
				endif;
				
				$dayActivity .= '<div class="calLinkHolder '.$hasTip.'" '.$title.'>';
				$dayActivity .= '<span class="itemTag '.$a['type'].'">'.$letter.'</span>';
	
				# Old class for link - '.$a['type'].'Link calLink
				$dayActivity .= '<a class="'.$completedClass.'" href="'.$a['link'].'">'.$a['title'].'</a>';
				$dayActivity .= '</div>';
			endfor;
		endif;
		
		return $dayActivity;
		
	}

	function getLinks() {
		
		$lastMonth = mktime(0,0,0, ($this->_month - 1), 0, $this->_year);
		$nextMonth = mktime(0,0,0, ($this->_month + 1), 1, $this->_year);
		
	}
	
	function compileActivity($data) {
		
		$dates['lower'] = $data['firstDay'];
		$dates['upper'] = $data['lastDay'];
		
		$activity = array();
		
		# Milestones
		$milestoneModel =& JModel::getInstance('Milestone','JForceModel');
		$milestoneModel->setPid($this->_pid);
		$milestoneModel->setDateRange($dates);
		$milestones = $milestoneModel->listMilestones(4);
		
		if ($milestones['active']) :
			foreach($milestones['active'] as $m):
				$activity['milestone'][]=$m;
			endforeach;
		endif;
		
		if ($milestones['late']) :
			foreach($milestones['late'] as $m):
				$activity['milestone'][]=$m;
			endforeach;
		endif;
		
		if ($milestones['completed']) :
			foreach($milestones['completed'] as $m):
				$activity['milestone'][]=$m;
			endforeach;
		endif;
		
		
		# Tasks
		$taskModel =& JModel::getInstance('Task','JForceModel');
		$taskModel->setPid($this->_pid);
		$taskModel->setDateRange($dates);
		$tasks = $taskModel->listTasks();
		
		if ($tasks) :
			foreach($tasks as $t):
				$activity['task'][]=$t;
			endforeach;
		endif;

		if ($activity) :
			$activity = JForceHelper::sortArray($activity,'duedate');
		endif;
		
		return $activity;

	}
	
}


function viewCalendar($option, $auth=null) {
	$database = & JFactory::getDBO();

	if ((!isset($_GET['month'])) && (!isset($_GET['year']))) {
		$calendar['month'] = date ("m");
		$calendar['year'] = date ("Y");
	} else {
		$calendar['month'] = $_GET['month'];
		$calendar['year'] = $_GET['year'];
	}

	# Calculate the viewed month
	$calendar['timestamp'] = mktime (0, 0, 0, $calendar['month'], 1, $calendar['year']);
	$calendar['monthname'] = date("F", $calendar['timestamp']);
	$calendar['monthstart'] = date("w", $calendar['timestamp']);
	$calendar['lastday'] = date("d", mktime (0, 0, 0, $calendar['month'] + 1, 0, $calendar['year']));
	$calendar['startdate'] = -$calendar['monthstart'];

	# Figure out how many rows we need.
	$calendar['numrows'] = ceil (((date("t",mktime (0, 0, 0, $calendar['month'] + 1, 0, $calendar['year'])) + $calendar['monthstart']) / 7));

	if ($calendar['month']==1) {
		$prevMonth = 12;
		$prevYear = $calendar['year']-1;
		$nextMonth = $calendar['month']+1;
		$nextYear = $calendar['year'];
	} elseif ($calendar['month']==12) {
		$prevMonth = $calendar['month']-1;
		$prevYear = $calendar['year'];
		$nextMonth = 1;
		$nextYear = $calendar['year']+1;
	} else {
		$prevMonth = $calendar['month']-1;
		$prevYear = $calendar['year'];
		$nextMonth = $calendar['month']+1;
		$nextYear = $calendar['year'];
	}

	$calendar['prevLink'] = "<a href='index2.php?option=com_jprojects&task=viewCalendar&month=".$prevMonth."&year=".$prevYear."'><< Last Month</a>";
	$calendar['nextLink'] = "<a href='index2.php?option=com_jprojects&task=viewCalendar&month=".$nextMonth."&year=".$nextYear."'>Next Month >></a>";

	# Get Tasks
		if (strlen($calendar['month'])==1) {
			$datefilter = "'".$calendar['year']."-0".$calendar['month'];
		} else {
			$datefilter = "'".$calendar['year']."-".$calendar['month'];
		}
		$datefilter.= "' AND j.startdate < '";
		if (strlen($nextMonth)==1) {
			$datefilter.= $nextYear."-0".$nextMonth."'";
		} else {
			$datefilter.= $nextYear."-".$nextMonth."'";
		}
		$where = ($auth!="") ? "AND" : "WHERE";
		$query = "SELECT j.id, j.subject, j.published, j.stage, j.startdate, j.completiondate, j.priority, "
		."\n m.username as owner, p.subject as projectname, a.username as assignedto FROM #__jtasks as j"
		."\n LEFT OUTER JOIN #__users as a on j.assignedto = a.id"
		."\n LEFT OUTER JOIN #__jprojects as p on j.projectid = p.id"
		."\n LEFT OUTER JOIN #__users as m on j.manager = m.id"
		."\n $auth $where j.published = 1 "
		."\n AND (j.startdate > ".$datefilter.")"
		."\n ORDER BY j.id, subject DESC";
		$database->setQuery($query);

		$tasks = $database -> loadObjectList();


	HTML_calendar::viewCalendar($calendar, $tasks);

 }
function calendarDayView($option, $auth=null) {
$database = & JFactory::getDBO();

	$date = date("Y-m-d",strtotime($_GET['date']));
	$calendar['prevDate'] = date("Y-m-d", strtotime("-1 day",strtotime($date)));
	$calendar['nextDate'] = date("Y-m-d", strtotime("+1 day",strtotime($date)));

	$calendar['prevLink'] = "<a href='index2.php?option=com_jprojects&task=calendarDayView&date=".$calendar['prevDate']."'><< Previous Day</a>";
	$calendar['nextLink'] = "<a href='index2.php?option=com_jprojects&task=calendarDayView&date=".$calendar['nextDate']."'>Next Day >></a>";
	$calendar['date'] = $date;

	$database->setQuery("SELECT j.id, j.subject, j.published, j.stage, j.startdate, j.completiondate, j.priority, "
	."\n m.username as owner, p.subject as projectname, a.username as assignedto FROM #__jtasks as j"
	."\n LEFT OUTER JOIN #__users as a on j.assignedto = a.id"
	."\n LEFT OUTER JOIN #__jprojects as p on j.projectid = p.id"
	."\n LEFT OUTER JOIN #__users as m on j.manager = m.id"
	."\n $auth WHERE j.published = 1 "
	."\n AND j.startdate >= '$date' AND j.startdate < '$calendar[nextDate]'"
	."\n ORDER BY j.id, subject DESC");

	$tasks = $database -> loadObjectList();

	HTML_calendar::viewCalendarDay($option, $calendar, $tasks);
}