<?php
/**
* Module Carousel Banner For Joomla 1.5
* Versi	: 1.0
* Created by	: Rony Sandra Yofa Zebua And Camp26.Com Team
* Email	: ronysyz@gmail.com
* Created on	: 18 March 2008
* This Module based from Carousel Banner For Joomla 1.0.x by Andy Sikumbang (BOS OF TEMPLATEPLAZZA.COM)
	and Developted become to Carousel Banner For Joomla 1.5 by Rony Sandra Yofa Zebua (Support Of TemplatePlazza.Com and Member Of Camp26.Com)
* URL		: www.camp26.com - www.templateplazza.com
* @version $Id: mod_allbanners.php v1.0
* @hack of mod_banners.php by pe7er / db8.nl
* @This module does NOT increase the counter for Impressions Made, only the Clicks.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

// clientids must be an integer
$clientids = $params->get( 'banner_cids', '' );
$limitlist = $params->get( 'banner_limit', '' );

$where 	= '';
$limit 	= '';
$banner = null;

if ( $clientids != '' ) {
	$where = "\n AND cid IN ( $clientids )";
}
if ( $limitlist != '' ) {
	$limit = "\n LIMIT $limitlist";
}

$query = "SELECT *"
. "\n FROM #__banner"
. "\n WHERE showBanner=1 "
. $where
. "\n ORDER BY RAND()"
. $limit
;
$database =& JFactory::getDBO();
$database->setQuery( $query );
$banners = $database->loadObjectList();


    

?>

<script type="text/javascript" src="modules/mod_carousel_banner/carousel_banner/jquery-1.1.2.pack.js"></script>
<script type="text/javascript" src="modules/mod_carousel_banner/carousel_banner/jquery.jcarousel.pack.js"></script>
<link rel="stylesheet" href="modules/mod_carousel_banner/carousel_banner/jquery.jcarousel.css" type="text/css" />
<link rel="stylesheet" href="modules/mod_carousel_banner/carousel_banner/skin.css" type="text/css" />
<script type="text/javascript">

function mycarousel_initCallback(carousel)
{
    // Disable autoscrolling if the user clicks the prev or next button.
    carousel.buttonNext.bind('click', function() {
        carousel.startAuto(0);
    });

    carousel.buttonPrev.bind('click', function() {
        carousel.startAuto(0);
    });

    // Pause autoscrolling if the user moves with the cursor over the clip.
    carousel.clip.hover(function() {
        carousel.stopAuto();
    }, function() {
        carousel.startAuto();
    });
};



jQuery.easing['BounceEaseOut'] = function(p, t, b, c, d) {
	if ((t/=d) < (1/2.75)) {
		return c*(7.5625*t*t) + b;
	} else if (t < (2/2.75)) {
		return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
	} else if (t < (2.5/2.75)) {
		return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
	} else {
		return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
	}
};

jQuery.noConflict();
jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        auto: 3,
        wrap: 'last',
		easing: 'BounceEaseOut',
        animation: 1000,
        initCallback: mycarousel_initCallback
    });
});

</script>

<!-- Banner Carousel - from TemplatePlazza.com and Camp26.Com -->


		<ul id="mycarousel" class="jcarousel-skin-tango">

	  <?php 
	  foreach ($banners AS $banner){
    $imageurl 	= $baseurl."images/banners/".$banner->imageurl;
    $link		= JRoute::_( 'index.php?option=com_banners&task=click&bid='. $banner->bid );
	
	  echo '<li><a href="'. $link .'" target="_blank"><img src="'. $imageurl .'" border="0" alt="Advertisement" /></a></li>'; }?>

  </ul>
			