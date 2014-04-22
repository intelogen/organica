<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.view');


class PhaseViewClient extends JView
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
    
    function deshbord($tpl = null)
    {
        $user =& JFactory::getUser();
        $userId = $user->id;
        $model = $this->getModel();
        $userPhases = $model->getUserPhases($userId);
        $userPhases2 = $model->getUserPhases($userId);
        
        //echo '<pre>';
        //var_dump($userPhases2);
        $i = 0;
        foreach ($userPhases2 as $userPhases2)
        {   
            $i++;
            $pid[$i] = $userPhases2->id."<br>";
        }
        $allCountTask = $model->getCount($pid);
        $this->assignRef('count', $allCountTask);
        $finishCountTask = $model->getFinishCount($pid);
        $this->assignRef('finishCountTask', $finishCountTask);
        
        
        
        if ($userPhases == null){ echo 'You dont have any phase yet';}
        $this->assignRef('userPhases', $userPhases);
        parent::display($tpl);
    }
    
    function show_phases_tasks($tpl = null)
    {
        $phaseId = JRequest::getVar('phase');
        $model = $this->getModel();
        $phasesTasks = $model->getPhasesTasks($phaseId);
        $this->assignRef('phasesTasks', $phasesTasks);
        parent::display($tpl);
    }
    
    function show_tasks($tpl = null)
    {
        $taskId = JRequest::getVar('task');
        $model = $this->getModel();
        $taskData = $model->getTaskData($taskId);
        $this->assignRef('taskData', $taskData);
        
        
        parent::display($tpl);
    }
    
    function show_my_coach($tpl = null)
    {
        $user =& JFactory::getUser();
        $userId = $user->id;
        $model = $this->getModel();
        $companyId = $model->getCompanyId($userId);
        foreach ($companyId as $companyId) { $companyId = $companyId->company;}
        $coachInfo = $model->getCoachInfo($companyId);
        $this->assignRef('coachInfo', $coachInfo);
        parent::display($tpl);
    }
    
    
    function finish_task($tpl = null)
    {
        $taskId = JRequest::getVar('taskId');
        $model = $this->getModel();
        $result = $model->finishTask($taskId);
        if ($result)
        {
            $msg = JText::_('Task completed');
        }
        else
        {
            $msg = JText::_('Task not completed');
        }
        global $mainframe;
        $mainframe->redirect('index.php?option=com_phase&controller=client&action=deshbord', $msg);
        
        parent::display($tpl);
    }
    
    
}