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
<div class='contentheading'><?php echo JText::_('People'); ?></div>
<div class='quickLinks'>
	<?php echo $this->newLink;?>
</div>
<div class='tabContainer2'>
			<?php
			$k=0;
	 		for($i=0; $i<count($this->persons); $i++) :
				$person = $this->persons[$i];
				$k = 1-$k;
				$lastCompany = null;
				
				if ($i>0) :
					$lastCompany = $this->persons[$i-1]->company;
				endif;
			?>
            <?php if ($person->company != $lastCompany || !$lastCompany) : 	
				$k=0;
			?>
            	<h2><?php echo $person->company;?></h2>
            <?php endif; ?>
			<div class='row<?php echo $k; ?>'>
				<div class='logo'>
					<?php echo $person->image; ?>
				</div>
				<div class='personContainer'>
                	<?php if ($this->showLinks) : ?>
         				<div class='itemButtons'>
                        	<form action="index.php" method="post">
                        	<button onclick="this.form.submit();" class="inlineTab" /><span><?php echo JText::_('Remove');?></span></button>
                            <input type="hidden" name="option" value="com_jforce" />
                            <input type="hidden" name="task" value="deletePermissions" />
                            <input type="hidden" name="c" value="people" />
                            <input type="hidden" name="id" value="<?php echo $person->uid;?>" />
                            <input type="hidden" name="pid" value="<?php echo $this->pid;?>" />
                            <?php echo JHTML::_('form.token'); ?>
                            </form>
                        	<a href='<?php echo JRoute::_('index.php?option=com_jforce&c=people&view=modal&tmpl=component&layout=editpermissions&pid='.$this->pid.'&id='.$person->id);?>' class="modal" rel="{handler: 'iframe', size: {x: 700, y: 450}}"><img src='<?php echo JURI::root();?>components/com_jforce/images/edit_icon.png' /></a>
            			</div>
        			<?php endif; ?>
					<div class="listTitle">
						<a href='<?php echo JRoute::_('index.php?option=com_jforce&c=people&view=person&layout=person&id='.$person->id); ?>'>
							<?php echo $person->name; ?>
						</a>
					</div>
					<div class='personDetail'>
						<div class='key'><?php echo JText::_('Company'); ?></div>
                        	<?php if($person->company): ?>
    	                        <a href='<?php echo $person->companyLink; ?>'><?php echo $person->company;?></a>
                            <?php else: ?>
	                            <?php echo $person->lead_company; ?>
                            <? endif; ?>
					</div>			
					<div class='personDetail'>
						<div class='key'><?php echo JText::_('Email'); ?></div><a href='mailto:<?php echo $person->email; ?>'><?php echo $person->email;?></a>
					</div>	
					<div class='personDetail'>
						<div class='key'><?php echo JText::_('Last Visit'); ?></div><?php echo $person->lastvisit;?></a>
					</div>								
				</div>
			</div>
   
		<?php endfor; ?>
       <div class='pagination'><?php echo $this->pagination->getPagesLinks(); ?><?php echo $this->pagination->getPagesCounter(); ?></div>
		<?php echo $this->startupText; ?>
</div>