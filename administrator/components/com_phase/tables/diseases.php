<?php
defined('_JEXEC') or die('Restricted access');

class JTableDiseases extends JTable
{ 

	
	var $id                          = null;
	var $name                        = null;
	var $owner                       = null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_my_diseases', 'id', $_db );
	}	
}