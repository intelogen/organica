<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');


class PhaseControllerCoach extends PhaseController
{
    
    function __construct() 
    {
        parent::__construct();
        JRequest::setVar('view', 'coach');
    }
    
    function display()
    {
        $action = null;
        $action = JRequest::getVar('action');
        
        if($action)
        {
            JRequest::setVar('layout', $action);
        }
        parent::display();
    }
    
}




?>