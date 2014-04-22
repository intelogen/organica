<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'base.php');

//this class extends the base model so we can acess the base functions from our view

class igalleryModeladd extends igalleryModelbase
{
	function __construct()
	{
		parent::__construct();
		global $mainframe;
	}
	
}	


?>

