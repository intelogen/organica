<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
mm_showMyFileName(__FILE__); ?>

<?php echo $buttons_header // The PDF, Email and Print buttons ?>
<?php echo $browsepage_header // The heading, the category description ?>
<?php echo $parameter_form // The Parameter search form ?>
<?php echo $orderby_form // The sort-by, order-by form PLUS top page navigation ?>

<div id="product_list" style="width:103%; float:none;">
<?php
$data =array(); // Holds the rows of products
$i = $row = $tmp_row = 0; // Counters
$num_products = count( $products );

$prod_i = 0;
foreach( $products as $product ) {
	$prod_i++;
		/*** Now echo the filled cell ***/
		if( $tmp_row != $row || $row == 0 ) {
			if ( ($num_products - $i) < $products_per_row ) {
				$cell_count =$num_products - $i;
			}
			else {
				$cell_count = $products_per_row;
			}
			$row++;
			$tmp_row = $row;
		}
		$colspan = $products_per_row - $cell_count + 1;
		if( $cell_count < 1 ) {
			$cell_count = 1;
		}
//настройка вида миниатюр товара
		//echo "<div style=\"margin-right: 5px; height: 640px; width:32%; float:left;\" id=\"".uniqid( "row_" ) ."\">";
		echo "<div style=\"box-shadow: 0 0 10px 5px rgba(221, 221, 221, 1);border: rgba(221, 221, 221, 1);
  border-top-left-radius: 14px;
  border-top-right-radius: 14px;
  border-bottom-right-radius: 14px;
  border-bottom-left-radius: 14px;
  margin-right: 5px; height: 640px; width:32%; float:left;\" id=\"".uniqid( "row_" ) ."\">";
		
		
                
		foreach( $product as $attr => $val ) {
			// Using this we make all the variables available in the template
			// translated example: $this->set( 'product_name', $product_name );
			$this->set( $attr, $val );
		}
		
		// Parse the product template (usually 'browse_x') for each product
		// and store it in our $data array 
		echo $this->fetch( 'browse/'.$templatefile .'.php' );
		
		$i++;
		if ( $prod_i%3 ==0 ) {
			
			$row++;
			/** if yes, close the current "row" ***/
			echo "\n</div><div class=\"clr\" /></div>";
		}
		else {
			echo "\n</div>";
			
		}
		
		
}
?>
</div>


<br class="clr" />
<?php 
echo $browsepage_footer;

// Show Featured Products
if( $this->get_cfg( 'showFeatured', 1 )) {
    /* featuredproducts(random, no_of_products,category_based) no_of_products 0 = all else numeric amount
    edit featuredproduct.tpl.php to edit layout */
    echo $ps_product->featuredProducts(true,10,true);
}
echo $recent_products;

?>
