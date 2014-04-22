<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_igallery'.DS.'helpers'.DS.'file.php');
include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_igallery'.DS.'helpers'.DS.'tree.php');
include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_igallery'.DS.'helpers'.DS.'static.php');

/*
-------------
 Joomla 1.5
-------------
*/

if(!version_compare(JVERSION,'1.6.0','ge')) {
  $mainframe->registerEvent( 'onSearch', 'plgSearchIgallery' );
  $mainframe->registerEvent( 'onSearchAreas', 'plgSearchIgalleryAreas' );
}

function &plgSearchIgalleryAreas() {
	static $areas = array(
		'igallery' => 'Ignite Gallery'
	);
	return $areas;
}


function plgSearchIgallery($text, $phrase='', $ordering='', $areas=null)
{
	$db		=& JFactory::getDBO();
	$user	=& JFactory::getUser();
	jimport('joomla.filesystem.file');
	include(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_igallery'.DS.'helpers'.DS.'html.php');

	$searchText = $text;

	if( is_array($areas) ) 
	{
		if( !array_intersect($areas, array_keys( plgSearchIgalleryAreas() ) ) ) 
		{
			return array();
		}
	}
	
 	$plugin =& JPluginHelper::getPlugin('search', 'igallery');
 	$pluginParams = new JParameter($plugin->params);

	$limit = $pluginParams->def('search_limit', 50);

	$text = trim($text);
	if ($text == '') 
	{
		return array();
	}
	
	$section = JText::_( 'IGNITE GALLERY' );

	$wheres = array();
	
	//search photos part
	switch ($phrase)
	{
		case 'exact':
			$text		= $db->Quote('%'.$db->getEscaped($text, true).'%', false);
			$wheres2 	= array();
			$wheres2[] 	= 'i.tags LIKE '.$text;
			$wheres2[] 	= 'i.description LIKE '.$text;
			$wheres2[] 	= 'i.alt_text LIKE '.$text;
			$wheres2[] 	= 'i.filename LIKE '.$text;
			$where 		= '('.implode(') OR (', $wheres2 ).')';
			break;

		case 'all':
		case 'any':
		default:
			$words 	= explode( ' ', $text );
			$wheres = array();
			foreach ($words as $word)
			{
				$word		= $db->Quote( '%'.$db->getEscaped($word, true).'%', false );
				$wheres2 	= array();
				$wheres2[] 	= 'i.tags LIKE '.$word;
				$wheres2[] 	= 'i.description LIKE '.$word;
				$wheres2[] 	= 'i.alt_text LIKE '.$word;
				$wheres2[] 	= 'i.filename LIKE '.$word;
				$wheres[] 	= implode( ' OR ', $wheres2 );
			}
			$where 	= '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
			break;
	}
	
	switch ($ordering)
	{
		case 'oldest':
			$order = 'i.date ASC';
			break;

		case 'popular':
			$order = 'i.hits DESC';
			break;

		case 'alpha':
			$order = 'i.filename ASC';
			break;

		case 'newest':
		case 'category':
		default:
			$order = 'i.date DESC';
	}
	
	$query = 'SELECT '.
	'i.*, '.
	'c.name, '.
	'p.thumb_pagination, p.thumb_pagination_amount '.
	'FROM #__igallery_img AS i '.
	'INNER JOIN #__igallery AS c ON c.id = i.gallery_id '.
	'INNER JOIN #__igallery_profiles AS p ON p.id = c.profile '.
	'WHERE ('. $where .') AND i.published = 1 '. 
	'AND i.access <= '.(int)$user->get( 'aid' ) . ' ORDER BY '. $order;
	$db->setQuery($query, 0, $limit);
	$rows = $db->loadObjectList();	

	$results = array();
	$counter = 0;
	
	for($i=0; $i<count($rows); $i++) 
	{
	    $row =& $rows[$i];
		
		$limitStart = '';
		if($row->thumb_pagination == 1)
		{
			if($row->ordering > $row->thumb_pagination_amount)
			{
				$group = ceil( $row->ordering / $row->thumb_pagination_amount ) - 1;
				
				if($group > 0)
				{
					$limitStart = '&limitstart='.($group * $row->thumb_pagination_amount);
					$remainder = $row->ordering - ($group * $row->thumb_pagination_amount);
					$row->ordering = $remainder == 0 ? 1 : $remainder;
				}
			}
		}
		
	    $results[$counter]->href = JRoute::_('index.php?option=com_igallery&view=igcategory&id='.$row->gallery_id.'&image='.$row->ordering.'&Itemid='.igHtmlHelper::getItemid($row->gallery_id).$limitStart);
	    $results[$counter]->title  = strlen($row->alt_text) > 0 ? $row->alt_text : substr($row->filename, 0, strrpos($row->filename, '-')).'.'.JFile::getExt($row->filename);
	    $results[$counter]->text = 'igalleryimg '.$row->id.' &nbsp;&nbsp;&nbsp;'.$row->description;
	    $results[$counter]->created = null;
	    $results[$counter]->browsernav = 0;
			$increment = igFileHelper::getIncrementFromFilename($row->filename);
      $folderName = igFileHelper::getFolderName($increment);
			$results[$counter]->image = JUri::Root()."images/igallery/original/".$folderName."/".$row->filename;
		$results[$counter]->section = $row->name;
	    
	    $counter ++;
	}
	
	//search categories part	
	switch ($phrase)
	{
		case 'exact':
			$text		= $db->Quote('%'.$db->getEscaped($text, true).'%', false);
			$wheres2 	= array();
			$wheres2[] 	= 'name LIKE '.$text;
			$wheres2[] 	= 'menu_description LIKE '.$text;
			$wheres2[] 	= 'gallery_description LIKE '.$text;
			$where 		= '('.implode(') OR (', $wheres2 ).')';
			break;

		case 'all':
		case 'any':
		default:
			$words 	= explode( ' ', $text );
			$wheres = array();
			foreach ($words as $word)
			{
				$word		= $db->Quote( '%'.$db->getEscaped($word, true).'%', false );
				$wheres2 	= array();
				$wheres2[] 	= 'name LIKE '.$word;
				$wheres2[] 	= 'menu_description LIKE '.$word;
				$wheres2[] 	= 'gallery_description LIKE '.$word;
				$wheres[] 	= implode( ' OR ', $wheres2 );
			}
			$where 	= '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
			break;
	}
	
	switch ($ordering)
	{
		case 'oldest':
			$order = 'date ASC';
			break;

		case 'popular':
			$order = 'hits DESC';
			break;

		case 'alpha':
			$order = 'name ASC';
			break;

		case 'newest':
		case 'category':
		default:
			$order = 'date DESC';
	}

	$query = 'SELECT * from #__igallery WHERE ('. $where .') AND published = 1 ORDER BY '. $order;
	$db->setQuery($query, 0, $limit);
	$rows = $db->loadObjectList();
	
	
	for($i=0; $i<count($rows); $i++) 
	{
	    $row =& $rows[$i];
		
	    $results[$counter]->href = JRoute::_('index.php?option=com_igallery&view=igcategory&id='.$row->id.'&Itemid='.igHtmlHelper::getItemid($row->id));
	    $results[$counter]->title  = $row->name;
	    $results[$counter]->text = strlen($row->gallery_description) > 0 ? $row->gallery_description : $row->menu_description;
	    $results[$counter]->created = null;
	    $results[$counter]->browsernav = 0;
	    $results[$counter]->browsernav = 0;
	    if ($row->menu_image_filename!="") {
  			$increment = igFileHelper::getIncrementFromFilename($row->menu_image_filename);
	      $folderName = igFileHelper::getFolderName($increment);
			  $results[$counter]->image = JUri::Root()."images/igallery/original/".$folderName."/".$row->menu_image_filename;
      }			    
	    $query = 'SELECT name from #__igallery WHERE id = '.(int)$row->parent;
	    $db->setQuery($query);
	    $parentRow = $db->loadObject();
	    
	    $results[$counter]->section = @$parentRow->name;
	    
	    $counter ++;
	}
	return $results;
}

/*
-------------
 Joomla 1.7+
-------------
*/

class plgSearchIgallery extends JPlugin
{
	
	function onContentSearchAreas()
	{
		static $areas = array('igallery' => 'Ignite Gallery');
		return $areas;
	}


	function onContentSearch($text, $phrase='', $ordering='', $areas=null)
	{
		$db		=& JFactory::getDBO();
		$user	= JFactory::getUser();
		$groups	= implode(',', $user->authorisedLevels() );
		jimport('joomla.filesystem.file');
		include(JPATH_SITE.DS.'components'.DS.'com_igallery'.DS.'helpers'.DS.'utility.php');
	
		$searchText = $text;
	
		if (is_array($areas)) {
			if (!array_intersect($areas, array_keys($this->onContentSearchAreas()))) {
				return array();
			}
		}
		
	 	$limit			= $this->params->def('search_limit',		50);
	
		$text = trim($text);
		if ($text == '') 
		{
			return array();
		}
		
		$section = JText::_( 'IGNITE_GALLERY' );
	
		$wheres = array();
		
		//search photos part
		switch ($phrase)
		{
			case 'exact':
				$text		= $db->Quote('%'.$db->getEscaped($text, true).'%', false);
				$wheres2 	= array();
				$wheres2[] 	= 'i.tags LIKE '.$text;
				$wheres2[] 	= 'i.description LIKE '.$text;
				$wheres2[] 	= 'i.alt_text LIKE '.$text;
				$wheres2[] 	= 'i.filename LIKE '.$text;
				$where 		= '('.implode(') OR (', $wheres2 ).')';
				break;
	
			case 'all':
			case 'any':
			default:
				$words 	= explode( ' ', $text );
				$wheres = array();
				foreach ($words as $word)
				{
					$word		= $db->Quote( '%'.$db->getEscaped($word, true).'%', false );
					$wheres2 	= array();
					$wheres2[] 	= 'i.tags LIKE '.$word;
					$wheres2[] 	= 'i.description LIKE '.$word;
					$wheres2[] 	= 'i.alt_text LIKE '.$word;
					$wheres2[] 	= 'i.filename LIKE '.$word;
					$wheres[] 	= implode( ' OR ', $wheres2 );
				}
				$where 	= '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
				break;
		}
		
		switch ($ordering)
		{
			case 'newest':
				$order = 'i.date DESC';
				break;
			
			case 'oldest':
				$order = 'i.date ASC';
				break;
	
			case 'popular':
				$order = 'i.hits DESC';
				break;
	
			case 'alpha':
				$order = 'i.filename ASC';
				break;
			
			case 'category':
				$order = 'i.gallery_id';
				break;
	
			default:
				$order = 'i.date DESC';
		}
		
		$query = 'SELECT '.
		'i.*, '.
		'c.name, '.
		'p.thumb_pagination, p.thumb_pagination_amount '.
		'FROM #__igallery_img AS i '.
		'INNER JOIN #__igallery AS c ON c.id = i.gallery_id '.
		'INNER JOIN #__igallery_profiles AS p ON p.id = c.profile '.
		'WHERE ('. $where .') AND i.published = 1 '. 
		'AND i.access IN ('.$groups.') ORDER BY '. $order;

		$db->setQuery($query, 0, $limit);
		$rows = $db->loadObjectList();
		
		$results = array();
		$counter = 0;
		
		for($i=0; $i<count($rows); $i++) 
		{
		    $row =& $rows[$i];
			
			$limitStart = '';
			if($row->thumb_pagination == 1)
			{
				if($row->ordering > $row->thumb_pagination_amount)
				{
					$group = ceil( $row->ordering / $row->thumb_pagination_amount ) - 1;
					
					if($group > 0)
					{
						$limitStart = '&limitstart='.($group * $row->thumb_pagination_amount);
						$remainder = $row->ordering - ($group * $row->thumb_pagination_amount);
						$row->ordering = $remainder == 0 ? 1 : $remainder;
					}
				}
			}

		    $results[$counter]->href = JRoute::_('index.php?option=com_igallery&view=category&igid='.$row->gallery_id.'&image='.$row->ordering.'&Itemid='.igUtilityHelper::getItemid($row->gallery_id).$limitStart);
		    $results[$counter]->title  = strlen($row->alt_text) > 0 ? $row->alt_text : substr($row->filename, 0, strrpos($row->filename, '-')).'.'.JFile::getExt($row->filename);
		    $results[$counter]->text = 'igalleryimg '.$row->id.' &nbsp;&nbsp;'.$row->description;
		    $results[$counter]->created = $row->date;
		    $results[$counter]->browsernav = 0;
  			$results[$counter]->section = $row->name;
  			$increment = igFileHelper::getIncrementFromFilename($row->filename);
	      $folderName = igFileHelper::getFolderName($increment);
  			$results[$counter]->image = JUri::Root()."images/igallery/original/".$folderName."/".$row->filename;		    
		  	$counter ++;
		}
		
		//search categories part	
		switch ($phrase)
		{
			case 'exact':
				$text		= $db->Quote('%'.$db->getEscaped($text, true).'%', false);
				$wheres2 	= array();
				$wheres2[] 	= 'name LIKE '.$text;
				$wheres2[] 	= 'menu_description LIKE '.$text;
				$wheres2[] 	= 'gallery_description LIKE '.$text;
				$where 		= '('.implode(') OR (', $wheres2 ).')';
				break;
	
			case 'all':
			case 'any':
			default:
				$words 	= explode( ' ', $text );
				$wheres = array();
				foreach ($words as $word)
				{
					$word		= $db->Quote( '%'.$db->getEscaped($word, true).'%', false );
					$wheres2 	= array();
					$wheres2[] 	= 'name LIKE '.$word;
					$wheres2[] 	= 'menu_description LIKE '.$word;
					$wheres2[] 	= 'gallery_description LIKE '.$word;
					$wheres[] 	= implode( ' OR ', $wheres2 );
				}
				$where 	= '(' . implode( ($phrase == 'all' ? ') AND (' : ') OR ('), $wheres ) . ')';
				break;
		}
		
		switch ($ordering)
		{
			case 'newest':
				$order = 'date DESC';
				break;
			
			case 'oldest':
				$order = 'date ASC';
				break;
	
			case 'popular':
				$order = 'hits DESC';
				break;
	
			case 'alpha':
				$order = 'name ASC';
				break;
			
			case 'category':
				$order = 'parent, ordering';
				break;

			default:
				$order = 'date DESC';
		}
	
		$query = 'SELECT * from #__igallery WHERE ('. $where .') AND published = 1 ORDER BY '. $order;

		$db->setQuery($query, 0, $limit);
		$rows = $db->loadObjectList();
		
		
		for($i=0; $i<count($rows); $i++) 
		{
		    $row =& $rows[$i];

		    $results[$counter]->href = JRoute::_('index.php?option=com_igallery&view=category&igid='.$row->id.'&Itemid='.igUtilityHelper::getItemid($row->id));
		    $results[$counter]->title  = $row->name;
		    
		    $results[$counter]->text = strlen($row->gallery_description) > 0 ? $row->gallery_description : $row->menu_description;
		    $results[$counter]->created = null;
		    $results[$counter]->browsernav = 0;
		    if ($row->menu_image_filename!="") {
    			$increment = igFileHelper::getIncrementFromFilename($row->menu_image_filename);
  	      $folderName = igFileHelper::getFolderName($increment);
  			  $results[$counter]->image = JUri::Root()."images/igallery/original/".$folderName."/".$row->menu_image_filename;
        }		
		    $query = 'SELECT name from #__igallery WHERE id = '.(int)$row->parent;
		    $db->setQuery($query);
		    $parentRow = $db->loadObject();
			$section = isset($parentRow->name) ? $parentRow->name : '';
		    $results[$counter]->section = $section;
		    
		    $counter ++;
		}
	
		return $results;
	}

}
