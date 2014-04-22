<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

class manageController extends JController
{
	function __construct( $default = array())
	{
		parent::__construct( $default );
		
		//add the backend models, there are no frontend ones
		$path = JPATH_COMPONENT_ADMINISTRATOR.DS.'models';
        $this->addModelPath($path); 
	}
	
	function display() 
	{
		parent::display();
	}
	
	function upload_image()
	{
		if( !$this->authenticate() )
		{
			return;
		}
		
		$post	= JRequest::get('post');
		$model = $this->getModel('manage');
		
		if ($model->upload($post, false)) 
		{
			//the uploading is done with ajax, 1 means success, anything else will get alerted
			echo 1;
		}
	}
	
	function save_edit_photo()
	{
		if( !$this->authenticate() )
		{
			return;
		}
		
		$post = JRequest::get('post');
		
		$itemId = JRequest::getInt('Itemid', '');
		
		if( isset( $post['save_edit_photo_cancel'] ) )
		{
			$this->setRedirect('index.php?option=com_igallery&controller=manage&view=manage&gid='.$post['gid'].'&Itemid='.$itemId);
			return;
		}
		
		$model = $this->getModel('manage');
	
		if($model->save_edit_photo($post, false)) 
		{
			$msg = JText::_( 'PHOTO DETAILS SUCCESSFULLY SAVED' );
		}

		$this->setRedirect('index.php?option=com_igallery&controller=manage&view=manage&gid='.$post['gid'].'&Itemid='.$itemId, $msg);
	}
	
	function publish()
	{
		if( !$this->authenticate() )
		{
			return;
		}
		
		$model = $this->getModel('manage');
		$model->publish(1);
		
		$gid	= JRequest::getInt('gid');
		$itemId = JRequest::getInt('Itemid', '');
		
		$this->setRedirect('index.php?option=com_igallery&controller=manage&view=manage&gid='.$gid.'&Itemid='.$itemId );
	}
	
	function unpublish()
	{
		if( !$this->authenticate() )
		{
			return;
		}
		
		$gid	= JRequest::getInt('gid');
		$model = $this->getModel('manage');
		$model->publish(0);
		
		$itemId = JRequest::getInt('Itemid', ''); 
		$this->setRedirect('index.php?option=com_igallery&controller=manage&view=manage&gid='.$gid.'&Itemid='.$itemId );
	}
	
	function saveorder()
	{	
		if( !$this->authenticate() )
		{
			return;
		}
		
		$model = $this->getModel('manage');
		if ($model->saveorder()) 
		{
			$msg = JText::_( 'NEW ORDERING SAVED' );
		}
		
		$gid	= JRequest::getInt('gid');
		$itemId = JRequest::getInt('Itemid', '');
		
		$this->setRedirect('index.php?option=com_igallery&controller=manage&view=manage&gid='.$gid.'&Itemid='.$itemId, $msg);
	}
	
	function delete_photo()
	{
		if( !$this->authenticate() )
		{
			return;
		}
		
		$post = JRequest::get('post');
		$model = $this->getModel('manage');
		
		if($model->deletePhoto($post, false)) 
		{
			$msg = JText::_( 'IMAGE DELETED' );
		}
		
		$gid	= JRequest::getInt('gid');
		$itemId = JRequest::getInt('Itemid', '');
		
		$this->setRedirect('index.php?option=com_igallery&controller=manage&view=manage&gid='.$gid.'&Itemid='.$itemId,$msg );
	}
	
	function authenticate()
	{
		$user   =& JFactory::getUser();
		if( $user->get('guest') )
		{
			echo JText::_('PLEASE LOGIN TO VIEW');
			return false;
		}
		
		$configArray =& JComponentHelper::getParams('com_igallery');
		$allowFrontend = $configArray->get('allow_frontend_creation', 0);
		if($allowFrontend != 1)
		{
			echo JText::_('RESTRICTED ACCESS');
			return false;
		}
		
		return true;
	}
	
	
	
}	
?>
