<?php
// controllers
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');

class JController extends JController
{
    function display()
    {
        echo 'sdsd';
        parent::display();
    }
}
$controller = new JController ();



?>