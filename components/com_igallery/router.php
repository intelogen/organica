<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
function igalleryBuildRoute(&$query)
{
	$segments = array();
	$titlesArray = array();
	
	if( isset($query['view']) && isset($query['id']) )
	{
		if($query['view'] == 'category' || $query['view'] == 'gallery')
		{
			$db =& JFactory::getDBO();
			$dbQuery = 'SELECT name, alias, parent FROM #__igallery WHERE id = '.intval($query['id']);
			$db->setQuery($dbQuery);
			$row = $db->loadObject();
			$segments[] = $row->alias;
			
			while($row->parent != 0)
			{
				$dbQuery = 'SELECT name, alias, parent FROM #__igallery WHERE id = '.intval($row->parent);
				$db->setQuery($dbQuery);
				$row = $db->loadObject();
				array_unshift($segments, $row->alias);
			}
			
			unset($query['view']);
			unset($query['id']);
		}
	}
	return $segments;
}

function igalleryParseRoute($segments)
{
	$vars = array();
	$count = count($segments);
	$lastSegment = $segments[$count - 1];
	if($lastSegment)
	{
		$lastSegment = str_replace(':', '-', $lastSegment);
	
		$db =& JFactory::getDBO();
		$dbQuery = 'SELECT id, type FROM #__igallery WHERE alias = "'.$db->getEscaped($lastSegment).'"';
		$db->setQuery($dbQuery);
		$row = $db->loadObject();
		$vars['id'] = $row->id;
		
		if($row->type == 0)
		{
			$vars['view'] = 'category';
		}
		else
		{
			$vars['view'] = 'gallery';
		}
		
		return $vars;
	}
	else
	{
		return $segments;
	}
	
	
	
}

?>