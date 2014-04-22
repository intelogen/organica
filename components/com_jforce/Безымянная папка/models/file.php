<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			file.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelFile extends JModel {
	
	var $_id					= null;
	var $_pid					= null;
	var $_document				= null;
	var $_file					= null;
	var $_discussion			= null;
	var $_comment				= null;
	var $_milestone				= null;

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$pid = JRequest::getVar('pid', 0, '', 'int');
		$this->_pid = $pid;
		
		$milestone = JRequest::getVar('milestone',0,'','int');
		$this->setMilestone($milestone);
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_file	= null;
	}	
	function setMilestone($milestone)
	{
		$this->_milestone = $milestone;
	}
	
	function setType($type, $value) {
		$type = "_".$type;
		$this->$type = $value;
	}

	function &getFile()
	{
		// Load the Category data
		if ($this->_loadFile())
		{

			if ($this->_file->pid != $this->_file || (!$this->_file->visibility && !$user->systemrole->can_see_private_objects)) :
				#JForceHelper::notAuth();
			endif;

		}
		else
		{
			$file =& JTable::getInstance('File');
			$file->parameters	= new JParameter( '' );
			$this->_file		= $file;
			$this->_file->pid	= $this->_pid;
			$this->_file->milestone = $this->_milestone;
		}
		
		return $this->_file;
	}

	function save($data)
	{
		global $mainframe;
		$user = &JFactory::getUser();
		$file  =& JTable::getInstance('File');

		// Bind the form fields to the web link table
		if (!$file->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$file->id = (int) $file->id;

		if (!$file->id) :
			$file->author = $user->get('id');
			$file->created = gmdate("Y-m-d H:i:s");
		else :
			$file->modified = gmdate("Y-m-d H:i:s");
		endif;
		
		if (!$file->pid) $file->pid = $this->_pid;
		
		if (!$file->document) $file->document = $this->_document;

		// Make sure the table is valid
		if (!$file->check()) {
			$this->setError($file->getError());
			return false;
		}
		// Store the article table to the database
		if (!$file->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_file	=& $file;

		return true;
	}
	
	function listFiles() {	
	
		$where = $this->_buildWhere();

		$query = 'SELECT f.* '.
				' FROM #__jf_files AS f' .
				$where;

        $files = $this->_getList($query, 0, 0);
		
		$this->list =$files;
        return $this->list;
    }

	function _loadFile()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_file))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT f.* '.
					' FROM #__jf_files AS f' .
					$where;
			$this->_db->setQuery($query);
			$this->_file = $this->_db->loadObject();

			if ( ! $this->_file ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function _buildWhere()
	{
		global $mainframe;
		
		$where = ' WHERE f.published = 1';
	
		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR f.id = ',$this->_id);
				$where .= ' AND (f.id = '. $ids.')';
			else:
				$where .=' AND f.id = '.(int) $this->_id;
			endif;
		elseif ($this->_discussion):
			$where .= ' AND f.discussion = '.(int)$this->_discussion;
		elseif ($this->_milestone):
			$where .= ' AND f.milestone = '.(int)$this->_milestone;
		elseif ($this->_comment):
			$where .= ' AND f.comment = '.(int)$this->_comment;
		endif;
		
		return $where;
	}
	function uploadIcon($files, $post, $type) {
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
	
		if ($type == 'person') :
			$destination = JPATH_SITE.DS.'jf_projects'.DS.'people_icons';
		else :
			$destination = JPATH_SITE.DS.'jf_projects'.DS.'company_icons';
		endif;
		
		$tmpPath = $destination.DS.'tmp';
		$thumbsDir = $destination.DS.'thumbs';
		
		$file = null;
		if(!JFolder::exists($tmpPath)):
			JFolder::create($tmpPath);
		endif;
		
		if ($files['file']['name']) :
		
			$ext = JFile::getExt($files['file']['name']);
			$file = md5(md5(uniqid().time())).'.'.$ext;
			$newDestination = $tmpPath.DS.$file;
			
			if(!JFile::upload($files['file']['tmp_name'],$newDestination)):
				$this->setError(JText::_('Error Uploading File'));
				return false;
			endif;	
			
			if(!JFolder::exists($destination)):
				JFolder::create($destination);
			endif;
		
			if(!JFolder::exists($thumbsDir)):
				JFolder::create($thumbsDir);
			endif;
			
			$this->resizeImage($newDestination, $destination, 150, 150, $file);
			$this->resizeImage($newDestination, $thumbsDir, 32, 32, $file);
			JFile::delete($newDestination);
		endif;
		
		return $file;
		
	}
	
	
	function uploadFiles($files, $post, $thumb = true) {
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
	
		#if(!$destination) $destination = JPATH_SITE.DS.'jf_projects'.DS.'tmp';
	
		$destination = JPATH_SITE.DS.'jf_projects'.DS.$post['pid'].DS.'originals';
	
		if(!JFolder::exists($destination)):
			JFolder::create($destination);
		endif;
					
		if (count($files['file']['name'])):
			for ($i=0; $i<count($files['file']['name']); $i++) :
				if ($files['file']['name'][$i]) :
					
					$data['name'] = $files['file']['name'][$i];
					$data['filetype'] = JFile::getExt($files['file']['name'][$i]);
					$data['filelocation'] = md5(md5(uniqid().time()));
					$data['filesize'] = $files['file']['size'][$i];
					$data['published'] = 1;
		
					$newDestination = $destination.DS.$data['filelocation'].'.'.$data['filetype'];
		
					if(!JFile::upload($files['file']['tmp_name'][$i],$newDestination)):
						$this->setError(JText::_('Error Uploading File'));
						return false;
					else:
						
						if ($this->isImage($data['filetype'])):
							$image = true;
							$data['image'] = $image ? 1 : 0;
						endif;
						
						if ($post['newVersion']) :
							$data['document'] = $post['document'];
							$data['version'] = $this->_getLatestVersionNumber($data['document']);
						else :
							$post['name'] = $data['name'];
							$this->createDocument($post, $i);
							$data['version'] = 1;
						endif;
						
						$this->save($data);
						
						if ($image && $thumb):
							$this->createThumbs($data, $post);
						endif;
					endif;
				endif;
			endfor;
		endif;
		
	
	}
	
	function createThumbs($data, $post) {
		jimport('joomla.filesystem.folder');
		$projectPath = JPATH_SITE.DS.'jf_projects'.DS.$post['pid'].DS.'originals';
		$fileName = $data['filelocation'].'.'.$data['filetype'];
		
		$file = $projectPath.DS.$fileName;
	
		$thumbsDir = JPATH_SITE.DS.'jf_projects'.DS.$post['pid'].DS.'thumbs';
	
		if(!JFolder::exists($thumbsDir)):
			JFolder::create($thumbsDir);
		endif;
		
		$small = $data['filelocation'].'_small.'.$data['filetype'];
		$medium = $data['filelocation'].'_medium.'.$data['filetype'];
		
		$this->resizeImage($file, $thumbsDir, 100, 100, $small);
		$this->resizeImage($file, $thumbsDir, 500, 500, $medium);
		
	
	}
	
	function createDocument($post, $i) {
		$user = &JFactory::getUser();
		
		$post['description'] = $post['description'][$i];
		$post['published'] = 1;
		$post['visibility'] = 1;
		
		$document = &JModel::getInstance('Document', 'JForceModel');
		$document->save($post);

		$this->_document = $document->_document->id;
		return $this->_document;
	}
	
	function isImage($ext) {
		$images = array(
			'jpg',
			'bmp',
			'png',
			'gif'
		);
	
		if (in_array($ext, $images)) :
			return true;
		else:
			return false;
		endif;
	
	}
	
	function resizeImage($file = null, $destination, $newwidth, $newheight, $name=null) {
		if(!$file) $file = $this->_file;
		
		jimport('joomla.filesystem.file');
		
		$ext = strtolower(JFile::getExt($file));

		if ($ext=='jpg') $ext = 'jpeg';
		$imageCreateFrom = 'imagecreatefrom'.$ext;
		$imageCreate = 'image'.$ext;
		
		// Create an Image from it so we can do the resize
		$src = $imageCreateFrom($file);
		
		// Capture the original size of the uploaded image
		list($width,$height)=getimagesize($file);
		
	
		if($width>$height):		
			$newheight=($height/$width)*$newwidth;
		else :
			$newwidth=($width/$height)*$newheight;
		endif;
			
		$tmp=imagecreatetruecolor($newwidth,$newheight);
	
		// this line actually does the image resizing, copying from the original
		// image into the $tmp image
 		imagealphablending ($tmp, false);
		imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		
		// now write the resized image to disk. I have assumed that you want the
		// resized, uploaded image file to reside in the ./images subdirectory.
		$newFile = $destination.DS.$name;
		
		if($ext=='png'):
			imagesavealpha ($tmp, true);
			$imageCreate($tmp,$newFile);			
		else:
			$imageCreate($tmp,$newFile,100);
		endif;
		
		imagedestroy($src);
		imagedestroy($tmp); 
	
		return true;
	}
	
	function _getLatestVersionNumber($document) {
		
		$query = "SELECT MAX(version) + 1 FROM #__jf_files WHERE document = '$document'";
		$this->_db->setQuery($query);
		$version = $this->_db->loadResult();
		
		return $version;
		
	}

	function downloadFile() {

		$this->getFile();

		$path = JPATH_SITE.DS."jf_projects".DS.$this->_file->pid.DS.'originals'.DS;
		
		$filepath = $path.$this->_file->filelocation.".".$this->_file->filetype;

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$this->_file->name.'"');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filepath));
		ob_clean();
		flush();
		readfile($filepath);

	}		
}