<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 jimport('joomla.application.component.model');
 
 
class PhaseModelPhase extends JModel
{
         
     function __construct()
     {
         parent::__construct();
     }
     
     function isAdmin($userId)
     {
         /*
        $query = "SELECT usertype FROM #__users WHERE id = $userId";
        $result =  $this->_getList($query);
        
        foreach ($result as $result) { $result = $result->usertype;}
        if($result == 'Super Administrator')
        {
            return 1;
        }
        else
        {
            return 0;
        }
        */
     }
     
     function isCoach($userId)
     {
        $query = "SELECT id FROM #__jf_companies WHERE owner = $userId";
        $result =  $this->_getList($query);
        if($result)
        {
            return 1;
        }
        else
        {
            return 0;
        }
     }
     
     
}



/*
 <?php
$user =& JFactory::getUser();
$userId = $user->id;

//isAdmin
$admin = null;

$query = "SELECT usertype FROM #__users WHERE id = $userId";
$result =  $this->_getList($query);
        
foreach ($result as $result) { $result = $result->usertype;}

if($result == 'Super Administrator')
{
$admin = 1;
}
else
{
$admin = 0;
}
echo $admin;
//isAdmin





//isCoach
$coach = null;

$query = "SELECT id FROM #__jf_companies WHERE owner = $userId";
$result =  $this->_getList($query);
if($result)
{
$coach = 1;
}
else
{
$coach = 0;
}

echo $coach;
//isCoach



//isClient
$client = null;

$query = "SELECT id FROM #__jf_companies WHERE owner = $userId";
$result =  $this->_getList($query);
if($result)
{
$client = 0;
}
else
{
$client = 1;
}

echo $client;
//isClient

?>
 * 
 * 
 * 
 * 
 */