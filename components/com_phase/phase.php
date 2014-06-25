<script src="jquery.js" type="text/javascript"></script>
<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once JPATH_COMPONENT.DS.'controller.php';


//подключаем css
$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_phase/library/style.css');








$controller = JRequest::getVar('controller');

if($controller)
    {
    $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
    if(file_exists($path))
    {
        require_once $path;
    }
    }
$classname = 'PhaseController'.ucfirst($controller);

$controller = new $classname();
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();




?>