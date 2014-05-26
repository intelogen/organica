<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');


class PhaseControllerPhase extends PhaseController
{
    
    function __construct() 
    {
        parent::__construct();
        JRequest::setVar('view', 'admin');
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