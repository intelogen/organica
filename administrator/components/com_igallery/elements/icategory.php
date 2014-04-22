<?php
defined('_JEXEC') or die( 'Restricted access' );

class JElementIcategory extends JElement
{
	var	$_name = 'ICategory';

	function fetchElement($name, $value, &$node, $control_name)
	{
		//get all the categories
		$db =& JFactory::getDBO();
	    $query = "SELECT * FROM #__igallery WHERE type = 0 ORDER BY parent, ordering";
	    $db->setQuery( $query );
	    $categories = $db->loadObjectList();
		
	    //make the tree
	    $children = array();
		if($categories )
	    {
	        foreach($categories as $v) 
	        {
	            $pt     = $v->parent;
	            $list   = @$children[$pt] ? $children[$pt] : array();
	            array_push($list,$v);
	            $children[$pt] = $list;
	        }
	    }
		$categoryTree = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0 );
		
		//make the top select item
	    $selectItems     = array();
	    $selectItems[]   = JHTML::_('select.option', '0', JText::_('Top') );
		
	    //make the rest of the select items
	    foreach ($categoryTree as $branch) 
	    {
	        $selectItems[] = JHTMLSelect::option( $branch->id, '&nbsp;&nbsp;&nbsp;'. $branch->treename );
	    }
		
	    //make the html select box
	    $selectHTML = JHTML::_("select.genericlist", $selectItems, $control_name.'['.$name.']', 'class="inputbox"', 'value', 'text',
	    $value, $control_name.$name );
	
	    return $selectHTML;
	}
}
?>