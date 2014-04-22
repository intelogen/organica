<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

 
class JTableCoach extends JTable
{
    public $id = null;
    public $name = null;
    public $address = null;
    public $phone = null;
    public $fax = null;
    public $homepage = null;
    public $image = null;
    public $owner = null;
    public $author = null;
    public $enabled = 1;
    public $created = null;
    public $modified = null;
    public $admin = null;
    public $published = 1;
     
    function __construct(& $_db)
        {
            parent::__construct('#__jf_companies', 'id', $_db);
            $this->modified = date('Y-m-d G:i:s');
        }
        
}
?>