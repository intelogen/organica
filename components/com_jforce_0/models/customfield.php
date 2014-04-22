<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			customfield.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelCustomfield extends JModel {
	
	var $_id					= null;
	var $_customfield			= null;
	var $_values				= null;
	var $_public_only			= false;
	var $_published				= 1;


    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$cid = JRequest::getVar('cid', '', '', 'array');
		if ($cid[0]) :
			$this->setId((int)$cid[0]); 
		endif;
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_customfield	= null;
	}	

	function setPublished($published)
	{
		$this->_published = $published;	
	}

	function setPublicOnly() {
		$this->_public_only = true;
	}

	function &getCustomfield()
	{
		// Load the Category data
		if ($this->_loadCustomfield())
		{

		//	$this->_loadCustomfieldParams();

		}
		else
		{
			$customfield =& JTable::getInstance('Customfield');
			$customfield->parameters	= new JParameter( '' );
			$this->_customfield			= $customfield;
		}

		$this->_customfield->_values = $this->_parseValues();
		
		return $this->_customfield;
	}

	function save($data)
	{
		global $mainframe;

		$customfield  =& JTable::getInstance('Customfield');

		// Bind the form fields to the web link table
		if (!$customfield->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$customfield->id = (int) $customfield->id;

		for ($i=0; $i<count($data['values']); $i++) :
			if ($data['values'][$i] == '') :
				unset($data['values'][$i]);
			endif;
		endfor;

		$customfield->values = implode("[%]", $data['values']);
		
		if ($customfield->fieldtype == 'textarea' || $customfield->fieldtype == 'textbox') :
			$customfield->values = '';
		elseif($customfield->fieldtype == 'checkbox') :
			$customfield->required = 0;
		endif;

		// Make sure the table is valid
		if (!$customfield->check()) {
			$this->setError($customfield->getError());
			return false;
		}
		// Store the article table to the database
		if (!$customfield->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_customfield	=& $customfield;

		return true;
	}

	function saveCustomFields($fields, $cfid)
	{
		
		if ($fields) :
		
			foreach($fields as $key=>$value):
				
				if (is_array($value)) :
					$value = implode("[%]",$value);
				endif;
				
				$query = "SELECT COUNT(*) FROM #__jf_customfields_cf WHERE fid = '$key' AND cfid = '$cfid'";
				$this->_db->setQuery($query);
				$exists = $this->_db->loadResult();
				
				if ($exists) :
					$query = "UPDATE #__jf_customfields_cf SET value = '$value' WHERE fid='$key' AND cfid = '$cfid'";
					$this->_db->setQuery($query);
					$this->_db->query();
				else :
					$query = "INSERT INTO #__jf_customfields_cf (id, fid, cfid, value) VALUES ('', '$key', '$cfid', '$value')";
					$this->_db->setQuery($query);
					$this->_db->query();
				endif;
				
			endforeach;
		endif;

		return true;
	}
	
	function getTotal() {
		$where = $this->_buildWhere();

		$query = 'SELECT COUNT(*) '.
				' FROM #__jf_customfields AS c' .
				$where;
		$this->_db->setQuery($query);
        $total = $this->_db->loadResult();
		return $total;
	}
	
	function listCustomfields() {	
	
		$where = $this->_buildWhere();

		$query = 'SELECT c.* '.
				' FROM #__jf_customfields AS c' .
				$where;

		$limit = JRequest::getVar('limit', 0);
		$limitstart = JRequest::getVar('limitstart', 0);

        $customfields = $this->_getList($query, $limitstart, $limit);
	
		for ($i=0; $i<count($customfields); $i++) :
			$cf = $customfields[$i];
			$cf->public = $cf->public ? '<img src="images/tick.png" />' : '<img src="images/publish_x.png" />';
			$cf->published = $cf->published ? '<img src="images/tick.png" />' : '<img src="images/publish_x.png" />';
			$cf->required = $cf->required ? '<img src="images/tick.png" />' : '<img src="images/publish_x.png" />';
		endfor;
	
		$this->list =$customfields;
        return $this->list;
    }

	function _loadCustomfield()
	{
		global $mainframe;

		if($this->_id == '0')
		{ 
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_customfield))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT c.* '.
					' FROM #__jf_customfields AS c' .
					$where;
			$this->_db->setQuery($query);
			$this->_customfield = $this->_db->loadObject();

			if ( ! $this->_customfield ) {
				return false;
			}
			return true;
		}
		return true;
	}
		
	
	function getValue($fid, $cfid) {
		$query = "SELECT value FROM #__jf_customfields_cf WHERE fid = '$fid' AND cfid = '$cfid'";
		$this->_db->setQuery($query);
		$value = $this->_db->loadResult();
		$layout = JRequest::getVar('layout');
		if(!$value && $layout == 'ticket'):
			$value = '--';
		endif;
		
		return $value;
	}
	
	function loadCustomFields($type, $id = null, $edit = true) {
		$customFields = array();
		
		$where = $this->_buildWhere();
		
		$query = "SELECT c.* ".
				"FROM #__jf_customfields AS c ".
				$where.
				" AND c.type = '$type'";
		$this->_db->setQuery($query);
		$fields = $this->_db->loadObjectList();

		for ($i=0; $i<count($fields); $i++) :
			$field = $fields[$i];
			
			$field->cfvalue = $this->getValue($field->id, $id);

			if(!$edit):
			
				$cf = array();
				$cf['label'] = $field->field;
				$cf['fieldtype'] = $field->fieldtype;
				
				if($field->fieldtype == 'checkbox'):
					$cf['field'] = $this->_parseValues($field->cfvalue);
					$cf['field'] = implode(", ",$cf['field']);
				else:
					$cf['field'] = $field->cfvalue;
				endif;
				
				$customFields[$i] = $cf;
				
			else:

				switch ($field->fieldtype) :
				
					case 'textbox':
						$customFields[$i] = $this->_loadTextBox($field);
					break;
					
					case 'textarea':
						$customFields[$i] = $this->_loadTextArea($field);
					break;
					
					case 'select':
						$customFields[$i] = $this->_loadSelectBox($field);
					break;
					
					case 'radio':
						$customFields[$i] = $this->_loadRadioList($field);
					break;
					
					case 'checkbox':
						$customFields[$i] = $this->_loadCheckbox($field);
					break;
				
				endswitch;
			endif;			
			
		
		endfor;
	
		return $customFields;
	}
	
	function _loadTextBox($field) {
		$name = 'cf['.$field->id.']';
		$id = 'cf_'.$field->id;
		$value = $field->cfvalue ? $field->cfvalue : null;
		$class = $field->required ? 'inputbox required' : 'inputbox';
		$label = $field->field;
		
		$html = "<input type='text' name='$name' id='$id' class='$class' size='30' value='$value' />";
	
		$cf['fieldtype'] 	= $field->fieldtype;
		$cf['label'] 		= $label;
		$cf['field'] 		= $html;
		$cf['name']			= $id;
		
		return $cf;
	}
	
	function _loadTextArea($field) {
		$name = 'cf['.$field->id.']';
		$id = 'cf_'.$field->id;
		$value = $field->cfvalue ? $field->cfvalue : null;
		$class = $field->required ? 'inputbox required' : 'inputbox';
		$label = $field->field;
		
		$html = "<textarea name='$name' id='$id' class='$class'>$value</textarea>";
		
		$cf['fieldtype'] 	= $field->fieldtype;
		$cf['label'] 		= $label;
		$cf['field'] 		= $html;
		$cf['name']			= $id;
		
		return $cf;
	}
	
	function _loadSelectBox($field) {
		
		$name = 'cf['.$field->id.']';
		$id = 'cf_'.$field->id;
		$value = $field->cfvalue ? $field->cfvalue : null;
		$class = $field->required ? 'inputbox required' : 'inputbox';
		$label = $field->field;
		
		$values = $this->_parseValues($field->values);
		
		for($i=0; $i<count($values);$i++) :
			$v = $values[$i];
			$value_options[] = JHTML::_('select.option', $v, $v);
		endfor;
		
		$html = JHTML::_('select.genericlist', $value_options, $name, "class='$class'", 'value', 'text', $value, $id);

		$cf['fieldtype'] 	= $field->fieldtype;
		$cf['label'] 		= $label;
		$cf['field'] 		= $html;
		$cf['name']			= $id;
		
		return $cf;
	}
	
	function _loadRadioList($field) {
		$name = 'cf['.$field->id.']';
		$id = 'cf_'.$field->id;
		$value = $field->cfvalue ? $field->cfvalue : null;
		$class = $field->required ? 'inputbox required' : 'inputbox';
		$label = $field->field;
		
		$values = $this->_parseValues($field->values);
		
		for($i=0; $i<count($values);$i++) :
			$v = $values[$i];
			$value_options[] = JHTML::_('select.option', $v, $v);
		endfor;
		
		$html = JHTML::_('select.radiolist', $value_options, $name, "class='$class'", 'value', 'text', $value, $id);

		$cf['fieldtype'] 	= $field->fieldtype;
		$cf['label'] 		= $label;
		$cf['field'] 		= $html;
		$cf['name']			= $id;
		
		return $cf;
	}
	
	function _loadCheckbox($field) {
		$name = 'cf['.$field->id.']';
		$id = 'cf_'.$field->id;
		$selected = $field->cfvalue ? explode('[%]',$field->cfvalue) : array();
		$class = $field->required ? 'inputbox required' : 'inputbox';
		$label = $field->field;
		
		$values = $this->_parseValues($field->values);
		
		$boxes = array();
		for($i=0; $i<count($values);$i++) :
			$v = $values[$i];
			$checked = in_array($v,$selected) ? 'checked' : '';
			$boxes[] = "<input type='checkbox' name='".$name."[]' class='inputbox' value='$v' ".$checked." />&nbsp;&nbsp;".$v;
		endfor;
		
		$html = implode("<br />",$boxes);

		$cf['fieldtype'] 	= $field->fieldtype;
		$cf['label'] 		= $label;
		$cf['field'] 		= $html;
		$cf['name']			= $id;
		
		return $cf;
	}
	
	function _parseValues($values = null) {
	
		if (!$values) :
			$values = $this->_customfield->values;
		endif;
	
		if ($values) :
			$values = explode("[%]", $values);
		else:
			$values = array();
		endif;
		
		return $values;
	
	}
	
	function trash($data) {
	
		$cid = $data['cid'];
		
		for($i=0;$i<count($cid);$i++):
			$id = $cid[$i];
			echo $id;
			$item = JTable::getInstance('Customfield');
			$item->load($id);
			$item->published = -1;
			$item->store();
		endfor;
		return true;
		
	}
	
	function buildLists() {
	
		$lists['fieldtypes'] = JForceListsHelper::getFieldTypeList($this->_customfield->fieldtype);
		
		$lists['type'] = JForceListsHelper::getFieldObjectList($this->_customfield->type);

		$lists['required'] = JForceListsHelper::getRequiredList($this->_customfield->required);

		$lists['public'] = JForceListsHelper::getPublicList($this->_customfield->public);
		
		$lists['published'] = JForceListsHelper::getPublishedList($this->_customfield->published);

		return $lists;	
	}
	
	function _buildWhere()
	{
		global $mainframe;
		
		$where = ' WHERE c.published >= '.(int) $this->_published;
	
		if($this->_id):
			$where .= ' AND c.id = '. (int) $this->_id;
		endif;
		
		if ($this->_public_only) :
			$where .= ' AND c.public = 1';
		endif;
		
		return $where;
	}
}