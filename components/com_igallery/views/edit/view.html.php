<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'base.php');

class igalleryVIEWedit extends igalleryVIEWbase
{

	function display($tpl = null)
	{
		global $mainframe;	
    	
		//if front end gallery creation is disabled, return
		$configArray =& JComponentHelper::getParams('com_igallery');
		$allowFrontend = $configArray->get('allow_frontend_creation', 0);
		if($allowFrontend == 0)
		{
			echo JText::_('RESTRICTED ACCESS');
			return;
		}
		
		//if they are a guest return
		$user   =& JFactory::getUser();
		if( $user->get('guest') )
		{
			echo JText::_('PLEASE LOGIN TO VIEW');
			return;
		}
		
		//get the gallery data from our edit model in the backend
		$gallery =& $this->get('Gallery');
		
		//get the category list from the base model
		$catList	=& $this->get('CatList');
		
		//if this is not the users gallery, and the front end user is not allowed to 
		//edit all galleries, return
		$allowEditAll = $configArray->get('frontend_edit_all', 0);
		if( $user->id != $gallery->user && $allowEditAll != 1)
		{
			echo JText::_('RESTRICTED ACCESS');
			return;
		}
		
		//get the html form elements from the base view
		$lists = $this->getEditFormElements($gallery);
		
		jimport('joomla.environment.uri' );
		$host = JURI::root();
		
		$itemId = JRequest::getInt('Itemid', '');
		
		//our template file will include the backend template file, which needs to know
		//if we are in the front end or backend
		$backend = false;
		
		//assign vars and display
		$this->assignRef('configArray',	$configArray);
		$this->assignRef('gallery',$gallery);
		$this->assignRef('catList',	$catList);			
		$this->assignRef('lists',$lists);
		$this->assignRef('host',$host);
		$this->assignRef('itemId', $itemId);
		$this->assignRef('backend',	$backend);
		parent::display($tpl);
	}
	
}	

?>
