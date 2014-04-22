<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			project.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access

defined('_JEXEC') or die('Restricted access');

class JTableBasic extends JTable
{ 

	var $id					= null;
	
	var $name				= null;
			
	var $description		= null;
			
	var $author				= null;
	
	var $leader				= null;
			
	var $company			= null;
						
	var $status				= null;
			
	var $image				= null;
	
	var $imagethumb			= null;
			
	var $created			= null;
	
	var $startson			= null;
			
	var $modified			= null;
			
	var $alertmessage		= null;
	
	var $key				= null;
	
	var $published			= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_projects', 'id', $_db );
	}	
}