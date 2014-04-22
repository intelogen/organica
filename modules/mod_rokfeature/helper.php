<?php
/**
* @package RokFeature
* @copyright Copyright (C) 2007 RocketWerx. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');
jimport('joomla.utilities.date');

class modRokFeatureHelper
{
	function prepareContent( $text, $length=300 ) {
		// strips tags won't remove the actual jscript
		$text = preg_replace( "'<script[^>]*>.*?</script>'si", "", $text );
		$text = preg_replace( '/{.+?}/', '', $text);
		// replace line breaking tags with whitespace
		$text = preg_replace( "'<(br[^/>]*?/|hr[^/>]*?/|/(div|h[1-6]|li|p|td))>'si", ' ', $text );
		$text = strip_tags( $text );
		if (strlen($text) > $length) $text = substr($text, 0, $length) . "...";
		return $text;
	}	
	
	function setRotatorImages($text,&$item, &$params) {
	    $thumbfound = false;
	    $imagefound = false;
	    $blankimage = 'images/blank.png';
	    $showthumbs = $params->get('showthumbs',1);
	    
	    if ($showthumbs) {
            $regex = "#<!--THUMB\s(.*?)THUMB-->#s";
            preg_match( $regex, $text, $matches );
            if (sizeof($matches)==2) {
                $item->thumbimage = trim($matches[1]);
                $thumbfound = true;
            }
        }
        
        $regex = "#<!--IMAGE\s(.*?)IMAGE-->#s";
        preg_match( $regex, $text, $matches );
        if (sizeof($matches)==2) {
            $item->mainimage = trim($matches[1]);
            $imagefound = true;
        }
        
        if ($showthumbs and $imagefound and !$thumbfound) {
            // make a thumb
            $item->thumbimage = modRokFeatureHelper::getFeatureThumb($item->mainimage);
            $thumbfound = true;
        }
        
        if (!$imagefound) {
            //set to blank image
            $item->mainimage = $blankimage;
        }
        
        if (!$thumbfound) {
            // set to blank image
            $item->thumbimage = $blankimage;
        }
    }
    
    function getFeatureThumb($source_image, $xsize=65, $ysize=65, $reflections=false) {


		$paths = array();

		$image_path = $source_image;

		//joomla 1.5 only
		$full_url = JURI::base();
		
		//remove any protocol/site info from the image path
		$parsed_url = parse_url($full_url);
		
		$paths[] = $full_url;
		if (isset($parsed_url['path']) && $parsed_url['path'] != "/") $paths[] = $parsed_url['path'];
		
		
		foreach ($paths as $path) {
			if (strpos($image_path,$path) !== false) {
				$image_path = substr($image_path,strpos($image_path, $path)+strlen($path));
			}
		}
		
		// remove any / that begins the path
		if (substr($image_path, 0 , 1) == '/') $image_path = substr($image_path, 1);
		
		//if after removing the uri, still has protocol then the image
		//is remote and we don't support thumbs for external images
		if (strpos($image_path,'http://') !== false ||
			strpos($image_path,'https://') !== false) {
			return false;
		}
		
		// create a thumb filename
		$file_div = strrpos($image_path,'.');
		$thumb_ext = substr($image_path, $file_div);
		$thumb_prev = substr($image_path, 0, $file_div);
		$thumb_path = $thumb_prev . "_thumb" . $thumb_ext;

		// check to see if this file exists, if so we don't need to create it
		if (function_exists("gd_info") && !file_exists($thumb_path)) {
			// file doens't exist, so create it and save it
			if (!class_exists("Thumbnail")) {
			    include_once('thumbnail.inc.php');
		    }
			$thumb = new Thumbnail($image_path);
			
			if ($thumb->error) { 
				if (MININEWS_DEBUG)	echo "RokFeature ERROR: " . $thumb->errmsg . ": " . $image_path; 
				return false;
			}
			$thumb->resizePercent(25);
			$thumb->cropFromCenter($xsize);
			if ($reflections) {
				$thumb->createReflection(30,30,60,false);
			}
			if (!is_writable(dirname($thumb_path))) {
				$thumb->destruct();
				return false;
			}
			$thumb->save($thumb_path);
			$thumb->destruct();
		}
		return ($thumb_path);

	}
	
	function getList(&$params)
	{
		global $mainframe;

		$db			=& JFactory::getDBO();
		$user		=& JFactory::getUser();
		$userId		= (int) $user->get('id');

		$count		= $params->get('count',3);
		$catid		= trim( $params->get('catid') );
		$secid		= trim( $params->get('secid') );
		$show_front	= $params->get('show_front', 1);
		$aid		= $user->get('aid', 0);

		$textlength = intval($params->get( 'preview_count', 120) );

		$contentConfig = &JComponentHelper::getParams( 'com_content' );
		$access		= !$contentConfig->get('shownoauth');

		$nullDate	= $db->getNullDate();

		$date =& JFactory::getDate();
		$now	 = $date->toMySQL();

		$where		= 'a.state = 1'
			. ' AND ( a.publish_up = '.$db->Quote($nullDate).' OR a.publish_up <= '.$db->Quote($now).' )'
			. ' AND ( a.publish_down = '.$db->Quote($nullDate).' OR a.publish_down >= '.$db->Quote($now).' )'
			;

		// User Filter
		switch ($params->get( 'user_id' ))
		{
			case 'by_me':
				$where .= ' AND (created_by = ' . (int) $userId . ' OR modified_by = ' . (int) $userId . ')';
				break;
			case 'not_me':
				$where .= ' AND (created_by <> ' . (int) $userId . ' AND modified_by <> ' . (int) $userId . ')';
				break;
		}

		// Ordering
		switch ($params->get( 'ordering' ))
		{
			case 'm_dsc':
				$ordering		= 'a.modified DESC, a.created DESC';
				break;
			case 'c_dsc':
				$ordering		= 'a.created DESC';
				break;
			default:
				$ordering		= 'a.ordering ASC';
				break;
		}

        if ($show_front != 2) {
    		if ($catid)
    		{
    			$ids = explode( ',', $catid );
    			JArrayHelper::toInteger( $ids );
    			$catCondition = ' AND (cc.id=' . implode( ' OR cc.id=', $ids ) . ')';
    		}
    		if ($secid)
    		{
    			$ids = explode( ',', $secid );
    			JArrayHelper::toInteger( $ids );
    			$secCondition = ' AND (s.id=' . implode( ' OR s.id=', $ids ) . ')';
    		}
    	}

		// Content Items only
		$query = 'SELECT a.*, ' .
			' CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug,'.
			' CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(":", cc.id, cc.alias) ELSE cc.id END as catslug'.
			' FROM #__content AS a' .
			($show_front == '0' ? ' LEFT JOIN #__content_frontpage AS f ON f.content_id = a.id' : '') .
			($show_front == '2' ? ' INNER JOIN #__content_frontpage AS f ON f.content_id = a.id' : '') .
			' INNER JOIN #__categories AS cc ON cc.id = a.catid' .
			' INNER JOIN #__sections AS s ON s.id = a.sectionid' .
			' WHERE '. $where .' AND s.id > 0' .
			($access ? ' AND a.access <= ' .(int) $aid. ' AND cc.access <= ' .(int) $aid. ' AND s.access <= ' .(int) $aid : '').
			($catid && $show_front != 2 ? $catCondition : '').
			($secid && $show_front != 2 ? $secCondition : '').
			($show_front == '0' ? ' AND f.content_id IS NULL ' : '').
			' AND s.published = 1' .
			' AND cc.published = 1' .
			' ORDER BY '. $ordering;


		$db->setQuery($query, 0, $count);
		$rows = $db->loadObjectList();
		

		$i		= 0;
		$lists	= array();
		foreach ( $rows as $row )
		{
		    modRokFeatureHelper::setRotatorImages($row->introtext,$lists[$i],$params);
		    
		    
			$lists[$i]->link = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catslug, $row->sectionid));
			$lists[$i]->title = htmlspecialchars( $row->title );
			$lists[$i]->introtext = trim(modRokFeatureHelper::prepareContent($row->introtext, $textlength));
			$lists[$i]->date = new JDate( $row->created );
	
			$i++;
		}

		return $lists;
	}



}
