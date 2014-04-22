<?php
// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
    	<td class="contentheading"><?php echo $this->title;?></td>
        <td align="right"><?php echo "|&nbsp;&nbsp;".$this->otherLink.'&nbsp;&nbsp;|&nbsp;&nbsp;'.$this->composeLink."&nbsp;&nbsp;|";?></td>
    </tr>
</table>
<table width="100%" cellpadding="2" cellspacing="2" style="border:1px solid #DDD">
	<tr style="background-color:#DDD">
    	<td class="sectiontableheader" width="40%">Subject</td>
        <td class="sectiontableheader"><?php echo $this->fromHeader;?></td>
        <td class="sectiontableheader" width="20%">Date</td>
        <td class="sectiontableheader" width="10%">Action</td>
    </tr>
	<?php
    for($i=0; $i<count($this->messages); $i++) :
        $message = $this->messages[$i];
        $k = $i%2;
		$class = $message->read ? '' : 'unread';
    ?>
    <tr class="sectiontableentry<?php echo $k;?> <?php echo $class;?>" <?php if($class == "unread"):?> style="font-weight:bold" <?php endif;  ?>>
        <td><?php echo $message->link;?></td>
        <td><?php echo $message->name;?></td>
        <td><?php echo $message->created;?></td>
        <td align="center"><?php echo $message->delete;?></td>
    </tr>
	<?php endfor; ?>
    <?php if (!count($this->messages)) : ?>
    	<tr class="sectiontableentry0">
        	<td colspan="4" align="center" style="font-weight:bold;"><br />You have no messages yet.<br /><br /></td>
    	</tr>
    <?php endif; ?>
</table>
<div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>

