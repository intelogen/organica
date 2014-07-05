<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');


class PhaseViewPhase extends JView
{
    function display($tpl = null)
    {
        $user =& JFactory:: getUser();
        $userId = $user->id;
        
        global $mainframe;
        $model = $this->getModel();
       
        $redirect = $model->redirectTo($userId);
        
        
        
        
        if ($redirect == '1'){
        $url = "index.php?option=com_phase&controller=admin";
        $msg = "Welcome";
        }elseif ($redirect == '2'){
        $url = "index.php?option=com_phase&controller=coach";
        $msg = "Welcome";
        }elseif ($redirect == '4'){
        $url = "index.php?option=com_phase&controller=client";
        $msg = "Welcome";
        } else{
            $url = "index.php";
            $msg = "you tried to get access to the closed part of the system, please register first";
	}
        $mainframe->redirect($url, $msg);
        




        parent::display($tpl);
    }
    
    
}



?>