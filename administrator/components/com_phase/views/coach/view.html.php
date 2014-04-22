<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');


class PhaseViewCoach extends JView
{
    function display($tpl = null) {
        
        if(JRequest::getVar('layout') == 'form')
        {
            $this->form($tpl);
            return;
        }
      
        if(JRequest::getVar('action') == addcoach)
        {
            $this->addCoach($tpl);
        }
        
       
        
        JToolBarHelper::title(JText::_('All coaches'), 'config');
        JToolBarHelper::addNew();
        JToolBarHelper::deleteCoach();
               
        $model = $this->getModel();
        $content = $model->getRecords();
        
        $this->assignRef('content', $content);
        
        parent::display($tpl);
    }
    
    
  
    function form($tpl = null)
    {
        $model = $this->getModel();
        
        $coachName = $model->getCoachName();
        $this->assignRef(coach, $coachName);
        
        
        JToolBarHelper::title(JText::_('Add coache'), 'config');
        JToolBarHelper::save();
        JToolBarHelper::cancel();
        parent::display($tpl);
    }
    
    function addCoach($tpl = null)
    {
        
             
        $model = $this->getModel();
        $id = JRequest::getVar('userId');
        $userInfo = $model->getUserInfo($id);
        
        foreach ($userInfo as $value)
        {
        $userId = $value->id;
        $userName = $value->name;
        }
        
        
        
        $coachTable = $model->addCoach($userId, $userName);
        
        if ($coachTable)
        {
            $msg = JText::_('New coach add');
        }
        else
        {
            $msg = JText::_('New coach not add');
        }
        global $mainframe;
        $mainframe->redirect('index.php?option=com_phase&controller=coach', $msg);
    }
    
    
}
?>