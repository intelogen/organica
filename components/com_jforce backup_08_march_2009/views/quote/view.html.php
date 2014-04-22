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

class JforceViewQuote extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();

		if($layout == 'print'):
			$this->_displayPrint();
			return;
		endif;

		if ($layout == 'quote') {
			$this->_displayQuote($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}
		$pid = JRequest::getVar('pid');
		$url = $pid ? 'index.php?option=com_jforce&c=accounting&view=quote&layout=form&pid='.$pid : 'index.php?option=com_jforce&c=accounting&view=quote&layout=form';
		$newQuoteLink = "	<a href='".JRoute::_($url)."' class='button'>".JText::_('New Quote')."</a>";

        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		
		$quotes = $model->listQuotes();
		
		## Show Startup Help Text ##
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$help = $configModel->getConfig('showhelp');
		
		if($help && !$quotes):
			$startupText = JForceStartupHelper::showHelp();
		else:
			$startupText = '';
		endif;
		
		$status = JRequest::getVar('status');

		$this->assignRef('status',$status);
		$this->assignRef('startupText',$startupText);		
		$this->assignRef('newQuoteLink', $newQuoteLink);
		$this->assignRef('quotes', $quotes);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('pid',$pid);
        
        parent::display($tpl);		
	}	
	
	function _displayQuote($tpl) {
        global $mainframe, $option;

		$configModel = JModel::getInstance('Configuration','JForceModel');
		$currency = $configModel->getCurrency();

		$user = &JFactory::getUser();
		$document =& JFactory::getDocument();

        $model = &$this->getModel();
		
        $quote = &$model->getQuote();
		
		$js = "window.addEvent('domready',function() {
				
			$('subscribeLink').addEvent('click',function(e) {
					e = new Event(e);
					subscribeMe('".$quote->id."','quote', '".$quote->pid."');
					e.stop();										
				});
			
			$('remindLink').addEvent('click',function(e) {
						e = new Event(e);
						remindPeople('".$quote->id."','quote');
						e.stop();										
					});
						
			   });";
		
		$document->addScriptDeclaration($js);		
		
		$owner = $quote->owner;
		
		$company = $quote->company;
		
		$services = $quote->services;
        
		$comments = JForceHelper::loadComments('quote', $quote);
		
		$tabMenu = JForceTabHelper::getTabMenu($quote);
		
		$this->assignRef('tabMenu',$tabMenu);
		$this->assignRef('owner', $owner);
		$this->assignRef('services',$services);
		$this->assignRef('company',$company);
        $this->assignRef('quote', $quote);
        $this->assignRef('option', $option);
		$this->assignRef('comments', $comments);
		$this->assignRef('currency', $currency);

		parent::display($tpl);		
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		$configModel = JModel::getInstance('Configuration','JForceModel');
		$currency = $configModel->getConfig('currency');

		// Initialize variables
		$document	=& JFactory::getDocument();
		$user		=& JFactory::getUser();
		$uri		=& JFactory::getURI();	
			
		// Load the JEditor object
		$editor =& JFactory::getEditor();

		// Initialize variables
        $model = &$this->getModel();
		JForceHelper::initValidation($model->_required);
		
        $quote = &$model->getQuote();
		
		$services = $quote->services;

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
					
					$$('#servicesArea input').addEvent('blur', function() {
							updateTotals();												 
						});
					
					$$('#servicesArea select').addEvent('change', function() {
							updateTotals();												 
						});
										
					updateTotals();
				});";
		$doc->addScriptDeclaration($js);
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('quote');
		$subscriptionFields = $subscriptionModel->buildSubscriptionFields();
		
		$subscriptionLink = 'index.php?tmpl=component&option=com_jforce&c=accounting&view=modal&action=quote&pid='.$quote->pid;
		
		// Build the page title string
		$title = $quote->id ? JText::_('Edit Quote') : JText::_('New Quote');			

		JHTML::_('behavior.modal', 'a.modal');			
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('services',$services);
		$this->assign('lists',$lists);
		$this->assignRef('title',   $title);
		$this->assignRef('quote',	$quote);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);		
		$this->assignRef('subscriptionLink',	$subscriptionLink);
		$this->assignRef('subscriptionFields',	$subscriptionFields);
		$this->assignRef('currency', $currency);
		
		parent::display($tpl);			
	}		


	function _displayPrint() {
		
		$model = &$this->getModel();
		
        $quote = &$model->getQuote();
		$params 	= & $quote->parameters;
		
		$configModel = JModel::getInstance('Configuration','JForceModel');
		$template = $configModel->getConfig('quotetemplate');

		$owner = $quote->owner;

		$company = $quote->company;
		
		$services = $quote->services;

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
		
		if($quote->milestone):
			$milestone = "<div>".JText::_('Milestone').": ".$quote->milestone."</div>";
		else:
			$milestone = '';
		endif;

		if($quote->checklist):
			$checklist = "<div>".JText::_('Checklist').": ".$quote->checklist."</div>";
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
							$quote->id,$quote->validtill, $quote->name,
							$owner->image,$owner->name,$owner->address,$owner->phone,
							$company->name,$company->address,$company->phone,
							$quote->project,$milestone,$checklist,
							$quote->description,
							$service_area,
							$quote->subtotal, $quote->discount, $quote->tax, $quote->total
							);
		
		$print = str_replace($variables, $replacements, $template);
		
		echo $print;

	
	}
	
}