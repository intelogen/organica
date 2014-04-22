<?php
// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
    	<td class="contentheading">
         <img src="/images/icons/inbox_message.jpg">
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
        table.inbox_table th{
            background-color:#F1F1F1;
            color:#800;
            font-size:1.1em;
            border-right:1px solid #ddd;
            text-align:left;
            padding-left:10px;
            margin-right:10px;
            border-top:1px solid #ddd;
        }
        table.inbox_table td{
            padding:10px;            
        }
    </style>
<table width="100%" cellpadding="0" cellspacing="0"  style="border:1px solid #DDD;padding:10px;" class="inbox_table">
    <!--
	<tr>
    	<td class="sectiontableheader" colspan="2" style="font-size:1.3em;" style='border-top:1px solid #EEE;'>
           <img src="/images/icons/inbox_message.jpg"> 
        </td>
    </tr>
    -->
	<tr class="sectiontableentry1">
    	<th width="65" class="label"><?php echo $this->fromHeader;?></th>
        <td><?php echo $this->message->name;?></td>
    </tr>
    <tr class="sectiontableentry0">
    	<th class="label">Subject</th>
        <td><?php echo $this->message->subject;?>
    </tr>
    <tr class="sectiontableentry1">
    	<th class="label">Date</th>
        <td><?php echo $this->message->created;?>
    </tr>
    <tr class="sectiontableentry0">
    	<th class="label" valign="top">Body</th>
        <td><?php echo $this->message->body;?>
    </tr>
</table>
