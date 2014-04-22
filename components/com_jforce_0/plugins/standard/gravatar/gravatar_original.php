<?php
defined('_JEXEC') or die('Restricted access');

$mainframe->registerEvent('onLoadPerson', 'jfGravatar');
#$mainframe->registerEvent('onLoadComment','jfGravatar');

function jfGravatar($person) {
	
	$params = JForcePluginHelper::loadParams('gravatar');
	
	$defaultPersonThumb = '<img src="'.JURI::root().'components/com_jforce/images/people_icons/default.png" />';
	$defaultPersonLarge = '<img src="'.JURI::root().'"components/com_jforce/images/people_icons/default_large.png" />';
	
	$defaultPersonThumbPath = JURI::root().'components/com_jforce/images/people_icons/default.png';
	$defaultPersonLargePath = JURI::root().'components/com_jforce/images/people_icons/default_large.png';
	
	$rating = $params->get('rating', 'g');
		
	if ($person->email):
		
		$imageHash = md5($person->email);
		
		if($person->image == $defaultPersonThumb):
			$default = $params->get('default', $defaultPersonThumbPath);
			$size = $params->get('thumb_size', '50');	
		elseif($person->image == $defaultPersonLarge):
			$default = $params->get('default', $defaultPersonLargePath);
			$size = $params->get('large_size', '150');
		endif;
		
		$person->image = '<img src="http://www.gravatar.com/avatar/'.$imageHash.'?d='.$default.'&s='.$size.'&r='.$rating.'" />';
		
	endif;

	return true;
}