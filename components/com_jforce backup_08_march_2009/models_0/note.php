<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			note.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelNote extends JModel {
	
	var $_id					= null;
	var $_note			= null;


    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_note	= null;
	}	

	function &getNote()
	{
		// Load the Category data
		if ($this->_loadNote())
		{

		//	$this->_loadNoteParams();

		}
		else
		{
			$note =& JTable::getInstance('Note');
			$note->parameters	= new JParameter( '' );
			$this->_note			= $note;
		}

		return $this->_note;
	}

	function save($data)
	{
		global $mainframe;

		$note  =& JTable::getInstance('Note');

		// Bind the form fields to the web link table
		if (!$note->bind($data, 'published')) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$note->id = (int) $note->id;

		// Make sure the table is valid
		if (!$note->check()) {
			$this->setError($note->getError());
			return false;
		}
		// Store the article table to the database
		if (!$note->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_note	=& $note;

		return true;
	}
	
	function listNotes() {	
	
		$where = $this->_buildWhere();

		$query = 'SELECT n.* '.
				' FROM #__jf_notes AS n' .
				$where;

        $notes = $this->_getList($query, 0, 0);
		
		$this->list =$notes;
        return $this->list;
    }

	function _loadNote()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_note))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT n.* '.
					' FROM #__jf_notes AS n' .
					$where;
			$this->_db->setQuery($query);
			$this->_note = $this->_db->loadObject();

			if ( ! $this->_note ) {
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
			$where = ' WHERE n.id = '. (int) $this->_id;
		else:
			$where = null;
		endif;
		
		return $where;
	}	
}