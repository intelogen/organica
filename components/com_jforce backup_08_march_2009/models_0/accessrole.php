<?php

/********************************************************************************
*	@package		Joomla														*
*	@subpackage		jForce, the Joomla! CRM										*
*	@version		2.0															*
*	@file			accessrole.php												*
*	@updated		2008-12-15													*
*	@copyright		Copyright (C) 2008 - 2009 JoomPlanet. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								*
********************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelAccessrole extends JModel {
	
	var $_id					= null;
	var $_accessrole			= null;
	var $_exludeCustom			= null;
	var $_project_objects 		= array('milestone', 'checklist', 'timetracker', 'document', 'ticket', 'discussion', 'quote', 'invoice');
	var $_global_objects		= array('project','lead', 'person', 'company', 'campaign', 'potential', 'global_quote', 'global_invoice', 'global_ticket');
	var $_settings				= array('system_access', 'can_see_private_objects', 'can_assign', 'can_be_assigned_tickets','can_be_assigned_leads', 'can_view_reports', 'can_access_messages');
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
		$this->_accessrole	= null;
	}
	
	function excludeCustom() {
		$this->_excludeCustom = null;
	}

	function &getAccessrole()
	{
		// Load the Category data
		if ($this->_loadAccessrole())
		{

		//	$this->_loadProjectroleParams();

		}
		else
		{
			$accessrole =& JTable::getInstance('Accessrole');
			$accessrole->parameters	= new JParameter( '' );
			$this->_accessrole			= $accessrole;
		}

		return $this->_accessrole;
	}

	function save($data)
	{
		global $mainframe;

		$accessrole  =& JTable::getInstance('Accessrole');
		
		$fields = array_merge($data['pr'],$data['sys']);
		$data = array_merge($data,$fields);

		// Bind the form fields to the web link table
		if (!$accessrole->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$accessrole->id = (int) $accessrole->id;

		// Make sure the table is valid
		if (!$accessrole->check()) {
			$this->setError($accessrole->getError());
			return false;
		}
		// Store the article table to the database
		if (!$accessrole->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_accessrole	=& $accessrole;

		return true;
	}
	
	function listAccessroles() {	
	
		$where = $this->_buildWhere();

		$query = 'SELECT p.* '.
				' FROM #__jf_accessroles AS p' .
				$where;

        $accessroles = $this->_getList($query, 0, 0);
		
		$this->list =$accessroles;
        return $this->list;
    }

	function _loadAccessrole()
	{
		global $mainframe;

		if($this->_id == '0' || !$this->_id)
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_accessrole))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT p.* '.
					' FROM #__jf_accessroles AS p' .
					$where;
			$this->_db->setQuery($query);
			$this->_accessrole = $this->_db->loadObject();

			if ( ! $this->_accessrole ) {
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
		
		if (!$person && !$project) :
			$projectrole = JTable::getInstance('Accessrole', 'JTable');
			$projectrole->load($this->_id);
		else :
			$projectrole = JTable::getInstance('Projectrolecf', 'JTable');
			$id = $this->getRoleId($person, $project);
			
			if ($id) :
				$projectrole->load($id);
			endif;
			
			if (isset($projectrole->role)) :
				$this->_role_id = $projectrole->role;
			endif;
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
		
		foreach ($this->_project_objects as $o) :
			$radiolist = JHTML::_('select.radiolist', $role_options, 'pr['.$o.']', 'class="inputbox"', 'value', 'text', $projectrole->$o, '');
			$html .= "<tr>";
			$html .= "<td>".JText::_($o)."</td>";
			$html .= "<td>".$radiolist."</td>";
			$html .= "</tr>";
		endforeach;
		
		$html .= "</table>";
		
		return $html;
		
	}
	
	function buildSystemRoleOptions() {
		
		$systemrole = JTable::getInstance('Accessrole', 'JTable');
	
		if ($this->_id) :
			$systemrole->load($this->_id);
		endif;
		
		$access = array(
			0 => JText::_('No'),
			1 => JText::_('Yes'),
		);
		foreach ($access as $key=>$value) :
			$role_options[] = JHTML::_('select.option', $key, $value);
		endforeach;
	
		$html = "<table>";
		$html .= "<tr>";
		$html .= "<th>".JText::_('Object')."</th>";
		$html .= "<th>".JText::_('Access')."</th>";
		$html .= "</tr>";
		
		foreach ($this->_settings as $o) :
			$radiolist = JHTML::_('select.radiolist', $role_options, 'sys['.$o.']', 'class="inputbox"', 'value', 'text', $systemrole->$o, '');
			$html .= "<tr>";
			$html .= "<td>".JText::_($o)."</td>";
			$html .= "<td align='right'>".$radiolist."</td>";
			$html .= "</tr>";
		endforeach;
		
		$html .= "</table>";
		
		$options['settings'] = $html;
		
		$html = NULL;
		$role_options = array();
		
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
	
		$html = "<table>";
		$html .= "<tr>";
		$html .= "<th>".JText::_('Object')."</th>";
		$html .= "<th>".JText::_('Permissions Level')."</th>";
		$html .= "</tr>";
		
		foreach ($this->_global_objects as $o) :
			$radiolist = JHTML::_('select.radiolist', $role_options, 'sys['.$o.']', 'class="inputbox"', 'value', 'text', $systemrole->$o, '');
			$html .= "<tr>";
			$html .= "<td>".JText::_($o)."</td>";
			$html .= "<td align='right'>".$radiolist."</td>";
			$html .= "</tr>";
		endforeach;
		
		$html .= "</table>";
		
		$options['objects'] = $html;
		
		return $options;
		
	}
	
	function addPeopletoProject($data) {
		
		if ($data['systemrole']) :
			$role = &JTable::getInstance('Accessrole', 'JTable');
			$role->load($data['systemrole']);
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
	
	function loadUserAccessRole($uid = null) {
		if (!$uid) :
			$user = &JFactory::getUser();
			$uid = $user->id;
		endif;
		$query = "SELECT systemrole FROM #__jf_persons WHERE uid = '$uid'";
		$this->_db->setQuery($query);
		$id = $this->_db->loadResult();
		
		$this->setId($id);
		
		$accessrole = JTable::getInstance('Accessrole','JTable');
		$accessrole->load($id);
		return $accessrole;
	}
	
	function getAccessRoleId($uid = null) {
		if (!$uid) :
			$user = &JFactory::getUser();
			$uid = $user->id;
		endif;
		
		$query = "SELECT id FROM #__jf_accessroles WHERE uid = '$uid'";
		$this->_db->setQuery($query);
		$id = $this->_db->loadResult();
		return $id;
	}
	
	function saveUserAccessRole($roles, $person, $project = null) {
		
		if (!$person->systemrole) :
			$id = $this->getAccessRoleId($person->uid);
			$accessrole = JTable::getInstance('Accessrole', 'JTable');
		
			if ($id) :
				$accessrole->load($id);
			endif;
		
			$accessrole->bind($roles);
			$accessrole->uid = $person->uid;
			$accessrole->store();
			return $accessrole->id;
		else :
			$query = "DELETE FROM #__jf_accessroles WHERE uid = '$person->uid'";
			$this->_db->setQuery($query);
			$this->_db->query();
			return $person->systemrole;
		endif;
		
		
		
	}
	
	function saveUserProjectRole($roles, $person, $project = null) {
		$id = $this->getRoleId($person, $project);
		
		$accessrole = JRequest::getVar('systemrole', '0');
		
		if ($accessrole) :
			$savedRole = JTable::getInstance('Accessrole', 'JTable');
			$savedRole->load($accessrole);
			$roles = $this->_convertToArray($savedRole);
		endif;

		$roles['role'] = $accessrole;
		$roles['uid'] = $person;
		$roles['pid'] = $project;
		
		$projectrole = JTable::getInstance('Projectrolecf', 'JTable');
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

		foreach ($this->_project_objects as $o) :
			$array[$o] = $object->$o;
		endforeach;
		
		return $array;
	}
}