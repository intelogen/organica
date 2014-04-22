<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			report.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');	
?>

<div class='contentheading'><?php echo $this->report->name; ?></div>
<div class='quickLinks'>
</div>
<div class='tabs'>
	<ul id="tabMenu">
    	<?php for($i=0;$i<count($this->graphLinks);$i++):
			$graphLink = $this->graphLinks[$i]; ?>
				<li id='tab-<?php echo $i; ?>'><a href='<?php echo $graphLink['link']; ?>'><?php echo $graphLink['name']; ?></a></li>
		<?php endfor; ?>
	</ul>
</div>
<div class='tabContainer'>
	<div class="row1"><div class="itemTitle"><?php echo JText::_('Name'); ?></div><?php echo $this->report->name; ?></div>
	<div class='row0'><div class='itemTitle'><?php echo JText::_('Description'); ?></div><?php echo $this->report->description; ?></div>
	<div class='reportsArea'>
    <script language="javascript">AC_FL_RunContent = 0;</script>
    <script language="javascript"> DetectFlashVer = 0; </script>
    <script src="<?php echo JURI::root().'components'.DS.'com_jforce'.DS.'lib'.DS.'charts'.DS.'AC_RunActiveContent.js'; ?>" language="javascript"></script>
    <script language="JavaScript" type="text/javascript">
    <!--
    var requiredMajorVersion = 9;
    var requiredMinorVersion = 0;
    var requiredRevision = 45;
    -->
    </script>
    
    <script language="JavaScript" type="text/javascript">
    <!--
    if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
        alert("This page requires AC_RunActiveContent.js.");
    } else {
        var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
        if(hasRightVersion) { 
            AC_FL_RunContent(
                'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0',
                'width', '500',
                'height', '350',
                'scale', 'noscale',
                'salign', 'TL',
                'bgcolor', '#777788',
                'wmode', 'opaque',
                'movie', 'components/com_jforce/lib/charts/charts',
                'src', 'components/com_jforce/lib/charts/charts',
                'FlashVars', 'library_path=<?php echo $this->chartPath; ?>', 
                'id', 'my_chart',
                'name', 'my_chart',
                'menu', 'true',
                'allowFullScreen', 'true',
                'allowScriptAccess','sameDomain',
                'quality', 'high',
                'align', 'middle',
                'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
                'play', 'true',
                'devicefont', 'false'
                ); 
        } else { 
            var alternateContent = 'This content requires the Adobe Flash Player. '
            + '<u><a href=http://www.macromedia.com/go/getflash/>Get Flash</a></u>.';
            document.write(alternateContent); 
        }
    }
    // -->
    </script>
    <noscript>
        <P>This content requires JavaScript.</P>
    </noscript>
</div>
</div>