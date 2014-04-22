<?php

defined('_JEXEC') or die('Restricted access');

class JTableProject extends JTable
{ 

	var $id					= null;
	
	var $name				= null;
			
	var $description		= null;
			
	var $author				= null;
	
	var $leader				= null;
			
	var $company			= null;
						
	var $status				= null;
			
	var $image				= null;
	
	var $imagethumb			= null;
			
	var $created			= null;
	
	var $startson			= null;
			
	var $modified			= null;
			
	var $alertmessage		= null;
	
	var $key				= null;
	
	var $published			= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_projects', 'id', $_db );
	}	
}