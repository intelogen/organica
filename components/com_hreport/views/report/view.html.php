<?php
/**
 * Health Report for Joomla! 1.5
 * @author Alexander Barannikov
 * @copyright 2010 Seanetix Company
 */

defined('_JEXEC') or die('Access denied');

jimport('joomla.application.component.view');

class HReportViewReport extends JView {

    function display($tpl=null) {

        $document =& JFactory::getDocument();
        $document->addStyleSheet(JURI::root().'components/com_hreport/css/style.css');
        JHTML::script('hreport2.js',JURI::root().'components/com_hreport/js/', true);

        // adding chart
        JHTML::script('jquery-1.7.1.min.js',JURI::root().'components/com_jforce/js/charts/');
        JHTML::script('highcharts.js',JURI::root().'components/com_jforce/js/charts/');

        $model = $this->getModel();
        $person = $model->getPersonDetails();

        $user = JFactory::getUser();
        $uid = JRequest::getInt('uid');

        $uid = (int)($uid ? $uid : $user->id);
        
        for($i=1;$i<=10;$i++) {
            $phase[$i] = $model->getPhaseDetails($uid, $i);
        }

        $person->reg = $this->prepareRegSurveyResultsOutput($person->reg_survey_results);
        
        $this->assignRef('person', $person);
        $this->assignRef('phase', $phase);
        parent::display($tpl);
    }

    function prepareRegSurveyResultsOutput($res)
    {
        $output = new stdClass();
        // preparing 'looking for' output
        $lf_text = array();
        if($res->looking_for) {
            foreach($res->looking_for as $v) {
                $lf_text[] = '<strong>'.strtolower($v->question).'</strong>';
            }
            $output->lf_text = implode(', ', $lf_text);
        } else {
            $output->lf_text = 'nothing';
        }

        // preparing 'symptoms' output
        $sym_text = array();
        if($res->symptoms) {
            foreach($res->symptoms as $v) {
                $sym_text[] = '<strong>'.strtolower($v->question).'</strong>';
            }
        $output->sym_text = 'Your symptoms are '.implode(', ', $sym_text);
        } else {
            $output->sym_text = 'You have no symptoms';
        }

        // preparing 'medtrack' output
        $med_text = array();
        if($res->medtrack) {
            foreach($res->medtrack as $v) {
                $med_text[] = '<strong>'.$v->question.'</strong>';
            }
        $output->med_text = implode(', ', $med_text);
        } else {
            $output->med_text = 'nothing';
        }

        // preparing 'diseases' output
        $dis_text = array();
        if($res->disease) {
            foreach($res->disease as $v) {
                $dis_text[] = '<strong>'.strtolower($v->question).'</strong>';
            }
        $output->dis_text = "Currently you have the following diseases: ".implode(', ', $dis_text);
        } else {
            $output->dis_text = "Currently you don't have any diseases";
        }

        return $output;
    }

}

?>
