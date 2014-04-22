<?php 

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			toolbar.jforce.html.php											*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

defined('_JEXEC') or die();


class menuJforce {
	function controlPanelMenu() {
		JToolBarHelper::title( JText::_( 'JForce Configuration' ), '' );	
	}
	function defaultMenu() {
		JToolBarHelper::title( JText::_( 'JForce Configuration' ), '' );	
		JToolBarHelper::custom('cancel','back.png','back.png','Back', false);
		JToolBarHelper::custom('new','new.png','new.png','New', false);
		JToolBarHelper::custom('edit','edit.png','edit.png','Edit', true);
		JToolBarHelper::custom('trash','trash.png','trash.png','Trash', true);
	}

	function detailMenu() {
		JToolBarHelper::title( JText::_( 'JForce Configuration' ), '' );	
		if (JRequest::getVar('id') || JRequest::getVar('cid')) {
			JToolBarHelper::custom('cancel','cancel.png','cancel.png','Cancel', false);
		} else {
			JToolBarHelper::custom('cancel','cancel.png','cancel.png','Close', false);
		}
		JToolBarHelper::custom('save','save.png','save.png','Save', false);
	}

	function generalMenu() {
		JToolBarHelper::title( JText::_( 'JForce Configuration' ), '' );	
		JToolBarHelper::custom('cancel','cancel.png','cancel.png','Cancel', false);
		JToolBarHelper::custom('save','save.png','save.png','Save', false);
	}

	function templatesMenu() {
		JToolBarHelper::title( JText::_( 'JForce Configuration' ), '' );	
		JToolBarHelper::custom('cancel','cancel.png','cancel.png','Cancel', false);
		JToolBarHelper::custom('save','save.png','save.png','Save', false);
	}

	function categoryMenu() {
		JToolBarHelper::title( JText::_( 'JForce Configuration' ), '' );	
		JToolBarHelper::custom('cancel','cancel.png','cancel.png','Cancel', false);
		JToolBarHelper::custom('save','save.png','save.png','Save', false);
	}
}