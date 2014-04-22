<?php 

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			chart.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<chart>
	<chart_type><?php echo $this->type; ?></chart_type>
	<chart_data>
    	<row>
        <null/>
	<?php for($i=0;$i<count($this->data);$i++):
			$row = $this->data[$i]; ?>
			<string><?php echo $row['label']; ?></string>
    <?php endfor; ?>
    	</row>
        <row>
        	<string>Projects by Status</string>
	<?php for($i=0;$i<count($this->data);$i++):
			$row = $this->data[$i]; ?>
			<number><?php echo $row['value']; ?></number>
    <?php endfor; ?>
    	</row>
	</chart_data>
	<series_color>
		<color>86ab71</color>
		<color>4e627c</color>
		<color>564546</color>
        <color>ff0000</color>
		<color>336699</color>
	</series_color>

</chart>