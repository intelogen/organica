<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class igalleryController extends JController
{
	function __construct($config = array() )
	{
		parent::__construct($config);
		
		//if the apply task comes in, the save_changes function will be done,
		//same for cat_apply -> cat_save
		$this->registerTask('apply', 'save_changes');
		$this->registerTask('cat_apply', 'cat_save');
	}
	
	//the default task
	function display() 
	{
		parent::display();
	}
	
	//add a new gallery
	function add()
	{
		JRequest::setVar('view', 'add');
		parent::display();
	}
	
	//save the gallery
	function save()
	{
		$post  = JRequest::get('post');
		$model = $this->getModel('igallery');
	
		if($model->save($post, true)) 
		{
			$msg = JText::_('GALLERY SAVED');
		} 
		$this->setRedirect('index.php?option=com_igallery',$msg);
	}
	
	//edit the settings of an existing gallery
	function edit()
	{
		JRequest::setVar('view', 'edit');
		parent::display();
	}
	
	//this saves any changes made to a gallery
	function save_changes()
	{
		$post	= JRequest::get('post');
		$model = $this->getModel('igallery');
		
		if($model->save_changes($post, true)) 
		{
			$msg = JText::_( 'GALLERY SAVED' );
		}
		
		//if they hit apply send them back to the same page
		switch($this->_task)
		{
			case 'save_changes':
			$url = 'index.php?option=com_igallery';
			break;
		
			case 'apply':
			$url = 'index.php?option=com_igallery&task=edit&cid[]='.$post['cid'][0];
			break;
		}
		
		$this->setRedirect($url,$msg);
	}
	
	function cancel()
	{
		$this->setRedirect('index.php?option=com_igallery');
	}
	
	//this deletes a gallery
	function remove()
	{
		$model = $this->getModel('igallery');
		if($model->delete(true)) 
		{
			$msg = JText::_( 'GALLERY DELETED' );
		}
		$this->setRedirect('index.php?option=com_igallery', $msg);
	}
	
	//this publishes a gallery/category
	function publish()
	{
		$model = $this->getModel('igallery');
		$model->publish(1); 
		$this->setRedirect('index.php?option=com_igallery' );
	}
	
	//this unpublishes a gallery/category
	function unpublish()
	{
		$model = $this->getModel('igallery');
		$model->publish(0); 
		$this->setRedirect('index.php?option=com_igallery' );
	}
	
	//order up a gallery
	function orderup()
	{
		$model = $this->getModel('igallery');
		$model->move(-1);
		$this->setRedirect('index.php?option=com_igallery');
	}
	
	//order down a gallery
	function orderdown()
	{
		$model = $this->getModel('igallery');
		$model->move(1);
		$this->setRedirect('index.php?option=com_igallery');
	}
	
	//save the order of the galleries and categories
	function saveorder()
	{
		$post = JRequest::get('post');
		$model = $this->getModel('igallery');
		if ($model->saveorder()) 
		{
			$msg = JText::_( 'NEW ORDERING SAVED' );
		}
		$this->setRedirect( 'index.php?option=com_igallery', $msg );
	}
	
	//make a new category
	function cat_new()
	{
		JRequest::setVar('view', 'cat_new');
		parent::display();
	}
	
	//edit an existing category
	function cat_edit()
	{
		JRequest::setVar('view', 'cat_edit');
		parent::display();
	}
	
	//save a category, or save changes to a category
	function cat_save()
	{
		$post  = JRequest::get('post');
		$model = $this->getModel('igallery');
	
		if($model->cat_save($post)) 
		{
			$msg = JText::_('CATEGORY SAVED');
		}
		
		//if they hit apply, send them back to the same page
		switch($this->_task)
		{
			case 'cat_apply':
			$url = 'index.php?option=com_igallery&task=cat_edit&cid='.$post['cid'];
			break;
		
			case 'cat_save':
			$url = 'index.php?option=com_igallery';
			break;
		}
		$this->setRedirect($url,$msg);
	}
	
	//delete a category
	function cat_delete()
	{
		$model = $this->getModel('igallery');
		if($model->cat_delete()) 
		{
			$msg = JText::_( 'CATEGORY DELETED' );
		}
		$this->setRedirect('index.php?option=com_igallery', $msg);
	}
	
	//order up a category
	function cat_orderup()
	{	
		$post = JRequest::get('post');
		$model = $this->getModel('igallery');
		$model->cat_move(-1);
		$this->setRedirect('index.php?option=com_igallery' );
	}
	
	//order down a category
	function cat_orderdown()
	{	
		$post = JRequest::get('post');
		$model = $this->getModel('igallery');
		$model->cat_move(1);
		$this->setRedirect('index.php?option=com_igallery' );
	}
	
	//this is called after hitting the comments button, it redericts to the comments controller, 
	//where the display task will be called and the administrator can manage comments
	function comments()
	{
		$this->setRedirect('index.php?option=com_igallery&controller=comments' );
	}
	
	//this is called after hitting the ratings button, it redericts to the rating controller, 
	//where the display task will be called and the administrator can manage ratings
	function rating()
	{
		$this->setRedirect('index.php?option=com_igallery&controller=rating' );
	}
	
}	
?>
