<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class ratingViewrating extends JView
{
	function __construct( $config = array() )
	{
 		parent::__construct($config);
	}
 
	function display($tpl = null)
	{
	 	global $mainframe, $option;
		
	 	//set the toolbar buttons
		JToolBarHelper::title( JText::_( 'RATINGS' ), 'generic.png' );
		JToolBarHelper::custom('back_main','back', '',JText::_( 'MAIN MENU' ), false);
		JToolBarHelper::deleteList();
		
    	$lists = array();
		
		//get the filter order/dir, so we can put at the bottom of the form for reposting
    	$filter_order     = $mainframe->getUserStateFromRequest( $option.'rating.filter_order',      'filter_order', 'date', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'rating.filter_order_Dir',  'filter_order_Dir', '', 'word' );		
		$lists['order'] 	= $filter_order;  
		$lists['order_Dir'] = $filter_order_Dir;
		
		//get the data from the rating model
  		$ratingList	 =& $this->get('RatingList');
  		$photoList	 =& $this->get('PhotoList');
  		$galleryList =& $this->get('GalleryList');
		
  		//get the selectlist that can choose which gallery to limit by
  		$lists['gallery_id'] =& $this->get('SelectList');
  		
  		//get the pagination objects
  		$total	=& $this->get('Total');
		$pagination =& $this->get('Pagination');
		
		jimport('joomla.environment.uri' );
		$host = JURI::root();
		
		//assign vars and display
	    $this->assignRef('lists',		$lists);    
	  	$this->assignRef('ratingList',	$ratingList);
	  	$this->assignRef('photoList',	$photoList);
	  	$this->assignRef('galleryList',	$galleryList);
	  	$this->assignRef('total',		$total); 		
	    $this->assignRef('pagination',	$pagination);
	    $this->assignRef('host',		$host);
	    
	    parent::display($tpl);
  }
}
?>
