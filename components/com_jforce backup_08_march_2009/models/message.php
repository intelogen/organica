<?php
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');

class JForceModelMessage extends JModel {
	
	var $_id			= null;
	var $_uid			= null;
	var $_type			= null;
	var $_message		= null;
	var $_published		= null;
	var $_private		= null;

    function __construct() {
    	
        parent::__construct();
		
		$user = JFactory::getUser();
		
		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
		
		$uid = JRequest::getVar('user', $user->get('id'), '', 'int');
		$this->setUid($uid);
		
		$type = JRequest::getVar('action', 'inbox');
		$this->setType($type);
		
	} 

	function setId($id)
	{
		// Set new article ID and wipe data
		$this->_id		= $id;
		$this->_message	= null;
	}	
	
	function setUid($uid) {
		$this->_uid = $uid;
	}

	function setType($type) {
		$this->_type = $type;	
	}

	function &getMessage()
	{
		
		// Load the Message data
		if ($this->_loadMessage())
		{
			$user = &JFactory::getUser();
			if ($this->_message->to != $user->id && $this->_message->from != $user->id) :
				JForceHelper::notAuth();
				return false;
			endif;
		//	$this->_loadMessageParams();

		}
		else
		{
			$message =& JTable::getInstance('Message');
			$message->parameters	= new JParameter( '' );
			$this->_message			= $message;
		}
		
		return $this->_message;
	}

	function save($data)
	{
		global $mainframe;

		$message  =& JTable::getInstance('Message');
		$user = &JFactory::getUser();
		// Bind the form fields to the web link table
		if (!$message->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (!$message->id) :
			$message->from = $user->get('id');
			$message->created = date("Y-m-d H:i:s");
			$message->read = 0;
		endif;

		$message->body = JRequest::getVar('body', '', 'post', 'string', JREQUEST_ALLOWRAW);

		// Make sure the table is valid
		if (!$message->check()) {
			$this->setError($message->getError());
			return false;
		}
		// Store the article table to the database
		if (!$message->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		
		$this->_message	=& $message;

		$this->send();

		return true;
	}
	
	function send() {
		$mail = &JFactory::getMailer();
		
		$sender 	= new JUser($this->_message->from);
		$receiver 	= new JUser($this->_message->to);
		
		# JTPL HACK HERE
		// default behaviour changed
		// reciever is always a client's coach
		// so remove any selection and set it to the coach
		
		// check the view for what has been done
		
		# JTPL HACK ends
		
		$mail->setSender(array($sender->email, $sender->name));
		$mail->addRecipient($receiver->email);
		$mail->setSubject($this->_message->subject);
		$mail->setBody($this->_message->body);
		
		$mail->send();
		
	}
	
	function getTotal() {
		$where = $this->_buildWhere();

		$query = 'SELECT COUNT(*) '.
				' FROM #__jf_messages AS m' .
				' LEFT JOIN #__users AS u ON u.id = m.to '.
				' LEFT JOIN #__users AS v ON v.id = m.from '.
				$where;
		$this->_db->setQuery($query);
		$total = $this->_db->loadResult();
		
		return $total;
		
	}
	
	function listMessages() {	
	
		$limit = JRequest::getVar('limit', 0);
		$limitstart = JRequest::getVar('limitstart', 0);
	
		$where = $this->_buildWhere();

		$query = 'SELECT m.*, u.name AS toname, v.name AS fromname, t.id AS `to`, f.id AS `from` '.
				' FROM #__jf_messages AS m' .
				' INNER JOIN #__users AS u ON u.id = m.to '.
				' INNER JOIN #__jf_persons AS t ON t.uid = m.to '.
				' INNER JOIN #__users AS v ON v.id = m.from '.
				' INNER JOIN #__jf_persons AS f ON f.uid = m.from '.
				$where;
				
		$messages = $this->_getList($query, $limitstart, $limit);
		for($i=0; $i<count($messages); $i++) :
			$m = $messages[$i];
			
			if ($this->_type == 'inbox') :
				$m->name = '<a href="'.JRoute::_('index.php?option=com_jforce&c=people&view=person&layout=person&id='.$m->from).'">'.$m->fromname.'</a>';
				$m->link = '<a href="'.JRoute::_('index.php?option=com_jforce&view=message&layout=message&id='.$m->id).'">'.$m->subject.'</a>';
				$m->delete = '<a href="javascript:deleteMessage(\''.$m->id.'\');">Delete</a>';
			else :
				$m->name = '<a href="'.JRoute::_('index.php?option=com_jforce&c=people&view=person&layout=person&id='.$m->to).'">'.$m->toname.'</a>';
				$m->link = '<a href="'.JRoute::_('index.php?option=com_jforce&view=message&layout=message&action=sent&id='.$m->id).'">'.$m->subject.'</a>';
				$m->read = 1;
				$m->delete = '';
			endif;			
		endfor;
		
        return $messages;
    }

	function _loadMessage()
	{
		global $mainframe;

		if(!$this->_id)
		{
			return false;
		}

		// Load the item if it doesn't already exist
		if (empty($this->_message))
		{

			// Get the WHERE clause
			$where	= $this->_buildWhere();

			$query = 'SELECT m.*, u.name AS toname, v.name AS fromname '.
				' FROM #__jf_messages AS m' .
				' LEFT JOIN #__users AS u ON u.id = m.to '.
				' LEFT JOIN #__users AS v ON v.id = m.from '.
					$where;
			$this->_db->setQuery($query);
			$this->_message = $this->_db->loadObject();

			if ($this->_type == 'inbox') :
				$this->_message->name = '<a href="'.JRoute::_('index.php?option=com_jforce&view=profile&layout=profile&id='.$this->_message->from).'">'.$this->_message->fromname.'</a>';
			else :
				$this->_message->name = '<a href="'.JRoute::_('index.php?option=com_jforce&view=profile&layout=profile&action=sent&id='.$this->_message->to).'">'.$this->_message->toname.'</a>';
			endif;

			if ($this->_message->read == '0' && $this->_message->to == $this->_uid) :
				$query = "UPDATE #__jf_messages SET `read` = '1' WHERE id = '".$this->_message->id."'";
				$this->_db->setQuery($query);
				$this->_db->query();
			endif;

			if ( ! $this->_message ) {
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
		$where = null;
	
		if($this->_id):
			$where .= ' WHERE m.id = '. (int) $this->_id;
		endif;
		
		if ($this->_type == 'inbox' && !$this->_id):
			$where .= ' WHERE m.to = '.(int)$this->_uid;
		elseif($this->_type == 'sent' && !$this->_id) :
			$where .= ' WHERE m.from = '.(int)$this->_uid;
		endif;
		
		$where .= ' ORDER BY m.created DESC';
		
		return $where;
	}	
	
	function buildLists() {
	
		$lists = array();
		
		$people = $this->getRelatedPersons();
		
		# JTPL HACK
		# display members only when user type is coach
		# if client display coach only
        // new method has been added
        // buildListsForClient
		
		foreach($people as $p){
		}		

		
		$to_options[] = JHTML::_('select.option', '', '-- Select a User --');
		
		for ($i=0; $i<count($people); $i++) :
			$p = $people[$i];
			
			if ($i == 0) :
				$to_options[] = JHTML::_('select.optgroup', $p->companyname);
			elseif ($p->company != $people[$i-1]->company) :
				$to_options[] = JHTML::_('select.optgroup', $p->companyname);
			endif;
			
			$to_options[] = JHTML::_('select.option', $p->id, $p->name);
		endfor;
	
		$lists['to'] = JHTML::_('select.genericlist', $to_options, 'to', 'class="inputbox"', 'value', 'text');
	
		return $lists;
	}

    # JTPL HACK    
    function getCoachEmail() {
        
        $user = &JFactory::getUser();
        $employees     = array();
        
        $cid = $user->person->companyid;
        
        $query = "SELECT DISTINCT(u.id), u.name, p.company, c.name AS companyname".
                " FROM #__jf_persons AS p".
                " LEFT JOIN #__users AS u ON u.id = p.uid".
                " LEFT JOIN #__jf_companies AS c ON c.id = p.company".
                " WHERE c.id = '$cid'".
                " AND u.id <> '$user->id'".
                " AND c.owner = u.id"
                ;
        $this->_db->setQuery($query);
        $employees = $this->_db->loadObjectList();        
        return $employees;
        
    }
    
    function get_coach_client_messages($coach_id,$client_id){

        $query = 'SELECT * FROM #__jf_messages WHERE ('
                .$this->_db->nameQuote("from")." = ".$this->_db->Quote($client_id)." OR "
                .$this->_db->nameQuote("to")." = ".$this->_db->Quote($client_id).") AND ("
                .$this->_db->nameQuote("from")." = ".$this->_db->Quote($coach_id)." OR "
                .$this->_db->nameQuote("to")." = ".$this->_db->Quote($coach_id)
                .") ORDER BY created DESC LIMIT 10";
                
        $this->_db->setQuery($query);
        $this->_db->query();        
        return $this->_db->loadObjectList();
    }
    
    function buildListsForClient($companyid) {
    
        $lists = array();
        $people = $this->getCoachEmail();
        
        for ($i=0; $i<count($people); $i++) :        
            $p = $people[$i];
            
            if ($i == 0) :
                $to_options[] = JHTML::_('select.optgroup', $p->companyname);
            elseif ($p->company != $people[$i-1]->company) :
                $to_options[] = JHTML::_('select.optgroup', $p->companyname);
            endif;
            
            $to_options[] = JHTML::_('select.option', $p->id, $p->name);
        endfor;
    
        $lists['to'] = JHTML::_('select.genericlist', $to_options, 'to', 'class="inputbox"', 'value', 'text');
    
        return $lists;
    }
    
    # JTPL HACK ends
	
	
	function getRelatedPersons() {
		$user = &JFactory::getUser();
		$employees 	= array();
		$others		= array();
		
		# JTPL HACK
		//echo "<pre>";
		//print_r($user);
		//die();
		# JTPL HACK ENDS
		
		$cid = $user->person->companyid;
		
		$query = "SELECT DISTINCT(u.id), u.name, p.company, c.name AS companyname".
				" FROM #__jf_persons AS p".
				" LEFT JOIN #__users AS u ON u.id = p.uid".
				" LEFT JOIN #__jf_companies AS c ON c.id = p.company".
				" WHERE c.id = '$cid'".
				" AND u.id <> '$user->id'"
				;
		$this->_db->setQuery($query);
		$employees = $this->_db->loadObjectList();
		
		$query = "SELECT c.pid ".
				" FROM #__jf_projectroles_cf AS c ".
				" LEFT JOIN #__jf_projects AS p ON p.id = c.pid ".
				" WHERE c.uid = '$user->id' ".
				" AND p.published = 1"
				;
		$this->_db->setQuery($query);
		$projects = $this->_db->loadResultArray();
		
		if (!empty($projects)) :
			$ids = "cf.pid = '".implode("' OR cf.pid = '",$projects)."'";
			$query = "SELECT DISTINCT(u.id), u.name, p.company, c.name AS companyname".
					" FROM #__jf_projectroles_cf AS cf".
					" LEFT JOIN #__users AS u ON cf.uid = u.id".
					" LEFT JOIN #__jf_persons AS p ON p.uid = u.id".
					" LEFT JOIN #__jf_companies AS c ON c.id = p.company".
					" WHERE p.published = 1".
					" AND u.block = 0".
					" AND c.published = 1".
					" AND p.company <> '$cid'".
					" AND ($ids)".
					" GROUP BY p.company".
					" ORDER BY c.admin DESC, c.name ASC"
					;
					
			$this->_db->setQuery($query);
			$others = $this->_db->loadObjectList();
		endif;
	
		$people = array_merge($employees, $others);
	
		return $people;
	}	
	
}
?>
