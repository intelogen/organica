<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			quote.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelQuote extends JModel {
	
	var $_id				= null;
	var $_quote				= null;
	var $_pid				= null;
	var $_published			= 1;
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
		$this->_quote	= null;
	}	

	function setPid($pid)
	{
		$this->_pid		= $pid;
	}	

	function &getQuote()
	{
		global $mainframe;
		// Load the Category data
		if ($this->_loadQuote())
		{

			$read = JForceHelper::getObjectStatus($this->_quote->id, 'quote');
			if (!$read) :
				JForceHelper::setObjectStatus($this->_quote->id, 'quote');
			endif;
			
			$companyModel = JModel::getInstance('Company','JForceModel');
			$this->_quote->owner = $companyModel->getAdminCompany();
						
			$this->_quote->company = $this->_getClient();
			
			$serviceModel = JModel::getInstance('Service', 'JForceModel');
			$serviceModel->setQuote($this->_quote->id);
			
			$this->_quote->services = $serviceModel->listItemServices();

			for($i=0;$i<count($this->_quote->services);$i++):
				$service = $this->_quote->services[$i];
				$service->listServices = $serviceModel->buildItemsSelected($service->service, $service->tax, $service->discount_type, $i);
			endfor;
			
			if($this->_quote->accepted==1):
				$this->_quote->acceptedHTML = "<span class='quoteAccepted'>".JText::_('Quote Accepted')."</span>";
			elseif ($this->_quote->accepted == -1) :
				$this->_quote->acceptedHTML = "<span class='quoteDenied'>".JText::_('Quote Denied')."</span>";
			else:
				$this->_quote->acceptedHTML = $this->_generateButtons();
			endif;
			
			if($this->_quote->pid):
				$this->_quote->link = JRoute::_('index.php?option=com_jforce&c=project&view=quote&layout=quote&pid='.$this->_quote->pid.'&id='.$this->_quote->id);
				$this->_quote->projectlink = JRoute::_('index.php?option=com_jforce&c=project&view=project&layout=project&pid='.$this->_quote->pid);
			else:
				$this->_quote->link = JRoute::_('index.php?option=com_jforce&c=accounting&view=quote&layout=quote&id='.$this->_quote->id);
				$this->_quote->projectlink = '';
			endif;
			
			$mainframe->triggerEvent('onLoadQuote',array($this->_quote));		
			
			
		}
		else
		{
			$quote =& JTable::getInstance('Quote');
			$quote->parameters	= new JParameter( '' );
			$this->_quote			= $quote;
			$this->_quote->pid		= $this->_pid;
			
			$serviceModel = JModel::getInstance('Service', 'JForceModel');
			
			$service = &JTable::getInstance('Servicecf', 'JTable');
			$service->description = null;
			$service->listServices = $serviceModel->buildItemsSelected($service->service, $service->tax,$service->discount_type, 0);
			$this->_quote->services[0] = $service;
			
			
		}

		return $this->_quote;
	}

	function save($data)
	{
		global $mainframe;
		
		$user = JFactory::getUser();

		$id = $data['id'];

		$quote  =& JTable::getInstance('Quote');

		// Bind the form fields to the web link table
		if (!$quote->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		if (!$quote->id) :
			$quote->created = gmdate("Y-m-d H:i:s");
			$quote->author = $user->get('id');
			$quote->published = 1;
			$new = 1;
		else :
			$new = 0;
		endif;
		$quote->description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$quote->modified = gmdate("Y-m-d H:i:s");
		// sanitise id field	
		$quote->id = (int) $quote->id;
	
		// Make sure the table is valid
		if (!$quote->check()) {
			$this->setError($quote->getError());
			return false;
		}
		
		if (!isset($data['override'])) :
			JForceHelper::validateObject($quote, $this->_required);
		endif;

		$mainframe->triggerEvent('onBeforeQuoteSave',array($quote,$new));		

		// Store the article table to the database
		if (!$quote->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$selectedUsers = JRequest::getVar('hiddenSubscription');
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setId($quote->id);
		
		if($quote->pid):
			$subscriptionModel->setPid($quote->pid);
		endif;
		
		$subscriptionModel->setAction('quote');
		$subscriptionModel->save($selectedUsers);
		
		$this->_quote	=& $quote;
		
		$services = $data['services'];
		
		$serviceModel = &JModel::getInstance('Service', 'JForceModel');
		$serviceModel->saveServices($services, $quote->id, 'quote');
		
		$invoiceModel = &JModel::getInstance('Invoice', 'JForceModel');
		$invoiceModel->setQid($quote->id);
		$invoiceModel->purgeInvoices();
		
		if((int)$quote->numinvoices > 0):
			$this->createInvoices();
		endif;
		
		if (isset($data['notify'])) :
			$this->sendNotifications($quote, $new);
		endif;

		$mainframe->triggerEvent('onAfterQuoteSave',array($this->_quote,$new));		

		return true;
	}
	
	function getTotal() {
		$where = $this->_buildWhere();

		$query = 'SELECT COUNT(*) '.
				' FROM #__jf_quotes AS q' .
				' LEFT JOIN #__jf_projects AS b ON q.pid = b.id' .
				' LEFT JOIN #__users As u on q.author = u.id' .
				$where;
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		return $total;
	}
	
	function listQuotes() {	
		global $mainframe;
		
		$where = $this->_buildWhere();

		$query = 'SELECT q.*, b.name as project, u.name as author '.
				' FROM #__jf_quotes AS q' .
				' LEFT JOIN #__jf_projects AS b ON q.pid = b.id' .
				' LEFT JOIN #__users As u on q.author = u.id' .
				$where.
				' ORDER BY q.created DESC';

		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

        $quotes = $this->_getList($query, $limitstart, $limit);
		
		for($i=0;$i<count($quotes);$i++):
			$quote = $quotes[$i];
			
			$read = JForceHelper::getObjectStatus($quote->id, 'quote');
			
			if ($read) :
				$quote->read = "<img src='components".DS."com_jforce".DS."images".DS."quote_icon.png' />";
			else :
				$quote->read = "<img src='components".DS."com_jforce".DS."images".DS."quote_icon_new.png' />";
			endif;
						
			if($quote->pid):
				$quote->link = JRoute::_('index.php?option=com_jforce&c=project&view=quote&layout=quote&pid='.$quote->pid.'&id='.$quote->id);
				$quote->projectlink = JRoute::_('index.php?option=com_jforce&c=project&view=project&layout=project&pid='.$quote->pid);
			else:
				$quote->link = JRoute::_('index.php?option=com_jforce&c=accounting&view=quote&layout=quote&id='.$quote->id);
				$quote->projectlink = '';
			endif;
			
			$quote->date = JForceHelper::getDaysDate($quote->created,false);

			$configModel = JModel::getInstance('Configuration','JForceModel');
			$currency = $configModel->getCurrency();
			
			$quote->total = $currency.number_format($quote->total,2,'.',',');
			$quote->subtotal = $currency.number_format($quote->subtotal,2,'.',',');
			
			$mainframe->triggerEvent('onLoadQuote',array($quote));		
		endfor;
		
		$this->list =$quotes;
        return $this->list;
    }

	function _loadQuote()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_quote))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT q.*, p.name as project, m.summary as milestone, c.summary as checklist '.
					 'FROM #__jf_quotes AS q ' .	
					 'LEFT JOIN #__jf_projects AS p ON q.pid = p.id '.
					 'LEFT JOIN #__jf_milestones AS m ON q.milestone = m.id '.
					 'LEFT JOIN #__jf_checklists AS c ON q.checklist = c.id '.
					$where;
					
			$this->_db->setQuery($query);
			$this->_quote = $this->_db->loadObject();

			if ( ! $this->_quote ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function createInvoices()
	{
		$numInvoices = $this->_quote->numinvoices;  // 2
		$interval = $this->_quote->interval; // 30
		
		for($i=0;$i<$numInvoices;$i++):
			$invoice = JTable::getInstance('Invoice', 'JTable');
			$invoice->bind($this->_quote);
			$invoice->id = null;
			$invoice->viewed = 0;
			$invoice->published = 0;
			$invoice->quote = $this->_quote->id;
			$invoice->created = gmdate('Y-m-d H:i:s');
			$invoice->total = $this->_quote->total / $numInvoices;
			$invoice->subtotal = $this->_quote->subtotal / $numInvoices;
			$invoice->tax = $this->_quote->tax / $numInvoices;
			$invoice->payment_method = '';
			$invoice->store();
		endfor;
	}

	function quoteAction($post)
	{
		global $mainframe;
		
		$accepted = $post['accept'];
						
		$quote = &JTable::getInstance('Quote', 'JTable');
		$quote->load($post['id']);
		
		$mainframe->triggerEvent('onBeforeQuoteAction',array($quote, $accepted));		
		
		$quote->accepted = (int)$accepted;

		$quote->store();


		if ($quote->accepted == 1) :
			$interval = $quote->interval; // 30		
			
			$invoiceModel =& JModel::getInstance('Invoice','JForceModel');
			$invoiceModel->setQid($quote->id);
			$invoices = $invoiceModel->listInvoices();
			
			for($i=0;$i<count($invoices);$i++):
				$invoice = $invoices[$i];
				// Start invoice publishing		
				$int = $interval*($i+1);
				$invoice->publishdate = JForceHelper::getInvoiceInterval($invoice->created, $int);
				$invoice->validtill = JForceHelper::getInvoiceInterval($invoice->publishdate, $int);
				$invoice->store();
			endfor;
		endif;
		
		$mainframe->triggerEvent('onAfterQuoteAction',array($quote));		
		
	}
	
	function copyQuote() {
		$user =& JFactory::getUser();

		$quote = JTable::getInstance('Quote');
		$quote->load($this->_id);
		$quote->id = null;
		$quote->created = gmdate("Y-m-d H:i:s");
		$quote->author = $user->get('id');
		$quote->name = JText::_('Copy of').' '.$quote->name;
		$quote->store();
		
		$serviceModel = JModel::getInstance('Service', 'JForceModel');
		$serviceModel->setQuote($this->_id);
			
		$services = $serviceModel->listItemServices();
		
		for($i=0;$i<count($services);$i++):
			$id = $services[$i]->id;
			$s = JTable::getInstance('Servicecf');
			$s->load($id);
			$s->id = null;
			$s->quote = $quote->id;
			$s->store();
		endfor;		
		
		return $quote;
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
		$buttons .= "<form action='index.php' method='post' name='adminForm'>";
		$buttons .= "\n<input type='button' name='accept_button' class='button' onclick='quoteAccept(this.form,1)' value='".JText::_('Accept')."' />";
		$buttons .= "\n<input type='button' name='deny_button' class='button' onclick='quoteAccept(this.form,-1)' value='".JText::_('Deny')."' />";
		$buttons .= "\n<input type='hidden' name='option' value='com_jforce' />";
		$buttons .= "\n<input type='hidden' name='model' value='quote' />";
		$buttons .= "\n<input type='hidden' name='id' value='".$this->_quote->id."' />";
		$buttons .="\n<input type='hidden' name='task' value='quoteAction' />";
		$buttons .="\n<input type='hidden' name='accept' id='accept' value='0' />";
		$buttons .="\n<input type='hidden' name='c' value='accounting' />";
		$buttons .= "\n".JHTML::_('form.token');
		$buttons .= "</form>";
		$buttons .= "\n</div>";
		
		return $buttons;
	}
	
	function _buildWhere()
	{
		global $mainframe;
	
		$status = JRequest::getVar('status','');
		
		$where = ' WHERE q.published = ' . (int) $this->_published;
	
		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR q.id = ',$this->_id);
				$where .= ' AND (q.id = '. $ids.')';
			else:
				$where .=' AND q.id = '.(int) $this->_id;
			endif;
		elseif($this->_pid):
			$where .= ' AND q.pid = '. (int) $this->_pid;
		endif;
		
		if ($status != '') :
			$where .= ' AND q.accepted = '. (int) $status;
		endif;
		
		return $where;
	}	
	
	
	function buildLists() {
		
		if ($this->_pid) :
			$lists['milestones'] = JforceListsHelper::getMilestoneList($this->_quote->milestone);
			$lists['checklists'] = JforceListsHelper::getMilestoneList($this->_quote->checklist);
		else :
			$lists['companies'] = JforceListsHelper::getClientList($this->_quote->company);
		endif;
		
		$lists['visibility'] = JforceListsHelper::getVisibilityList($this->_quote->visibility, $this->_quote->id, true);
		
		$lists['accepted'] = JforceListsHelper::getAcceptedList($this->_quote->accepted);
		
		return $lists;
	}
	
	function sendNotifications(&$quote, $new = false) {
		$user = &JFactory::getUser();
		if($quote):
			$this->setId($quote->id);
		endif;
		
		$quote = $this->getQuote();
		
		$values = array(
					'type' => 'Quote',
					'title' => $quote->name, 
					'date' => $quote->modified, 
					'project' => $quote->project, 
					'description' => $quote->description, 
					'author' => $user->name
				);		
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->sendMail($values, $quote, 'quote', $new);
		
	}
	
}