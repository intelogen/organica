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
    
    
    function read_messages($tpl = null)
    {
        $id = JRequest::getVar('id');
        $user =& JFactory::getUser();
        $sendUserId = $user->id;
        
        $model = $this->getModel();
        $result = $model->getMessageBody($id, $sendUserId);
        $sendUserInfo = $model->getSendUserInfo($sendUserId);
        foreach ($sendUserInfo as $value)
        {
            $sendUserInfo = $value->firstname." ".$value->lastname;     
        }
        
        
        $this->assignRef('result', $result);
        $this->assignRef('sendUserInfo', $sendUserInfo);
        parent::display($tpl);
    }
    
    function send_message($tpl = null)
    {
        $model = $this->getModel();

        $result = $model->sendMassege();
        
        if ($result)
        {
            $msg = JText::_('Message send');
        }
        else
        {
            $msg = JText::_('Message not send');
        }
        
        global $mainframe;
        $mainframe->redirect("index.php?option=com_phase&view=message", $msg);
          
        
        parent::display($tpl);
    }
    
    function inbox_messages($tpl = null)
    {
        $user =& JFactory::getUser();
        $userId = $user->id;
        $model =  $this->getModel();
        
        $newMassage = $model->getNewMessage($userId); 
        $result = $model->getInboxMessage($userId); 
        
        $users = $model->getUserLIst();
        foreach ($users as $key => $value)
        {
            $usersIdName[$value->uid] = $value->firstname." ".$value->lastname; 
        }
        
        $this->assignRef('newMessage', $newMassage);
        $this->assignRef('usersIdName', $usersIdName);
        $this->assignRef('inbox', $result);
        
        
        
        parent::display($tpl);
    }
    
    function sent_messages($tpl = null)
    {
        $user =& JFactory::getUser();
        $userId = $user->id;
        $model =  $this->getModel();
        
        $result = $model->getSentMessage($userId); 
        
        $users = $model->getUserLIst();
        foreach ($users as $key => $value)
        {
            $usersIdName[$value->uid] = $value->firstname." ".$value->lastname; 
        }
        
        $this->assignRef('usersIdName', $usersIdName);
        $this->assignRef('sent', $result);
        
        
        
        parent::display($tpl);
    }
    
    function create_message($tpl = null)
    {
        $user =& JFactory::getUser();
        $userId = $user->id;
        
        $model =  $this->getModel();
        $sendUserInfo = $model->getSendUserInfo($userId);
        
        if($sendUserInfo != null)
        {
        foreach ($sendUserInfo as $value)
        {
            $sendUserInfo = $value->firstname." ".$value->lastname;
        }
        }
        
        $this->assignRef('sendUserInfo', $sendUserInfo);
        $this->assignRef('userId', $userId);
        
        $isCoach = $model->isCoach($userId);
        if(count($isCoach) == 0)
        {
            $coachId = $model->getCoachId($userId);
            foreach ($coachId as $value)
            {
                $mto = $value->owner;
            }
            $this->assignRef('mto', $mto);    
        }
        else
        {
            foreach ($isCoach as $value)
            {
                $companyId = $value->id;
            }
            $clientInfo = $model->getClientInfo($companyId, $userId);
            $this->assignRef('clientInfo', $clientInfo);
        }
        
        
        parent::display($tpl);
    }
    
}



?>