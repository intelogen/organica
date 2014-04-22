
<?php
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
<form action='<?php echo $this->action ?>' method='post' name='adminForm'>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
    	<td class="contentheading"><?php echo $this->title;?></td>
        <td align="right"><button type='button' onclick="submitbutton('save')" class="button">
				<?php echo JText::_('Save') ?>
			</button>
			<button type='button' onclick="submitbutton('cancel')" class="button">
				<?php echo JText::_('Cancel') ?>
			</button></td>
    </tr>
</table>


<table width='100%' cellpadding='5' cellspacing='0' class='admintable'>
			<tr>
            	<td class="sectiontableheader" colspan="2">Message Details</td>
            </tr>
			<tr class="sectiontableentry0">
				<td class='label' width="65">
					<?php echo JText::_('To'); ?>:</td><td>
					<?php echo $this->lists['to']; ?>
				</td>
			</tr>
            <tr class="sectiontableentry0">
				<td class='label'>
					<?php echo JText::_('Subject'); ?>:</td><td>
					<input type='text' name='subject' size='35' class='inputbox required' value='' />
				</td>
			</tr><tr class="sectiontableentry0">
				<td class='label' colspan='2'>
					<?php echo JText::_('Description'); ?>:<br />
					<textarea name="body"></textarea>
				</td>
			</tr>
		</table>
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='message' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>	
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
