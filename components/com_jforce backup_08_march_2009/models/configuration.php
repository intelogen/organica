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

		if (isset($data['company'])) :
			$company = $data['company'];
			$company->address = JRequest::getVar('company[address]', '', 'post', 'string', JREQUEST_ALLOWRAW);
			$companyModel = &JModel::getInstance('Company', 'JForceModel');
			$companyModel->save($company);
		endif;

		if(isset($data['supportcategories'])) :
			$data['supportcategories'] = array_filter($data['supportcategories']);
			$data['supportcategories'] = implode('|',$data['supportcategories']);
		endif;
		
		if (isset($data['generalcategories'])) :
			$data['generalcategories'] = array_filter($data['generalcategories']);
			$data['generalcategories'] = implode('|',$data['generalcategories']);
		endif;
		
		if (isset($data['tax'])) :
			$data['tax'] = array_filter($data['tax']);
			sort($data['tax']);
			$data['tax'] = implode('|',$data['tax']);
		endif;
		
		if (isset($data['currency'])) :
			$data['currency'] = htmlentities($data['currency']);
		endif;
		
		$config  =& JTable::getInstance('Configuration', 'JTable');

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
		$buttons[1]['image'] = '<img src="components/com_jforce/images/cpicons/templates.png" alt="'.JText::_('Templates').'">';
		
		$buttons[2]['name'] = JText::_('Categories');
		$buttons[2]['link'] = JRoute::_('index.php?option=com_jforce&view=configuration&layout=categories');	
		$buttons[2]['image'] = '<img src="components/com_jforce/images/cpicons/categories.png" alt="'.JText::_('Categories').'">';
		
		$buttons[3]['name'] = JText::_('System Access');
		$buttons[3]['link'] = JRoute::_('index.php?option=com_jforce&view=role&type=system');	
		$buttons[3]['image'] = '<img src="components/com_jforce/images/cpicons/access.png" alt="'.JText::_('System Access').'">';

		$buttons[4]['name'] = JText::_('Services');
		$buttons[4]['link'] = JRoute::_('index.php?option=com_jforce&view=service');	
		$buttons[4]['image'] = '<img src="components/com_jforce/images/cpicons/accounting.png" alt="'.JText::_('Services').'">';

		$buttons[5]['name'] = JText::_('Custom Fields');
		$buttons[5]['link'] = JRoute::_('index.php?option=com_jforce&view=customfield');	
		$buttons[5]['image'] = '<img src="components/com_jforce/images/cpicons/customfields.png" alt="'.JText::_('Custom Fields').'">';
		
		$buttons[6]['name'] = JText::_('Payment Gateways');
		$buttons[6]['link'] = JRoute::_('index.php?option=com_jforce&view=plugin&type=gateway');	
		$buttons[6]['image'] = '<img src="components/com_jforce/images/cpicons/gateways.png" alt="'.JText::_('Payment Gateways').'">';
		
		$buttons[7]['name'] = JText::_('Plugins');
		$buttons[7]['link'] = JRoute::_('index.php?option=com_jforce&view=plugin');	
		$buttons[7]['image'] = '<img src="components/com_jforce/images/cpicons/plugin.png" alt="'.JText::_('Plugins').'">';

		return $buttons;
		
	}
	
	function getCompany() {
	
		$companyModel =& JModel::getInstance('Company','JForceModel');
		$company = $companyModel->getAdminCompany();
		
		return $company;
	
	}
	
	function getCurrency() {
		
		$currency = $this->getConfig('currency');
		
		$currency = '&'.$currency;
		
		return $currency;
	}
	
	function getEmailFields() {
	
		$email = $this->getConfig();
		
		return $email;
	}
	
	function buildGeneralLists() {
		$default = $this->getConfig('currency');
		$lists['currency'] = JForceListsHelper::getCurrencyList($default);
		
		$default = $this->getConfig('showhelp');
		$lists['showhelp'] = JForceListsHelper::getShowHelpList($default);
		
		$default = $this->getConfig('tax_enabled');
		$lists['taxenabled'] = JForceListsHelper::getTaxEnabledList($default);
		
		return $lists;
	}
}