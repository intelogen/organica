<?php
defined('_JEXEC') or die('Restricted access');

class JTableSymptoms extends JTable
{ 

	
	var $id                          = null;
	var $name                        = null;
	var $owner                       = null;

	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_my_symptoms', 'id', $_db );
	}	
}