<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			systemrole.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<ul>
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=systemrole&layout=form&id='.$this->systemrole->id); ?>'><?php echo JText::_('Edit Systemrole'); ?></a></li>	
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=systemrole&layout=form'); ?>'><?php echo JText::_('New Systemrole'); ?></a></li>	
</ul>

		<div>
		Name: <?php echo $this->systemrole->name;?><br />
					System_access: <?php echo $this->systemrole->system_access;?><br />
					Admin_access: <?php echo $this->systemrole->admin_access;?><br />
					Project_management: <?php echo $this->systemrole->project_management;?><br />
					People_management: <?php echo $this->systemrole->people_management;?><br />
					Add_project: <?php echo $this->systemrole->add_project;?><br />
					Manage_company_details: <?php echo $this->systemrole->manage_company_details;?><br />
					Can_see_private_objects: <?php echo $this->systemrole->can_see_private_objects;?><br />
					Manage_assignment_filters: <?php echo $this->systemrole->manage_assignment_filters;?><br />
					Can_use_status_updates: <?php echo $this->systemrole->can_use_status_updates;?><br />
					Use_time_reports: <?php echo $this->systemrole->use_time_reports;?><br />
					Manage_time_reports: <?php echo $this->systemrole->manage_time_reports;?><br />
					
		</div>	
