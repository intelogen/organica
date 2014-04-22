<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			discussion.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JForceModelDashboard extends JModel {
	
	var $_id					= null;
	var $_dashboard				= null;
	var $_uid					= null;

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$user = JFactory::getUser();
		$this->_uid = $user->id;

	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_dashboard	= null;
	}	

	function &getDashboard()
	{
	
        global $mainframe;
		if ($this->_loadDashboard())
		{

		}
		return $this->_dashboard;
	}

	function getObjects() {
		
		$subscriptionModel =& JModel::getInstance('Subscription','JForceModel');
		$subscriptions = $subscriptionModel->buildUserSubscriptions($this->_uid);
		$sub = array();
		for($i=0;$i<count($subscriptions);$i++):
			$subscription = $subscriptions[$i];
			$sub['milestone'][] = $subscription->milestone;
			$sub['discussion'][] = $subscription->discussion;
			$sub['document'][] = $subscription->document;
			$sub['ticket'][] = $subscription->ticket;
			$sub['task'][] = $subscription->task;
			$sub['checklist'][] = $subscription->checklist;
			$sub['quote'][] = $subscription->quote;
			$sub['invoice'][] = $subscription->invoice;
		endfor;

		if(!empty($sub)):
			$objects = array();
			foreach($sub as $key => $values):
			
				# Milestones
				if($key =='milestone'):
					$milestoneModel =& JModel::getInstance('Milestone','JForceModel');
					$milestoneModel->setId($values);

					$milestones = $milestoneModel->listMilestones(1);

					if($milestones['active']):
						foreach($milestones['active'] as $m):
							$objects[$key][]=$m;
						endforeach;
					endif;
				else:
					$model = ucwords($key);
					$function = 'list'.$model.'s';

					$m =& JModel::getInstance($model,'JForceModel');
					$m->setId($values);
					$items = $m->$function();
					
					if($items):
						foreach($items as $i):
							$objects[$key][] = $i;
						endforeach;
					endif;		
					
				endif;
				
			endforeach;		
	
		$objects = JForceHelper::standardizeFields($objects);
		
		$items = array();
		if(count($objects)):
			foreach($objects as $object=>$item):
				$items[$object][] = $item;
			endforeach;
		endif;
	
	else :
		$items = array();
	endif;
    
	return $items;
	
	}
	
	function _loadDashboard()
	{
		global $mainframe;

		// Load the item if it doesn't already exist
		if (empty($this->_dashboard))
		{
			
			$this->_dashboard = $this->getObjects();
 
			if ( ! $this->_dashboard ) {
				return false;
			}
			return true;
		}
        
		return true;
	}
	
}