<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class Tableigallery_rating extends JTable
{
	
	var $id = null;
	var $img_id = null;
	var $rating = null;
	var $ip = null;
	var $date = null;
	var $author = null;
	var $published = null;
	var $gallery_id = null;
	
	function Tableigallery_rating(& $db) 
	{
		parent::__construct('#__igallery_rating', 'id', $db);
	}

}
?>
