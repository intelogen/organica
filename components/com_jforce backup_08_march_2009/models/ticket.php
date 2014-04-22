<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			ticket.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelTicket extends JModel {
	
	var $_id				= null;
	var $_ticket			= null;
	var $_pid 				= null;
	var $_milestone			= null;
	var $_published 		= 1;
	var $_required			= array('summary');

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this-> setId((int)$id);
		
		$pid = JRequest::getVar('pid',0,'','int');
		$this->setPid((int)$pid);
		
		$milestone = JRequest::getVar('milestone',0,'','int');
		$this->setMilestone($milestone);
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_ticket	= null;
	}	
	
	function setPid($pid)
	{
		$this->_pid = $pid;
	}

	function setMilestone($milestone)
	{
		$this->_milestone = $milestone;
	}

	function &getTicket()
	{
		global $mainframe;
		// Load the Category data
		if ($this->_loadTicket())
		{
			
			$read = JForceHelper::getObjectStatus($this->_ticket->id, 'ticket');
			if (!$read) :
				JForceHelper::setObjectStatus($this->_ticket->id, 'ticket');
			endif;
			
			if($this->_ticket->image):
				$this->_ticket->image = '<img src="'.JURI::root().'jf_projects'.DS.'people_icons'.DS.$this->_ticket->image.'" />';
			else:
				$this->_ticket->image = '<img src="'.JURI::root().'jf_projects'.DS.'people_icons'.DS.'default.png" />';	
			endif;
			
			$this->_ticket->assignees = $this->getAssignees($this->_ticket->id);
					
			$this->_ticket->createdDate = JForceHelper::getDaysDate($this->_ticket->created, false);
			
			$this->_ticket->attachments = $this->loadAttachments();
			
			$this->_ticket->link = JRoute::_('index.php?option=com_jforce&view=ticket&layout=ticket&pid='.$this->_ticket->pid.'&id='.$this->_ticket->id);

			$mainframe->triggerEvent('onLoadTicket',array($this->_ticket));		

		}
		else
		{
			$ticket =& JTable::getInstance('Ticket');
			$ticket->parameters	= new JParameter( '' );
			$this->_ticket			= $ticket;
			$this->_ticket->pid		= $this->_pid;
		}

		$customFieldModel = &JModel::getInstance('Customfield', 'JforceModel');
		$layout = JRequest::getVar('layout');
		$edit = $layout == 'form' ? true : false;
		
		$this->_ticket->customFields = $customFieldModel->loadCustomFields('ticket', $this->_ticket->id, $edit);

		return $this->_ticket;
	}

	function save($data)
	{
		global $mainframe;
		$user = &JFactory::getUser();
		$data['visibility'] = isset($data['visibility']) ? $data['visibility'] : 1;

		$ticket  =& JTable::getInstance('Ticket');

		// Bind the form fields to the web link table
		if (!$ticket->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$ticket->id = (int) $ticket->id;

		if (!$ticket->id) :
			$ticket->published = '1';
			$ticket->created = gmdate("Y-m-d H:i:s");
			$ticket->author = $user->id;
			$new = 1;
		else :
			$new = 0;
		endif;
		$ticket->description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$ticket->modified = gmdate("Y-m-d H:i:s");

		// Make sure the table is valid
		if (!$ticket->check()) {
			$this->setError($ticket->getError());
			return false;
		}
		
		if (!isset($data['override'])) :
			JForceHelper::validateObject($ticket, $this->_required);
		endif;
	
		$mainframe->triggerEvent('onBeforeTicketSave',array($this->_ticket,$new));		

		// Store the article table to the database
		if (!$ticket->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		$files = JRequest::get('files');

		for ($i=0; $i<count($files['file']['name']); $i++) :
			$data['attachment'] = 1;
			$data['ticket'] = $ticket->id;
			$data['id'] = null;
			$fileHandler = JModel::getInstance('File', 'JForceModel');
			$fileHandler->uploadFiles($files, $data);
		endfor;		

		$cf = JRequest::getVar('cf', '', 'post', 'array', JREQUEST_ALLOWRAW);
		if ($cf) :
			$customFieldModel = &JModel::getInstance('customfield', 'JforceModel');
			$customFieldModel->saveCustomFields($cf, $ticket->id);
		endif;
		
		$selectedUsers = JRequest::getVar('hiddenSubscription');
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setId($ticket->id);
		
		if($ticket->pid):
			$subscriptionModel->setPid($ticket->pid);
		endif;
		
		$subscriptionModel->setAction('ticket');
		#$subscriptionModel->save($selectedUsers);
		
		$assignedUsers = JRequest::getVar('hiddenAssignment');
		$subscriptionModel->setType('assignment');
		$subscriptionModel->save($assignedUsers);
		
		$this->_ticket	=& $ticket;
		
		if ($data['notify']) :
			$this->sendNotifications($new, $ticket);
		endif;

		$mainframe->triggerEvent('onAfterTicketSave',array($this->_ticket,$new));		

		return true;
	}
	
	function getAssignees($id) {
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setAction('ticket');
		$subscriptionModel->setPid($this->_pid);
		$subscriptionModel->setType('assignment');
		$subscriptionModel->setId($id);
		
		$assignees = $subscriptionModel->loadCurrentSubscriptions();
		
		$assignees = $assignees ? JForceHelper::prepareAssignees($assignees) : '';
		
		return $assignees;
	}
	
	function listTickets() {	
		global $mainframe;
		
		$where = $this->_buildWhere();

		$query = 'SELECT t.*, u.name as author'.
				' FROM #__jf_tickets AS t' .
				' LEFT JOIN #__users AS u ON t.author = u.id'.
				$where;
				
		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

        $tickets = $this->_getList($query, $limitstart, $limit);
		
		for($i=0;$i<count($tickets);$i++):
			$ticket = $tickets[$i];
			$ticket->numReplies = $this->getCommentCount($ticket->id);
			$ticket->assignees = $this->getAssignees($ticket->id);
			$ticket->link = JRoute::_('index.php?option=com_jforce&view=ticket&layout=ticket&pid='.$ticket->pid.'&id='.$ticket->id);
			if($ticket->numReplies==1):
				$ticket->lastPost  = JForceHelper::getDaysDate($ticket->created, false);
				$ticket->lastPostAuthor = $ticket->author;
			else:
				$ticket->lastPost = null;
				$ticket->lastPostAuthor = null;
			endif;
			
			$read = JForceHelper::getObjectStatus($ticket->id, 'ticket');
			
			if ($read) :
				$ticket->read = "<img src='components".DS."com_jforce".DS."images".DS."ticket_icon.png' />";
			else :
				$ticket->read = "<img src='components".DS."com_jforce".DS."images".DS."ticket_icon_new.png' />";
			endif;
			
			$ticket->link = JRoute::_('index.php?option=com_jforce&view=ticket&layout=ticket&pid='.$ticket->pid.'&id='. $ticket->id);
		
			$mainframe->triggerEvent('onLoadTicket',array($ticket));		
			
		endfor;

		
		$this->list =$tickets;
        return $this->list;
    }

	function _loadTicket()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_ticket))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT t.*, t.author as authorid, u.name as author, p.image, m.summary as milestonename, b.name AS projectname '.
					' FROM #__jf_tickets AS t' .
					' LEFT JOIN #__users AS u ON t.author = u.id'.
					' LEFT JOIN #__jf_persons AS p ON p.uid = u.id'.
					' LEFT JOIN #__jf_milestones AS m ON t.milestone = m.id'.
					' LEFT JOIN #__jf_projects AS b ON b.id = t.pid '.
					$where;

			$this->_db->setQuery($query);
			$this->_ticket = $this->_db->loadObject();

			if ( ! $this->_ticket ) {
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
		$documentModel->setType('ticket',$id);
		$attachments = $documentModel->listDocuments();

		return $attachments;
	}
	
	
	function loadComments($id = null) {
		
		if (!$id) $id = $this->_id;
	
		$commentModel = &JModel::getInstance('Comment', 'JforceModel');
		$commentModel->setId(null);
		$commentModel->setType('ticket', $id);
		$comments = $commentModel->listComments();
	
		return $comments;
	}
	
	function getCommentCount($ticket) 
	{
		$query = "SELECT count(*) FROM #__jf_comments AS c WHERE c.ticket='$ticket'";
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		if(!$total) $total = 1;
		
		return $total;
		
	}	

	function getTotal() 
	{
	
		$where = $this->_buildWhere();

		$query = 'SELECT COUNT(*)'.
				' FROM #__jf_tickets AS t' .
				' LEFT JOIN #__users AS u ON t.author = u.id'.
				$where;
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		
		return $total;
	
	}
	
	
	function _buildWhere()
	{
		global $mainframe;
		
		$status = JRequest::getVar('status','0');
	
		$where = ' WHERE t.published = '. (int) $this->_published;
	
		
		
		if($this->_pid):
			$where .= ' AND t.pid = '. (int) $this->_pid;
		endif;
		
		if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR t.id = ',$this->_id);
				$where .= ' AND (t.id = '. $ids.')';
			else:
				$where .=' AND t.id = '.(int) $this->_id;
			endif;
		else :
			$where .= ' AND t.resolved = '. $status;
		endif;

		return $where;
	}	

	function buildLists() {
	
		$lists['milestones'] = JforceListsHelper::getMilestoneList($this->_ticket->milestone);
		
		$lists['category'] = JforceListsHelper::getCategoryList($this->_ticket->category, 'supportcategories');
		
		$lists['resolved'] = JforceListsHelper::getResolvedList($this->_ticket->resolved);
	
		$lists['priority'] =JforceListsHelper::getPriorityList($this->_ticket->priority);	
	
		return $lists;
		
	}

	function sendNotifications($new, $ticket) {
		$user = &JFactory::getUser();
		$this->setId($ticket->id);
		$ticket = $this->getTicket();
		
		$values = array(
					'type' => 'Ticket',
					'title' => $ticket->summary, 
					'date' => $ticket->modified, 
					'project' => $ticket->projectname, 
					'description' => $ticket->description, 
					'author' => $user->name
				);		
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->sendMail($values, $ticket, 'ticket', $new);
		
	}

}