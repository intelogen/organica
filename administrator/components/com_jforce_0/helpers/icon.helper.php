<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			icon.helper.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
// Component Helper
jimport('joomla.application.component.helper');


class JForceIconHelper {
	
	function updateIcon($type,$icon = '') {
		$id = JRequest::getVar('id');
		$model = JModel::getInstance($type, 'JForceModel');
		$table = JTable::getInstance($type);
		$table->load($id);
		JForceIconHelper::deleteIcon($type, $table->image);	
		$table->image = $icon;
		$table->store();
		
		return true;
	}
	
	function deleteIcon($type, $oldImage) {
		jimport('joomla.filesystem.file');
		if ($oldImage) :
			$folder = $type == 'person' ? 'people_icons' : 'company_icons';
			$oldPath = 'jf_projects'.DS.$folder.DS.$oldImage;
			$oldThumb = 'jf_projects'.DS.$folder.DS.'thumbs'.DS.$oldImage;
			if (JFile::exists($oldPath)) :
				JFile::delete($oldPath);
			endif;
			if (JFile::exists($oldThumb)) :
				JFile::delete($oldThumb);
			endif;
		endif;
		return true;
	}
	
	function getProfileIcon($type) {
		$model = &JModel::getInstance($type, 'JForceModel');
		$function = 'get'.ucwords($type);
		$row = $model->$function();
		return $row->image;
	}
	
	
}