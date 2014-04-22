<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class manageViewmanage extends JView
{
	function __construct( $config = array())
	{
 		parent::__construct( $config );
	}
 
	function display($tpl = null)
	{
	 	global $mainframe, $option;
	 	
	 	//get the data from the manage model
	 	$photoList =& $this->get('PhotoList');
	 	$gallery   =& $this->get('Gallery');
		
	 	//set the toolbar items
	 	JToolBarHelper::title( JText::_( 'MANAGE PHOTOS').' - '.$gallery->name ,'generic.png' );
		JToolBarHelper::custom('back_main','back', '',JText::_( 'MAIN MENU' ), false);
		JToolBarHelper::publish();
		JToolBarHelper::unpublish();
		JToolBarHelper::deleteList();
		
		$lists = array();
		
		//get the filter order/dir, so we can put at the bottom of the form for reposting
    	$filter_order     = $mainframe->getUserStateFromRequest( $option.'manage.filter_order',      'filter_order', 'ordering', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'manage.filter_order_Dir',  'filter_order_Dir', '', 'word' );		
		$lists['order'] 	= $filter_order;  
		$lists['order_Dir'] = $filter_order_Dir;
		
		//get the pagination objects
		$total	=& $this->get('Total');
		$pagination =& $this->get('Pagination');
		
		jimport('joomla.environment.uri' );
		$host = JURI::root();
  		
		//add the swfupload scripts to the head of the doc
		$document =& JFactory::getDocument();
		$document->addScript($host.'administrator/components/com_igallery/swfupload/swfupload.js');
		$document->addScript($host.'administrator/components/com_igallery/swfupload/swfupload.queue.js');
		$document->addScript($host.'administrator/components/com_igallery/swfupload/fileprogress.js');
		$document->addScript($host.'administrator/components/com_igallery/swfupload/handlers.js');
		$document->addStyleSheet($host.'administrator/components/com_igallery/swfupload/default.css');
		
		$session = & JFactory::getSession();
		$gid = JRequest::getInt('gid', 0);
		
		//add the swfupload inline javascript to the head of the doc
		$swfUploadHeadJs ='
		var swfu;

		window.onload = function()
		{
			var settings = 
			{
				flash_url : "'.$host.'administrator/components/com_igallery/swfupload/swfupload.swf",
				upload_url: "'.$host.'administrator/index.php",
				post_params: 
				{
					"option" : "com_igallery",
					"controller" : "manage",
					"task" : "upload_image",
					"gid" : "'.$gallery->id.'",
					"'.$session->getName().'" : "'.$session->getId().'",
					"format" : "raw"
				}, 
				file_size_limit : "5 MB",
				file_types : "*.jpg;*.jpeg;*.gif;*.png",
				file_types_description : "All Files",
				file_upload_limit : 100,
				file_queue_limit : 100,
				custom_settings : 
				{
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "'.$host.'administrator/components/com_igallery/swfupload/browse-background.gif",
				button_width: "85",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text_left_padding: 5,
				button_text_top_padding: 6,
				button_text: \'<span class="theFont">'.JText::_( 'CHOOSE FILES' ).'</span>\',
				button_text_style: ".theFont { font-size: 13px; }",
				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
	     };
	     
	    //This function is in the head instead of the handlers.js, as we need to dynamically change the
	    //redirect url
		function queueComplete(numFilesUploaded) 
		{
			var status = document.getElementById("divStatus");
			status.innerHTML = numFilesUploaded + " '.JText::_( 'FILES UPLOADED' ).'";
			window.location = \''.$host.'administrator/index.php?option=com_igallery&controller=manage&view=manage&gid='.$gallery->id.'\';
		}
	    ';
		
		$document->addScriptDeclaration($swfUploadHeadJs);
		
		//assign vars and display	
	    $this->assignRef('gallery', $gallery);	
	    $this->assignRef('lists', $lists);    
	  	$this->assignRef('photoList', $photoList); 		
	    $this->assignRef('pagination', $pagination);
	    
	    parent::display($tpl);
  }
}
?>
