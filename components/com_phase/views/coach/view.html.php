<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');


class PhaseViewCoach extends JView
{
    function display($tpl = null)
    {
        
        
        $layout = JRequest::getVar('layout');
        if ($layout)
        {
            $this->$layout($tpl);
            return;
            
        }
         
        parent::display($tpl);
    }
    //все пользователи определённого тренера
    function show_all_users($tpl = null)
    {
        $user =& JFactory::getUser();
        $coachId = $user->id;
        $model = $this->getModel();
        $clients = $model->getClients($coachId);
        $this->assignRef('clients', $clients);
        $this->assignRef('coachId', $coachId);
        
        
        parent::display($tpl);
    }
    
    
    // вывод выбранного клиента 
    function show_user_info($tpl = null)
    {
        $model = $this->getModel();
        $userId = JRequest::getVar('userId');
        $clientInfo = $model->getClintInfo($userId);
        $this->assignRef('clientInfo', $clientInfo);
        $user =& JFactory::getUser();
        $coachId = $user->id;
        
        $phases = $model->getUserPhasees($userId, $coachId);
        $this->assignRef('phases', $phases);
        
        
        
        parent::display($tpl);
    }
    
    
    function edit($tpl = null)
    {
        //редактируем фазы
        $model = $this->getModel(); 
        global $mainframe;
        if(JRequest::getVar('phase'))
        {
            if(!$phaseId = JRequest::getVar('phaseId'))
            {
                $userId = JRequest::getVar('userId');
                $mainframe->redirect("index.php?option=com_phase&controller=coach&action=show_user_info&userId=$userId", 'Phase not select');
            }
            $phaseData = $model->editPhase($phaseId);
            $this->assignRef('phaseData', $phaseData);
            
        }
        
        if (JRequest::getVar('task'))
        {
            
            if(!JRequest::getVar('taskId'))
            {
                echo 'Написать редирект';
            }
            
            //var_dump( JRequest::get('post'));
            $taskContent = $model->getTaskContent(JRequest::getVar('taskId'));
            $this->assignRef('taskContent', $taskContent);
            
        }
        
        parent::display($tpl);
    }
    // заносим изминения фазы
    function edit_phase($tpl =null)
    {
        global $mainframe;
        if(JRequest::getvar('cancel'))
            {
            echo '<pre>';
            var_dump(JRequest::get('post'));
            
            $userId = JRequest::getVar('userId');
            $mainframe->redirect("index.php?option=com_phase&controller=coach&action=show_user_info&userId=$userId");
            }
            
        $model = $this->getModel();
        $result = $model->recordPhase();
        
        if ($result)
        {
            $msg = JText::_('Phase edit');
        }
        else
        {
            $msg = JText::_('Phase not edit');
        }
        $userId = JRequest::getVar('userId');
        $mainframe->redirect("index.php?option=com_phase&controller=coach&action=show_user_info&userId=$userId", $msg);
            
        parent::display($tpl);
    }
    
    //удаляем фазу
    function delete($tpl = null)
    {
        global$mainframe;
        if(JRequest::getVar('phase'))
        {
            $userId = JRequest::getVar('userId');
             
            if(!$phaseId = JRequest::getVar('phaseId'))
            {
                $mainframe->redirect("index.php?option=com_phase&controller=coach&action=show_user_info&userId=$userId", 'Phase not select');
            }
            
            $model= $this->getModel();
            $result = $model->deletePhase($phaseId);
            
            if ($result)
        {
            $msg = JText::_('Phase delete');
        }
        else
        {
            $msg = JText::_('Phase not delete');
        }
        $mainframe->redirect("index.php?option=com_phase&controller=coach&action=show_user_info&userId=$userId", $msg);
            
        }
        
        if(JRequest::getVar('task'))
        {
            
            $taskId = JRequest::getVar('taskId');
            $model= $this->getModel();
            $result = $model->deleteTask($taskId);
            
            if ($result)
        {
            $msg = JText::_('Task delete');
        }
        else
        {
            $msg = JText::_('Task not delete');
        }
        $mainframe->redirect("index.php?option=com_phase&controller=coach&action=show_all_users", $msg);
            
        }
        
        parent::display($tpl);
    }
    
    //добавляем новую фазу
    function create($tpl = null)
    {
        global $mainframe;
        if(JRequest::getVar('phase'))
        {
            $model = $this->getModel();
            $coachCompanyId = $model->getCoachCompanyId(JRequest::getVar('coachId'));
            
            foreach ($coachCompanyId as $coachCompanyId) {$coachCompanyId = $coachCompanyId->id; }
            $result = $model->addPhase($coachCompanyId);
            
            if ($result)
        {
            $msg = JText::_('Phase create');
        }
        else
        {
            $msg = JText::_('Phase not create');
        }
        $userId = JRequest::getVar('userId');
        $mainframe->redirect("index.php?option=com_phase&controller=coach&action=show_user_info&userId=$userId", $msg);
           
        }
        
        if(JRequest::getVar('task'))
        {
            $model = $this->getModel();
            $result = $model->addTask();
            
            if ($result)
        {
            $msg = JText::_('Task save');
        }
        else
        {
            $msg = JText::_('Task not save');
        }
        $mainframe->redirect("index.php?option=com_phase&controller=coach&action=show_all_users", $msg);
        
        
        }
        
        
        parent::display($tpl);
    }
    
    function show($tpl = null)
    {
        if(JRequest::getVar('phase'))
        {
            $phaseId = JRequest::getVar('phaseId');
            $model = $this->getModel();
            $taskList = $model->getTaskList(JRequest::getVar('phaseId'));
            $this->assignRef('taskList', $taskList);
            $this->assignRef('phaseId', $phaseId);   
        }
        parent::display($tpl);
    }
    
    function edit_task($tpl = null)
    {
        global $mainframe;
        if(JRequest::getVar('cancel'))
        {
            $mainframe->redirect("index.php?option=com_phase&controller=coach&action=show_all_users");
        }
        $model = $this->getModel();
        $result = $model->editTask();
        
        if ($result)
        {
            $msg = JText::_('Task save');
        }
        else
        {
            $msg = JText::_('Task not save');
        }
        $mainframe->redirect("index.php?option=com_phase&controller=coach&action=show_all_users", $msg);
           
        
        parent::display($tpl);
    }
    
    function edit_information($tpl = null)
    {
        $user =& JFactory:: getUser();
        $userId = $user->id;
        $model = $this->getModel();
        $coachInfo = $model->edit_information($userId);
        $this->assignRef('row', $coachInfo);
        
        parent::display($tpl);
    }
    
    function edit_coach($tpl =null)
    {
        if(JRequest::getVar('cancel'))
        {
            global $mainframe;
        $mainframe->redirect("index.php?option=com_phase&controller=coach");
        }
        $model = $this->getModel();
        $result = $model->edit_coach();
        
        if ($result)
        {
            $msg = JText::_('Information edit');
        }
        else
        {
            $msg = JText::_('Information is not added');
        }
        global $mainframe;
        $mainframe->redirect("index.php?option=com_phase&controller=coach", $msg);
        
        
        parent::display($tpl);
    }
}
?>