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

class JTableAccessrole extends JTable
{ 

	var $id									= null;
	
	var $uid								= null;
	
	var $role								= null;
	
	var $name								= null;
			
	var $system_access						= 0;
															
	var $can_see_private_objects			= 0;
			
	var $can_assign							= 0;
					
	var $can_be_assigned_leads				= 0;
	
	var $can_be_assigned_tickets			= 0;
	
	var $can_access_messages				= 0;
	
	var $can_view_reports					= 0;
	
	var $project							= 0;
	
	var $lead								= 0;
	
	var $person								= 0;
	
	var $company							= 0;
	
	var $campaign							= 0;
	
	var $potential							= 0;
	
	var $global_quote						= 0;
	
	var $global_invoice						= 0;
	
	var $global_ticket						= 0;
	
	var $milestone							= 0;
				
	var $checklist							= 0;
			
	var $timetracker						= 0;
			
	var $document							= 0;
			
	var $ticket								= 0;
			
	var $discussion							= 0;
	
	var $quote								= 0;
	
	var $invoice							= 0;			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_accessroles', 'id', $_db );
	}	
}