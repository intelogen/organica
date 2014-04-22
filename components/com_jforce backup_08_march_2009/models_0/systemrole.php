<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			systemrole.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelSystemrole extends JModel {
	
	var $_id					= null;
	var $_systemrole			= null;
	var $_settings				= array('system_access', 'can_see_private_objects', 'can_assign', 'can_be_assigned_tickets','can_be_assigned_leads', 'can_view_reports');
	var $_objects				= array('project','lead', 'person', 'company', 'campaign', 'potential', 'quote', 'invoice', 'ticket');


    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_systemrole	= null;
	}	

	function &getSystemrole()
	{
		// Load the Category data
		if ($this->_loadSystemrole())
		{
		//	$this->_loadSystemroleParams();

		}
		else
		{
			$systemrole =& JTable::getInstance('Systemrole');
			$systemrole->parameters	= new JParameter( '' );
			$this->_systemrole			= $systemrole;

		}

		return $this->_systemrole;
	}

	function save($data)
	{
		global $mainframe;

		$systemrole  =& JTable::getInstance('Systemrole');

		// Bind the form fields to the web link table
		if (!$systemrole->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$systemrole->id = (int) $systemrole->id;

		// Make sure the table is valid
		if (!$systemrole->check()) {
			$this->setError($systemrole->getError());
			return false;
		}
		// Store the article table to the database
		if (!$systemrole->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_systemrole	=& $systemrole;

		return true;
	}
	
	function listSystemroles() {	
	
		$where = $this->_buildWhere();

		$query = 'SELECT s.* '.
				' FROM #__jf_systemroles AS s' .
				$where;

        $systemroles = $this->_getList($query, 0, 0);
		
		$this->list =$systemroles;
        return $this->list;
    }

	function _loadSystemrole()
	{
		global $mainframe;

		if($this->_id == '0' || $this->_id == '')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_systemrole))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT s.* '.
					' FROM #__jf_systemroles AS s' .
					$where;
					
			$this->_db->setQuery($query);
			$this->_systemrole = $this->_db->loadObject();

			if ( ! $this->_systemrole ) {
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
			$where = ' WHERE s.id = '. (int) $this->_id;
		else:
			$where = null;
		endif;
		
		return $where;
	}
	
	function loadUserSystemRole($userid) {
		$query = "SELECT systemrole FROM #__jf_persons WHERE uid = '$userid'";

		$this->_db->setQuery($query);
		$this->_id = $this->_db->loadResult();
		
		$this->_loadSystemRole();
		
		return $this->_systemrole;
	}	
	
	function buildSystemRoleOptions() {
		
		$systemrole = JTable::getInstance('Systemrole', 'JTable');
	
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
		$html .= "<th width='200'>".JText::_('Object')."</th>";
		$html .= "<th>".JText::_('Access')."</th>";
		$html .= "</tr>";
		
		foreach ($this->_settings as $o) :
			$radiolist = JHTML::_('select.radiolist', $role_options, 'pr['.$o.']', 'class="inputbox"', 'value', 'text', $systemrole->$o, '');
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
		$html .= "<th width='200'>".JText::_('Object')."</th>";
		$html .= "<th>".JText::_('Permissions Level')."</th>";
		$html .= "</tr>";
		
		foreach ($this->_objects as $o) :
			$radiolist = JHTML::_('select.radiolist', $role_options, 'pr['.$o.']', 'class="inputbox"', 'value', 'text', $systemrole->$o, '');
			$html .= "<tr>";
			$html .= "<td>".JText::_($o)."</td>";
			$html .= "<td align='right'>".$radiolist."</td>";
			$html .= "</tr>";
		endforeach;
		
		$html .= "</table>";
		
		$options['objects'] = $html;
		
		return $options;
		
	}
	
}