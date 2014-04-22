<?php
defined('_JEXEC') or die('Restricted access');

$mainframe->registerEvent('onLoadCompany', 'jfSnapcasa');

function jfSnapcasa($company) {
	
	$pluginModel = JModel::getInstance('Plugin','JForceModel');
	$plugin = $pluginModel->getPlugin('snap');
	
	$defaultCompanyThumb = '<img src="'.JURI::root().'components/com_jforce/images/company_icons/default.png" />';
	$defaultCompanyLarge = '<img src="'.JURI::root().'components/com_jforce/images/company_icons/default_large.png" />';
	
	$pluginParams = new JParameter( $plugin->params );

	$snapcode = $pluginParams->get('snap_code');
	
	if ( $snapcode && $company->homepage):
		
		if($company->image == $defaultCompanyThumb):

			$company->image = '<img src="http://snapcasa.com/get.aspx?code='.$snapcode.'&size=s&url='.$company->homepage.'" />';
		
		elseif($company->image == $defaultCompanyLarge):

			$company->image = '<img src="http://snapcasa.com/get.aspx?code='.$snapcode.'&size=m&url='.$company->homepage.'" />';
		
		endif;
		
	endif;

	return true;
}