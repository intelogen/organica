<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			milestone.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableMilestone extends JTable
{ 

	var $id						= null;
	
	var $pid					= null;
			
	var $startdate				= null;
			
	var $duedate				= null;
			
	var $notes					= null;
			
	var $summary				= null;
			
	var $completed				= null;
			
	var $reopened				= null;
			
	var $datereopened			= null;
			
	var $datecompleted			= null;
			
	var $completedby			= null;
			
	var $reopenedby				= null;
			
	var $priority				= null;
			
	var $tags					= null;
					
	var $created				= null;
			
	var $modified				= null;
			
	var $author					= null;
	
	var $published				= null;
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_milestones', 'id', $_db );
	}	
}