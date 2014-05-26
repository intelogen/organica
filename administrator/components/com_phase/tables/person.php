<?php
defined('_JEXEC') or die('Restricted access');

class JTablePerson extends JTable
{ 

	var $id                                 = null;
	
	var $uid				= null;
				
	var $company				= null;
	
	var $firstname				= null;
	
	var $lastname				= null;
			
	var $systemrole				= null;
	
	var $projectrole 			= null;
						
	var $image				= null;
			
	var $auto_add				= null;
			
	var $created				= null;
			
	var $modified				= null;
			
	var $author				= null;
	
	var $lead				= null;
	
	var $lead_company			= null;
	
	var $converted				= null;
	
	var $key				= null;
	
	var $published				= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_persons', 'id', $_db );
	}	
}