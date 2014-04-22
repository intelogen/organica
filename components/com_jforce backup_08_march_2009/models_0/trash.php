<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			trash.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelTrash extends JModel {
	
	var $_trash	= null;
	
    function __construct() {    	
        parent::__construct();		
	} 
	
	function listTrash() {	

		# Milestones
		$milestoneModel =& JModel::getInstance('Milestone','JForceModel');
		$milestones = $milestoneModel->listMilestones(5);
		
		$activity = array();
		if($milestones['trash']):
			foreach($milestones['trash'] as $m):
				$activity['trash'][]=$m;
			endforeach;
		endif;
		
		# Other Items
		$activityType = array(
							'checklist'
						#	'task',
						#	'comment',
						#	'discussion',
						#	'ticket',
						#	'document',
						#	'quote',
						#	'invoice'
							);
		
		foreach($activityType as $act):
			$function = 'list'.ucwords($act).'s';
			$model =& JModel::getInstance(ucwords($act),'JForceModel');
			$model->setPublished(-1);
			$items = $model->$function();
			
			if($items):
				foreach($items as $i):
					$activity[$act][] = $i;
				endforeach;
			endif;		
		endforeach;

		if($activity):
			$activity = JForceHelper::sortArray($activity,'created');
		endif;
		
		return $activity;
    }

}