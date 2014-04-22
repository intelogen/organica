<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			gateway.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTablePlugin extends JTable
{ 

	var $id					= null;
	
	var $name				= null;
			
	var $author				= null;
	
	var $authoremail		= null;
	
	var $authorurl			= null;
	
	var $version			= null;
	
	var $copyright			= null;
	
	var $license			= null;
	
	var $creationdate		= null;
			
	var $published			= null;
			
	var $default			= null;
			
	var $folder				= null;
	
	var $link				= null;
			
	var $params				= null;
	
	var $type				= null;
	
	var $ordering			= null;
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_plugins', 'id', $_db );
	}	
}