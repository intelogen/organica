<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class igalleryViewigallery extends JView
{
 	function display($tpl = null)
	{
	 	global $mainframe, $option;
		
	 	//add all the toolbar buttons
		JToolBarHelper::title( JText::_( 'IGNITE GALLERY' ), 'generic.png' );
		JToolBarHelper::custom('add', 'new', '', JText::_( 'NEW GALLERY' ),false );
		JToolBarHelper::custom('cat_new', 'copy', '', JText::_( 'NEW CATEGORY' ),false );
		JToolBarHelper::custom('comments', 'edit', '', JText::_( 'COMMENTS' ),false );
		JToolBarHelper::custom('rating', 'default', '', JText::_( 'RATINGS' ),false );
		JToolBarHelper::preferences('com_igallery', 500);
		
		//get the filter by column and direction, so we can put in into the form, so it gets sent on the next form submit
		$filter_order     = $mainframe->getUserStateFromRequest( $option.'filter_order', 'filter_order', 'ordering', 'cmd' );
  		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', '', 'word' );
		
  		$lists = array();
  		$lists['order_Dir'] = $filter_order_Dir;
  		$lists['order'] = $filter_order;
  		
  		//get all the categories/galleries from the igallery model
  		$items	=& $this->get('Data');
  		
  		//get the pagination stuff from the igallery model
		$total =& $this->get('Total');
  		$pagination =& $this->get('Pagination');
  		
  		//assign the vars to our template file
	    $this->assignRef('lists',$lists);    
	  	$this->assignRef('items',$items);
	  	$this->assignRef('pagination',$pagination);
	    
	    parent::display($tpl);
  }
}
?>
