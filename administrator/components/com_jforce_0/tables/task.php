<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			task.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableTask extends JTable
{ 

	var $id						= null;
	
	var $cid					= null;
			
	var $pid					= null;
			
	var $summary				= null;
			
	var $priority				= null;
			
	var $duedate				= null;
			
	var $notify					= null;
			
	var $completed				= null;
			
	var $reopened				= null;
			
	var $datereopened			= null;
			
	var $datecompleted			= null;
			
	var $completedby			= null;
			
	var $reopenedby				= null;
			
	var $created				= null;
			
	var $modified				= null;
			
	var $author					= null;
	
	var $published				= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_tasks', 'id', $_db );
	}	
}