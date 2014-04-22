<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			ticket.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableTicket extends JTable
{ 

	var $id				= null;
	
	var $pid			= null;
			
	var $summary		= null;
			
	var $description	= null;
			
	var $attachment		= null;
			
	var $category		= null;
			
	var $milestone		= null;
			
	var $priority		= null;
				
	var $resolved		= null;
			
	var $duedate		= null;
			
	var $created		= null;
			
	var $modified		= null;
			
	var $author	    	= null;
			
	var $published		= null;
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_tickets', 'id', $_db );
	}	
}