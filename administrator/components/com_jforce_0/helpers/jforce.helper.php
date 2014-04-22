<?php

/********************************************************************************
*	@package		Joomla														*
*	@subpackage		jForce, the Joomla! CRM										*
*	@version		2.0															*
*	@file			jforce.helper.php											*
*	@updated		2008-12-15													*
*	@copyright		Copyright (C) 2008 - 2009 JoomPlanet. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php								*
********************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
// Component Helper
jimport('joomla.application.component.helper');


class JForceHelper {
	
	function getDaysDate($date, $style = true) {
		$day = 86400;
		$today = time();
		$date = date('Y-m-d',strtotime($date));
		$date = strtotime($date);
		
		$days = floor(($today-$date)/$day);
		
		switch($days) {
			case 0:
			case -1:
			$html = JText::_('Today');
			break;
			
			case 1:
			$html = JText::_('Yesterday');
			break;
			
			default:
				if($days > 30 ):
					$months = floor($days/30);
					if($months==1):
						$html = $months.' '.JText::_('Month Ago');
					else:
						$html = $months.' '.JText::_('Months Ago');
					endif;
				elseif($days < -1):
					if(!$style):
						$html = JText::_('Due in')." ". abs($days) ." ".JText::_('Days');
					else:
						$html = "<span class='upcoming'>".JText::_('Due in')." ". abs($days) ." ".JText::_('Days')."</span>";
					endif;
				else:
					if(!$style):
						$html = $days." ".JText::_('Days Ago')."</span>";
					else:
						$html = "<span class='late'>".$days." ".JText::_('Days Late')."</span>";
					endif;
				endif;
			break;
		}
    return $html;
	}

	function getObjectStatus($object, $type)
	{
		$user 		= JFactory::getUser();
		$database 	= JFactory::getDBO();
		
		$query = "SELECT COUNT(*) FROM #__jf_objectviews ".
				 " WHERE object='$object' ".
				 " AND type='$type' ".
				 " AND uid='$user->id' ";
		$database->setQuery($query);

		$result = $database->loadResult();
		
		if(!$result):
			$read = true;
		else:
			$read = false;
		endif;
		
		return $read;
	}
	
	function setObjectStatus($object, $type)
	{
		$user 		= JFactory::getUser();
		$database 	= JFactory::getDBO();
		
		$item = JTable::getInstance('ObjectStatus', 'JTable');
		
		$item->uid = $user->get('id');
		$item->object = $object;
		$item->type = $type;

		$item->store();
	}

	function getInvoiceInterval($publish, $interval) {
		// Interval must be declared in days
		
		$interval = $interval*3600*24;
		
		$time = strtotime($publish) + $interval;
		
		$time = date("Y-m-d", $time);
		
		return $time;
	
	}
	
	function standardizeFields($original, $field = null)
	{
		$object = array();
		if ($original) :
		foreach ( $original as $key => $value ) : 
                
				$type = $key;
				
				if($value):
				foreach($value as $v) :
					
					switch($type) :
						case 'milestone':
							$title = $v->summary;
							$text = $v->notes;
							$completed = $v->completed;
							$duedate = $v->duedate;
						break;
						
						case 'checklist':
							$title = $v->summary;
							$text = $v->description;
							$completed = $v->completed;
							$duedate = null;
						break;
						
						case 'task':
							$title = $v->summary;
							$text = null;
							$completed = $v->completed;	
							$duedate = $v->duedate;
						break;
						
						case 'comment':
							$title = $v->message;
							$text = null;
							$completed = null;
							$duedate = null;
						break;
						
						case 'discussion':
							$title = $v->summary;
							$text = $v->message;
							$completed = null;
							$duedate = null;
						break;
						
						case 'ticket':
							$title = $v->summary;
							$text = $v->description;
							$completed = null;
							$duedate = null;
						break;
						
						case 'quote':
						case 'invoice':
						case 'document':
							$title = $v->name;
							$text = $v->description;
							$completed = null;
							$duedate = null;
						break;
						
					endswitch;
					
					$text = JForceHelper::snippet($text, 50);
					
					if($field):
						$object[$v->$field] = array(
							"type" => $type,
							"author" => $v->author,
							"link" => $v->link,
							"created" => $v->created,
							"title" => $title,
							"text" => $text,
							"completed" => $completed,
							"duedate" => $duedate
							);
					else:
						$object[$type] = array(
							"type" => $type,
							"author" => $v->author,
							"link" => $v->link,
							"created" => $v->created,
							"title" => $title,
							"text" => $text,
							"completed" => $completed,
							"duedate" => $duedate
							);
					endif;
				endforeach;
				endif;
				
        	endforeach;
		endif;
			
		return $object;
	}

	function sortArray($original,$field, $start = null)
        {
           $sortArr = array();
			
		   $new = JForceHelper::standardizeFields($original, $field);
		    
		   $items = array();
		   
			$seconds = 86400;
			$today = time();
			
			if($new):
				foreach ($new as $k=>$n) {
	
				$date = date('Y-m-d',strtotime($k));
				$date = strtotime($date);
				$days = floor(($today-$date)/$seconds);		
	
				$day = date("Y-m-d", strtotime($k));
						
				if($start):
					if($days < $start):
						$items[$day][] = $n;
					endif;
				else:
					$items[$day][] = $n;
				endif;
				
				}
			endif;			
			
			krsort($items);
            return $items;
        }    
		

		function snippet($text,$length=100,$tail="...") {
			$text = strip_tags($text);
			$text = trim($text);
			$txtl = strlen($text);
			if($txtl > $length) {
				for($i=1;$text[$length-$i]!=" ";$i++) {
					if($i == $length) {
						return substr($text,0,$length) . $tail;
					}
				}
				$text = substr($text,0,$length-$i+1) . $tail;
			}
			
			return $text;
		}
		
		function prepareTags($tags,$pid) {
			$tags = explode(',',$tags);
			for($i=0;$i<count($tags);$i++):
				$tag = $tags[$i];
				$link = JRoute::_('index.php?option=com_jforce&view=search&layout=results&pid='.$pid.'&keyword='.$tag);				
				$returnTags[] = '<a href='.$link.'>'.$tag.'</a>';
			endfor;

			$finalTags = implode(', ',$returnTags);
			
			return $finalTags;
		
		}
		
		function prepareAssignees($assignees) {
			for($i=0;$i<count($assignees);$i++):
				$a = $assignees[$i];
				$link = JRoute::_('index.php?option=com_jforce&view=person&layout=person&id='.$a->person_id);				
				$returnTags[] = '<a href='.$link.'>'.$a->name.'</a>';
			endfor;

			$finalTags = implode(', ',$returnTags);
			
			return $finalTags;
		}
		
		function getFilesize($filesize)
		{
			if($filesize < 1000):
				$size = $filesize."b";
			elseif($filesize >= 1000 and $filesize < 1000000):
				$size = round($filesize / 1000,2) ."kb";
			else:
				$size = round($filesize / 1000000, 2) ."mb";
			endif;
			
			return $size;
		}
		
		function getPagination($model) {
			
			$limit		 	= JRequest::getVar('limit', 0);
			$limitstart		= JRequest::getVar('limitstart', 0);
	
			$total = $model->getTotal();
			
			if (!$limit) :
				$limit = 10;
				JRequest::setVar('limit', $limit, 'get');
			endif;
	
			jimport('joomla.html.pagination');
			$pagination = new JPagination($total, $limitstart, $limit);
		
			return $pagination;
		}
        
		function notAuth() {
			global $mainframe;
			$url = JRoute::_('index.php?option=com_jforce');
			$msg = JText::_('You are not authorized to view this resource.');
			$mainframe->redirect($url, $msg);
		}
		
		function lockOut() {
			global $mainframe;
			$url = 'index.php';
			$msg = JText::_('You are not authorized to view this resource.');
			$mainframe->redirect($url, $msg);
		}
		
		function loginRedirect() {
			global $mainframe;
			$uri = &JFactory::getURI();
			$return = base64_encode($uri->toString());
			$url = JRoute::_('index.php?option=com_user&view=login&return='.$return);
			$msg = JText::_('Please login.');
			$mainframe->redirect($url, $msg);	
		}
		
		function generateKey() {
			$key = md5(md5(uniqid().time()));
			return $key;
		}
		
		function loadComments($type, $object) {
			
			$document = &JFactory::getDocument();
			$js = "window.addEvent('domready', function() {
						$('addAttachment').addEvent('click', function(e) {
							new Event(e).stop();

							addAttachment();											  
						});
					});";
			
			$document->addScriptDeclaration($js);
			
			$commentModel = &JModel::getInstance('Comment', 'JforceModel');
			$commentModel->setId(null);
			$commentModel->setType($type);
			$commentModel->setObjectid($object->id);
			
			$pagination = JForceHelper::getPagination($commentModel);
			$comments = $commentModel->listComments();
			$title = JText::_('Reply to '.ucwords($type));
			$showMain = $pagination->get('pages.current')==1 ? true : false;
			
			$config['name'] = 'comment';
			$commentView = new JView($config);
			$commentView->assignRef('comments', $comments);
			$commentView->assignRef('id', $object->id);
			$commentView->assignRef('pid', $object->pid);
			$commentView->assignRef('type', $type);
			$commentView->assignRef('pagination', $pagination);
			$commentView->assignRef('showMain', $showMain);
			$commentView->assignRef('title', $title);
			
			return $commentView;
		}

	function trashItem($data)
	{
		$table = $data['model'];
		$id = $data['id'];
		$item = JTable::getInstance(ucfirst($table), 'JTable');
		$item->load($id);
		$item->published = -1;
		$item->store();
		
		return true;
	}
	
	function getTrashLink($object, $model)
	{
		$c = JRequest::getVar('c','project');
		
		if($model=='project'):
			$object->pid = $object->id;
		endif;
		
		if ($model == 'task') :
			$url = 'index.php?option=com_jforce&view=checklist&layout=checklist&id='.$object->cid;
		else :
			$url = 'index.php?option=com_jforce&view='.$model;
		endif;
		
		if ($c == 'project') :
			$url .= '&pid='.$object->pid;
		endif;
		 
		$link  = "<form action='index.php' method='post' name='adminForm' onsubmit='return confirmDelete();'>";

	  	$link .= "<button class='inlineTab' /><span>".JText::_('Trash ' . ucfirst($model))."</span></button>";
        $link .= "<input type='hidden' name='id' value='".$object->id."' />";
		if($c=='project'):
			$link .= "<input type='hidden' name='pid' value='".$object->pid."' />";
		endif;
        $link .= "<input type='hidden' name='option' value='com_jforce' />";
        $link .= "<input type='hidden' name='task' value='trash' />";
      	$link .= "<input type='hidden' name='model' value='".$model."' />";
        $link .= "<input type='hidden' name='ret' value='".JRoute::_($url)."' />";
        $link .= "<input type='hidden' name='".JUtility::getToken()."' value='1' />";
       	$link .= "</form>";
		
		return $link;
	}
	
	function validateObject($object, $fields) {
		global $mainframe;
		$missing = array();
		
		for($i=0; $i<count($fields); $i++) :
			$f = $fields[$i];
			if (!$object->$f) :
				$pass = false;
				$missing[] = $f;
			endif;
		endfor;
		
		if (!empty($missing)) :
			$return = $_SERVER['HTTP_REFERER'];
			$msg = JText::_('Please fill out all required fields:');
			$mainframe->enqueueMessage($msg, 'error');
			foreach ($missing as $m) :
				$mainframe->enqueueMessage(JText::_($m), 'error');
			endforeach;
			$mainframe->redirect($return);
		endif;
		
	}
	
	function initValidation($fields) {
		
		$fields = "'".implode("','",$fields)."'";
		
		$document = &JFactory::getDocument();
		$js = "window.addEvent('domready', function() {
					var requiredFields = new Array(".$fields.");
					
					$$('input, select, textarea').each(function(el) {
						var name = el.getProperty('name');
						
						if (in_array(name, requiredFields)) {
							el.addClass('required');
							
						}
						
					});
				
				});";
		$document->addScriptDeclaration($js);
	}

	function prepareSearchContent( $text, $length=200, $searchword ) {
      // strips tags won't remove the actual jscript
      $text = preg_replace( "'<script[^>]*>.*?</script>'si", "", $text );
      $text = preg_replace( '/{.+?}/', '', $text);
  
      //$text = preg_replace( '/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is','\2', $text );
  
      // replace line breaking tags with whitespace
      $text = preg_replace( "'<(br[^/>]*?/|hr[^/>]*?/|/(div|h[1-6]|li|p|td))>'si", ' ', $text );
  
      $text = JForceHelper::smartSubstr( strip_tags( $text ), $length, $searchword );
  
      return $text;
  }
  
	function smartSubstr($text, $length=200, $searchword) {
    	$wordpos = strpos(strtolower($text), strtolower($searchword));
		$halfside = intval($wordpos - $length/2 - strlen($searchword));
		if ($wordpos && $halfside > 0) {
		  return '...' . substr($text, $halfside, $length) . '...';
		} else {
		  return substr( $text, 0, $length);
		}
  }

}