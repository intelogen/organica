<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			discussion.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelDiscussion extends JModel {
	
	var $_id					= null;
	var $_discussion			= null;
	var $_pid					= null;
	var $_category				= null;
	var $_milestone				= null;
	var $_published				= 1;
	var $_required				= array('summary');

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);

		$pid = JRequest::getVar('pid', 0, '', 'int');
		$this->setPid((int)$pid);
		
		$category = JRequest::getVar('category');
		$this->_category = $category;
		
		$milestone = JRequest::getVar('milestone', 0, '', 'int');
		$this->setMilestone($milestone);
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_discussion	= null;
	}	

	function setPid($pid)
	{
		// Set new article ID and wipe data
		$this->_pid		= $pid;
	}	
	
	function setMilestone($milestone) 
	{
		$this->_milestone	= $milestone;	
	}

	function &getDiscussion()
	{
		global $mainframe;
		$user = &JFactory::getUser();
		// Load the Category data
		if ($this->_loadDiscussion())
		{
			if ($this->_discussion->pid != $this->_pid || (!$this->_discussion->visibility && !$user->systemrole->can_see_private_objects)) :
				JForceHelper::notAuth();
			endif;
			
			$read = JForceHelper::getObjectStatus($this->_discussion->id, 'discussion');
			if (!$read) :
				JForceHelper::setObjectStatus($this->_discussion->id, 'discussion');
			endif;
			
			if($this->_discussion->image):
				$this->_discussion->image = '<img src="'.JURI::root().'jf_projects'.DS.'people_icons'.DS.$this->_discussion->image.'" />';
			else:
				$this->_discussion->image = '<img src="'.JURI::root().'jf_projects'.DS.'people_icons'.DS.'default.png" />';	
			endif;
					
			$this->_discussion->createdDate = JForceHelper::getDaysDate($this->_discussion->created, false);
			
			if($this->_discussion->attachments):
				$this->_discussion->attachments = $this->loadAttachments();
			endif;

			$mainframe->triggerEvent('onLoadDiscussion',array($this->_discussion));
		}
		else
		{
			$discussion =& JTable::getInstance('Discussion');
			$discussion->parameters	= new JParameter( '' );
			$this->_discussion			= $discussion;
			$this->_discussion->pid		= $this->_pid;
			$this->_discussion->milestone = $this->_milestone;
		}

		return $this->_discussion;
	}

	function save($data)
	{
		global $mainframe;
		
		$data['visibility'] = isset($data['visibility']) ? $data['visibility'] : 1;
		
		$user =& JFactory::getUser();

		$discussion  =& JTable::getInstance('Discussion');

		// Bind the form fields to the web link table
		if (!$discussion->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$discussion->id = (int) $discussion->id;
		
		if (!$discussion->id) :
			$discussion->author = $user->get('id');
			$discussion->created = gmdate("Y-m-d H:i:s");
			$discussion->published = 1;
			$new = 1;
		else :
			$new = 0;
		endif;

		$discussion->message = JRequest::getVar('message', '', 'post', 'string', JREQUEST_ALLOWRAW);

		$discussion->modified = gmdate("Y-m-d H:i:s");

		// Make sure the table is valid
		if (!$discussion->check()) {
			$this->setError($discussion->getError());
			return false;
		}
		
		$files = JRequest::get('files');
		
		if($files):
			$discussion->attachments = 1;
		endif;

		if (!isset($data['override'])) :
			JForceHelper::validateObject($discussion, $this->_required);
		endif;

		$mainframe->triggerEvent('onBeforeDiscussionSave',array($discussion,$new));
		
		// Store the article table to the database
		if (!$discussion->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		for ($i=0; $i<count($files['file']['name']); $i++) :
			$data['attachment'] = 1;
			$data['discussion'] = $discussion->id;
			$data['id'] = null;
			$fileHandler = JModel::getInstance('File', 'JForceModel');
			$fileHandler->uploadFiles($files, $data);
		endfor;		

		$selectedUsers = JRequest::getVar('hiddenSubscription');
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setId($discussion->id);
		$subscriptionModel->setPid($discussion->pid);
		$subscriptionModel->setAction('discussion');
		$subscriptionModel->save($selectedUsers);
		
		$this->_discussion	=& $discussion;

		if ($data['notify']) :
			$this->sendNotifications($discussion, $new);
		endif;

		$mainframe->triggerEvent('onAfterDiscussionSave',array($this->_discussion,$new));
		
		return $this->_discussion;
	}
	
	function getTotal() {
		$where = $this->_buildWhere();

		$query = 'SELECT COUNT(*) '.
				' FROM #__jf_discussions AS d' .
				' LEFT JOIN #__users AS u on d.author = u.id' .
				$where;
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		return $total;
	}
	
	function listDiscussions() {	
		global $mainframe;
		
		$where = $this->_buildWhere();

		$query = 'SELECT d.*, p.id as authorid, u.name as author '.
				' FROM #__jf_discussions AS d' .
				' LEFT JOIN #__users AS u on d.author = u.id' .
				' LEFT JOIN #__jf_persons AS p on d.author = p.uid' .
				$where;
	
		// Get the pagination request variables
		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

        $discussions = $this->_getList($query, $limitstart, $limit);
		
		for($i=0;$i<count($discussions);$i++):
			$discussion = $discussions[$i];
			$discussion->numPosts = $this->getCommentCount($discussion->id);
			$discussion->link = JRoute::_('index.php?option=com_jforce&view=discussion&layout=discussion&pid='.$discussion->pid.'&id='.$discussion->id);
			if($discussion->numPosts==1):
				$discussion->lastPost  = JForceHelper::getDaysDate($discussion->created, false);
				$discussion->lastPostAuthor = $discussion->author;
			else:
				$discussion->lastPost = null;
				$discussion->lastPostAuthor = null;
			endif;
			
			$read = JForceHelper::getObjectStatus($discussion->id, 'discussion');
			
			if ($read) :
				$discussion->read = "<img src='components".DS."com_jforce".DS."images".DS."discussion_icon.png' />";
			else :
				$discussion->read = "<img src='components".DS."com_jforce".DS."images".DS."discussion_icon_new.png' />";
			endif;
			
			$mainframe->triggerEvent('onLoadDiscussion',array($discussion));
		
		endfor;
		
		$this->list =$discussions;
        return $this->list;
    }

	function _loadDiscussion()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_discussion))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT d.*, p.id as authorid, u.name as author, p.image, m.summary as milestonename, b.name AS projectname'.
					' FROM #__jf_discussions AS d' .
					' LEFT JOIN #__users AS u ON d.author = u.id'.
					' LEFT JOIN #__jf_persons AS p ON p.uid = u.id'.
					' LEFT JOIN #__jf_milestones AS m ON d.milestone = m.id'.
					' LEFT JOIN #__jf_projects AS b ON b.id = d.pid '.
					$where;
			$this->_db->setQuery($query);
			$this->_discussion = $this->_db->loadObject();

			if ( ! $this->_discussion ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function loadAttachments($id = null) 
	{
		if(!$id) $id = $this->_id;
		
		$documentModel =& JModel::getInstance('Document','JForceModel');
		$documentModel->setId(null);
		$documentModel->setType('discussion',$id);
		$attachments = $documentModel->listDocuments();

		return $attachments;
	}
	
	function loadComments($id = null) {
		
		if (!$id) $id = $this->_id;
	
		$commentModel = &JModel::getInstance('Comment', 'JforceModel');
		$commentModel->setId(null);
		$commentModel->setType('discussion', $id);
		$comments = $commentModel->listComments();
	
		return $comments;
	}
	
	function getCommentCount($discussion) 
	{
		$query = "SELECT count(*) FROM #__jf_comments AS c WHERE c.discussion='$discussion'";
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		if(!$total) $total = 1;
		
		return $total;
		
	}
	
	
	function _buildWhere()
	{
		$user = &JFactory::getUser();
		
		$where  = ' WHERE d.published = '. (int) $this->_published;

		if($this->_pid):
			$where .= ' AND d.pid = '. (int) $this->_pid;
		endif;
		
		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR d.id = ',$this->_id);
				$where .= ' AND (d.id = '. $ids.')';
			else:
				$where .=' AND d.id = '.(int) $this->_id;
			endif;
		endif;
		
		if ($this->_category):
			$where .= " AND d.category = '$this->_category'";
		endif;
		
		if(!$user->systemrole->can_see_private_objects && !$this->_id) :
			$where .= " AND d.visibility = '1'";
		endif;
		
		return $where;
	}	
	
	function getFilter() {
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$categories = $configModel->getConfig('generalcategories', true);
		
		$cat = JRequest::getVar('category');
		
		if($cat == ''):
			$active = 'class="active"';
		else:
			$active = '';
		endif;
		
		$category_links = "<ul id='tabMenu'>";
		$category_links .= "<li id='tab-0'><a href='".JRoute::_('index.php?option=com_jforce&view=discussion&pid='.$this->_pid)."' ".$active." />".JText::_('All')."</a></li>";
	
		for($i=0; $i<count($categories); $i++) :
			$category = $categories[$i];
			if($cat == $category):
				$active = 'class="active"';
			else:
				$active = '';
			endif;
			$category_links .= "<li id='tab-".$i."'><a href='".JRoute::_('index.php?option=com_jforce&view=discussion&pid='.$this->_pid.'&category='.$category)."' ".$active." />".$category."</a></li>";
		endfor;
		
		$category_links .= "</ul>";
		
		return $category_links;
	
	}
	
	function buildLists() {
		
		$lists['milestones'] = JforceListsHelper::getMilestoneList($this->_discussion->milestone);
	
		$lists['category'] = JforceListsHelper::getCategoryList($this->_discussion->category, 'generalcategories');
		
		$lists['visibility'] = JforceListsHelper::getVisibilityList($this->_discussion->visibility, $this->_discussion->id);
			
		return $lists;
		
	}
	
	function sendNotifications(&$discussion, $new = false) {
		$user = &JFactory::getUser();
		if($discussion):
			$this->setId($discussion->id);
		endif;
		
		$discussion = $this->getDiscussion();
		
		$values = array(
					'type' => 'Discussion',
					'title' => $discussion->summary, 
					'date' => $discussion->modified, 
					'project' => $discussion->projectname, 
					'description' => $discussion->message, 
					'author' => $user->name
				);		
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->sendMail($values, $discussion, 'discussion', $new);
		
	}
		
}