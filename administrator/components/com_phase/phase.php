<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once JPATH_COMPONENT.DS.'controller.php';
require_once JPATH_COMPONENT.DS.'helpers'.DS.'toolbar.php';



HWSubMenu::build();

// табы
jimport('joomla.html.pane');




$document = &JFactory::getDocument();
$document->addStyleSheet('components/com_phase/library/style.css');

$controller = JRequest::getWord('controller');

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
echo '<br>TASK = '.JRequest::getCmd('task').'<br><br>';
//echo '<pre>';
//var_dump(JRequest::get('post'));



$controller->execute(JRequest::getCmd('task'));
$controller->redirect();




?>