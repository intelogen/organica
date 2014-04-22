<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'base.php');

//we need to extend our base view, as we will be using a function in it
class igalleryVIEWadd extends igalleryVIEWbase
{
	function display($tpl = null)
	{
		global $mainframe;
		
		//get the component paramaters
		$configArray =& JComponentHelper::getParams('com_igallery');
		
		//if frontend gallery creation is not allawed return
		$allowFrontend = $configArray->get('allow_frontend_creation', 0);
		if($allowFrontend == 0)
		{
			echo JText::_('RESTRICTED ACCESS');
			return;
		}
		
		//guests must login to create a gallery
		$user   =& JFactory::getUser();
		if( $user->get('guest') )
		{
			echo JText::_('PLEASE LOGIN TO VIEW');
			return;
		}
		
		//get all our html form elements from our base view
		$lists = $this->getNewFormElements();
		
		//get our cat list from the base model in the backend
		$catList	=& $this->get('CatList');
		
		//we need the item id for any links
		$itemId = JRequest::getInt('Itemid', '');
		
		//our template file will include the backend template file, which needs to know
		//if we are frontend/ backend
		$backend = false;
		
		$this->assignRef('configArray',	$configArray);
		$this->assignRef('lists',$lists);
		//the get new form elements function returns config params, and html form stuff
		$this->assignRef('configParams',$lists['configParams']);
		$this->assignRef('catList',	$catList);
		$this->assignRef('itemId', $itemId);
		$this->assignRef('backend',	$backend);
		
		parent::display($tpl);
	}
	
}	

?>
