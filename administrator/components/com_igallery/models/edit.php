<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'base.php');

class igalleryModeledit extends igalleryModelbase
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
	
	function getGallery()
	{
		$query = 'SELECT * FROM #__igallery WHERE id = '. $this->_id;
		$this->_db->setQuery($query);
		$this->_gallery = $this->_db->loadObject();
		return  $this->_gallery;
	}
}