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
            // just after the user is created, it is added to jforce
            $created = gmdate("Y-m-d H:i:s");
            $db = JFactory::getDBO();
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
            .','.$db->Quote(intval($user["referredby"]))
            .','.$db->Quote($user["id"])
            .','.$db->Quote(DEFAULT_CLIENT) // 4 is the default id for client type in jforce configuration
            .','.$db->Quote($created)
            .','.$db->Quote('1')
            . ') ';
            $db->setQuery($query);
            //echo $query;
            $db->query();   
            
            // allocate user as a person of the Coach Company            
            
            // create default project as first phase for the user            
            
            
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
        
        header("Location: /index.php/component/jforce/dashboard/dashboard.html");
        die();
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

		// Here you would do whatever you need for a logout routine with the credentials
		//
		// In this example the boolean variable $success would be set to true
		// if the logout routine succeeds

		// ThirdPartyApp::loginUser($user['username'], $user['password']);

        header("Location: /index.php/component/jforce/dashboard/dashboard.html");
        die();

		return $success;
	}
}
