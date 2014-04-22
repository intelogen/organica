<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			subscription.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableSubscription extends JTable
{ 

	var $id						= null;

	var $uid					= null;
	
	var $project				= null;
			
	var $milestone				= null;
			
	var $discussion				= null;
			
	var $document				= null;
	
	var $ticket					= null;
	
	var $task					= null;
	
	var $checklist				= null;
	
	var $quote					= null;
	
	var $invoice				= null;
	
	var $assignment				= null;
	
	var $primary				= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_subscriptions', 'id', $_db );
	}	
}