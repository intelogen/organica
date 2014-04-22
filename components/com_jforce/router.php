<?php

/**********************************************************************************
*	@package		Joomla													  	  *
*	@subpackage		jForce, the Joomla! CRM										  *
*	@version		2.0															  *
*	@file			router.php													  *
*	@updated		2008-12-15													  *
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.*
*	@license		GNU/GPL, see jforce.license.php								  *
**********************************************************************************/

function JforceBuildRoute(&$query)
{
	$segments = array();
	
	// get a menu item based on Itemid or currently active
	$menu = &JSite::getMenu();
	if (empty($query['Itemid'])) {
		$menuItem = &$menu->getActive();
	} else {
		$menuItem = &$menu->getItem($query['Itemid']);
	}

	if(isset($query['pid']))
	{
		if(!empty($query['Itemid']) && isset($menuItem->query['pid'])) {
			if ($query['pid'] == $menuItem->query['pid']) {
				$segments[] = $query['pid'];
			}
		} else {
			$segments[] = $query['pid'];
		}
	}
	
	if(isset($query['view']))
	{
		$view = $query['view'];
		if(empty($query['Itemid'])) {
			$segments[] = $query['view'];
		}
		$segments[] = $query['view'];
		
	};

	

	if(isset($query['layout']))
	{
		if(!empty($query['Itemid']) && isset($menuItem->query['layout'])) {
			if ($query['layout'] == $menuItem->query['layout']) {
				$segments[] = $query['layout'];
			}
		} else {
			if($query['layout'] == 'default') {
				$segments[] = $query['layout'];
			} else {
				if ($query['layout'] == $query['view']) :
					$segments[] = 'view';
				elseif ($query['layout'] == 'form' && isset($query['id'])) :
					$segments[] = 'edit';
				elseif ($query['layout'] == 'form' && !isset($query['id'])) :
					$segments[] = 'new';
				else:
					$segments[] = $query['layout'];
				endif;
			}
		}
	}
	
	if(isset($query['id'])) {
		if (empty($query['Itemid'])) {
			$segments[] = $query['id'];
		} else {
			if (isset($menuItem->query['id'])) {
				if($query['id'] != $mId) {
					$segments[] = $query['id'];
				}
			} else {
				$segments[] = $query['id'];
			}
		}
	};

	unset($query['view']);
	unset($query['layout']);
	unset($query['id']);
	unset($query['pid']);

	return $segments;
}

function JforceParseRoute($segments)
{
	$vars = array();

	//Get the active menu item
	$menu =& JSite::getMenu();
	$item =& $menu->getActive();

	$vars['pid'] = $segments[0];

	$vars['view']  = $segments[1];
	
	if (isset($segments[2])) :
		if ($segments[2] != 'default') :
			if($segments[2] == 'view') :
				$vars['layout'] = $segments[1];
			elseif($segments[2] == 'edit' || $segments[2] == 'new') :
				$vars['layout'] = 'form';
			else :
				$vars['layout'] = $segments[2];
			endif;
		endif;
	endif;
	
	if (isset($segments[3])) :
		$vars['id']    = $segments[3];
	endif;
	

	return $vars;
}