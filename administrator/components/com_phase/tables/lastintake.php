<?php
defined('_JEXEC') or die('Restricted access');

class JTableLastintake extends JTable
{ 

	
	var $id                          = null;
	var $uid                         = null;
	var $pid                         = null;
        var $name                        = null;
        var $val                         = null;
        var $status                      = null;
        var $note                        = null;
        var $step                        = null;
        var $date                        = null;
        
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_my_lastintake', 'id', $_db );
                
	}	
}