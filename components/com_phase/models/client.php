<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 jimport('joomla.application.component.model');
 
 
class PhaseModelClient extends JModel
{
         
     function __construct()
     {
         parent::__construct();
     }
     
     function getUserPhases($userId)
     {
         $query = "SELECT * FROM #__jf_projects WHERE leader = $userId AND published =1 ORDER BY id";
         return $this->_getList($query);
     }
     
     function getPhasesTasks($phaseId)
     {
         $query = "SELECT * FROM #__jf_checklists WHERE pid = $phaseId ORDER BY id";
         return $this->_getList($query);
     }
     
     function getTaskData($taskId)
     {
         $query = "SELECT * FROM #__jf_checklists WHERE id = $taskId";
         return $this->_getList($query);
     }
     
     
     function getCompanyId($userId)
     {
         $query = "SELECT company FROM #__jf_persons WHERE uid = $userId";
         return $this->_getList($query);
     }
     
     function getCoachInfo($companyId)
     {
         $query = "SELECT * FROM #__jf_companies WHERE id = $companyId";
         return $this->_getList($query);
     }
     
     function finishTask($taskId)
     {
        $row = & JTable::getInstance('Checklist');
        $row->load($taskId);
        $row->set('completed', 1);
        if(!$row->store())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;  
        }
  
        return true;
     }
     
     function getCount($pid)
     {
        for ($i = 1; $i<=count($pid); $i++)
        {
            $c = (int)$pid[$i];
            $countTask[$c] = $this->cnt((int)$pid[$i]);
        }
        return $countTask;
     }
    
    function cnt($idp)
    {
        $query = "SELECT COUNT('id') as allCount FROM #__jf_checklists WHERE pid = $idp";
        return $this->_getList($query);
    }
    
    
    
    function getFinishCount($pid)
     {
        for ($i = 1; $i<=count($pid); $i++)
        {
            $c = (int)$pid[$i];
            $countTask[$c] = $this->fcnt((int)$pid[$i]);
        }
        return $countTask;
     }
    
    function fcnt($idp)
    {
        $query = "SELECT COUNT('id') as allCount FROM #__jf_checklists WHERE pid = $idp AND completed = 1";
        return $this->_getList($query);
    }
    
    
    
    
     
}