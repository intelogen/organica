<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

//we are extending our base view class, which has some common view functions
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'base.php');

class igalleryVIEWadd extends igalleryVIEWbase
{
	function display($tpl = null)
	{
		global $mainframe;
		
		//add in the toolbar buttons
    	JToolBarHelper::title(JText::_('NEW GALLERY'),'generic.png');
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		
		//get the list of categories this gallery could go into
		//this function is in our base model
		$catList	=& $this->get('CatList');

		//get all of our radio boxes/ textareas/ select lists etc
		//this function is in our base view class
		$lists = $this->getNewFormElements();
		
		//the defualt.php file will show everything if $backend is true, but only allowed bits, if backend is false
		$backend = true;
		
		$configArray =& JComponentHelper::getParams('com_igallery');
		
		//assign vars and display
		$this->assignRef('catList',	$catList);
		$this->assignRef('lists', $lists);
		//the get new form elements function returns config params, and html form stuff
		$this->assignRef('configParams', $lists['configParams']);
		$this->assignRef('configArray',	$configArray);
		$this->assignRef('backend',	$backend);
		
		parent::display($tpl);
	}
	
}	

?>
