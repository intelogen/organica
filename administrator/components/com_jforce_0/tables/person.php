<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			person.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTablePerson extends JTable
{ 

	var $id						= null;
	
	var $uid					= null;
				
	var $company				= null;
	
	var $firstname				= null;
	
	var $lastname				= null;
			
	var $systemrole				= null;
	
	var $projectrole 			= null;
						
	var $image					= null;
			
	var $auto_add				= null;
			
	var $created				= null;
			
	var $modified				= null;
			
	var $author					= null;
	
	var $lead					= null;
	
	var $lead_company			= null;
	
	var $converted				= null;
	
	var $key					= null;
	
	var $published				= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_persons', 'id', $_db );
	}	
}