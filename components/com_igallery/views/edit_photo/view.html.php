<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class manageVIEWedit_photo extends JView
{
	function display($tpl = null)
	{
		global $mainframe;
		
		//if front end creation is disabled, return
		$configArray =& JComponentHelper::getParams('com_igallery');
		$allowFrontend = $configArray->get('allow_frontend_creation', 0);
		if($allowFrontend == 0)
		{
			echo JText::_('RESTRICTED ACCESS');
			return;
		}
		
		//if they are a guest, return
		$user   =& JFactory::getUser();
		if( $user->get('guest') )
		{
			echo JText::_('PLEASE LOGIN TO VIEW');
			return;
		}
		
		//get the data from the edit_photo model
		$gallery =& $this->get('Gallery');
		$photo =& $this->get('Photo');
		
		//if this gallery does not belong to the user, and editing all galleries is not allowed, return
		$allowEditAll = $configArray->get('frontend_edit_all', 0);
		if( $user->id != $gallery->user && $allowEditAll != 1)
		{
			echo JText::_('RESTRICTED ACCESS');
			return;
		}
		
		jimport('joomla.environment.uri' );
		$host = JURI::root();
		
		$itemId = JRequest::getInt('Itemid', '');
		
		//assign vars and display
		$this->assignRef('gallery',$gallery);
		$this->assignRef('photo',$photo);
		$this->assignRef('host',$host);
		$this->assignRef('itemId', $itemId);
		parent::display($tpl);
	}
	
}	

?>
