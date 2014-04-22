<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			projectrolecf.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableProjectrolecf extends JTable
{ 

	var $id						= null;
	
	var $uid					= null;
			
	var $pid					= null;
	
	var $role					= null;
			
	var $milestone				= null;
			
	var $checklist				= null;
			
	var $timetracker			= null;
			
	var $document				= null;
			
	var $ticket					= null;
			
	var $discussion				= null;
	
	var $quote					= null;
	
	var $invoice				= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_projectroles_cf', 'id', $_db );
	}	
}