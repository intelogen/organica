<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');


class PhaseViewPhase extends JView
{
    function display($tpl = null) {
        
        JToolBarHelper::title(JText::_('Phases controll system'), 'config');
        
        parent::display($tpl);
    }
    
    
}



?>
