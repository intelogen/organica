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
<div class='contentheading'>Companies</div>
<div class='quickLinks'>
	<a href='<?php echo JRoute::_('index.php?option=com_jforce&c=people&view=company&layout=form'); ?>' class='button'><?php echo JText::_('New Company'); ?></a>
</div>
		<div class='tabContainer2'>
			<?php
	 		for($i=0; $i<count($this->companies); $i++) :
				$company = $this->companies[$i];
				$k = $i%2;
			?>
			<div class='row<?php echo $k; ?>'>
            	<div class='logo company'>
                	<?php echo $company->image; ?>
                </div>
            	<div class='listTitle'>
                    <a href='<?php echo JRoute::_('index.php?option=com_jforce&c=people&view=company&layout=company&id='.$company->id); ?>'>
                        <?php echo $company->name;?>
                    </a>
            	</div>
                <?php if($company->address): ?>
				<div class='subheading'>
					<div class='key'><?php echo JText::_('Address'); ?></div> <?php echo $company->address;?>
                </div>
                <?php endif; 
				if($company->phone): ?>
                <div class='subheading'>
                	<div class='key'><?php echo JText::_('Phone'); ?></div> <?php echo $company->phone;?>
                </div>
                <?php endif;
				if($company->homepage): ?>
                <div class='subheading'>
                	<div class='key'><?php echo JText::_('Homepage'); ?></div> <?php echo $company->homepageURL;?>
                </div>
                <?php endif; ?>
			</div>
		<?php endfor; ?>
        <div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>
	</div>	
