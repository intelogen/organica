<?php 

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			view.html.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view'); 

class JforceViewInvoice extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if($layout == 'print'):
			$this->_displayPrint();
			return;
		endif;

		if ($layout == 'invoice') {
			$this->_displayInvoice($tpl);
			return;	
		}
		
		if ($layout == 'payment') {
			$this->_displayPaymentForm($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}
		$pid = JRequest::getVar('pid');
        
		$model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		$invoices = $model->listInvoices();
		
		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$invoices):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;

		$newInvoiceLink = "	<a href='".JRoute::_('index.php?option=com_jforce&c=accounting&view=invoice&layout=form&pid='.$pid)."' class='button'>".JText::_('New Invoice')."</a>";

		$status = JRequest::getVar('status');
		
		$this->assignRef('status',$status);
		$this->assignRef('startupText',$startupText);
		$this->assignRef('newInvoiceLink', $newInvoiceLink);
		$this->assignRef('invoices', $invoices);
		$this->assignRef('pagination', $pagination);
        $this->assignRef('pid',$pid);
		
        parent::display($tpl);		
	}	
	
	function _displayInvoice($tpl) {
        global $mainframe, $option;
		$user = &JFactory::getUser();
        $model = &$this->getModel();
		$document =& JFactory::getDocument();		
		
        $invoice = &$model->getInvoice();

		$js = "window.addEvent('domready',function() {
				
			$('subscribeLink').addEvent('click',function(e) {
					e = new Event(e);
					subscribeMe('".$invoice->id."','invoice', '".$invoice->pid."');
					e.stop();										
				});
			
			$('remindLink').addEvent('click',function(e) {
						e = new Event(e);
						remindPeople('".$invoice->id."','invoice');
						e.stop();										
					});
						
			   });";
		
		$document->addScriptDeclaration($js);		

		$owner = $invoice->owner;	
		$company = $invoice->company;
		$services = $invoice->services;
		$comments = JForceHelper::loadComments('invoice', $invoice);
		
		$tabMenu = JForceTabHelper::getTabMenu($invoice);
		
		$this->assignRef('tabMenu',$tabMenu);
		$this->assignRef('owner', $owner);
		$this->assignRef('services',$services);
		$this->assignRef('company',$company);
        $this->assignRef('invoice', $invoice);
        $this->assignRef('option', $option);
		$this->assignRef('comments', $comments);
		
		parent::display($tpl);		
	}
	
	function _displayPaymentForm($tpl) {
        global $mainframe, $option;

        $model = &$this->getModel();
		
        $invoice = &$model->getInvoice();
		
		$owner = $invoice->owner;
		
		$company = $invoice->company;
		
		
		$gateway = &JModel::getInstance('Gateway', 'JForceModel');
		$gateway->setGateway($invoice->payment_method);
		$form = $gateway->generatePaymentForm($invoice);
        
		$pathway =& $mainframe->getPathway();
		$pathway->addItem(JText::_('List Invoices'), 'index.php?option=com_jforce&c=accounting&view=invoice');	
		$pathway->addItem(JText::_('Invoice'));	

		$this->assignRef('owner', $owner);
		$this->assignRef('form',$form);
		$this->assignRef('company',$company);
        $this->assignRef('invoice', $invoice);
        $this->assignRef('option', $option);

		parent::display($tpl);		
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
			
		// Load the JEditor object
		$editor =& JFactory::getEditor();

		// Initialize variables
        $model = &$this->getModel();	
		JForceHelper::initValidation($model->_required);
		
        $invoice = &$model->getInvoice();
		
		$services = $invoice->services;

		$lists = $model->buildLists();

		
		JHTML::_('behavior.mootools');
		
		$doc = &JFactory::getDocument();
		
		$js = "window.addEvent('domready', function() {
					$$('.removeItem a').addEvent('click', function() {
							var removeId = this.id.substr(11);											  
							deleteItem(removeId);									   
						});
					$$('.listTitle select').addEvent('change', function() {
							getServiceInfo(this.value, this.id);
						});
					
					$$('#servicesArea input').addEvent('change', function() {
							updateTotals();												 
						});
					
					$$('#servicesArea select').addEvent('change', function() {
							updateTotals();												 
						});
										
					updateTotals();
				});";
		$doc->addScriptDeclaration($js);
		
		// Build the page title string
		$title = $invoice->id ? JText::_('Edit Invoice') : JText::_('New Invoice');			

		JHTML::_('behavior.modal', 'a.modal');
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('invoice');
		$subscriptionFields = $subscriptionModel->buildSubscriptionFields();
		
		$subscriptionLink = 'index.php?tmpl=component&option=com_jforce&c=accounting&view=modal&action=invoice&pid='.$invoice->pid;
		
		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('services',$services);
		$this->assign('lists',$lists);
		$this->assignRef('title',   $title);
		$this->assignRef('invoice',	$invoice);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);
		$this->assignRef('subscriptionLink',	$subscriptionLink);
		$this->assignRef('subscriptionFields',	$subscriptionFields);
		
		parent::display($tpl);			
	}		


	function _displayPrint() {
		
		$model = &$this->getModel();
		
        $invoice = &$model->getInvoice();
		$params 	= & $invoice->parameters;
		
		$configModel = JModel::getInstance('Configuration','JForceModel');
		$template = $configModel->getConfig('invoicetemplate');

		$owner = $invoice->owner;

		$company = $invoice->company;
		
		$services = $invoice->services;

		$service_area = "<div class='servicesHeader'>
            	<div class='serviceTotals'>Cost</div>
                <div class='serviceQuantity'>Quantity</div>
                <div class='listTitle'>Service</div>
            </div>";

		for($i=0;$i<count($services);$i++): 
			$service = $services[$i]; 
			$k = $i%2;
			$service_area .="<div class='row".$k."'>";
			$service_area .="<div class='serviceTotals'>";
			$service_area .="<div class='key'>".JText::_('Subtotal')."</div>".$service->subtotal."<br />";
			if($service->discount):
				$service_area .="<div class='key'>".JText::_('Discount')."</div>".$service->discount."<br />";
			else:
				$service_area .="<div class='key'></div><br />";
			endif;
			if($service->tax):
				$service_area .="<div class='key'>".JText::_('Tax')."</div>".$service->tax."<br />";
			else:
				$service_area .="<div class='key'></div><br />";
			endif;
			$service_area .="<div class='key'>".JText::_('Total')."</div>".$service->total."<br />";
			$service_area .="</div>";
			$service_area .="<div class='serviceQuantity'>".$service->quantity."</div>";
			$service_area .="<div class='listTitle'>".$service->name."</div>";
			$service_area .="<div class='serviceDescription'>".$service->description."</div>";
			$service_area .="</div>";
		endfor;
		
		$service_area .="</div>";
		
		if($invoice->milestone):
			$milestone = "<div>".JText::_('Milestone').": ".$invoice->milestone."</div>";
		else:
			$milestone = '';
		endif;

		if($invoice->checklist):
			$checklist = "<div>".JText::_('Checklist').": ".$invoice->checklist."</div>";
		else:
			$checklist = '';
		endif;		
				
		$variables = array(
							'%QUOTE_ID%','%VALID_TILL%','%QUOTE_NAME%',
							'%OWNER_LOGO%','%OWNER_NAME%','%OWNER_ADDRESS%','%OWNER_PHONE%',
							'%COMPANY_NAME%','%COMPANY_ADDRESS%','%COMPANY_PHONE%',
							'%QUOTE_PROJECT%','%QUOTE_MILESTONE%','%QUOTE_CHECKLIST%',
							'%QUOTE_DESCRIPTION%',
							'%QUOTE_SERVICES%',
							'%QUOTE_SUBTOTAL%','%QUOTE_DISCOUNT%','%QUOTE_TAX%','%QUOTE_TOTAL%'
						  );
		
		$replacements = array(
							$invoice->id,$invoice->validtill, $invoice->name,
							$owner->image,$owner->name,$owner->address,$owner->phone,
							$company->name,$company->address,$company->phone,
							$invoice->project,$milestone,$checklist,
							$invoice->description,
							$service_area,
							$invoice->subtotal, $invoice->discount, $invoice->tax, $invoice->total
							);
		
		$print = str_replace($variables, $replacements, $template);
		
		echo $print;

	
	}
	
}