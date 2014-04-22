<?php
/**
 * Health Report for Joomla! 1.5
 * @author Alexander Barannikov
 * @copyright 2010 Seanetix company
 */

defined('_JEXEC') or die('Access denied.');

jimport('joomla.application.component.view');

class HReportViewSearch extends JView {

    function display($tpl=NULL) {

        $user = JFactory::getUser();

        $document =& JFactory::getDocument();
        $document->addStyleSheet(JURI::root().'components/com_hreport/css/style.css');
        $document->addStyleSheet(JURI::root().'components/com_hreport/css/autocompleter.css');
        JHTML::script('autocompleter.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('observer.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('hreport.js',JURI::root().'components/com_hreport/js/', true);

        $db =& JFactory::getDBO();
        $query = "SELECT id,question FROM #__jf_jtpl_survey_looking_for";
        $db->setQuery($query);
        $result = $db->loadObjectList();

        $look_for_all = new stdClass();
        $look_for_all->id = -1;
        $look_for_all->question = '- None selected -';
        array_unshift($result, $look_for_all);

        $look_for = JHTML::_('select.genericlist', $result, 'lookfor', '', 'id', 'question');

        $this->assignRef('look_for',$look_for);

        parent::display($tpl);
    }

}

?>
