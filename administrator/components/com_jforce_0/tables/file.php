<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			file.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableFile extends JTable
{ 

	var $id					= null;
	
	var $pid				= null;
	
	var $document			= null;
			
	var $filelocation		= null;
			
	var $filetype			= null;
			
	var $filesize			= null;
	
	var $image				= null;
			
	var $name				= null;
			
	var $version			= null;
			
	var $created			= null;
			
	var $modified			= null;
			
	var $author				= null;
	
	var $published			= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_files', 'id', $_db );
	}	
}