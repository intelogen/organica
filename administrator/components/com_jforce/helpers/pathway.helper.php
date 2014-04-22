<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			pathway.helper.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
// Component Helper
jimport('joomla.application.component.helper');


class JForcePathwayHelper {

	function getPathway() {
		
		global $mainframe;
	
		$view = JRequest::getVar('view');
		$layout = JRequest::getVar('layout','default');

		$pid = JRequest::getVar('pid',0);
		$id = JRequest::getVar('id',0);
		
		$title = $id ? JText::_('Edit '.ucwords($view)) : JText::_('New '.ucwords($view)); 
		
		if($pid):
			$projectModel =& JModel::getInstance('Basic','JForceModel');
			$project = $projectModel->getBasic();
		endif;
		
		$pathway =& $mainframe->getPathway();
		
		if ($pid) :
			$pathway->addItem(JText::_('All Projects'), JRoute::_('index.php?option=com_jforce&view=basic'));	
			$pathway->addItem(JText::_($project->name), JRoute::_('index.php?option=com_jforce&view=basic&layout=basic&pid='.$pid));
		endif;
		
		$plural = JForcePathwayHelper::pluralize($view);
		
		if($layout=='default'):
			$pathway->addItem(JText::_('List '.ucwords($plural)));
		elseif($view!='basic' && $layout!='form'):
			$pathway->addItem(JText::_('List '.ucwords($plural)), JRoute::_('index.php?option=com_jforce&pid='.$pid.'&view='.$view));
			$pathway->addItem(JText::_(ucwords($layout)));
		elseif($layout=='form'):
			$pathway->addItem(JText::_('List '.ucwords($plural)), JRoute::_('index.php?option=com_jforce&pid='.$pid.'&view='.$view));
			$pathway->addItem($title);
		endif;
	}
	
	function pluralize($word) {
		
		if ($word == 'company') :
			$plural = 'companies';
		else:
			$plural = $word.'s';
		endif;
		
		return $plural;
	}

}