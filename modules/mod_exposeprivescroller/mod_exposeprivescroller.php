<?php
/****************************************************************************
Module: Expose Thumbnail Scroller Module for Joomla 1.0.X and 1.5.x
Version  : 3.0 beta3 (04/05/2008)
Author   : Bruno Marchant
E-mail   : bruno@gotgtek.net
Web Site : www.gotgtek.net
Copyright: Copyright 2007-2008 by GTEK Technologies
License  : Expose thumbnail scroller is released under GNU/GPL licence
*****************************************************************************/

if(!(defined('_VALID_MOS')||defined('_JEXEC'))) die( 'Direct Access to this location is not allowed.' );

// Translate all strings in module
function epscr_lbl( $IniVar) {
	if(function_exists('jimport')) { // J! 1.5.x versions
		return JText::_( $IniVar );
	} else { // J! 1.0.x versions
		global $mosConfig_locale;
	$expLocale = str_replace('_', '-', $mosConfig_locale);
	if (isset($expLocale) && is_file('../modules/mod_exposeprivescroller/'.$expLocale.'/'.$expLocale.'.mod_exposeprivescroller.ini')) {
		$IniFile = '../modules/mod_exposeprivescroller/'.$expLocale.'/'.$expLocale.'.mod_exposeprivescroller.ini';
	} else { // No translation file found for this language: use default en-GB
		$IniFile = "../modules/mod_exposeprivescroller/en-GB/en-GB.mod_exposeprivescroller.ini";
	}
	$IniVar = strtoupper($IniVar);
	$Ini_File = file($IniFile);
	$Ini_Value = "";
	for($Ini_Rec=0; $Ini_Rec<sizeof($Ini_File); $Ini_Rec++) {
		$ispos = strpos($Ini_File[$Ini_Rec], '=');
		if (trim(substr($Ini_File[$Ini_Rec], 0, $ispos-1)) == $IniVar) {
			$Ini_Value = trim(substr($Ini_File[$Ini_Rec], $ispos+1));
				return $Ini_Value;
			}
		}

		if ( !$Ini_Value ) {
			return "ERROR .: Key: <b>".strtoupper($IniVar)."</b>, does not exist in <b>".strtoupper($IniFile)."</b> file !"; // Key or Variable NOT FOUND in INI file
		}
	}
}

// Retrieve the parameters
$setModuleId		= $params->get('ModuleId_sfx', 'expose_scroller2');
$setPath			= $params->get('ImagePath', '0');
$setRecurceDirs 	= $params->get('SubDirs', '1');
$setFileType 		= $params->get('type', '\.(jpg|gif|png)$'); // Set eregi() string type (search for specific file patterns)
$setLinking 		= $params->get('Linking', 'album');
$setHoverPause		= $params->get('Pause', '1');
$setWidth			= $params->get('Width', '100%');
$setHeight			= $params->get('Height', '100');
$setPicsNum			= intval($params->get('PicsNum', '10'));
$setPickMethod		= trim  ($params->get('PickMethod','random'));
$setDirection		= trim  ($params->get('Direction', 'left'));
$setSpeed			= intval($params->get('Speed', '50'));
$setSpace			= intval($params->get('Space', '3'));
$setUseCss			= $params->get('UseCss', '1');
$setCssDef			= $params->get('Css');

// Predefigned things
$ExposeXmlPath = "components/com_exposeprive/expose/xml/";
$newJoom = function_exists('jimport');

//******************
//sort a subarray
if(!function_exists('sortByFunc')) {
	function sortByFunc(&$arr, $func) {
		$tmpArr = array();
		foreach ($arr as $k => $e) {
			$tmpArr[] = array('f' => $func($e), 'k' => $k, 'e' =>$e);
		}
		rsort($tmpArr);
		$arr = array();
		foreach($tmpArr as $fke) {
			$arr[$fke['k']] = $fke['e'];
		}
	}
}

//******************
// open other required libs and search the Expose componentId in the database
//function get_componentId($ModuleName = "com_exposeprive") {
	if($newJoom) {
		$exp_live_site = JURI::base();
		//$exp_live_site = $this->baseurl;
		$modPath = $exp_live_site . 'modules/mod_exposeprivescroller/'; // J!1.5.x creates a module directory now, 1.0.x didn't
	} else {
		global $mosConfig_live_site;
		$exp_live_site = $mosConfig_live_site.'/';
		$modPath = $exp_live_site . 'modules/';
		$query = "SELECT id FROM #__menu WHERE published = 1 AND link = 'index.php?option=com_exposeprive' ORDER BY link" ;
		$database->setQuery( $query );
		$Itemidobj = $database->loadObjectList();
		if (count($Itemidobj) > 0) $Itemid = $Itemidobj[0]->id;
	}
//return $Itemid;
//}

//****************************************************************************
//****************** READ EXPOSE XML FILES *********************************
//****************************************************************************
//if folder is just a number then analyze the Expose XML files
if (is_numeric($setPath)) {
	require_once( dirname(__FILE__).'/mod_exposeprivescroller/xml.php' ); // Lib for searching/loading Expose xml content files
	//open xml file, read the collection into array and return qty of records
	$cData = array(); $aData = array();

	$domobj = new exp_xmlp;
	$domobj->open_xmlfile(realpath('components/com_exposeprive/expose/xml').'/albums.xml');
	$domobj->searchId = $setPath;
	$total = $domobj->read_xml($domobj->dom, $cData);
	$domobj->close_xmlfile();

	//if user wants random selection of pics, loop trough collection array and read all albums
	if ($total == 0) {
		//If  cData is emty (albums.xml doesn't exist or has no albums), it will generate an error in foreach()  so first check!
		echo epscr_lbl('NO_ALBUMS_FOUND');
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

	$ExposeImgPath = $exp_live_site . "components/com_exposeprive/expose/img/";

// Overview created arrays for troubleshooting
//echo "\n<br><!-- Collection: \n<br>"; print_r($cData); echo "\n<br>Album: \n<br>"; print_r($aData); echo " -->";

//****************************************************************************
//****************** READ FILES FROM DIRECTORY (NON-EXPOSE) ******************
//****************************************************************************
// not numeric: search in requested folder
} else {
	require_once( dirname(__FILE__).'/mod_exposeprivescroller/folder.php' ); // Lib for searcheng/loading files from path
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
echo "\n<!-- ExposeScroller Module (3v0 beta3) starts here --> \n";
//use css?
//if($setUseCss) echo"\n<style type='text/css'><!-- $setCssDef --></style>";

// Should be in header of page: use global $mainframe; $mainframe->addcustomHeadTag('...') instead of echo ''
echo "<script language='javascript' type='text/javascript' src='".$modPath."mod_exposeprivescroller/continiousscroll.js'></script> \n"
	. "<script language='javascript' type='text/javascript' src='".$modPath."mod_exposeprivescroller/scrollinit.js'></script> \n";

// If set, load Shadowbox scripts in page
// Should all be in header of page like previous
if (eregi('shadowbox', $setLinking)) {
	if (file_exists ('components/com_exposeprive/expose/shadowbox/build/js/shadowbox.js')) { // If Expose installed
		echo "<link rel='stylesheet' type='text/css' href='components/com_exposeprive/expose/shadowbox/build/css/shadowbox.css' /> \n";
		echo "<script language='javascript' type='text/javascript' src='components/com_exposeprive/expose/shadowbox/build/js/lib/yui-utilities.js'></script> \n";
		echo "<script language='javascript' type='text/javascript' src='components/com_exposeprive/expose/shadowbox/build/js/adapter/shadowbox-yui.js'></script> \n";
		echo "<script language='javascript' type='text/javascript' src='components/com_exposeprive/expose/shadowbox/build/js/shadowbox.js'></script> \n";
	} else {
		echo "<link rel='stylesheet' type='text/css' href='".$modPath."mod_exposeprivescroller/shadowbox/build/css/shadowbox.css' /> \n";
		echo "<script language='javascript' type='text/javascript' src='".$modPath."mod_exposeprivescroller/shadowbox/build/js/lib/yui-utilities.js'></script> \n";
		echo "<script language='javascript' type='text/javascript' src='".$modPath."mod_exposeprivescroller/shadowbox/build/js/adapter/shadowbox-yui.js'></script> \n";
		echo "<script language='javascript' type='text/javascript' src='".$modPath."mod_exposeprivescroller/shadowbox/build/js/shadowbox.js'></script> \n";
	}
}

//create scroller divs: 1st is visible area, 2nd has all pics 
echo "<div id=\"$setModuleId\" style=\"position:relative; overflow:hidden; width:$setWidth; height:$setHeight;\" ";
if (($setDirection !== 'horizontal') && ($setDirection !== 'vertical') && $setHoverPause)
	echo "onmouseover=zxcBannerStop('$setModuleId'); onmouseout=zxcBannerStart('$setModuleId');";
echo "> \n";
echo "<div style=\"position:absolute; top:0px; width:auto; white-space:nowrap;\"> \n";

//are there pics in the album/directory?
if (!$setPicsNum)
	echo "<div style=\"position: absolute; background-color: rgb(255, 204, 102); color: rgb(153, 102, 255); text-align: center; font-size: 13px; width: 200px; height: 102px; left: 300px; top: 0px;\">_NO_IMAGES</div> \n";

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
					$Linkref = "<a href=\"".JRoute::_("index.php?option=com_exposeprive&topcoll=".$aData[$picid]['albumid'])."\">";
				else
					$Linkref = "<a href=\"".sefRelToAbs("index.php?option=com_exposeprive&amp;Itemid=".$Itemid."&amp;topcoll=".$aData[$picid]['albumid'])."\">";
				$LinkEndref="</a>";
				break;
			case "album":
				if ($newJoom)
					$Linkref = "<a href=\"".JRoute::_("index.php?option=com_exposeprive&album=".$aData[$picid]['albumid'])."\">";
				else
					$Linkref = "<a href=\"".sefRelToAbs("index.php?option=com_exposeprive&amp;Itemid=".$Itemid."&amp;album=".$aData[$picid]['albumid'])."\">";
				$LinkEndref="</a>";
				break;
			case "photo":
				if ($newJoom)
					$Linkref = "<a href=\"".JRoute::_("index.php?option=com_exposeprive&album=".$aData[$picid]['albumid']."&photo=".$aData[$picid]['mngid'])."\">";
				else
					$Linkref = "<a href=\"".sefRelToAbs("index.php?option=com_exposeprive&amp;Itemid=".$Itemid."&amp;album=".$aData[$picid]['albumid']."&amp;photo=".$aData[$picid]['mngid'])."\">";
				$LinkEndref="</a>";
				break;
			case "slideshow";
				if ($newJoom)
					$Linkref = "<a href=\"".JRoute::_("index.php?option=com_exposeprive&album=".$aData[$picid]['albumid']."&photo=".$aData[$picid]['mngid']."&playslideshow=yes")."\">";
				else
					$Linkref = "<a href=\"".sefRelToAbs("index.php?option=com_exposeprive&amp;Itemid=".$Itemid."&amp;album=".$aData[$picid]['albumid']."&amp;photo=".$aData[$picid]['mngid']."&amp;playslideshow=yes")."\">";
				$LinkEndref="</a>";
				break;
			case "slideshowfirst":
				if ($newJoom)
					$Linkref = "<a href=\"".JRoute::_("index.php?option=com_exposeprive&album=".$aData[$picid]['albumid']."&photo=1&playslideshow=yes")."\">";
				else
					$Linkref = "<a href=\"".sefRelToAbs("index.php?option=com_exposeprive&amp;Itemid=".$Itemid."&amp;album=".$aData[$picid]['albumid']."&amp;photo=1&amp;playslideshow=yes")."\">";
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
	echo $Linkref."<img style=$divstyle src=\"".$ExposeImgPath.$aData[$picid]['smallimage']."\" alt=\"".$titlepic."\" />".$LinkEndref."\n";
	//when horizontal scrolling, goto next line
	if (eregi($setDirection, 'up_down_vertical'))
		echo "<br />";
}

//finally, load scrollerinit and scrolling script and fire on page loading
?>
</div></div>

<script type="text/javascript">
// <!--
function ExpScrollLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}
<?php
/*	 Init horizontal or vertical scrolling
	 zxcCSBanner(divId, type, width, speed, contentArray)
		divId = unique ID name of the Banner <DIV>			(string)
		type = the type of banner 'H' = horizontal, 'V' = vertical.	(string, 'H' or 'V')
		width = (optional) the default width of each element.		(digits or null)
		speed = (optional) the scroll speed (1 = fast, 500 = slow).		(digits or null)
		contentArray = (optional) the Content Array name.		(array variable name, or omit)
*/
	if (eregi($setDirection, 'left_right_horizontal'))
		echo "ExpScrollLoadEvent(function(){zxcCSBanner('$setModuleId','H',0,$setSpeed);});\n"; //init scrollerscript
	else
		echo "ExpScrollLoadEvent(function(){zxcCSBanner('$setModuleId','V',0,$setSpeed);});\n";

	if (eregi($setLinking, 'shadowboxnav'))
		echo "ExpScrollLoadEvent(function(){Shadowbox.init({continuous:true,displayCounter:false,loadingImage:'".$modPath."mod_exposeprivescroller/shadowbox/images/loading.gif'});});\n";  //init ShadowBox

	// Set scrolling direction to left, right, up or down
	if (eregi($setDirection, 'left_up')) {
		 echo "ExpScrollLoadEvent(function(){zxcCngDirection('$setModuleId',-1);});\n"; //defign scroll to left
		 echo "ExpScrollLoadEvent(function(){zxcBannerStart('$setModuleId');});\n";  //start scrolling
	} elseif (eregi($setDirection, 'right_down')) {
		 echo "ExpScrollLoadEvent(function(){zxcCngDirection('$setModuleId',1);});\n"; //defign scroll to right
		 echo "ExpScrollLoadEvent(function(){zxcBannerStart('$setModuleId');});\n";  //start scrolling
	} 

?>
// -->
</script>
<!-- ExposeScroller Module (3v0 beta3) ends here -->
