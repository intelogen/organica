<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'base.php');

class manageModeledit_photo extends igalleryModelbase
{
	var $_id = null;

	function __construct()
	{
		parent::__construct();

		global $mainframe;
		
		$cid = JRequest::getVar('cid',  array(0), '', 'array');
		$gid = JRequest::getInt('gid', 0);
		$this->setValues($cid[0], $gid);
	}
	
	function setValues($id, $gid)
	{
		$this->_id = (int)$id;
		$this->_gid = (int)$gid;
	}
	
	function getGallery()
	{
		$query = 'SELECT * FROM #__igallery WHERE id = '. (int)$this->_gid;
		$this->_db->setQuery($query);
		$this->_gallery = $this->_db->loadObject();
		return  $this->_gallery;
	}
	
	function getPhoto()
	{
		$query = 'SELECT * FROM #__igallery_img WHERE id = '. (int)$this->_id;
		$this->_db->setQuery($query);
		$this->_photo = $this->_db->loadObject();
		return  $this->_photo;
	}
}