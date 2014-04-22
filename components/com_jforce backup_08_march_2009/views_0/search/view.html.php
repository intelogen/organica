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

class JforceViewSearch extends JView {
	
	function display($tpl = null) {
        global $mainframe;
		
		$layout = $this->getLayout();
        $model = &$this->getModel();
		$uri		=& JFactory::getURI();	

		if($layout=='results'):
			$this->_displayResults($tpl);
			return;
		endif;
		
		$lists = $model->buildLists();
		
		$action = JRoute::_('index.php?option=com_jforce&view=search&layout=results');
		
		$this->assign('action', $action);
		$this->assignRef('lists',$lists);
				
        parent::display($tpl);		
	}	
	
	function _displayResults($tpl)
	{
        $model = &$this->getModel();
		
        $results = &$model->getSearchResults();
		
		$keyword = JRequest::getVar('keyword');
                
		$this->assignRef('keyword',$keyword);		
        $this->assignRef('results', $results);

		parent::display($tpl);				
	}

}