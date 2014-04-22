<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

	<div id="<?php echo $desVars->prefix; ?>_des_container<?php echo $this->id; ?>" class="<?php echo $desVars->prefix; ?>_des_container" style="overflow: hidden; width: <?php echo $desVars->des_container_width; ?>px; height: <?php echo $desVars->photo_des_height; ?>px; <?php if($desVars->show == 0){?> display: none;<?php }?>"><!-- start <?php echo $desVars->prefix; ?> descriptions container div -->
	<?php	
	$row = &$this->photoList[0];
	?> 		<div class="des_div"><?php echo $row->description; ?></div><?php	
					for ($i=1; $i<count($this->photoList); $i++)
					{
						$row = &$this->photoList[$i];
					?> 
			<div style="display: none" class="des_div"><?php echo $row->description; ?></div><?php
					}
					?>
				
	</div><!-- end <?php echo $desVars->prefix; ?> descriptions container div -->
	
	