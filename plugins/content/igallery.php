<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

//load the component language file
JPlugin::loadLanguage('com_igallery');

//when the Joomla content is being prepared, do the displaygallery function 
$mainframe->registerEvent('onPrepareContent', 'displayGallery');

//we need to access this in the component display function, so we know not to do breadcrumbs etc
JRequest::setVar('calledFrom','plugin');


function displayGallery( &$row, &$params )
{
	$view = null;
	$id = null;
	$layout = null;
	
	//get all the {igallery X} bits in the content
	preg_match_all('/\{igallery ([0-9]+)\}/U',$row->text, $matches);
	
	//for every match
	foreach( $matches[1] as $pluginId )
	{
		//they may be a current view/id for the active component, we need to get these, so we can
		//reset them back after we do the plugin html
		$view = JRequest::getCmd('view',null);
		$id = JRequest::getInt('id',null);
		$layout= JRequest::getCmd('layout',null);
		
		//set the view and id, so when we make the controller class in the component, it gets the
		//correct values
		JRequest::setVar('view', 'gallery');
		JRequest::setVar('id', (int)$pluginId);
		JRequest::setVar('layout', 'default');
		
		//get our controller class from the component
		require_once(JPATH_SITE.DS.'components'.DS.'com_igallery'.DS.'controllers'.DS.'igallery.php');
		$controllerClass = new igalleryController();
		
		//start output buffering, so we can grab the buffer html, and put it into the content
		ob_start();
		
		//the display function will echo out the gallery html to the buffer
		$controllerClass->display(false);
		
		//get the buffer
		$pluginHtml = ob_get_contents(); 
		ob_end_clean();
		
		//replace the {igallery X} bit with the buffer html
		$row->text = str_replace("{igallery $pluginId}", $pluginHtml, $row->text);
	}
	
	//if there was a view id before we started, the reset them to original values
	if($view != null)
	{
		JRequest::setVar('view', $view);
	}
	
	if($id != null)
	{
		JRequest::setVar('id', $id);
	}
	
	if($layout != null)
	{
		JRequest::setVar('layout', $layout);
	}
	
	return true;
}