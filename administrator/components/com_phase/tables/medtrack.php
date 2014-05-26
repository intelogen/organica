<?php
defined('_JEXEC') or die('Restricted access');

class JTableMedtrack extends JTable
{ 

	
	var $id                          = null;
	var $name                    = null;
	var $owner                       = null;

	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_my_medtrack', 'id', $_db );
	}	
}

