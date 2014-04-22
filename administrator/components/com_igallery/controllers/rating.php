<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class ratingController extends JController
{
	function __construct( $config = array() )
	{
		parent::__construct($config);
	}
	
	function display() 
	{	
		parent::display();
	}
	
	function remove()
	{
		$post = JRequest::get('post');
		$model = $this->getModel('rating');
		if($model->delete($post)) 
		{
			$msg = JText::_('RATING DELETED' );
		} 
		$this->setRedirect( 'index.php?option=com_igallery&controller=rating',$msg );
	}
	
	function back_main()
	{
		$this->setRedirect( 'index.php?option=com_igallery');
	}
	
}	
?>
