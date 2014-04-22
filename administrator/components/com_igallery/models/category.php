<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'base.php');

class igalleryModelcategory extends igalleryModelbase
{
	function __construct()
	{
		parent::__construct();

		global $mainframe;
		
		$id = JRequest::getInt('id', 0);
		
		$this->setValues($id);
	}
	
	function setValues($id)
	{
		$this->_id = (int)$id;
	}
	
	function getAid()
	{
		$user   =& JFactory::getUser();
	 	$this->_aid = (int)$user->get('aid', 0);
	 	return $this->_aid;
	}
	
	function getCategory()
	{
		//if the top category has been linked to
		if($this->_id == 0)
		{
			$this->_category = new stdClass();
			$this->_category->id = 0;
	 		$this->_category->access = 0;
	 		$this->_category->published = 1;
	 		$this->_category->show_cat_menu = 0;
	 		
	 		$configArray =& JComponentHelper::getParams( 'com_igallery' );
			$this->_category->columns = $configArray->get('cat_menu_columns', 2);
		}
		else
		{
			$query = 'SELECT * FROM #__igallery WHERE id = '. intval($this->_id);
			$this->_db->setQuery($query);
			$this->_category = $this->_db->loadObject();
		}
		return  $this->_category;
	}
	
	function getChildCats()
	{
		$query = 'SELECT * FROM #__igallery WHERE parent = '. $this->_id .
		' AND type = 0 AND published = 1 AND access <= '.intval($this->_aid).' ORDER BY ordering';
		$this->_db->setQuery($query);
		$this->_childCats = $this->_db->loadObjectList();
		return  $this->_childCats;
	}
	
	function getChildGalleries()
	{
		$query = 'SELECT * FROM #__igallery WHERE parent = '.$this->_id.
		' AND type = 1 AND published = 1 AND menu_access <= '.intval($this->_aid).' ORDER BY ordering';
		$this->_db->setQuery($query);
		$this->_childGalleries = $this->_db->loadObjectList();
		return  $this->_childGalleries;
	}
	
	function getParentCats()
	{
		$query = 'SELECT * FROM #__igallery WHERE parent = '.intval($this->_category->parent).
		' AND type = 0 AND published = 1 AND access <= '.intval($this->_aid).' ORDER BY ordering';
		$this->_db->setQuery($query);
		$this->_parentCat = $this->_db->loadObjectList();
		return  $this->_parentCat;
	}
	
}	
?>