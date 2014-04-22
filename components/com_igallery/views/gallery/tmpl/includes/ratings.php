<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<div id="<?php echo $ratingsVars->prefix; ?>_ratings_wrapper<?php echo $this->id; ?>" class="<?php echo $ratingsVars->prefix; ?>_ratings_wrapper"><!-- start <?php echo $ratingsVars->prefix; ?> ratings wrapper div -->
			
		Rating: (<?php echo JText::_( 'VOTES' ); ?>: <span id="<?php echo $ratingsVars->prefix; ?>_num_ratings<?php echo $this->id; ?>" class="<?php echo $ratingsVars->prefix; ?>_num_ratings"></span>)
		<form name="<?php echo $ratingsVars->prefix; ?>_rating_form<?php echo $this->id; ?>" id="<?php echo $ratingsVars->prefix; ?>_rating_form<?php echo $this->id; ?>" class="<?php echo $ratingsVars->prefix; ?>_rating_form" method="post" action="<?php echo $this->host; ?>index.php?option=com_igallery&amp;task=rating&amp;format=raw" > 
			<img id="<?php echo $ratingsVars->prefix; ?>_rating_star1" class="<?php echo $ratingsVars->prefix; ?>_rating_star" src="<?php echo $this->host; ?>components/com_igallery/images/star-white.gif" alt="" />
			<img id="<?php echo $ratingsVars->prefix; ?>_rating_star2" class="<?php echo $ratingsVars->prefix; ?>_rating_star" src="<?php echo $this->host; ?>components/com_igallery/images/star-white.gif" alt="" />
			<img id="<?php echo $ratingsVars->prefix; ?>_rating_star3" class="<?php echo $ratingsVars->prefix; ?>_rating_star" src="<?php echo $this->host; ?>components/com_igallery/images/star-white.gif" alt="" />
			<img id="<?php echo $ratingsVars->prefix; ?>_rating_star4" class="<?php echo $ratingsVars->prefix; ?>_rating_star" src="<?php echo $this->host; ?>components/com_igallery/images/star-white.gif" alt="" />
			<img id="<?php echo $ratingsVars->prefix; ?>_rating_star5" class="<?php echo $ratingsVars->prefix; ?>_rating_star" src="<?php echo $this->host; ?>components/com_igallery/images/star-white.gif" alt="" />
			<input type="hidden" name="img_id" id="<?php echo $ratingsVars->prefix; ?>_ratings_img_id<?php echo $this->id; ?>" value="1" />
			<input type="hidden" name="rating" id="<?php echo $ratingsVars->prefix; ?>_img_rating<?php echo $this->id; ?>" value="1" />
			<input type="hidden" name="gallery_id" id="<?php echo $ratingsVars->prefix; ?>_gallery_id<?php echo $this->id; ?>" value="<?php echo $this->id; ?>" />
		</form>
	 	
		<div id="<?php echo $ratingsVars->prefix; ?>_ratings_message_container<?php echo $this->id; ?>" class="<?php echo $ratingsVars->prefix; ?>_ratings_message_container">
			<span id="<?php echo $ratingsVars->prefix; ?>_ratings_login<?php echo $this->id; ?>" class="<?php echo $ratingsVars->prefix; ?>_ratings_login" style="display: none;"><?php echo JText::_( 'PLEASE LOGIN OR' ); ?> <a href="<?php echo $this->registerLink; ?>"><?php echo JText::_( 'REGISTER' ); ?></a> <?php echo JText::_( 'TO RATE THIS PHOTO' ); ?> </span>
			<span id="<?php echo $ratingsVars->prefix; ?>_ratings_rate<?php echo $this->id; ?>" class="<?php echo $ratingsVars->prefix; ?>_ratings_rate" style="display: none;"> <?php echo JText::_( 'RATE THIS PHOTO' ); ?> </span>
			<span id="<?php echo $ratingsVars->prefix; ?>_ratings_already<?php echo $this->id; ?>" class="<?php echo $ratingsVars->prefix; ?>_ratings_already" style="display: none;"> <?php echo JText::_( 'YOU HAVE ALREADY VOTED' ); ?></span>
			<span id="<?php echo $ratingsVars->prefix; ?>_ratings_gif<?php echo $this->id; ?>" class="<?php echo $ratingsVars->prefix; ?>_ratings_gif" style="display: none;"><img src="<?php echo $this->host; ?>components/com_igallery/images/loader.gif" alt="" /></span>
			<span id="<?php echo $ratingsVars->prefix; ?>_ratings_success<?php echo $this->id; ?>" class="<?php echo $ratingsVars->prefix; ?>_ratings_success" style="display: none;"><?php echo JText::_( 'RATING SUCCESSFULLY' ); ?></span>
			<span id="<?php echo $ratingsVars->prefix; ?>_ratings_login_again<?php echo $this->id; ?>" class="<?php echo $ratingsVars->prefix; ?>_ratings_success" style="display: none;"><?php echo JText::_( 'PLEASE LOGIN AGAIN' ); ?></span>
		</div>
					
	</div><!-- end <?php echo $ratingsVars->prefix; ?> ratings wrapper div -->
	