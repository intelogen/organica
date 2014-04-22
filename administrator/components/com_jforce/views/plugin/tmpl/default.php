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
<form name="uploadForm" method="post" enctype="multipart/form-data">
<fieldset>
	<legend><?php echo JText::_('Install Plugin');?></legend>
    <input type="file" name="plugin" class="inputbox" id="plugin" />&nbsp;&nbsp;
    <input type="submit" name="upload" class="button" value="<?php echo JText::_('Upload');?>" />
</fieldset>
<input type="hidden" name="option" value="com_jforce" />
<input type="hidden" name="task" value="installPlugin" />
<?php echo JHTML::_('form.token'); ?>
</form>
<form action='index.php' method='post' name='adminForm'>
<table cellpadding='4' cellspacing='0' border='0' width='100%' class='adminlist'>
    <thead>
        <tr>
            <th width='20'><input type='checkbox' name='toggle' value='' onclick='checkAll(<?php echo count($this->plugins); ?>);' /></th>
            <th align='center'><?php echo JText::_('ID'); ?></th>
            <th><?php echo JText::_('Name'); ?></th>
            <th><?php echo JText::_('Published'); ?></th>
        </tr>
	</thead>
		<tbody>
		<?php
		$k = 0;
		for($i=0; $i < count( $this->plugins ); $i++) {
		$plugin = $this->plugins[$i];
		$published = $plugin->published ? '<img src="images/tick.png" />' : '<img src="images/publish_x.png" />';
		$default = $plugin->default ? '<img src="images/tick.png" />' : '<img src="images/publish_x.png" />';
		?>
		<tr class='<?php echo 'row'.$k; ?>'>
		<td width="15"><input type='checkbox' id='cb<?php echo $i; ?>' name='cid[]' value='<?php echo $plugin->id; ?>' onclick='isChecked(this.checked);' /></td>
		<td align='center' width="15"><?php echo $plugin->id; ?></td>
		<td><a href='#edit' onclick="return listItemTask('cb<?php echo $i; ?>','edit')"><?php echo $plugin->name; ?></td>
        <td width="50" align="center"><?php echo $published; ?></td>
		<?php $k = 1 - $k; ?>
		</tr>
		<?php }	?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan='10'><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>
		</table>
		<input type='hidden' name='task' value='' />
		<input type='hidden' name='option' value='com_jforce' />
        <input type='hidden' name='c' value='configuration' />
		<input type='hidden' name='boxchecked' value='0' />
        <input type="hidden" name="view" value="plugin" />
		<input type="hidden" name="layout" value="form" />
        <input type='hidden' name='ret' value='index.php?option=com_jforce' />
		</form> 