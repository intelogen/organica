<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class igalleryViewigallery extends JView
{
	function __construct( $config = array() )
	{
 		parent::__construct($config);
	}
 
	function display($tpl = null)
	{
		global $mainframe;
		
		//get the configeration paramaters
		$configArray =& JComponentHelper::getParams('com_igallery');
		
		//check whether front end gallery creation has been allowed 
		$allowFrontend = $configArray->get('allow_frontend_creation', 0);
		if($allowFrontend == 0)
		{
			echo JText::_('RESTRICTED ACCESS');
			return;
		}
		
		//if the user is a guest, they must login to make a gallery
		$user   =& JFactory::getUser();
		if( $user->get('guest') )
		{
			echo JText::_('PLEASE LOGIN TO VIEW');
			return;
		}
		
		//get the galleries from our igallery model in the backend
		$galleries	=& $this->get('Galleries');
		
		jimport('joomla.environment.uri' );
		$host = JURI::root();
		
		//we need to put the item id into any subsequent frontend links
		$itemId = JRequest::getInt('Itemid', '');
		
		//add the admintable css, this is more or less taken from Joomlas backend template css
		$document =& JFactory::getDocument();
		$document->addStyleSheet($host.'components/com_igallery/css/admintable.css');
		
		//we dont have the backend js, so we need this in the head to the save order button will submit
		$submitFormJs = '
		function submitform()
		{
		  document.igalleryForm.submit();
		}
		';
		$document->addScriptDeclaration($submitFormJs);
		
	 	//assign vars and display
		$this->assignRef('galleries',$galleries);
		$this->assignRef('host',$host);
		$this->assignRef('itemId', $itemId);
	  	parent::display($tpl);
  }
}
?>
