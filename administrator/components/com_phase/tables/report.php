<?php
defined('_JEXEC') or die('Restricted access');

class JTableReport extends JTable
{ 

	
	var $id                           = null;
	var $pid                          = null;
	var $bodyscore                    = null;
        var $fat                          = null;
        var $photo                        = null;
        var $symptoms                     = null;
        var $medtrack                     = null;
        var $diseases                     = null;
        var $time                         = null;
        
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_my_survay_report', 'id', $_db );
	}	
}

