<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			form.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class='contentheading'><?php echo $this->title; ?></div>
<div class='quickLinks'>
		<button type='button' onclick="saveServicesForm('save')" class='button'>
				<?php echo JText::_('Save') ?>
			</button>
			<button type='button' onclick="saveServicesForm('cancel')" class='button'>
				<?php echo JText::_('Cancel') ?>
			</button>
</div>
<div class='tabContainer2'>
<form action='<?php echo $this->action ?>' method='post' name='adminForm'>
	<div class='basicsContainer'>
	<div class="mainColumn">
			<div class='editField'>
			<label for='name' class='key'><?php echo JText::_('Name'); ?></label>			
					<input type='text' name='name' size='50' class='inputbox' value='<?php echo $this->invoice->name;?>' />
			</div>
			<div class='editField'>			
			<label for='description' class='key'><?php echo JText::_('Description'); ?></label>
					<textarea name='description' cols='35' rows='10' class='inputbox'><?php echo $this->invoice->description;?></textarea>
			</div>
	</div>
	<div class='secondaryColumn sideBox'>
    	<?php if ($this->invoice->pid) : ?>
			<div class='editField'>
			<label for='milestone' class='key'><?php echo JText::_('Milestone'); ?></label>
					<?php echo $this->lists['milestones']; ?>
			</div>
			<div class='editField'>
			<label for='checklist' class='key'><?php echo JText::_('Checklist'); ?></label>
					<?php echo $this->lists['checklists']; ?>
			</div>
        <?php else : ?>
        	<div class='editField'>
			<label for='checklist' class='key'><?php echo JText::_('Company'); ?></label>
					<?php echo $this->lists['companies']; ?>
			</div>        
        <?php endif; ?>
			<div class='editField2'>
			<label for='validtill' class='key'><?php echo JText::_('Valid Till'); ?></label>
			<?php echo JHTML::_('calendar', $this->invoice->validtill, 'validtill', 'validtill', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'19', 'readonly'=>'readonly')); ?>
			</div>
			<div class='editField2'>
			<label for='publishdate' class='key'><?php echo JText::_('Start Publishing'); ?></label>
			<?php echo JHTML::_('calendar', $this->invoice->publishdate, 'publishdate', 'publishdate', '%Y-%m-%d', array('class'=>'inputbox', 'size'=>'10',  'maxlength'=>'19', 'readonly'=>'readonly')); ?>
			</div>						
			<div class='editField2'>
			<label for='visibility' class='key'><?php echo JText::_('Enabled'); ?></label>
					<?php echo $this->lists['visibility']; ?>
			</div>

			<div class='editField2'>
			<label for='paid' class='key'><?php echo JText::_('Paid'); ?></label>
					<?php echo $this->lists['paid']; ?>
			</div>
            <div class='editField'>
			<label for='payment_method' class='key'><?php echo JText::_('Payment Method'); ?></label>
					<?php echo $this->lists['payment_methods']; ?>
			</div>
            <div class='editField'>
				<label for='notify' class='key'><?php echo JText::_('Notify'); ?></label>			
					<input type="checkbox" name="notify" class="inputbox" value="1" />
			</div>  
            <div id="subscriptionHolder"> 
            	<div class="assignmentTitleHolder">
					<div class="assignmentTitle"><?php echo JText::_('Subscribers');?></div>
	           	 	<div class="manageLink"><a class="modal button" href="<?php echo $this->subscriptionLink;?>" rel="{handler: 'iframe', size: {x: 600, y: 300}}"><?php echo JText::_('Manage');?></a></div>
                </div>
				<?php echo $this->subscriptionFields;?>
            </div>
	</div>
  	</div>
		<div class='servicesArea' id='servicesArea'>
		<div class='quickLinks'><a href='javascript:void(0)' onclick='addService()' class='button'><?php echo JText::_('Add Service'); ?></a><a href='javascript:void(0)' onclick='updateTotals()' class='button'><?php echo JText::_('Update Totals'); ?></a></div>	
    	<div class='notesTitle'>
		<?php echo JText::_('Services'); ?></div><hr />
        	<div class='servicesHeader'>
            	<div class='serviceTotals'><?php echo JText::_('Cost'); ?></div>
                <div class='serviceQuantity'><?php echo JText::_('Quantity'); ?></div>
                <div class='removeItem'> </div>
                <div class='listTitle'><?php echo JText::_('Service'); ?></div>
            </div>
                  
            <?php for($i=0;$i<count($this->services);$i++): 
					$service = $this->services[$i]; 
					$k = $i%2; ?>
						<div class='row<?php echo $k; ?>' id='service_<?php echo $i;?>'>
                        	<div class='serviceTotals'>
                            	<div class='serviceField'>
									<div class='entry'><input type='text' name='services[price][]' class='inputbox smallBox' id='priceField_<?php echo $i;?>' value='<?php echo $service->price; ?>' /></div>
                                    <div class='key'><?php echo JText::_('Price'); ?></div>
                                </div>
                                <div class='serviceField'>
									<div class='entry'id='subtotal_<?php echo $i;?>'><?php echo $service->subtotal;?></div>
                                    <div class='key'><?php echo JText::_('Subtotal'); ?></div>
                                </div>
                            	<div class='serviceField'>
									<div class='entry'><input type='text' name='services[discount][]' class='inputbox smallBox' value='<?php echo $service->discount; ?>' />&nbsp;<?php echo $service->listServices['discount'];?></div>
                                    <div class='key'><?php echo JText::_('Discount'); ?></div>
                                </div>
                            	<div class='serviceField'>
									<div class='entry'><?php echo $service->listServices['tax']; ?></div>
                                    <div class='key'><?php echo JText::_('Tax'); ?></div>
                                </div>
                            	<div class='serviceField'>
									<div class='entryTotal' id="total_<?php echo $i;?>"><?php echo $service->total; ?></div>
                                    <div class='key'><?php echo JText::_('Total'); ?></div>
                                </div>
                            </div>
                            <div class='serviceQuantity'><input type='text' name='services[quantity][]' class='inputbox smallBox' value='<?php echo $service->quantity; ?>' /></div>
                            <div class='removeItem'>
                           	<a href='javascript:void(0);' id='removeLink_<?php echo $i;?>' ><img src='<?php echo 'components/com_jforce/images/remove.png' ?>' /></a>                        
                            </div>
							<div class='listTitle'><?php echo $service->listServices['item']; ?></div>
							<div class='serviceDescription'>
								<div id='description_<?php echo $i; ?>'><?php echo $service->description; ?></div>
                                 <!--<div class="descriptionEdit" id="descriptionEdit_<?php echo $i;?>">
                                 	<textarea class="inputbox" name="services[description][]" id='descriptionHidden_<?php echo $i; ?>' /><?php echo $service->description;?></textarea>
                                 </div>-->
                                <div>
                                	<a href='<?php echo JRoute::_('index.php?option=com_jforce&view=modal&layout=editdescription&tmpl=component&i='.$i); ?>' id="descriptionEditLink_<?php echo $i;?>" class='modal' rel="{handler: 'iframe', size: {x: 475, y: 350}}"><?php echo JText::_('Edit'); ?></a>
                                </div>
                            </div>
							<input type="hidden" name="services[id][]" value="<?php echo $service->id;?>" />
	                        <input type="hidden" name="services[total][]" value="<?php echo $service->subtotal;?>" id='totalHidden_<?php echo $i; ?>' />
                            <input type='hidden' name='services[subtotal][]' value='<?php echo $service->subtotal; ?>' id='subtotalHidden_<?php echo $i; ?>' />
                          	<input type='hidden' name='services[description][]' value='<?php echo $service->description; ?>' id='descriptionHidden_<?php echo $i; ?>' />
                        </div>
			<?php endfor; ?>
        
			</div>
        <div class='totalsArea'>
            <div class='sideBox'>
                <div class='field'>
                    <div class='key'><?php echo JText::_('Subtotal'); ?></div>
                    <span id='subtotal'><?php echo $this->invoice->subtotal; ?></span>
                </div>
                <div class='field'>
                    <div class='key'><?php echo JText::_('Discount'); ?></div>
                    <span id='discount'><?php echo $this->invoice->discount; ?></span>
                </div>
                <div class='field'>
                    <div class='key'><?php echo JText::_('Tax'); ?></div>
                    <span id='tax'><?php echo $this->invoice->tax; ?></span>
                </div>
                <div class='fieldTotal'>
                    <div class='key'><?php echo JText::_('Total'); ?></div>
                    <span id='total'><?php echo $this->invoice->total; ?></span>
                </div>
            </div>
        </div>
<input type='hidden' name='total' id='totalHidden' value='<?php echo $this->invoice->total; ?>' />
<input type='hidden' name='subtotal' id='subtotalHidden' value='<?php echo $this->invoice->subtotal; ?>' />
<input type='hidden' name='tax' id='taxHidden' value='<?php echo $this->invoice->tax; ?>' />
<input type='hidden' name='discount' id='discountHidden' value='<?php echo $this->invoice->discount; ?>' />
<input type='hidden' name='deleted[]' id='deleted' value='0' />
<input type='hidden' name='option' value='com_jforce' />
<input type='hidden' name='model' value='invoice' />
<input type='hidden' name='pid' value='<?php echo $this->invoice->pid; ?>' />
<input type='hidden' name='ret' value='<?php echo @$_SERVER['HTTP_REFERER']; ?>' />
<input type='hidden' name='id' value='<?php echo $this->invoice->id; ?>' />
<input type='hidden' name='c' value='accounting' />
<input type='hidden' name='task' value='' />
<?php echo JHTML::_('form.token'); ?>
</form>
<?php echo JHTML::_('behavior.keepalive'); ?>	
</div>