<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'base.php');

class igalleryVIEWcat_new extends igalleryVIEWbase
{
	function __construct( $config = array())
	{
 		parent::__construct( $config );
	}
	
	function display($tpl = null)
	{
		global $mainframe;	
    	
		//add the toolbar buttons
    	JToolBarHelper::title(JText::_('NEW').' '.JText::_('CATEGORY'),'generic.png');
		JToolBarHelper::custom('cat_save', 'save', '', JText::_( 'SAVE' ), false );
		JToolBarHelper::cancel();
		
		//get the list of categories from the select box, this is in models/base.php
		$parentList =& $this->get('CatList');
		
		//get the default paramaters and make some html form elements
		$configArray =& JComponentHelper::getParams( 'com_igallery' );
		
		$lists = array();
		$configParams = array();
		
		$configParams['cat_max_width'] = $configArray->get('cat_max_width', 200);
		
		$configParams['cat_max_height'] = $configArray->get('cat_max_height', 150);
		
		$configParams['cat_show_parent'] = $configArray->get('cat_show_parent', 0);
		$lists['show_cat_menu'] = JHTML::_('select.booleanlist',  'show_cat_menu', 'class="inputbox"', $configParams['cat_show_parent'] );
		
		$configParams['cat_menu_columns'] = $configArray->get('cat_menu_columns', 2);
		
		$access = new stdClass(); 
		$access->access = 0;
		$lists['access'] = JHTML::_('list.accesslevel',  $access);
		
		$configParams['cat_published'] = $configArray->get('cat_published', 0);
		$lists['published'] = JHTML::_('select.booleanlist',  'published', 'class="inputbox"', $configParams['cat_published'] );
		
		
		//assign vars and display
		$this->assignRef('lists',$lists);
		$this->assignRef('configParams',$configParams);
		$this->assignRef('parentList',	$parentList);
		
		parent::display($tpl);
	}
}	


?>
