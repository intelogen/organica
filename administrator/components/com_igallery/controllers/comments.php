<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class commentsController extends JController
{
	function __construct( $config = array() )
	{
		parent::__construct($config);
	}
	
	function display() 
	{	
		parent::display();
	}
	
	function publish()
	{
		$model = $this->getModel('comments');
		$model->publish(1); 
		$this->setRedirect('index.php?option=com_igallery&controller=comments' );
	}
	
	function unpublish()
	{
		$model = $this->getModel('comments');
		$model->publish(0); 
		$this->setRedirect('index.php?option=com_igallery&controller=comments' );
	}
	
	function remove()
	{
		$post = JRequest::get('post');
		$model = $this->getModel('comments');
		if($model->delete($post)) 
		{
			$msg = JText::_('COMMENT DELETED' );
		} 
		$this->setRedirect( 'index.php?option=com_igallery&controller=comments',$msg );
	}
	
	function back_main()
	{
		$this->setRedirect('index.php?option=com_igallery');
	}
	
}	
?>
