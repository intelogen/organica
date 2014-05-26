<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 jimport('joomla.application.component.model');
 
 
class PhaseModelAdmin extends JModel
{
         
     function __construct()
     {
         parent::__construct();
     }
     
     //вывод всех тренеров
     function getAllCoaches()
     {
         $query = "SELECT * FROM #__jf_companies";
         return $this->_getList($query);
     }
     
     
     
     
     // Добавление нового тренера
     //1 вывод кандидатов на пост тренера
     function userList()
     {
         $query = "SELECT * FROM #__users WHERE id NOT IN(SELECT owner FROM jos_jf_companies)";
         return $this->_getList($query);
     }
     
     //2 вывод id и name по извесному id кандидата
     function getUserInfo($userId)
     {
        $query = "SELECT id, name, username FROM #__users WHERE id = $userId";
        return $this->_getList($query);
     }
     
     function getCompanyId($userId)
     {
         $query = "SELECT id FROM #__jf_companies` WHERE owner = $userId";
        return $this->_getList($query);
     }
     
     function updateUserInfo($companyId, $userId)
     {
         $query = "UPDATE  #__jf_persons SET company = $companyId WHERE uid = $userId";
        $this->_getList($query);
     }
     
     //3 добавление нового пользователя
     function addCoach($userId, $userName)
     {
        $row = & JTable::getInstance('Coach');
        
        $row->load();
        
        $data = JRequest::get('post');
        
        
    if (!$row->bind($data))
        {
        $this->setError($this->_db->getErrorMsg());
        return false;
        }
        $row->name = $userName;
        $row->owner = $userId;
        $row->author= $userId;
   
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
     
     
     
     
     // Удаление ренера
     function delete_coach($userId)
     {
        $row = & JTable::getInstance('Coach');
        if(!$row->delete($userId))
        {
            $this->setError($this->_db->getErrorMsg());
            return false;  
        }
        return true;
     }
     
     
    //Редактирование тренера
    //выборка данных тренера
     function getCoachInfo($userId)
    {
         
        $row = & JTable::getInstance('Coach');
        
        if(!$row->load($userId))
        {
            $this->setError($this->_db->getErrorMsg());
            return false;  
        }
        
        return $row;
        
    }
    //Редактирование тренера update
    function edit_coach()
    {
        $data = JRequest::get('post');
        
        $row = & JTable::getInstance('Coach');
        
        $row->load($data[id]);
        
        $row->set('name',"$data[name]");
        $row->set('address',"$data[address]");
        $row->set('phone',"$data[phone]");
        $row->set('fax',"$data[fax]");
        $row->set('homepage',"$data[homepage]");
        $row->set('image',"$data[image]");
        $row->set('owner',"$data[owner]");
        $row->set('author',"$data[author]");
        $row->set('created',"$data[created]");
        $row->set('modified',"$data[modified]");
        $row->set('admin',"$data[admin]");
        $row->set('published',"$data[published]");
        
        
        if(!$row->store())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;  
        }
  
        return true;

    }
    
    // coach-user
    //вывод всех не присоиных пользователей
    function allUsers()
    {
        $query = "SELECT id, firstname, lastname FROM #__jf_persons WHERE company = 0";
        return $this->_getList($query);
    }
    
    //присваивает тренера
    function assignCoach($userId, $coachId)
    {
        $row = & JTable::getInstance('Person');
        
        $row->load($userId);
        
        $row->set('company',"$coachId");
        
        if(!$row->store())
        {
            $this->setError($this->_db->getErrorMsg());
            return false;  
        }
  
        return true;

    }
 
}