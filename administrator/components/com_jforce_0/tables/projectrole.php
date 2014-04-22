<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			projectrole.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableProjectrole extends JTable
{ 

	var $id						= null;
	
	var $uid					= null;
			
	var $name					= null;
			
	var $milestone				= null;
			
	var $checklist				= null;
			
	var $timetracker			= null;
			
	var $document				= null;
			
	var $ticket					= null;
			
	var $discussion				= null;
	
	var $quote					= null;
	
	var $invoice				= null;
			
	var $created				= null;
			
	var $modified				= null;
			
	var $author					= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_projectroles', 'id', $_db );
	}	
}