<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			results.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>

<div class='contentheading'><?php echo JText::_('Upload Progress Photo'); ?></div>
<div class='tabContainer2'>
	<div class="phase_photos_container">
		<table>
			<tr>
				<th>Phase Start</th>
				<th>Phase End</th>
			</tr>            
			<tr>
                <style>
                    img.bordered{
                       border:3px solid #0096D6;
                       width:200px;
                       height:250px;
                       display:block;
                    }
                </style>
				<td><img src="<?=$this->phase_details->startphoto; ?>" class="bordered"></td>
				<td><img src="<?=$this->phase_details->endphoto; ?>" class="bordered"></td>
			</tr>
		</table>
	</div>
	<form method="post" enctype="multipart/form-data" action="index.php?option=com_jforce&view=phase&layout=photoupload&pid=<?=$this->pid;?>&phase_id=<?=$this->phase_id;?>">
		<table>
			<tr>
				<td colspan="2"><input type="file" name="filename"></td>
			</tr>
            <tr>
                <td>
                    <select name="type">
                        <option value="0">-- Select One --</option>
                        <option value="start">Start of Phase</option>
                        <option value="end">End of Phase</option>
                    </select>
                </td>
                <td>
                    <input type="submit" value="Save">
                    <input type="hidden" name="task" value="photoupload">
                    <input type="hidden" name="phase_id" value="<?=$this->phase_id;?>">
                </td>
            </tr>
		</table>
	</form>
</div>
