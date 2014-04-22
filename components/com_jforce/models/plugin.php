<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			customfield.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JForceModelPlugin extends JModel {
	
	var $_id					= null;
	var $_type					= null;
	var $_filetype				= null;
	var $_package				= null;
	var $_plugin				= null;
	var $_name					= null;
	var $_directory				= null;
	var $_subfolder				= null;
	var $_tmpDir				= null;
	var $_xml					= null;
	var $_info					= null;
	var $_params				= null;
	var $_pluginPath			= null;
	var $_pluginRoot			= null;
	var $_published				= 1;

    function __construct() {
    	
        parent::__construct();
	
		$type = JRequest::getVar('type','standard');
		$this->set('type', $type);

	} 

	function set($var, $value) {
		$var = '_'.$var;
		$this->$var = $value;
		return true;
	}
	
	function setPath() {
		$this->set('pluginRoot', JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'plugins'.DS.$this->_type);	
	}

	function upload($files, $post) {
		global $mainframe;
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		
		$destination = JPATH_COMPONENT_ADMINISTRATOR.DS.'tmp';
	
		if(!JFolder::exists($destination)):
			JFolder::create($destination);
		endif;
					
		
		$ext = JFile::getExt($files['plugin']['name']);
		if (!$this->checkFileType($ext)) :
			$msg = JText::_('Incorrect Package Type');
			$mainframe->enqueueMessage($msg, 'error');
			return false;
		endif;

		$newDestination = $destination.DS.$files['plugin']['name'];
		
		if(!JFile::upload($files['plugin']['tmp_name'],$newDestination)):
			$msg = JText::_('Error Uploading File');
			$mainframe->enqueueMessage($msg, 'error');
			return false;
		else:
			$this->set('package', $newDestination);
			if (!$this->install()) :
				return false;
			endif;
		endif;
			
	}
	
	function install() {
		global $mainframe;
		jimport('joomla.filesystem.archive');
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		
		$tmpDir = JPATH_COMPONENT_ADMINISTRATOR.DS.'tmp'.DS.'tmp_'.time();
		
		$this->set('tmpDir', $tmpDir);
		
		if (!JFolder::exists($tmpDir)) :
			JFolder::create($tmpDir);
		endif;
		
		JArchive::extract($this->_package, $this->_tmpDir);
		
		$files = JFolder::files($this->_tmpDir);
		$folders = JFolder::folders($this->_tmpDir);
		
		if (!$files && (!$folders || count($folders) > 1)) :
			$msg = JText::_('No Files Found');
			$mainframe->enqueueMessage($msg, 'error');
			$this->abort();
			return false;
		elseif(!$files && count($folders) == 1) :
			$this->set('subfolder', $folders[0]);	
		endif;
	
		if (!$this->findXML()) :
			$this->abort();
			return false;
		endif;
	
		$this->installXML();
	
	}
	
	
	
	function installXML() {
		global $mainframe;
		jimport('joomla.filesystem.file');
		
		$xml = JFactory::getXMLParser('Simple');
		$xml->loadFile($this->_xml);
				
		if ($xml->document->_attributes['type'] != 'JForcePlugin') :
			$msg = JText::_('Incorrect XML Setup File');
			$mainframe->enqueueMessage($msg, 'error');
			$this->abort();
			return false;
		endif;
		
		$info = array();
		
		if (isset($xml->document->_attributes['plugin'])) :
			$info['type'] = $xml->document->_attributes['plugin'];
			$this->set('type',$info['type']);
			$this->setPath();
		endif;
		
		foreach ($xml->document->_children as $data) :
			if ($data->_name != 'files' && $data->_name != 'params') :
				$info[$data->_name] = $data->_data;
			endif;
		endforeach;
		
		if (!$this->checkUnique($info['folder'])) :
			$this->abort();
			return false;
		endif;
		
		if (!isset($xml->document->files[0])) :
			$msg = JText::_('XML Setup File Error: No files specified');
			$mainframe->enqueueMessage($msg, 'error');
			$this->abort();
			return false;
		elseif(count($xml->document->files[0]) == 0) :
			$msg = JText::_('XML Setup File Error: No files specified');
			$mainframe->enqueueMessage($msg, 'error');
			$this->abort();
			return false;
		endif;
		
		$files = array();
		$missing = array();
		
		$tmpPath = $this->getTmpPath();
		foreach($xml->document->files[0]->_children as $file) :
			$filename = $tmpPath.DS.$file->_data;
			if (!JFile::exists($filename)) :
				$missing[] = $file->_data;
			else :
				$files[] = $file->_data;
			endif;
		endforeach;
		
		if (!empty($missing)) :
			$msg = JText::_('XML Setup Missing Files:');
			$mainframe->enqueueMessage($msg, 'error');
			foreach($missing as $m) :
				$mainframe->enqueueMessage($m, 'error');
			endforeach;
			$this->abort();
			return false;
		endif;
		
		$this->set('pluginPath', $this->_pluginRoot.DS.$info['folder']);
		
		if (!JFolder::exists($this->_pluginPath)) :
			JFolder::create($this->_pluginPath);
		endif;
		
		foreach($files as $file) :
			$this->createPath($file);
			$tmp = $tmpPath.DS.$file;
			$new = $this->_pluginPath.DS.$file;
			JFile::move($tmp, $new);
		endforeach;
		
		$newXML = $this->_pluginPath.DS.$info['folder'].'.xml';
		JFile::move($this->_xml, $newXML);
		
		$plugin = &JTable::getInstance('Plugin', 'JTable');
		
		$info['published'] = 0;
		$info['default'] = 0;
		
		$plugin->bind($info);
		
		$plugin->store();
		
		$this->cleanup();
		
		$mainframe->enqueueMessage(JText::_('Plugin Successfully Installed'));
	}
	
	function uninstall() {
		
	}
	
	function getTmpPath() {
		$path = $this->_tmpDir;
		if ($this->_subfolder) :
			$path .= DS.$this->_subfolder;
		endif;
		
		return $path;
	}
	
	function checkFileType($ext) {
		$pass = true;
		$allowed = array('zip', 'gz', 'tar', 'tar.gz','bz2', 'tgz', 'tbz');
		
		if (!in_array($ext, $allowed)) :
			$pass = false;
		endif;
		
		return $pass;
	}
	
	function abort() {
		$this->cleanup();
	}
	
	function findXML() {
		global $mainframe;
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		
		$folder = $this->getTmpPath();
		
		$xmlArray = JFolder::files($folder, 'xml$', false, true);
		
		if (empty($xmlArray) || count($xmlArray) > 1) :
			$msg = JText::_('XML Setup File Not Found');
			$mainframe->enqueueMessage($msg, 'error');
			return false;
		endif;
		
		$this->set('xml', $xmlArray[0]);
		
		return true;
		
	}
	
	function cleanup() {
		jimport('joomla.filesystem.folder');
		
		if (JFolder::exists($this->_tmpDir)) :
			JFolder::delete($this->_tmpDir);
		endif;
		
		if (JFile::exists($this->_package)) :
			JFile::delete($this->_package);
		endif;
		
		return true;
	}
	
	function checkUnique($folder) {
		global $mainframe;
		jimport('joomla.filesystem.folder');

		$query = "SELECT COUNT(*) FROM #__jf_plugins WHERE folder = '$folder'";
		$this->_db->setQuery($query);
		$dbExists = $this->_db->loadResult();
	
		$fileExists = false;
		if (JFolder::exists($this->_pluginRoot.DS.$folder)) :
			$fileExists = true;
		endif;
		
		if ($dbExists || $fileExists) :
			$msg = JText::_('A plugin by this name has already been installed');
			$mainframe->enqueueMessage($msg, 'error');
			return false;
		endif;
		
		return true;
	}
	
	function createPath($file) {
		jimport('joomla.filesystem.folder');
		$path = explode("/", $file);
		if (count($path) == 1) :
			return true;
		else :
			$last = count($path)-1;
			unset($path[$last]);
			$folder = $this->_pluginPath.DS.implode("/", $path);
			if (!JFolder::exists($folder)) :
				JFolder::create($folder);
			endif;
			return true;
		endif;
	}
	
	function initialize() {
            
		global $mainframe;
		jimport('joomla.filesystem.file');
		$this->set('id', '');
		$this->set('type', 'standard');
		$plugins = $this->listPlugins();
		for ($i=0; $i<count($plugins); $i++) :
			$p = $plugins[$i];
			$file = JPATH_COMPONENT.DS.'plugins'.DS.$p->type.DS.$p->folder.DS.$p->folder.'.php';
                        if (JFile::exists($file)) :
				include_once($file);
			endif;
		endfor;
	}
	
	function getTotal() {
		$where = $this->_buildWhere();
		
		$query = "SELECT COUNT(*) FROM #__jf_plugins AS p".
				$where
		;
		$this->_db->setQuery($query);
		
		$total = $this->_db->loadResult();
		return $total;
	}
	
	function listPlugins() {
		
		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		
		$where = $this->_buildWhere();
		
		$query = "SELECT p.* FROM #__jf_plugins AS p".
				$where
		;
		
		$this->_db->setQuery($query, $limitstart, $limit);
		
		$plugins = $this->_db->loadObjectList();
		
		return $plugins;
		
	}
	
	function getPlugin($folder = null) {
		if (!$folder) :
			$where = ' WHERE id = "'.$this->_id.'"';
		else :
			$where = ' WHERE folder = "'.$folder.'"';
		endif;
		
		$query = 'SELECT * FROM #__jf_plugins '.$where;
		$this->_db->setQuery($query);
		$plugin = $this->_db->loadObject();
		
		$this->_plugin = $plugin;
		
		return $plugin;
	}
	
	function _buildWhere() {
	
		if ($this->_id) :
			$where = ' WHERE p.id = '.(int)$this->_id;
		else:
	
			$where = ' WHERE p.published >= '.(int)$this->_published;
		
			if($this->_type) :
				$where .= " AND p.type = '$this->_type'";
			endif;
			
		endif;
	
		return $where;
	
	}
	
	function save($data) {
		$user = &JFactory::getUser();
		$plugin  =& JTable::getInstance('Plugin');
		
		// Bind the form fields to the web link table
		if (!$plugin->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		$params = new JParameter('');
		$params->bind($data['params']);
		$plugin->params = $params->toString();

		// Make sure the table is valid
		if (!$plugin->check()) {
			$this->setError($project->getError());
			return false;
		}
		
		// Store the article table to the database
		if (!$plugin->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_plugin	=& $plugin;

		

		return $this->_plugin;

	}
	
	function loadParams() {
		jimport('joomla.filesystem.file');
				
		$xml = JPATH_SITE.DS.'components'.DS.'com_jforce'.DS.'plugins'.DS.$this->_plugin->type.DS.$this->_plugin->folder.DS.$this->_plugin->folder.'.xml';
		
		if (!JFile::exists($xml)) :
			$xml = null;
		endif;
		
		$params = new JParameter($this->_plugin->params, $xml);
		
		return $params;
	
	}
	
	function buildLists() {
		
		$lists['published'] = JForceListsHelper::getPublishedList($this->_plugin->published);
		
		$lists['default'] = JForceListsHelper::getDefaultList($this->_plugin->default);
		
		return $lists;
	}
	
}