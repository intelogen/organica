<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			checklist.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableCampaign extends JTable
{ 

	var $id					= null;
	
	var $name				= null;
			
	var $status				= null;
			
	var $expectedclose		= null;
			
	var $type				= null;
			
	var $audience			= null;
			
	var $sponsor			= null;
			
	var $reach				= null;
	
	var $ecost				= null;
			
	var $acost				= null;
			
	var $eresponse			= null;
			
	var $aresponse			= null;
			
	var $erevenue			= null;
			
	var $arevenue			= null;
			
	var $eroi				= null;
			
	var $aroi				= null;
	
	var $description		= null;
	
	var $tags				= null;
	
	var $published			= null;
	
	var $visibility			= null;
	
	var $author				= null;
	
	var $created			= null;
	
	var $modified			= null;
			
	var $attachments		= null;
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_campaigns', 'id', $_db );
	}	
}