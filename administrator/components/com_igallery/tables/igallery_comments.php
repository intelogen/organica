<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class Tableigallery_comments extends JTable
{
	
	var $id = null;
	var $img_id = null;
	var $text = null;
	var $ip = null;
	var $published = null;
	var $date = null;
	var $author = null;
	var $gallery_id = null;
	
	function Tableigallery_comments(& $db) 
	{
		parent::__construct('#__igallery_comments', 'id', $db);
	}

}
?>
