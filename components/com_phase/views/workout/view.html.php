<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');


class PhaseViewWorkout extends JView
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
    
    
    
    
}



?>