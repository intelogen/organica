<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'base.php');

class ratingModelrating extends igalleryModelbase
{
	var $_ratingList = null;
	var $_total = null;
	var $_pagination = null;

	function __construct()
	{
		parent::__construct();

		global $mainframe, $option; 
		
		//get the two vars for pagination
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $option.'.rating.limitstart', 'limitstart', 0, 'int' );
		
		//set the pagination vars
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
		
		$cid = JRequest::getVar('cid',  array(0), '', 'array');
		
		//get the value sent through from the select gallery drop down list
		$selectGallery = JRequest::getInt('select_gallery', NULL);
		
		$this->setValues($cid, $selectGallery);
	}
	
	function setValues($cid, $selectGallery)
	{
		$this->_cid = $cid;
		JArrayHelper::toInteger($this->_cid);
		
		$this->_selectGallery = (int)$selectGallery;
	}
	
	function getRatingList()
	{
		if (empty($this->_ratingList))
		{
			$query = $this->_buildQuery();
			$this->_ratingList = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		return $this->_ratingList;
	}
	
	function _buildQuery()
	{
		if($this->_selectGallery != NULL)
		{
			$where = 'WHERE gallery_id = '.$this->_selectGallery;
		}
		else
		{
			$where = '';
		}
		
		$orderby = $this->_buildContentOrderBy();

		$query = 'SELECT * from #__igallery_rating '.$where.' '.$orderby;
		return $query;
	}
	
	function _buildContentOrderBy()
	{
		global $mainframe, $option;
		
		$filter_order     = $mainframe->getUserStateFromRequest( $option.'rating.filter_order',      'filter_order', 'date', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'rating.filter_order_Dir',  'filter_order_Dir', '', 'word' );
		$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir;			
		return $orderby;
	}
	
	function getTotal()
	{
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}
	
	function getPagination()
	{
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	function getPhotoList()
	{
		$query = 'SELECT * FROM #__igallery_img';
		$this->_db->setQuery($query);
		$this->_photoList = $this->_db->loadObjectList();
		return  $this->_photoList;
	}
	
	function getGalleryList()
	{
		$query = 'SELECT * FROM #__igallery';
		$this->_db->setQuery($query);
		$this->_galleryList = $this->_db->loadObjectList();
		return  $this->_galleryList;
	}
	
	function delete($post)
	{
		$cids = implode( ',', $this->_cid );
		$query = 'DELETE FROM #__igallery_rating WHERE id IN ( '.$cids.' )';
		$this->_db->setQuery($query);
		if(!$this->_db->query()) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}
		return true;
		
	}
	
	function getSelectList()
	{
		//get all the galleries
		$query = "SELECT * FROM #__igallery WHERE type = 1 ORDER BY parent, ordering";
	    $this->_db->setQuery($query);
	    $galleries = $this->_db->loadObjectList();
		
	  	//add in a top option asking to select an option
		array_unshift($galleries, JHTML::_('select.option', '0', '- '.JText::_('SELECT GALLERY').' -', 'id', 'name'));
		
		$javascript = 'class="inputbox" size="1" onchange="document.adminForm.submit();"';
		
		//make the select list
	    $selectList = JHTML::_("select.genericlist", $galleries, 'select_gallery', $javascript, 'id', 'name' );
	
	    return $selectList;
	}
	
	
}	


?>

