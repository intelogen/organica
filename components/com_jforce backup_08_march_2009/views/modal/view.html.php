<?php 

/************************************************************************************
*	@package		Joomla															*
*	@subpackage		jForce, the Joomla! CRM											*
*	@version		2.0																*
*	@file			view.html.php													*
*	@updated		2008-12-15														*
*	@copyright		Copyright (C) 2008 - 2009 Extreme Joomla. All rights reserved.	*
*	@license		GNU/GPL, see jforce.license.php									*
************************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view'); 

class JforceViewModal extends JView {
	
function display($tpl = null) {
        global $mainframe;

		$layout = $this->getLayout();
	
		if ($layout == 'editdescription') {
			$this->_editDescription($tpl);
			return;	
		}
		
		if ($layout == 'quickadd') {
			$this->_quickAdd($tpl);
			return;	
		}
		
		if ($layout == 'addpeople') {
			$this->_addPeople($tpl);
			return;	
		}
		
		if($layout == 'profilepic') {
			$this->profilepic($tpl);
			return;
		}
		
		if($layout == 'wizard1') {		
			$this->_wizard1($tpl);
			return;
		}
		
		if($layout == 'wizard2') {		
			$this->_wizard2($tpl);
			return;
		}	
		if($layout == 'wizard3') {		
			$this->_wizard3($tpl);
			return;
		}	
		if($layout == 'wizard4') {		
			$this->_wizard4($tpl);
			return;
		}
		
		if($layout == 'editpermissions') {		
			$this->_editpermissions($tpl);
			return;
		}

		JHTML::_('behavior.mootools');
		
		$doc = &JFactory::getDocument();
		
		$doc->addScript('components/com_jforce/js/jforce.js');
		$js = "window.addEvent('domready', function() {
													
			loadSelectedUsers();
													
			$('selectMove').addEvent('click', function() {
				selectOptions();							   
			});
			
			$('saveButton').addEvent('click', function() {
				saveSubscriptions();
				window.parent.$('sbox-window').close();
			});
			
			$('cancelButton').addEvent('click', function() {
				window.parent.$('sbox-window').close();
			});
			
			$$('#unsubSelect option').addEvent('dblclick',function() {
					moveOption(this);
			});
			
		});
		";
		
		$doc->addScriptDeclaration($js);
		
        $model = &$this->getModel();
		$lists = $model->buildSubscriptionLists();
		$action = JRequest::getVar('action');
		$id = JRequest::getVar('id');
		$pid = JRequest::getVar('pid');
		$type = JRequest::getVar('type');
		
		$this->assignRef('lists', $lists);
		$this->assignRef('action', $action);
		$this->assignRef('id', $id);
		$this->assignRef('pid', $pid);
		$this->assignRef('type', $type);
        
        parent::display($tpl);		
	}	
	
		
	function _quickAdd($tpl) {
        

		parent::display($tpl);		
	}
	
	function _addPeople($tpl) {
	
		JHTML::_('behavior.mootools');
		
		$doc = &JFactory::getDocument();
		
		$doc->addScript('components/com_jforce/js/jforce.js');
		$js = "window.addEvent('domready', function() {
													
			initProjectRoles();
													
			$('selectMove').addEvent('click', function() {
				selectOptions();							   
			});
			
			$('saveButton').addEvent('click', function() {
				$('addPeopleForm').submit();
			});
			
			$('cancelButton').addEvent('click', function() {
				window.parent.$('sbox-window').close();
			});
			
			$$('#unsubSelect option').addEvent('dblclick',function() {
					moveOption(this);
			});
			
		});
		";
		
		$doc->addScriptDeclaration($js);
		
        $model = &$this->getModel();
		$peopleList = $model->buildPeopleList();
		$lists = $model->buildLists();
		
		$accessModel = JModel::getInstance('Accessrole', 'JForceModel');
		$roleOptions = $accessModel->buildProjectRoleOptions();
		$action = JRequest::getVar('action');
		$id = JRequest::getVar('id');
		$pid = JRequest::getVar('pid');
		$type = JRequest::getVar('type');
		
		$this->assignRef('peopleList', $peopleList);
		$this->assignRef('lists', $lists);
		$this->assignRef('action', $action);
		$this->assignRef('id', $id);
		$this->assignRef('pid', $pid);
		$this->assignRef('type', $type);
		$this->assignRef('roleOptions', $roleOptions);
        
        parent::display($tpl);		
	
	}
	
	function profilepic($tpl) {

		$document =& JFactory::getDocument();
		
		$js = "window.addEvent('domready',function() {
					$('saveButton').addEvent('click', function() {
						
						$('uploadForm').submit();
					});
			});";
	
		$document->addScriptDeclaration($js);

		$id = JRequest::getVar('id');
		$model = JRequest::getVar('model');
		
		$this->assignRef('id',$id);
		$this->assignRef('model',$model);
	
		parent::display($tpl);
	}
	
	
	function _wizard1($tpl) {
	
		$document =& JFactory::getDocument();
		
		$js = "window.addEvent('domready',function() {

				$('cancel').addEvent('click', function() {
						closeModal();
				});
			});";
	
		$document->addScriptDeclaration($js);
	
		$model =& JModel::getInstance('Person','JForceModel');
		
		$lead = $model->getPerson();
		$lists = $model->buildLists();
		
		$this->assignRef('lists',$lists);
		$this->assignRef('lead',$lead);
		$this->assignRef('lists',$lists);
		
		parent::display($tpl);
	}

	function _wizard2($tpl) {
		
	$document =& JFactory::getDocument();
	
	$js = "window.addEvent('domready',function() {
			$('back').addEvent('click',function() {
					window.history.go(-1);
				});
			
				$('company').addEvent('change',function() {
					var id = $('company').value;
					prefillCompanyFields(id);		
				});
		});";

	$document->addScriptDeclaration($js);

	$model =& JModel::getInstance('Person','JForceModel');
	$personId = JRequest::getVar('person');
	
	$model->setId($personId);
	$model->setPid(null);
	$person = $model->getPerson();
	$lists = $model->buildLists();
	
	$this->assignRef('lists',$lists);
	$this->assignRef('person',$person);
	$this->assignRef('lists',$lists);
	
	parent::display($tpl);
	}

	function _wizard3($tpl) {
		
	$document =& JFactory::getDocument();
	
	$js = "window.addEvent('domready',function() {
			$('back').addEvent('click',function() {
					window.history.go(-1);
				});
			
			//	$('project').addEvent('change',function() {
			//		var pid = $('project').value;
			//		prefillProjectFields(pid);		
			//	});
		});";

	$document->addScriptDeclaration($js);
	
	$personId = JRequest::getVar('person');
	$model =& JModel::getInstance('Person','JForceModel');
	$model->setId($personId);
	$person = $model->getPerson();
	$lists = $model->buildLists();
	
	$this->assignRef('lists',$lists);
	$this->assignRef('person',$person);
	$this->assignRef('lists',$lists);
	
	parent::display($tpl);
	}

	function _wizard4($tpl) {
		
	$document =& JFactory::getDocument();
	
	$js = "window.addEvent('domready',function() {
			$('back').addEvent('click',function() {
					window.history.go(-1);
				});
			$('complete').addEvent('click', function() {
					closeModal();
				});
			
			initProjectRoles();
			
		});";

	$document->addScriptDeclaration($js);

	$id = JRequest::getVar('person');

	$model =& JModel::getInstance('Person','JForceModel');
	$model->setId($id);
	$model->setUserid(null);
	$model->setPid(null);
	$person = $model->getPerson();
	
	$pid = JRequest::getVar('pid');
		
	$lists = $model->buildLists();
	
	$this->assignRef('pid',$pid);
	$this->assignRef('person',$person);
	$this->assignRef('lists',$lists);
	
	parent::display($tpl);
	}
	
	function _editpermissions($tpl) {
		
	$document =& JFactory::getDocument();
	
	$js = "window.addEvent('domready',function() {
			$('back').addEvent('click',function() {
					window.parent.$('sbox-window').close();
				});
			$('complete').addEvent('click', function() {
					
				});
			
			initProjectRoles();
			toggleCustomProjectRoles();	
		});";

	$document->addScriptDeclaration($js);

	$id = JRequest::getVar('id');
	$pid = JRequest::getVar('pid');
	
	$model =& JModel::getInstance('Person','JForceModel');
	$model->setId($id);
	$model->setUserid(null);
	$model->setPid(null);
	$person = $model->getPerson();
	
	$accessroleModel = &JModel::getInstance('Accessrole', 'JForceModel');
	$accessroleModel->setId(null);
	
	$options = $accessroleModel->buildProjectRoleOptions($person->uid, $pid);
	$lists['projectroles'] = JforceListsHelper::getAccessRoleList($accessroleModel->_role_id);
	
	$this->assignRef('pid',$pid);
	$this->assignRef('person',$person);
	$this->assignRef('lists',$lists);
	$this->assignRef('options',$options);
	
	parent::display($tpl);
	}
	
	function _editDescription($tpl) {
	
		$i = JRequest::getVar('i', '0');
		$document =& JFactory::getDocument();
	
		$js = "window.addEvent('domready',function() {
			editDescription('".$i."');
			
			$('saveButton').addEvent('click', function() {
				saveDescription();										   
			});
			
			$('cancelButton').addEvent('click', function() {
				closeModal();										   
			});
		});";

		$document->addScriptDeclaration($js);
		
		$this->assignRef('i', $i);
	
		parent::display($tpl);
	}
	
}