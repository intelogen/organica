<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			person.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	

?>

<h1>Client Tracking</h1>
<div class='tabContainer2'>
	<div class='companyArea'>
		<div class='logo'>
			<?php echo $this->person->image; ?>
		</div>
		<div class='companyDetails'>
			<div class="row1"><div class="itemTitle"><?php echo JText::_('Name'); ?></div><?php echo $this->person->name; ?></div>	
			<div class="row0"><div class="itemTitle"><?php echo JText::_('Username'); ?></div><?php echo $this->person->username; ?></div>
		</div>
	</div>	
</div>

<br />
<div class="tabs">
    <ul id="tabMenu">
        <?php 
            $id = JRequest::getCmd("id");
        ?>
        <li id='tab-1'><a href="<?=JRoute::_("index.php?option=com_jforce&c=people&view=person&layout=client&id=$id&action=message")?>">Client Messages</a></li>
        <li id='tab-0'><a href="<?=JRoute::_("index.php?option=com_jforce&c=people&view=person&layout=client&id=$id&action=progress")?>">Client Progress</a></li>
    </ul>
</div>



<div class="tabContainer">
    <?php
        // do according to the action parameter

    
    
        if($this->action == "progress"):            
        $k = 0;
            foreach($this->progress_tracking as $p):
                    $k ++;  $k = $k%2;
                ?>
                    <div class="row<?=$k?>">
                        <div>
                        <img src="uploads_jtpl/icons/project_status/<?=strtolower(str_replace(" ","_",$p->status))?>.png" alt="<?=$p->status; ?>" title="<?=$p->status; ?>" align=top> &nbsp; 
                        <a href="<?=JRoute::_("index.php?option=com_jforce&view=checklist&pid=".$p->id."&client_id=".$this->client_id)?>" title="View Phase status"><?=$p->name;?></a>
                        </div>
                        <div>               
                            [<a href="<?=JRoute::_("index.php?option=com_jforce&view=project&layout=form&pid=".$p->id."&client_id=".$this->client_id)?>" title="Edit Phase Status">
                                <img src="/uploads_jtpl/icons/edit.png" align="top">
                                Edit Phase Status
                            </a>]&nbsp;
                             [<a href="<?=JRoute::_("index.php?option=com_jforce&view=phase&layout=client_phase_progress&pid=".$p->id."&client_id=".$this->client_id)?>" title="View Phase Progress">
                                <img src="/uploads_jtpl/icons/view.png" align="top">                                
                                View Phase Progress
                            </a>]&nbsp;
                            [<a href="<?=JRoute::_("index.php?option=com_jforce&view=phase&layout=recommend_products&pid=".$p->id."&client_id=".$this->client_id)?>" title="Recommend Products">
                                <img src="/uploads_jtpl/icons/product.png" align="top">                                
                                Recommend Products
                            </a>]
                        </div>                        
                    </div>
                    <br />
                <?php
            endforeach;
        endif;
        
        if($this->action == "message"):
            ?>
                <div>
                    Displaying last <?= count($this->messages)?> messages communicated with the client                    
                </div>                
            <?php
            $k = 0;            
            foreach($this->messages as $m):
                $k ++;  $k = $k%2;
                ?>
                <div class="row<?=$k?>">
                    <img src="uploads_jtpl/icons/message_directions/<?=$m->direction;?>.png" alt="<?=$m->direction; ?>">
                    <a href="<?=JRoute::_("index.php?option=com_jforce&view=message&layout=message&id=".$m->id);?>">
                    
                    <?php                      
                        if($m->subject){
                            echo $m->subject;
                        }else
                            echo "(No Subject)";
                    ?>
                    </a>
                </div>
                <?php
            endforeach;
        endif;
        
        
    ?>  
</div>
