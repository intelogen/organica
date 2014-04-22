<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'base.php');

class igalleryVIEWcat_edit extends igalleryVIEWbase
{
	function __construct( $config = array())
	{
 		parent::__construct( $config );
	}
	
	function display($tpl = null)
	{
		global $mainframe;	
    	
		//set the toolbar items
    	JToolBarHelper::title(JText::_('EDIT').' '.JText::_('CATEGORY'),'generic.png');
    	JToolBarHelper::custom('cat_apply', 'apply', '', JText::_( 'APPLY' ),false );
		JToolBarHelper::custom('cat_save', 'save', '', JText::_( 'SAVE' ),false );
		JToolBarHelper::cancel();
		
		jimport('joomla.environment.uri' );
		$host = JURI::root();
		
		//get the category data from our cat_edit model
		$category	=& $this->get('Cat');
		
		//the the category select list from the base model
		$parentList =& $this->get('CatList');
		
		//make some html form elements
		$lists = array();
		
		$lists['show_parent'] = JHTML::_('select.booleanlist',  'show_cat_menu', 'class="inputbox"', $category->show_cat_menu );
		
		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $category->published );
		
		$lists['access'] = JHTML::_('list.accesslevel',  $category);
		
		$lists['remove_menu_image'] = JHTML::_('select.booleanlist',  'remove_menu_image', 'class="inputbox"', 0 );
		
		//assign vars and display
		$this->assignRef('host',$host);
		$this->assignRef('category',	$category);
		$this->assignRef('parentList',	$parentList);
		$this->assignRef('lists',$lists);
		
		parent::display($tpl);
	}
}	


?>
