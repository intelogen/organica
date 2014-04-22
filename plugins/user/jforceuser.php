<?php
/**
 * @version		$Id: example.php 10381 2008-06-01 03:35:53Z pasamio $
 * @package		Joomla
 * @subpackage	JFramework
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.plugin.plugin');
define("DEFAULT_CLIENT",4);

/**
 * Example User Plugin
 *
 * @package		Joomla
 * @subpackage	JFramework
 * @since 		1.5
 */
class plgUserJforceuser extends JPlugin {

	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @param 	array  $config  An array that holds the plugin configuration
	 * @since 1.5
	 */
	function plgUserJforceuser(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	/**
	 * Example store user method
	 *
	 * Method is called before user data is stored in the database
	 *
	 * @param 	array		holds the old user data
	 * @param 	boolean		true if a new user is stored
	 */
	function onBeforeStoreUser($user, $isnew)
	{
		global $mainframe;
        //echo '<pre>';
        //print_r($user);
        //die();
	}

	/**
	 * Example store user method
	 *
	 * Method is called after user data is stored in the database
	 *
	 * @param 	array		holds the new user data
	 * @param 	boolean		true if a new user is stored
	 * @param	boolean		true if user was succesfully stored in the database
	 * @param	string		message
	 */
	function onAfterStoreUser($user, $isnew, $success, $msg)
	{
		global $mainframe;
        
        /**
		$args = array();
		$args['username']	= $user['username'];
		$args['email'] 		= $user['email'];
		$args['fullname']	= $user['name'];
		$args['password']	= $user['password'];
        **/
        
        $splitname = explode(" ",$user["name"],2);
        // take the first word as firstname and remaining as lastname
        
        $fname = $splitname[0];
        $lname = $splitname[1];

        if ($isnew && $success)
        {   
            
            $db = JFactory::getDBO();
            
            
            // $db->setQuery("DELETE FROM #__users WHERE `id` = ".$db->Quote($user["id"]));            
//             $db->query();
            
            //mdie($db);            
            
            $referred_by = $user["referredby"];
            $referred_by = intval(substr($referred_by, 6, strlen($referred_by)));
            if(!$referred_by){
                $query = "UPDATE #__users SET ".$db->nameQuote("params")." = CONCAT(`params`, ".$db->Quote("\nreferred_by=".$user["referredby"]."").") WHERE `id` = ".$db->Quote($user["id"])." LIMIT 1"; 
                
                
                $db->setQuery($query);                
                $db->query();
                
            }
            

            if($referred_by){
                $query = "SELECT * FROM #__jf_companies WHERE ".$db->nameQuote("id")." = ".$db->Quote($referred_by)." LIMIT 1";         
                $db->setQuery($query);
                $db->query();
                
                $coach_id = $db->loadObject()->owner;
            }else{
                $coach_id = 0;
            }
            
            // just after the user is created, it is added to jforce
            $created = gmdate("Y-m-d H:i:s");
            // $db = JFactory::getDBO();
            $query = 'INSERT INTO '.$db->nameQuote('#__jf_persons')
            .' ('.$db->nameQuote('firstname')
            .' , '.$db->nameQuote('lastname') 
            .' , '.$db->nameQuote('company') 
            .' , '.$db->nameQuote('uid')
            .' , '.$db->nameQuote('systemrole')
            .' , '.$db->nameQuote('created')
            .' , '.$db->nameQuote('published').')'
            .'VALUES('.$db->Quote($fname)
            .','.$db->Quote($lname)
            .','.$db->Quote($referred_by) // this will assign the person to a particular coach
            .','.$db->Quote($user["id"])
            .','.$db->Quote(DEFAULT_CLIENT) // 4 is the default id for client type in jforce configuration
            .','.$db->Quote($created)
            .','.$db->Quote('1')
            . ') ';
            $db->setQuery($query);
            //echo $query;
            $db->query();
            
            // create default project as first phase for the user 
            // so when creating a project, these parameters should be assigned
            // a) author of the project is this user being registered
            // b) company is the coach company assigned to /referred by 
            // c) status is Active by default
            // d) image and imagethumb represent status at the beginning of the project
            // e) created is now time and starts on will be selected by the coach
            // f) published, i do not know about this crap. 
            
            // so build an array of phases (projects) for any particular user whenever being registered
            
            /** Default phases as found right now at the referring website 
            
            Phase No    Phase Title                             Start Date    Completed Date    Status    Activate
                1    Phase 1 Intestinal / Digestive Cleanse     6/4/2007                         Open    NA
                2    Phase 2 Yeast / Candida Cleanse            7/11/2007                        Open    NA
                3    Phase 3 Parasite Cleanse                   4/15/2009                        Open    NA
                4    Phase 4 Liver Cleanse                                                  Not Started  Start Phase
                5    Phase 5 Heavy Metal / Chemical Cleanse                                 Not Started  Start Phase
                6    Phase 6 Adrenal Testing & Balancing                                    Not Started  Start Phase
                7    Phase 7 Hormone Testing & Balancing                                    Not Started  Start Phase
                8    Phase 8 Maintenance Protocols                                          Not Started  Start Phase
                9    Phase 9 Rebuilding & Support                                           Not Started  Start Phase
                10   Phase 10 Exercise Program                                              Not Started  Start Phase
            
            **/ 
            
            $startdate = $created;
            
            $phases = array();
            $phases[0] = "Phase 1 Intestinal / Digestive Cleanse";
            $phases[1] = "Phase 2 Yeast / Candida Cleanse";
            $phases[2] = "Phase 3 Parasite Cleanse";
            $phases[3] = "Phase 4 Liver Cleanse";
            $phases[4] = "Phase 5 Heavy Metal / Chemical Cleanse";
            $phases[5] = "Phase 6 Adrenal Testing & Balancing";
            $phases[6] = "Phase 7 Hormone Testing & Balancing";
            $phases[7] = "Phase 8 Maintenance Protocols";
            $phases[8] = "Phase 9 Rebuilding & Support";
            $phases[9] = "Phase 10 Exercise Program";
            
            $checklists = array();
            // survey, photoupload, direction, purchase, evaluation, signoff
            $checklists[0] = array(
                                "survey"=>"Phase 1 Start Surveys",
                                "photoupload"=>"Update Your Photo",
                                "direction"=>"Phase 1 Directions",
                                "purchase"=>"Purchase Phase 1 Kit",
                                "evaluation"=>"Phase 1 Evaluation",
                                "signoff"=>"Sign off by coach"  );
            
            $checklists[1] = array(
                            "survey"=>"Phase 2 Start Surveys",
                            "photoupload"=>"Update Your Photo",
                            "direction"=>"Phase 2 Directions",
                            "purchase"=>"Purchase Phase 2 Kit",
                            "evaluation"=>"Phase 2 Evaluation",
                            "signoff"=>"Sign off by coach"  );
                            
            $checklists[2] = array(
                            "survey"=>"Phase 3 Start Surveys",
                            "photoupload"=>"Update Your Photo",
                            "direction"=>"Phase 3 Directions",
                            "purchase"=>"Purchase Phase 3 Kit",
                            "evaluation"=>"Phase 3 Evaluation",
                            "signoff"=>"Sign off by coach"  );

            $checklists[3] = array(
                            "survey"=>"Phase 4 Start Surveys",
                            "photoupload"=>"Update Your Photo",
                            "direction"=>"Phase 4 Directions",
                            "purchase"=>"Purchase Phase 4 Kit",
                            "evaluation"=>"Phase 4 Evaluation",
                            "signoff"=>"Sign off by coach"  );
                            
            $checklists[4] = array(
                            "survey"=>"Phase 5 Start Surveys",
                            "photoupload"=>"Update Your Photo",
                            "direction"=>"Phase 5 Directions",
                            "purchase"=>"Purchase Phase 5 Kit",
                            "evaluation"=>"Phase 5 Evaluation",
                            "signoff"=>"Sign off by coach"  );
            $checklists[5] = array(
                            "survey"=>"Phase 6 Start Surveys",
                            "photoupload"=>"Update Your Photo",
                            "direction"=>"Phase 6 Directions",
                            "purchase"=>"Purchase Phase 6 Kit",
                            "evaluation"=>"Phase 6 Evaluation",
                            "signoff"=>"Sign off by coach"  );
            $checklists[6] = array(
                            "survey"=>"Phase 7 Start Surveys",
                            "photoupload"=>"Update Your Photo",
                            "direction"=>"Phase 7 Directions",
                            "purchase"=>"Purchase Phase 7 Kit",
                            "evaluation"=>"Phase 7 Evaluation",
                            "signoff"=>"Sign off by coach"  );
            $checklists[7] = array(
                            "survey"=>"Phase 8 Start Surveys",
                            "photoupload"=>"Update Your Photo",
                            "direction"=>"Phase 8 Directions",
                            "purchase"=>"Purchase Phase 8 Kit",
                            "evaluation"=>"Phase 8 Evaluation",
                            "signoff"=>"Sign off by coach"  );
            $checklists[8] = array(
                            "survey"=>"Phase 9 Start Surveys",
                            "photoupload"=>"Update Your Photo",
                            "direction"=>"Phase 9 Directions",
                            "purchase"=>"Purchase Phase 9 Kit",
                            "evaluation"=>"Phase 9 Evaluation",
                            "signoff"=>"Sign off by coach"  );
            $checklists[9] = array(
                            "survey"=>"Phase 10 Start Surveys",
                            "photoupload"=>"Update Your Photo",
                            "direction"=>"Phase 10 Directions",
                            "purchase"=>"Purchase Phase 10 Kit",
                            "evaluation"=>"Phase 10 Evaluation",
                            "signoff"=>"Sign off by coach"  );


           
            $db = JFactory::getDBO();
            
            $query = 'INSERT INTO '.$db->nameQuote('#__jf_projects')
                .' ('.$db->nameQuote('name')
                .' , '.$db->nameQuote('description') 
                .' , '.$db->nameQuote('author')
                .' , '.$db->nameQuote('leader')
                .' , '.$db->nameQuote('company')
                .' , '.$db->nameQuote('status')
                .' , '.$db->nameQuote('created')
                .' , '.$db->nameQuote('published').')'
                .'VALUES';
                
            $valuesarr = array();

            foreach($phases as $p){
                //print_r($p);
                $pname = $p;
                $pdesc = "Description not available";
                
                $valuesarr[] = '('.$db->Quote($pname)
                .','.$db->Quote($pdesc)
                .','.$db->Quote($user["id"]) // this will assign the client as the author
                .','.$db->Quote($coach_id) // this will assign the coach as the leader
                .','.$db->Quote($referred_by)
                .','.$db->Quote("Not Started") // 4 is the default id for client type in jforce configuration
                .','.$db->Quote($created)
                .','.$db->Quote('1')
                . ') ';
            }
            
            $query .= implode(",",$valuesarr);
            $db->setQuery($query);
            
            
            //mdie($db);
            $db->query();
            
            $uid = $user["id"];
            
            $query = "SELECT * from #__jf_projects WHERE ".$db->nameQuote("author")." = ".$db->Quote("$uid");            
            $db->setQuery($query);
            $db->query();
            
            $objects = $db->loadObjectList();

            $db = JFactory::getDBO();
            $count = 0;
            
            $rolesquery = 'INSERT INTO '.$db->nameQuote('#__jf_projectroles_cf')
                .' ('.$db->nameQuote('uid')
                .' , '.$db->nameQuote('pid') 
                .' , '.$db->nameQuote('role') 
                .' , '.$db->nameQuote('milestone')
                .' , '.$db->nameQuote('checklist')
                .' , '.$db->nameQuote('timetracker')
                .' , '.$db->nameQuote('document')
                .' , '.$db->nameQuote('ticket')
                .' , '.$db->nameQuote('discussion')
                .' , '.$db->nameQuote('quote')
                .' , '.$db->nameQuote('invoice').')'
                .'VALUES';
                
            $phasenumbers_query = 'INSERT INTO '.$db->nameQuote('#__jf_jtpl_phase_numbers')
                .' ('.$db->nameQuote('project_id')
                .' , '.$db->nameQuote('phase_number') .')'
                .'VALUES';
            
            $rolessarr = array();
            $phasenumbers_array = array();
            $phase_number = 1;
            
            $phases_reversed = array();
            
            foreach($phases as $key=>$value){
                $phases_reversed[$value]  = $key+1;
            }
            
            foreach($objects as $p){                
                // id     uid     pid     role     milestone     checklist     timetracker     document     ticket     discussion     quote     invoice
                
                $phase_number = $phases_reversed[$p->name];
                $count = $phase_number - 1;
                
                $phasenumbers_array[] = '('.$db->Quote($p->id).','.$db->Quote($phase_number).')';
                //$phase_number++;
                
                $rolesarr[] = '('.$db->Quote($uid)
                .','.$db->Quote($p->id)
                .','.$db->Quote('1') // this will assign the person to a particular coach
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                . ') ';
                
                $rolesarr[] = '('.$db->Quote($coach_id)
                .','.$db->Quote($p->id)
                .','.$db->Quote('1') // this will assign the person to a particular coach
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                .','.$db->Quote('4')
                . ') ';
                
                // also add checklists to each phase
                /** 
                Checklist                   Start dAte  Complete Date       STatus
                Phase 1 Start Surveys       4/20/2009                       Not Complete
                Update Your Photo           4/20/2009                       Not Complete
                Phase 1 Directions          4/20/2009                       Not Complete
                Purchase Phase 1 Kit        4/20/2009                       Not Complete
                Phase 1 Evaluation          4/20/2009                       Not Complete
                Sign off by coach    
                **/
                
                // each phase has different checklists, so that have to be found out. 
/**
*  Checklists table
id
pid
summary
description
visibility
milestone
tags
completed
reopened
datecompleted
datereopened
completedby
reopenedby
created
modified
author
published
**/
                $pid = $p->id;                
                $checklistarr = array();
                $checklistquery = 'INSERT INTO '.$db->nameQuote('#__jf_checklists')
                    .' ('.$db->nameQuote('pid')
                    .' , '.$db->nameQuote('summary') 
                    .' , '.$db->nameQuote('visibility')
                    .' , '.$db->nameQuote('completed')
                    .' , '.$db->nameQuote('reopened')
                    .' , '.$db->nameQuote('tags')// will be used to associate action to particular phase
                    .' , '.$db->nameQuote('created')
                    .' , '.$db->nameQuote('modified')
                    .' , '.$db->nameQuote('author')
                    .' , '.$db->nameQuote('published').')'
                    .'VALUES';
                foreach($checklists[$count] as $tag=>$chk){                    
                    $summary = $chk;
                    $desc = "";
                    $author = $coach_id;
                             
                    $checklistarr[] = '('.$db->Quote($pid)
                    .','.$db->Quote($summary)
                    .','.$db->Quote('1')
                    .','.$db->Quote('0')
                    .','.$db->Quote('0')
                    .','.$db->Quote($tag)
                    .','.$db->Quote($created)
                    .','.$db->Quote($created)
                    .','.$db->Quote($author)
                    .','.$db->Quote('1')
                    . ') ';
                }
                // ok execute checklists
                $db->setQuery($checklistquery." ".implode(",",$checklistarr));
                $db->query();
                //echo "<pre>";
//                print_r($db);
                //$count++;
            }
            // ok execute permissions
            $db->setQuery($rolesquery." ".implode(",",$rolesarr));
            $db->query(); 

            // ok add phase numbers
            $db->setQuery($phasenumbers_query." ".implode(",",$phasenumbers_array));
            $db->query(); 
            
            
            //print_r($db);
            
//            $q = "DELETE FROM #__users WHERE username = ".$db->Quote($user["username"]);
//            $db->setQuery($q);
//            $db->query();
//             die();            
//            

            //$location = JRoute::_('index.php?option=com_jforce&view=phase&task=application&layout=registration_survey_0');
//            header("Location: $location");
            return $success;
            
        }else if(!$new && $success){
            $db = JFactory::getDBO();
            $query = 'UPDATE '.$db->nameQuote('#__jf_persons')
            .' SET '.$db->nameQuote('firstname').' = '.$db->Quote($fname)
            .', '.$db->nameQuote('lastname').' = '.$db->Quote($lname)
            .' WHERE '.$db->nameQuote('uid').' = '.$db->Quote($user['id']);
            $db->setQuery($query);
            $db->query();   
        }
            
		if ($isnew)
		{
			// Call a function in the external app to create the user
			// ThirdPartyApp::createUser($user['id'], $args);
            
		}
		else
		{
			// Call a function in the external app to update the user
			// ThirdPartyApp::updateUser($user['id'], $args);
		}
	}

	/**
	 * Example store user method
	 *
	 * Method is called before user data is deleted from the database
	 *
	 * @param 	array		holds the user data
	 */
	function onBeforeDeleteUser($user)
	{
		global $mainframe;
        
        function mdie($var){
            echo "<pre>";
            print_r($var);
            die();
        }
        
        $db = JFactory::getDBO();
        
        $uid = $user["id"];
        // delete from persons table
        $db->setQuery("select * from #__jf_persons where ".$db->nameQuote("uid").'='.$db->Quote($uid)." limit 1");
        $db->query();
        $person_under_delete = $db->loadObject();        
        $person_id = $person_under_delete->id;        
        $db->setQuery("delete from #__jf_persons where ".$db->nameQuote("uid").'='.$db->Quote($uid)."  limit 1");
        $db->query();
        
        // delete from projectroles_cf table
        $db->setQuery("delete from #__jf_projectroles_cf where ".$db->nameQuote("uid").'='.$db->Quote($uid));
        $db->query();
        
        // delete from projects table
        $db->setQuery("select * from #__jf_projects where ".$db->nameQuote("author").'='.$db->Quote($uid));
        $db->query();
        $user_projects = $db->loadObjectList();
        $projects = array();
        foreach($user_projects as $p){
            $projects[] = $p->id;
        }
        
        $projects = implode(",",$projects);
        $db->setQuery("delete from #__jf_projects where FIND_IN_SET(".$db->nameQuote("id").','.$db->Quote($projects).")");
        $db->query();
        
        // delete from checklists table
        $db->setQuery("delete from #__jf_checklists where FIND_IN_SET(".$db->nameQuote("pid").','.$db->Quote($projects).")");
        $db->query();
        
        // delete from phase numbers
        $db->setQuery("delete from #__jf_jtpl_phase_numbers where FIND_IN_SET(".$db->nameQuote("project_id").','.$db->Quote($projects).")");
        $db->query();
        
        // delete from phasedetails
        $db->setQuery("delete from #__jf_jtpl_phasedetails where FIND_IN_SET(".$db->nameQuote("project_id").','.$db->Quote($projects).")");
        $db->query();        
        
        // delete from survey_details
        $db->setQuery("delete from #__jf_jtpl_survey_details where ".$db->nameQuote("user_id").'='.$db->Quote($uid));
        $db->query();
        
        // delete from survey_status
        $db->setQuery("delete from #__jf_jtpl_survey_status where ".$db->nameQuote("user_id").'='.$db->Quote($uid));
        $db->query();
        
        // delete from survey_tracking
        $db->setQuery("delete from #__jf_jtpl_survey_tracking where ".$db->nameQuote("user_id").'='.$db->Quote($uid));
        $db->query();
        
        // delete from extraboxes_tracking
        $db->setQuery("delete from #__jf_jtpl_survey_extraboxes_tracking where ".$db->nameQuote("box_id").' IN (SELECT '.$db->nameQuote("id")." FROM #__jf_jtpl_survey_extraboxes WHERE ".$db->nameQuote("user_id").'='.$db->Quote($uid).")");        
        $db->query();
        
        // delete from extraboxes
        $db->setQuery("delete from #__jf_jtpl_survey_extraboxes where ".$db->nameQuote("user_id").'='.$db->Quote($uid));
        $db->query();

        // delete from product_recommendations        
        $db->setQuery("delete from #__jf_jtpl_product_recommendations where FIND_IN_SET(".$db->nameQuote("project_id").','.$db->Quote($projects).")");
        $db->query();
        
        // delete from virtue mart
        $virtuemart_tables = "auth_user_group,auth_user_vendor,cart";        
        //$db->setQuery("delete from #__vm_auth_user_group where ".$db->nameQuote("user_id").'='.$db->Quote($uid));
        //$db->query();
        
        //$db->setQuery("delete from #__vm_auth_user_vendor where ".$db->nameQuote("user_id").'='.$db->Quote($uid));
        //$db->query();
        
        //$db->setQuery("delete from #__vm_cart where ".$db->nameQuote("user_id").'='.$db->Quote($uid));
        //$db->query();
        
        //$db->setQuery("delete from #__vm_orders where ".$db->nameQuote("user_id").'='.$db->Quote($uid));
        //$db->query();        
        
        //mdie($db);
        //$db->query();        
	}

	/**
	 * Example store user method
	 *
	 * Method is called after user data is deleted from the database
	 *
	 * @param 	array		holds the user data
	 * @param	boolean		true if user was succesfully stored in the database
	 * @param	string		message
	 */
	function onAfterDeleteUser($user, $succes, $msg)
	{
		global $mainframe;

	 	// only the $user['id'] exists and carries valid information

		// Call a function in the external app to delete the user
		// ThirdPartyApp::deleteUser($user['id']);
        
        // impose jtpl hack here
        /**
        * On after user is deleted jforce persons account and other details with the user should be deleted
        */
        
	}

	/**
	 * This method should handle any login logic and report back to the subject
	 *
	 * @access	public
	 * @param 	array 	holds the user data
	 * @param 	array    extra options
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function onLoginUser($user, $options)
	{
		// Initialize variables
		$success = false;        
        
		// Here you would do whatever you need for a login routine with the credentials
		//
		// Remember, this is not the authentication routine as that is done separately.
		// The most common use of this routine would be logging the user into a third party
		// application.
		//
		// In this example the boolean variable $success would be set to true
		// if the login routine succeeds

		// ThirdPartyApp::loginUser($user['username'], $user['password']);
        
        
        // ok everything is done so redirect user to the dashboard
//        echo "<pre>";
//        print_r($_SESSION);
//        die();

        $session = JSession::getInstance("none",array());        
        if($session->get("is_registration_process") == "yes"){
            // this is the registration process so , redirect to the registration time survey pages 
            $location = JRoute::_('index.php?option=com_jforce&view=phase&task=registration_just_complete&layout=registration_survey_0');
            header("Location: $location");
            die();
        }else{
            $location = JRoute::_('index.php?option=com_jforce&view=dashboard');
            header("Location: $location");
            die();
        }
		return $success;
	}
    
	/**
	 * This method should handle any logout logic and report back to the subject
	 *
	 * @access public
	 * @param array holds the user data
	 * @return boolean True on success
	 * @since 1.5
	 */
	function onLogoutUser($user)
	{
        // overriding JForce redirect
        return true;
        
		// Initialize variables
		$success = false;
        
//        echo "<pre>";
//        print_r(get_defined_vars());
//        die();

		// Here you would do whatever you need for a logout routine with the credentials
		//
		// In this example the boolean variable $success would be set to true
		// if the logout routine succeeds

		// ThirdPartyApp::loginUser($user['username'], $user['password']);

        $location = JRoute::_('index.php?option=com_jforce&view=dashboard');
        header("Location: $location");
        die();

		return $success;
	}
}
