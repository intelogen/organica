<?php

/**
* JElementVMMultiCategories - additional element for module XML file
* @package News Show Pro GK4
* @Copyright (C) 2009-2010 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 4.0.0 $
**/
 
// access denied
defined('JPATH_BASE') or die();
 
class JElementVMMultiCategories extends JElement
{
	// name of element
	var $_name = 'VMMultiCategories';
	// Construct an array of the HTML OPTION statements.
	var $_options = array();
	// function to create an element
	function fetchElement($name, $value, &$node, $control_name) {
        // Base name of the HTML control.
        $ctrl  = $control_name .'['. $name .']';
        // creating database instance
        $db =& JFactory::getDBO();
		// get default VM language
        
        if (!class_exists( 'VmConfig' ) && file_exists(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php')) { 
			require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
            $config = VmConfig::loadConfig();
            $lang = $config->lang;
        } else {
            // set default language to en_GB
            $lang = 'en_gb';
        }
        // generating query
		$db->setQuery("SELECT c.category_name AS name, c.virtuemart_category_id AS id, x.category_parent_id AS parent FROM #__virtuemart_categories_".$lang." AS c LEFT JOIN #__virtuemart_category_categories AS x ON x.category_child_id = c.virtuemart_category_id 
                        LEFT JOIN #__virtuemart_categories AS cr ON cr.virtuemart_category_id = c.virtuemart_category_id WHERE cr.published = '1' ORDER BY c.category_name, x.category_parent_id ASC");
 		// getting results
   		$results = $db->loadObjectList();
     	
		if(count($results)){
			// iterating
			$temp_options = array();
			
			foreach ($results as $item)
			{
				array_push($temp_options, array($item->id, $item->name, $item->parent));	
			}
			
			foreach ($temp_options as $option)
        	{
        		if($option[2] == 0)
				{
        	    	$this->_options[] = JHTML::_('select.option', $option[0], $option[1]);
        	    	$this->recursive_options($temp_options, 1, $option[0]);
        	    }
        	}		
			// Construct the various argument calls that are supported.
	        $attribs       = ' ';
	        if ($v = $node->attributes( 'size' )) $attribs .= 'size="'.$v.'"';
	        if ($v = $node->attributes( 'class' )) $attribs .= 'class="'.$v.'"';
	        else $attribs .= 'class="inputbox"';
	        // if multiselection enabled
			if ($m = $node->attributes( 'multiple' ))
	        {
	            $attribs .= ' multiple="multiple"';
	            $ctrl .= '[]';
	        }
	        // Render the HTML SELECT list.
	        return JHTML::_('select.genericlist', $this->_options, $ctrl, $attribs, 'value', 'text', $value, $control_name.$name );	
		} 
		else
		{
			// Render the HTML SELECT list.
	        return '<strong>VirtueMart is not installed or any VirtueMart categories are available.</strong><input id="paramsvm_categories" type="hidden" name="'.$control_name.$name.'" value="-1" />';	
		}
	}
 	// bind function to save
    function bind( $array, $ignore = '' )
    {
        if (key_exists( 'field-name', $array ) && is_array( $array['field-name'] )) {
        	$array['field-name'] = implode( ',', $array['field-name'] );
        }
 
        return parent::bind( $array, $ignore );
    }
    
    function recursive_options($temp_options, $level, $parent){
		foreach ($temp_options as $option)
       	{
      		if($option[2] == $parent)
		  	{
		  		$level_string = '';
		  		for($i = 0; $i < $level; $i++) $level_string .= '&mdash;&mdash;';
        	    $this->_options[] = JHTML::_('select.option', $option[0], $level_string . $option[1]);
       	    	$this->recursive_options($temp_options, $level+1, $option[0]);
			}
       	}
    }
}