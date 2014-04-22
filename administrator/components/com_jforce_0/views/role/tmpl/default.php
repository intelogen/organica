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

<form action='index.php' method='post' name='adminForm'>
<table cellpadding='4' cellspacing='0' border='0' width='100%' class='adminlist'>
    <thead>
        <tr>
            <th width='20'><input type='checkbox' name='toggle' value='' onclick='checkAll(<?php echo count($this->roles); ?>);' /></th>
            <th align='center' width="25"><?php echo JText::_('ID'); ?></th>
            <th><?php echo JText::_('Name'); ?></th>
        </tr>
	</thead>
		<tbody>
		<?php
		$k = 0;
		for($i=0; $i < count( $this->roles ); $i++) {
		$role = $this->roles[$i];
		?>
		<tr class='<?php echo 'row'.$k; ?>'>
		<td><input type='checkbox' id='cb<?php echo $i; ?>' name='cid[]' value='<?php echo $role->id; ?>' onclick='isChecked(this.checked);' /></td>
		<td align='center'><?php echo $role->id; ?></td>
		<td><a href='#edit' onclick="return listItemTask('cb<?php echo $i; ?>','edit')"><?php echo $role->name; ?></td>
		<?php $k = 1 - $k; ?>
		</tr>
		<?php }	?>
		</tbody>
	<!--	<tfoot>
			<tr>
				<td colspan='10'><?php /*echo $pagination->getListFooter();*/?></td>
			</tr>
		</tfoot> -->
		</table>
		<input type='hidden' name='task' value='' />
		<input type='hidden' name='option' value='com_jforce' />
        <input type='hidden' name='c' value='configuration' />
		<input type='hidden' name='boxchecked' value='0' />
        <input type="hidden" name="view" value="role" />
		<input type="hidden" name="layout" value="form" />
		<input type="hidden" name="type" value="<?php echo $this->type;?>" />
		</form> 