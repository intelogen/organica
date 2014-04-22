<?php
// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
    	<td class="contentheading">
        <img src="/images/icons/inbox.jpg" align="middle"> 
        &nbsp; <span style="display:none"><?php echo $this->title;?></span>
        </td>
        <td align="right"><?php echo "|&nbsp;&nbsp;".$this->otherLink.
        '&nbsp;&nbsp;|&nbsp;&nbsp;'; ?>
        </td>
        <Td width="20"><img src="/images/icons/inbox_compose.png"></Td>
        <td>
        <? echo $this->composeLink."&nbsp;&nbsp;|";?>
        </td>
    </tr>
</table>
<table width="100%" cellpadding="2" cellspacing="2" style="border:1px solid #DDD" class="inbox_table">
	<tr style="background-color:#0096D6">
    	<td class="sectiontableheader" colspan=2>Subject</td>
        <td class="sectiontableheader" width="100"><?php echo $this->fromHeader;?></td>
        <td class="sectiontableheader" width="100">Date</td>
        <td class="sectiontableheader" width="50">Action</td>
    </tr>
    <style>
        tr.sectiontableentry1 td, td.sectiontableentry1, tr.sectiontableentry0 td, td.sectiontableentry0  {
            background-image: none;
        }
        tr.sectiontableentry1 td, tr.sectiontableentry2 td, td.sectiontableentry1, td.sectiontableentry2 {
                padding:0;
        }
        
        table.inbox_table td{
            background-color:none;
        }
    </style>
    
    <form method="post" action="<?= JRoute::_("index.php?option=com_jforce&c=message&view=message"); ?>">
    <?php echo JHTML::_('form.token'); ?>    
	<?php
    for($i=0; $i<count($this->messages); $i++) :
        $message = $this->messages[$i];
        $k = $i%2;
		$class = $message->read ? '' : 'unread';
    ?>
    <tr class="sectiontableentry<?php echo $k;?>       
        <?php echo $class;?>" <?php if($class == "unread"):?> style="background-color:#fff;font-weight:bold;" <? else: ?> style="background-color:#fff;"<?php endif;  ?>>
        <td align="left" width="23" cellpadding=0 cellspacing=0 style="margin:0;padding:0;"><? if($class=="unread"): ?>
            <center><img src="/images/icons/inbox_unread.jpg"> <? else: ?> <img src="/images/icons/inbox_read.jpg"> <? endif; ?></center></td>
        <td><?php echo $message->link;?></td>
        <td><?php echo $message->name;?></td>
        <td><?php echo $message->created;?></td>
        <td align="center"><center><img src="/images/icons/delete.png">
            <br />
            <?php 
                //echo $message->delete;
            ?>
            <input type="checkbox" name="jforce_messaage_delete[]" value="<?=$message->id;?>"/>
            </center>
        </td>
    </tr>
	<?php endfor; ?>
    <? if(count($this->messages))    : ?>
        <tr>
            <td colspan=4></td><td><input type="submit" name="submit" value="Delete" ></td>
        </tr>
        <input type="hidden" name='ret' value='<?=JRequest::getURI()?>' />
        <input type="hidden" name='task' value='delete' />
    <? endif; ?>
    </form>
    <?php if (!count($this->messages)) : ?>
    	<tr class="sectiontableentry0">
        	<td colspan="5" align="center" style="font-weight:bold;"><br />You have no messages yet.<br /><br /></td>
    	</tr>
    <?php endif; ?>
</table>
<div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>

