<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');


class PhaseViewMeal extends JView
{
    function display($tpl = null)
    {
        $layout = JRequest::getVar('layout');
        if ($layout)
        {
            $this->$layout($tpl);
            return;
            
        }
        
        parent::display($tpl);
    }
    
    
    function mealplan($tpl = null)
    {
        parent::display($tpl);
    }
    
    function mealplancreate($tpl = null)
    {
        parent::display($tpl);
    }
    
    
    
}



?>