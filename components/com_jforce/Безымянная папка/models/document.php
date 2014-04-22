<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			document.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelDocument extends JModel {
	
	var $_id					= null;
	var $_pid					= null;
	var $_document				= null;
	var $_discussion			= null;
	var $_comment				= null;
	var $_milestone				= null;
	var $_ticket 				= null;
	var $_published 			= 1;
	var $_required				= array('name');

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$pid = JRequest::getVar('pid', 0, '', 'int');
		$this->_pid = $pid;
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_document	= null;
	}	
	
	function setMilestone($milestone)
	{
		$this->_milestone = $milestone;	
	}

	function setType($type, $value) {
		$type = "_".$type;
		$this->$type = $value;
	}

	function &getDocument()
	{
		global $mainframe;
		$user = &JFactory::getUser();
		
		// Load the Category data
		if ($this->_loadDocument())
		{
			if ($this->_document->pid != $this->_pid || (!$this->_document->visibility && !$user->systemrole->can_see_private_objects)) :
				JForceHelper::notAuth();
			endif;
			$this->getDocumentDetails($this->_document);
			
			$mainframe->triggerEvent('onLoadDocument',array($this->_document));

		}
		else
		{
			$document =& JTable::getInstance('Document');
			$document->parameters		= new JParameter( '' );
			$this->_document			= $document;
			$this->_document->pid		= $this->_pid;
			$this->_document->milestone = $this->_milestone;
		}

		return $this->_document;
	}

	function save($data)
	{
		global $mainframe;
		
		$data['visibility'] = isset($data['visibility']) ? $data['visibility'] : 1;
		
		$user = &JFactory::getUser();
		$document  =& JTable::getInstance('Document');

		// Bind the form fields to the web link table
		if (!$document->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$document->id = (int) $document->id;

		if (!$document->id) :
			$document->author = $user->get('id');
			$document->created = gmdate("Y-m-d H:i:s");
			$new = 1;
		else :
			$new = 0;
		endif;
		$document->description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$document->modified = gmdate("Y-m-d H:i:s");

		// Make sure the table is valid
		if (!$document->check()) {
			$this->setError($document->getError());
			return false;
		}
		
		if (!isset($data['override'])) :
			JForceHelper::validateObject($document, $this->_required);
		endif;

		$mainframe->triggerEvent('onBeforeDocumentSave',array($document,$new));

		// Store the article table to the database
		if (!$document->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
	
		$selectedUsers = JRequest::getVar('hiddenSubscription');
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setId($document->id);
		$subscriptionModel->setPid($document->pid);
		$subscriptionModel->setAction('document');
		$subscriptionModel->save($selectedUsers);
	
		$this->_document	=& $document;
		
		if ($data['notify']) :
			$this->sendNotifications($document, $new);
		endif;

		$mainframe->triggerEvent('onAfterDocumentSave',array($this->_document,$new));

		return $this->_document;
	}
	
	function getTotal() {
		$where = $this->_buildWhere();

		$query = 'SELECT COUNT(*)'.
				 ' FROM #__jf_documents AS d' .			
				 ' LEFT JOIN #__jf_milestones AS m on d.milestone = m.id' .
				 ' LEFT JOIN #__jf_discussions AS s on d.discussion = s.id' .
				 ' LEFT JOIN #__jf_comments AS c on d.comment = c.id' .
				 ' LEFT JOIN #__users AS u ON d.author = u.id' .
				$where;
				
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		return $total;
	}
	
	function listDocuments() {	
		global $mainframe;
	
		$where = $this->_buildWhere();

		$query = 'SELECT d.*, d.milestone as milestoneid, m.summary as milestone,'.
				 ' d.discussion as discussionid, s.summary as discussion,'.
				 ' d.comment as commentid, c.message as comment,'.
				 ' u.name as author'.
				 ' FROM #__jf_documents AS d' .			
				 ' LEFT JOIN #__jf_milestones AS m on d.milestone = m.id' .
				 ' LEFT JOIN #__jf_discussions AS s on d.discussion = s.id' .
				 ' LEFT JOIN #__jf_comments AS c on d.comment = c.id' .
				 ' LEFT JOIN #__users AS u ON d.author = u.id' .
				$where;
				
		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

        $documents = $this->_getList($query, $limitstart, $limit);

		for($i=0;$i<count($documents);$i++):
			$document = $documents[$i];
			$this->getDocumentDetails($document);
			
			$mainframe->triggerEvent('onLoadDocument',array($document));
		endfor;
		
		
		$this->list =$documents;
        return $this->list;
    }

	function _loadDocument()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_document))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

		
			$query = 'SELECT d.*, d.milestone as milestoneid, m.summary as milestone,b.name AS projectname,'.
					 ' d.discussion as discussionid, s.summary as discussion,'.
					 ' d.comment as commentid, c.message as comment'.
					 ' FROM #__jf_documents AS d' .			
					 ' LEFT JOIN #__jf_milestones AS m on d.milestone = m.id' .
					 ' LEFT JOIN #__jf_discussions AS s on d.discussion = s.id' .
					 ' LEFT JOIN #__jf_comments AS c on d.comment = c.id' .
					 ' LEFT JOIN #__jf_projects AS b ON b.id = d.pid' .
					$where;
					
			$this->_db->setQuery($query);
			$this->_document = $this->_db->loadObject();

			if ( ! $this->_document ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function _buildWhere()
	{
		global $mainframe;
		$user = &JFactory::getUser();
		
		$where = ' WHERE d.published = '. (int) $this->_published;
	
		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR d.id = ',$this->_id);
				$where .= ' AND (d.id = '. $ids.')';
			else:
				$where .=' AND d.id = '.(int) $this->_id;
			endif;

		if($this->_pid):
			$where .= ' AND d.pid = '. (int) $this->_pid;
		endif;

		elseif ($this->_discussion):
			$where .= ' AND d.discussion = '.(int)$this->_discussion;
		elseif ($this->_milestone):
			$where .= ' AND d.milestone = '.(int)$this->_milestone;
		elseif ($this->_comment):
			$where .= ' AND d.comment = '.(int)$this->_comment;
		elseif($this->_ticket):
			$where .= ' AND d.ticket = '.(int)$this->_ticket;
		endif;
		
		if(!$user->systemrole->can_see_private_objects && !$this->_id) :
			$where .= " AND d.visibility = '1'";
		endif;
		
		return $where;
	}
	
	function buildLists() {
		$lists['milestones'] = JforceListsHelper::getMilestoneList($this->_document->milestone);
		
		$lists['category'] = JforceListsHelper::getCategoryList($this->_document->category, 'generalcategories');
		
		$lists['visibility'] = JforceListsHelper::getVisibilityList($this->_document->visibility, $this->_document->id);
		
		return $lists;
	}
	
	function loadComments($id = null) {
		
		if (!$id) $id = $this->_id;
	
		$commentModel = &JModel::getInstance('Comment', 'JforceModel');
		$commentModel->setId(null);
		$commentModel->setType('file', $id);
		$comments = $commentModel->listComments();
	
		for ($i=0; $i<count($comments); $i++) :
			$comment = $comments[$i];
			$comment->permalink = $commentModel->getCommentLink($comment);
		endfor;
	
		return $comments;
	}
	
	function getCommentCount($document) 
	{
		$query = "SELECT count(*) FROM #__jf_comments AS c WHERE c.file='$document'";
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		if(!$total) $total = 1;
		
		return $total;
		
	}
	
	function getDocumentDetails($document)
	{
			$document->file = $this->getLatestVersion($document->id);
			$document->first = $this->getFirstVersion($document->id);
					
			if($document->attachment==0):
				$document->link = JRoute::_('index.php?option=com_jforce&c=project&view=document&layout=document&pid='.$this->_pid.'&id='.$document->id);
			else:
				$document->link = JRoute::_('index.php?option=com_jforce&c=project&task=downloadFile&pid='.$this->_pid.'&id='.$document->file->id);
			endif;

			$document->attachedType = null;
			$document->attachedUrl = null;
			$document->attached = null;

			if($document->milestone):
				$document->attachedType = JRoute::_('Milestone');
				$document->attachedUrl = JRoute::_('index.php?option=com_jforce&c=project&view=milestone&layout=milestone&pid='.$this->_pid.'&id='.$document->milestoneid);
				$document->attached = $document->milestone;
			elseif($document->discussion):
				$document->attachedType = JRoute::_('Discussion');
				$document->attachedUrl = JRoute::_('index.php?option=com_jforce&c=project&view=discussion&layout=discussion&pid='.$this->_pid.'&id='.$document->discussionid);
				$document->attached = $document->discussion;
			endif;
			if($document->comment):
				
				$commentModel =& JModel::getInstance('Comment', 'JForceModel');
				$commentModel->setId($document->commentid);
				$comment = $commentModel->getComment();
				
				$document->attachedType = JText::_('Comment');
				$document->attachedUrl = $commentModel->getCommentLink($comment);

				$document->attached = $document->comment;
			endif;
			$document->attachedUrl = JRoute::_($document->attachedUrl);		
		
	}

	function getFilter() {
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$categories = $configModel->getConfig('generalcategories', true);
		
		$cat = JRequest::getVar('category');
		
		if($cat==''):
			$active = 'class="active"';
		else:
			$active = '';
		endif;
		
		$category_links = "<ul id='tabMenu'>";
		$category_links .= "<li id='tab-0'><a href='".JRoute::_('index.php?option=com_jforce&c=project&view=document&pid='.$this->_pid)."' ".$active."/>".JText::_('All')."</a></li>";
	
		for($i=0; $i<count($categories); $i++) :
			$category = $categories[$i];
			if($cat == $category):
				$active = 'class="active"';
			else:
				$active = '';
			endif;
			$category_links .= "<li id='tab-".$i."'><a href='".JRoute::_('index.php?option=com_jforce&c=project&view=document&pid='.$this->_pid.'&category='.$category)."' ".$active." />".$category."</a></li>";
		endfor;
		
		$category_links .= "</ul>";
		
		return $category_links;
	
	}


	function getLatestVersion($document = null)
	{
		jimport('joomla.filesystem');
		
		$query = "SELECT f.*, u.name as author, p.id as authorid ".
				 "FROM #__jf_files AS f ".
				 "LEFT JOIN #__users AS u ON f.author = u.id ".
				 "LEFT JOIN #__jf_persons AS p ON f.author = p.uid ".
				 "WHERE f.document=".$document.
				 " ORDER BY f.version DESC LIMIT 1";
	
		$this->_db->setQuery($query);
		$file = $this->_db->loadObject();
		
		if($file->image==1):
			$image = 'jf_projects'.DS.$file->pid.DS.'thumbs'.DS.$file->filelocation.'_small.'.$file->filetype;
			$imageLarge = 'jf_projects'.DS.$file->pid.DS.'thumbs'.DS.$file->filelocation.'_medium.'.$file->filetype;
		else:
			$image = 'components'.DS.'com_jforce'.DS.'images'.DS.'filetypes'.DS.$file->filetype.'.png';
			if(!JFile::exists($image)):
				$image = 'components'.DS.'com_jforce'.DS.'images'.DS.'filetypes'.DS.'unknown.png';
			endif;
			$imageLarge = $image;
		endif;

		$file->image = '<img src='.$image.' border="0"/>';
		$file->imageLarge = '<img src='.$imageLarge.' border="0" />';

		$file->createdDate = JForceHelper::getDaysDate($file->created, false);
		
		$file->downloadUrl = JRoute::_('index.php?option=com_jforce&c=project&pid='.$file->pid.'&task=downloadFile&id='.$file->id);
		
		$file->authorUrl = JRoute::_('index.php?option=com_jforce&c=people&view=person&layout=person&id='.$file->authorid);
		
		$file->filesize = JForceHelper::getFilesize($file->filesize);

		
		return $file;
	}
	function getAllVersions($latest = null)
	{
		$where = "WHERE f.document=".$this->_document->id;
		
		if($latest):
			$where .= " AND f.version <> ".$latest;
		endif;
				 
		$query = "SELECT f.*, u.name as author, p.id as authorid ".
				 "FROM #__jf_files AS f ".
				 "LEFT JOIN #__users AS u ON f.author = u.id ".
				 "LEFT JOIN #__jf_persons AS p ON f.author = p.uid ".
				 $where.
				 " ORDER BY f.version DESC";
		$files = $this->_getList($query,0,0);
		
		for($i=0;$i<count($files);$i++):
			$file = $files[$i];
			if($file->image==1):
				$image = 'jf_projects/'.$file->pid.'/thumbs/'.$file->filelocation.'_small.'.$file->filetype;
				$imageLarge = 'jf_projects/'.$file->pid.'/thumbs/'.$file->filelocation.'_medium.'.$file->filetype;
				$file->image = '<img src="'.JURI::root().$image.'" border="0" />';
				$file->imageLarge = '<img src="'.JURI::root().$imageLarge.'" border="0" />';
			endif;
	
			$file->createdDate = JForceHelper::getDaysDate($file->created, false);
			
			$file->downloadUrl = JRoute::_('index.php?option=com_jforce&c=project&pid='.$file->pid.'&task=downloadFile&id='.$file->id);
			
			$file->authorUrl = JRoute::_('index.php?option=com_jforce&c=people&view=person&layout=person&id='.$file->authorid);
			
			$file->filesize = JForceHelper::getFilesize($file->filesize);
			
		endfor;
		
		return $files;
	}	
function getFirstVersion($document = null)
	{
		$query = 'SELECT COUNT(*) FROM #__jf_files AS f '.
				 'WHERE f.document ='.$document;
		
		$this->_db->setQuery($query);
		$result = $this->_db->loadResult();
		
		if($result>1):
			$query = "SELECT f.*, u.name as author, p.id as authorid ".
					 "FROM #__jf_files AS f ".
					 "LEFT JOIN #__users AS u ON f.author = u.id ".
					 "LEFT JOIN #__jf_persons AS p ON f.author = p.uid ".
					 "WHERE f.document=".$document.
					 " ORDER BY f.version ASC LIMIT 1";

			$this->_db->setQuery($query);
			$file = $this->_db->loadObject();
	
			$file->createdDate = JForceHelper::getDaysDate($file->created, false);
				
			$file->authorUrl = JRoute::_('index.php?option=com_jforce&c=people&view=person&layout=person&id='.$file->authorid);
			
			$file->filesize = JForceHelper::getFilesize($file->filesize);
			
		else:
			$file = null;
		endif;
		
		return $file;
	}
	
	function sendNotifications(&$document, $new = false) {
		$user = &JFactory::getUser();
		
		if($document):
			$this->setId($document->id);
		endif;
		
		$document = $this->getDocument();
		
		$values = array(
					'type' => 'Document',
					'title' => $document->name, 
					'date' => $document->modified, 
					'project' => $document->projectname, 
					'description' => $document->description, 
					'author' => $user->name
				);		
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->sendMail($values, $document, 'document', $new);
		
	}
}