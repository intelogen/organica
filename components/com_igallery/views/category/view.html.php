<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class igalleryViewcategory extends JView
{
	function __construct( $config = array())
	{
 		parent::__construct($config);
	}
 
	function display($tpl = null)
	{
	 	global $mainframe;
	 	
	 	$itemId = JRequest::getInt('Itemid', '');
	 	
	 	$configArray =& JComponentHelper::getParams( 'com_igallery' );
	 	
	 	//get the users access level
	 	$aid =& $this->get('Aid');
	 	
	 	//get the data for this category from our category model in the backend
	 	$category	=& $this->get('Category');
	 	
	 	//get all the child categories and galleries of this category
	 	$childCats	=& $this->get('ChildCats');
	 	$childGalleries	=& $this->get('ChildGalleries');
	 	
	 	//if show cat menu at top is yes, get the categories with the same parent
	 	if($category->show_cat_menu == 1)
		{
	 		$parentCats	=& $this->get('parentCats');
		}
		else
		{
			$parentCats = null;
		}
	 	
	 	//check published and restrict if necessary
	 	if($category->published != 1)
		{
			echo JText::_( 'NOT PUBLISHED' );
			return;
		}
		
		//if the acess level is higher than the users acess level
	 	if($category->access > $aid)
	 	{
	 		//if the category is resrticted to registered users
			if($category->access == 1)
		 	{
		 		//get the joomla or community builder register link
		 		$registerLink = $configArray->get('register_link', 'index.php?option=com_user&amp;task=register');
		 		header("location: ".$registerLink);
		 	}
		 	
		 	//if the category is restricted to special users
		 	if($category->access == 2)
		 	{
		 		echo JText::_('RESTRICTED ACCESS');
		 	}
		 	return;
	 	}
		
	 	
		//BREADCRUMBS BIT
		
		//if its the top category, let the menu do the breadcrumb, as we dont 
		//know what to call the breadcrumb
		if($category->id != 0)
		{
			$pathway =& $mainframe->getPathway();
			
			//we want to lose the menu link joomla has made, so we can breadcrumb back to the
			//parent categories
			$pathway->_pathway = array();
			
			$breadCrumbs = array();
			$breadCrumbsLinks = array();
			
			//make the breadcrumb for this category
			$breadCrumbs[] = $category->name;
			$breadCrumbsLinks[] = JRoute::_('index.php?option=com_igallery&view=category&id='.$category->id.'&Itemid='.$itemId);
			
			$breadcrumbCategory = $category;
			
			//while the category has a parent that is not the top category, make a breadcrumb
			while($breadcrumbCategory->parent != 0)
			{
				$db =& JFactory::getDBO();
				$query = 'SELECT * FROM #__igallery WHERE id = '.intval($breadcrumbCategory->parent);
				$db->setQuery($query);
				$breadcrumbCategory = $db->loadObject();
				
				//add the new breadcrumb to the beginning of the array
				array_unshift($breadCrumbs, $breadcrumbCategory->name);
				array_unshift($breadCrumbsLinks, JRoute::_('index.php?option=com_igallery&view=category&id='.$breadcrumbCategory->id.'&Itemid='.$itemId) );
			}
			
			//make a breadcrumb for every item in the arrays
			for($i=0; $i<count($breadCrumbs); $i++)
			{
				$pathway->addItem($breadCrumbs[$i],$breadCrumbsLinks[$i]);
			}
		}
		
		jimport('joomla.environment.uri');
		$host = JURI::root();
		
		//add the stylesheet
		$document =& JFactory::getDocument();
		$document->addStyleSheet($host.'components/com_igallery/css/category.css');
		
		if($category->id != 0)
		{
			//if its not the top cat, add in the category name as the title
			$document->setTitle($category->name);
		}
		
	 	
		
		$params = &$mainframe->getParams();
		
		//assign vars and display
		$this->assignRef('host', $host);
		$this->assignRef('category', $category);
		$this->assignRef('parentCats', $parentCats);
		$this->assignRef('childCats', $childCats);
		$this->assignRef('childGalleries', $childGalleries);
		$this->assignRef('itemId', $itemId);
		$this->assignRef('params', $params);
	  	
		parent::display($tpl);
  }
}
?>
