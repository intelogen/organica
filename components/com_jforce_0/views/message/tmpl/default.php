<?php
// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
    	<td class="contentheading"><?php echo $this->title;?></td>
        <td align="right"><?php echo $this->composeLink.'&nbsp;'.$this->otherLink;?></td>
    </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
    	<td class="sectiontableheader" width="40%">Subject</td>
        <td class="sectiontableheader"><?php echo $this->fromHeader;?></td>
        <td class="sectiontableheader" width="20%">Date</td>
        <td class="sectiontableheader" width="10%">&nbsp;</td>
    </tr>
	<?php
    for($i=0; $i<count($this->messages); $i++) :
        $message = $this->messages[$i];
        $k = $i%2;
		$class = $message->read ? '' : 'unread';
    ?>
    <tr class="sectiontableentry<?php echo $k;?> <?php echo $class;?>">
        <td><?php echo $message->link;?></td>
        <td><?php echo $message->name;?></td>
        <td><?php echo $message->created;?></td>
        <td align="center"><?php echo $message->delete;?></td>
    </tr>
	<?php endfor; ?>
    <?php if (!count($this->messages)) : ?>
    	<tr class="sectiontableentry0">
        	<td colspan="4" align="center" style="font-weight:bold;">No Messages</td>
    	</tr>
    <?php endif; ?>
</table>
<div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>

