<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); 
mm_showMyFileName(__FILE__);?>

<h3><?php echo $browsepage_lbl; ?> 
	<?php 
	if( $this->get_cfg( 'showFeedIcon', 1 ) && (VM_FEED_ENABLED == 1) ) { ?>
	<a href="index.php?option=<?php echo VM_COMPONENT_NAME ?>&amp;page=shop.feed&amp;category_id=<?php echo $category_id ?>" title="<?php echo $VM_LANG->_('VM_FEED_SUBSCRIBE_TOCATEGORY_TITLE') ?>">
	<img src="<?php echo VM_THEMEURL ?>/images/feed-icon-14x14.png" align="middle" alt="feed" border="0"/></a>
	<?php 
	} ?>
</h3>

<?php /*
<div style="text-align:left;">*/?>


    <div style="box-shadow: 0 0 10px 5px rgba(221, 221, 221, 1);border: rgba(221, 221, 221, 1);
  border-top-left-radius: 14px;
  border-top-right-radius: 14px;
  border-bottom-right-radius: 14px;
  border-bottom-left-radius: 14px;
  margin-right: 5px; margin-bottom: 5px;
  padding-bottom: 5px;
  padding-left: 5px;
  ">
	<?php echo $navigation_childlist;?>
</div>
<?php if( trim(str_replace( "<br />", "" , $desc)) != "" ) { ?>

		<div style="width:100%;float:left;">
			<?php echo $desc; ?>
		</div>
		<br class="clr" /><br />
		<?php
     }
?>