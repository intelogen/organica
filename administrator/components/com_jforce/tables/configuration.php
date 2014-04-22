<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			configuration.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableConfiguration extends JTable
{ 

	var $id						= null;

	var $status					= null;
	
	var $priority				= null;
							
	var $supportcategories		= null;

	var $quotetemplate			= null;
	
	var $tax					= null;
	
	var $tax_enabled			= null;
	
	var $currency				= null;
	
	var $emailsubject			= null;
	
	var $emailbody				= null;

	var $generalcategories		= null;
	
	var $invoicetemplate		= null;
	
	var $showhelp				= null;
	
	var $sales_stages			= null;
	
	var $lead_status			= null;
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_configuration', 'id', $_db );
	}	
}