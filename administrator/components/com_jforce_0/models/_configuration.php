<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			configuration.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelConfiguration extends JModel {
	
	var $_config				= null;
	var $_field					= null;


    function __construct() {

        parent::__construct();
		
		// Add front-side Models
		JModel::addIncludePath( JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'models');

	}
	
	function &getConfig($field = null, $array=false)
	{
		// Load the Category data
		if ($this->_loadConfig())
		{
			if($field && $array):
				$this->_field = explode('|',$this->_config[$field]);
			elseif ($field && !$array):
				$this->_field = $this->_config[$field];
			endif;
		}
		else
		{
			$config =& JTable::getInstance('Configuration');
			$config->parameters	= new JParameter( '' );
			$this->_config			= $config;
		}

		if($field):
			return $this->_field;
		else :
			return $this->_config;
		endif;
	}

	function save($data)
	{
		global $mainframe;

		$data['supportcategories'] = implode('|',$data['supportcategories']);
		$data['generalcategories'] = implode('|',$data['generalcategories']);
		$data['currency'] = htmlentities($data['currency']);
		
		$config  =& JTable::getInstance('Configuration');

		// Bind the form fields to the web link table
		if (!$config->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$config->id = 1;

		// Make sure the table is valid
		if (!$config->check()) {
			$this->setError($config->getError());
			return false;
		}
		// Store the article table to the database
		if (!$config->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_config	=& $config;

		return true;
	}
	
	function listConfig() {	
	
		$where = $this->_buildWhere();

		$query = 'SELECT c.* '.
				' FROM #__jf_configuration AS c LIMIT 1';

        $config = $this->_getList($query, 0, 0);
		
		$this->list =$config;
        return $this->list;
    }

	function _loadConfig()
	{
		global $mainframe;

		// Load the item if it doesn't already exist
		if (empty($this->_config))
		{

			$query = 'SELECT c.* '.
					' FROM #__jf_configuration AS c LIMIT 1';
					
			$this->_db->setQuery($query);
			$this->_config = $this->_db->loadAssoc();

			if ( ! $this->_config ) {
				return false;
			}
			return true;
		}
		return true;
	}

	function listButtons() {
	
		$buttons = array();
		
		$buttons[0]['name'] = JText::_('General');
		$buttons[0]['link'] = JRoute::_('index.php?option=com_jforce&view=configuration&layout=general');
		$buttons[0]['image'] = '<img src="components/com_jforce/images/cpicons/general.png" alt="'.JText::_('General').'">';
		
		$buttons[1]['name'] = JText::_('Templates');
		$buttons[1]['link'] = JRoute::_('index.php?option=com_jforce&view=configuration&layout=templates');
		$buttons[1]['image'] = '<img src="components/com_jforce/images/cpicons/templates.png" alt="'.JText::_('General').'">';
		
		$buttons[2]['name'] = JText::_('Categories');
		$buttons[2]['link'] = JRoute::_('index.php?option=com_jforce&view=configuration&layout=categories');	
		$buttons[2]['image'] = '<img src="components/com_jforce/images/cpicons/categories.png" alt="'.JText::_('General').'">';
		
		$buttons[3]['name'] = JText::_('System Access');
		$buttons[3]['link'] = JRoute::_('index.php?option=com_jforce&view=role&type=system');	
		$buttons[3]['image'] = '<img src="components/com_jforce/images/cpicons/access.png" alt="'.JText::_('System Access').'">';
		
		#$buttons[4]['name'] = JText::_('Project Access');
		#$buttons[4]['link'] = JRoute::_('index.php?option=com_jforce&view=role&type=project');	
		#$buttons[4]['image'] = '<img src="components/com_jforce/images/cpicons/access.png" alt="'.JText::_('Project Access').'">';

		$buttons[4]['name'] = JText::_('Services');
		$buttons[4]['link'] = JRoute::_('index.php?option=com_jforce&view=service');	
		$buttons[4]['image'] = '<img src="components/com_jforce/images/cpicons/accounting.png" alt="'.JText::_('Services').'">';

		#$buttons[6]['name'] = JText::_('Projects');
		#$buttons[6]['link'] = JRoute::_('index.php?option=com_jforce&view=configuration&layout=projects');	
		#$buttons[6]['image'] = '<img src="components/com_jforce/images/cpicons/projects.png" alt="'.JText::_('Projects').'">';

		$buttons[5]['name'] = JText::_('Custom Fields');
		$buttons[5]['link'] = JRoute::_('index.php?option=com_jforce&c=customfield');	
		$buttons[5]['image'] = '<img src="components/com_jforce/images/cpicons/customfields.png" alt="'.JText::_('Custom Fields').'">';
		
		$buttons[6]['name'] = JText::_('Payment Gateways');
		$buttons[6]['link'] = JRoute::_('index.php?option=com_jforce&view=gateway');	
		$buttons[6]['image'] = '<img src="components/com_jforce/images/cpicons/customfields.png" alt="'.JText::_('Payment Gateways').'">';

		return $buttons;
		
	}

	function getCompany() {
	
	$companyModel =& JModel::getInstance('Company','JForceModel');
	$company = $companyModel->getAdminCompany();
	
	return $company;
	
	}
	
	function getCurrencies() {
		
	$default = $this->getConfig('currency');
	
	$currencyOptions = array();
	
	$currencyOptions[] = JHTML::_('select.option','$','$');
	$currencyOptions[] = JHTML::_('select.option','&pound;','&pound;');


	$currencies = JHTML::_('select.genericlist',$currencyOptions,'currency','class="inputbox"','text','value', $default);
	
	return $currencies;
	}
	
	function getEmailFields() {
	
	$email = $this->getConfig();
	
	return $email;
	}
}