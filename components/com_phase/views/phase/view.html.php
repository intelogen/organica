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
        
        
        
        
        if ($redirect == '1')
        {
        $url = "index.php?option=com_phase&controller=admin";
        }
        elseif ($redirect == '2')
        {
        $url = "index.php?option=com_phase&controller=coach";
        }
        elseif ($redirect == '4')
        {
        $url = "index.php?option=com_phase&controller=client";
        }
	
        else
	{
            $url = "index.php";
	}
        $mainframe->redirect($url);
        




        parent::display($tpl);
    }
    
    
}



?>