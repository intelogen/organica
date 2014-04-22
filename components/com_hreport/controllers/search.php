<?php
/**
 * Health Report for Joomla! 1.5
 * @author Alexander Barannikov
 * @copyright 2010 Seanetix Company
 */

defined('_JEXEC') or die('Access denied.');
 
jimport('joomla.application.component.controller');
require_once(JPATH_ROOT.DS.'components'.DS.'com_hreport'.DS.'models'.DS.'report.php');
 
class HReportControllerSearch extends JController {

    function _getUserDetails($id) {

        $details = new stdClass();

        $id = (int)$id;
        $db =& JFactory::getDBO();

        // get user symptom variables
        $query = "SELECT survey_value FROM #__jf_jtpl_survey_details WHERE user_id = $id AND survey_variable = 'reg_symptoms'";
        $db->setQuery($query);
        $sym_vars = explode(',',$db->loadResult());
        // get user symtom names
        $query = "SELECT question FROM #__jf_jtpl_survey_symptoms WHERE variable IN ('".implode("', '",$sym_vars)."')";
        $db->setQuery($query);
        $sym_names = $db->loadResultArray();

        $details->symptoms = $sym_names;

        // get user looking for variables
        $query = "SELECT survey_value FROM #__jf_jtpl_survey_details WHERE user_id = $id AND survey_variable = 'reg_looking_for'";
        $db->setQuery($query);
        $lookfor_vars = explode(',',$db->loadResult());
        // get user looking for names
        $query = "SELECT question FROM #__jf_jtpl_survey_looking_for WHERE variable IN ('".implode("', '",$lookfor_vars)."')";
        $db->setQuery($query);
        $lookfor_names = $db->loadResultArray();

        $details->looking_for = $lookfor_names;

        // get user medtrack variables
        $query = "SELECT survey_value FROM #__jf_jtpl_survey_details WHERE user_id = $id AND survey_variable = 'reg_medtrack'";
        $db->setQuery($query);
        $med_vars = explode(',',$db->loadResult());
        // get user medtrack names
        $query = "SELECT question FROM #__jf_jtpl_survey_medtrack WHERE variable IN ('".implode("', '",$med_vars)."')";
        $db->setQuery($query);
        $med_names = $db->loadResultArray();

        $details->medtrack = $med_names;

        // get user disease variables
        $query = "SELECT survey_value FROM #__jf_jtpl_survey_details WHERE user_id = $id AND survey_variable LIKE 'reg_disease%'";
        $db->setQuery($query);
        $dis_vars = $db->loadResultArray();
        $dis_vars = explode(',',implode(',',$dis_vars));
        // get user disease names
        $query = "SELECT question FROM #__jf_jtpl_survey_diseases WHERE variable IN ('".implode("', '",$dis_vars)."')";
        $db->setQuery($query);
        $dis_names = $db->loadResultArray();

        $details->diseases = $dis_names;

        //get user name and surname
        $query = "SELECT firstname, lastname FROM #__jf_persons WHERE uid = $id";
        $db->setQuery($query);
        $name = $db->loadAssoc();

        $details->firstname = $name['firstname'];
        $details->lastname = $name['lastname'];

        //get user photos
        $query = "SELECT startphoto, endphoto FROM #__jf_jtpl_phasedetails WHERE phase_id = (SELECT MIN(id) FROM #__jf_projects WHERE author = $id)";
        $db->setQuery($query);
        $name = $db->loadAssoc();

        $details->startphoto = $name['startphoto']?$name['startphoto']:'picture_not_found.jpg';
        $details->endphoto = $name['endphoto']?$name['endphoto']:'picture_not_found.jpg';

        return $details;
    }

    function _getUserPlate($id) {

        $details = new stdClass();

        $db =& JFactory::getDBO();

        $id = (int)$id;

        $model = new HReportModelReport();

        //get user name and surname
        $query = "SELECT firstname, lastname FROM #__jf_persons WHERE uid = $id";
        $db->setQuery($query);
        $name = $db->loadAssoc();

        $details->firstname = $name['firstname'];
        $details->lastname = $name['lastname'];

        //get user photos
        $photos = $model->getFirstLastPhoto($id);
        $details->startphoto = $photos->first;
        $details->endphoto = $photos->last;
        
        //get user weight, fat and PH
        $intake = $model->getIntakeDiff($id);
        //start
        $details->startweight = $intake->start->weight ? $intake->start->weight : 'N/A';
        $details->startfat = $intake->start->fat ? $intake->start->fat : 'N/A';
        $details->startph = $intake->start->ph ? $intake->start->ph : 'N/A';

        //last
        $details->lastweight = $intake->end->weight ? $intake->end->weight : 'N/A';
        $details->lastfat = $intake->end->fat ? $intake->end->fat : 'N/A';
        $details->lastph = $intake->end->ph ? $intake->end->ph : 'N/A';

        $details->userid = $id;

        //get diseases eliminated
        $details->diseaseseliminated = $model->getEliminatedDiseases($id);

        //get medications eliminated
        $details->medicationseliminated = $model->getEliminatedMedications($id);

        // get age
        $details->age = $model->getAge($id);

        return $details;

    }

    function _makeReport($medtrack, $symptom, $disease, $lookfor) {

        $db =& JFactory::getDBO();
        // searching users medtrack
        $criteria = '';
        foreach ($medtrack as $med) {
            $criteria .=" AND survey_value LIKE '%$med%'";
        }
        $query = "SELECT
                    DISTINCT (user_id)
                  FROM
                    jos_jf_jtpl_survey_details
                  WHERE
                    (
                        survey_variable = 'reg_medtrack'
                        $criteria
                    )
                 ";
        $db->setQuery($query);
        $med_ids = $db->loadResultArray();

        // searching users symptom
        $criteria = '';
        foreach ($symptom as $sym) {
            $criteria .=" AND survey_value LIKE '%$sym%'";
        }
        $query = "SELECT
                    DISTINCT (user_id)
                  FROM
                    jos_jf_jtpl_survey_details
                  WHERE
                    (
                        survey_variable = 'reg_symptoms'
                        $criteria
                    )
                 ";
        $db->setQuery($query);
        $sym_ids = $db->loadResultArray();

        // searching users diseases
        $criteria = '';
        foreach ($disease as $dis) {
            $criteria .=" AND survey_value LIKE '%$dis%'";
        }
        $query = "SELECT
                    DISTINCT (user_id)
                  FROM
                    jos_jf_jtpl_survey_details
                  WHERE
                    (
                        survey_variable LIKE 'reg_disease%'
                        $criteria
                    )
                 ";
        $db->setQuery($query);
        $dis_ids = $db->loadResultArray();

        // searching users looking for
        $criteria = '';
        foreach ($lookfor as $lkf) {
            $criteria .=" AND survey_value LIKE '%$lkf%'";
        }
        $query = "SELECT
                    DISTINCT (user_id)
                  FROM
                    jos_jf_jtpl_survey_details
                  WHERE
                    (
                        survey_variable LIKE 'reg_looking_for'
                        $criteria
                    )
                 ";
        $db->setQuery($query);
        $lkf_ids = $db->loadResultArray();

        //searching users by sex
        $sex = JRequest::getInt('sex', -1);
        $where="";
        if ($sex>-1) $where="WHERE sex=$sex";
        $sql = "SELECT id FROM #__users $where";
        $db->setQuery($sql);
        $sex_ids = $db->loadResultArray();

//        echo "<pre>";
//        echo "sex: ".count($sex_ids)."\n";
//        echo "med: ".count($med_ids)."\n";
//        echo "sym: ".count($sym_ids)."\n";
//        echo "dis: ".count($dis_ids)."\n";
//        print_r($lkf_ids);
//        echo "</pre>";
//
//        die();

        $retarr = $sex_ids;
        if (!empty($medtrack)) $retarr = array_intersect($med_ids, $retarr);
        if (!empty($symptom)) $retarr = array_intersect($sym_ids, $retarr);
        if (!empty($disease)) $retarr = array_intersect($dis_ids, $retarr);
        if (!empty($lookfor)) $retarr = array_intersect($lkf_ids, $retarr);

        return $retarr;
    }


    function results() {

        $db =& JFactory::getDBO();
        //diseases
        $criteria = '';
        foreach ($_REQUEST['dis'] as $dis) {
            $criteria .= " OR question = '".mysql_real_escape_string($dis)."'";
        }
        $query = "SELECT variable FROM #__jf_jtpl_survey_diseases WHERE FALSE $criteria";
        $db->setQuery($query);
        $diseases = $db->loadResultArray();
        //medtrack
        $criteria = '';
        foreach ($_REQUEST['med'] as $med) {
            $criteria .= " OR question = '".mysql_real_escape_string($med)."'";
        }
        $query = "SELECT variable FROM #__jf_jtpl_survey_medtrack WHERE FALSE $criteria";
        $db->setQuery($query);
        $medtrack = $db->loadResultArray();
        //symptoms
        $criteria = '';
        foreach ($_REQUEST['sym'] as $sym) {
            $criteria .= " OR question = '".mysql_real_escape_string($sym)."'";
        }
        $query = "SELECT variable FROM #__jf_jtpl_survey_symptoms WHERE FALSE $criteria";
        $db->setQuery($query);
        $symptoms = $db->loadResultArray();
        //lookfor
        $lookfor = array();
        $lf = (int)$_REQUEST['lookfor'];
        if($lf != -1) {
            $query = "SELECT variable FROM #__jf_jtpl_survey_looking_for WHERE id = $lf";
            $db->setQuery($query);
            $lookfor = $db->loadResultArray();
        }
        $users = $this->_makeReport($medtrack, $symptoms, $diseases, $lookfor);

        $u = array();

        foreach ($users as $user) {
            $u[] = $this->_getUserPlate($user);
        }

//            $u[] = $this->_getUserDetails(181);
//            $u[] = $this->_getUserDetails(180);
//            $u[] = $this->_getUserDetails(182);
//
            $view =& $this->getView('Search','html');
            $view->setLayout('report');
            $view->assignRef('items', $u);
            $view->display();

//            var_dump($symptoms);
    }
		
    function suggestion() {

        $type = JRequest::getString('t');
        $search = mysql_real_escape_string(JRequest::getString('search'));

        switch($type) {
            case 'symptom':
                $tbl_name = '#__jf_jtpl_survey_symptoms';
                $field_name = 'question';
            break;

            case 'disease':
                $tbl_name = '#__jf_jtpl_survey_diseases';
                $field_name = 'question';
            break;

            case 'medtrack':
                $tbl_name = '#__jf_jtpl_survey_medtrack';
                $field_name = 'question';
            break;

            case 'lookfor':
                $tbl_name = '#__jf_jtpl_survey_looking_for';
                $field_name = 'question';
            break;
        }

        $db =& JFactory::getDBO();
        $query = "SELECT question FROM $tbl_name WHERE question LIKE '$search%'";
        $db->setQuery($query);
        $results = $db->loadResultArray();

        if ($results) {
            $str = '["'.implode('", "', $results).'"]';
        }
        die($str);
    }

}
?>
