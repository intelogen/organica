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

class JforceViewPhase extends JView {
	
	function display($tpl = null) {
        global $mainframe;
		
		$layout = $this->getLayout();
        $model = &$this->getModel();
		$uri	=& JFactory::getURI();	
        
        // survey, photoupload, direction, purchase, evaluation, signoff
		if($layout=='survey'):
			$this->_display_survey($tpl);
            return;
        elseif($layout == "photoupload"):
            $this->_display_photoupload($tpl);
            return;
        elseif($layout == "direction"):
            $this->_display_direction($tpl);
            return;
        elseif($layout == "purchase"):
            $this->_display_purchase($tpl);
            return;
        elseif($layout == "evaluation"):        
            $this->_display_evaluation($tpl);
            return;
        elseif($layout == "signoff"):
            $this->_display_signoff($tpl);
            return;
		endif;
		
		//$lists = $model->buildLists();
		
		$action = JRoute::_('index.php?option=com_jforce&view=phase&layout=results');
		
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
    
    function _display_survey($tpl){
        parent::display($tpl);      
    }
    function _display_photoupload($tpl){
		$model = &$this->getModel();
		//$phase_details = $model->get_phase_details();
        
        $phase_id = JRequest::getVar('phase_id');
        $db = JFactory::getDBO();
        
        $query = "SELECT * FROM #__jf_jtpl_phasedetails WHERE ".
                $db->nameQuote('phase_id')." = ".
                $db->Quote($phase_id)." LIMIT 1";
                
        $db->setQuery($query);
        $db->query();
        
		parent::display($tpl);
    }
    function _display_direction($tpl){
        parent::display($tpl);
    }
    function _display_purchase($tpl){
        parent::display($tpl);
    }
    function _display_evaluation($tpl){
        parent::display($tpl);
    }
    function _display_signoff($tpl){
        parent::display($tpl);                
    }

}