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
        $ud = JFactory::getUser()->id;
        if( $ud == "" ||  $ud == 0 ||  $ud == null){
            $url = "index.php";
            $msg = "you tried to get access to the closed part of the system, please register first";
            global $mainframe;
            $mainframe->redirect($url, $msg);
        }
        if($action)
        {
            JRequest::setVar('layout', $action);
        }
        parent::display();
    }
    
}




?>