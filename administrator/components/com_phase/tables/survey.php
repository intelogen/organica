<?php
defined('_JEXEC') or die('Restricted access');

class JTableSurvey extends JTable
{ 

	
	var $id				= null;
	var $user_id			= null;
	var $project_id			= null;
	var $survey_variable		= null;
	var $survey_value		= null;
	var $key 			= null;
			
	
	
	function __construct( &$_db )
	{
		parent::__construct( '#__jf_jtpl_survey_details', 'id', $_db );
	}	
}