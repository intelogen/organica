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

class JTableReport extends JTable
{ 

	var $id					= null;
	
	var $uid				= null;
			
	var $name				= null;
			
	var $description		= null;
			
	var $search				= null;
			
	var $created			= null;
			
	var $lastrun			= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_reports', 'id', $_db );
	}	
}