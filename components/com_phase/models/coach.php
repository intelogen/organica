<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 jimport('joomla.application.component.model');
 
 
class PhaseModelCoach extends JModel
{
         
     function __construct()
     {
         parent::__construct();
     }
     
     function getClients($coachId)
     {
         
         $query = "SELECT uid, firstname, lastname FROM #__jf_persons WHERE company = (SELECT id FROM #__jf_companies WHERE owner = $coachId) AND uid NOT IN ($coachId)";
         return $this->_getList($query);
     }
     
     function getClintInfo($userId)
     {
         $query = "SELECT * FROM #__users WHERE id = $userId";
         return $this->_getList($query);
     }
     
     function getUserPhasees($userId, $coachId)
     {
        $query = "SELECT * FROM #__jf_projects WHERE leader = $userId AND author = $coachId ORDER BY id";
        return $this->_getList($query);
     }
     
     //редактирование фазы
     //1 - достаём инфу фазы
     function editPhase($phaseId)
     {
        $row = & JTable::getInstance('Projects');
        $row->load($phaseId);
        return $row;
     }
     
     //заносим изминения в базу
     function recordPhase()
     {
        $row = & JTable::getInstance('Projects');
        $row->load(JRequest::getVar('id'));
        $name = JRequest::getVar('name');
        $description = JRequest::getVar('description');
        $published = JRequest::getVar('published');
        
        
        $row->set('name', $name);
        $row->set('description', $description);
        $row->set('published', $published);
        
        
        
        if(!$row->store())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;  
        }
  
        return true;
     }
     
     //удаляем фазу
     function deletePhase($phaseId)
     {
        $row = & JTable::getInstance('Projects');
        
        $query = "DELETE FROM `maximlife2`.`jos_jf_checklists` WHERE `jos_jf_checklists`.`pid` = $phaseId";
        $this->_getList($query);
     
        if(!$row->delete($phaseId))
        {
            $this->setError($this->_db->getErrorMsg());
            return false;  
        }
        return true;
     }
     
     function getCoachCompanyId($coachId)
     {
         $query = "SELECT id FROM #__jf_companies WHERE owner = $coachId";
        return $this->_getList($query);
     }
     //добавляем новую фазу
     function addPhase($coachCompanyId)
     {
        $row = & JTable::getInstance('Projects');
        $row->load();
        $data = JRequest::get('post');
        
        $row->name = JRequest::getVar('newName');
        $row->description = JRequest::getVar('newDescription');
        $row->author = JRequest::getVar('coachId');
        $row->leader= JRequest::getVar('userId');
        $row->company= $coachCompanyId;
        
        if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

        if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
    
    return true;
        
     }
     
    function getTaskList($phaseId)
    {
        
        $query = "SELECT * FROM #__jf_checklists WHERE pid = $phaseId";
        $result = $this->_getList($query);
        return $result;
    }
    
    function getTaskContent($phaseId)
    {
        $row = & JTable::getInstance('Checklist');
        $row->load($phaseId);
        return $row;
    }
    
    function editTask()
    {
        $row = & JTable::getInstance('Checklist');
        $row->load(JRequest::getVar('id'));
        
        $row->set('summary', JRequest::getVar('name'));
        $row->set('description', JRequest::getVar('description'));
        echo'<pre>';

        

        if(!$row->store())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;  
        }
  
        return true;

    }
    
    function deleteTask($taskId)
    {
        $row = & JTable::getInstance('Checklist');
        if(!$row->delete($taskId))
        {
            $this->setError($this->_db->getErrorMsg());
            return false;  
        }
        return true;
    }
    
    function addTask()
    {
        echo '<pre>';
        var_dump(JRequest::get('post'));
        
        $row = & JTable::getInstance('Checklist');
        $row->load();
        
        
       $row->pid = JRequest::getVar('phaseId');
       $row->summary = JRequest::getVar('newSummary');
       $row->description = JRequest::getVar('newDescription');
       var_dump($row);
       


        if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

        if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

return true;
    }
    
    function edit_information($userId)
    {
        $query = "SELECT id FROM #__jf_companies WHERE owner = $userId";
        $coachId =  $this->_getList($query);
        foreach ($coachId as $coachId) {$coachId = $coachId->id; }
        $row = & JTable::getInstance('Company');
        $row->load($coachId);
        return $row;
    }
    
    function edit_coach()
    {
        $row = & JTable::getInstance('Company');
        $row->load(JRequest::getVar('id'));
        
        $data = JRequest::get('post');
        
        
        if (!$row->bind($data))
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
        
         if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }

    if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
    
    return true;
        
    }
}
?>