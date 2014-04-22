<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			customfield.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableCustomfield extends JTable
{ 

	var $id				= null;
	
	var $field			= null;
	
	var $fieldtype		= null;
			
	var $values			= null;
			
	var $type			= null;
	
	var $required		= null;
			
	var $public			= null;
	
	var $published		= null;
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_customfields', 'id', $_db );
	}	
}