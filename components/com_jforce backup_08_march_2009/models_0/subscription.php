<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			subscription.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelSubscription extends JModel {
	 
	 var $_id					= null;
	 var $_pid					= null;
	 var $_action				= null;
	 var $_type					= null;
	 var $currentSubscriptions	= null;
	 var $possibleSubscriptions	= null;
	 var $_emailVariables		= array('%TYPE%','%TITLE%', '%DATE%', '%PROJECT%','%DESCRIPTION%', '%AUTHOR%','%LINK%','%COMPANY%');
	
    function __construct() {
    	
        parent::__construct();
		
		$this->setId(JRequest::getVar('id', ''));
		$this->setPid(JRequest::getVar('pid', ''));
		$this->setAction(JRequest::getVar('action', ''));
	
	}
	
	function setId($id) {
		$this->_id = (int) $id;	
	}
	
	function setPid($pid) {
		$this->_pid = (int) $pid;	
	}
	
	function setAction($action) {
		$this->_action = $action;	
	}
	
	function setType($type) {
		$this->_type = $type;	
	}
	
	function buildWhere() {
		$where = null;
		
		$assignment = $this->_type == 'assignment' ? 1 : 0;
	
		$where = " AND s.assignment = '$assignment'";

		
		return $where;
	}
	
	function loadCurrentSubscriptions() {
		
		if (!$this->_id) :
			return array();
		endif;
		
		$where = $this->buildWhere();
		
		$query = "SELECT DISTINCT(u.id), u.name, u.email, p.id AS person_id"
		."\n FROM #__jf_subscriptions AS s"
		."\n LEFT JOIN #__users AS u ON u.id = s.uid"
		."\n LEFT JOIN #__jf_persons AS p ON p.uid = u.id"
		."\n WHERE s.project = '$this->_pid'"
		."\n AND s.".$this->_action." = '$this->_id'"
		."\n ".$where
		."\n ORDER BY s.primary DESC"
		;
		
		$this->_db->setQuery($query);
		$this->currentSubscriptions = $this->_db->loadObjectList();
		
		return $this->currentSubscriptions;
	
	}
	
	
	function loadPossibleSubscriptions() {
		$where = $this->buildWhere();
		$query = "SELECT u.id, u.name, c.name AS company"
		."\n FROM #__jf_projectroles_cf AS r"
		."\n LEFT JOIN #__users AS u ON u.id = r.uid"
		."\n LEFT JOIN #__jf_persons AS p ON p.uid = r.uid"
		."\n LEFT JOIN #__jf_companies AS c ON c.id = p.company"
		."\n WHERE r.pid = '$this->_pid'"
		."\n AND p.id <> ''"
		."\n ORDER BY c.admin DESC"
		;
		
		$this->_db->setQuery($query);
		$this->possibleSubscriptions = $this->_db->loadObjectList();
		return $this->possibleSubscriptions;
	}
	
	function save($selectedUsers) {

		$selectedUsers = $selectedUsers ? $selectedUsers : array();

		$currentSubscriptions = $this->loadCurrentSubscriptions();
		
		$curr = array();
		for ($i=0; $i<count($currentSubscriptions); $i++) :
			$curr[] = $currentSubscriptions[$i]->id;
		endfor;
		
		$toDelete = array_diff($curr, $selectedUsers);
		$toAdd = array_diff($selectedUsers, $curr);
		
		$this->deleteSubscriptions($toDelete);
		$this->addSubscriptions($toAdd);
		
		if ($this->_type == 'assignment' && isset($selectedUsers[0])) :	
			$this->assignPrimary($selectedUsers[0]);
		endif;
	}
	
	function assignPrimary($uid) {
		$query = "UPDATE #__jf_subscriptions SET `primary` = '0' WHERE ".$this->_action." = '$this->_id' AND project = '$this->_pid'";
		$this->_db->setQuery($query);
		$this->_db->query();
		
		$query = "UPDATE #__jf_subscriptions SET `primary` = '1' WHERE ".$this->_action." = '$this->_id' AND project = '$this->_pid' AND uid = '$uid'";
		$this->_db->setQuery($query);
		$this->_db->query();
	}
	
	function subscribeMe($post) {
		$user = &JFactory::getUser();
		$this->setId($post['id']);
		$this->setPid($post['pid']);
		$this->setAction($post['type']);
		
		$ids = array($user->id);
		
		$query = "SELECT id FROM #__jf_subscriptions WHERE ".$this->_action." = '$this->_id' AND uid = '$user->id'";
		$this->_db->setQuery($query);
		$subscribed = $this->_db->loadResult();
		
		if ($subscribed) :
			$this->deleteSubscriptions($ids);
			$return = JText::_('Subscribe');
		else :
			$this->addSubscriptions($ids);
			$return = JText::_('Unsubscribe');
		endif;
		
		return $return;
	}
	
	function addSubscriptions($toAdd) {
		
		if ($toAdd) :
			foreach ($toAdd as $a) :
				$sub = JTable::getInstance("Subscription");
				$field = $this->_action;
				$sub->uid = $a;
				$sub->$field = $this->_id;
				$sub->project = $this->_pid;
				$sub->assignment = $this->_type == 'assignment' ? 1 : 0;
				$sub->store();
			endforeach;
		endif;
		
	}

	function deleteSubscriptions($toDelete) {
		$ids = "uid = '".implode("' OR uid = '",$toDelete)."'";
		
		$query = "DELETE FROM #__jf_subscriptions"
		."\n WHERE ".$this->_action." = '$this->_id' AND (".$ids.")"
		;
		$this->_db->setQuery($query);
		$this->_db->query();
	
	}

	function getObjectStatus($object, $type)
	{
		$user = JFactory::getUser();
		
		$query = "SELECT COUNT(*) FROM #__jf_objectviews ".
				 " WHERE object='$object' ".
				 " AND type='$type' ".
				 " AND uid='$user->id' ".
		$this->_db->setQuery($query);

		$result = $this->_db->loadResult();
		
		if($result):
			$read = "<img src='components".DS."com_jforce".DS."images".DS.$type."icon_new.png' />";
		else:
			$read = "<img src='components".DS."com_jforce".DS."images".DS.$type."icon.png' />";
		endif;
		
		return $read;
	}

	function sendMail($values, $object, $type, $emailType) {
		
		$this->setId($object->id);
		$this->setPid($object->pid);
		$this->setAction($type);
		
		$subscribers = $this->loadCurrentSubscriptions();
		
		$this->setType('assignment');
		$assignees = $this->loadCurrentSubscriptions();
	
		$link = JRoute::_('index.php?option=com_jforce&view='.$type.'&layout='.$type.'&pid='.$object->pid.'&id'.$object->id);
		$linkURI = JURI::getInstance($link);
		$queryString = $linkURI->getQuery();
		$link = JURI::base().'index.php?'.$queryString;
		$values['link'] = $link;
	
		$configModel = &JModel::getInstance('Configuration', 'JForceModel');
		$subject = $configModel->getConfig('emailsubject');
		$body = $configModel->getConfig('emailbody');
	
		$companyModel = &JModel::getInstance('Company', 'JForceModel');
		$company = $companyModel->getAdminCompany();
		$values['company'] = $company->name;
		
		$subject = str_replace($this->_emailVariables, $values, $subject);
		$body = str_replace($this->_emailVariables, $values, $body);
		
		$subject = ucwords($type).' '.JText::_('Notification').': '.$subject;
		
		if ($emailType == 1) :
			$subject = JText::_('New').' '.$subject;
		endif;
		
		for ($i=0; $i<count($subscribers); $i++) :
			$mail = JFactory::getMailer();
			$user = $subscribers[$i];
			$mail->addRecipient($user->email);
			$mail->setSubject($subject);
			$mail->setBody($body);
			$mail->send();
		endfor;
		
		for ($i=0; $i<count($assignees); $i++) :
			$mail = JFactory::getMailer();
			$user = $assignees[$i];
			$mail->addRecipient($user->email);
			$mail->setSubject($subject);
			$mail->setBody($body);
			$mail->send();
		endfor;
		
	}
	
	function buildSubscriptionFields() {
	
		$current = $this->loadCurrentSubscriptions();
		$subs = null;
		$hidden = null;
		$html = null;
		
		if ($this->_type == 'assignment') :
			for ($i=0; $i<count($current); $i++) :
				$c = $current[$i];
				$subs .= '<div class="assignedList" id="asgmntVisible_'.$c->id.'">'.$c->name.'</div>';
				$hidden .= '<input type="hidden" id="asgmntHidden_'.$c->id.'" name="hiddenAssignment[]" value="'.$c->id.'" />';
			endfor;
			$style = $subs ? 'style="display:none;"' : '';
			$html = '<div id="currentAssignments">';
			$html .= $subs;
			$html .= '</div>';
			$html .= '<div id="hiddenAssignments">';
			$html .= $hidden;
			$html .= '</div>';
			$html .= '<div id="noAssignments" class="empty" '.$style.'>'.JText::_('No Assignees').'</div>';
		else:
			for ($i=0; $i<count($current); $i++) :
				$c = $current[$i];
				$subs .= '<div class="subscribedList" id="subVisible_'.$c->id.'">'.$c->name.'</div>';
				$hidden .= '<input type="hidden" id="subHidden_'.$c->id.'" name="hiddenSubscription[]" value="'.$c->id.'" />';
			endfor;
			$style = $subs ? 'style="display:none;"' : '';
			$html = '<div id="currentSubscriptions">';
			$html .= $subs;
			$html .= '</div>';
			$html .= '<div id="hiddenSubscriptions">';
			$html .= $hidden;
			$html .= '</div>';
			$html .= '<div id="noSubscriptions" class="empty" '.$style.'>'.JText::_('No Subscribers').'</div>';
		endif;
		
		return $html;
	}
	
	function checkSubscriptionStatus($user, $id, $type) {
		
		$query = "SELECT COUNT(*) FROM #__jf_subscriptions WHERE ".$type." = '$id' AND uid = '$user'";
		$this->_db->setQuery($query);
		$status = $this->_db->loadResult();
		
		return $status;
	}
	
	function buildUserSubscriptions($user, $owner = false) {
	
		$where = " WHERE uid = '$user'";
		
		if($this->_type):
			$where .= " AND $this->_type > 0";
		endif;
	
		if($owner):
			$where .= ' AND assignment = 1 ';
		endif;
	
		$query = "SELECT * FROM #__jf_subscriptions"
				 .$where;
				 
		$this->_db->setQuery($query);
		$subscriptions = $this->_db->loadObjectList();
			
		return $subscriptions;
	}
	
	function buildUserSubscriptionIdList($user, $owner = false) {
		
			$subscribedTasks = $this->buildUserSubscriptions($user, $owner);		
			$taskIds = array();
			for($i=0;$i<count($subscribedTasks);$i++):
				$subscribedTask = $subscribedTasks[$i];
				$taskIds[] = $subscribedTask->task;
			endfor;
			
			return $taskIds;	
	}
	
}