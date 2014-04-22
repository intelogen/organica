<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );


class commentsViewcomments extends JView
{
	function __construct( $config = array() )
	{
 		parent::__construct($config);
	}
 
	function display($tpl = null)
	{
	 	global $mainframe, $option;
		
	 	//set the toolbar buttons
		JToolBarHelper::title( JText::_( 'COMMENTS' ), 'generic.png' );
		JToolBarHelper::custom('back_main','back', '',JText::_( 'MAIN MENU' ), false);
		JToolBarHelper::publish();
		JToolBarHelper::unpublish();
		JToolBarHelper::deleteList();
		
		$lists = array();
		
		//get the filter order/dir, so we can put at the bottom of the form for reposting
    	$filter_order     = $mainframe->getUserStateFromRequest( $option.'comments.filter_order',      'filter_order', 'date', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'comments.filter_order_Dir',  'filter_order_Dir', '', 'word' );		
		$lists['order'] 	= $filter_order;  
		$lists['order_Dir'] = $filter_order_Dir;
		
		//get the data from our comments model
  		$commentsList =& $this->get('CommentsList');
  		$photoList	  =& $this->get('PhotoList');
  		$galleryList  =& $this->get('galleryList');
		
  		//get the selectlist that can choose which gallery to limit by
  		$lists['gallery_id'] =& $this->get('SelectList');
  		
  		//get the paganation objects
  		$total	=& $this->get('Total');
		$pagination =& $this->get('Pagination');
		
		jimport('joomla.environment.uri' );
		$host = JURI::root();
			
	    $this->assignRef('lists',		$lists);    
	  	$this->assignRef('commentsList',	$commentsList);
	  	$this->assignRef('photoList',	$photoList);
	  	$this->assignRef('galleryList',	$galleryList);
	  	$this->assignRef('total',		$total); 		
	    $this->assignRef('pagination',	$pagination);
	    $this->assignRef('host',		$host);
	    
	    parent::display($tpl);
  }
}
?>
