<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			lead.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableLead extends JTable
{ 

	var $id						= null;
						
	var $firstname				= null;
	
	var $lastname				= null;
	
	var $address				= null;
			
	var $company				= null;
	
	var $email		 			= null;
						
	var $office_phone			= null;
			
	var $home_phone				= null;
			
	var $cell_phone				= null;
	
	var $status					= null;
	
	var $source					= null;
	
	var $do_not_contact			= null;
	
	var $converted				= null;
	
	var $created				= null;
			
	var $modified				= null;
			
	var $author					= null;
				
	var $published				= null;
	
	var $manager				= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_leads', 'id', $_db );
	}	
}