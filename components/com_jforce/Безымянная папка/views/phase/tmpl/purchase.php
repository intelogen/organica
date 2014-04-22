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

<div class='contentheading'><?php echo JText::_('Products recommended for this phase'); ?></div>
<div class='tabContainer2'>
    <p>
        <img src="/uploads_jtpl/images/products.jpg" style="float:right;">
    </p>
	<P>
        To complete each phase there are certain products you are going to need. To help you, we have created a phase kit designed specifically for each phase. If you haven't purchase the phase kit yet, click the Purchase Phase Kit link below. It will take you directly to our online store where you can complete your purchase. Once you have received the kit, come back to this page and click the Received button below. This will let your assigned coach know you have everything you need for this phase. If you have any questions about the products, do not hesitate to contact your coach.        
    </P>
</div>	
<br />
<div class="tabContainer2" style="background-color:#EFEFEF;font-size:1.3em;">
      <a href="<?=JRoute::_($this->shopping_cart_link);?>"><img src="/uploads_jtpl/icons/general/shopping_cart.jpg" align="middle">    Purchase <?=$this->phase_name;?> Kit</a>
</div>
<br />
<div class="tabContainer2">
    <form method="post" action="<?=$this->step_action_link;?>">
        <?php echo JHTML::_( 'form.token' ); ?>
        <input type="hidden" name="step_redirection_link" value="<?=$this->step_redirection_link; ?>" >
        <input type="hidden" name="phase_id" value="<?=$this->phase_id ?>" >
        <input type="submit" value="Mark Step as Completed">
    </form>
</div>