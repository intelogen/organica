
<?php 
// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view'); 

class JForceViewMessage extends JView {
	
function display($tpl = null) {
        global $mainframe;
		$layout = $this->getLayout();
		

		if ($layout == 'message') {
			$this->_displayMessage($tpl);
			return;	
		}

		if($layout == 'form') {
			$this->_displayForm($tpl);
			return;
		}			

		$user = &JFactory::getUser();

        $model = &$this->getModel();
		$pagination = JForceHelper::getPagination($model);
		$messages = $model->listMessages();
		
		
		$composeLink = '<a class="button" href="'.JRoute::_('index.php?option=com_jforce&view=message&layout=form').'">Compose</a>';
		
		if ($model->_type == 'inbox') :
			$title = 'My Inbox';
			$otherLink = '<a class="button" href="'.JRoute::_('index.php?option=com_jforce&view=message&action=sent').'">Sent Items</a>';
			$fromHeader = 'From';
		else:
			$title = 'My Sent Items';
			$otherLink = '<a class="button" href="'.JRoute::_('index.php?option=com_jforce&view=message').'">Inbox</a>';
			$fromHeader = 'To';
		endif;
		 
	
		$this->assignRef('messages', $messages);
		$this->assignRef('title', $title);
		$this->assignRef('composeLink', $composeLink);
		$this->assignRef('otherLink', $otherLink);
		$this->assignRef('fromHeader', $fromHeader);
		$this->assignRef('pagination', $pagination);

        
        parent::display($tpl);		
	}	
	
	
	function _displayMessage($tpl) {
        global $mainframe, $option;

		JHTML::_('behavior.modal');				

        $model = &$this->getModel();
		
        $message = &$model->getMessage();
        
		$composeLink = '<a class="button" href="'.JRoute::_('index.php?option=com_jforce&view=message&layout=form').'">Compose</a>';
		
		if ($model->_type == 'sent') :
			$otherLink = '<a class="button" href="'.JRoute::_('index.php?option=com_jforce&view=message&action=sent').'">Sent Items</a>';
			$fromHeader = 'To';
		else:
			$otherLink = '<a class="button" href="'.JRoute::_('index.php?option=com_jforce&view=message').'">Inbox</a>';
			$fromHeader = 'From';
		endif;
		
		$pathway =& $mainframe->getPathway();
		$pathway->addItem(JText::_('List Messages'), 'index.php?option=com_jforce&view=message');	
		$pathway->addItem(JText::_('Message'));	
		
        $this->assignRef('message', $message);
        $this->assignRef('option', $option);
		$this->assignRef('otherLink', $otherLink);
		$this->assignRef('composeLink', $composeLink);
		$this->assignRef('fromHeader', $fromHeader);

		parent::display($tpl);		
	}
	
	function _displayForm($tpl) {
		global $option, $mainframe;

		// Initialize variables
		$document	=& JFactory::getDocument();
        $user        =& JFactory::getUser();
		$uri		=& JFactory::getURI();	
        			
		// Load the JEditor object
		$editor =& JFactory::getEditor();

		// Initialize variables
        $model = &$this->getModel();
        
        // JTPL HACK
        // check user access role and build compose message lists accordingly
        if($user->person->accessrole=="Client"){
            $lists = $model->buildListsForClient($user->person->companyid);
        }else{        
            $lists = $model->buildLists();
        }
		
		// Build the page title string
		$title = JText::_('Write to your coach');

		$pathway =& $mainframe->getPathWay();
		$pathway->addItem($title, '');		
		
		$this->assign('action', 	$uri->toString());
		$this->assignRef('title',   $title);
		$this->assignRef('editor',	$editor);
		$this->assignRef('user',	$user);	
		$this->assignRef('lists',	$lists);	
		
		parent::display($tpl);			
	}
}
?>	
