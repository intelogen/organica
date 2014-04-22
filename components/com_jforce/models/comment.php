<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			comment.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelComment extends JModel {
	
	var $_id				= null;
	var $_type				= null;
	var $_pid				= null;
	var $_objectid			= null;
	var $_published			= 1;

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$pid = JRequest::getVar('pid',0,'','int');
		$this->setPid((int)$pid);
		
		$type = JRequest::getVar('type',0,'','int');
		$this->setPid((int)$type);
	
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_comment	= null;
	}
	
	function setPid($pid)
	{
		$this->_pid = $pid;
	}
	
	function setType($type) {
		$this->_type = $type;
	}
	
	function setObjectId($id) {
		$this->_objectid = $id;
		return true;
	}

	function &getComment()
	{
		global $mainframe;
		// Load the Category data
		if ($this->_loadComment())
		{

		//	$this->_loadCommentParams();
		$mainframe->triggerEvent('onLoadComment',array($this->_comment));
		}
		else
		{
			$comment =& JTable::getInstance('Comment');
			$comment->parameters	= new JParameter( '' );
			$this->_comment			= $comment;
		}

		return $this->_comment;
	}

	function save($data)
	{
		global $mainframe;
		$user = &JFactory::getUser();
				
		$comment  =& JTable::getInstance('Comment');

		// Bind the form fields to the web link table
		if (!$comment->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$comment->id = (int) $comment->id;

		if (!$comment->id) :
			$comment->author = $user->get('id');
			$comment->created = gmdate("Y-m-d H:i:s");
			$comment->published = 1;
			$isNew = true;
		else :
			$comment->modified = gmdate("Y-m-d H:i:s");
			$isNew = false;
		endif;

		$comment->message = JRequest::getVar('message', '', 'post', 'string', JREQUEST_ALLOWRAW);

		// Make sure the table is valid
		if (!$comment->check()) {
			$this->setError($comment->getError());
			return false;
		}

		$mainframe->triggerEvent('onBeforeCommentSave',array($comment,$isNew));
		// Store the article table to the database
		if (!$comment->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$files = JRequest::get('files');
		
		for ($i=0; $i<count($files['file']['name']); $i++) :
			$data['attachment'] = 1;
			$data['comment'] = $comment->id;
			$fileHandler = JModel::getInstance('file', 'jforceModel');
			$fileHandler->uploadFiles($files, $data);
		endfor;
		
		
		$this->_comment	=& $comment;
		
		$mainframe->triggerEvent('onAfterCommentSave',array($this->_comment,$isNew));

		return $this->_comment;
	}
	
	function listComments() {	
		global $mainframe;
		$where = $this->_buildWhere();

		$limit		= JRequest::getVar('limit', 10, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

		$query = "SELECT c.*, u.name as author, u.username, pr.image, pr.id as authorid, u.email"
				."\n FROM #__jf_comments AS c"
				."\n LEFT JOIN #__users AS u ON u.id = c.author"
				."\n LEFT JOIN #__jf_persons AS pr ON pr.uid = c.author"
				.$where;
		
        $comments = $this->_getList($query, $limitstart, $limit);
		
		for($i=0;$i<count($comments);$i++):
			$comment = $comments[$i];
			$comment->link = $this->getCommentLink($comment);
			$comment->attachments = $this->loadAttachments($comment->id);
			
			if($comment->image):
				$comment->image = '<img src="'.JURI::root().'jf_projects/people_icons/'.$comment->image.'" />';
			else:
				$comment->image = '<img src="'.JURI::root().'components/com_jforce/images/people_icons/default.png" />';	
			endif;
			
			$comment->permalink = $this->getCommentLink($comment);			
			$comment->permalinkImage = '<img src="'.JURI::root().'components/com_jforce/images/permalink.png" />';
			
			$comment->createdDate = JForceHelper::getDaysDate($comment->created, false);
			
			$comment->authorUrl = JRoute::_('index.php?option=com_jforce&view=person&layout=person&id='.$comment->authorid);
			$mainframe->triggerEvent('onLoadComment', array($comment));
		endfor;

		$this->_list = $comments;
        return $this->_list;
    }
	
	function getTotal() 
	{
		$query = "SELECT COUNT(*) FROM #__jf_comments AS c WHERE c.".$this->_type."='$this->_objectid'";
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		
		return $total;
		
	}

	function loadAttachments($id = null) 
	{
		if(!$id) $id = $this->_id;
		JRequest::setVar('limit', 0, 'get');
		JRequest::setVar('limitstart', 0, 'get');
		$documentModel =& JModel::getInstance('Document','JForceModel');
		$documentModel->setId(null);
		$documentModel->setType('comment',$id);
		$attachments = $documentModel->listDocuments();

		return $attachments;
	}

	function _loadComment()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_comment))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = "SELECT c.*, u.name, u.username, pr.image"
					."\n FROM #__jf_comments AS c"
					."\n LEFT JOIN #__users AS u ON u.id = c.author"
					."\n LEFT JOIN #__jf_persons AS pr ON pr.uid = c.author"
					.$where;
			$this->_db->setQuery($query);
			$this->_comment = $this->_db->loadObject();

			if ( ! $this->_comment ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function _buildWhere()
	{
		global $mainframe;
	
		$where = ' WHERE c.published = '.(int)$this->_published;
	
		if($this->_id):
			$where .= ' AND c.id = '. (int) $this->_id;
		elseif ($this->_objectid):
			$where .= ' AND c.'.$this->_type.' = '.(int)$this->_objectid;
		endif;
		
		if($this->_pid):
			$where .= ' AND c.pid = ' . (int)$this->_pid;
		endif;
		
		
		return $where;
	}	
	
	function getCommentLink($comment) {
		$c = 'project';
		if($comment->ticket):
			$field = 'ticket';
		elseif($comment->invoice) :
			$field = 'invoice';
		elseif($comment->quote) :
			$field = 'quote';
		elseif($comment->document):
			$field = 'document';
		elseif($comment->campaign) :
			$field = 'campaign';
			$c = 'sales';
		elseif($comment->potential) :
			$field = 'potential';
			$c = 'sales';
		else:
			$field = 'discussion';
		endif;
		
		$value = $comment->$field;
		$query = "SELECT id FROM #__jf_comments WHERE $field = '$value'";
	
		$this->_db->setQuery($query);
		$totalComments = $this->_db->loadResultArray();
	
		$keys = array_keys($totalComments, $comment->id);

		if($keys):
			$position = $keys[0];
		else:
			$position = 0;
		endif;
		
		$limitstart = 10*(floor($position/10));
	
		$url = 'index.php?option=com_jforce&view='.$field.'&layout='.$field.'&limit=10&limitstart='.$limitstart;
		if ($comment->pid) :
			$url .= '&pid='.$comment->pid;
		endif;
		$url .= '&id='.$value.'#comment'.$comment->id;
		
		$link = JRoute::_($url);
		
		return $link;
		
	}
}