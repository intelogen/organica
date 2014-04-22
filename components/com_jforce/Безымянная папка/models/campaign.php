<?php

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			campaign.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelCampaign extends JModel {
	
	var $_id					= null;
	var $_campaign				= null;
	var $_category				= null;
	var $_published				= 1;
	var $_required				= array('name');

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$category = JRequest::getVar('category');
		$this->_category = $category;
	
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_campaign	= null;
	}	

	function setPid($pid)
	{
		// Set new article ID and wipe data
		$this->_pid		= $pid;
	}	
	
	

	function &getCampaign()
	{
		$user = &JFactory::getUser();
		// Load the Category data
		if ($this->_loadCampaign())
		{
			
			$read = JForceHelper::getObjectStatus($this->_campaign->id, 'campaign');
			if (!$read) :
				JForceHelper::setObjectStatus($this->_campaign->id, 'campaign');
			endif;
			
			if($this->_campaign->image):
				$this->_campaign->image = '<img src="'.JURI::root().'jf_projects'.DS.'people_icons'.DS.$this->_campaign->image.'" />';
			else:
				$this->_campaign->image = '<img src="'.JURI::root().'jf_projects'.DS.'people_icons'.DS.'default.png" />';	
			endif;
					
			$this->_campaign->createdDate = JForceHelper::getDaysDate($this->_campaign->created, false);
			
			if($this->_campaign->attachments):
				$this->_campaign->attachments = $this->loadAttachments();
			endif;
		}
		else
		{
			$campaign =& JTable::getInstance('Campaign');
			$campaign->parameters	= new JParameter( '' );
			$this->_campaign			= $campaign;
		}

		return $this->_campaign;
	}

	function save($data)
	{
				
		$user =& JFactory::getUser();

		$campaign  =& JTable::getInstance('Campaign');

		// Bind the form fields to the web link table
		if (!$campaign->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// sanitise id field
		$campaign->id = (int) $campaign->id;
		
		if (!$campaign->id) :
			$campaign->author = $user->get('id');
			$campaign->created = gmdate("Y-m-d H:i:s");
			$campaign->published = 1;
			$new = 1;
		else :
			$new = 0;
		endif;
		$campaign->description = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$campaign->modified = gmdate("Y-m-d H:i:s");

		// Make sure the table is valid
		if (!$campaign->check()) {
			$this->setError($campaign->getError());
			return false;
		}
		
		$files = JRequest::get('files');
		
		if($files):
			$campaign->attachments = 1;
		endif;

		if (!isset($data['override'])) :
			JForceHelper::validateObject($campaign, $this->_required);
		endif;

		// Store the article table to the database
		if (!$campaign->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		for ($i=0; $i<count($files['file']['name']); $i++) :
			$data['attachment'] = 1;
			$data['campaign'] = $campaign->id;
			$data['id'] = null;
			$fileHandler = JModel::getInstance('File', 'JForceModel');
			$fileHandler->uploadFiles($files, $data);
		endfor;		

		$selectedUsers = JRequest::getVar('hiddenSubscription');
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->setId($campaign->id);
		$subscriptionModel->setPid($campaign->pid);
		$subscriptionModel->setAction('campaign');
		$subscriptionModel->save($selectedUsers);
		
		$this->_campaign	=& $campaign;

		if ($data['notify']) :
			$this->sendNotifications($campaign, $new);
		endif;

		return true;
	}
	
	function getTotal() {
		$where = $this->_buildWhere();

		$query = 'SELECT COUNT(*) '.
				' FROM #__jf_campaigns AS d' .
				' LEFT JOIN #__users AS u on d.author = u.id' .
				$where;
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		return $total;
	}
	
	function listCampaigns() {	
	
		$where = $this->_buildWhere();

		$query = 'SELECT d.*, d.author as authorid, u.name as author '.
				' FROM #__jf_campaigns AS d' .
				' LEFT JOIN #__users AS u on d.author = u.id' .
				$where;
	
		// Get the pagination request variables
		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');

        $campaigns = $this->_getList($query, $limitstart, $limit);

		for($i=0;$i<count($campaigns);$i++):
			$campaign = $campaigns[$i];
			$campaign->link = JRoute::_('index.php?option=com_jforce&c=sales&view=campaign&layout=campaign&id='.$campaign->id);
			
			$read = JForceHelper::getObjectStatus($campaign->id, 'campaign');
			
			if ($read) :
				$campaign->read = "<img src='components".DS."com_jforce".DS."images".DS."campaign_icon.png' />";
			else :
				$campaign->read = "<img src='components".DS."com_jforce".DS."images".DS."campaign_icon_new.png' />";
			endif;
		
		endfor;
		
		$this->list =$campaigns;
        return $this->list;
    }

	function _loadCampaign()
	{
		global $mainframe;

		if($this->_id == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_campaign))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT d.*, d.author as authorid, u.name as author, p.image'.
					' FROM #__jf_campaigns AS d' .
					' LEFT JOIN #__users AS u ON d.author = u.id'.
					' LEFT JOIN #__jf_persons AS p ON p.uid = u.id'.
					$where;
			$this->_db->setQuery($query);
			$this->_campaign = $this->_db->loadObject();

			if ( ! $this->_campaign ) {
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
		$documentModel->setType('campaign',$id);
		$attachments = $documentModel->listDocuments();

		return $attachments;
	}
	
	function loadComments($id = null) {
		
		if (!$id) $id = $this->_id;
	
		$commentModel = &JModel::getInstance('Comment', 'JforceModel');
		$commentModel->setId(null);
		$commentModel->setType('campaign', $id);
		$comments = $commentModel->listComments();
	
		return $comments;
	}
	
	function getCommentCount($campaign) 
	{
		$query = "SELECT count(*) FROM #__jf_comments AS c WHERE c.campaign='$campaign'";
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		if(!$total) $total = 1;
		
		return $total;
		
	}
	
	
	function _buildWhere()
	{
		$user = &JFactory::getUser();
		
		$where  = ' WHERE d.published = '. (int) $this->_published;
				
		if($this->_id):
			$where .= ' AND d.id = '. (int) $this->_id;
		endif;
		
		if ($this->_category):
			$where .= " AND d.category = '$this->_category'";
		endif;
				
		return $where;
	}	
	
	function getFilter() {
		$configModel =& JModel::getInstance('Configuration','JForceModel');
		$categories = $configModel->getConfig('generalcategories', true);
		
		$category_links = "<ul id='tabMenu'>";
		$category_links .= "<li id='tab-0'><a href='".JRoute::_('index.php?option=com_jforce&c=sales&view=campaign')."' />".JText::_('All')."</a></li>";
	
		for($i=0; $i<count($categories); $i++) :
			$category = $categories[$i];
			$category_links .= "<li id='tab-".$i."'><a href='".JRoute::_('index.php?option=com_jforce&c=sales&view=campaign&category='.$category)."' />".$category."</a></li>";
		endfor;
		
		$category_links .= "</ul>";
		
		return $category_links;
	
	}
	
	function buildLists() {
		$lists = array();			
		return $lists;
		
	}
	
	function sendNotifications(&$campaign, $new = false) {
		$user = &JFactory::getUser();
		if($campaign):
			$this->setId($campaign->id);
		endif;
	
		$campaign = $this->getCampaign();
		
		$values = array(
					'type' => 'Campaign',
					'title' => $campaign->summary, 
					'date' => $campaign->modified, 
					'project' => $campaign->projectname, 
					'description' => $campaign->message, 
					'author' => $user->name
				);		
		
		$subscriptionModel = &JModel::getInstance('Subscription', 'JForceModel');
		$subscriptionModel->sendMail($values, $campaign, 'campaign', $new);
		
	}
		
}