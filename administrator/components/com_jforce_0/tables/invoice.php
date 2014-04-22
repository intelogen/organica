<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			invoice.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class JTableInvoice extends JTable
{ 

	var $id						= null;
	
	var $pid					= null;
			
	var $milestone				= null;
			
	var $checklist				= null;
	
	var $quote					= null;
	
	var $company				= null;
			
	var $name					= null;
			
	var $description			= null;
			
	var $validtill				= null;
	
	var $publishdate			= null;
			
	var $published				= null;
	
	var $visibility				= null;
			
	var $payment_method			= null;
			
	var $paid					= null;
			
	var $viewed					= null;
	
	var $subtotal				= null;
	
	var $discount				= null;
			
	var $tax					= null;
			
	var $total					= null;
			
	var $created				= null;
			
	var $modified				= null;
			
	var $author					= null;
	
	var $tags					= null;
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_invoices', 'id', $_db );
	}	
}