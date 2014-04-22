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

<form action='<?php echo $this->action ?>' method='post' name='adminForm'>

<?php
echo $this->tabs->startPane('pane');
echo $this->tabs->startPanel('General', 'tab1');
?>
		<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
			<tr>
				<td class='key'>
					<?php echo JText::_('Name'); ?></td><td>
					<input type='text' name='name' size='35' class='inputbox required' value='<?php echo $this->role->name;?>' />
				</td>
			</tr>      
            <tr>
				<td class='key' valign="top">
					<?php echo JText::_('Access'); ?></td><td>
					<?php echo $this->systemroleoptions['settings']; ?>
				</td>
			</tr>
		</table>
<?php
echo $this->tabs->endPanel();

echo $this->tabs->startPanel('System', 'tab2');
?>
	<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
         <tr>
            <td class='key' valign="top">
                <?php echo JText::_('Objects'); ?></td><td>
                <?php echo $this->systemroleoptions['objects']; ?>
            </td>
        </tr>
    </table>
<?php
echo $this->tabs->endPanel();

echo $this->tabs->startPanel('Project', 'tab3');
?>
<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
    <tr>
        <td class='key' valign="top">
            <?php echo JText::_('Objects'); ?></td><td>
            <?php echo $this->projectroleoptions; ?>
        </td>
    </tr>
</table>
<?php
echo $this->tabs->endPanel();

echo $this->tabs->endPane();

?>

	
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->role->id; ?>' />
<input type='hidden' name='task' value='' />
<input type='hidden' name='model' value='accessrole' />
<input type='hidden' name='c' value='configuration' />
<input type='hidden' name='view' value='role' />
<input type='hidden' name='layout' value='form' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive');
