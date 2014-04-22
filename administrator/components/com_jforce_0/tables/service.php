<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			service.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableService extends JTable
{ 

	var $id					= null;
	
	var $name				= null;
			
	var $description		= null;
			
	var $price				= null;
						
	var $created			= null;
			
	var $modified			= null;
			
	var $author				= null;
			
	var $published			= null;
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_services', 'id', $_db );
	}	
}