<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

 
class JTableUsers extends JTable
{
    public $id = null;
    public $name = null;
    public $username = null;
    public $email = null;
    public $address = null;
    public $city = null;
    public $state = null;
    
    public $zip = null;
    public $phone = null;
    public $birthday = null;
    public $sex = null;
    
    
    
    
    
    
    

     
    function __construct(& $_db)
        {
            parent::__construct('#__users', 'id', $_db);

        }
        
}
?>