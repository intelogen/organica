<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_igallery'.DS.'models'.DS.'base.php');

class igalleryModelgallery extends igalleryModelbase
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
	
	function getId()
	{
	 	return $this->_id;
	}
	
	function getAid()
	{
		$user   =& JFactory::getUser();
	 	$this->_aid = (int)$user->get('aid', 0);
	 	return $this->_aid;
	}
	
	function getGallery()
	{
		$query = 'SELECT * FROM #__igallery WHERE id = '. intval($this->_id);
		$this->_db->setQuery($query);
		$this->_gallery = $this->_db->loadObject();
		return  $this->_gallery;
	}
	
	function getPhotoList()
	{
		$query = 'SELECT * FROM #__igallery_img WHERE gallery_id = '.intval($this->_id). 
		' AND published = 1 AND access <= '.intval($this->_aid).' ORDER BY ordering';
		$this->_db->setQuery($query);
		$this->_photoList = $this->_db->loadObjectList();
		return  $this->_photoList;
	}
	
	function getGalleries()
	{
		$query = 'SELECT * FROM #__igallery WHERE published = 1 AND type = 1 AND parent = '
		.intval($this->_gallery->parent).' ORDER BY ordering';
		$this->_db->setQuery($query);
		$this->_galleries = $this->_db->loadObjectList();
		return  $this->_galleries;
	}
	
	function getCommentsList()
	{
		$query = '
		SELECT #__igallery_img.id,
		#__igallery_comments.img_id,
		#__igallery_comments.text,
		#__igallery_comments.date,
		#__igallery_comments.author
		FROM `#__igallery_img` INNER JOIN #__igallery_comments 
		ON #__igallery_img.id = #__igallery_comments.img_id
		WHERE #__igallery_img.access <= '.intval($this->_aid).
		' AND #__igallery_img.published =1 AND #__igallery_comments.published =1 
		ORDER BY #__igallery_comments.date';
			
		$this->_db->setQuery($query);
		$this->_commentsList = $this->_db->loadObjectList();
		return  $this->_commentsList;
	}
	
	function getRatingsList()
	{
		$query = '
		SELECT #__igallery_img.id,
		#__igallery_rating.img_id,
		#__igallery_rating.rating,
		#__igallery_rating.author
		FROM `#__igallery_img` INNER JOIN #__igallery_rating 
		ON #__igallery_img.id = #__igallery_rating.img_id
		WHERE #__igallery_img.access <= '.intval($this->_aid).
		' AND #__igallery_img.published =1 AND #__igallery_rating.published =1';
			
		$this->_db->setQuery($query);
		$this->_ratingsList = $this->_db->loadObjectList();
		return  $this->_ratingsList;
	}
	
}	
?>