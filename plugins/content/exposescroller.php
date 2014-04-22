<?php
/****************************************************************************
Module: Expose Thumbnail Scroller Mambot for Joomla 1.0.X
Version  : 0.0.12(14/12/2008)
Original Author: Bruno Marchant
E-mail:  bruno@gotgtek.net
Web Site : www.gotgtek.net
Mambot Author   : James Guthrie
E-mail   : scroller@jamesguthrie.ch
Web Site : www.jamesguthrie.ch
Copyright: Copyright 2007-2008 by GTEK Technologies
License  : Expose thumbnail scroller is released under GNU/GPL licence
*****************************************************************************/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
 
$_MAMBOTS->registerFunction( 'onPrepareContent', 'botExposeScroller' );
 
/**
* Expose Scroller Mambot
* 
* A mambot for the expose scroller module
*/
function botExposeScroller( $published, &$row, $mask=0, $page=0  ) 
{
  global $mosConfig_absolute_path;
 
 
  if (!$published) {
	//$row->text = preg_replace( $regex, ' ', $row->text );
	return true;
  }
 
  require_once( $mosConfig_absolute_path . '/includes/domit/xml_saxy_lite_parser.php' );
 
  // define the regular expression for the bot
  $regex = "#{expose}([0-9][0-9]*)\,([0-9][0-9]*px)\,([0-9][0-9]*){/expose}#s";
 
  // perform the replacement
  $row->text = preg_replace_callback( $regex, 'botExposeScroller_replacer', $row->text );
 
  return true;
}
/**
* Replaces the matched tags an image
* @param array An array of matches (see preg_match_all)
* @return string
*/
function botExposeScroller_replacer( &$matches ) 
{
	$attribs = @SAXY_Lite_Parser::parseAttributes( $matches[1] );
	$id = @$attribs['id'];
// Predefined things
	$setModuleId		= 'expose_scroller1';
	$setPath			=  $matches[1];
	$setRecurceDirs 	= '1';
	$setFileType 		= '\.(jpg|gif|png)$'; // Set eregi() string type (search for specific file patterns)
	$setLinking 		= 'photo';
	$setHoverPause		= '1';
	$setWidth			= $matches[2];
	$setHeight			= '150px';
	$setPicsNum			= intval ('10');
	$setPickMethod		= trim  ('random');
	$setDirection		= trim ('left');
	$setSpeed			= $matches[3];
	$setSpace			= 3;
	$setUseCss			= '1';
	$setCssDef			= 'a img{border:0;}';

$ExposeXmlPath = "components/com_expose/expose/xml/";
$newJoom = function_exists('jimport');

$output = "";
global $mosConfig_live_site;
$exp_live_site = $mosConfig_live_site.'/';
$modPath = $exp_live_site . 'mambots/content/';
//****************************************************************************
//****************** READ EXPOSE XML FILES *********************************
//****************************************************************************
//if folder is just a number then analyze the Expose XML files
if (is_numeric($setPath)) {
	require_once( dirname(__FILE__).'/exposescroller/xml.php' ); // Lib for searching/loading Expose xml content files
	//open xml file, read the collection into array and return qty of records
	$cData = array(); $aData = array();

	$domobj = new exp_xml;
	$domobj->open_xmlfile(realpath('components/com_expose/expose/xml').'/albums.xml');
	$domobj->searchId = $setPath;
	$total = $domobj->read_xml($domobj->dom, $cData);
	$domobj->close_xmlfile();

	//if user wants random selection of pics, loop trough collection array and read all albums
	if ($total == 0) {
		//If  cData is emty (albums.xml doesn't exist or has no albums), it will generate an error in foreach()  so first check!
		$output .= escr_lbl('NO_ALBUMS_FOUND');
	} else {
		//load all album files into array
		foreach ($cData as $ckey) {
			if (isset($ckey['contentxmlurl'])) {
				$domobj->open_xmlfile(realpath($ExposeXmlPath.$ckey['contentxmlurl']));
				$domobj->albumId = $ckey['mngid'];
				$total = $domobj->read_xml($domobj->dom, $aData);
				$domobj->close_xmlfile();
			}
		}

	}
	$ExposeImgPath = $exp_live_site . "components/com_expose/expose/img/";

// Overview created arrays for troubleshooting
//echo "\n<br><!-- Collection: \n<br>"; print_r($cData); echo "\n<br>Album: \n<br>"; print_r($aData); echo " -->";

//****************************************************************************
//****************** READ FILES FROM DIRECTORY (NON-EXPOSE) ******************
//****************************************************************************
// not numeric: search in requested folder
} else {
	require_once( dirname(__FILE__).'/exposescroller/folder.php' ); // Lib for searcheng/loading files from path
	//cleanup the provided path:
	$setPath = cleanupPath($setPath);
	//get the files now! (returns qty of files found)
	$total = recursive_dir(($newJoom ? JPATH_SITE.DS : $mosConfig_absolute_path.'/').$setPath, $setFileType, "", $aData, $setRecurceDirs);

	// Overview created arrays for troubleshooting
	//echo "\n<br><!-- Directory: \n<br>"; print_r($aData); echo " -->";

	//adjust some settings because we're not searching in the expose-directory now
	$ExposeImgPath = $exp_live_site. $setPath;
}

//****************** CHECK PIC-QTY ******************
//make sure PicsNum < pics found in directory
if ($setPicsNum > $total) $setPicsNum = $total;
//show all pics if PicsNum = 0
elseif ($setPicsNum == 0) $setPicsNum = $total;

//****************** GENERATE HTML CODE ******************
$output .= "\n<!-- ExposeScroller Module (3v0 beta3) starts here --> \n";
//use css?
//if($setUseCss) echo"\n<style type='text/css'><!-- $setCssDef --></style>";

// Should be in header of page: use global $mainframe; $mainframe->addcustomHeadTag('...') instead of echo ''
$output .= "<script language='javascript' type='text/javascript' src='".$modPath."exposescroller/continiousscroll.js'></script> \n"
	. "<script language='javascript' type='text/javascript' src='".$modPath."exposescroller/scrollinit.js'></script> \n";

// If set, load Shadowbox scripts in page
// Should all be in header of page like previous
if (eregi('shadowbox', $setLinking)) {
	if (file_exists ('components/com_expose/expose/shadowbox/build/js/shadowbox.js')) { // If Expose installed
		$output .= "<link rel='stylesheet' type='text/css' href='components/com_expose/expose/shadowbox/build/css/shadowbox.css' /> \n";
		$output .= "<script language='javascript' type='text/javascript' src='components/com_expose/expose/shadowbox/build/js/lib/yui-utilities.js'></script> \n";
		$output .= "<script language='javascript' type='text/javascript' src='components/com_expose/expose/shadowbox/build/js/adapter/shadowbox-yui.js'></script> \n";
		$output .= "<script language='javascript' type='text/javascript' src='components/com_expose/expose/shadowbox/build/js/shadowbox.js'></script> \n";
	} else {
		$output .= "<link rel='stylesheet' type='text/css' href='".$modPath."exposescroller/shadowbox/build/css/shadowbox.css' /> \n";
		$output .= "<script language='javascript' type='text/javascript' src='".$modPath."exposescroller/shadowbox/build/js/lib/yui-utilities.js'></script> \n";
		$output .= "<script language='javascript' type='text/javascript' src='".$modPath."exposescroller/shadowbox/build/js/adapter/shadowbox-yui.js'></script> \n";
		$output .= "<script language='javascript' type='text/javascript' src='".$modPath."exposescroller/shadowbox/build/js/shadowbox.js'></script> \n";
	}
}

//create scroller divs: 1st is visible area, 2nd has all pics 
$output .= "<div id=\"$setModuleId\" style=\"position:relative; overflow:hidden; width:$setWidth; height:$setHeight;\" ";
if (($setDirection !== 'horizontal') && ($setDirection !== 'vertical') && $setHoverPause)
	$output .= "onmouseover=zxcBannerStop('$setModuleId'); onmouseout=zxcBannerStart('$setModuleId');";
$output .= "> \n";
$output .= "<div style=\"position:absolute; top:0px; width:auto; white-space:nowrap;\"> \n";

//are there pics in the album/directory?
if (!$setPicsNum)
	$output .= "<div style=\"position: absolute; background-color: rgb(255, 204, 102); color: rgb(153, 102, 255); text-align: center; font-size: 13px; width: 200px; height: 102px; left: 300px; top: 0px;\">_NO_IMAGES</div> \n";

//if showing the latest added pictures, then sort the array
if ($setPickMethod == 'latest') {
	sortByFunc($aData,create_function('$element','return $element["timestamp"];'));
	// Set the pointer to beginning of array
	reset($aData);
}

//set picture style (padding: create space between pics; border: remove link border)
if (eregi($setDirection, 'left_right_horizontal'))
	$divstyle = "\"height: $setHeight; top: 0px; padding: 0px $setSpace 0px $setSpace; border: 0px\"";
else
	$divstyle = "\"width: $setWidth; top: 0px; padding: $setSpace 0px $setSpace 0px; border: 0px\"";

// Get $setPicsNum images from array
$picstack = '';
for ($i=0;$i<$setPicsNum;$i++) {
	// Search for a PictureId depending user settings
	if ($setPickMethod == 'filename') {
		//not very usefull, but doesn't cost anything...
		$picid=$i;
	} elseif ($setPickMethod == 'latest') {
		//use reverse-sorting: we'll need the id by array-pointer, not by referance
		$picid=key($aData);
		//prepare for next loop
		next($aData);
	} else {
		//random pick: prevent a photo from showing twice or more: check for unique picid
		do {
			$picid = rand(0,$total-1);
		} while (eregi($picid.'a', $picstack.'a'));
		//memorize used pics for check if already used
		$picstack = $picstack.$picid.'a';
	}

	// Get largest picture available to show in Shadowbox
	if (isset($aData[$picid]['largeimage']))
		$largestpic = $ExposeImgPath.$aData[$picid]['largeimage'];
	elseif (isset($aData[$picid]['image']))
		$largestpic = $ExposeImgPath.$aData[$picid]['image'];
	else
		$largestpic = $ExposeImgPath.$aData[$picid]['smallimage'];

	if (isset($aData[$picid]['title']))
		$titlepic = $aData[$picid]['title'];
	else
		$titlepic = '';
		
	if(!is_numeric($setPath)) { // link to directory
		switch ($setLinking) {
			case "shadowbox":
				$Linkref = "<a href=\"".$largestpic."\" rel=\"shadowbox\" title=\"".$titlepic."\">";
				$LinkEndref="</a>";
				break;
			case "shadowboxnav":
				$Linkref = "<a href=\"".$largestpic."\" rel=\"shadowbox[exposescroller]\" title=\"".$titlepic."\">";
				$LinkEndref="</a>";
				break;
			default: // Off
				$Linkref = "";
				$LinkEndref= "";
				break;
		}
	} else { // link to Expose picture
		switch ($setLinking) {
			case "collection":
				if ($newJoom)
					$Linkref = "<a href=\"".JRoute::_("index.php?option=com_expose&topcoll=".$aData[$picid]['albumid'])."\">";
				else
					$Linkref = "<a href=\"".sefRelToAbs("index.php?option=com_expose&amp;Itemid=".$Itemid."&amp;topcoll=".$aData[$picid]['albumid'])."\">";
				$LinkEndref="</a>";
				break;
			case "album":
				if ($newJoom)
					$Linkref = "<a href=\"".JRoute::_("index.php?option=com_expose&album=".$aData[$picid]['albumid'])."\">";
				else
					$Linkref = "<a href=\"".sefRelToAbs("index.php?option=com_expose&amp;Itemid=".$Itemid."&amp;album=".$aData[$picid]['albumid'])."\">";
				$LinkEndref="</a>";
				break;
			case "photo":
				if ($newJoom)
					$Linkref = "<a href=\"".JRoute::_("index.php?option=com_expose&album=".$aData[$picid]['albumid']."&photo=".$aData[$picid]['mngid'])."\">";
				else
					$Linkref = "<a href=\"".sefRelToAbs("index.php?option=com_expose&amp;Itemid=".$Itemid."&amp;album=".$aData[$picid]['albumid']."&amp;photo=".$aData[$picid]['mngid'])."\">";
				$LinkEndref="</a>";
				break;
			case "slideshow";
				if ($newJoom)
					$Linkref = "<a href=\"".JRoute::_("index.php?option=com_expose&album=".$aData[$picid]['albumid']."&photo=".$aData[$picid]['mngid']."&playslideshow=yes")."\">";
				else
					$Linkref = "<a href=\"".sefRelToAbs("index.php?option=com_expose&amp;Itemid=".$Itemid."&amp;album=".$aData[$picid]['albumid']."&amp;photo=".$aData[$picid]['mngid']."&amp;playslideshow=yes")."\">";
				$LinkEndref="</a>";
				break;
			case "slideshowfirst":
				if ($newJoom)
					$Linkref = "<a href=\"".JRoute::_("index.php?option=com_expose&album=".$aData[$picid]['albumid']."&photo=1&playslideshow=yes")."\">";
				else
					$Linkref = "<a href=\"".sefRelToAbs("index.php?option=com_expose&amp;Itemid=".$Itemid."&amp;album=".$aData[$picid]['albumid']."&amp;photo=1&amp;playslideshow=yes")."\">";
				$LinkEndref="</a>";
				break;
			case "shadowbox":
				$Linkref = "<a href=\"".$largestpic."\" rel=\"shadowbox\" title=\"".$titlepic."\">";
				$LinkEndref="</a>";
				break;
			case "shadowboxnav":
				$Linkref = "<a href=\"".$largestpic."\" rel=\"shadowbox[exposescroller]\" title=\"".$titlepic."\">";
				$LinkEndref="</a>";
				break;
			default: // Off
				$Linkref = "";
				$LinkEndref= "";
				break;
		}
	}

	//display and adjust the <img> tag depending settings
	$output .= $Linkref."<img style=$divstyle src=\"".$ExposeImgPath.$aData[$picid]['smallimage']."\" alt=\"".$titlepic."\" />".$LinkEndref."\n";
	//when horizontal scrolling, goto next line
	if (eregi($setDirection, 'up_down_vertical'))
		$output .= "<br />";
}

//finally, load scrollerinit and scrolling script and fire on page loading
$output .= "</div></div> \n \n";

$output .= '<script type="text/javascript">'."\n";
// <!--
$output .= "function ExpScrollLoadEvent(func) { \n";
$output .= "  var oldonload = window.onload; \n";
$output .= "  if (typeof window.onload != 'function') { \n";
$output .= "    window.onload = func; \n";
$output .= "  } else { \n";
$output .= "    window.onload = function() { \n";
$output .= "      if (oldonload) { \n";
$output .= "        oldonload(); \n";
$output .= "      } \n";
$output .= "      func(); \n";
$output .= "    } \n";
$output .= "  } \n";
$output .= "} \n";

/*	 Init horizontal or vertical scrolling
	 zxcCSBanner(divId, type, width, speed, contentArray)
		divId = unique ID name of the Banner <DIV>			(string)
		type = the type of banner 'H' = horizontal, 'V' = vertical.	(string, 'H' or 'V')
		width = (optional) the default width of each element.		(digits or null)
		speed = (optional) the scroll speed (1 = fast, 500 = slow).		(digits or null)
		contentArray = (optional) the Content Array name.		(array variable name, or omit)
*/
	if (eregi($setDirection, 'left_right_horizontal'))
		$output .= "ExpScrollLoadEvent(function(){zxcCSBanner('$setModuleId','H',0,$setSpeed);});\n"; //init scrollerscript
	else
		$output .= "ExpScrollLoadEvent(function(){zxcCSBanner('$setModuleId','V',0,$setSpeed);});\n";

	if (eregi($setLinking, 'shadowboxnav'))
		$output .= "ExpScrollLoadEvent(function(){Shadowbox.init({continuous:true,displayCounter:false,loadingImage:'".$modPath."exposescroller/shadowbox/images/loading.gif'});});\n";  //init ShadowBox

	// Set scrolling direction to left, right, up or down
	if (eregi($setDirection, 'left_up')) {
		 $output .= "ExpScrollLoadEvent(function(){zxcCngDirection('$setModuleId',-1);});\n"; //defign scroll to left
		 $output .= "ExpScrollLoadEvent(function(){zxcBannerStart('$setModuleId');});\n";  //start scrolling
	} elseif (eregi($setDirection, 'right_down')) {
		 $output .= "ExpScrollLoadEvent(function(){zxcCngDirection('$setModuleId',1);});\n"; //defign scroll to right
		 $output .= "ExpScrollLoadEvent(function(){zxcBannerStart('$setModuleId');});\n";  //start scrolling
	} 


// -->
$output .= "</script>\n";
$output .= "<!-- ExposeScroller Module (3v0 beta3) ends here -->\n";
  return $output;
}
?>