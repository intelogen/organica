<?php // no direct access
/**
* @package RokFeature
* @copyright Copyright (C) 2009 RocketTheme. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*/
defined('_JEXEC') or die('Restricted access'); 

if (!defined('ROKFEATURE_JS')) {
	echo '<script type="text/javascript" src="'.JURI::base().'modules/mod_rokfeature/rokfeature.js"></script>' . "\n";
	define('ROKFEATURE_JS',1);
}
$counter=1;
$thumbclass = '';
?>

<script type="text/javascript">
    var RokFeatureImages = [];

    window.addEvent('domready', function() {
        new RokFeature('featured-block', {
	    'transition': Fx.Transitions.Quad.easeOut,
	    'duration': <?php echo $params->get('duration',600); ?>,
	    'opacity': <?php echo $params->get('opacity','0.9'); ?>,
	    'autoplay': <?php echo $params->get('autoplay')==1?"true":"false"; ?>,
	    'delay': <?php echo $params->get('delay',7000); ?>
        });
    });
</script>
<div id="rows-<?php echo count($list); ?>" class="rokfeature-mod<?php echo $params->get('moduleclass_sfx'); ?>">
    <div class="rokfeature-image">
        <div class="rokfeature-options">
            <?php foreach ($list as $item) :  ?>
            <div class="rokfeature-option-block">
                <div class="rokfeature-tab-<?php echo $counter; ?>"></div>
                <div class="rokfeature-block-<?php echo $counter; ?>">
                    <?php if ($params->get('showthumbs',1)==1) :?>
                        <?php if ($params->get('linkthumbs',1)==1) :?>
                            <a href="<?php echo $item->link; ?>"><img src="<?php echo $item->thumbimage ?>" alt="thumb" class="rokfeature-thumb" /></a>
                        <?php else: ?>
                            <img src="<?php echo $item->thumbimage ?>" alt="thumb" class="rokfeature-thumb" />
                        <?php endif; ?>
                        <?php $thumbclass="showthumb"?>
                    <?php endif; ?>
                    <span class="<?php echo $thumbclass; ?>"><?php echo $item->introtext; ?></span>
                    <div class="rokfeature-block-bg<?php echo $counter; ?>"></div>
                </div>
                <script type="text/javascript">
                    RokFeatureImages.push('<?php echo $item->mainimage ?>');
                </script>

            </div>
            <?php if ($params->get('showtitle',1)==1): ?>
            <div class="rokfeature-title">
                <?php if ($params->get('linktitle',1)==1) :?>
                <a href="<?php echo $item->link; ?>"><span><?php echo $item->title; ?></span></a>
                <?php else: ?>
                <span><?php echo $item->title; ?></span>   
                <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php if ($params->get('showreadmore',1)==1): ?>
            <div class="rokfeature-readon">
                <a href="<?php echo $item->link; ?>"><?php echo $params->get('readmore','Click Here to View Article'); ?></a>
            </div>
            <?php endif; ?>
            <?php $counter++;?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

