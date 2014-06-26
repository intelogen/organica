<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');


class PhaseViewAdmin extends JView
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
    
    // вывод всех тренеров
    function show_all_coaches($tpl = null)
    {
        $model = $this->getModel();
        $allCoaches = $model->getAllCoaches();
        $this->assignRef('allCoaches', $allCoaches);
        parent::display($tpl = null);
    }
    
    
    //добавление нового тренера
    //1 вывод кандидатов на пост тренера
    function new_coach($tpl = null)
    {
        $model = $this->getModel();
        $userList = $model->userList();
        $this->assignRef('userList', $userList);
        parent::display($tpl = null);
    }
    //2-3 добавление нового пользователя
    function add_coach($tpl = null)
    {
        
        
        global $mainframe;
        $post = JRequest::get('post');
        $userId = $post['userId'];
        $model = $this->getModel();
        $userInfo = $model->getUserInfo($userId);
        foreach ($userInfo as $value)
        {
        $userId = $value->id;
        $userName = $value->name;
        }
        
        
        $addCoachResult = $model->addCoach($userId, $userName);
        
        if (!$addCoachResult)
        {
            $msg = JText::_('New coach not add');
            $mainframe->redirect('index.php?option=com_phase&controller=admin&action=show_all_coaches', $msg);
        }
        
        $companyId = $model->getCompanyId($userId);
        
        //foreach ($companyId as $companyId) { $companyId = $companyId->id; }
        
        $updateUserInfo = $model->updateUserInfo($companyId, $userId, 2);
        

        if (!$updateUserInfo)
        {
            $msg = JText::_('New coach not add');
        }
        else
        {
            $msg = JText::_('New coach add');
        }
        
        
        $mainframe->redirect('index.php?option=com_phase&controller=admin&action=show_all_coaches', $msg);
        
    }
    
    //удаление тренера
    function Delete($tpl = null)
    {
        
        $post = JRequest::get('post');
        $userId = $post['userId'];
        $model = $this->getModel();
        
        if (!$userId)
        {
            $msg = JText::_('Coach not selected');
        }
        
        $model = $this->getModel();
        $delete_result = $model->delete_coach($userId);
        if ($delete_result)
        {
            $msg = JText::_('Coach delete');
            $model->updateUserInfo2('0', $userId, '4');
        }
        else
        {
            $msg = JText::_('Coach not delete');
        }
        global $mainframe;
        $mainframe->redirect('index.php?option=com_phase&controller=admin&action=show_all_coaches', $msg);
        
        
        parent::display($tpl);
    }
    
    //редактирование тренера
    //достаём данные тренера
    function Edit($tpl = null)
    {
        $post = JRequest::get('post');
        $userId = $post['userId'];
        if (!$userId)
        {
            $msg = JText::_('Coach not selected');
            global $mainframe;
            $mainframe->redirect('index.php?option=com_phase&controller=admin&action=show_all_coaches', $msg);
        }
        
        $model = $this->getModel();
        $row = $model->getCoachInfo($userId);
        $this->assignRef('row', $row);
      
        parent::display($tpl);
    }
    
    //редактирование(запись) тренера
    function edit_coach($tpl = null)
    {
        
        if(!JRequest::getVar('name'))
        {
            global $mainframe;
            $mainframe->redirect('index.php?option=com_phase&controller=admin&action=show_all_coaches');
        }
        
        $model = $this->getModel();
        $result = $model->edit_coach();
        
        if ($result)
        {
            $msg = JText::_('Coach save');
        }
        else
        {
            $msg = JText::_('Coach not save');
        }
        global $mainframe;
        $mainframe->redirect('index.php?option=com_phase&controller=admin&action=show_all_coaches', $msg);

        
        
        parent::display($tpl);
    }
    
    
    // coach-user
    //вывод всех не присоиных пользователей и список тренеров
    function coach_users($tpl =null)
    {
        $model = $this->getModel();
        
        $allUsers = $model->allUsers();
        $this->assignRef('allUsers', $allUsers);
        
        $allCoaches = $model->getAllCoaches();
        $this->assignRef('allCoaches', $allCoaches);
        
        
        parent::display($tpl = null);
    }
    //сохраняет изминения
    function Assign($tpl = null)
    {
        $post = JRequest::get('post');
        //echo '<pre>';
        //print_r($post);
        $model = $this->getModel();
        $result = $model->assignCoach($post[userId], $post[coachId]);
        if ($result)
        {
            $msg = JText::_('Information save');
        }
        else
        {
            $msg = JText::_('Information not save');
        }
        global $mainframe;
        $mainframe->redirect('index.php?option=com_phase&view=phase', $msg);
        
        
        
        parent::display($tpl);
    }
    
}



?>