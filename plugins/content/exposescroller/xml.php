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

if (version_compare(PHP_VERSION,'5','>='))
	if (file_exists("components/com_expose/expose/manager/misc/domxml-php4-to-php5.php"))
		include_once("components/com_expose/expose/manager/misc/domxml-php4-to-php5.php");
	else
		include_once(dirname(__FILE__)."/domxml-php4-to-php5.php");

class exp_xml {

	var $dom;
	var $prearray;
	var $nName;
	var $searchId; //search for specific album/collection id
	var $albumId;  //store album id next to photo id for creating link to expose

	function open_xmlfile($fName) {
		if(!$this->dom = domxml_open_file($fName)) {
			echo $fName . ' could not be opened for reading!'; //lbl('STRUCTUREFILE_NOT_FOUND');
			exit;
		}
	}

	function close_xmlfile() {
		$this->dom->free();
		$this->prearray = null;
		$this->nName = '';
		$this->searchId = 0;
		$this->albumId = null;
	}

	function read_xml($node, &$array) {
		$hasidattrib = '';

		foreach ($node->child_nodes() as $cnode) {
			if ($cnode->node_type()==XML_TEXT_NODE) {
				$nValue = trim($cnode->node_value());
				if (!empty($nValue)) {
					$this->prearray[$this->nName] = $nValue;
				}
			} elseif ($cnode->node_type()==XML_ELEMENT_NODE) {
				switch ($cnode->node_name()) {
					case 'album':
					case 'picture':
					case 'video':
						// New mnid found: save current prearray data here !?
						$hasidattrib = $cnode->get_attribute('_mngid');
						if ($hasidattrib) {
							$this->prearray='';
							$this->prearray['mngid'] = $hasidattrib;
							$this->prearray['albumid'] = $this->albumId;
						}
						break;
					case 'url':
						break;
					case 'thumb':
						$this->nName = 'smallimage';
						break;
					default:
						$this->nName = $cnode->node_name();
				}
				$ntext = exp_xml::read_xml($cnode, $array);
				if ($hasidattrib)
					if (empty($this->searchId) || $hasidattrib == $this->searchId)
						$array[] = $this->prearray;
			}
		}
		return count($array);
	}
}

?>
