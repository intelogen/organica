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

<h1>Recommend Products</h1>
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
<h4>Current Recommendations for this phase</h4>
<div class="tabContainer2">        
    <?php
        if(count($this->recommended_products)):
            $k = 0;
            echo "
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
                        <th></th>
                    </tr>";
            foreach ($this->recommended_products as $product):
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
                        <Td>
                            <a href="<?=JRoute::_("index.php?option=com_jforce&view=phase&layout=recommend_products&task=delete_recommendation&pid=".JRequest::getCmd("pid")."&client_id=".JRequest::getCmd("client_id")."&recommendation_id=".$product->recommendation_id
                                                    );?>" title="Delete Recommendation">
                                <img src="/uploads_jtpl/icons/general/delete.png">
                            </a>
                        </Td>
                    </tr>
                <?php
            endforeach;            
            echo "</table>";
        else:
            echo "No products have been recommended yet."; 
        endif;
    ?> 
</div>
<H4>Recommend a product for this phase</H4>
<div class="tabContainer2">
    <?php   if(count($this->products_list)):  ?>
        <form name="recommendations_form" action="<?=$this->action;?>" method="post">
            <?php echo JHTML::_( 'form.token' ); ?>
            <table>
                <tr>
                    <th>Product Name</th>
                    <td>
                        <select name="product">                        
                            <option value="">--- Select one ---</option>
                            <?php foreach($this->products_list as $p):?>
                                <option value="<?=$p->product_id;?>"><?=$p->product_name;?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Quantity</th>
                    <td>
                        <input type="text" name="quantity" style="width:65px">
                    </td>
                </tr>
                    <th>Notes on <br />recommendation</th>
                    <td>
                        <textarea name="notes"></textarea>
                    </td>        
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td><input type="submit" value="Recommend Product"></td>
            </table>
        </form>
    <?php else: ?>
        There aren't any products available for recommendation
    <?php endif; ?>
</div>
