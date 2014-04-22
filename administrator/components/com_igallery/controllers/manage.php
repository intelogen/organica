<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class manageController extends JController
{
	function __construct( $config = array() )
	{
		parent::__construct($config);
		$this->registerTask('apply_edit_photo' ,'save_edit_photo');
	}
	
	function display() 
	{	
		parent::display();
	}
	
	function back_main()
	{
		$this->setRedirect( 'index.php?option=com_igallery');
	}
	
	function upload_image()
	{
		$post	= JRequest::get('post');
		$model = $this->getModel('manage');
		
		if ($model->upload($post, true)) 
		{
			//the uploading is done with ajax, 1 means success, anything else will get alerted
			echo 1;
		}
	}
	
	function edit_photo()
	{
		JRequest::setVar('view', 'edit_photo');
		parent::display();
	}
	
	function save_edit_photo()
	{
		$post	= JRequest::get('post');
		$model = $this->getModel('manage');
	
		if($model->save_edit_photo($post, true)) 
		{
			$msg = JText::_( 'PHOTO DETAILS SUCCESSFULLY SAVED' );
		}
		
		switch($this->_task)
		{
			case 'apply_edit_photo':
			$url = 'index.php?option=com_igallery&controller=manage&task=edit_photo&gid='.$post['gid'].'&cid[]='.$post['cid'][0];
			break;
		
			case 'save_edit_photo':
			$url = 'index.php?option=com_igallery&controller=manage&gid='.$post['gid'];
			break;
		}
		$this->setRedirect($url, $msg);
	}
	
	function cancel_edit_photo()
	{
		$post = JRequest::get('post');
		$this->setRedirect('index.php?option=com_igallery&controller=manage&gid='.$post['gid']);
	}
	
	function remove()
	{
		$post = JRequest::get('post');
		$model = $this->getModel('manage');
		if($model->deletePhoto($post, true)) 
		{
			$msg = JText::_('IMAGE DELETED' );
		} 
		$this->setRedirect( 'index.php?option=com_igallery&controller=manage&gid='.$post['gid'],$msg );
	}
	
	function publish()
	{
		$post = JRequest::get('post');
		$model = $this->getModel('manage');
		$model->publish(1); 
		$this->setRedirect('index.php?option=com_igallery&controller=manage&gid='.$post['gid'] );
	}
	
	function unpublish()
	{
		$post = JRequest::get('post');
		$model = $this->getModel('manage');
		$model->publish(0); 
		$this->setRedirect('index.php?option=com_igallery&controller=manage&gid='.$post['gid'] );
	}
	
	function orderup()
	{	
		$post = JRequest::get('post');
		$model = $this->getModel('manage');
		$model->move(-1);
		$this->setRedirect('index.php?option=com_igallery&controller=manage&gid='.$post['gid'] );
	}
	
	function orderdown()
	{	
		$post = JRequest::get('post');
		$model = $this->getModel('manage');
		$model->move(1);
		$this->setRedirect('index.php?option=com_igallery&controller=manage&gid='.$post['gid'] );
	}
	
	function saveorder()
	{
		$post = JRequest::get('post');
		$model = $this->getModel('manage');
		if ($model->saveorder()) 
		{
			$msg = JText::_( 'NEW ORDERING SAVED' );
		}
		$this->setRedirect( 'index.php?option=com_igallery&controller=manage&gid='.$post['gid'], $msg );
	}
	
}	
?>
