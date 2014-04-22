<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			company.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<div class='contentheading'><?php echo $this->company->name; ?></div>
<div class='tabs'>
    <ul id="tabMenu">        
        <?php
            // JTPL HACK
            // replace all company words to coach
            foreach($this->tabMenu as &$t){
                $t["Text"] = str_ireplace("company","coach",$t["Text"]);
            }
        ?>
			<?php for($i=0;$i<count($this->tabMenu);$i++):
                    $tab = $this->tabMenu[$i]; 
                    if(!$tab['Link']): ?>
    	                <li id='tab-<?php echo $i; ?>'><?php echo $tab['Text']; ?></li>
					<?php else: ?>
        	            <li id='tab-<?php echo $i; ?>'><a href='<?php echo $tab['Link']; ?>' <?php echo $tab['Options']; ?>><?php echo $tab['Text']; ?></a></li>
            	<?php endif;
			endfor; ?>
     </ul>
</div>
<div class='tabContainer'>
	<div class='companyArea'>
            <div class="logo">
                <?php echo $this->company->image; ?>
            </div>
			<div class='companyDetails'>
            <?php $k = 1; ?>
				<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Name'); ?></div><?php echo $this->company->name; ?></div>	
				<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Address'); ?></div><?php echo $this->company->address; ?></div>
				<?php
					// JTPL HACK, pick the email from company owner and display as the company email
					$email = "";
					//echo "<pre>";
					//print_r($this->company);
					foreach($this->company->people as $person):
 							if($person->uid == $this->company->owner):
							$email = $person->email;
							break;
						endif;
					endforeach;
					?>
					<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Email'); ?></div><a href="mailto:<?=$email; ?>"><?=$email;?></a></div>
					<?php
				?>
				<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Phone'); ?></div><?php echo $this->company->phone; ?></div>	
				<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Fax'); ?></div><?php echo $this->company->fax; ?></div>	
				<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Homepage'); ?></div><?php echo $this->company->homepage; ?></div>	
			</div>
    </div>
        <?php if ($this->company->customFields): ?>
		<div class='customFields'>
				<div class='title'><?php echo JText::_('Custom Fields'); ?></div>
				<?php for ($i=0; $i<count($this->company->customFields); $i++) : 
					$cf = $this->company->customFields[$i];?>
					<div class='editField'>
						<label for='<?php echo $cf['label']; ?>' class='key'><?php echo $cf['label']; ?></label>
						<?php echo $cf['field'];?>
					</div>
				<?php endfor; ?>
		</div>		
        <?php endif; ?>
        <div class='personArea'>
        	<div class='title'><?php echo JText::_('Clients'); ?></div>
			<?php 
            $counter = 0;
			for($i=0;$i<count($this->company->people);$i++):
				$person = $this->company->people[$i];
				$k = 1 - $counter%2;
                
                // HACK by JTPL
                // default behaviour of jforce changed
                // company owner is assumed as coach and hence not displayed
                if($person->uid == $this->company->owner):
                    continue;
                else:
                    // increase the counter
                    $counter++;
                endif;
			?>
			<div class='row<?php echo $k; ?>'>
				<div class='logo'>
					<?php echo $person->image;
					if($person->uid==$this->company->owner):
					echo '<div class="companyOwner">'.JText::_('Owner').'</div>';
					endif;
					?>			
				</div>
				<div class='personContainer'>
					<?php if($person->lastvisit): ?>
						<div class='lastVisit'>
							<?php echo JText::_('Last Visit'); ?> <span class='hasTip' title='<?php echo $person->lastvisit;?>'><?php echo $person->date; ?></span>
						</div>	
					<?php endif; ?>	                
					<div class="listTitle">
						<a href='<?php echo JRoute::_('index.php?option=com_jforce&c=people&view=person&layout=person&id='.$person->id); ?>'>
							<?php echo $person->name; ?>
						</a>
					</div>		
					<div class='personDetail'>
						<div class='key'><?php echo JText::_('Email'); ?></div><a href='mailto:<?php echo $person->email; ?>'><?php echo $person->email;?></a>
					</div>												
				</div>
			</div>
		<?php endfor; ?>
		</div>
</div>