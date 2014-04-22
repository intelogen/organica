<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			servicecf.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableServicecf extends JTable
{ 

	var $id					= null;
	
	var $service			= null;
			
	var $quote				= null;
			
	var $invoice			= null;
			
	var $quantity			= null;
			
	var $subtotal			= null;
	
	var $price				= null;
			
	var $tax				= null;
			
	var $total				= null;
	
	var $discount			= null;
	
	var $discount_type		= null;
	
	var $description		= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_services_cf', 'id', $_db );
	}	
}