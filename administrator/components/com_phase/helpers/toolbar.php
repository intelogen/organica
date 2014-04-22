<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

class HWToolBarHelper
{
    function link($name, $text, $url)
    {
        $bar = &JToolBar::getInstance();
        $bar->appendButton('Link', $name, $text, $url);
    }
    
    function popup($name, $text, $url, $width=640, $height=480, $top=0, $left=0)
    {
        $bar = &JToolBar::getInstance();
        $bar->appendButton('Popup', $name, $text, $url, $width, $height, $top, $left);
    }
    
    
    
}



class HWSubMenu
{
    function build()
    {
        JSubMenuHelper::addEntry(JText::_('Main'), 'index.php?option=com_phase');
        JSubMenuHelper::addEntry(JText::_('Coaches list'), 'index.php?option=com_phase&controller=coach');
        
    }
}






?>