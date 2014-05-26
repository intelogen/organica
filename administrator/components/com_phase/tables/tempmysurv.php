<?php
defined('_JEXEC') or die('Restricted access');

class JTableTempmysurv extends JTable
{ 

	
	var $id                          = null;
	var $user_id                     = null;
	var $project_id                  = null;
        var $cat                         = null;
        var $val                         = null;
        var $status                      = "new";
        var $notes                       = null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_my_temp_survay', 'id', $_db );
	}	
}