<?php
/**
 * Health Report for Joomla! 1.5
 * @author Alexander Barannikov
 * @copyright 2010 Seanetix Company
 */

defined('_JEXEC') or die('Access denied.');

jimport('joomla.application.component.model');

class HReportModelLookingFor extends JModel {

    function getQuestions() {

        $sql = "SELECT question, variable FROM #__jf_jtpl_survey_looking_for";
        $this->_db->setQuery($sql);
        die('!!!');
        return $this->_db->loadObjectList();
        
    }

}
?>
