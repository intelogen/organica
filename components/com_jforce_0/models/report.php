<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			report.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelReport extends JModel {
	
	var $_id				= null;
	var $_report			= null;
	var $_type				= null;
	var $_data				= null;
	var $_category			= null;

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);

		$category = JRequest::getVar('category', 'Projects');
		$this->_category = $category;

	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}	

	function &getData()
	{
		// Load the Category data
		if ($this->_loadData())
		{

		}
		else
		{

		$this->_data = null;
		
		}

		return $this->_data;
	}
	
	function save($data)
	{
		global $mainframe;

		$report  =& JTable::getInstance('Report');

		// Bind the form fields to the web link table
		if (!$report->bind($data, 'published')) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$report->id = (int) $report->id;

		// Make sure the table is valid
		if (!$report->check()) {
			$this->setError($report->getError());
			return false;
		}
		// Store the article table to the database
		if (!$report->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_report	=& $report;

		return true;
	}
	
	function listReports() {	
	
		$where = $this->_buildWhere();

		$query = 'SELECT r.* '.
				' FROM #__jf_reports AS r' .
				$where;

        $reports = $this->_getList($query, 0, 0);
		
		for($i=0;$i<count($reports);$i++):
			$report = $reports[$i];
			$report->icon = '<img src="'.JURI::base().'components'.DS.'com_jforce'.DS.'images'.DS.'report_icon.png" />';
		endfor;
		
		$this->list =$reports;
        return $this->list;
    }
	
	function getReport() {
		// Load the Category data
		if ($this->_loadReport())
		{
			//	$this->_loadProjectParams();

		}
		else
		{
			$report =& JTable::getInstance('Report');
			$this->_report	= $report;
		}

		return $this->_report;
	}

	function _loadReport()
	{

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_report))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT r.* '.
					' FROM #__jf_reports AS r' .
					$where;
			$this->_db->setQuery($query);
			$this->_report = $this->_db->loadObject();

			if ( ! $this->_report ) {
				return false;
			}
			return true;
		}
		return true;
	}

	function _loadData()
	{
		global $mainframe;
		
		$graphFunction = '_loadGraph'.$this->_id;
		
		$data = $this->$graphFunction();
		
		$this->_data = $data;
		
		return true;
	}
		
	function _buildWhere()
	{
	if($this->_id):
			$where = ' WHERE r.id = '. (int) $this->_id;
		else:
			$where = null;
		endif;
		
		if ($this->_category):
			$where = " WHERE r.category = '$this->_category'";
		endif;			
		return $where;
	}
	
	function _loadGraph1()
	{
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$status = $configModel->getConfig('status', true);
		
		$data = array();
		
		for($i=0;$i<count($status);$i++):
			
			$s = $status[$i];
			
			$data[$i]['label']= $s;
			
			$query = 'SELECT COUNT(*) FROM #__jf_projects WHERE status = "'.$s.'"';
			$this->_db->setQuery($query);
			$data[$i]['value'] = $this->_db->loadResult();
			
		endfor;
		
		return $data;
	}
	
	
}