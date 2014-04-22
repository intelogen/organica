<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

class igalleryController extends JController
{
	function __construct( $default = array())
	{
		//add in the backend models, there is no frontend models folder
		$path = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_igallery'.DS.'models';
        $this->addModelPath($path);
		
        //if the plugin/module is calling the controller, we need to tell jcontroller where
        //to look for the views/models
		$default['base_path'] = JPATH_SITE.DS.'components'.DS.'com_igallery';
		parent::__construct( $default );
	}
	
	function display() 
	{	
		parent::display();
	}
	
	function comment()
	{
		//done with ajax, the model will echo the result
		$model = $this->getModel('igallery');
		$model->comment();
	}
	
	function rating() 
	{	
		//done with ajax, the model will echo the result
		$model = $this->getModel('igallery');
		$model->rating();
	}
	
	function save()
	{
		if( !$this->authenticate() )
		{
			return;
		}
		
		$post  = JRequest::get('post');
		$itemId = JRequest::getInt('Itemid', '');
		
		if( isset( $post['new_gallery_cancel'] ) )
		{
			$this->setRedirect('index.php?option=com_igallery&view=igallery&Itemid='.$itemId);
			return;
		}
		
		$model = $this->getModel('igallery');
		if($model->save($post, false)) 
		{
			$msg = JText::_('GALLERY SAVED');
		} 
		$this->setRedirect('index.php?option=com_igallery&view=igallery&Itemid='.$itemId,$msg);
	}
	
	function save_changes()
	{
		if( !$this->authenticate() )
		{
			return;
		}
		
		$post	= JRequest::get('post');
		$itemId = JRequest::getInt('Itemid', '');
		
		if( isset( $post['edit_gallery_cancel'] ) )
		{
			$this->setRedirect('index.php?option=com_igallery&view=igallery&Itemid='.$itemId);
			return;
		}
		
		$model = $this->getModel('igallery');
		if ($model->save_changes($post, false)) 
		{
			$msg = JText::_( 'GALLERY SAVED' );
		}
		
		$this->setRedirect('index.php?option=com_igallery&view=igallery&Itemid='.$itemId, $msg);
	}
	
	function publish()
	{
		if( !$this->authenticate() )
		{
			return;
		}
		
		$model = $this->getModel('igallery');
		$model->publish(1);
		
		$itemId = JRequest::getInt('Itemid', ''); 
		$this->setRedirect('index.php?option=com_igallery&view=igallery&Itemid='.$itemId );
	}
	
	function unpublish()
	{
		if( !$this->authenticate() )
		{
			return;
		}
		
		$model = $this->getModel('igallery');
		$model->publish(0);
		
		$itemId = JRequest::getInt('Itemid', ''); 
		$this->setRedirect('index.php?option=com_igallery&view=igallery&Itemid='.$itemId );
	}
	
	function delete()
	{
		if( !$this->authenticate() )
		{
			return;
		}
		
		$model = $this->getModel('igallery');
		if($model->delete(false)) 
		{
			$msg = JText::_( 'GALLERY DELETED' );
		}
		
		$itemId = JRequest::getInt('Itemid', '');
		$this->setRedirect('index.php?option=com_igallery&view=igallery&Itemid='.$itemId, $msg);
	}
	
	function saveorder()
	{	
		if( !$this->authenticate() )
		{
			return;
		}
		
		$model = $this->getModel('igallery');
		if ($model->saveorder()) 
		{
			$msg = JText::_( 'NEW ORDERING SAVED' );
		}
		
		$itemId = JRequest::getInt('Itemid', '');
		$this->setRedirect( 'index.php?option=com_igallery&view=igallery&Itemid='.$itemId, $msg );
	}
	
	function authenticate()
	{
		//guests can not do gallery creating/editing
		$user   =& JFactory::getUser();
		if( $user->get('guest') )
		{
			echo JText::_('PLEASE LOGIN TO VIEW');
			return false;
		}
		
		//if front end gallery creation is disabled, then any
		//gallery editing tasks will stop here
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
