<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'base.php');

class igalleryVIEWedit extends igalleryVIEWbase
{

	function display($tpl = null)
	{
		global $mainframe;
		
		//get this gallery's data from the edit model
		$gallery =& $this->get('Gallery');
		
		//get the category select list from the base model
		$catList =& $this->get('CatList');
		
		//get all of our radio boxes/ textareas/ select lists etc
		//this function is in our base view class
		$lists = $this->getEditFormElements($gallery);
		
		//set the toolbar buttons
    	JToolBarHelper::title( JText::_('EDIT GALLERY').' - '.$gallery->name,'generic.png' );
		JToolBarHelper::apply();
		JToolBarHelper::custom('save_changes','save', '',JText::_('SAVE'), false);
		JToolBarHelper::cancel();
		
		
		jimport('joomla.environment.uri' );
		$host = JURI::root();
		
		//the defualt.php file will show everything if $backend is true, but only allowed bits, if backend is false
		$backend = true;
		
		$configArray =& JComponentHelper::getParams('com_igallery');
		
		//assign vars and display
		$this->assignRef('gallery',$gallery);
		$this->assignRef('catList',	$catList);
		$this->assignRef('lists',$lists);			
		$this->assignRef('host',$host);
		$this->assignRef('backend',	$backend);
		$this->assignRef('configArray',	$configArray);
		
		parent::display($tpl);
	}
	
}	

?>
