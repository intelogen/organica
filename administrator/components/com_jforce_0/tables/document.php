<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			document.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableDocument extends JTable
{ 

	var $id					= null;
	
	var $pid				= null;
			
	var $name				= null;
			
	var $description		= null;
			
	var $visibility			= null;
		
	var $category			= null;
			
	var $milestone			= null;
			
	var $discussion			= null;
			
	var $comment			= null;
	
	var $ticket				= null;
	
	var $attachment			= null;
			
	var $tags				= null;
						
	var $created			= null;
			
	var $modified			= null;
			
	var $author				= null;
	
	var $published			= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_documents', 'id', $_db );
	}	
}