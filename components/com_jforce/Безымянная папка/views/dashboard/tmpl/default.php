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
<div class='contentheading'><?php echo JText::_('My Alerts'); ?></div>
<div class='tabContainer2' style="background-color:#E1FFE3">
    <?php if($this->alerts): ?>
    <?php
        $k = 0;        
        foreach($this->alerts as $alert=>$link){
            $k++;
            $k = $k%2; 
            echo "<div class='row$k'>";
            echo "<img src='uploads_jtpl/icons/alert.gif' align=middle /><a href='$link'>$alert</a>";
            echo '</div>';
        }
    ?>
    <?php else: ?>
        <img src='uploads_jtpl/icons/alert.gif' align=middle /> There are no alerts for you this time.
    <?php endif; ?>    
</div>
    
<?php if($this->dashboard): ?>
    <div class='contentheading'><?php echo JText::_('My Dashboard'); ?></div>
	<div class='tabContainer2'>
    	<?php if($this->dashboard):
        		foreach($this->dashboard as $object => $items): ?>
        <div class='objectContainer'>
        	<div class='objectTitle'><?php echo JText::_(ucwords($object).'s'); ?></div>
            <div class='objectItems' id='<?php echo $object; ?>'>
            		<?php if(count($items)):
							$i = 0;
							foreach($items as $item): 
                            	$k = $i%2; ?>
        		<div class='row<?php echo $k; ?>'>
						<div class='itemHolder'>
							<span class='listTitle'><a href="<?php echo $item['link']; ?>" /><?php echo $item['title']; ?></a></span> <?php echo JText::_('by'); ?> <?php echo $item['author']; ?> 
							<div class='itemDetails'><?php echo $item['text']; ?></div>
						</div>
                </div>
        			<?php 		$i++;
							endforeach; 
                    	endif; ?>
           </div>
       </div>
        <?php endforeach; 
			endif; ?>
        <?php echo $this->startupText; ?>
	</div>	
<?php endif; ?>
	
