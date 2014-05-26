<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 jimport('joomla.application.component.model');
 
 
class PhaseModelMessage extends JModel
{
         
    function __construct()
    {
        parent::__construct();
    }
     
     
    function getNewMessage($userId)
    {
        $query = "SELECT * FROM #__jf_messages WHERE mto = $userId AND mread = 0 ORDER BY id";
        return $this->_getList($query);
    }
     
    function getSendUserInfo($sendUserId)
    {
        $query = "SELECT firstname, lastname FROM #__jf_persons WHERE uid = $sendUserId";
        return $this->_getList($query);
    }
     
     
     function getMessageBody($id, $sendUserId)
    {
        $row = & JTable::getInstance('Message');
        $row->load($id);
        
        if($sendUserId == $row->mto)
        {
        $row->set('mread', 1);    
        }
        
        if(!$row->store())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;  
        }
        
        return $row;
    }
     
    function sendMassege()
    {
        $post = JRequest::get('post');
        $row = & JTable::getInstance('Message');
        $row->load();
        
        if (!$row->bind($post))
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
        $body = JRequest::getVar('body', 'no text', post, string, 5);
        
        
        $row->set('body', $body);
        
        
        
    if (!$row->check())
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
        
        
        //echo '<pre>';
        //var_dump($row);
    
    if (!$row->store()) 
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
    
        return true;
        
    }
    
    function getInboxMessage($userId)
    {
        $query = "SELECT * FROM #__jf_messages WHERE mto = $userId and mread = 1 ORDER BY id DESC";
        return $this->_getList($query);
    }
    
    function getSentMessage($userId)
    {
        $query = "SELECT * FROM #__jf_messages WHERE mfrom = $userId ORDER BY id DESC";
        return $this->_getList($query);
    }
    
    function isCoach($userId)
    {
        $query = "SELECT id FROM #__jf_companies WHERE owner = $userId LIMIT 1";
        return $this->_getList($query);
    }
    
    function getCoachId($userId)
    {
        $query = "SELECT owner FROM #__jf_companies WHERE id = (SELECT company FROM #__jf_persons WHERE uid = $userId LIMIT 1)";
        return $this->_getList($query);
    }
            
    function getClientInfo($companyId, $userId)
    {
        $query = "SELECT uid, firstname, lastname FROM #__jf_persons WHERE company = $companyId AND uid NOT IN ($userId)";
        return $this->_getList($query);
    }
    
    function getUserLIst()
    {
        $query = "SELECT uid, firstname, lastname FROM #__jf_persons";
        return $this->_getList($query);
    }
            
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     
     function tempo()
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
     
     
     
     
     
     
     
     
}


