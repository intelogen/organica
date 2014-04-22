<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			service.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelService extends JModel {
	
	var $_id					= null;
	var $_service				= null;
	var $_quote					= null;
	var $_invoice				= null;
	var $_published 			= 1;

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_service	= null;
	}	
	
	function setQuote($qid)
	{
		$this->_quote = $qid;	
	}

	function setInvoice($id)
	{
		$this->_invoice = $id;	
	}

	function &getService()
	{
		// Load the Category data
		if ($this->_loadService())
		{

		//	$this->_loadServiceParams();

		}
		else
		{
			$service =& JTable::getInstance('Service');
			$service->parameters	= new JParameter( '' );
			$this->_service			= $service;
		}

		return $this->_service;
	}

	function save($data)
	{
		global $mainframe;
		$user = &JFactory::getUser();
		$service  =& JTable::getInstance('Service');

		// Bind the form fields to the web link table
		if (!$service->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$service->id) :
			$service->published = 1;
			$service->author = $user->id;
			$service->created = gmdate("Y-m-d H:i:s");
		endif;

		$service->modified = gmdate("Y-m-d H:i:s");
		
		// sanitise id field
		$service->id = (int) $service->id;

		// Make sure the table is valid
		if (!$service->check()) {
			$this->setError($service->getError());
			return false;
		}
		// Store the article table to the database
		if (!$service->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_service	=& $service;

		return true;
	}
	
	function listServices() {	
	
		$where = $this->_buildWhere();

		$query = 'SELECT s.* '.
				' FROM #__jf_services AS s' .
				$where;
        $services = $this->_getList($query, 0, 0);
		
		$this->list =$services;
        return $this->list;
    }

	function _loadService()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_service))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT s.* '.
					' FROM #__jf_services AS s' .
					$where;
			$this->_db->setQuery($query);
			$this->_service = $this->_db->loadObject();

			if ( ! $this->_service ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function listItemServices() 
	
	{
		if($this->_quote):
			$where = 'WHERE s.quote = '.$this->_quote;
		elseif($this->_invoice):
			$where = 'WHERE s.invoice = '.$this->_invoice;
		endif;
		
		$query = "SELECT s.*, t.name FROM #__jf_services_cf AS s ".
		  		 "LEFT JOIN #__jf_services AS t ON s.service = t.id ".
				 $where;
		$services = $this->_getList($query, 0, 0);
		
		return $services;
	}
	
	function _buildWhere()
	{
		global $mainframe;
	
		$where = ' WHERE s.published = ' . (int) $this->_published;
	
		if($this->_id):
			$where .= ' AND s.id = '. (int) $this->_id;
		endif;
				
		return $where;
	}	
	
	function buildItemsSelected($item, $itemTax, $discount_type, $k) 
	{
		
		$this->setId(null);
		$services = $this->listServices();

		$services_options[] = JHTML::_('select.option', '', '---');
		
		for($i=0;$i<count($services);$i++):
			$service = $services[$i];
			$services_options[] = JHTML::_('select.option',$service->id,$service->name);
		endfor;
	
		$serviceList['item'] = JHTML::_('select.genericlist',$services_options,'services[service][]','class="inputbox serviceSelect" style="width: 350px"', 'value','text',$item, 'serviceSelect_'.$k);
		
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$taxes = $configModel->getConfig('tax', true);
		
		$tax_options[] = JHTML::_('select.option','0', '0');
		for($i=0;$i<count($taxes);$i++):
			$tax = $taxes[$i];
			$tax_options[] = JHTML::_('select.option',$tax, $tax);
		endfor;
		
		$serviceList['tax'] = JHTML::_('select.genericlist',$tax_options,'services[tax][]','class="inputbox"','value','text',$itemTax);
		
		$currency = $configModel->getCurrency();
		$discount_options[] = JHTML::_('select.option','amount', $currency);
		$discount_options[] = JHTML::_('select.option','percent', '%');
		$serviceList['discount'] = JHTML::_('select.genericlist',$discount_options,'services[discount_type][]','class="inputbox"','value','text',$discount_type);
		
		return $serviceList;						
	}
	
	function saveServices($services, $objectid, $type) {
		$this->_deleteOldServices($services, $objectid, $type);
		
		for ($i=0; $i<count($services['service']); $i++) :
			$s = $services['service'][$i];
			if ($s) :
				$params['id'] 		= $services['id'][$i];
				$params['service'] 	= $services['service'][$i];
				$params['description'] 	= $services['description'][$i];
				$params[$type] 	= $objectid;
				$params['subtotal'] = $services['subtotal'][$i];
				$params['price'] = $services['price'][$i];
				$params['discount'] = $services['discount'][$i];
				$params['tax'] 		= $services['tax'][$i];
				$params['quantity'] = $services['quantity'][$i];
				$params['total'] 	= $services['total'][$i];
				$params['discount_type'] 	= $services['discount_type'][$i];
				
				$cf = JTable::getInstance('Servicecf', 'JTable');
				$cf->bind($params);
				$cf->store();
			endif;
		endfor;
		
		
	}
	
	function _deleteOldServices($services, $objectid, $type) {
		$ids = array();
		for ($i=0; $i<count($services['id']); $i++) :
			$s = $services['id'][$i];
			if ($s) :
				$ids[] = $s;
			endif;
		endfor;
		
		if (!empty($ids)) :
			$where = "id <> '".implode("' AND id <> '", $ids)."'";
			$query = "DELETE FROM #__jf_services_cf WHERE ".$type." = '$objectid' AND ($where)";
			$this->_db->setQuery($query);
			$this->_db->query();
		endif;
	}
}