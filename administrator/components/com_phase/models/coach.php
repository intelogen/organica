<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 jimport('joomla.application.component.model');
 
 
 class PhaseModelCoach extends JModel
 {
     private $_content = array();
     public $userList;
     
     function __construct()
     {
         parent::__construct();
     }
     
     
     
     function getRecords()
     {
         if(empty($this->_content))
         {
             $query = $this->_buildSql();
             $this->_content = $this->_getList($query);
         }
         return $this->_content;
     }
     
     private function _buildSql()
     {
         $sql = "SELECT * FROM #__jf_companies";
         return $sql;
     }
     
     
     
     function getCoachName()
     {
         //$query = "SELECT id, name FROM #__users";
         $query = "SELECT id, name FROM jos_users WHERE id NOT IN(SELECT owner FROM jos_jf_companies)";
         return $this->_getList($query);
     }
     
     
     
     
     function addCoach($userId, $userName)
     {
        $row = & JTable::getInstance('Coach');
        $row->load();
        
        $data = JRequest::get('post');
        $userId = $userId;
        $userName = $userName;

        if (!$row->bind($data))
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
        $row->name = $userName;
        $row->owner = $userId;
        $row->author= $userId;
        
        
    
   

    if (!$row->check()) {
        $this->setError($this->_db->getErrorMsg());
        return false;
    }

    
    if (!$row->store()) {
        $this->setError($this->_db->getErrorMsg());
        return false;
    }
    return true;
        
     }
     
     
     
     
    function getUserInfo($id)
    {
        $sql = "SELECT id, name FROM #__users WHERE id = $id";
        $userInfo = $this->_getList($sql);
        return $userInfo;
    }
     
     
     
     
     
 }



?>
