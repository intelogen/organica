<?php
defined('_JEXEC') or die('Restricted Access');

class JElementIgalleryHead extends JElement
{
	var	$_name = 'IgalleryHead';
	
	//this makes no heading on the left hand side
	function fetchTooltip($label, $description, &$node, $control_name, $name)
	{
		return '&nbsp;';
	}
	
	//this will return a heading (on the right), we need it as the joomla config does not have a xml heading option
	function fetchElement($name, $value, &$node, $control_name)
	{
		return '<p style="background: #d5e5ff; color: #000000; padding:5px; font-weight: bold;">'.JText::_($value).'</p>';
	}
}
?>