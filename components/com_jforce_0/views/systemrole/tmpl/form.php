<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			form.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<script language='javascript' type='text/javascript'>
<!--
function submitbutton(pressbutton) {
	var form = document.adminForm;
	form.task.value=pressbutton;
	form.submit();
}
//-->
</script>
<h1><?php echo $this->title; ?></h1>
<form action='<?php echo $this->action ?>' method='post' name='adminForm'>
<table class='adminform' width='100%'>
<tr>
	<td>
			<button type='button' onclick="submitbutton('save')">
				<?php echo JText::_('Save') ?>
			</button>
			<button type='button' onclick="submitbutton('cancel')">
				<?php echo JText::_('Cancel') ?>
			</button>
	</td>
</tr>
</table>
<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
<tr>
				<td class='key'>
					<?php echo JText::_('Name'); ?></td><td>
					<input type='text' name='name' size='35' class='inputbox required' value='<?php echo $this->systemrole->name;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('System_access'); ?></td><td>
					<input type='text' name='system_access' size='35' class='inputbox required' value='<?php echo $this->systemrole->system_access;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Admin_access'); ?></td><td>
					<input type='text' name='admin_access' size='35' class='inputbox required' value='<?php echo $this->systemrole->admin_access;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Project_management'); ?></td><td>
					<input type='text' name='project_management' size='35' class='inputbox required' value='<?php echo $this->systemrole->project_management;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('People_management'); ?></td><td>
					<input type='text' name='people_management' size='35' class='inputbox required' value='<?php echo $this->systemrole->people_management;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Add_project'); ?></td><td>
					<input type='text' name='add_project' size='35' class='inputbox required' value='<?php echo $this->systemrole->add_project;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Manage_company_details'); ?></td><td>
					<input type='text' name='manage_company_details' size='35' class='inputbox required' value='<?php echo $this->systemrole->manage_company_details;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Can_see_private_objects'); ?></td><td>
					<input type='text' name='can_see_private_objects' size='35' class='inputbox required' value='<?php echo $this->systemrole->can_see_private_objects;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Manage_assignment_filters'); ?></td><td>
					<input type='text' name='manage_assignment_filters' size='35' class='inputbox required' value='<?php echo $this->systemrole->manage_assignment_filters;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Can_use_status_updates'); ?></td><td>
					<input type='text' name='can_use_status_updates' size='35' class='inputbox required' value='<?php echo $this->systemrole->can_use_status_updates;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Use_time_reports'); ?></td><td>
					<input type='text' name='use_time_reports' size='35' class='inputbox required' value='<?php echo $this->systemrole->use_time_reports;?>' />
				</td>
			</tr><tr>
				<td class='key'>
					<?php echo JText::_('Manage_time_reports'); ?></td><td>
					<input type='text' name='manage_time_reports' size='35' class='inputbox required' value='<?php echo $this->systemrole->manage_time_reports;?>' />
				</td>
			</tr>
		</table>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='systemrole' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->systemrole->id; ?>' />
<input type='hidden' name='task' value='' />
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
