<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			gateway.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelGateway extends JModel {
	
	var $_id				= null;
	var $_gid				= null;
	var $_gateway			= null;
	var $_params			= null;


    function __construct() {
    	
        parent::__construct();
	
	} 

	function setId($id) {
		$this->_id = $id;
		return true;
	}

	function setGateway($gateway) {
		$this->_gid = $gateway;
		
		return $this->checkGateway();
	}
	
	function checkGateway() {
		$gateway = JTable::getInstance('Plugin');
		$gateway->load($this->_gid);
		
		if (!$gateway->id || $gateway->published == 0) :
			return $this->loadDefault();
		endif;
		
		jimport('joomla.filesystem.file');
		$path = JPATH_COMPONENT.DS.'plugins'.DS.'gateways'.DS.$gateway->folder.DS.$gateway->folder.'.php';
		
		if (!JFile::exists($path)) :
			return $this->loadDefault();
		endif;
		
		$this->_gateway = $gateway;
		return $this->_gateway;
		
	}

	function loadDefault() {
		$query = "SELECT * FROM #__jf_plugins WHERE type = 'gateway' AND `default` = '1'";
		$this->_db->setQuery($query);
		$gateway = $this->_db->loadObject();
		
		if (!$gateway) :
			return false;
		endif;
		
		jimport('joomla.filesystem.file');
		$path = JPATH_COMPONENT.DS.'plugins'.DS.'gateways'.DS.$gateway->folder.DS.$gateway->folder.'.php';
		
		if (!JFile::exists($path)) :
			JError::raiseError('404', JText::_('Payment Gateway File Not Found'));
			return false;
		endif;
		
		$this->_gateway = $gateway;
		return $this->_gateway;
		
	}

	function getClass() {
		include_once(JPATH_COMPONENT.DS.'plugins'.DS.'gateways'.DS.$this->_gateway->folder.DS.$this->_gateway->folder.'.php');

		$class = 'Gateway'.ucwords($this->_gateway->folder);
				
		$gateway = new $class();
	
		return $gateway;
	}

	function generatePaymentLink($invoice) {
		
		if ($this->_gateway->link) :
			$html = $this->generatePaymentForm($invoice);
		else :
			$html = "<a class='button' href='".JRoute::_('index.php?option=com_jforce&view=invoice&layout=payment&pid='.$invoice->pid.'&id='.$invoice->id)."'>".JText::_('Pay Now')."</a>";
		endif;
		
		return $html;
		
	}

	function generatePaymentForm($invoice)
	{		
		$gateway = $this->getClass();
		$params = $this->loadParams();
		
		$html = $gateway->generateForm($params, $invoice);
		
		return $html;
	}
	
	function processPayment($post) {
		$gateway = $this->getClass();
		$params = $this->loadParams();
		
		$response = $gateway->processPayment($params, $post);
		
		return $response;
	}

	function loadParams() {
		jimport('joomla.filesystem.file');
		
		$xml = JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'plugins'.DS.'gateways'.DS.$this->_gateway->folder.DS.$this->_gateway->folder.'.xml';
		
		if (!JFile::exists($xml)) :
			$xml = null;
		endif;
		
		$params = new JParameter($this->_gateway->params, $xml);
	
		return $params;
	
	}
	
	function save($data) {
		$user = &JFactory::getUser();
		$gateway  =& JTable::getInstance('Plugin');
		
		// Bind the form fields to the web link table
		if (!$gateway->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		$params = new JParameter('');
		$params->bind($data['params']);
		$gateway->params = $params->toString();

		// Make sure the table is valid
		if (!$gateway->check()) {
			$this->setError($project->getError());
			return false;
		}
		
		// Store the article table to the database
		if (!$gateway->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_gateway	=& $gateway;

		

		return $this->_gateway;

	}
	
	function getTotal() {
		
		$query = "SELECT COUNT(*) FROM #__jf_plugins WHERE type = 'gateway'";
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		
		return $total;
		
	}
	
	function listGateways() {
		
		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		
		$query = "SELECT * FROM #__jf_plugins WHERE `type` = 'gateway'";
		$this->_db->setQuery($query, $limitstart, $limit);
		
		$gateways = $this->_db->loadObjectList();
		
		return $gateways;
	}
	
	function getGateway() {
		$where = $this->buildWhere();
		
		$query = "SELECT * FROM #__jf_plugins ".$where;
		$this->_db->setQuery($query);
		$gateway = $this->_db->loadObject();
		
		$this->_gateway = $gateway;
	
		return $this->_gateway;
		
	}
	
	function buildWhere() {
		
		$where = null;
		
		if ($this->_id) :
			$where = ' WHERE id = '.(int)$this->_id;
		endif;
		
		return $where;
		
	}
	
	function buildLists() {
		
		$lists['published'] = JForceListsHelper::getPublishedList($this->_gateway->published);
		
		$lists['default'] = JForceListsHelper::getDefaultList($this->_gateway->default);
		
		return $lists;
	}
	
}