<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'base.php');

class igalleryModeligallery extends igalleryModelbase
{
	var $_id = null;
	var $_galleries = null;
	var $_gallery = null;
	var $_data = null;
	var $_total = null;
	var $_pagination = null;

	function __construct()
	{
		parent::__construct();

		global $mainframe, $option; 
		
		$limit      = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
  		$limitstart = $mainframe->getUserStateFromRequest( $option.'limitstart', 'limitstart', 0, 'int' );
		
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
		
		$gid = JRequest::getInt('gid',0);
		$cid = JRequest::getVar('cid',  array(0), '', 'array');
		$order 	= JRequest::getVar('order', array(0), 'post', 'array');
		
		$this->setValues($cid, $cid[0], $order, $gid);
	}
	
	function setValues($cid, $id, $order, $gid)
	{
		$this->_cid = $cid;
		JArrayHelper::toInteger($this->_cid);
		
		$this->_id = (int)$id;
		
		$this->_order = $order;
		JArrayHelper::toInteger($this->_order);
		
		$this->_gid = (int)$gid;
	}
	
	function getData()
	{
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();
			
			//we will do the limits after we make the tree of galleries/ categories
			$this->_data = $this->_getList($query, 0, 10000);
		}

		$children = array();
	    
	    foreach ($this->_data as $v ) 
	    {
	        $pt = $v->parent;
	        $list = @$children[$pt] ? $children[$pt] : array();
	        array_push($list, $v);
	        $children[$pt] = $list;
	    }
	    
	    $list = JHTML::_('menu.treerecurse',  0, '', array(), $children, max( 0, 9 ) );
	   
	    $orderedList = array_values($list);
	    
	    $total = count($orderedList);
	    
	    jimport('joomla.html.pagination');
		$this->_pagination = new JPagination( $total, $this->getState('limitstart'), $this->getState('limit') );

		// slice out elements based on limits
		$orderedList = array_slice( $list, $this->_pagination->limitstart, $this->_pagination->limit );
	    
	    return $orderedList;
	}
	
	function _buildQuery()
	{
		$orderby	= $this->_buildContentOrderBy();
		$query = "SELECT * from #__igallery ".$orderby;
		
		return $query;
	}
	
	function _buildContentOrderBy()
	{
		global $mainframe, $option;
		
		$filter_order     = $mainframe->getUserStateFromRequest( $option.'filter_order',     'filter_order', 'ordering', 'cmd' );
  		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', '', 'word' );

		$orderby 	= 'ORDER BY parent, ordering';//.$filter_order.' '.$filter_order_Dir;			
		
		return $orderby;
	}
	
	function getTotal()
	{	
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}
		return $this->_total;
	}
	
	function getPagination()
	{
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
		return $this->_pagination;
	}
	
	
	
	function getGalleries()
	{
		//get the components paramaters
		$configArray =& JComponentHelper::getParams('com_igallery');
		
		//check whether front end users can edit all galleries, or just their own
		$allowEditAll = $configArray->get('frontend_edit_all', 0);
		
		if($allowEditAll == 1)
		{
			$query = 'SELECT * FROM #__igallery WHERE type = 1 ORDER BY ordering';
		}
		else
		{
			$user   =& JFactory::getUser();
			$query = 'SELECT * FROM #__igallery WHERE user = '.intval($user->id).' AND type = 1 ORDER BY ordering';
		}
		
		$this->_db->setQuery($query);
		$this->_galleries = $this->_db->loadObjectList();
		return  $this->_galleries;
	}
	
	function comment()
	{
		$user   =& JFactory::getUser();
		if( $user->get('guest') )
		{
			echo 0;
			return;
		}
		
		$row =& $this->getTable('igallery_comments');
		
		//get the gallery and image id
		$row->gallery_id = JRequest::getInt('comment_gallery_id');
		$row->img_id = JRequest::getInt('comment_img_id');
		
		//get the username and ip address
		$row->author = $user->get('username');
		$row->ip = $_SERVER['REMOTE_ADDR'];
		
		$row->published = 1;
		
		//getVar will strip all html and javascript from the input
		$commentText = JRequest::getVar('comment_textarea');
		
		//we want to encode any special characters like ' and " as html entities
		//so we can send the comment back to the javascript to display
		$htmlText = htmlspecialchars($commentText, ENT_QUOTES);
		
		//any returns the user entered should be a html line break
		$row->text = nl2br($htmlText);
		
		//get the unix timestamp
		$row->date = time();
		
		//store to the database
		if (!$row->store()) 
		{
			echo $row->getError();
			return false;
		}
		
		$response = $row->text.'<br /><span class="italics_text">'.$row->author.' - '.date("F j, Y, g:i a",$row->date).'</span>';
		
		//the javascript will display the response
		echo $response;
	}
	
	function rating()
	{
		$user   =& JFactory::getUser();
		
		//if the user has been logged out, echo 0, and the javascript will ask them to log in again
		if($user->get('guest'))
		{
			echo 0;
			return;
		}
		
		$post = JRequest::get('post');
		
		//if they have already voted then echo 1, the javascript will tell them they have already voted.
		//the javascript disables the form if they have already voted for an image, and says they have voted 
		//this is the serverside check if some one hits the script with firebug etc
		$query = 'SELECT * FROM #__igallery_rating WHERE author = \''.$this->_db->getEscaped( $user->get('username') ).'\' AND img_id = '.intval($post['img_id']);
		$this->_db->setQuery($query);
		$this->_db->query($query);
		$numRows = $this->_db->getNumRows();
		if($numRows != 0)
		{
			echo 1;
			return;
		}
		
		//bind the incoming data
		$row =& $this->getTable('igallery_rating');
		
		if (!$row->bind($post)) 
		{
			echo $row->getError();
			return false;
		}
		$row->ip = $_SERVER['REMOTE_ADDR'];
		$row->author = $user->get('username');
		$row->published = 1;
		$row->date = time();
		
		//store the data
		if (!$row->store()) 
		{
			echo $row->getError();
			return false;
		}
		//if the store was successful, echo 2, and the javascript will tell them the rating was successfully added
		echo 2;
	}
	
	//this function saves a new gallery, save_changes() saves changes to an existing gallery
	function save($post, $backend)
	{
		//get joomlas file system so we can write with the ftp user if it is turned on
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		
		include_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'jimagelib'.DS.'JImageLib.php');
		
		//we will make the folder name for this gallery from the gallery name
		
		//remove any special characters/ spaces
		$alpha_num =  ereg_replace("[^A-Za-z0-9]", "_", $post['name']);
		
		//make it lowercase
		$lowercase = strtolower($alpha_num);
		
		//make it a max of 40 characters long
		$folderName = substr($lowercase,0,40);
		
		//if the folder name already exists
		if( JFolder::exists(JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName) )
		{
			//add a -1 to the end, if that exists, add a -2 to the end...
			$folderNumber = 1;
			while( JFolder::exists(JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName.'-'.$folderNumber) )
			{
				$folderNumber++;
			}
			$folderName = $folderName.'-'.$folderNumber;
		}
		
		//no folders get made on install, so when the first gallery is made, the base folders get made
		$folders_to_make = array();
		$folders_to_make[0] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery';
		$folders_to_make[1] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics';
		$folders_to_make[2] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics'.DS.'temp';
		
		//folders for this gallery
		$folders_to_make[3] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName;
		$folders_to_make[4] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName.DS.'temp';
		$folders_to_make[5] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName.DS.'original';
		$folders_to_make[6] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName.DS.'lightbox';
		$folders_to_make[7] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName.DS.'lightbox_thumbs';
		$folders_to_make[8] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName.DS.'thumbs';
		$folders_to_make[9] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName.DS.'large';
		
		//make the folders
		for($i = 0; $i<count($folders_to_make); $i++)
		{
			if ( !JFolder::exists($folders_to_make[$i]) )
			{
				if( !JFolder::create($folders_to_make[$i], 0755) ) 
				{
					JError::raise(2, 500, $folders_to_make[$i] .' '. JText::_( 'FOLDER CREATE ERROR' ) );
					return false;
				}
			}
		}
		
		$configArray =& JComponentHelper::getParams('com_igallery');
		
		//if there was a category image uploaded
		if(strlen($_FILES['upload_image']['name']) > 2 )
		{
			$field_name = 'upload_image';
			
			//we will delete the temp file after making a image from it
			$tempDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName.DS.'temp'.DS;
			
			//we will check to see if the filename exists in the original folder, if it does we will make a unique filename
			$currentImgsDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName.DS.'original'.DS;
			
			//ok mime types
			$accept = 'image/jpeg,image/pjpeg,image/png,image/x-png,image/gif';
			
			//ok file extensions
			$okExtensions = 'jpeg,jpg,png,gif';
			
			//get the max filesize for an image that is set in the paramaters
			$configUploadImg = $configArray->get('max_upload_img', 1500);
			
			//make it in bytes, not kilobytes
			$maxUploadImg = $configUploadImg * 1000;
			
			//upload the file, using the function in our base model
			$uploadedFile = $this->upload_file($field_name, $tempDir, $currentImgsDir, $accept, $maxUploadImg, $okExtensions);
			if($uploadedFile == false)
			{
				return false;
			}
			
			//get the image size of the image we just uploaded
			$imgSize = getimagesize($tempDir.$uploadedFile);
			
			//we dont want to keep the uploaded file, as it may be huge, so we will make a copy at 90% quality
			//and max 2000 X 1500 and then delete the uploaded file
			$origDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName.DS.'original'.DS;
			
			$JImageTemp = new JImageLib();

			$JImageTemp->load($tempDir.$uploadedFile);
	
	        $JImageTemp->setWidth(2000);
	        $JImageTemp->setHeight(1500);
	
	        if (!$JImageTemp->save( $origDir.$uploadedFile,95) ) 
	        {
	            JError::raise(2, 500, 'M1 '.$uploadedFile .' '. $JImageTemp->getError() ) ;
				return false;
	        }
			
			
			//delete the uploaded file
			JFile::delete(JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName.DS.'temp'.DS.$uploadedFile);
			
			//we might be in the front end, where setting the max width and height of the menu image has
			//been disabled, so if they are not sent through, we get them from the config params
			if( !isset($post['menu_max_width']) )
			{
				$post['menu_max_width'] = $configArray->get('menu_max_width', 200);
			}
			
			if( !isset($post['menu_max_height']) )
			{
				$post['menu_max_height'] = $configArray->get('menu_max_height', 200);
			}
			
			if( !isset($post['img_quality']) )
			{
				$post['img_quality'] = $configArray->get('img_quality', 80);
			}
			
			//we will put the menu image into the gallery folder (no sub folder)
			$resizeDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$folderName.DS;
			
			$JImage = new JImageLib();

			$JImage->load($origDir.$uploadedFile);
	
			$JImage->setWidth( intval($post['menu_max_width']) );
	        $JImage->setHeight( intval($post['menu_max_height']) );
			
	        if (!$JImage->save( $resizeDir.$uploadedFile, intval($post['img_quality']) ) ) 
	        {
	            JError::raise(2, 500, 'M2 '.$uploadedFile .' '. $JImage->getError() ) ;
				return false;
	        }
			
			//add the filename to the array, so it will go to the database later
			$post['menu_image_filename'] = $uploadedFile;
			
		}
		
		//bind all the incoming post data to the table object
		$row =& $this->getTable('igallery');
		if (!$row->bind($post)) 
		{
			JError::raise(2, 500, $row->getError());
			return false;
		}
		
		if( strlen($row->alias) < 1)
		{
			$row->alias = $row->name;
		}
		
		$row->alias = ereg_replace("[^A-Za-z0-9]", "-", $row->alias);
		$row->alias = strtolower($row->alias);
		
		//we want to allow html in the description, but not javascript 
		$row->gallery_description = JRequest::getVar( 'gallery_description', '', 'post', 'string', JREQUEST_ALLOWHTML );
		$row->menu_description = JRequest::getVar( 'menu_description', '', 'post', 'string', JREQUEST_ALLOWHTML );
		
 		$row->folder = $folderName;
 		
 		//1 = gallery, 0 is category
 		$row->type = 1;
 		
 		$user   =& JFactory::getUser();
		$row->user = $user->id;
		
		//if we are in the frontend the category may not be set, so we get it from the config params
		if( !isset($post['parent']) )
		{
			$row->parent = $configArray->get('default_category', 0);
		}
		
		$row->ordering = $row->getNextOrder('parent = '.intval($row->parent).' AND type = 1');
		
		
		if($backend == false)
		{
			$galleryVars = array('menu_description','gallery_description','menu_max_width',
			'menu_max_height','max_width','max_height','fade','preload',
			'thumb_width','thumb_height','thumb_position','thumb_container_width','thumb_container_height',
			'images_per_row','thumb_scrollbar','scroll_speed','scroll_boundary','photo_des_position',
			'photo_des_width','photo_des_height','align','lightbox','lbox_max_width','lbox_max_height','lbox_fade','lbox_preload',
			'lbox_thumb_width','lbox_thumb_height','lbox_thumb_position','lbox_thumb_container_width','lbox_thumb_container_height',
			'lbox_images_per_row','lbox_thumb_scrollbar','lbox_scroll_speed','lbox_scroll_boundary',
			'lbox_photo_des_position','lbox_photo_des_width','lbox_photo_des_height','img_quality','published',
			'gallery_des_position','arrows_up_down','arrows_left_right','lbox_arrows_left_right','lbox_arrows_up_down',
			'show_cat_menu','cat_menu_columns','magnify','menu_access','access','allow_comments',
			'allow_rating','lbox_allow_comments','lbox_allow_rating','img_container_width','img_container_height',
			'lbox_img_container_width','lbox_img_container_height','show_large_image','show_thumbs','show_descriptions',
			'lbox_show_thumbs','lbox_show_descriptions','enable_slideshow','show_slideshow_controls','slideshow_autostart','slideshow_pause',
			'lbox_enable_slideshow','lbox_show_slideshow_controls','lbox_slideshow_autostart','lbox_slideshow_pause',
			'crop_thumbs','lbox_crop_thumbs','style');
			
			
			//if we are in the frontend there may be a lot of vars unset, and we have to get them from the
			//defaults in the config paramaters. the above array has all the params that may not be set in the front end
			
			//loop through the array...
			for($i=0; $i<count($galleryVars); $i++)
			{
				//if the front end user is not allowed to set this paramater
				if($configArray->get('allow_'.$galleryVars[$i], 0) == 0)
				{
					//make the table object paramater the default paramater set in the config
					$row->{$galleryVars[$i]} = $configArray->get($galleryVars[$i], 0);
				}
			}
		}
		
		//write to the database
 		if (!$row->store()) 
		{
			JError::raise(2, 500, $row->getError());
			return false;
		}
		
		return true;
	}
	
  	function save_changes($post, $backend)
	{	
		$configArray =& JComponentHelper::getParams('com_igallery');
		
		//import joomla's file system, so if the ftp user is on, the files will be written with the ftp user
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		
		include_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'jimagelib'.DS.'JImageLib.php');
		
		//get the row for the gallery we are making changes to
		$row =& $this->getTable('igallery');
		$row->load($this->_id);
		
		//if we are in the frontend, check that this gallery belongs to the user,
		//or that they are allowed to edit all galleries
		if($backend != true)
		{
			$user   =& JFactory::getUser();
			
			$allowEditAll = $configArray->get('frontend_edit_all', 0);
			if( $user->id != $row->user && $allowEditAll != 1)
			{
				JError::raise(2, 500, JText::_( 'RESTRICTED ACCESS' ));
				return false;
			}
		}
		
		$imageUploaded = false;
		//if there was a menu image uploaded...
		if(strlen($_FILES['upload_image']['name']) > 2 )
		{
			$imageUploaded = true;
			
			//the name of the html form element that has the image
			$field_name = 'upload_image';
			
			//where we are going to put the uploaded file
			$tempDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'temp'.DS;
			
			//our upload function needs this to check if we already have an image with that filename
			$currentImgsDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'original'.DS;
			
			//our upload function will check for correct mime and file extension
			$accept = 'image/jpeg,image/pjpeg,image/png,image/x-png,image/gif';
			$okExtensions = 'jpeg,jpg,png,gif';
			
			//get the max filesize in bytes from the component paramaters, if it is not been set, default to 1.5MB
			$configArray =& JComponentHelper::getParams( 'com_igallery' );
			$configUploadImg = $configArray->get('max_upload_img', 1500);
			//we want bytes, but the paramaters give us KB
			$maxUploadImg = $configUploadImg * 1000;
			
			//this function is in our base model
			$uploadedFile = $this->upload_file($field_name, $tempDir, $currentImgsDir, $accept, $maxUploadImg, $okExtensions);
			
			if($uploadedFile == false)
			{
				return false;
			}
			
			//we will make a copy of the uploaded image at 90% quality and 2000 max width, then delete
			//the uploaded file, as it may be 3MB in size
			$origDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'original'.DS;
			
			$JImageTemp = new JImageLib();

			$JImageTemp->load($tempDir.$uploadedFile);
	
	        $JImageTemp->setWidth(2000);
	        $JImageTemp->setHeight(1500);
	
	        if (!$JImageTemp->save( $origDir.$uploadedFile,95) ) 
	        {
	            JError::raise(2, 500, 'M3 '.$uploadedFile .' '. $JImageTemp->getError() ) ;
				return false;
	        }
			
			$imgSize = getimagesize($origDir.$uploadedFile);
			
			$configArray =& JComponentHelper::getParams('com_igallery');
			
			//if the gallery is being made from the front end, the max width/ 
			//max height/ quality may not be set, so we will get it from the default params		
			if( !isset($post['menu_max_width']) )
			{
				$post['menu_max_width'] = $configArray->get('menu_max_width', 200);
			}
			
			if( !isset($post['menu_max_height']) )
			{
				$post['menu_max_height'] = $configArray->get('menu_max_height', 200);
			}
			
			if( !isset($post['img_quality']) )
			{
				$post['img_quality'] = $configArray->get('img_quality', 80);
			}
			
			//make the menu image
			$resizeDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS;
			
			$JImage = new JImageLib();

			$JImage->load($origDir.$uploadedFile);
	
			$JImage->setWidth( intval($post['menu_max_width']) );
	        $JImage->setHeight( intval($post['menu_max_height']) );
			
	        if (!$JImage->save( $resizeDir.$uploadedFile, intval($post['img_quality']) ) ) 
	        {
	            JError::raise(2, 500, 'M4 '.$uploadedFile .' '. $JImage->getError() ) ;
				return false;
	        }
			
			//add the filename to the post array, as we will write it to the database later 
			$post['menu_image_filename'] = $uploadedFile;
			
			//delete the uploaded file
			JFile::delete(JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'temp'.DS.$uploadedFile);
			
			//if there was already a menu image, delete the old image
			if(strlen($row->menu_image_filename) > 1)
			{
				JFile::delete(JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.$row->menu_image_filename);
				JFile::delete(JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'original'.DS.$row->menu_image_filename);
			}
		}
		
		//if the frontend did not send through the image quality, set it to the current quality
		if( !isset($post['img_quality']) )
		{
			$post['img_quality'] = $row->img_quality;
		}
		
		//if the frontend did not send through the crop thumbs, set it to the current value
		if( !isset($post['crop_thumbs']) )
		{
			$post['crop_thumbs'] = $row->crop_thumbs;
		}
		
		//if the frontend did not send through the crop thumbs, set it to the current value
		if( !isset($post['lbox_crop_thumbs']) )
		{
			$post['lbox_crop_thumbs'] = $row->lbox_crop_thumbs;
		}
		
		//if there has been a main image max width and height sent in (front end may not send it)
		if( isset($post['max_width']) && isset($post['max_height']) )
		{
			//if the max width/height is different, or the image quality is different
			if($row->max_width != $post['max_width'] || $row->max_height != $post['max_height'] ||
			$row->img_quality != $post['img_quality'] )
			{
				//we will remake all the main images...
				
				//empty the dir with the main images
				$dirToEmpty = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'large'.DS;
				$d = dir($dirToEmpty); 
				while($entry = $d->read()) 
				{ 
					if ($entry!= "." && $entry!= "..") 
					{ 
				 		if( !JFile::delete($dirToEmpty.$entry) )
				 		{
				 			JError::raise(2, 500, $dirToEmpty.$entry.' '.JText::_( 'FILE DELETE ERROR' ));
							return false;
				 		}
				 	} 
				} 
				$d->close();
				
				//get all the images from the images table that belong to this gallery
				$query = 'SELECT * FROM #__igallery_img WHERE gallery_id = '.intval($this->_id);
				$this->_db->setQuery($query);
				$rows = $this->_db->loadObjectlist();
				
				//we will be taking files from the original dir, and making new ones to go into the large
				$sourceDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'original'.DS;
				$resizeDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'large'.DS;
				
				//every row from database has the filename we need
				for($i=0; $i<count($rows); $i++)
				{
					$currentRow = $rows[$i];
					
					//make the new image
					$JImage = new JImageLib();

					$JImage->load($sourceDir.$currentRow->filename);
			
					$JImage->setWidth( intval($post['max_width']) );
			        $JImage->setHeight( intval($post['max_height']) );
					
			        if (!$JImage->save( $resizeDir.$currentRow->filename, intval($post['img_quality']) ) ) 
			        {
			            JError::raise(2, 500, 'M5 '.$currentRow->filename .' '. $JImage->getError() ) ;
						return false;
			        }
					
					//get the width/height/file size for the database
					$fileSize = filesize($resizeDir.$currentRow->filename)/1000;
					$imgSize = getimagesize($resizeDir.$currentRow->filename);
					
					//update the database with the new image values
					$toDatabase = array();
					$toDatabase['id'] = $currentRow->id;
					$toDatabase['filesize'] = $fileSize;
					$toDatabase['width'] = $imgSize[0];
					$toDatabase['height'] = $imgSize[1];
					
					$imgRow =& $this->getTable('igallery_img');
					
					if (!$imgRow->bind($toDatabase)) 
					{
						JError::raise(2, 500, $row->getError());
						return false;
					}
					
					
					if (!$imgRow->store()) 
					{
						JError::raise(2, 500, $row->getError());
						return false;
					}
					
				}
			}
		}
		
		//if the lightbox width/height has been sent through...
		if( isset($post['lbox_max_width']) && isset($post['lbox_max_height']) )
		{
			//if the width/height or quality has changed
			if($row->lbox_max_width != $post['lbox_max_width'] || $row->lbox_max_height != $post['lbox_max_height'] ||
			$row->img_quality != $post['img_quality'] )
			{
				//empty the lbox folder
				$dirToEmpty = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'lightbox'.DS;
				$d = dir($dirToEmpty); 
				while($entry = $d->read()) 
				{ 
					if ($entry!= "." && $entry!= "..") 
					{ 
				 		if( !JFile::delete($dirToEmpty.$entry) )
				 		{
				 			JError::raise(2, 500, $dirToEmpty.$entry.' '.JText::_( 'FILE DELETE ERROR' ));
							return false;
				 		}
				 	} 
				} 
				$d->close();
				
				//get all the images for this gallery
				$query = 'SELECT * FROM #__igallery_img WHERE gallery_id = '.intval($this->_id);
				$this->_db->setQuery($query);
				$rows = $this->_db->loadObjectlist();
				
				$sourceDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'original'.DS;
				$resizeDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'lightbox'.DS;
				
				
				for($i=0; $i<count($rows); $i++)
				{
					$currentRow = $rows[$i];
					
					//make the new lightbox image
					$JImage = new JImageLib();

					$JImage->load($sourceDir.$currentRow->filename);
			
					$JImage->setWidth( intval($post['lbox_max_width']) );
			        $JImage->setHeight( intval($post['lbox_max_height']) );
					
			        if (!$JImage->save( $resizeDir.$currentRow->filename, intval($post['img_quality']) ) ) 
			        {
			            JError::raise(2, 500, 'M5 '.$currentRow->filename .' '. $JImage->getError() ) ;
						return false;
			        }
			        
					$imgSize = getimagesize($resizeDir.$currentRow->filename);
					
					//write the new details to the database
					$toDatabase = array();
					$toDatabase['id'] = $currentRow->id;
					$toDatabase['lightbox_width'] = $imgSize[0];
					$toDatabase['lightbox_height'] = $imgSize[1];
					
					$imgRow =& $this->getTable('igallery_img');
					
					if (!$imgRow->bind($toDatabase)) 
					{
						JError::raise(2, 500, $row->getError());
						return false;
					}
					
					
					if (!$imgRow->store()) 
					{
						JError::raise(2, 500, $row->getError());
						return false;
					}
					
				}
				
			}
		}
		
		//if the thumb width/height has been sent through...
		if( isset($post['thumb_width']) && isset($post['thumb_height']) )
		{
			//if the width/height or quality has changed
			if($row->thumb_width != $post['thumb_width'] || $row->thumb_height != $post['thumb_height'] 
			|| $row->img_quality != $post['img_quality'] || $row->crop_thumbs != $post['crop_thumbs'])
			{
				//empty the thumb dir
				$dirToEmpty = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'thumbs'.DS;
				$d = dir($dirToEmpty); 
				while($entry = $d->read()) 
				{ 
					if ($entry!= "." && $entry!= "..") 
					{ 
				 		if( !JFile::delete($dirToEmpty.$entry) )
				 		{
				 			JError::raise(2, 500, $dirToEmpty.$entry.' '.JText::_( 'FILE DELETE ERROR' ));
							return false;
				 		} 
				 	} 
				} 
				$d->close();
				
				$query = 'SELECT * FROM #__igallery_img WHERE gallery_id = '.intval($this->_id);
				$this->_db->setQuery($query);
				$rows = $this->_db->loadObjectlist();
				
				$sourceDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'original'.DS;
				$resizeDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'thumbs'.DS;
				
				
				
				for($i=0; $i<count($rows); $i++)
				{
					$currentRow = $rows[$i];
					
					//if the gallery settings are set to make the thumbs the same size
					if($post['crop_thumbs'] == 1)
					{
						$JImage = new JImageLib();
						
						$JImage->load($sourceDir.$currentRow->filename);
				
						$JImage->setWidth( intval($post['thumb_width']) );
				        $JImage->setHeight( intval($post['thumb_height']) );
						
				        if (! $JImage->setResizing('crop'))
						{
			                JError::raise(2, 500, 'M6 '.$currentRow->filename .' '. $JImage->getError() ) ;
			                return false;
			            }
				        
				        if (!$JImage->save( $resizeDir.$currentRow->filename, intval($post['img_quality']) ) ) 
				        {
				            JError::raise(2, 500, 'M7 '.$currentRow->filename .' '. $JImage->getError() ) ;
							return false;
				        }
				        
				        //get the width/height for the database
						$imgSize = getimagesize($resizeDir.$currentRow->filename);
						
						//update the database with the new image values
						$toDatabase = array();
						$toDatabase['id'] = $currentRow->id;
						$toDatabase['thumb_width'] = $imgSize[0];
						$toDatabase['thumb_height'] = $imgSize[1];
						
						$imgRow =& $this->getTable('igallery_img');
					
						if (!$imgRow->bind($toDatabase)) 
						{
							JError::raise(2, 500, $row->getError());
							return false;
						}
						
						
						if (!$imgRow->store()) 
						{
							JError::raise(2, 500, $row->getError());
							return false;
						}
						
					}
					//otherwise resize the thumb down, but do not crop
					else
					{
						$JImage = new JImageLib();

						$JImage->load($sourceDir.$currentRow->filename);
				
						$JImage->setWidth( intval($post['thumb_width']) );
				        $JImage->setHeight( intval($post['thumb_height']) );
						
				        if (!$JImage->save( $resizeDir.$currentRow->filename, intval($post['img_quality']) ) ) 
				        {
				            JError::raise(2, 500, 'M8 '.$currentRow->filename .' '. $JImage->getError() ) ;
							return false;
				        }
				        
				        //get the width/height for the database
						$imgSize = getimagesize($resizeDir.$currentRow->filename);
						
						//update the database with the new image values
						$toDatabase = array();
						$toDatabase['id'] = $currentRow->id;
						$toDatabase['thumb_width'] = $imgSize[0];
						$toDatabase['thumb_height'] = $imgSize[1];
						
						$imgRow =& $this->getTable('igallery_img');
					
						if (!$imgRow->bind($toDatabase)) 
						{
							JError::raise(2, 500, $row->getError());
							return false;
						}
						
						
						if (!$imgRow->store()) 
						{
							JError::raise(2, 500, $row->getError());
							return false;
						}
					}
					
				}
			}
		}
		
		if( isset($post['lbox_thumb_width']) && isset($post['lbox_thumb_height']) )
		{
			if($row->lbox_thumb_width != $post['lbox_thumb_width'] || $row->lbox_thumb_height != $post['lbox_thumb_height'] 
			|| $row->img_quality != $post['img_quality'] || $row->lbox_crop_thumbs != $post['lbox_crop_thumbs'] )
			{
				$dirToEmpty = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'lightbox_thumbs'.DS;
				$d = dir($dirToEmpty); 
				while($entry = $d->read()) 
				{ 
					if ($entry!= "." && $entry!= "..") 
					{ 
				 		if( !JFile::delete($dirToEmpty.$entry) )
				 		{
				 			JError::raise(2, 500, $dirToEmpty.$entry.' '.JText::_( 'FILE DELETE ERROR' ));
							return false;
				 		} 
				 	} 
				} 
				$d->close();
				
				$query = 'SELECT * FROM #__igallery_img WHERE gallery_id = '.intval($this->_id);
				$this->_db->setQuery($query);
				$rows = $this->_db->loadObjectlist();
				
				$sourceDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'original'.DS;
				$resizeDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'lightbox_thumbs'.DS;
				
				for($i=0; $i<count($rows); $i++)
				{
					$currentRow = $rows[$i];
					
					//if the gallery settings are set to make the thumbs the same size
					if($post['lbox_crop_thumbs'] == 1)
					{
						$JImage = new JImageLib();

						$JImage->load($sourceDir.$currentRow->filename);
				
						$JImage->setWidth( intval($post['lbox_thumb_width']) );
				        $JImage->setHeight( intval($post['lbox_thumb_height']) );
						
				        if (! $JImage->setResizing('crop') )
						{
			                JError::raise(2, 500, 'M9 '.$currentRow->filename .' '. $JImage->getError() ) ;
			                return false;
			            }
				        
				        if (!$JImage->save( $resizeDir.$currentRow->filename, intval($post['img_quality']) ) ) 
				        {
				            JError::raise(2, 500, 'M10 '.$currentRow->filename .' '. $JImage->getError() ) ;
							return false;
				        }
				        
				        //get the width/height for the database
						$imgSize = getimagesize($resizeDir.$currentRow->filename);
						
						//update the database with the new image values
						$toDatabase = array();
						$toDatabase['id'] = $currentRow->id;
						$toDatabase['lightbox_thumb_width'] = $imgSize[0];
						$toDatabase['lightbox_thumb_height'] = $imgSize[1];
						
						$imgRow =& $this->getTable('igallery_img');
					
						if (!$imgRow->bind($toDatabase)) 
						{
							JError::raise(2, 500, $row->getError());
							return false;
						}
						
						if (!$imgRow->store()) 
						{
							JError::raise(2, 500, $row->getError());
							return false;
						}
					}
					//otherwise resize the thumb down, but do not crop
					else
					{
						$JImage = new JImageLib();

						$JImage->load($sourceDir.$currentRow->filename);
				
						$JImage->setWidth( intval($post['lbox_thumb_width']) );
				        $JImage->setHeight( intval($post['lbox_thumb_height']) );
						
				        if (!$JImage->save( $resizeDir.$currentRow->filename, intval($post['img_quality']) ) ) 
				        {
				            JError::raise(2, 500, 'M11 '.$currentRow->filename .' '. $JImage->getError() ) ;
							return false;
				        }
				        
				        //get the width/height for the database
						$imgSize = getimagesize($resizeDir.$currentRow->filename);
						
						//update the database with the new image values
						$toDatabase = array();
						$toDatabase['id'] = $currentRow->id;
						$toDatabase['lightbox_thumb_width'] = $imgSize[0];
						$toDatabase['lightbox_thumb_height'] = $imgSize[1];
						
						$imgRow =& $this->getTable('igallery_img');
					
						if (!$imgRow->bind($toDatabase)) 
						{
							JError::raise(2, 500, $row->getError());
							return false;
						}
						
						
						if (!$imgRow->store()) 
						{
							JError::raise(2, 500, $row->getError());
							return false;
						}
					}
				}
				
			}
		}
		
		//if there was menu image uploaded, we have already made it the correct size, if ther wasn't a menu
		//image uploaded, we might have to resize the old one...
		if($imageUploaded != true)
		{
			//if the menu max/width and height were sent through
			if( isset($post['menu_max_width']) && isset($post['menu_max_height']) )
			{
				//if the width/height/quality has changed
				if($row->menu_max_width != $post['menu_max_width'] || $row->menu_max_height != $post['menu_max_height'] ||
				$row->img_quality != $post['img_quality'] )
				{
					if(strlen($row->menu_image_filename) > 2 )
					{
						//delete the current menu image
						JFile::delete(JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.$row->menu_image_filename); 
						
						$sourceDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'original'.DS;
						$resizeDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS;
						
						$JImage = new JImageLib();

						$JImage->load($sourceDir.$row->menu_image_filename);
				
						$JImage->setWidth( intval($post['menu_max_width']) );
				        $JImage->setHeight( intval($post['menu_max_height']) );
						
				        if (!$JImage->save( $resizeDir.$row->menu_image_filename, intval($post['img_quality']) ) ) 
				        {
				            JError::raise(2, 500, 'M12 '.$row->menu_image_filename .' '. $JImage->getError() ) ;
							return false;
				        }
					}	
				}
			}
		}
		
		
		//if remove menu image has been set to yes and there is a current menu image
		$menuImageDeleted = false;
		if($post['remove_menu_image'] == 1 && strlen($row->menu_image_filename) > 1)
		{
			//delete the menu image
			JFile::delete(JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.$row->menu_image_filename);
			JFile::delete(JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'original'.DS.$row->menu_image_filename);
			$menuImageDeleted = true;
		}
		
		$post['id'] = intval($this->_id);
		
		$row =& $this->getTable('igallery');
		if (!$row->bind($post)) 
		{
			JError::raise(2, 500, $row->getError());
			return false;
		}
		
		if( strlen($row->alias) < 1)
		{
			$row->alias = $row->name;
		}
		
		$row->alias = ereg_replace("[^A-Za-z0-9]", "-", $row->alias);
		$row->alias = strtolower($row->alias);
		
		if($menuImageDeleted == true)
		{
			$row->menu_image_filename = '';
		}
		
		$row->gallery_description = JRequest::getVar( 'gallery_description', '', 'post', 'string', JREQUEST_ALLOWHTML );
		$row->menu_description = JRequest::getVar( 'menu_description', '', 'post', 'string', JREQUEST_ALLOWHTML );
		
		if (!$row->store()) 
		{
			JError::raise(2, 500, $row->getError());
			return false;
		}
		
		return true;
	}
	
	function delete($backend)
	{
		//import the file/folder functions so we can delete with the ftp user
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		
		$configArray =& JComponentHelper::getParams('com_igallery');
		
		//we need the folder name for this gallery
		$query = 'SELECT * FROM #__igallery WHERE id = '.intval($this->_id);
		$this->_db->setQuery($query);
		$this->_row = $this->_db->loadObject();
		
		//if we are in the frontend, check that this gallery belongs to the user,
		//or that they are allowed to edit all galleries
		if($backend != true)
		{
			$user   =& JFactory::getUser();
			
			$allowEditAll = $configArray->get('frontend_edit_all', 0);
			if( $user->id != $this->_row->user && $allowEditAll != 1)
			{
				JError::raise(2, 500, JText::_( 'RESTRICTED ACCESS' ));
				return false;
			}
		}
		
		$folders_to_remove = array();
		$folders_to_remove[0] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_row->folder.DS.'large'.DS;
		$folders_to_remove[1] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_row->folder.DS.'lightbox'.DS;
		$folders_to_remove[2] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_row->folder.DS.'lightbox_thumbs'.DS;
		$folders_to_remove[3] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_row->folder.DS.'original'.DS;
		$folders_to_remove[4] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_row->folder.DS.'thumbs'.DS;
		$folders_to_remove[5] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_row->folder.DS.'temp'.DS;
		$folders_to_remove[6] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_row->folder.DS;
		
		//for each folder, empty it, then delete it
		for($i = 0; $i < count($folders_to_remove); $i++)
		{
			if (JFolder::exists($folders_to_remove[$i]))
			{
				$d = dir($folders_to_remove[$i]); 
				while($entry = $d->read()) 
				{ 
					if ($entry!= "." && $entry!= "..") 
					{ 
						if( !JFile::delete($folders_to_remove[$i].$entry) )
				 		{
				 			JError::raise(2, 500, $folders_to_remove[$i].$entry.' '.JText::_( 'FILE DELETE ERROR' ));
							return false;
				 		} 
				 	} 
				} 
				$d->close();
				
				if (!JFolder::delete($folders_to_remove[$i])) 
				{
					JError::raise(2, 500, $folders_to_remove[$i]. ' ' .JText::_( 'FOLDER DELETE ERROR' ) );
					return false;
				}	
			}
		}
		
		//get all the image rows in the image table, that belong to this gallery
		$query = 'SELECT id FROM #__igallery_img WHERE gallery_id = '.intval($this->_id);
		$this->_db->setQuery($query);
		$images = $this->_db->loadObjectlist();
		
		
		for($i=0; $i<count($images);$i++)
		{
			$row = $images[$i];
			
			//delete all the rows in the rating table, that are for an image in this gallery
			$query = 'DELETE FROM #__igallery_rating WHERE img_id = '.intval($row->id);
			$this->_db->setQuery($query);
			if(!$this->_db->query()) 
			{
				JError::raise(2, 500, $this->_db->getErrorMsg());
				return false;
			}
			
			//delete all the rows in the comments table, that are for an image in this gallery
			$query = 'DELETE FROM #__igallery_comments WHERE img_id = '.intval($row->id);
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) 
			{
				JError::raise(2, 500, $this->_db->getErrorMsg());
				return false;
			}
			
			//delete all the image rows
			$query = 'DELETE FROM #__igallery_img WHERE id = '.intval($row->id);
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) 
			{
				JError::raise(2, 500, $this->_db->getErrorMsg());
				return false;
			}
			
		}
		
		//delete the gallery row itself
		$query = 'DELETE FROM #__igallery WHERE id = '.intval($this->_id);
		$this->_db->setQuery($query);
		if(!$this->_db->query()) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}
		
		return true;
	}
	
	function cat_save($post)
	{
		
		//import joomlas file system so we can write with the ftp user if nescessary
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		
		include_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'jimagelib'.DS.'JImageLib.php');
		
		//get the components paramaters
		$configArray =& JComponentHelper::getParams('com_igallery');
		
		//if a category is made before a gallery, we these folders will not have been made yet
		$folders_to_make = array();
		$folders_to_make[0] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery';
		$folders_to_make[1] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics';
		$folders_to_make[2] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics'.DS.'temp';
		
		//if they dont exist, make the folders
		for($i = 0; $i<count($folders_to_make); $i++)
		{
			if ( !JFolder::exists($folders_to_make[$i]) )
			{
				if (! JFolder::create($folders_to_make[$i], 0755) ) 
				{
					JError::raise(2, 500, $folders_to_make[$i] .' '. JText::_( 'FOLDER CREATE ERROR' ) );
					return false;
				}
			}
		}
		
		//if we are saving changes to an existing category, we need some of its details
		$row =& $this->getTable('igallery');
		$row->load($this->_id);
		
		$imageUploaded = false;
		//if there was an image uploaded
		if(strlen($_FILES['upload_image']['name']) > 2 )
		{
			//the name of the html form element
			$field_name = 'upload_image';
			
			//where we will put the uploaded image
			$tempDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics'.DS.'temp'.DS;
			
			//our upload function needs to check if there is a file with the same name
			$currentImgsDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics'.DS;
			
			//our upload function will do a mime/file ext check
			$accept = 'image/jpeg,image/pjpeg,image/png,image/x-png,image/gif';
			$okExtensions = 'jpeg,jpg,png,gif';
			
			//max filesize for upload
			$configArray =& JComponentHelper::getParams( 'com_igallery' );
			$configUploadImg = $configArray->get('max_upload_img', 1500);
			$maxUploadImg = $configUploadImg * 1000;
			
			//the upload function is in base.php
			$uploadedFile = $this->upload_file($field_name, $tempDir, $currentImgsDir, $accept, $maxUploadImg, $okExtensions);
			if($uploadedFile == false)
			{
				return false;
			}
			
			//the directory for the menu pic 
			$resizeDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics'.DS;
			
			
			//make the menu pic at the correct size
			$JImage = new JImageLib();

			$JImage->load($tempDir.$uploadedFile);
	
			$JImage->setWidth( intval($post['menu_max_width']) );
	        $JImage->setHeight( intval($post['menu_max_height']) );
			
	        if (!$JImage->save( $resizeDir.$uploadedFile, $configArray->get('img_quality', 90) ) ) 
	        {
	            JError::raise(2, 500, 'M14 '.$uploadedFile .' '. $JImage->getError() ) ;
				return false;
	        }
			
			//save the filename for database writing
			$post['menu_image_filename'] = $uploadedFile;
			
			//if there was a menu image before, then delete the old one
			if(strlen($row->menu_image_filename) > 1)
			{
				JFile::delete(JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics'.DS.$row->menu_image_filename);
			}
			$imageUploaded = true;
		}
		
		//if there is already a menu image, and we didnt just upload a new one
		if($row->menu_image_filename != null && $imageUploaded == false)
		{
			//if the size has changed
			if($row->max_width != $post['menu_max_width'] || $row->max_height != $post['menu_max_height']  )
			{
				//delete the old image
				JFile::delete(JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics'.DS.$row->menu_image_filename);
				
				$tempDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics'.DS.'temp'.DS;
				$resizeDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics'.DS;
				
				//make the image with the new width and height
				$JImage = new JImageLib();

				$JImage->load($tempDir.$row->menu_image_filename);
		
				$JImage->setWidth( intval($post['menu_max_width']) );
		        $JImage->setHeight( intval($post['menu_max_height']) );
				
		        if (!$JImage->save( $resizeDir.$row->menu_image_filename, $configArray->get('img_quality', 90) ) ) 
		        {
		            JError::raise(2, 500, 'M15 '.$uploadedFile .' '. $JImage->getError() ) ;
					return false;
		        }
			
			}
		}
		
		//if the 'remove menu image' has been set to yes, and there is a menu image
		$menuImageDeleted = false;
		if($post['remove_menu_image'] == 1 && strlen($row->menu_image_filename) > 1)
		{ 
			JFile::delete(JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics'.DS.$row->menu_image_filename);
			$menuImageDeleted = true;
		}
		
		
		if (!$row->bind($post)) 
		{
			JError::raise(2, 500, $row->getError());
			return false;
		}
		
		if( strlen($row->alias < 1) )
		{
			$row->alias = $row->name;
		}
		
		$row->alias = ereg_replace("[^A-Za-z0-9]", "-", $row->alias);
		$row->alias = strtolower($row->alias);
		
		//if this is a new category, get the order
		if($row->ordering == null )
		{
			$row->ordering = $row->getNextOrder('parent = '.intval($row->parent).' AND type = 0');
		}
		
		$row->menu_description = JRequest::getVar( 'menu_description', '', 'post', 'string', JREQUEST_ALLOWHTML );
		
		//category = 0, gallery = 1
		$row->type = 0;
		
		if($menuImageDeleted == true)
		{
			$row->menu_image_filename = '';
		}
		
		if (!$row->store()) 
		{
			JError::raise(2, 500, $row->getError());
			return false;
		}
	}
	
	function cat_delete()
	{
		//load the category row from the database
		$row =& $this->getTable('igallery');
		$row->load($this->_id);
		
		//if the category has an image, delete the image
		if(strlen($row->menu_image_filename) > 1)
		{
			unlink(JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics'.DS.$row->menu_image_filename);
		}
		
		//delete the category row
		$query = 'DELETE FROM #__igallery WHERE id = '.$this->_id;
		$this->_db->setQuery($query);
		if(!$this->_db->query()) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}
		
		//if there were any children of this category, make their parent 0 (top level)
		//so we can still see them in the tree list.
		$query = 'SELECT id from #__igallery where parent = '.intval($this->_id);
		$this->_db->setQuery($query);
		$children = $this->_db->loadObjectlist();
		
		for($i=0; $i<count($children);$i++)
		{
			$row = $children[$i];
			
			$query = 'UPDATE #__igallery SET parent = 0 WHERE parent = '.intval($this->_id);
			$this->_db->setQuery($query);
			if(!$this->_db->query()) 
			{
				JError::raise(2, 500, $this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}
	
	function publish($publish)
	{
		$cids = implode( ',', $this->_cid );
		$query = 'UPDATE #__igallery SET published = '. $publish . ' WHERE id IN ( '.$cids.' )';
		$this->_db->setQuery($query);
		if ( !$this->_db->query() ) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}

		return true;
	}
	
	function move($direction)
	{	
		$row =& $this->getTable('igallery');
		if (!$row->load($this->_id)) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}
		
		$row->move( $direction, 'parent = '.intval($row->parent).' AND type = 1' );
		
		if (!$row->reorder('parent = '.intval($row->parent).' AND type = 1')) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}
		return true;
	}
	
	function cat_move($direction)
	{	
		$row =& $this->getTable('igallery');
		if (!$row->load($this->_id)) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}
		
		$row->move($direction,'parent = '.intval($row->parent).' AND type = 0');
		
		if (!$row->reorder('parent = '.intval($row->parent).' AND type = 0')) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}
		return true;
	}
	
	function saveorder()
	{		
		$row =& $this->getTable('igallery');
		$groupings = array();
		
		for($i=0; $i < count($this->_cid); $i++)
		{
			$row->load( (int)$this->_cid[$i] );
			
			if($row->ordering != $this->_order[$i])
			{
				$row->ordering = $this->_order[$i];
				
				if (!$row->store()) 
				{
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}
		}
		return true;
	}
	
}	


?>

