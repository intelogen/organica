<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			default.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<ul>
<li><a href='<?php echo JRoute::_('index.php?option=com_jforce&view=systemrole&layout=form'); ?>'><?php echo JText::_('New Systemrole'); ?></a></li>	
</ul>

		<div>
			<?php
	 		for($i=0; $i<count($this->systemroles); $i++) :
				$systemrole = $this->systemroles[$i];
				$k = $i%2;
			?>
			<div>
				<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=systemrole&layout=systemrole&id='.$systemrole->id); ?>'><?php echo JText::_('View Systemrole'); ?></a><br />
		<span class='title'><?php echo JText::_('Name'); ?></span>:  
					<?php echo $systemrole->name;?><br />
				<span class='title'><?php echo JText::_('System_access'); ?></span>:  
					<?php echo $systemrole->system_access;?><br />
				<span class='title'><?php echo JText::_('Admin_access'); ?></span>:  
					<?php echo $systemrole->admin_access;?><br />
				<span class='title'><?php echo JText::_('Project_management'); ?></span>:  
					<?php echo $systemrole->project_management;?><br />
				<span class='title'><?php echo JText::_('People_management'); ?></span>:  
					<?php echo $systemrole->people_management;?><br />
				<span class='title'><?php echo JText::_('Add_project'); ?></span>:  
					<?php echo $systemrole->add_project;?><br />
				<span class='title'><?php echo JText::_('Manage_company_details'); ?></span>:  
					<?php echo $systemrole->manage_company_details;?><br />
				<span class='title'><?php echo JText::_('Can_see_private_objects'); ?></span>:  
					<?php echo $systemrole->can_see_private_objects;?><br />
				<span class='title'><?php echo JText::_('Manage_assignment_filters'); ?></span>:  
					<?php echo $systemrole->manage_assignment_filters;?><br />
				<span class='title'><?php echo JText::_('Can_use_status_updates'); ?></span>:  
					<?php echo $systemrole->can_use_status_updates;?><br />
				<span class='title'><?php echo JText::_('Use_time_reports'); ?></span>:  
					<?php echo $systemrole->use_time_reports;?><br />
				<span class='title'><?php echo JText::_('Manage_time_reports'); ?></span>:  
					<?php echo $systemrole->manage_time_reports;?><br />
				
			</div>
		<?php endfor; ?>
	</div>	
