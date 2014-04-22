<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			view.feed.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class JforceViewPhase extends JView {

	function display()
	{
		global $mainframe;

		$doc     =& JFactory::getDocument();
		

		$model = &$this->getModel();
		$phase = $model->getPhase();
		$activity = $model->latestActivity();
		
		$doc->setTitle($phase->name);
		$doc->setDescription($phase->description);
		
		if ($activity) :
			foreach ($activity as $act) :
				for ($i=0; $i<count($act); $i++) :
					$a = $act[$i];
					$a['text'] = JForceHelper::snippet($a['text'], 300);
					
					$title = ucwords($a['type']).': '.$a['title'];
					
					$item = new JFeedItem();
					$item->title 		= $title;
					$item->link 		= $a['link'];
					$item->description 	= $a['text'];
					$item->date			= $a['created'];
					$doc->addItem( $item );
				endfor;
			endforeach;
		endif;
		

	}
}
