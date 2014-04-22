<?php
// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
    	<td class="contentheading">View Message</td>
        <td align="right"><?php echo "|&nbsp;&nbsp;".$this->otherLink.'&nbsp;&nbsp;|&nbsp;&nbsp;'.$this->composeLink."&nbsp;&nbsp;|";?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
    	<td class="sectiontableheader" colspan="2">Message Details</td>
    </tr>
	<tr class="sectiontableentry0">
    	<td width="65" class="label"><?php echo $this->fromHeader;?>:</td>
        <td><?php echo $this->message->name;?>
    </tr>
    <tr class="sectiontableentry1">
    	<td class="label">Subject:</td>
        <td><?php echo $this->message->subject;?>
    </tr>
    <tr class="sectiontableentry0">
    	<td class="label">Date:</td>
        <td><?php echo $this->message->created;?>
    </tr>
    <tr class="sectiontableentry1">
    	<td class="label" valign="top">Body:</td>
        <td><?php echo $this->message->body;?>
    </tr>
</table>
