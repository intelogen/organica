<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

 
class JTableTempbodyscore extends JTable
{
    public $id = null;
    public $user_id = null;
    public $pid = null;
    public $name = null;
    public $val = null;
    public $time = null;
    public $step = null;
    
    
    
    
    

     
    function __construct(& $_db)
        {
            parent::__construct('#__jf_my_temp_bodyscore', 'id', $_db);

        }
        
}
?>