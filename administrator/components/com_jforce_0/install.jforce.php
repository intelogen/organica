<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			install.jforce.php												*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

function com_install() {
	JTable::addIncludePath(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_jforce'.DS.'tables');
	require_once(JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_jforce'.DS.'helpers'.DS.'jforce.helper.php');
	
	createConfig();
	createProjectFolder();
	createOwnerCompany();
	importAdmins();
	autoInstallPlugins();
}

function createConfig() {
	$database = &JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__jf_configuration";
	$database->setQuery($query);
	$configExists = $database->loadResult();
	
	if (!$configExists) :
		$query = getConfigQuery();
		$database->setQuery($query);
		$database->query();
	endif;
}

function createProjectFolder() {
	jimport('joomla.filesystem.folder');
	
	$projectFolder = JPATH_SITE.DS.'jf_projects';
	
	if(!JFolder::exists($projectFolder)):
		JFolder::create($projectFolder);
	endif;
}

function createOwnerCompany() {
	$database = &JFactory::getDBO();
	$query = "SELECT COUNT(*) FROM #__jf_companies WHERE admin = '1'";
	$database->setQuery($query);
	$adminExists = $database->loadResult();
	
	if (!$adminExists) :
		$company = JTable::getInstance('Company', 'JTable');
		$company->name 		= "Default Admin Company";
		$company->address 	= '1234 Main Street<br />Anywhere, ST 11223';
		$company->phone 	= '(555) 555-5555';
		$company->fax 		= '(555) 555-4444';
		$company->admin 	= 1;
		$company->published	= 1;
		$company->created	= gmdate("Y-m-d H:i:s");
		$company->store();
	endif;
}

function importAdmins() {
	
	$database = &JFactory::getDBO();
	
	$query = "SELECT COUNT(*) FROM #__jf_persons";
	$database->setQuery($query);
	$existingUsers = $database->loadResult();
	
	if (!$existingUsers) :
		$query = "SELECT id FROM #__jf_companies WHERE admin = '1'";
		$database->setQuery($query);
		$adminCompany = $database->loadResult();
		
		$systemRole = findAdminRole();
		
		$query = "SELECT * FROM #__users WHERE gid = '25'";
		$database->setQuery($query);
		$admins = $database->loadObjectList();
		
		for ($i=0; $i<count($admins); $i++) :
			$a = $admins[$i];
			$name = explode(" ",$a->name);
			if (isset($name[1])):
				$first_name = $name[0];
				$last_name = $name[1];
			else :
				$first_name = '';
				$last_name = $name[0];
			endif;
			
			$person = JTable::getInstance('Person', 'JTable');
			$person->uid		= $a->id;
			$person->systemrole	= $systemRole;
			$person->company	= $adminCompany;
			$person->firstname	= $first_name;
			$person->lastname	= $last_name;
			$person->auto_add	= 1;
			$person->created	= gmdate("Y-m-d H:i:s");
			$person->published	= 1;
			$person->key		= JForceHelper::generateKey();
			$person->store();
		endfor;
	endif;
	
}

function findAdminRole() {
	$database = &JFactory::getDBO();
	
	$fields = array(
					'system_access', 
					'can_see_private_objects',
					'can_assign',
					'can_be_assigned_leads',
					'can_be_assigned_tickets',
					'can_access_messages',
					'can_view_reports'
				);
	
	$fields2 = array(
					'project',
					'lead',
					'person',
					'company',
					'campaign',
					'potential',
					'global_quote',
					'global_invoice',
					'global_ticket',
					'milestone',
					'checklist',
					'timetracker',
					'document',
					'ticket',
					'discussion',
					'quote',
					'invoice'
				);
	
	$where = " WHERE ".implode(" = '1' AND ",$fields)."'";
	$where2 = " AND ".implode(" = '4' AND ",$fields2)."'";
	$query = "SELECT id FROM #__jf_accessroles"
			.$where
			.$where2
			;
	$database->setQuery($query);
	$adminRole = $database->loadResult();
	
	if (!$adminRole) :
		$systemrole = JTable::getInstance('Accessrole', 'JTable');
		$systemrole->name = 'Administrator';
		foreach ($fields as $field) :
			$systemrole->$field = 1;
		endforeach;
		foreach ($fields2 as $field) :
			$systemrole->$field = 4;
		endforeach;
		$systemrole->store();
		$adminRole = $systemrole->id;
		
	endif;
	
	return $adminRole;
	
}

function autoInstallPlugins() {
	$db = &JFactory::getDBO();
	$query = "INSERT INTO `#__jf_plugins` (`id`, `name`, `author`, `authoremail`, `published`, `default`, `folder`, `link`, `params`, `type`, `ordering`, `authorurl`, `version`, `copyright`, `license`, `creationdate`) VALUES
('', 'Authorize.net', 'JoomPlanet', '', 1, 1, 'authorizenet', 0, '', 'gateway', 0, '', '', '', '', ''),
('', 'Gravatar', 'Extreme Joomla', '', 0, 0, 'gravatar', 0, '', 'standard', 1, '', '', '', '', '');";
	$db->setQuery($query);
	$db->query();
}

function getConfigQuery() {
	$query = "INSERT INTO `jos_jf_configuration` (`id`, `status`, `priority`, `supportcategories`, `quotetemplate`, `tax`, `currency`, `emailsubject`, `emailbody`, `generalcategories`, `invoicetemplate`, `showhelp`, `sales_stages`, `lead_status`) VALUES
('', 'Active|Paused|Cancelled|Completed', 'Low|Medium|High|Urgent', 'General|Hosting', '<div class=''tabContainer''>\r\n		<div class=''dateArea sideBox''>\r\n			<strong>Quote: </strong>%QUOTE_ID%<hr />\r\n			<strong>Valid Till</strong>%VALID_TILL%\r\n		</div>\r\n		<div class=''ownerLogo''>\r\n			%OWNER_LOGO%\r\n		</div>\r\n		<div class=''ownerAddress''>\r\n			<strong>%OWNER_NAME%</strong><br />%OWNER_ADDRESS%<br />%OWNER_PHONE%\r\n		</div>\r\n		<div class=''companyAddress''>\r\n		<span class=''billingTitle''>Billing Information:</span><br />\r\n			<strong>%COMPANY_NAME%</strong><br />\r\n			%COMPANY_ADDRESS%<br />\r\n            %COMPANY_PHONE%\r\n		</div>		\r\n		<h1>%QUOTE_NAME%</h1>\r\n		<div>Project:%QUOTE_PROJECT%</div>\r\n		\r\n		\r\n			 %QUOTE_MILESTONE%\r\n		\r\n			%QUOTE_CHECKLIST%\r\n		\r\n		\r\n		\r\n		<div class=''notesArea''>\r\n		<div class=''notesTitle''>Quote Description</div>\r\n			%QUOTE_DESCRIPTION%\r\n		</div>\r\n		\r\n		<div class=''servicesArea''>\r\n		<div class=''notesTitle''>Services</div>\r\n        	\r\n			%QUOTE_SERVICES%\r\n        <div class=''totalsArea''>\r\n            <div class=''sideBox''>\r\n                <div class=''field''>\r\n                    <div class=''key''>Subtotal</div>\r\n                    <span>%QUOTE_SUBTOTAL%</span>\r\n                </div>\r\n                \r\n                <div class=''field''>\r\n                    <div class=''key''>Discount</div>\r\n                    <span>%QUOTE_DISCOUNT%</span>\r\n                </div>\r\n               \r\n                <div class=''field''>\r\n                    <div class=''key''>Tax</div>\r\n                    <span>%QUOTE_TAX%</span>\r\n                </div>\r\n               \r\n                <div class=''fieldTotal''>\r\n                    <div class=''key''>Total</div>\r\n                    <span>%QUOTE_TOTAL%</span>\r\n                </div>\r\n            </div>\r\n        </div>\r\n\r\n	<div class=''footerArea''>\r\n	    <span class=''right''>%OWNER_PHONE%</span>\r\n		<span class=''left''><strong>%OWNER_NAME%</strong></span>\r\n        <span>%OWNER_ADDRESS%</span>\r\n	</div>			\r\n</div>', '5|7|10|15', '£', 'test subject', '''%TYPE%'',''%TITLE%'', ''%DATE%'', ''%PROJECT%'', ''%LINK%'', ''%DESCRIPTION%'', ''%AUTHOR%'', ''%COMPANY%''', 'General|Project Milestones', '<div class=''tabContainer''>\r\n		<div class=''dateArea sideBox''>\r\n			<strong>Quote: </strong>%QUOTE_ID%<hr />\r\n			<strong>Valid Till</strong>%VALID_TILL%\r\n		</div>\r\n		<div class=''ownerLogo''>\r\n			%OWNER_LOGO%\r\n		</div>\r\n		<div class=''ownerAddress''>\r\n			<strong>%OWNER_NAME%</strong><br />%OWNER_ADDRESS%<br />%OWNER_PHONE%\r\n		</div>\r\n		<div class=''companyAddress''>\r\n		<span class=''billingTitle''>Billing Information:</span><br />\r\n			<strong>%COMPANY_NAME%</strong><br />\r\n			%COMPANY_ADDRESS%<br />\r\n            %COMPANY_PHONE%\r\n		</div>		\r\n		<h1>%QUOTE_NAME%</h1>\r\n		<div>Project:%QUOTE_PROJECT%</div>\r\n		\r\n		\r\n			 %QUOTE_MILESTONE%\r\n		\r\n			%QUOTE_CHECKLIST%\r\n		\r\n		\r\n		\r\n		<div class=''notesArea''>\r\n		<div class=''notesTitle''>Quote Description</div>\r\n			%QUOTE_DESCRIPTION%\r\n		</div>\r\n		\r\n		<div class=''servicesArea''>\r\n		<div class=''notesTitle''>Services</div>\r\n        	\r\n			%QUOTE_SERVICES%\r\n        <div class=''totalsArea''>\r\n            <div class=''sideBox''>\r\n                <div class=''field''>\r\n                    <div class=''key''>Subtotal</div>\r\n                    <span>%QUOTE_SUBTOTAL%</span>\r\n                </div>\r\n                \r\n                <div class=''field''>\r\n                    <div class=''key''>Discount</div>\r\n                    <span>%QUOTE_DISCOUNT%</span>\r\n                </div>\r\n               \r\n                <div class=''field''>\r\n                    <div class=''key''>Tax</div>\r\n                    <span>%QUOTE_TAX%</span>\r\n                </div>\r\n               \r\n                <div class=''fieldTotal''>\r\n                    <div class=''key''>Total</div>\r\n                    <span>%QUOTE_TOTAL%</span>\r\n                </div>\r\n            </div>\r\n        </div>\r\n\r\n	<div class=''footerArea''>\r\n	    <span class=''right''>%OWNER_PHONE%</span>\r\n		<span class=''left''><strong>%OWNER_NAME%</strong></span>\r\n        <span>%OWNER_ADDRESS%</span>\r\n	</div>			\r\n</div>', 1, 'Prospecting|Qualification|Needs Analysis', 'Cold|Rare|Medium Rare|Well Done|Hot');";
	
	return $query;
}