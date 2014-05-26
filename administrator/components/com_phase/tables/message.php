<?php
defined('_JEXEC') or die('Restricted access');

class JTableMessage extends JTable
{ 


	var $id					= null;
	
	var $mto				= null;
			
	var $mfrom              		= null;
			
	var $subject                            = null;
			
	var $body                               = null;
			
	var $created                            = null;
			
	var $mread				= null;
			
	var $published                          = null;
	
	var $deleted_by                     	= null;
			
	
        
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_messages', 'id', $_db );
                $this->created = date('Y-m-d G:i:s');
	}	
}
?>