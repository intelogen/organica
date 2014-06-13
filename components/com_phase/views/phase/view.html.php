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
        $admin = $model->isAdmin($userId);
        
        
        
        
        
        
        
        
        $user =& JFactory:: getUser();
        $userId = $user->id;
        global $mainframe;

        
        
        if ($userId == 430)
        {
        $url = "index.php?option=com_phase&controller=coach";
        }
        elseif ($userId == 431)
        {
        $url = "index.php?option=com_phase&controller=client";
        }
        elseif ($userId == 432)
        {
        $url = "index.php?option=com_phase&controller=client";
        }
        elseif ($userId == 435)
        {
        $url = "index.php?option=com_phase&controller=client";
        }
        elseif ($userId == 62)
        {
        $url = "index.php?option=com_phase&controller=admin";
        }
		else
		{
		$url = "index.php?option=com_phase";
		}
        $mainframe->redirect($url);
        




        parent::display($tpl);
    }
    
    
}



?>