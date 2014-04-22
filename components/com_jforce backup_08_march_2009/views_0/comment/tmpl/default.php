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
<?php if ($this->comments) : ?>
	<div id="comments">
		<?php for ($i=0; $i<count($this->comments); $i++) :
			$comment = $this->comments[$i];
			$k = 1 - $i%2;
		?>
		<div class='row<?php echo $k; ?>' id="comment<?php echo $comment->id;?>">
			<div class='commentTitle'>
				<div class='commentButtons'><a href="#comment<?php echo $comment->id;?>"></a> <a href='<?php echo $comment->permalink;?>'><?php echo $comment->permalinkImage; ?></a></div>
				<div class='commentImage'><?php echo $comment->image; ?></div>
				<div class='commentAuthor'><a href='<?php echo $comment->authorUrl; ?>' ><?php echo $comment->author;?></a> <?php echo JText::_('said'); ?></div>
				<div class='commentTime'><span class='hasTip' title="<?php echo $comment->created."::"; ?>"><?php echo $comment->createdDate; ?></span></div>
			</div>
			<div class='commentArea'>
           		<?php echo $comment->message; ?>
            </div>
            <?php if ($comment->attachments) : ?>
            	<div class="commentAttachments">
                	<?php echo JText::_('Attachments'); ?>
                	<ul class="commentAttachmentList">
            	<?php for ($k=0; $k<count($comment->attachments); $k++) : 
					$a = $comment->attachments[$k];
				?>
                	<li><a href="<?php echo $a->file->downloadUrl;?>"><?php echo $a->name;?></a></li>
                <?php endfor; ?>
                	</ul>
                </div>
            <?php endif; ?>
	</div>
        <?php endfor; ?>
	</div>
<?php endif; ?>
    <div class='pagination'>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
<form action="index.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm();">
<div class='contentheading'><?php echo $this->title; ?></div>
		<div class='quickLinks'>
            <input type="submit" name="save" value="<?php echo JText::_('Save');?>" class="button" />
		</div>	
	<div class='commentReplyForm'>
	
	<div class='mainColumn'>
		<div class='editField'>
			<label for='<?php echo JText::_('Your Reply'); ?>' class='key'><?php echo JText::_('Your Reply'); ?></label>
			<textarea  name="message" cols="50" rows="5" class="required"></textarea>
		</div>
	</div>
	<div class='secondaryColumn'>
		<div class='editField' id="attachments">
		<label for='<?php echo JText::_('Attachment'); ?>' class='key'><?php echo JText::_('Attachment'); ?><a href="#" id="addAttachment">Add</a></label>
		<input type="file" name="file[]" class="inputbox" />
		</div>
	</div>		
	<input type="hidden" name="pid" value="<?php echo $this->pid;?>" />
	<input type="hidden" name="<?php echo $this->type;?>" value="<?php echo $this->id;?>" />
	<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
	<input type="hidden" name="option" value="com_jforce" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="model" value="comment" />
	<?php echo JHTML::_('form.token'); ?>
	</form>
	</div>