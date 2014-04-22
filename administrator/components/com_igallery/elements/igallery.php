<?php
defined('_JEXEC') or die( 'Restricted access' );

class JElementIgallery extends JElement
{
	var	$_name = 'IGallery';

	function fetchElement($name, $value, &$node, $control_name)
	{
		//get all the galleries
		$db =& JFactory::getDBO();
	    $query = "SELECT * FROM #__igallery WHERE type = 1 ORDER BY parent, ordering";
	    $db->setQuery($query);
	    $galleries = $db->loadObjectList();
		
	    //make the select list
	    $output = JHTML::_("select.genericlist", $galleries, $control_name.'['.$name.']', 'class="inputbox"',
	    'id', 'name', $value, $control_name.$name );
	
	    return $output;
	}
}
?>