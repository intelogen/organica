<?php
defined('_JEXEC') or die('Restricted access');

class JTableMysurvreztemp extends JTable
{ 

	
	var $id                          = null;
	var $uid                     = null;
	var $pid                  = null;
        var $name                         = null;
        var $val                         = null;
        var $status                      = null;
        var $note                       = null;
        var $step                       = null;
        var $date                       = null;
        
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_my_temp_res', 'id', $_db );
                $this->date = date('Y-m-d G:i:s');
	}	
}