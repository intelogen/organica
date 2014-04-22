<?php

/********************************************************************************
*	@package		Joomla														*
*	@subpackage		jForce, the Joomla! CRM										*
*	@version		2.0															*
*	@file			checklist.php												*
*	@updated		2008-12-15													*
*	@copyright		Copyright (C) 2008 - 2009 JoomPlanet. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								*
********************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>
<?php if($this->checklist->visibility==0): ?>
		<div class='alertArea'><?php echo JText::_('This item is marked as private'); ?></div>
	<?php endif; ?>
<div class='contentheading'><?php echo JText::_('Step'); ?>: <?php echo $this->checklist->summary; ?></div>
<div class='tabs'>
    <ul id="tabMenu">
			<?php 
                /**
                for($i=0;$i<count($this->tabMenu);$i++):                
                    $tab = $this->tabMenu[$i];
                    if(!$tab['Link']): ?>
    	                <li id='tab-<?php echo $i; ?>'><?php echo $tab['Text']; ?></li>
					<?php else: ?>
        	            <li id='tab-<?php echo $i; ?>'><a href='<?php echo $tab['Link']; ?>' <?php echo $tab['Options']; ?>><?php echo $tab['Text']; ?></a></li>
            	<?php endif;
			endfor; 
            **/
            ?>
 	</ul>
</div>
<div class="tabContainer">
<?php $k = 1; ?>

	<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Name'); ?></div><?php echo $this->checklist->summary; ?></div>	

    <?
    /**
	// JTPL HACK
    <div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Milestone'); ?></div><?php echo $this->checklist->milestone; ?></div>	
    **/
    ?>

	<div class='row<?php echo $k%2; $k = 1 - $k; ?>'><div class='itemTitle'><?php echo JText::_('Posted By'); ?></div><?php echo $this->checklist->author; ?> <?php echo JText::_('on'); ?> <?php echo $this->checklist->created; ?></div>
    
    <div class="row<?php echo $k%2; $k = 1 - $k; ?>">
        <div class="itemTitle">
            <?php echo JText::_('Completed'); ?>
        </div>
        <?php 
            if($this->checklist->completed == "Yes")
                echo "Yes";
            else{
                echo "Complete this step ";
                echo $this->checklist->tags; 
            }
            
            if($this->show_edit_link){            
                echo " [ ".$this->editChecklistLink. " ] ";
            }
            
            if($this->show_view_progress_link){
            	 echo " [ ".$this->viewProgressLink. " ] ";
            }
        ?>
    </div>
    
    <!-- 
	<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Completed'); ?></div><span id="checklistCompleted"><?php echo $this->checklist->completed; ?></span></div>
	<div class="row<?php echo $k%2; $k = 1 - $k; ?>"><div class="itemTitle"><?php echo JText::_('Tags'); ?></div><?php echo $this->checklist->tags; ?></div>	

    -->
    
    
    <div class="notesArea">
		<div class='notesTitle'><?php echo JText::_('Step Comments'); ?></div>        
		<?php 
            if($this->checklist->description){
                echo $this->checklist->description; 
            }else{
                echo "No comments have been made to this step";
            }
        ?>
	</div>
    
    <?php 
        // JTPL HACK
        // PRODUCT RECOMMENDATION
        // If the flag to display recommended products is set, then display products here
        
        if(count($this->product_recommendations)):
            ?>
            <h2>Product Recommendations</h2>
            <div>Below are the products recommended by your coach for this phase.</div>            
            
            <style>
                    table.allleft{
                        text-align:left;
                        border:1px solid #EFEFEF;
                    }
                    table.allleft th{
                        border:1px solid #DDD;
                        padding:4px;
                        background-color:#EEE;
                    }
                    table.allleft tr,
                    table.allleft td { padding:4px; }
                    
            </style>
            <table width='100%' class='allleft'>                
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Recommendation Notes</th>
                    <th>Recommendation Date</th>
                </tr>
                
            <?php
            foreach($this->product_recommendations as $product):
                $k++;
                $k=$k%2;
                ?>
                    <tr class="row<?=$k?>" >
                        <td>
                            <a href="<?=JRoute::_("index.php?option=com_virtuemart&page=shop.product_details&product_id=".$product->product_id);?>">
                            <?php echo $product->product_name; ?>
                            </a>
                        </td>
                        <td>
                            <?php echo $product->quantity; ?>                        
                        </td>
                        <td>
                            <?php echo $product->recommendation_notes; ?>                        
                        </td>
                        <td>
                            <?php echo $product->recommendation_date; ?>
                        </td>                            
                    </tr> 
                <?php
            endforeach;
            ?>
            </table>
            <?php
        endif;
    ?>
        
    <?php 
        // HACK ends
    ?>
    
	<?php
    /**
    
    // JTPL HACK 
    
    
    <div class='notesArea'>
		<div class='notesTitle'><?php echo JText::_('Tasks'); ?></div>
        <div id='newTaskArea'>
        		<form action='index.php' method='post' name='adminForm' id='ajaxAddTask'>
                <div class="secondaryColumn quickLinks">
                    <input type='submit' value='<?php echo JText::_('Save'); ?>' class='button'>
                    <button type='button'  id="cancelTask" class='button'>
                        <?php echo JText::_('Cancel'); ?>
                    </button>
                    <div id="checklistAssignment">
                                <div id="assignmentHolder">
                                    <div class="assignmentTitleHolder">
                                        <div class="assignmentTitle"><?php echo JText::_('Assignees'); ?></div>
                                        <div class="manageLink"><a class="modal button" href="<?php echo $this->assignmentLink;?>" rel="{handler: 'iframe', size: {x: 600, y: 300}}"><?php echo JText::_('Manage');?></a></div>
                                    </div>
                                    <?php echo $this->assignmentFields;?>
                               </div>
                           </div>
                </div>
                
                    <div class="mainColumn">
                            <div class='editField'>
                            <label for='summary' class='key required'><?php echo JText::_('Summary'); ?></label>			
                                    <input type='text' name='summary' size='60' class='inputbox required' value='' />
                            </div>
                            <div class='editField2'>			
                            <label for='priority' class='key'><?php echo JText::_('Priority'); ?></label>
                                    <?php echo $this->lists['priority'];?>
                            </div>
                            <div class='editField2'>
                            <label for='duedate' class='key required'><?php echo JText::_('Due Date'); ?></label>
                                    <?php echo JHTML::_('calendar', '', 'duedate', 'duedate', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'19', 'readonly'=>'readonly')); ?>
                            </div>
                            <div class='editField1'>
                            <label for='notify' class='key'><?php echo JText::_('Notify'); ?></label>
                                    <input type="checkbox" name="notify" class="inputbox" value="1" />
                                   
                            </div>
                            
                    </div>
                    
                <input type='hidden' name='id' value='' />
                <input type='hidden' name='pid' value='<?php echo $this->checklist->pid; ?>' />
                <input type='hidden' name='cid' value='<?php echo $this->checklist->id; ?>' />
                <input type='hidden' name='task' value='createTask' />
                <input type='hidden' name='option' value='com_jforce' />
                <input type='hidden' name='c' value='ajax' />
                <input type='hidden' name='format' value='raw' />
                <?php echo JHTML::_('form.token'); ?>
                </form>
            </div>
           
      </div>
      <div  id="currentTasks">     
			<?php for($i=0;$i<count($this->tasks['active']);$i++): 
					$task = $this->tasks['active'][$i]; 
					$k = $i%2; ?>
						<div class='row<?php echo $k; ?>' id="task_<?php echo $task->id; ?>">
							<div class='itemButtons'><?php echo $task->buttons; ?></div>
							<div class='listCheckbox'><input type='checkbox' name="task_<?php echo $task->id; ?>" class='taskbox' value="<?php echo $task->id;?>" /></div>
							<div class='listTitle'><?php echo $task->summary; ?></div>
							<?php if ($task->duedate) : ?>
	                            <div class="inline"><div class="hasTip" title="<?php echo $task->duedate; ?>::"><?php echo $task->date; ?></div></div>
                            <?php endif; ?>
                            <?php echo $task->duedate && $task->assignees ? '<div class="inline">|</div>' : ''; ?>
                            <?php if ($task->assignees) : ?>
                            	<div class="inline"><?php echo JText::_('Assignees').': '.$task->assignees; ?></div>
                            <?php endif; ?>
						</div>
			<?php endfor; ?>
            
            
	</div>
    
    <div id="completedTasks">
    	<div class='notesTitle'><?php echo JText::_('Completed Tasks'); ?></div>  
			<?php for($i=0;$i<count($this->tasks['completed']);$i++): 
					$task = $this->tasks['completed'][$i]; 
					$k = $i%2; ?>
						<div class='row<?php echo $k; ?>' id="task_<?php echo $task->id; ?>">
							<div class='itemButtons'><?php echo $task->buttons; ?></div>
							<div class='listCheckbox'><input type='checkbox' name="task_<?php echo $task->id; ?>" class='taskbox' value="<?php echo $task->id;?>" checked /></div>
							<div class='listTitle'><?php echo $task->summary; ?></div>
                            <div class="small"><?php echo $task->datecompleted . ' '.JText::_('by').' '. $task->completer; ?></div>
                            </div>
			<?php endfor; ?>
		
    </div>
    
    **/ 
    // JTPL HACK ENDS
    ?>
            
</div>	
