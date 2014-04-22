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
        parent::display();
    }
    
    function add()
    {
        JRequest::setVar('layout', 'form');
        parent::display();
    }
    
    function save()
    {
        parent::display();
    }
    
    function cancel()
    {
        global $mainframe;
        $mainframe->redirect('index.php?option=com_phase&controller=coach');
    }
    
    
    
}
?>