<?php

/********************************************************************************
*	@package		Joomla														*
*	@subpackage		jForce, the Joomla! CRM										*
*	@version		2.0															*
*	@file			projectrole.php												*
*	@updated		2008-12-15													*
*	@copyright		Copyright (C) 2008 - 2009 JoomPlanet. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								*
********************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelProjectrole extends JModel {
	
	var $_id					= null;
	var $_projectrole			= null;
	var $_exludeCustom			= null;
	var $_objects 				= array('milestone', 'checklist', 'timetracker', 'document', 'ticket', 'discussion', 'quote', 'invoice');
	var $_role_id				= null;


    function __construct() {
    	
        parent::__construct();
		
		#$id = JRequest::getVar('id', 0, '', 'int');
		#$this->setId((int)$id);
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_projectrole	= null;
	}
	
	function excludeCustom() {
		$this->_excludeCustom = null;
	}

	function &getProjectrole()
	{
		// Load the Category data
		if ($this->_loadProjectrole())
		{

		//	$this->_loadProjectroleParams();

		}
		else
		{
			$projectrole =& JTable::getInstance('Projectrole');
			$projectrole->parameters	= new JParameter( '' );
			$this->_projectrole			= $projectrole;
		}

		return $this->_projectrole;
	}

	function save($data)
	{
		global $mainframe;

		$projectrole  =& JTable::getInstance('Projectrole');

		// Bind the form fields to the web link table
		if (!$projectrole->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$projectrole->id = (int) $projectrole->id;

		// Make sure the table is valid
		if (!$projectrole->check()) {
			$this->setError($projectrole->getError());
			return false;
		}
		// Store the article table to the database
		if (!$projectrole->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_projectrole	=& $projectrole;

		return true;
	}
	
	function listProjectroles() {	
	
		$where = $this->_buildWhere();

		$query = 'SELECT p.* '.
				' FROM #__jf_projectroles AS p' .
				$where;

        $projectroles = $this->_getList($query, 0, 0);
		
		$this->list =$projectroles;
        return $this->list;
    }

	function _loadProjectrole()
	{
		global $mainframe;

		if($this->_id == '0' || !$this->_id)
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_projectrole))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT p.* '.
					' FROM #__jf_projectroles AS p' .
					$where;
			$this->_db->setQuery($query);
			$this->_projectrole = $this->_db->loadObject();

			if ( ! $this->_projectrole ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function _buildWhere()
	{
		global $mainframe;
	
		if($this->_id):
			$where = ' WHERE p.id = '. (int) $this->_id;
		else :
			$where = " WHERE p.uid = '0'";
		endif;
		
		return $where;
	}
	
	function buildProjectRoleOptions($person = null, $project = null) {
		
		$table = $project ? 'Projectrolecf' : 'Projectrole';
		$projectrole = JTable::getInstance($table, 'JTable');
		
		if ($person) :
			$id = $this->getRoleId($person, $project);
			if ($id) :
				$projectrole->load($id);
			endif;
		elseif($this->_id) :
			$projectrole->load($this->_id);
		endif;
		
		if (isset($projectrole->role)) :
			$this->_role_id = $projectrole->role;
		endif;
		
		$access = array(
			0 => JText::_('No Access'),
			1 => JText::_('Assignments Only'),
			2 => JText::_('Has Access'),
			3 => JText::_('and Can Create'),
			4 => JText::_('and Can Manage')
		);
		foreach ($access as $key=>$value) :
			$role_options[] = JHTML::_('select.option', $key, $value);
		endforeach;
	
		$html = "<table width='100%'>";
		$html .= "<tr>";
		$html .= "<th>".JText::_('Object')."</th>";
		$html .= "<th>".JText::_('Permissions Level')."</th>";
		$html .= "</tr>";
		
		foreach ($this->_objects as $o) :
			$radiolist = JHTML::_('select.radiolist', $role_options, 'pr['.$o.']', 'class="inputbox"', 'value', 'text', $projectrole->$o, '');
			$html .= "<tr>";
			$html .= "<td>".JText::_($o)."</td>";
			$html .= "<td>".$radiolist."</td>";
			$html .= "</tr>";
		endforeach;
		
		$html .= "</table>";
		
		return $html;
		
	}
	
	function addPeopletoProject($data) {
		
		if ($data['projectrole']) :
			$role = &JTable::getInstance('Projectrole', 'JTable');
			$role->load($data['projectrole']);
			$role->role = $role->id;
			$role->id = null;
		else :
			$role = $data['pr'];
		endif;
		
		for ($i=0; $i<count($data['selectedUsers']); $i++) :
			$u = $data['selectedUsers'][$i];
			$cf = &JTable::getInstance('Projectrolecf', 'JTable');
			$cf->bind($role);
			$cf->uid = $u;
			$cf->pid = $data['pid'];
			$cf->store();
			
		endfor;
		
	}
	
	function saveUserProjectRole($roles, $person, $project = null) {
		$table = $project ? 'Projectrolecf' : 'Projectrole';
		
		$id = $this->getRoleId($person, $project);
		
		$roles['role'] = JRequest::getVar('projectrole', '');
		
		if ($roles['role'] && !$project) :
			$this->_destroyRole($id, $project);
			return;
		endif;
		
		if ($roles['role']) :
			$savedRole = JTable::getInstance('Projectrole', 'JTable');
			$savedRole->load($roles['role']);
			$roles = $this->_convertToArray($savedRole);
		endif;
		
		if (is_array($roles)) :
			$roles['uid'] = $person;
			$roles['pid'] = $project;
			if ($savedRole->id):
				$roles['role'] = $savedRole->id;
			else:
				$roles['role'] = 0;
			endif;
		else:
			$roles->uid = $person;
			$roles->pid = $project;
		endif;
		
		$projectrole = JTable::getInstance($table, 'JTable');
		if ($id) :
			$projectrole->load($id);
		endif;
		
		if (!$projectrole->bind($roles)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		if (!$projectrole->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		return $projectrole->id;
		
	}
	
	function getRoleId($person, $project) {
		$table = $project ? '#__jf_projectroles_cf' : '#__jf_projectroles';
		
		$query = "SELECT id FROM $table WHERE uid = '$person'";
		if ($project) $query .= " AND pid = '$project'";
		
		$this->_db->setQuery($query);
		$id = $this->_db->loadResult();
		
		return $id;
	}
	
	function _destroyRole($id, $project) {
		if ($id) :
			$table = $project ? '#__jf_projectroles_cf' : '#__jf_projectroles';
			$query = "DELETE FROM $table WHERE id = '$id'";
			$this->_db->setQuery($query);
			$this->_db->query();
		endif;
	}
	
	function _convertToArray($object) {
		$array = array();

		foreach ($this->_objects as $o) :
			$array[$o] = $object->$o;
		endforeach;
		
		return $array;
	}
}