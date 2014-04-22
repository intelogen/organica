<?php
/**
 * Health Report for Joomla! 1.5
 * @author Alexander Barannikov
 * @copyright 2010 Seanetix Company
 */

defined('_JEXEC') or die('Access denied.');

jimport('joomla.application.component.model');
require_once(JPATH_COMPONENT.DS.'..'.DS.'com_jforce'.DS.'models'.DS.'phase.php');

class HReportModelReport extends JModel {

    function getPersonDetails() {

        $id = JRequest::getInt('uid');
        $db =& JFactory::getDBO();

        // get user name, surname and gender
        $sql = "SELECT firstname, lastname FROM #__jf_persons WHERE uid = $id";
        $this->_db->setQuery($sql);
        $names = $this->_db->loadAssoc();

        $details = new stdClass();
        $details->firstname = ucfirst($names['firstname']);
        $details->lastname = ucfirst($names['lastname']);
        $sql = "SELECT sex FROM #__users WHERE id = $id";
        $this->_db->setQuery($sql);
        $details->gender = $this->_db->loadResult()==1?'Male':'Female';

        // get weight loss
                //start
        $query = "SELECT survey_value, project_id FROM #__jf_jtpl_survey_details WHERE CHARACTER_LENGTH(survey_value)>10 AND survey_variable = 'intake_survey' AND user_id = $id ORDER BY project_id LIMIT 1";
        $db->setQuery($query);
        $data = $db->loadObject();
        //parse data
        if ($data) {
            $params = explode(',', $data->survey_value);
            foreach ($params as $param) {
                $attr = explode(':', $param);
                switch ($attr[0]) {
                    case 'W':
                        $details->startweight = $attr[1];
                    break;
                    case 'F':
                        $details->startfat = $attr[1];
                    break;
                    case 'PH':
                        $details->startph = $attr[1];
                    break;
                }
            }
        } else {
            $details->startweight = 0;
            $details->startfat = 0;
            $details->startph = 0;
        }

        $diff = $this->getIntakeDiff($id);

        $details->wl = $diff->weight;
        $details->fl = $diff->fat;

        //get user photos
        $photos = $this->getFirstLastPhoto($id);
        $details->startphoto = $photos->first;
        $details->endphoto = $photos->last;

        // get registration survey results
        $details->reg_survey_results = $this->getRegSurveyResults($id);

        // get age
        $details->age = $this->getAge($id);

        //get diseases eliminated
        $details->diseaseseliminated = $this->getEliminatedDiseases($id);

        //get medications eliminated
        $details->medicationseliminated = $this->getEliminatedMedications($id);

        return $details;
    }

    function getIntakeDiff($user_id)
    {
        $db = $this->_db;
        $query = "SELECT survey_value FROM #__jf_jtpl_survey_details
                  WHERE survey_variable IN ('reg_intake', 'intake_evaluation') AND user_id = ".$db->Quote($user_id)." ORDER BY project_id ASC";
        $db->setQuery($query);
        $result = $db->loadResultArray();
        
        $initial = explode(',', $result[0]); // registration intake
        $final = explode(',', $result[count($result) - 1]); // last submitted intake

        $result = array_map(function($el1, $el2){
                return $el1 - $el2;
            }, $initial, $final);

        $diff = new stdClass();
        $diff->weight = $result[0];
        $diff->fat = $result[1];
        $diff->ph = $result[2];

        $diff->start = new stdClass();
        $diff->start->weight = $initial[0];
        $diff->start->fat = $initial[1];
        $diff->start->ph = $initial[2];

        $diff->end = new stdClass();
        $diff->end->weight = $final[0];
        $diff->end->fat = $final[1];
        $diff->end->ph = $final[2];

        return $diff;
    }

    function getFirstLastPhoto($user_id)
    {
        $db = $this->_db;
        $db->setQuery("SELECT photo FROM #__jf_jtpl_progress_tracking WHERE user_id = ".$db->Quote($user_id)." ORDER BY phase_id ASC");
        $result = $db->loadResultArray();
        
        $photos = new stdClass();
        $photos->first = $result[0] ? $result[0] : 'picture_not_found.jpg';
        $last_index = count($result) - 1;
        $photos->last = $result[$last_index] ? $result[$last_index] : 'picture_not_found.jpg';

        return $photos;
    }

    function getAge($user_id)
    {
        $user = JFactory::getUser($user_id);
        $parsed_birth = strtotime($user->birthday);
        if($parsed_birth) {
            $datetime1 = date_create(date('Y-m-d', strtotime($user->birthday)));
            $datetime2 = date_create();
            $interval = date_diff($datetime1, $datetime2);
            return $interval->format('%Y');
        } else {
            return null;
        }
    }

    function getEliminatedDiseases($user_id)
    {
        $user_id = (int)$user_id;
        $sql = "SELECT COUNT( id ) FROM #__jf_jtpl_survey_tracking
            WHERE user_id = $user_id AND tracking_category = 'diseases' AND STATUS = 'eliminated'";
        $this->_db->setQuery($sql);
        $ret = $this->_db->loadResult();
        $ret = $ret ? $ret:'0';
        return $ret;
    }

    function getEliminatedDiseasesNames($user_id, $pid = null)
    {
        $user_id = (int)$user_id;
        $sql = "SELECT d.question FROM #__jf_jtpl_survey_tracking t
                LEFT JOIN #__jf_jtpl_survey_diseases d ON t.tracking_variable = d.variable
                WHERE t.user_id = $user_id AND project_id = $pid AND tracking_category = 'diseases' AND STATUS = 'eliminated'";
        $this->_db->setQuery($sql);
        $ret = $this->_db->loadResultArray();
        return $ret;
    }

    function getEliminatedMedications($user_id)
    {
        $user_id = (int)$user_id;
        $sql = "SELECT COUNT( id ) FROM #__jf_jtpl_survey_tracking
            WHERE user_id = $user_id AND `tracking_category` = 'medtrack' AND status = 'eliminated'";
        $this->_db->setQuery($sql);
        $ret = $this->_db->loadResult();
        $ret = $ret ? $ret:'0';
        return $ret;
    }

    function getEliminatedMedicationsNames($user_id, $pid = null)
    {
        $user_id = (int)$user_id;
        $sql = "SELECT m.question FROM #__jf_jtpl_survey_tracking t
                LEFT JOIN #__jf_jtpl_survey_medtrack m ON t.tracking_variable = m.variable
                WHERE t.user_id = $user_id AND project_id = $pid AND tracking_category = 'medtrack' AND status = 'eliminated'";
        $this->_db->setQuery($sql);
        $ret = $this->_db->loadResultArray();
        return $ret;
    }

    function getBodyscoreImprovementsDiff(array $IDs, $uid, $pid)
    {
        $db = $this->_db;

        //$init_pid = null;
        //$survey_var = null;
        /*if($pid == 1) {
            // check if we have available saved 1st phase
            $db->setQuery("SELECT * FROM #__jf_jtpl_survey_details WHERE user_id = $uid AND project_id = 1");
            $db->query();
            $has = (bool)$db->getNumRows();

            if($has) {
                $survey_var = 'reg_bodyscore';
                $init_pid = 0;
            } else {
                return array(); // nothing to diff here
            }
        } else {
            $survey_var = 'bodyscore_evaluation';
            $init_pid = $pid - 1;
        }*/

        $survey_var = 'reg_bodyscore';
        $init_pid = 0;

        // get initial bodyscore IDs
        $db->setQuery("SELECT survey_value FROM #__jf_jtpl_survey_details
                  WHERE survey_variable = ".$db->Quote($survey_var)." AND user_id = ".$db->Quote($uid))." AND project_id = $init_pid";
        $init_IDs = explode(',', $db->loadResult());
        $diff = array_diff($init_IDs, $IDs);

        $sql = "SELECT improvement FROM #__jf_jtpl_survey_body_score WHERE id IN (".implode(',', $diff).")";
        $db->setQuery($sql);
        return $db->loadResultArray();
    }

    function getPhaseDetails($uid, $pid)
    {
        $model = new JforceModelPhase();
        $details = $model->getProgressTrackingDetails($uid, $pid);
        $bodyscore_IDs = $details->bodyscore->answers;
        if($bodyscore_IDs[0] != '') {
            $details->bodyscore->improvements = $this->getBodyscoreImprovementsDiff($bodyscore_IDs, $uid, $pid);
        } else {
            $details->bodyscore->improvements = null;
        }

        $details->eliminated = new stdClass();
        $details->eliminated->diseases = $this->getEliminatedDiseasesNames($uid, $pid);
        $details->eliminated->medications = $this->getEliminatedMedicationsNames($uid, $pid);

        return $details;
    }

    function getRegSurveyResults($uid = null)
    {
        $model = new JforceModelPhase();
        $results_obj = $model->get_reg_survey_results($uid);
        return $results_obj;
    }

}

?>
