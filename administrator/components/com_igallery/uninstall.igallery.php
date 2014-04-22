<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
function com_uninstall()
{
	jimport('joomla.filesystem.file');
	jimport('joomla.filesystem.folder');
	
	//get all the galleries
	$db =& JFactory::getDBO();
	$query = "SELECT folder FROM #__igallery where type = 1";
	$db->setQuery($query);
	$rows = $db->loadObjectlist();
	
	//delete all the folders for the galleries
	for($i = 0; $i<count($rows); $i++)
	{
		$row = &$rows[$i];
	
		$folders_to_remove = array();
		$folders_to_remove[0] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'temp'.DS;
		$folders_to_remove[1] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'original'.DS;
		$folders_to_remove[2] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'large'.DS;
		$folders_to_remove[3] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'lightbox'.DS;
		$folders_to_remove[4] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'lightbox_thumbs'.DS;
		$folders_to_remove[5] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS.'thumbs'.DS;
		$folders_to_remove[6] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.$row->folder.DS;
		
		for($k = 0; $k < count($folders_to_remove); $k++)
		{
			if (JFolder::exists($folders_to_remove[$k]))
			{
				$d = dir($folders_to_remove[$k]); 
				while($entry = $d->read()) 
				{ 
					if ($entry!= "." && $entry!= "..") 
					{ 
				 		JFile::delete($folders_to_remove[$k].$entry); 
				 	} 
				} 
				$d->close();
				
				if (!JFolder::delete($folders_to_remove[$k])) 
				{
					JError::raise(2, 500, $folders_to_remove[$k].' '. JText::_( 'FOLDER DELETE ERROR' ) );
				}	
			}
		}
	}
	
	//delete the parent folders
	$folders_to_remove = array();
	$folders_to_remove[0] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics'.DS.'temp'.DS;
	$folders_to_remove[1] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS.'category_pics'.DS;
	$folders_to_remove[2] = JPATH_SITE.DS.'images'.DS.'stories'.DS.'igallery'.DS;
	
	for($k = 0; $k < count($folders_to_remove); $k++)
	{
		if (JFolder::exists($folders_to_remove[$k]))
		{
			$d = dir($folders_to_remove[$k]); 
			while($entry = $d->read()) 
			{ 
				if ($entry!= "." && $entry!= "..") 
				{ 
			 		JFile::delete($folders_to_remove[$k].$entry); 
			 	} 
			} 
			$d->close();
			
			if (!JFolder::delete($folders_to_remove[$k])) 
			{
				JError::raise(2, 500, $folders_to_remove[$k]. JText::_( 'FOLDER DELETE ERROR' ) );
			}	
		}
	}
}
?>