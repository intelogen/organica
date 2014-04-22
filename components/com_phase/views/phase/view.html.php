<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');


class PhaseViewPhase extends JView
{
    function display($tpl = null)
    {
        /*
        $model = $this->getModel();
        $admin = 0;
        $coach = 0;
        $client = 0;
        
        $user =& JFactory:: getUser();
        $userId = $user->id;
        global $mainframe;

        
        $admin = $model->isAdmin($userId);
        //echo 'admin = '.$admin;
        
        
        $coach = $model->isCoach($userId);
        //echo 'coach = '.$coach;
        
        if ($admin == 0 && $coach == 0)
        {$client = 1;}
        //echo 'client = '.$client;
        
        if ($admin == 1)
        {
        $url = "index.php?option=com_phase&controller=admin";
        }
        elseif ($coach == 1)
        {
        $url = "index.php?option=com_phase&controller=coach";
        }
        elseif ($client == 1)
        {
        $url = "index.php?option=com_phase&controller=client&action=deshbord";
        }
        
        
        $mainframe->redirect($url);
        */




        parent::display($tpl);
    }
}



?>