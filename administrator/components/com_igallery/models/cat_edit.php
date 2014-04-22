<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'base.php');

class igalleryModelcat_edit extends igalleryModelbase
{
	var $_id = null;

	function __construct()
	{
		parent::__construct();

		global $mainframe;
		
		$cid = JRequest::getVar('cid',  array(0), '', 'array');
		
		$this->setValues($cid[0]);
	}
	
	function setValues($id)
	{
		$this->_id = (int)$id;
	}
	
	function getCat()
	{
		$query = 'SELECT * FROM #__igallery WHERE id = '. intval($this->_id);
		$this->_db->setQuery($query);
		$this->_cat = $this->_db->loadObject();
		return  $this->_cat;
	}
	
}	


?>

