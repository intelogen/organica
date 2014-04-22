<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

if($empty_cart) { ?>
    
    <div style="margin: 0 auto;">
    <?php echo $VM_LANG->_('PHPSHOP_EMPTY_CART') ?>
    </div>
<?php } 
else {
    // Loop through each row and build the table
}
if(!$vmMinicart) { ?>
<?php } ?>
<?php echo $total_products ?>
<?php if (!$empty_cart && !$vmMinicart) { ?>
    <?php echo $show_cart ?>

<?php } 
echo $saved_cart;
?>