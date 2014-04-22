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

class JTableSystemrole extends JTable
{ 

	var $id									= null;
	
	var $name								= null;
			
	var $system_access						= null;
															
	var $can_see_private_objects			= null;
			
	var $can_assign							= null;
					
	var $can_be_assigned_leads				= null;
	
	var $can_be_assigned_tickets			= null;
	
	var $can_access_messages				= null;
	
	var $can_view_reports					= null;
	
	var $project							= null;
	
	var $lead								= null;
	
	var $person								= null;
	
	var $company							= null;
	
	var $campaign							= null;
	
	var $potential							= null;
	
	var $quote								= null;
	
	var $invoice							= null;
	
	var $ticket								= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_systemroles', 'id', $_db );
	}	
}