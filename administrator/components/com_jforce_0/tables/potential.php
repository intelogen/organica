<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			potential.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTablePotential extends JTable
{ 

	var $id					= null;
			
	var $name				= null;
	
	var $description		= null;
			
	var $lead				= null;
			
	var $company			= null;
			
	var $campaign			= null;
			
	var $closedate			= null;
						
	var $nextstep			= null;
	
	var $salesstage			= null;
	
	var $probability		= null;
	
	var $amount				= null;

	var $tags				= null;

	var $created			= null;
			
	var $modified			= null;
			
	var $author				= null;
			
	var $published			= null;
	
	var $visibility			= null;
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_potentials', 'id', $_db );
	}	
}