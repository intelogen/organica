<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			objectstatus.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableObjectStatus extends JTable
{ 

	var $id				= null;
	
	var $uid			= null;
			
	var $object			= null;
			
	var $type			= null;

	function __construct( &$_db )
	{
		parent::__construct( '#__jf_objectviews', 'id', $_db );
	}	
}