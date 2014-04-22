<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			timetracker.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelTimetracker extends JModel {
	
	var $_id					= null;
	var $_timetracker			= null;
	var $_pid					= null;
	var $_published 			= null;

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$pid = JRequest::getVar('pid',0,'','int');
		$this->setPid((int)$pid);
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_timetracker	= null;
	}	

	function setPid($pid)
	{
		$this->_pid	= $pid;	
	}

	function &getTimetracker()
	{
		global $mainframe;
		// Load the Category data
		if ($this->_loadTimetracker())
		{
			if ($this->_timetracker->pid != $this->_pid) :
				$url = JRoute::_('index.php?option=com_jforce');
				$msg = JText::_('You are not authorized to view this resource.');
				$mainframe->redirect($url, $msg);
			endif;
			$this->_timetracker->billableImg = '<img src="components/com_jforce/images/billable_'.$this->_timetracker->billable.'.png" class="billabletime" id="bt_'.$this->_timetracker->id.'" />'; 
		//	$this->_loadTimetrackerParams();
			$mainframe->triggerEvent('onLoadTimetracker',array($this->_timetracker));		

		}
		else
		{
			$timetracker =& JTable::getInstance('Timetracker');
			$timetracker->parameters	= new JParameter( '' );
			$timetracker->pid = $this->_pid;
			
			$this->_timetracker			= $timetracker;
		}

		return $this->_timetracker;
	}

	function save($data)
	{
		global $mainframe;

		$data['summary'] = JRequest::getVar('summary', '', 'post', 'string', JREQUEST_ALLOWRAW);

		$timetracker  =& JTable::getInstance('Timetracker');

		// Bind the form fields to the web link table
		if (!$timetracker->bind($data, 'published')) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$timetracker->id = (int) $timetracker->id;

		if(!$timetracker->id):
			$new = 1;
		else:
			$new = 0;
		endif;
		$timetracker->summary = JRequest::getVar('summary', '', 'post', 'string', JREQUEST_ALLOWRAW);
		// Make sure the table is valid
		if (!$timetracker->check()) {
			$this->setError($timetracker->getError());
			return false;
		}
		
		$mainframe->triggerEvent('onBeforeTimetrackerSave',array($timetracker,$new));		
	
		// Store the article table to the database
		if (!$timetracker->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_timetracker	=& $timetracker;

		$mainframe->triggerEvent('onAfterTimetrackerSave',array($timetracker,$new));		

		return $this->_timetracker;
	}
	
	function getTotal() {
		$where = $this->_buildWhere();

		$query = 'SELECT COUNT(*)'.
				' FROM #__jf_timetracker AS t' .
				' LEFT JOIN #__users AS u ON t.uid = u.id' .
				' LEFT JOIN #__jf_projects AS p ON t.pid = p.id'.
				$where;
				
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		
		return $total;
	}
	
	function listTimetrackers() {	
		global $mainframe;
		
		$where = $this->_buildWhere();

		$query = 'SELECT t.*, u.name as user, p.name as project '.
				' FROM #__jf_timetracker AS t' .
				' LEFT JOIN #__users AS u ON t.uid = u.id' .
				' LEFT JOIN #__jf_projects AS p ON t.pid = p.id'.
				$where;

		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

        $timetrackers = $this->_getList($query, $limitstart, $limit);
		
		for($i=0;$i<count($timetrackers);$i++):
			$timetracker = $timetrackers[$i];
			$timetracker->editUrl = JRoute::_('index.php?option=com_jforce&view=timetracker&layout=form&pid='.$timetracker->pid.'&id='.$timetracker->id);
			$timetracker->summarySnippet = strip_tags(JForceHelper::snippet($timetracker->summary,50));
			$timetracker->billableImg = '<img src="components/com_jforce/images/billable_'.$timetracker->billable.'.png" class="billabletime" id="bt_'.$timetracker->id.'" />'; 
			$timetracker->billed = '<img src="components/com_jforce/images/billed_'.$timetracker->billed.'.png" class="billed" />';
			
			$mainframe->triggerEvent('onLoadTimetracker',array($timetracker));		
		
		endfor;
		
		$this->list =$timetrackers;
        return $this->list;
    }

	function _loadTimetracker()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_timetracker))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT t.*, u.name as user, p.name as project '.
				' FROM #__jf_timetracker AS t' .
				' LEFT JOIN #__users AS u ON t.uid = u.id' .
				' LEFT JOIN #__jf_projects AS p ON t.pid = p.id'.
				$where;

			$this->_db->setQuery($query);
			$this->_timetracker = $this->_db->loadObject();

			if ( ! $this->_timetracker ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function _buildWhere()
	{
		global $mainframe;
		
		$where = ' WHERE t.published = '. (int) $this->_published;
		
		if($this->_pid):
			$where .= ' AND t.pid = '. (int) $this->_pid;
		endif;
		
		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR t.id = ',$this->_id);
				$where .= ' AND (t.id = '. $ids.')';
			else:
				$where .=' AND t.id = '.(int) $this->_id;
			endif;
		endif;
		
		return $where;
	}	
	
	function buildLists()
	{
		$lists = array();
		
		$lists['user'] = JForceListsHelper::getProjectPeople($this->_pid, $this->_timetracker->uid);
		
		$lists['billable'] = JHTML::_('select.booleanlist', 'billable', '', $this->_timetracker->billable, JText::_('No'), JText::_('Yes'));		

		$lists['billed'] = JHTML::_('select.booleanlist', 'billed', '', $this->_timetracker->billed, JText::_('No'), JText::_('Yes'));		
		
		return $lists;
	
	}
}