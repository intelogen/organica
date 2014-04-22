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
            foreach ($this->recommended_products as $product):
            endforeach;
        else:
            echo "No products have been recommended yet."; 
        endif;
    ?> 
</div>
<H4>Recommend a product for this phase</H4>
<div class="tabContainer2">
    <?php   if(count($this->products_list)):  ?>
        <form name="recommendations_form" action="<?=$this->action;?>" method="post">
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Notes on Recommendation</th>
                </tr>
                <tr>
                    <td>
                        <select name="product">                        
                        </select>
                    </td>
                    <td>
                        <input type="text" name="quantity" >
                    </td>
                    <td>
                        <input type="text" name="notes">
                    </td>
                </tr>
            </table>
        </form>
    <?php else: ?>
        There aren't any products available for recommendation
    <?php endif; ?>
</div>
