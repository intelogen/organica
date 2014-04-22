<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'base.php');

class manageModelmanage extends igalleryModelbase
{
	var $_id = null;
	var $_photo = null;
	var $_photolist = null;
	var $_total = null;
	var $_pagination = null;

	
	function __construct()
	{
		parent::__construct();

		global $mainframe, $option; 
		
		//get the two vars for pagination
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( $option.'.manage.limitstart', 'limitstart', 0, 'int' );
		
		//set the pagination vars
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
		
		$cid = JRequest::getVar('cid',  array(0), '', 'array');
		$gid = JRequest::getInt('gid', 0);
		$order 	= JRequest::getVar('order', array(0), 'post', 'array');
		$task 	= JRequest::getVar('task', '');
		
		$this->setValues($cid[0], $cid, $gid, $order, $task);
	}
	
	function setValues($id, $cid, $gid, $order, $task)
	{
		$this->_id = (int)$id;
		
		$this->_cid = $cid;
		JArrayHelper::toInteger($this->_cid);
		
		$this->_order = $order;
		JArrayHelper::toInteger($this->_order);
		
		$this->_gid = (int)$gid;
		
		$this->_task = $task;
	}
	
	function getPhotoList()
	{
		if (empty($this->_photolist))
		{
			$query = $this->_buildQuery();
			$this->_photolist = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}
		return $this->_photolist;
	}
	
	function _buildQuery()
	{
		$orderby	= $this->_buildContentOrderBy();
		$query = 'SELECT * from #__igallery_img WHERE gallery_id = '.$this->_gid . $orderby;
		return $query;
	}
	
	function _buildContentOrderBy()
	{
		global $mainframe, $option;

		$filter_order     = $mainframe->getUserStateFromRequest( $option.'manage.filter_order',      'filter_order', 'ordering', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'manage.filter_order_Dir',  'filter_order_Dir', '', 'word' );
		$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir;			
		
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
	
	function getGallery()
	{
		$query = 'SELECT * FROM #__igallery WHERE id = '. intval($this->_gid);
		$this->_db->setQuery($query);
		$this->_gallery = $this->_db->loadObject();
		return  $this->_gallery;
	}
	
	function getPhotos()
	{
		$query = 'SELECT * from #__igallery_img WHERE gallery_id = '.$this->_gid.' ORDER BY ordering';
		$this->_db->setQuery($query);
		$this->_photos = $this->_db->loadObjectList();
		return  $this->_photos;
	}
	
	
	function upload($post, $backend)
	{
		
		//import joomlas filesystem functions, we will do all the filewriting with joomlas functions,
		//so if the ftp layer is on, joomla will write with that, not the apache user, which might
		//not have the correct permissions
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		
		$configArray =& JComponentHelper::getParams( 'com_igallery' );
		
		//import the new Jimage library. This is not currently in the joomla package at the time of the
		//Ignite Gallery 2.1 release, so we will keep it in the component until Joomla includes it
		include_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'jimagelib'.DS.'JImageLib.php');
		
		//this is the name of the field in the html form, filedata is the default name for swfupload
		//so we will leave it as that
		$fieldName = 'Filedata';
		
		//get the filename of the file that was uploaded, we will need this when making the images
		$uploadedFileName = $_FILES[$fieldName]['name'];
		
		//we also need some extra data from the gallery, such as what the max image sizes are
		$query = 'SELECT * FROM #__igallery WHERE id = '. intval($this->_gid);
		$this->_db->setQuery($query);
		$this->_gallery = $this->_db->loadObject();
		
		//if we are in the frontend, check that this gallery belongs to the user,
		//or that they are allowed to edit all galleries
		if($backend != true)
		{
			$user   =& JFactory::getUser();
			
			$allowEditAll = $configArray->get('frontend_edit_all', 0);
			if( $user->id != $this->_gallery->user && $allowEditAll != 1)
			{
				JError::raise(2, 500, JText::_( 'RESTRICTED ACCESS' ));
				return false;
			}
		}
		
		//UPLOAD A FILE TO THE TEMP DIR...
		
		//we will put the file in the temp dir as is, even if it is 3MB in size, we will resize later
		$tempDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_gallery->folder.DS.'temp'.DS;
		
		//let the upload function know where the current images for this gallery are, so it can pick a unique
		//filename if the current filename exists
		$currentImgsDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_gallery->folder.DS.'original'.DS;
		
		//we will do a check in the upload function on MIME and file extension, so we are uploading an image, not
		//a php file etc.
		$accept = 'image/jpeg,image/pjpeg,image/png,imagex-png,image/x-png,image/gif';
		$okExtensions = 'jpeg,jpg,png,gif';
		
		//get the max filesize in bytes from the component paramaters, if it is not been set, default to 1.5MB
		$configUploadImg = $configArray->get('max_upload_img', 1500);
		//we want bytes, but the paramaters give us KB
		$maxUploadImg = $configUploadImg * 1000;
		
		//give our upload function all the info we just collected, it will upload the file
		$uploadedFile = $this->upload_file($fieldName, $tempDir, $currentImgsDir, $accept, $maxUploadImg, $okExtensions);
		
		//if there was an error in uploading, the upload function will raise the correct error message
		//and return false. If it does return false, we want to return false here.
		if($uploadedFile == false)
		{
			return false;
		}
		
		//get the image size of the file we just uploaded. The $uploadedFile var is the filename returned from
		//the upload function
		$origImgSize = getimagesize($tempDir.$uploadedFile);
		
		//MAKE THE ORIGINAL IMAGE. 
		
		//There is a problem with keeping the actual image that was uploaded, as it may
		//be 3MB in size. When someone tries to change the quality of the images, the component deletes all the
		//images and remakes them from the original image. If we keep 30 3MB images for this gallery, the server
		//will timeout when we try to make 30 new images, as 3MB is a lot to process. So to workaround we make
		//a copy of the uploaded image with a max width of 2000, max height of 1500, and a quality of 95.
		//This will be a good quality "original" image, that is > 500KB. 
		$origDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_gallery->folder.DS.'original'.DS;
		
		$JImageTemp = new JImageLib();

		$JImageTemp->load($tempDir.$uploadedFile);

        $JImageTemp->setWidth(2000);
        $JImageTemp->setHeight(1500);

        if (!$JImageTemp->save( $origDir.$uploadedFile,95) ) 
        {
            echo  'R1 '.$origDir.$uploadedFile .' '. $JImageTemp->getError();
			return false;
        }
		
		//MAKE THE THUMBNAIL IMAGE.
		$thumbDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_gallery->folder.DS.'thumbs'.DS;

		$JImage = new JImageLib();

		$JImage->load($origDir.$uploadedFile);

		$JImage->setWidth( intval($this->_gallery->thumb_width) );
        $JImage->setHeight( intval($this->_gallery->thumb_height) );

		//if the gallery settings are set to make the thumbs the same size
		if($this->_gallery->crop_thumbs == 1)
		{
		    if (! $JImage->setResizing('crop'))
		    {
                echo  'R2 '.$uploadedFile .' '. $JImage->getError();
                return false;
            }

            if ( !$JImage->save($thumbDir.$uploadedFile, intval($this->_gallery->img_quality) ) ) 
            {
                echo  'R3 '.$thumbDir.$uploadedFile .' '. $JImage->getError();
                return false;
            }
		}
		//otherwise resize the thumb down, but do not crop
		else
		{
			if (! $JImage->setResizing() )
			{
                echo  'R4 '.$uploadedFile .' '. $JImage->getError();
                return false;
            }

            if (! $JImage->save($thumbDir.$uploadedFile, intval($this->_gallery->img_quality) ) ) 
            {
                echo  'R5 '.$thumbDir.$uploadedFile .' '. $JImage->getError();
                return false;
            }
		}

		//MAKE THE LIGHTBOX THUMBNAIL IMAGE.
		$lboxThumbDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_gallery->folder.DS.'lightbox_thumbs'.DS;

		$JImage->setWidth( intval($this->_gallery->lbox_thumb_width) );
        $JImage->setHeight( intval($this->_gallery->lbox_thumb_height) );

		if($this->_gallery->lbox_crop_thumbs == 1)
		{
			if (! $JImage->setResizing('crop') )
			{
                echo  'R6 '.$uploadedFile .' '. $JImage->getError();
                return false;
            }

            if ( !$JImage->save($lboxThumbDir.$uploadedFile, intval($this->_gallery->img_quality) ) ) 
            {
                echo  'R7 '.$lboxThumbDir.$uploadedFile .' '. $JImage->getError();
                return false;
            }
		}
		else
		{
            if (! $JImage->setResizing())
            {
                echo  'R8 '.$uploadedFile .' '. $JImage->getError();
                return false;
            }

            if (! $JImage->save($lboxThumbDir.$uploadedFile,intval($this->_gallery->img_quality) ) ) 
            {
                echo  'R9 '.$lboxThumbDir.$uploadedFile .' '. $JImage->getError();
                return false;
            }
		}

		//MAKE THE MAIN IMAGE.
		$mainImageDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_gallery->folder.DS.'large'.DS;

		$JImage->setWidth( intval($this->_gallery->max_width) );
        $JImage->setHeight( intval($this->_gallery->max_height) );

        if (! $JImage->setResizing())
        {
            echo  'R10 '.$uploadedFile .' '. $JImage->getError();
            return false;
        }

        if (! $JImage->save($mainImageDir.$uploadedFile, intval($this->_gallery->img_quality) ) ) 
        {
            echo  'R11 '.$mainImageDir.$uploadedFile .' '. $JImage->getError();
            return false;
        }

		//MAKE THE LIGHTBOX IMAGE.
		$lboxDir = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_gallery->folder.DS.'lightbox'.DS;

		$JImage->setWidth( intval($this->_gallery->lbox_max_width) );
        $JImage->setHeight( intval($this->_gallery->lbox_max_height) );

        if (! $JImage->setResizing())
        {
            echo  'R12 '.$uploadedFile .' '. $JImage->getError();
            return false;
        }

        if (! $JImage->save($lboxDir.$uploadedFile, intval($this->_gallery->img_quality) ) ) 
        {
            echo  'R13 '.$lboxDir.$uploadedFile .' '. $JImage->getError();
            return false;
        }
		
		//delete the file that was uploaded, we have a smaller copy of it in the original folder
		JFile::delete($tempDir.$uploadedFile);
		
		//get all the image sizes of the files we just made, we need these for the database
		$thumbImgSize = getimagesize($thumbDir.$uploadedFile);
		$lboxThumbImgSize = getimagesize($lboxThumbDir.$uploadedFile);
		$mainImgSize = getimagesize($mainImageDir.$uploadedFile);
		$lboxImgSize = getimagesize($lboxDir.$uploadedFile);
		
		
		//get the filesize of the main image in KB
		$mainImgfileSize = filesize($mainImageDir.$uploadedFile)/1000;
		
		//get the object for the igallery_img table, so we can bind some values to it
		$row =& $this->getTable('igallery_img');
		
		//file name and size
		$row->filename = $uploadedFile;
		$row->filesize = round($mainImgfileSize);
		
		//img width and heights
		$row->thumb_width = $thumbImgSize[0];
		$row->thumb_height = $thumbImgSize[1];
		$row->lightbox_thumb_width = $thumbImgSize[0];
		$row->lightbox_thumb_height = $thumbImgSize[1];
		$row->width = $mainImgSize[0];
		$row->height = $mainImgSize[1];
		$row->lightbox_width = $lboxImgSize[0];
		$row->lightbox_height = $lboxImgSize[1];
		
		//image access and link target default can be set in cpmponent paramaters
		$configArray =& JComponentHelper::getParams( 'com_igallery' );
		$row->target_blank = $configArray->get('target_blank', 1);
		$row->access = $configArray->get('new_image_access', 0);
		$row->published = $configArray->get('new_image_published', 1);
		
		//the gallery id and order
		$row->gallery_id = $this->_gid;
		$row->ordering = $row->getNextOrder('gallery_id = '.intval($this->_gid) );
		
		//we want to let the description have html in it, jrequest strips this by default. Javascript will
		//still get stripped, so no XSS from front end users
		$row->description = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWHTML );
		
		$row->alt_text = JRequest::getVar( 'alt_text','');
		
		//store all our data to the database
		if( !$row->store() ) 
		{
		  	if($this->_task == 'upload_image')
		  	{
		  		echo $row->getError();
		  	}
		  	else
		  	{
		  		JError::raise( 2, 500,$row->getError() );
		  	}
			return false;
		}
		return true;
	}
	
	function save_edit_photo($post, $backend)
	{	
		$configArray =& JComponentHelper::getParams( 'com_igallery' );
		
		//if we are in the frontend, check that this gallery belongs to the user,
		//or that they are allowed to edit all galleries
		$row =& $this->getTable('igallery');
		$row->load($this->_gid);
		
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
		
		$post['id'] = (int)$this->_id;
		
		$row =& $this->getTable('igallery_img');
		if (!$row->bind($post)) 
		{
			JError::raise(2, 500, $row->getError());
			return false;
		}
	
		$row->description = JRequest::getVar( 'description', '', 'post', 'string', JREQUEST_ALLOWHTML );
		
		if (!$row->store()) 
		{
			JError::raise(2, 500, $row->getError());
			return false;
		}
		
		return true;
	}
	
	function publish($publish)
	{
		$cids = implode( ',', $this->_cid );
		$query = 'UPDATE #__igallery_img SET published = '. $publish . ' WHERE id IN ( '.$cids.' )';
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
		$row =& $this->getTable('igallery_img');
		if (!$row->load($this->_id)) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}
		
		$row->move($direction, 'gallery_id = '.$this->_gid); 
		
		if (!$row->reorder('gallery_id = '.$this->_gid)) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}
		return true;
	}
	
	
	
	function saveorder()
	{		
		$row =& $this->getTable('igallery_img');
		$groupings = array();
		
		for($i=0; $i < count($this->_cid); $i++)
		{
			$row->load( (int)$this->_cid[$i] );
			
			if($row->ordering != $this->_order[$i])
			{
				$row->ordering = $this->_order[$i];
				
				if (!$row->store()) 
				{
					JError::raise(2, 500, $this->_db->getErrorMsg());
					return false;
				}
			}
		}
		$row =& $this->getTable('igallery_img');
		
		if (!$row->reorder('gallery_id = '.$this->_gid)) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}
		return true;
	}

	
	function deletePhoto($post, $backend)
	{
		$configArray =& JComponentHelper::getParams( 'com_igallery' );
		
		//if we are in the frontend, check that this gallery belongs to the user,
		//or that they are allowed to edit all galleries
		$row =& $this->getTable('igallery');
		$row->load($this->_gid);
		
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
		
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		
		for($i=0; $i<count($this->_cid); $i++)
		{
			$row =& $this->getTable('igallery_img');
			$row->load( intval($this->_cid[$i]) );
			
			$query = 'SELECT folder FROM #__igallery WHERE id = '.intval($this->_gid);
			$this->_db->setQuery($query);
			$this->_gallery_row = $this->_db->loadObject();
			
			$filesToDelete = array();
			$filesToDelete[0] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_gallery_row->folder.DS.'thumbs'.DS.$row->filename;
			$filesToDelete[1] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_gallery_row->folder.DS.'large'.DS.$row->filename;
			$filesToDelete[2] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_gallery_row->folder.DS.'lightbox'.DS.$row->filename;
			$filesToDelete[3] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_gallery_row->folder.DS.'lightbox_thumbs'.DS.$row->filename;
			$filesToDelete[4] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$this->_gallery_row->folder.DS.'original'.DS.$row->filename;
			
			
			for($k=0; $k<count($filesToDelete); $k++)
			{
				if(JFile::exists($filesToDelete[$k]))
				{ 
					if( !JFile::delete($filesToDelete[$k]) )
					{
						JError::raise(2, 500, $filesToDelete[$k]. ' ' .JText::_( 'FILE DELETE ERROR' ) );
						return false;
					}
				}
			}
		
		}
		
		$cids = implode( ',', $this->_cid );
		$query = 'DELETE FROM #__igallery_img WHERE id IN ( '.$cids.' )';
		$this->_db->setQuery($query);
		if(!$this->_db->query()) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}
		
		$query = 'DELETE FROM #__igallery_comments WHERE img_id IN ( '.$cids.' )';
		$this->_db->setQuery($query);
		if(!$this->_db->query()) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}
		
		$query = 'DELETE FROM #__igallery_rating WHERE img_id IN ( '.$cids.' )';
		$this->_db->setQuery($query);
		
		if(!$this->_db->query()) 
		{
			JError::raise(2, 500, $this->_db->getErrorMsg());
			return false;
		}
		
		$row =& $this->getTable('igallery_img');
		$row->reorder('gallery_id = '.intval($this->_gid) );
		
		return true;
	}
	

}	


?>

