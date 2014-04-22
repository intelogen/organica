<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			message.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableMessage extends JTable
{ 

	var $id				= null;
	
	var $to				= null;
			
	var $from			= null;
			
	var $subject		= null;
			
	var $body			= null;
						
	var $created		= null;
									
	var $published		= null;
	
	var $read			= null;
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_messages', 'id', $_db );
	}	
}