<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			invoice.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelInvoice extends JModel {
	
	var $_id				= null;
	var $_invoice			= null;
	var $_pid				= null;
	var $_qid				= null;
	var $_published 		= 1;
	var $_required			= array('name');

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$pid = JRequest::getVar('pid', 0, '', 'int');
		$this->setPid((int)$pid);
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_invoice	= null;
	}	

	function setPid($pid)
	{
		$this->_pid		= $pid;
	}	

	function setQid($qid) {
		$this->_qid = $qid;	
	}

	function &getInvoice()
	{
		global $mainframe;
		// Load the Category data
		if ($this->_loadInvoice())
		{
		
			$read = JForceHelper::getObjectStatus($this->_invoice->id, 'invoice');
	
			if (!$read) :
				JForceHelper::setObjectStatus($this->_invoice->id, 'invoice');
			endif;
			
			$companyModel = JModel::getInstance('Company','JForceModel');
			$this->_invoice->owner = $companyModel->getAdminCompany();
						
			$this->_invoice->company = $this->_getClient();
			
			$serviceModel = JModel::getInstance('Service', 'JForceModel');
			$serviceModel->setInvoice($this->_invoice->id);
			
			$this->_invoice->services = $serviceModel->listItemServices();
			
			for($i=0;$i<count($this->_invoice->services);$i++):
				$service = $this->_invoice->services[$i];
				$service->listServices = $serviceModel->buildItemsSelected($service->service, $service->tax,$service->discount_type, $i);
			endfor;
			
			if($this->_invoice->paid==1):
				$this->_invoice->paid = "<div class='invoiceAccepted'>".JText::_('Invoice Paid')."</div>";
			else:
				$gateway = &JModel::getInstance('Gateway', 'JForceModel');
				$gateway->setGateway($this->_invoice->payment_method);
				$this->_invoice->paid = $gateway->generatePaymentLink($this->_invoice);
			endif;
			
			$configModel = JModel::getInstance('Configuration','JForceModel');
			$currency = $configModel->getCurrency();
			
			$this->_invoice->total = $currency.number_format($this->_invoice->total,2,'.',',');
			$this->_invoice->subtotal = $currency.number_format($this->_invoice->subtotal,2,'.',',');
		
			if($this->_invoice->pid):				
				$this->_invoice->link = JRoute::_('index.php?option=com_jforce&c=project&view=invoice&layout=invoice&pid='.$this->_invoice->pid.'&id='.$this->_invoice->id);
				$this->_invoice->projectlink = JRoute::_('index.php?option=com_jforce&c=project&view=project&layout=project&pid='.$this->_invoice->pid);
			else:
				$this->_invoice->link = JRoute::_('index.php?option=com_jforce&c=accounting&view=invoice&layout=invoice&id='.$this->_invoice->id);
				$this->_invoice->projectlink = '';			
			endif;

			$mainframe->triggerEvent('onLoadInvoice',array($this->_invoice));
			
		}
		else
		{
			$invoice =& JTable::getInstance('Invoice');
			$invoice->parameters	= new JParameter( '' );
			$this->_invoice			= $invoice;
			$this->_invoice->pid	= $this->_pid;
			$serviceModel = JModel::getInstance('Service', 'JForceModel');
			
			$service = &JTable::getInstance('Servicecf', 'JTable');
			$service->description = null;
			$service->listServices = $serviceModel->buildItemsSelected($service->service, $service->tax,$service->discount_type, 0);
			$this->_invoice->services[0] = $service;
			
			
		}

		return $this->_invoice;
	}

	function save($data)
	{
		global $mainframe;
		$user = JFactory::getUser();

		$id = $data['id'];
		$oldInvoice = JTable::getInstance('Invoice');

		if($id):
			$oldInvoice->load((int)$id);
		endif;

		$invoice  =& JTable::getInstance('Invoice');

		// Bind the form fields to the web link table
		if (!$invoice->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		if (!$invoice->id) :
			$invoice->created = gmdate("Y-m-d H:i:s");
			$invoice->author = $user->get('id');
			$invoice->published = 1;
			$new = 1;
		else :
			$new = 0;
		endif;
		$invoice->description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$invoice->modified = gmdate("Y-m-d H:i:s");
		
		// sanitise id field	
		$invoice->id = (int) $invoice->id;
	
		// Make sure the table is valid
		if (!$invoice->check()) {
			$this->setError($invoice->getError());
			return false;
		}
		
		if (!isset($data['override'])) :
			JForceHelper::validateObject($invoice, $this->_required);
		endif;
		
		$mainframe->triggerEvent('onBeforeInvoiceSave',array($invoice,$new));
		
		// Store the article table to the database
		if (!$invoice->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$selectedUsers = JRequest::getVar('hiddenSubscription');
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setId($invoice->id);
		
		if($invoice->pid):
			$subscriptionModel->setPid($invoice->pid);
		endif;
		
		$subscriptionModel->setAction('invoice');
		$subscriptionModel->save($selectedUsers);
		
		$this->_invoice	=& $invoice;
		
		$services = $data['services'];
		$serviceModel = &JModel::getInstance('Service', 'JForceModel');
		$serviceModel->saveServices($services, $invoice->id, 'invoice');
		
		if ($data['notify']) :
			$this->sendNotifications($invoice, $new);
		endif;

		$mainframe->triggerEvent('onAfterInvoiceSave',array($invoice,$new));

		return $this->_invoice;
	}
	
	
	function processPayment($post) {
		
		$gateway = &JModel::getInstance('Gateway', 'JForceModel');
		$gateway->setGateway($this->_invoice->payment_method);
		
		$response = $gateway->processPayment($post);
		
		if ($response[0]) :
			$this->_payInvoice($this->_invoice->id);
		endif;
		
		return $response;
		
	}
	
	function _payInvoice($id) {
		global $mainframe;
		
		$query = "UPDATE #__jf_invoices SET paid = '1' WHERE id = '$id'";
		$this->_db->setQuery($query);
		$this->_db->query();

		$mainframe->triggerEvent('onAfterInvoicePaid',array($invoice));
		
	}
	
	function getTotal() {
		$where = $this->_buildWhere();	

		$query = 'SELECT COUNT(*) '.
				' FROM #__jf_invoices AS i' .
				' LEFT JOIN #__jf_projects AS b ON i.pid = b.id' .
				' LEFT JOIN #__users As u on i.author = u.id' .
				$where;
				
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		return $total;
	}
	
	function listInvoices() {	
		global $mainframe;
		$where = $this->_buildWhere();	

		$query = 'SELECT i.*, b.name as project, u.name as author '.
				' FROM #__jf_invoices AS i' .
				' LEFT JOIN #__jf_projects AS b ON i.pid = b.id' .
				' LEFT JOIN #__users As u on i.author = u.id' .
				$where.
				' ORDER BY i.created DESC';

		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

        $invoices = $this->_getList($query, $limitstart, $limit);
		
		for($i=0;$i<count($invoices);$i++):
			$invoice = $invoices[$i];
			
			$read = JForceHelper::getObjectStatus($invoice->id, 'invoice');
			
			if ($read) :
				$invoice->read = "<img src='components".DS."com_jforce".DS."images".DS."invoice_icon.png' />";
			else :
				$invoice->read = "<img src='components".DS."com_jforce".DS."images".DS."invoice_icon_new.png' />";
			endif;
			
			if($invoice->pid):				
				$invoice->link = JRoute::_('index.php?option=com_jforce&c=project&view=invoice&layout=invoice&pid='.$invoice->pid.'&id='.$invoice->id);
				$invoice->projectlink = JRoute::_('index.php?option=com_jforce&c=project&view=project&layout=project&pid='.$invoice->pid);
			else:
				$invoice->link = JRoute::_('index.php?option=com_jforce&c=accounting&view=invoice&layout=invoice&id='.$invoice->id);
				$invoice->projectlink = '';			
			endif;
			
			$invoice->date = JForceHelper::getDaysDate($invoice->created,false);
			
			$configModel = JModel::getInstance('Configuration','JForceModel');
			$currency = $configModel->getCurrency();
			
			$invoice->total = $currency.number_format($invoice->total,2,'.',',');
			$invoice->subtotal = $currency.number_format($invoice->subtotal,2,'.',',');

			$mainframe->triggerEvent('onLoadInvoice',array($invoice));

		endfor;
		
		$this->list =$invoices;
        return $this->list;
    }

	function _loadInvoice()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_invoice))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT i.*, p.name as project, m.summary as milestone, c.summary as checklist '.
					 'FROM #__jf_invoices AS i ' .	
					 'LEFT JOIN #__jf_projects AS p ON i.pid = p.id '.
					 'LEFT JOIN #__jf_milestones AS m ON i.milestone = m.id '.
					 'LEFT JOIN #__jf_checklists AS c ON i.checklist = c.id '.
					$where;
			$this->_db->setQuery($query);
			$this->_invoice = $this->_db->loadObject();

			if ( ! $this->_invoice ) {
				return false;
			}
			return true;
		}
		return true;
	}

	function purgeInvoices()
	{
		$query = "DELETE FROM #__jf_invoices WHERE quote = ".(int)$this->_qid;
		$this->_db->setQuery($query);
		$this->_db->query();
		
	}
	
	function createInvoices()
	{
	
		$configurationModel = JModel::getInstance('Configuration','JForceModel');
		$gateway  = $configurationModel->getConfig('gateway'); // 0
	
		$numInvoices = $this->_invoice->numinvoices;  // 2
		$interval = $this->_invoice->interval; // 30
		
		for($i=0;$i<$numInvoices;$i++):
			$invoice = JTable::getInstance('Invoice');
			$invoice->bind($this->_invoice);
			$invoice->id = null;
			$invoice->viewed = 0;
			$invoice->enabled = 0;
			$invoice->invoice = $this->_invoice->id;
			$invoice->created = gmdate('Y-m-d H:i:s');
			$invoice->total = $this->_invoice->total / $numInvoices;
			$invoice->subtotal = $this->_invoice->subtotal / $numInvoices;
			$invoice->tax = $this->_invoice->tax / $numInvoices;
			$invoice->payment_method = $gateway;
			$invoice->store();
		endfor;
		
	}

	function invoiceAction($post)
	{
		global $mainframe;
		
		$accepted = $post['accepted'];
				
		$invoice = $this->_loadInvoice();
		$invoice->accepted = (int)$accepted;
		$invoice->store();

		$interval = $invoice->interval; // 30		
		
		$invoiceModel =& JModel::getInstance('Invoice','JForceModel');
		#$invoiceModel->setQid($invoice->id);
		$invoices = $invoiceModel->listInvoices();
		
		for($i=0;$i<count($invoices);$i++):
			$invoice = $invoices[$i];
			// Start invoice publishing		
			$int = $interval*($i+1);
			$invoice->publishdate = JForceHelper::getInvoiceInterval($invoice->created, $int);
			$invoice->validtill = JForceHelper::getInvoiceInterval($invoice->publishdate, $int);
			$invoice->store();
		endfor;
	}
	
	function _getClient() 
	{
		$query = "SELECT c.* FROM #__jf_companies AS c ".
				 "LEFT JOIN #__jf_projects as p ON p.company = c.id ".
				 "WHERE p.id = ".$this->_pid;
		
		$this->_db->setQuery($query);
		$company = $this->_db->loadObject();
		
		return $company;
		
	}
	
	function _generateButtons() 
	{	
		$uri		=& JFactory::getURI();	
	
		$buttons  = "<div class='buttonsForm'>";
		$buttons .= "<form action='".$uri->toString()."' method='post' name='adminForm'>";
		$buttons .= "\n<input type='button' name='accept' class='button' onclick='form.submit()' value='".JText::_('Accept')."' />";
		$buttons .= "\n<input type='button' name='deny' class='button' onclick='form.submit()' value='".JText::_('Deny')."' />";
		$buttons .= "\n<input type='hidden' name='option' value='com_jforce' />";
		$buttons .= "\n<input type='hidden' name='model' value='invoice' />";
		$buttons .= "\n<input type='hidden' name='ret' value='".@$_SERVER['HTTP_REFERER']."' />";
		$buttons .= "\n<input type='hidden' name='id' value='".$this->_invoice->id."' />";
		$buttons .="\n<input type='hidden' name='task' value='invoiceAction' />";
		$buttons .= "\n".JHTML::_('form.token');
		$buttons .= "</form>";
		$buttons .= "\n</div>";
		
		return $buttons;
	}
	

	function copyInvoice() {
		$user =& JFactory::getUser();

		$invoice = JTable::getInstance('Invoice');
		$invoice->load($this->_id);
		$invoice->id = null;
		$invoice->created = gmdate("Y-m-d H:i:s");
		$invoice->author = $user->get('id');
		$invoice->name = JText::_('Copy of').' '.$invoice->name;
		$invoice->store();
		
		$serviceModel = JModel::getInstance('Service', 'JForceModel');
		$serviceModel->setInvoice($this->_id);
			
		$services = $serviceModel->listItemServices();
		
		for($i=0;$i<count($services);$i++):
			$id = $services[$i]->id;
			$s = JTable::getInstance('Servicecf');
			$s->load($id);
			$s->id = null;
			$s->invoice = $invoice->id;
			$s->store();
		endfor;		
		
		return $invoice;
	}	
	
	function _buildWhere()
	{
		global $mainframe;
		
		$status = JRequest::getVar('status',0);
	
		$where = ' WHERE i.published = '.(int) $this->_published;
		
		if($this->_pid):
			$where .= ' AND i.pid = '. (int) $this->_pid;
		endif;
		
		if($this->_qid):
			$where .= ' AND i.quote = '. (int) $this->_qid;
		endif;
		
		$where .= ' AND i.paid = '. (int) $status;
		
		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR i.id = ',$this->_id);
				$where .= ' AND (i.id = '. $ids.')';
			else:
				$where .=' AND i.id = '.(int) $this->_id;
			endif;
		endif;
		
		return $where;
	}	
	
	function buildLists() {
		if ($this->_invoice->pid) :
			$lists['milestones'] = JforceListsHelper::getMilestoneList($this->_invoice->milestone);
			$lists['checklists'] = JforceListsHelper::getMilestoneList($this->_invoice->checklist);
		else :
			$lists['companies'] = JforceListsHelper::getClientList($this->_invoice->company);
		endif;
		
		$lists['payment_methods'] = JforceListsHelper::getGatewayList($this->_invoice->payment_method);
	
		$lists['visibility'] = JforceListsHelper::getVisibilityList($this->_invoice->visibility, $this->_invoice->id, true);
		
		$lists['paid'] = JforceListsHelper::getPaidList($this->_invoice->paid);
		
		return $lists;
	}
	
	function sendNotifications(&$invoice, $new = false) {
		$user = &JFactory::getUser();
		if($invoice):
			$this->setId($invoice->id);
		endif;
		
		$invoice = $this->getInvoice();
		
		$values = array(
					'type' => 'Invoice',
					'title' => $invoice->name, 
					'date' => $invoice->modified, 
					'project' => $invoice->project, 
					'description' => $invoice->description, 
					'author' => $user->name
				);		
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->sendMail($values, $invoice, 'invoice', $new);
		
	}
	
}