<?php

/********************************************************************************
*	@package		Joomla														*
*	@subpackage		jForce, the Joomla! CRM										*
*	@version		2.0															*
*	@file			menu.helper.php												*
*	@updated		2008-12-15													*
*	@copyright		Copyright (C) 2008 - 2009 JoomPlanet. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								*
********************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
// Component Helper
jimport('joomla.application.component.helper');


class JForceTabHelper {
	
function getTabMenu($object, $subscribe = true, $remind = true) {
	
	$user =& JFactory::getUser();
	$view = JRequest::getVar('view');
	$c = JRequest::getVar('c','project');
	$ucView = ucwords($view);
	
	$menu = array();
	$i = 0;

	# EDIT MENU ITEM #
	if($c=='project' && $view!='project'):
		$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&view='.$view.'&layout=form&pid='.$object->pid.'&id='.$object->id);
	elseif($c=='project' && $view == 'project'):
		$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&c='.$c.'&view='.$view.'&layout=form&pid='.$object->id);   
	else:
		$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&c='.$c.'&view='.$view.'&layout=form&id='.$object->id);
	endif;
	
	$menu[$i]['Options'] = "";		
	$menu[$i]['Text'] = JText::_('Edit ' . $ucView);
	$i++;
	
	# TRASH MENU ITEM #
	$menu[$i]['Link'] = '';
	$menu[$i]['Text'] = JForceHelper::getTrashLink($object, $view);
	$i++;
	
	if($subscribe):
		# SUBSCRIBE MENU ITEM #
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$status = $subscriptionModel->checkSubscriptionStatus($user->id, $object->id, $view);
		$subscribeText = $status ? JText::_('Unsubscribe') : JText::_('Subscribe');
	
		$menu[$i]['Link'] = '#';
		$menu[$i]['Options'] = "id='subscribeLink'";	
		$menu[$i]['Text'] = $subscribeText;
		$i++;
	endif;
	
	if($remind):
		# REMIND MENU ITEM #
		$menu[$i]['Link'] = '#';
		$menu[$i]['Options'] = "id='remindLink'";	
		$menu[$i]['Text'] = JText::_('Remind');					
		$i++;
	endif;
	
	if($view=='checklist'):
		$menu[$i]['Link'] = JRoute::_("index.php?option=com_jforce&view=task&layout=form&pid=".$object->pid."&cid=".$object->id);
		$menu[$i]['Options'] = "id='addTask'";
		$menu[$i]['Text'] = JText::_('New Task');
		$i++;
	endif;

	if($view=='company'):
		$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&c=people&view=person&layout=form&company='.$object->id);
		$menu[$i]['Options'] = "";	
		$menu[$i]['Text'] = JText::_('New Client'); 
		$i++;
	endif;
	
	if($view=='document'):
	    $menu[$i]['Link'] = $object->file->downloadUrl;
		$menu[$i]['Options'] = "";			
		$menu[$i]['Text'] = JText::_('Download');
        $i++;
		
		$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&view=document&layout=version&pid='.$object->pid.'&document='.$object->id);
		$menu[$i]['Options'] = "";			
		$menu[$i]['Text'] = JText::_('New Version'); 
		$i++;
	endif;
	
	if($view=='invoice' || $view=='quote'):
		$menu[$i]['Link'] = "javascript:copyObject('".$object->id."','invoice');";
		$menu[$i]['Options'] = "";			
		$menu[$i]['Text'] = JText::_('Copy '.$ucView);
		$i++;
		
		$menu[$i]['Link'] = '#';
		$menu[$i]['Options'] = "";			
		$menu[$i]['Text'] = JText::_('Email'); 
		$i++;
		
		$menu[$i]['Link'] = JRoute::_('index.php?option=com_jforce&c=accounting&view=invoice&layout=print&id='.$object->id.'&tmpl=component');
		$menu[$i]['Options'] = "onclick=\"window.open(this.href,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no'); return false;\"";
		$menu[$i]['Text'] = JText::_('Print');
		$i++;
	endif;
	
	if($view=='milestone'):
		$menu[$i]['Link'] = $object->rescheduleLink;
		$menu[$i]['Options'] = "id='rescheduleLink'";
		$menu[$i]['Text'] = JText::_('Reschedule');
		$i++;
		
		$menu[$i]['Link'] = '#';
		$menu[$i]['Options'] = "id='toggleLink'";
		$menu[$i]['Text'] = $object->completed ? JText::_('Reopen') : JText::_('Complete'); 
		$i++;
	endif;
	
	if($view=='project'):
		$menu[$i]['Link'] = "javascript:copyProject('".$object->id."');";
		$menu[$i]['Options'] = '';
		$menu[$i]['Text'] = JText::_('Copy Project'); 
		$i++;
		
	endif;
	
	return $menu;
	
}

function getActiveItem() {
	
}

	function getAdminSubMenu() {
		$subMenus = array(
		'General' => 'index.php?option=com_jforce&view=configuration&layout=general',
		'Templates' => 'index.php?option=com_jforce&view=configuration&layout=templates',
		'Categories' => 'index.php?option=com_jforce&view=configuration&layout=categories',
		'System Access' => 'index.php?option=com_jforce&view=role&type=system',
		'Services' => 'index.php?option=com_jforce&view=service',
		'Custom Fields' => 'index.php?option=com_jforce&view=customfield',
		'Payment Gateways' => 'index.php?option=com_jforce&view=plugin&type=gateway',
		'Plugins' => 'index.php?option=com_jforce&view=plugin'
		);
		
		$uri = &JFactory::getURI();
		$current = 'index.php?'.$uri->getQuery();
		
		foreach ($subMenus as $name => $link) {
			$active = $current == $link ? true : false;
			JSubMenuHelper::addEntry(JText::_( $name ), $link, $active);
		}	
		
	}

}