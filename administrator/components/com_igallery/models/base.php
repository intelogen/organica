<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class igalleryModelbase extends JModel
{
	function __construct()
	{
		parent::__construct();
	}
	
	function upload_file($fieldName, $destDir, $currentImgsDir, $accept, $maxUploadSize,$extAccept) 
	{
		
		//the name of the file in PHP's temp directory that we are going to move to our folder
		$fileTemp = $_FILES[$fieldName]['tmp_name'];
		
		//the name of the file (as it was named on the uploaders computer)
		$fileName = $_FILES[$fieldName]['name'];
		
		//the size of the file in bytes
		$fileSize = $_FILES[$fieldName]['size'];
		
		//any errors the server registered on uploading
		$fileError = $_FILES[$fieldName]['error'];
		
	
		//if there were any error...
		if ($fileError > 0) 
		{
			switch ($fileError) 
			{
				//the file was lager than php.ini allowed
			  	case 1:
			  	$message = 'U1 '.$fileName . JText::_( 'FILE TO LARGE INI' );
			  	if($this->_task == 'upload_image')
			  	{
			  		echo $message;
			  	}
			  	else
			  	{
			  		JError::raise(2, 500,$message);
			  	}
				break;
				
				//the file was larger than the html form said, the html form does not have
				//a max_size attribute, so this is unlikely to come up as an error
				case 2:
				$message = 'U2 '.$fileName . JText::_( 'FILE TO LARGE HTML' );
			  	if($this->_task == 'upload_image')
			  	{
			  		echo $message;
			  	}
			  	else
			  	{
			  		JError::raise(2, 500,$message);
			  	}
				break;
			  	
				//the upload did not complete
			  	case 3:
		  		$message = 'U3 '.$fileName . JText::_( 'ERROR PARTIAL UPLOAD' );
			  	if($this->_task == 'upload_image')
			  	{
			  		echo $message;
			  	}
			  	else
			  	{
			  		JError::raise(2, 500,$message);
			  	} 
			  	
			  	//no file was sent
			  	case 4:
		  		$message = 'U4 '.$fileName . JText::_( 'ERROR NO FILE' );
			  	if($this->_task == 'upload_image')
			  	{
			  		echo $message;
			  	}
			  	else
			  	{
			  		JError::raise(2, 500,$message);
			  	}
			}
			return false;
		}
	
		//if the filesize is larger than what the component paramaters say, raise an error and return
		if ($maxUploadSize < $fileSize) 
		{
			
			$message = 'U5 - '.$fileName .' - '.JText::_( 'FILESIZE' ).': '.$fileSize/1000 .'KB - '.
			JText::_( 'MAXIMUM FILESIZE' ).': '.$maxUploadSize/1000 .'KB - '. JText::_( 'FILE TO LARGE' );
		  	
			if($this->_task == 'upload_image')
		  	{
		  		echo $message;
		  	}
		  	else
		  	{
		  		JError::raise(2, 500,$message);
		  	}
			return false;
		}
					
		
		//CHECK FILE EXTENSION PART
		
		//get an array from the passed string of ok file extensions
		$validFileExts = explode(",", $extAccept);
		
		//get the last bit of the filename after the dot
		$uploadedFileNameParts = explode('.',$fileName);
		$uploadedFileExtension = array_pop($uploadedFileNameParts);
		
		//assume the extension is false until we know its ok
		$extOk = false;
		
		//go through every ok extension, if the ok extension matches the file extension (case insensitive)
		//then the file extension is ok
		foreach($validFileExts as $key => $value)
		{
			if( preg_match("/$value/i", $uploadedFileExtension ) )
			{
				$extOk = true;
			}
		}
		
		//if there was not a match, raise an error and return
		if ($extOk == false) 
		{
			$message = 'U6b '. JText::_( 'INCORRECT FILETYPE' ). ' Filetype: '.$uploadedFileExtension.
			', Allowed: '. $extAccept;
		  	if($this->_task == 'upload_image')
		  	{
		  		echo $message;
		  	}
		  	else
		  	{
		  		JError::raise(2, 500,$message);
		  	}
			return false;
		}
		
		
		//GET-IMAGE-SIZE PART
		//for security purposes, we will also do a getimagesize on the temp file (before we have moved it 
		//to the folder) to check the MIME type of the file, and whether it has a width and height
		$imageinfo = getimagesize($fileTemp);
		
		//get the ok image types as an array from the paramater passed
		$validFileTypes = explode(",", $accept);
		
		//if the width or height is not an integer, or if the MIME returned is not in our ok array
		//then raise an error and return
		if( !is_int($imageinfo[0]) || !is_int($imageinfo[1]) ||  !in_array($imageinfo['mime'], $validFileTypes) )
		{
			$message = 'U6c '. JText::_( 'INCORRECT FILETYPE' ). ' Filetype: '.$imageinfo[0].' '.$imageinfo[1].' '.$imageinfo['mime'].
			', Allowed: '. $accept;
		  	if($this->_task == 'upload_image')
		  	{
		  		echo $message;
		  	}
		  	else
		  	{
		  		JError::raise(2, 500,$message);
		  	}
			return false;
		}
		
		
		//lose any special characters in the filename. Some servers dont like spaces in the filename
		//so we will lose these too, Fancy characters go in the database description, not the filename!
		//if its not alphanumeric or a dot, then replace it with a _
		$fileName = ereg_replace("[^A-Za-z0-9.]", "-", $fileName);
		
		
		
		//CHECK IF FILENAME IS UNIQUE PART
		
		//if a file with the same name exists in this gallery
		if(JFile::exists($currentImgsDir.$fileName) ) 
		{	
			//get the bit before and after the dot
			$fileNameParts = explode('.',$fileName);
			$i=1;
			
			//keep putting a number in after the filename (before the .ext), until that filename
			//with that number does not exist in out current dir
			while(JFile::exists($currentImgsDir.$fileNameParts[0].$i.'.'.$fileNameParts[1]) ) 
			{
				$i++;
			}
			//overwrite the filanme var with the unique name
			$fileName = $fileNameParts[0].$i.'.'.$fileNameParts[1];
		}
		
		//our full destination path is the path passed to this function, plus the unique filename
		$destPath = $destDir.$fileName;
		
		//if moving the temp file to the destination dir is not successful, raise an error
		if(!JFile::upload($fileTemp, $destPath)) 
		{
			$message = 'U7 '. $fileTemp.' -> '.$destPath .' '. JText::_( 'ERROR MOVING FILE' );
		  	if($this->_task == 'upload_image')
		  	{
		  		echo $message;
		  	}
		  	else
		  	{
		  		JError::raise(2, 500,$message);
		  	}
			return false;
		}
		
		//return the new filename, so our resize/crop functions know how to name the images
		return $fileName;
	}
	
	function getCatList()
	{
		//if we are in the edit gallery/category screen, get the current category, so it will be highlighted
		$cidArray = JRequest::getVar('cid',  array(0), '', 'array');
		$cid = (int)$cidArray[0];
		
		//if cid is 0, we are in the new gallery/category screen, so we want the active select box item to be 'top'
		if($cid == 0)
		{
			$row = new stdClass();
			$row->id = null;
			$row->parent = 0;
		}
		//otherwise load the row for this gallery/category, so we know what its parent is
		else
		{
			$row =& $this->getTable('igallery');
			$row->load($cid);
		}
		
		//if there is an id in the url, we dont want that category to show
		//up in the parent select list (as a category can not have itself as a parent)
		$id = '';
	    if( $row->id != null )
	    {
	        $id = 'AND id != '.$row->id;
	    }
		
		
		//get all the categories
		$query = 'SELECT * FROM #__igallery WHERE type = 0 '.$id.' ORDER BY parent, ordering';
		$this->_db->setQuery($query);
		$this->_categories = $this->_db->loadObjectList();
		
		
		$children = array();
		
		if($this->_categories )
		{
		    foreach($this->_categories as $category) 
		    {
		        $parent = $category->parent;
		        
		        if(@$children[$parent])
		        {
		        	$list = $children[$parent];
		        }
		        else
		        {
		        	$list = array();
		        }
		        
		        array_push($list,$category);
		        
		        $children[$parent] = $list;
		    }
		}
		
		$menuTree = JHTML::_('menu.treerecurse', 0, '', array(), $children, 9999, 0, 0 );
		
		$selectOptions     = array();
		$selectOptions[]   = JHTML::_('select.option', '0', JText::_('Top') );
		
		foreach ( $menuTree as $branch ) 
		{
		    $selectOptions[] = JHTMLSelect::option( $branch->id, '&nbsp;&nbsp;&nbsp;'. $branch->treename );
		}
		
		$output = JHTML::_("select.genericlist", $selectOptions, 'parent', 'class="inputbox" size="10"', 'value', 'text', $row->parent );
		return $output;
		
	}
	
}