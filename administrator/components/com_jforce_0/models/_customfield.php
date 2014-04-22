<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			customfield.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelCustomfield extends JModel {
	
	var $_id					= null;
	var $_customfield			= null;
	var $_published				= 1;

    function __construct() {
    	
        parent::__construct();
		
		
		$cid = JRequest::getVar('cid');
		
		$id = is_array($cid) ? $cid[0] : $cid;
		
		$this->setId((int)$id);
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_customfield	= null;
	}	
	
	

	function &getCustomfield()
	{
		// Load the Category data
		if ($this->_loadCustomfield())
		{


		}
		else
		{
			$customfield =& JTable::getInstance('Customfield');
			$customfield->parameters	= new JParameter( '' );
			$this->_customfield			= $customfield;
		}

		$this->_parseValues();

		return $this->_customfield;
	}

	function _parseValues() {
	
		if ($this->_customfield->values) :
			$this->_customfield->_values = explode("|", $this->_customfield->values);
		else:
			$this->_customfield->_values = array();
		endif;
	
	}

	
	
	
	
	function listCustomfields() {	
	
		$where = $this->_buildWhere();

		$query = 'SELECT c.* '.
				' FROM #__jf_customfields AS c' .
				$where;

        $customfields = $this->_getList($query, 0, 0);
		
		$this->list =$customfields;
        return $this->list;
    }

	function _loadCustomfield()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_customfield))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT c.* '.
					' FROM #__jf_customfields AS c' .
					$where;
			$this->_db->setQuery($query);
			$this->_customfield = $this->_db->loadObject();

			if ( ! $this->_customfield ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
		
	
	
}