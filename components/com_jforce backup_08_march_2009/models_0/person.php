<?php

/************************************************************************************
*	@package		Joomla									   						*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			person.php														*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
*************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JforceModelPerson extends JModel {
	
	var $_id					= null;
	var $_pid					= null;
	var $_uid					= '0';
	var $_type					= null;
	var $_person				= null;
	var $_company				= null;
	var $_published 			= 1;
	var $_auto_add				= null;
	var $_required				= array('lastname', 'company');

    function __construct() {
    	
        parent::__construct();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$type = JRequest::getVar('type', 0, '', 'int');
		$this->setType($type);
		
		$pid = JRequest::getVar('pid', 0, '', 'int');
		$this->setPid($pid);

		$company = JRequest::getVar('company', 0, '', 'int');
		$this->setCompany($company);		
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_person	= null;
	}
	
	function setPid($pid)
	{
		// Set new article ID and wipe data
		$this->_pid		= $pid;
	}

	function setCompany($company)
	{
		$this->_company	= $company;
	}	
	
	function setUserid($uid) {
		$this->_uid = $uid;
	}
	
	function setType($type) {
	
		$this->_type = $type;
	
	}
	
	function setAutoAdd($autoAdd) {
	
		$this->_auto_add = $autoAdd;
	
	}

	function &getPerson()
	{
		global $mainframe;
		// Load the Category data
		if ($this->_loadPerson())
		{
			
			if($this->_person->image):
				$this->_person->image = '<img src="'.JURI::root().'jf_projects/people_icons/'.$this->_person->image.'" />';
			else:
				$this->_person->image = '<img src="'.JURI::root().'components/com_jforce/images/people_icons/default_large.png" />';
			endif;
			
			$this->_person->accessrole = $this->_person->accessrole ? $this->_person->accessrole : JText::_('Custom');
			$this->_person->companyLink = JRoute::_('index.php?option=com_jforce&c=people&view=company&layout=company&id='.$this->_person->companyid); 			

			$mainframe->triggerEvent('onLoadPerson', array($this->_person));

		}
		else
		{
			$person =& JTable::getInstance('Person');
			$person->parameters	= new JParameter( '' );
			$person->username = null;
			$person->email = null;
			$this->_person			= $person;
			$this->_person->pid		= $this->_pid;
			$this->_person->companyid = $this->_company;
		}

		$customFieldModel = &JModel::getInstance('Customfield', 'JforceModel');
		$layout = JRequest::getVar('layout');
		$edit = $layout == 'form' ? true : false;
		
		$this->_person->customFields = $customFieldModel->loadCustomFields('person', $this->_person->id, $edit);

		return $this->_person;
	}

	function save($data)
	{
		global $mainframe;
		$user = &JFactory::getUser();

		$params = JRequest::getVar('user');
		$params['id'] = $data['uid'];
		
		if ($data['firstname']) :
			$params['name'] = $data['firstname']." ".$data['lastname'];
		else:
			$params['name'] = $data['lastname'];
		endif;
		
		$block = false;
		
		if ($data['uid'] && !$data['id']):
			$this->setUserid($data['uid']);
		else:		
			if (!$this->saveJoomlaUser($params,$block)) :
				return false;
			endif;
		endif;

		if (!$data['uid']) :
			$data['uid'] = $this->_uid;
		endif;

		$person  =& JTable::getInstance('Person');

		// Bind the form fields to the web link table
		if (!$person->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
			
		if (!$person->id) :
			$person->uid = $this->_uid;
			$person->author = $user->get('id');
			$person->created = gmdate("Y-m-d H:i:s");
			$person->published = 1;
			$person->key = JForceHelper::generateKey();
			$isNew = true;
		else :
			$person->modified = gmdate("Y-m-d H:i:s");
			$isNew = false;
		endif;

		// sanitise id field
		$person->id = (int) $person->id;

		// Make sure the table is valid
		if (!$person->check()) {
			$this->setError($person->getError());
			return false;
		}
		
		if (!isset($data['override'])) :
			JForceHelper::validateObject($person, $this->_required);
		endif;
		
		$mainframe->triggerEvent('onBeforePersonSave',array($person,$isNew));

		
		// Store the article table to the database
		if (!$person->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$cf = JRequest::getVar('cf', '', 'post', 'array', JREQUEST_ALLOWRAW);
		if ($cf) :
			$customFieldModel = &JModel::getInstance('customfield', 'JforceModel');
			$customFieldModel->saveCustomFields($cf, $person->id);
		endif;
		
		$projectroles = JRequest::getVar('pr');
		$systemroles = JRequest::getVar('sys');
		$roles = array_merge($systemroles,$projectroles);
		
		$accessRoleModel = &JModel::getInstance('Accessrole', 'JforceModel');
		$accessrole = $accessRoleModel->saveUserAccessRole($roles, $person);
		
		if ($accessrole) :
			$person->systemrole = $accessrole;
			$person->store();
		endif;
	
		$this->_person	=& $person;

		$mainframe->triggerEvent('onAfterPersonSave',array($this->_person,$isNew));
		return $this->_person;
	}
	
	function getTotal() {
		$where = $this->_buildWhere();

		$query = 'SELECT COUNT(*)'.
				' FROM #__jf_persons AS p' .
				' LEFT JOIN #__jf_companies AS c on p.company = c.id' .
				' LEFT JOIN #__users AS u ON p.uid = u.id' .
				$where;
				
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		return $total;
	}
	
	function listPersons() {	
		global $mainframe;
	
		$where = $this->_buildWhere();

		$query = 'SELECT p.*, p.company as companyid, u.name, u.email,'.
				' u.lastvisitDate as lastvisit, c.name as company '.
				' FROM #__jf_persons AS p' .
				' LEFT JOIN #__jf_companies AS c on p.company = c.id' .
				' LEFT JOIN #__users AS u ON p.uid = u.id' .
				$where;
		
		$limit		= JRequest::getVar('limit', 0, '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		
        $persons = $this->_getList($query, $limitstart, $limit);
		
		for($i=0;$i<count($persons);$i++):
			$person = $persons[$i];
			if(!$person->image):
				$person->image = '<img src="'.JURI::root().'components/com_jforce/images/people_icons/default.png" />';
			else:
				$person->image = '<img src="'.JURI::root().'jf_projects/people_icons/thumbs/'.$person->image.'" />';
			endif;

			if($person->lastvisit == '0000-00-00 00:00:00') : 
				$person->lastvisit = 'N/A';
				$person->date = 'N/A';
			else :
				$person->date = JForceHelper::getDaysDate($person->lastvisit,false);
			endif;
			
			$person->companyLink = JRoute::_('index.php?option=com_jforce&c=people&view=company&layout=company&id='.$person->companyid); 
			$mainframe->triggerEvent('onLoadPerson', array($person));
		endfor;
		
		$this->list =$persons;
        return $this->list;
    }

	function _loadPerson()
	{
		global $mainframe;

		if($this->_person):
			return true;
		endif;

		if($this->_id == '0' && $this->_uid == '0')
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_person))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT p.*, u.name, u.username, u.email, u.registerDate, c.name as company, p.company as companyid, s.name as accessrole, c.admin, p.company AS companyid '.
					' FROM #__jf_persons AS p' .
					' LEFT JOIN #__jf_companies AS c ON p.company = c.id' .
					' LEFT JOIN #__users AS u ON u.id = p.uid'.
					' LEFT JOIN #__jf_accessroles as s on p.systemrole = s.id' .
					$where;
					
			$this->_db->setQuery($query);
			$this->_person = $this->_db->loadObject();

			if ( ! $this->_person ) {
				return false;
			}
			return true;
		}
		return true;
	}
	
	function _buildWhere()
	{
		global $mainframe;
				
		if($this->_pid):
			$where  =' LEFT JOIN #__jf_projectroles_cf AS cf on cf.uid = u.id';
			$where .=' WHERE cf.pid = ' . $this->_pid;
			$where .=' ORDER BY c.admin DESC, c.name ASC, u.name ASC';
		else:
			$where = ' WHERE p.published = '. (int) $this->_published;

			if($this->_id):
			if(is_array($this->_id)):
				$ids = implode(' OR p.id = ',$this->_id);
				$where .= ' AND (p.id = '. $ids.')';
			else:
				$where .=' AND p.id = '.(int) $this->_id;
			endif;
			elseif($this->_uid):
				$where .= ' AND p.uid = '. (int) $this->_uid;
			elseif($this->_auto_add) :
				$where .= ' AND p.auto_add = "1"';
			else:
				$where .= ' AND p.lead = '. (int) $this->_type;
			endif;
			
			if($this->_company):
				$where .= ' AND p.company = '. (int) $this->_company;
			endif;
		endif;
		
		return $where;
	}
	
	function buildLists() {
		$lists['roles'] = JforceListsHelper::getAccessRoleList($this->_person->systemrole);
								
		$lists['auto_add'] = JHTML::_('select.booleanlist', 'auto_add', '', $this->_person->auto_add, JText::_('Yes'), JText::_('No'));
		
		$lists['company'] = JForceListsHelper::getClientList($this->_person->companyid);
		
		$lists['projects'] = JForceListsHelper::getProjectList();
		
		$lists['projectstatus'] = JForceListsHelper::getStatusList();
		
		$lists['joomlausers'] = JForceListsHelper::getJoomlaUsers();
	
		return $lists;	
	}
	
	function saveJoomlaUser($params, $block = false) {
		global $mainframe;
		if (!$params['id']) :
			$params['gid'] = '18';
			$params['usertype'] = 'Registered';
		endif;
		
		$user = new JUser($params['id']);
		if (!$user->bind($params))
			{
				$mainframe->enqueueMessage(JText::_('CANNOT SAVE THE USER INFORMATION'), 'message');
				$mainframe->enqueueMessage($user->getError(), 'error');
				return false;
			}
		
		if($block) $user->block = 1;

		if(!$user->save()) {
			$mainframe->enqueueMessage(JText::_('CANNOT SAVE THE USER INFORMATION'), 'message');
			$mainframe->enqueueMessage($user->getError(), 'error');
			return false;
		}
		
		$this->setUserid($user->id);
		return $this->_uid;
	}
	
	function loadProjectPermissions($pid) {
		$query = "SELECT * FROM #__jf_projectroles_cf WHERE uid = '$this->_uid' AND pid = '$pid'";
		$this->_db->setQuery($query);
		$permissions = $this->_db->loadObject();
		return $permissions;
	}

	//Lead Conversion Functions
	function convertLead1($post) 
	{
		$lead  =& JTable::getInstance('Person');
		$lead->load($post['person']);
		$lead->lead = 0;
		$lead->converted = 1;
		$lead->systemrole = $post['systemrole'];
		$lead->store();	

		if ($post['firstname']) :
			$params['name'] = $post['firstname']." ".$post['lastname'];
		else:
			$params['name'] = $post['lastname'];
		endif;
		
		$params['username'] = $post['username'];
		$params['email']    = $post['email'];
	
		#$params['id'] = $lead->uid;
		
		$this->saveJoomlaUser($params);
	
		return true;
	}
	
	function convertLead2($post) {

		$companyId = $post['company'];
		
		if(!$companyId):
			$companyModel =& JModel::getInstance('Company','JForceModel');
			$company = $companyModel->save($post);
			$companyId = $company->id;
		endif;
		
		$person  =& JTable::getInstance('Person', 'JTable');
		$person->load($post['person']);
		$person->company = $companyId;
		
		$person->store();
				
		return true;
	}

	function convertLead3($post) {

		$projectModel =& JModel::getInstance('Project','JForceModel');
		$project = $projectModel->save($post);
		$projectId = $project->id;
	
		return $projectId;
	}


	function getCompany($existing = null) 
	{
		$companyModel =& JModel::getInstance('Company','JForceModel');
		$companyModel->setId($existing);
		
		$company = $companyModel->getCompany();
		
		return $company;
	}
	
	// END Lead Conversion Functions
	
}