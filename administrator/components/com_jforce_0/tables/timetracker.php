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

class JTableTimetracker extends JTable
{ 

	var $id				= null;
	
	var $pid			= null;
			
	var $uid			= null;
			
	var $date			= null;
			
	var $hours			= null;
			
	var $summary		= null;
			
	var $billable		= null;
			
	var $billed			= null;
			
	var $published		= null;
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_timetracker', 'id', $_db );
	}	
}