<?php
/**
 * Health Report for Joomla! 1.5
 * @author Alexander Barannikov
 * @copyright 2010 Seanetix Company
 */

defined('_JEXEC') or die('Access denied.');

jimport('joomla.application.component.view');

class HReportViewImport extends JView {

    function  display($tpl = null) {

        $document =& JFactory::getDocument();
        $document->addStyleSheet(JURI::root().'components/com_hreport/css/style.css');
        $document->addStyleSheet(JURI::root().'components/com_hreport/css/autocompleter.css');
        JHTML::script('autocompleter.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('observer.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('hreport3.js',JURI::root().'components/com_hreport/js/', true);
        JHTML::script('hreport2.js',JURI::root().'components/com_hreport/js/', true);

        $db =& JFactory::getDBO();
        $query = "SELECT id,question FROM #__jf_jtpl_survey_body_score";
        $db->setQuery($query);
        $bodyscore = $db->loadObjectList();

        $user =& JFactory::getUser();
        $uid = $user->id;

        $sql = "SELECT id FROM #__jf_projects WHERE author = $uid ORDER by id ASC";
        $db->setQuery($sql);
        $projects = $db->loadResultArray();

        $sql = "UPDATE #__jf_projects SET status = 'Active' WHERE author = $uid";
        $db->setQuery($sql);
        $db->query();
        
        $phases = array();
        for($i=0;$i<=9;$i++){
            $sql = "SELECT question, variable FROM #__jf_jtpl_survey_questions WHERE phase_number = $i AND step = 'start'";
            $db->setQuery($sql);
            $questions = $db->loadObjectList();
            foreach ($questions as $question) {
                $obj->q = $question->question;
                $obj->v = $question->variable;
                $phases[$i]->start_q[] = clone $obj;
            }

        }
        for($i=0;$i<=9;$i++){
            $sql = "SELECT question, variable FROM #__jf_jtpl_survey_questions WHERE phase_number = $i AND step = 'end'";
            $db->setQuery($sql);
            $questions = $db->loadObjectList();
            foreach ($questions as $question) {
                $obj->q = $question->question;
                $obj->v = $question->variable;
                $phases[$i]->end_q[] = clone $obj;
            }

        }

        //medtrack
        $medtrack = array();
        $sql = "SELECT survey_value FROM #__jf_jtpl_survey_details WHERE survey_variable='reg_medtrack' AND user_id = $uid";
        $db->setQuery($sql);
        $vars = $db->loadResult();
        if (!empty($vars)) {
        $vars = explode(',', $vars);
        foreach ($vars as $var) {
            $sql="SELECT question FROM #__jf_jtpl_survey_medtrack WHERE variable='$var'";
            $db->setQuery($sql);
            $obj->q = $db->loadResult();
            $obj->v = $var;
            $medtrack[]=clone $obj;
        }
        }
        //symptoms
        $symptoms = array();
        $sql = "SELECT survey_value FROM #__jf_jtpl_survey_details WHERE survey_variable='reg_symptoms' AND user_id = $uid";
        $db->setQuery($sql);
        $vars = $db->loadResult();
        if (!empty($vars)) {
        $vars = explode(',', $vars);
        foreach ($vars as $var) {
            $sql="SELECT question FROM #__jf_jtpl_survey_symptoms WHERE variable='$var'";
            $db->setQuery($sql);
            $obj->q = $db->loadResult();
            $obj->v = $var;
            $symptoms[]=clone $obj;
        }
        }

        //diseases
        $diseases = array();
        $sql = "SELECT survey_value FROM #__jf_jtpl_survey_details WHERE survey_variable LIKE 'reg_disease%' AND user_id = $uid";
        $db->setQuery($sql);
        $vars = $db->loadResult();
        if (!empty($vars)) {
        $vars = explode(',', $vars);
        foreach ($vars as $var) {
            $sql="SELECT question FROM #__jf_jtpl_survey_diseases WHERE variable='$var'";
            $db->setQuery($sql);
            $obj->q = $db->loadResult();
            $obj->v = $var;
            $diseases[]=clone $obj;
        }
        }
        //die("<pre>".print_r($diseases)."</pre>");

        $this->assignRef('bodyscore', $bodyscore);
        $this->assignRef('projects', $projects);
        $this->assignRef('phases', $phases);
        $this->assignRef('medtrack', $medtrack);
        $this->assignRef('symptoms', $symptoms);
        $this->assignRef('diseases', $diseases);

        parent::display($tpl);
    }

}
?>
