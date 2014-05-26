<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');


class PhaseControllerMessage extends PhaseController
{
    
    function __construct() 
    {
        parent::__construct();
        JRequest::setVar('view', 'message');
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