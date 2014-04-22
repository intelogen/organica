<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			comment.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access

defined('_JEXEC') or die('Restricted access');

class JTableComment extends JTable
{ 

	var $id				= null;
	
	var $discussion		= null;
	
	var $ticket			= null;
			
	var $document		= null;
	
	var $quote			= null;
	
	var $invoice		= null;
	
	var $campaign		= null;
	
	var $potential		= null;
	
	var $pid			= null;
			
	var $message		= null;
			
	var $created		= null;
			
	var $modified		= null;
			
	var $author			= null;
			
	var $published		= null;
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_comments', 'id', $_db );
	}	
}