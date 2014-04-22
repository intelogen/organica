<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<div id="<?php echo $commentsVars->prefix ?>_comments_wrapper<?php echo $this->id ?>" class="<?php echo $commentsVars->prefix ?>_comments_wrapper"><!-- start <?php echo $commentsVars->prefix ?> comments wrapper div -->	
	
	<div id="<?php echo $commentsVars->prefix ?>_comments_message<?php echo $this->id ?>" class="<?php echo $commentsVars->prefix ?>_comments_message"><!-- start <?php echo $commentsVars->prefix ?> comments message div -->
		<?php echo JText::_( 'COMMENTS' ) ?>: (<span id="<?php echo $commentsVars->prefix ?>_comments_amount<?php echo $this->id ?>" class="<?php echo $commentsVars->prefix ?>_comments_amount"></span>)
	</div><!-- end <?php echo $commentsVars->prefix ?> comments message div -->
	
	<div id="<?php echo $commentsVars->prefix ?>_comments_container<?php echo $this->id ?>" class="<?php echo $commentsVars->prefix ?>_comments_container"><!-- start <?php echo $commentsVars->prefix ?> comments container div -->
	<?php	
	for ($i=0; $i<count($this->commentsList); $i++)
	{
		$row = &$this->commentsList[$i];
	?> 
		<div class="comments_div_<?php echo $row->img_id; ?>" style="display: none;">
			<?php echo $row->text; ?> 
			<br /><span class="italics_text"><?php echo $row->author; ?> &ndash; <?php echo date("F j, Y, g:i a",$row->date); ?></span>
		</div>
	<?php
	}
	?>
	
	</div><!-- end <?php echo $commentsVars->prefix ?> comments container div -->
	<?php
	if($this->guest == 1) 
	{
	?> 
	<div id="<?php echo $commentsVars->prefix ?>_login_comments_message<?php echo $this->id ?>" class="<?php echo $commentsVars->prefix ?>_login_comments_message">
		<?php echo JText::_( 'PLEASE LOGIN OR' ) ?> <a href="<?php echo $this->registerLink ?>"><?php echo JText::_( 'REGISTER' ) ?></a> <?php echo JText::_( 'TO LEAVE A COMMENT' ) ?> 
	</div>
	<?php
	}
	else
	{
	?>
	<?php echo JText::_( 'ADD A COMMENT' ) ?>:
	<form name="<?php echo $commentsVars->prefix ?>_img_comment_form<?php echo $this->id ?>" id="<?php echo $commentsVars->prefix ?>_img_comment_form<?php echo $this->id ?>" action="<?php echo $this->host ?>index.php?option=com_igallery&amp;task=comment&amp;format=raw" method="post">
		
		<?php echo JText::_( 'USERNAME' ) ?>: <span class="italics_text"><?php echo $this->user->get('username') ?></span><br />
		<?php echo JText::_( 'COMMENT' ) ?>:<br /> 
		<textarea name="comment_textarea" id="<?php echo $commentsVars->prefix ?>_comment_textarea<?php echo $this->id ?>" class="<?php echo $commentsVars->prefix ?>_comment_textarea" rows="4" cols="<?php echo ( round($this->galleryWidth/10) ); ?>"></textarea><br />
		<input type="hidden" name="comment_img_id" id="<?php echo $commentsVars->prefix ?>_comment_img_id<?php echo $this->id ?>" value="1" />
		<input type="hidden" name="comment_gallery_id" value="<?php echo $this->id ?>" />
		<input type="submit" value="<?php echo JText::_( 'SUBMIT' ) ?>" /> <span id="<?php echo $commentsVars->prefix ?>_ajax_comment_gif<?php echo $this->id ?>"></span>
		
		<div id="<?php echo $commentsVars->prefix ?>_comments_message_container<?php echo $this->id ?>" class="<?php echo $commentsVars->prefix ?>_comments_message_container" style="display: none;">
			<span id="<?php echo $commentsVars->prefix ?>_comments_empty<?php echo $this->id ?>" class="<?php echo $commentsVars->prefix ?>_comments_empty" ><?php echo JText::_( 'THE COMMENT FIELD EMPTY' ) ?></span>
			<span id="<?php echo $commentsVars->prefix ?>_comments_login<?php echo $this->id ?>" class="<?php echo $commentsVars->prefix ?>_comments_login" ><?php echo JText::_( 'PLEASE LOGIN AGAIN' ) ?></span>
			<span id="<?php echo $commentsVars->prefix ?>_comments_added<?php echo $this->id ?>" class="<?php echo $commentsVars->prefix ?>_comments_added" ><?php echo JText::_( 'COMMENT SUCCESSFULLY ADDED' ) ?></span>
		</div>
	</form>
<?php
}
?>
</div><!-- end <?php echo $commentsVars->prefix ?> comments wrapper div -->	