<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');


class PhaseViewMessage extends JView
{
    function display($tpl = null)
    {
        $layout = JRequest::getVar('layout');
        if ($layout)
        {
            $this->$layout($tpl);
            return;
            
        }
        
        
        $user =& JFactory::getUser();
        $userId = $user->id;
        $model =  $this->getModel();
        
        $result = $model->getNewMessage($userId); 
        
        $users = $model->getUserLIst();
        foreach ($users as $key => $value)
        {
            $usersIdName[$value->uid] = $value->firstname." ".$value->lastname; 
        }
        
        $this->assignRef('usersIdName', $usersIdName);
        $this->assignRef('newMessage', $result);
        
        
        parent::display($tpl);
    }
    
    
    
}



?>