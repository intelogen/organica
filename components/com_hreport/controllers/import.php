<?php

defined('_JEXEC') or die('Access denied.');

jimport('joomla.application.component.controller');

class HReportControllerImport extends JController {

    function step() {

        error_reporting(E_ALL);

        $user =& JFactory::getUser();
        if (!empty($user)) {

            $uid = $user->id;
            $db =& JFactory::getDBO();

            $bsc = implode(',', $_REQUEST['bodyscore']);
            $sql = "DELETE FROM #__jf_jtpl_survey_details WHERE user_id = $uid AND project_id = 0 AND survey_variable = 'reg_bodyscore'";
            $db->setQuery($sql);
            $db->query() or die($db->ErrorMsg());
            $sql = "INSERT INTO #__jf_jtpl_survey_details SET user_id = $uid, project_id = 0, survey_variable = 'reg_bodyscore', survey_value = '$bsc'";
            $db->setQuery($sql);
            $db->query() or die($db->ErrorMsg());

            //get disease vars
            $ds = array();
            foreach ($_REQUEST['dis'] as $dis) {
                $ds[] = "'".$dis."'";
            }
            
            $dss = implode(',', $ds);

            $sql = "DELETE FROM #__jf_jtpl_survey_details WHERE user_id = $uid AND project_id = 0 AND survey_variable LIKE 'reg_disease%'";
            $db->setQuery($sql);
            $db->query() or die($db->ErrorMsg());

            $types = array('cardiovascular','gastrointestinal','gyn','metabolic','neurological','orthopedic','other','psychiatric','pulmonary','rheumatological','skin');
           foreach ($types as $type) {

            $sql = "SELECT variable FROM #__jf_jtpl_survey_diseases WHERE (question IN ($dss)) AND type = '$type'";
            $db->setQuery($sql);
            $vars = $db->loadResultArray();

            // put diseases

            $bsc = implode(',', $vars);
            if (!empty($bsc)) {
            $sql = "INSERT INTO #__jf_jtpl_survey_details SET user_id = $uid, project_id = 0, survey_variable = 'reg_disease_$type', survey_value = '$bsc'";
            $db->setQuery($sql);
            $db->query() or die($db->ErrorMsg());
            }
           }

            // symptoms
            $sql = "DELETE FROM #__jf_jtpl_survey_details WHERE user_id = $uid AND project_id = 0 AND survey_variable LIKE 'reg_symptoms'";
            $db->setQuery($sql);
            $db->query() or die($db->ErrorMsg());
            $ds = array();
            foreach ($_REQUEST['sym'] as $dis) {
                $ds[] = "'".$dis."'";
            }
            $dss = implode(',', $ds);
            $sql = "SELECT variable FROM #__jf_jtpl_survey_symptoms WHERE (question IN ($dss))";
            $db->setQuery($sql);
            $vars = $db->loadResultArray();
            $bsc = implode(',', $vars);
            if (!empty($bsc)) {
            $sql = "INSERT INTO #__jf_jtpl_survey_details SET user_id = $uid, project_id = 0, survey_variable = 'reg_symptoms', survey_value = '$bsc'";
            $db->setQuery($sql);
            $db->query() or die($db->ErrorMsg());
            }

            // medtrack
            $sql = "DELETE FROM #__jf_jtpl_survey_details WHERE user_id = $uid AND project_id = 0 AND survey_variable LIKE 'reg_medtrack'";
            $db->setQuery($sql);
            $db->query() or die($db->ErrorMsg());
            $ds = array();
            foreach ($_REQUEST['med'] as $dis) {
                $ds[] = "'".$dis."'";
            }
            $dss = implode(',', $ds);
            $sql = "SELECT variable FROM #__jf_jtpl_survey_medtrack WHERE (question IN ($dss))";
            $db->setQuery($sql);
            $vars = $db->loadResultArray();
            $bsc = implode(',', $vars);
            if (!empty($bsc)) {
            $sql = "INSERT INTO #__jf_jtpl_survey_details SET user_id = $uid, project_id = 0, survey_variable = 'reg_medtrack', survey_value = '$bsc'";
            $db->setQuery($sql);
            $db->query() or die($db->ErrorMsg());
            }

            // lookfor
            $sql = "DELETE FROM #__jf_jtpl_survey_details WHERE user_id = $uid AND project_id = 0 AND survey_variable LIKE 'reg_looking_for'";
            $db->setQuery($sql);
            $db->query() or die($db->ErrorMsg());
            $ds = array();
            foreach ($_REQUEST['lf'] as $dis) {
                $ds[] = "'".$dis."'";
            }
            $dss = implode(',', $ds);
            $sql = "SELECT variable FROM #__jf_jtpl_survey_looking_for WHERE (question IN ($dss))";
            $db->setQuery($sql);
            $vars = $db->loadResultArray();
            $bsc = implode(',', $vars);
            if (!empty($bsc)) {
            $sql = "INSERT INTO #__jf_jtpl_survey_details SET user_id = $uid, project_id = 0, survey_variable = 'reg_looking_for', survey_value = '$bsc'";
            $db->setQuery($sql);
            $db->query() or die($db->ErrorMsg());
            }


        }
           $this->setRedirect(JRoute::_('index.php?option=com_hreport&view=import&layout=step2'));

    }

    function nextstep() {

        $user =& JFactory::getUser();
        $db =& JFactory::getDBO();
        $uid = $user->id;

            
        for ($i=1;$i<=10;$i++) {
            $phase = $_REQUEST['phase'][$i];

            //intake_survey
            $sql = "DELETE FROM #__jf_jtpl_survey_details WHERE user_id = $uid AND project_id = {$phase['id']} AND survey_variable = 'intake_survey'";
            $db->setQuery($sql);
            $db->query();
            $sql = "INSERT INTO #__jf_jtpl_survey_details SET user_id = $uid, project_id = {$phase['id']}, survey_variable = 'intake_survey', survey_value = 'W:{$phase['st_weight']},F:{$phase['st_fat']},PH:{$phase['st_phscore']}' ";
            $db->setQuery($sql);
            $db->query();

            //intake_evaluation
            $sql = "DELETE FROM #__jf_jtpl_survey_details WHERE user_id = $uid AND project_id = {$phase['id']} AND survey_variable = 'intake_evaluation'";
            $db->setQuery($sql);
            $db->query();
            $sql = "INSERT INTO #__jf_jtpl_survey_details SET user_id = $uid, project_id = {$phase['id']}, survey_variable = 'intake_evaluation', survey_value = 'W:{$phase['ed_weight']},F:{$phase['ed_fat']},PH:{$phase['ed_phscore']}' ";
            $db->setQuery($sql);
            $db->query();

            //bodyscore_evaluation
            $sql = "DELETE FROM #__jf_jtpl_survey_details WHERE user_id = $uid AND project_id = {$phase['id']} AND survey_variable = 'bodyscore_evaluation'";
            $db->setQuery($sql);
            $db->query();
            $bsc = implode(',',$phase['ed_bodyscore']);
            $sql = "INSERT INTO #__jf_jtpl_survey_details SET user_id = $uid, project_id = {$phase['id']}, survey_variable = 'bodyscore_evaluation', survey_value = '$bsc' ";
            $db->setQuery($sql);
            $db->query();

            //initial_survey
            $sql = "DELETE FROM #__jf_jtpl_survey_details WHERE user_id = $uid AND project_id = {$phase['id']} AND survey_variable = 'initial_survey'";
            $db->setQuery($sql);
            $db->query();
            $val = array();
            foreach ($phase['st_question'] as $k=>$v) {
                $val[]=$k.':'.$v;
            }
            $val=implode(',', $val);
            $sql = "INSERT INTO #__jf_jtpl_survey_details SET user_id = $uid, project_id = {$phase['id']}, survey_variable = 'initial_survey', survey_value = '$val' ";
            $db->setQuery($sql);
            $db->query();

            //end_evaluation
            $sql = "DELETE FROM #__jf_jtpl_survey_details WHERE user_id = $uid AND project_id = {$phase['id']} AND survey_variable = 'end_evaluation'";
            $db->setQuery($sql);
            $db->query();
            $val = array();
            foreach ($phase['ed_question'] as $k=>$v) {
                $val[]=$k.':'.$v;
            }
            $val=implode(',', $val);
            $sql = "INSERT INTO #__jf_jtpl_survey_details SET user_id = $uid, project_id = {$phase['id']}, survey_variable = 'end_evaluation', survey_value = '$val' ";
            $db->setQuery($sql);
            $db->query();

            //medtrack tracking
            $sql="DELETE FROM #__jf_jtpl_survey_tracking WHERE user_id = $uid AND tracking_category = 'medtrack' AND project_id = {$phase[id]}";
            $db->setQuery($sql);
            $db->query();
            foreach ($phase['medtrack'] as $k=>$v) {
                $sql="INSERT INTO #__jf_jtpl_survey_tracking SET user_id = $uid, tracking_category = 'medtrack', tracking_variable = '$k', status = '$v', project_id = {$phase[id]}";
                $db->setQuery($sql);
                $db->query();
            }

            //photos handling
            $st_tmpname = $_FILES['phase']['tmp_name'][$i]['startphoto'];
            $ed_tmpname = $_FILES['phase']['tmp_name'][$i]['endphoto'];

            $newnamest = md5(microtime()).'.'.end(explode(".", $_FILES['phase']['name'][$i]['startphoto']));
            $newnameed = md5(microtime()).'.'.end(explode(".", $_FILES['phase']['name'][$i]['endphoto']));

            $sql = "DELETE FROM #__jf_jtpl_phasedetails WHERE phase_id = {$phase[id]}";
            $db->setQuery($sql);
            $db->query();

            if ($st_tmpname) {
                if (move_uploaded_file($st_tmpname, 'uploads_jtpl/phase_details/'.$newnamest)) {
                }
            }
            if ($ed_tmpname) {
                if (move_uploaded_file($ed_tmpname, 'uploads_jtpl/phase_details/'.$newnameed)) {
                }
            }

            if ($ed_tmpname || $st_tmpname) {
                $sql = "INSERT INTO #__jf_jtpl_phasedetails SET phase_id = {$phase[id]}, endphoto = '$newnameed', startphoto = '$newnamest'";
                $db->setQuery($sql);
                $db->query();
            }

        }

        $this->setRedirect(JRoute::_('index.php?option=com_hreport&view=report&uid='.$uid));
//        echo "<pre>";
//        die(print_r($_FILES));

    }

}
?>
