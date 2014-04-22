<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			modal.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelModal extends JModel {
	 
	 var $_id		= null;
	 var $_pid		= null;
	 var $_action	= null;
	
    function __construct() {
    	
        parent::__construct();
		
		$this->_action = JRequest::getVar('action', '');
		$this->_id = JRequest::getVar('id', '');
		$this->_pid = JRequest::getVar('pid', '');
	
	} 
	
	function buildSubscriptionLists() {
				
		$subModel = &JModel::getInstance('Subscription', 'JforceModel');
		
		$unsubscribed = $subModel->loadPossibleSubscriptions();
		
		$subscribed = $subModel->loadCurrentSubscriptions();
		
		$unsub = array();
		for ($i=0; $i<count($unsubscribed); $i++) :
			$u = $unsubscribed[$i];
			
			if ($i == 0) :
				$unsub[] = JHTML::_('select.optgroup', $u->company);
			elseif ($u->company != $unsubscribed[$i-1]->company) :
				$unsub[] = JHTML::_('select.optgroup', $u->company);
			endif;
			
			$unsub[] = JHTML::_('select.option', $u->id, $u->name);
		endfor;
		
		$lists['unsubscribed'] = JHTML::_('select.genericlist', $unsub, 'unsubscribed', 'class="modalSelect" size="10" multiple ','value', 'text', '', 'unsubSelect');
		
		$current = null;
		for ($i=0; $i<count($subscribed); $i++) :
			$s = $subscribed[$i];
			$current .= '<div id="selectedUser_'.$s->id.'" class="selectedUser"><span id="selectedUserName_'.$s->id.'">'.$s->name.'</span><a href="#" class="removeLink" id="remove_'.$s->id.'">x</a><input value="'.$s->id.'" name="selectedUsers[]" type="hidden"></div>';
		endfor;
		
		$lists['subscribed'] = $current;
		
		return $lists;
		
	}
	
	function buildPeopleList() {
		$personModel = &JModel::getInstance('Person', 'JforceModel');
		$personModel->setId(null);
		$personModel->setPid(null);
		$personModel->setType(0);
		
		$people = $personModel->listPersons();
		
		$personModel->setPid($this->_pid);
		$doNotAdd = $personModel->listPersons();
		$dna = array();
		for ($i=0; $i<count($doNotAdd); $i++) :
			$id = $doNotAdd[$i]->id;
			$dna[] = $id;
		endfor;
		
		$k = 0;
		$unsub = array();
		$companies = array();
		for ($i=0; $i<count($people); $i++) :
			$p = $people[$i];
			
			if (!in_array($p->id, $dna)) :
				$companies[$k] = $p->company;
				if ($i == 0) :
					$unsub[] = JHTML::_('select.optgroup', $p->company);
				elseif ((isset($companies[$k-1]) && ($p->company != $companies[$k-1])) || $k==0) :
					$unsub[] = JHTML::_('select.optgroup', $p->company);
				endif;
			
				$unsub[] = JHTML::_('select.option', $p->uid, $p->name);
				$k++;
			endif;
		endfor;
		
		$lists['unsubscribed'] = JHTML::_('select.genericlist', $unsub, 'unsubscribed', 'class="modalSelect" size="10" multiple ','value', 'text', '', 'unsubSelect');

		return $lists;
	}
	
	function buildLists() {
		$lists['projectroles'] = JforceListsHelper::getAccessRoleList();	
		return $lists;
	}
	
	
}