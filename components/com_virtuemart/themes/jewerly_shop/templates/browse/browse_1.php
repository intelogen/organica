<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
mm_showMyFileName(__FILE__);
 ?>

 <div class="browseProductContainer">
        <div id="product_id">
                                                <h3 class="browseProductTitle">
                                                    <a title="<?php echo $product_name ?>" href="<?php echo $product_flypage ?>">
                                                    <?php echo $product_name ?></a>
                                                </h3>
                                                <br />
                                                <div class="browseProductImageContainer">
                                                    
                                                    <a href="<?php echo $product_flypage ?>" title="<?php echo $product_details ?>">
                                                    <?php echo ps_product::image_tag( $product_thumb_image, 'class="browseProductImage" border="0" title="'.$product_name.'" alt="'.$product_name .'"' ) ?>
                                                    </a>
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    <?php// скрипт открываетполную картинку - раскоментить все чтоб работало?>
                                                    <?php //echo ps_product::image_tag( $product_thumb_image, 'class="browseProductImage" border="0" title="'.$product_name.'" alt="'.$product_name .'"' ) ?>
                                                    
                                                    <script type="text/javascript">//<![CDATA[
                                                        /*
                                                        document.write('<a href="javascript:void window.open(\'<?php echo $product_full_image ?>\', \'win2\', \'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=<?php echo $full_image_width ?>,height=<?php echo $full_image_height ?>,directories=no,location=no\');">');
                                                        document.write( '<?php echo ps_product::image_tag( $product_thumb_image, 'class="browseProductImage" border="0" title="'.$product_name.'" alt="'.$product_name .'"' ) ?></a>' );
                                                    //]]>*/
                                                    </script>
                                                    <noscript>
                                                    
                                                        <a href="<?php //echo $product_full_image ?>" target="_blank" title="<?php echo $product_name ?>">
                                                        <?php //echo ps_product::image_tag( $product_thumb_image, 'class="browseProductImage" border="0" title="'.$product_name.'" alt="'.$product_name .'"' ) ?>
                                                        </a>
                                                    
                                                    </noscript>
                                                    <?php// раскоментить все до сюда?>
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                <div class="inner">
                                                    <div class="browseProductDescription">
                                                      
                                                        <?php echo $product_s_desc ?>&nbsp;
                                                      
                                                    </div>
                                                <div class="line">
                                                   
                                                    <div class="browsePriceContainer">
                                                        <?php echo $product_price ?>
                                                    </div>
                                                  
                                                    <div class="details">
                                                        <a href="<?php echo $product_flypage ?>" title="<?php echo $product_details ?>">
                                                            Product Details
                                                        </a>
                                                    </div>
                                                    
                                                    <div class="clear"></div>
                                                </div>
                                                
                                                    <div class="browseRatingContainer">
                                                    <?php echo $product_rating ?>
                                                    </div>
                                                    <?php echo "<br>" ?>
                                                    <span class="browseAddToCartContainer">
                                                    <?php echo $form_addtocart ?>
                                                    <div class="clear"></div>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="clear"></div>

        </div>
</div>
  
