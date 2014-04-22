<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class igalleryViewgallery extends JView
{
	function __construct( $config = array())
	{
 		parent::__construct( $config );
	}
 
	function display($tpl = null)
	{	
		global $mainframe, $option;
		
		//get the users access level
	 	$aid =& $this->get('Aid');
	 	
	 	//get the gallery id
	 	$id =& $this->get('id');

	 	//get the data for this gallery from our gallery model in the backend
	 	$gallery =& $this->get('Gallery');
	 	
	 	//check published and restrict if necessary
	 	if($gallery->published != 1)
		{
			echo JText::_( 'NOT PUBLISHED' );
			return;
		}
		
		//if there is access control on this gallery check the user and redirect if nescessary
		$configArray =& JComponentHelper::getParams( 'com_igallery' );
		$registerLink = $configArray->get('register_link', 'index.php?option=com_user&amp;task=register');
		
		if($gallery->access > $aid)
	 	{
	 		//if the gallery is restricted to registed users
		 	if($gallery->access == 1)
		 	{
		 		header("location: ".$registerLink);
		 		return;
		 	}
		 	
		 	//if the gallery is restricted to special users
		 	if($gallery->access == 2)
		 	{
		 		echo JText::_('RESTRICTED ACCESS');
		 		return;
		 	}
		 	
	 	}
	 	
	 	//get all the photos for this gallery
	 	$photoList =& $this->get('PhotoList');
		if($photoList == NULL)
		{
			echo JText::_('NO PHOTOS PUBLISHED');
			return;
		}
		
		
		//if show parent category at the top is true, and the component is calling the
		//display get all of the galleries in this category
		if($gallery->show_cat_menu == 1 && $option == 'com_igallery')
		{
			$galleries =& $this->get('Galleries');
		}
		else
		{
			$galleries = null;
		}
		
		//if comments are enabled get the comments for each photo
		if($gallery->allow_comments == 1 || $gallery->lbox_allow_comments == 1)
		{
			$commentsList =& $this->get('CommentsList');
		}
		else
		{
			$commentsList = null;
		}
		
		
		//if ratings are enabled get the ratings for each photo
		if($gallery->allow_rating == 1 || $gallery->lbox_allow_rating == 1)
		{
			
			$ratingsList =& $this->get('RatingsList');
		}
		else
		{
			$ratingsList = null;
		}
		
		//BREADCRUMBS BIT
		
		if($option == 'com_igallery')
		{
		 	$pathway =& $mainframe->getPathway();
			
		 	//we want to lose the menu link joomla has made, so we can breadcrumb back to the
			//parent categories
			$pathway->_pathway = array();
		 		
		 	$breadCrumbs = array();
		 	$breadCrumbsLinks = array();
			
		 	//the breadcrumb for the gallery will be last, so it wont have a link	
		 	$breadCrumbs[] = $gallery->name;
			$breadCrumbsLinks[] = '';
			
			//if the gallery is not in the top category	
		 	if($gallery->parent != 0)
		 	{
		 		$db =& JFactory::getDBO();
		 		$query = 'SELECT * FROM #__igallery WHERE id = '.intval($gallery->parent);
				$db->setQuery($query);
				$category = $db->loadObject();
				
				//add the new breadcrumb to the beginning of the array
				array_unshift($breadCrumbs, $category->name);
				array_unshift($breadCrumbsLinks, JRoute::_('index.php?option=com_igallery&view=category&id='.$category->id) );
				
				
				while($category->parent != 0)
				{
					$query = 'SELECT * FROM #__igallery WHERE id = '.intval($category->parent);
					$db->setQuery($query);
					$category = $db->loadObject();
					
					//add the new breadcrumb to the beginning of the array
					array_unshift($breadCrumbs, $category->name);
					array_unshift($breadCrumbsLinks, JRoute::_('index.php?option=com_igallery&view=category&id='.$category->id) );
					
				}
		 	}
				
			//make a breadcrumb for every item in the arrays	
			for($i=0; $i<count($breadCrumbs);$i++)
			{
				$pathway->addItem($breadCrumbs[$i],$breadCrumbsLinks[$i]);
			}
		}
		
		
		//work out the largest width and largest height of the main and lightbox images
		$numPics = count($photoList);
		$largestHeight = 0;
		$largestWidth = 0;
		$largestLboxHeight = 0;
		$largestLboxWidth = 0;
		
		for ($i=0; $i<$numPics; $i++)
		{
			$row =& $photoList[$i];
		    if($row->width > $largestWidth)
		    {
		    	$largestWidth = $row->width;
		    }
		    
		    if($row->height > $largestHeight)
		    {
		    	$largestHeight = $row->height;
		    }
		    
		    if($row->lightbox_width > $largestLboxWidth)
		    {
		    	$largestLboxWidth = $row->lightbox_width;
		    }
		    
		    if($row->lightbox_height > $largestLboxHeight)
		    {
		    	$largestLboxHeight = $row->lightbox_height;
		    }
		    
		}
		
		
		//if the width/height has been manually set in the backend then override
		if($gallery->img_container_width != 0)
		{
			$largestWidth = $gallery->img_container_width;
		}
		
		if($gallery->img_container_height != 0)
		{
			$largestHeight = $gallery->img_container_height;
		}
		
		if($gallery->lbox_img_container_width != 0)
		{
			$largestLboxWidth = $gallery->lbox_img_container_width;
		}
		
		if($gallery->lbox_img_container_height != 0)
		{
			$largestLboxHeight = $gallery->lbox_img_container_height;
		}
		
		//work out the overall width of the gallery, add 10 pixels for the large image padding
		$galleryWidth = $largestWidth + 10;
		$galleryLboxWidth = $largestLboxWidth + 10;
		
		//if the grey borders/shadows are added the gallery wrapper needs to be a bit wider
		if($gallery->style == 'grey-border-shadow')
		{
			$galleryWidth = $galleryWidth + 22;
			$galleryLboxWidth = $galleryLboxWidth + 28;
		}
		
		if($gallery->photo_des_position == 'left' || $gallery->photo_des_position == 'right')
		{
			$galleryWidth = $galleryWidth + $gallery->photo_des_width;
		}
		
		if($gallery->thumb_position == 'left' || $gallery->thumb_position == 'right')
		{
			$galleryWidth = $galleryWidth + $gallery->thumb_container_width;
		}
		
		if($gallery->lbox_photo_des_position == 'left' || $gallery->lbox_photo_des_position == 'right')
		{
			$galleryLboxWidth = $galleryLboxWidth + $gallery->lbox_photo_des_width;
		}
		
		if($gallery->lbox_thumb_position == 'left' || $gallery->lbox_thumb_position == 'right')
		{
			$galleryLboxWidth = $galleryLboxWidth + $gallery->lbox_thumb_container_width;
		}
		
		//get the guest and host vars for the head javascript
		jimport('joomla.environment.uri' );
		$host = JURI::root();
		
		$user   =& JFactory::getUser();
		if( $user->get('guest') )
		{
			$guest = 1;
		}
		else
		{
			$guest = 0;
		}
		
		
		//make the string to go into the head javascript
		$headJs = '
		//make arrays and classes for the gallery: '.$gallery->name.' (id= '.$gallery->id.')
		window.addEvent(\'domready\', function()
		{
		';
		
		//id array part
		$headJs .= 		'var idArray'.$id.' = [';
		for($n=0;$n<count($photoList);$n++)
		{
			$headJs .= $photoList[$n]->id.',';
		}
		$headJs = substr($headJs,0,-1);
		$headJs .= '];
		';
		
		//rated head js part
		$headJs .= 		'
		var ratedArray'.$id.' = [';
		for($i=0;$i<count($photoList);$i++)
		{
			$match = false;
			for($m=0;$m<count($ratingsList);$m++)
			{
				if($photoList[$i]->id == $ratingsList[$m]->img_id)
				{	
					if($ratingsList[$m]->author == $user->username)
					{
						$headJs .= '1,';
						$match = true;
						break;
					}
				}
			}
			if($match == false)
			{
						$headJs .= '0,';
			}
		}
		$headJs = substr($headJs,0,-1);
		$headJs .= '];
		';
		
		
		$headJs .= '
		var ratingsArray'.$id.' = new Array();
		';
		for($i=0;$i<count($photoList);$i++)
		{
			$k = 0;
			for($m=0;$m<count($ratingsList);$m++)
			{
				if($photoList[$i]->id == $ratingsList[$m]->img_id)
				{	if($k == 0)
					{
						$headJs .= '
		ratingsArray'.$id.'['.$i.'] = new Array();
		'; 
					}
						$headJs .= 'ratingsArray'.$id.'['.$i.']['.$k.']='.$ratingsList[$m]->rating.';
		';
					$k++;
				}
			}
		}
		
		//images json part
		$headJs .= '
		
		var jsonImagesObject'.$id.' = 
		{
			"thumbs": 
			[
			';
			
		for($i=0; $i < count($photoList); $i++)
		{
			$headJs .= '	{"filename": "'.$photoList[$i]->filename.'", "width": '.$photoList[$i]->thumb_width.', "height": '.$photoList[$i]->thumb_height.'},
			';
		}
		$headJs = substr($headJs,0,-5);
		$headJs .= '
			],';
		
		$headJs .= '
			
			"main": 
			[
			';
			
		for($i=0; $i < count($photoList); $i++)
		{
			$headJs .= '	{"filename": "'.$photoList[$i]->filename.'", "width": '.$photoList[$i]->width.', "height": '.$photoList[$i]->height.'},
			';
		}
		$headJs = substr($headJs,0,-5);
		$headJs .= '	
		],';
		
		$headJs .= '
			
			"lbox": 
			[
			';
			
		for($i=0; $i < count($photoList); $i++)
		{
			$headJs .= '	{"filename": "'.$photoList[$i]->filename.'", "width": '.$photoList[$i]->lightbox_width.', "height": '.$photoList[$i]->lightbox_height.'},
			';
		}
		$headJs = substr($headJs,0,-5);
		$headJs .= '
			]
		};';
		
		$headJs .= '
		
		var igalleryMain'.$id.' = new igalleryClass({
			allowComments: '.$gallery->allow_comments.',
			allowRating: '.$gallery->allow_rating.',
			closeImage: \'closeImage'.$id.'\',
			commentsAmount: \'main_comments_amount'.$id.'\',
			commentsContainer: \'main_comments_container'.$id.'\',
			commentsForm: \'main_img_comment_form'.$id.'\',
			commentsImgId: \'main_comment_img_id'.$id.'\',
			commentsLoadingGif: \'main_ajax_comment_gif'.$id.'\',
			commentsMessageContainer: \'main_comments_message_container'.$id.'\',
			commentsTextarea: \'main_comment_textarea'.$id.'\',
			desContainer: \'main_des_container'.$id.'\',
			downArrow: \'main_down_arrow'.$id.'\',
			enableSlideshow: '.$gallery->enable_slideshow.',
			host: \''.$host.'\',
			fade: '.$gallery->fade.',
			folder:\''.$gallery->folder.'\',
			guest: '.$guest.',
			idArray: idArray'.$id.',
			imageTypeFolder: \'large\',
			jsonImages: jsonImagesObject'.$id.',
			jsonImagesImageType: jsonImagesObject'.$id.'.main,
			largeImage: \'main_large_image'.$id.'\',
			lboxDark: \'lbox_dark'.$id.'\',
			lboxWhite: \'lbox_white'.$id.'\',
			leftArrow: \'main_left_arrow'.$id.'\',
			lightboxOn: '.$gallery->lightbox.',
			lightboxWidth: '.$galleryLboxWidth.',
			magnify: '.$gallery->magnify.',
			main: 1,
			numPics: '.$numPics.',
			numRatings: \'main_num_ratings'.$id.'\',
			preload: '.$gallery->preload.',
			ratedArray: ratedArray'.$id.',
			ratingsArray: ratingsArray'.$id.',
			ratingsContainer: \'main_ratings_container'.$id.'\',
			ratingsForm: \'main_rating_form'.$id.'\',
			ratingsImgId: \'main_ratings_img_id'.$id.'\',
			ratingsImgRating: \'main_img_rating'.$id.'\',
			ratingsMessageContainer: \'main_ratings_message_container'.$id.'\',
			rightArrow: \'main_right_arrow'.$id.'\',
			scrollBoundary: '.$gallery->scroll_boundary.',
			scrollSpeed: '.$gallery->scroll_speed.',
			showDescriptions: '.$gallery->show_descriptions.',
			showUpDown: '.$gallery->arrows_up_down.',
			showLeftRight: '.$gallery->arrows_left_right.',
			showLargeImage: '.$gallery->show_large_image.',
			showThumbs: '.$gallery->show_thumbs.',
			showSlideshowControls: '.$gallery->show_slideshow_controls.',
			slideshowAutostart: '.$gallery->slideshow_autostart.',
			slideshowForward: \'slideshow_forward'.$id.'\',
			slideshowPause: '.$gallery->slideshow_pause.',
			slideshowPlay: \'slideshow_play'.$id.'\',
			slideshowRewind: \'slideshow_rewind'.$id.'\',
			thumbContainer: \'main_thumb_container'.$id.'\',
			thumbTable: \'main_thumb_table'.$id.'\',
			thumbScrollbar: '.$gallery->thumb_scrollbar.',
			upArrow: \'main_up_arrow'.$id.'\'
			
		});
		';
	if($gallery->lightbox == 1)
	{
			$headJs .= '
		var igalleryLbox'.$id.' = new igalleryClass({
			allowComments: '.$gallery->lbox_allow_comments.',
			allowRating: '.$gallery->lbox_allow_rating.',
			closeImage: \'closeImage'.$id.'\',
			commentsAmount: \'lbox_comments_amount'.$id.'\',
			commentsContainer: \'lbox_comments_container'.$id.'\',
			commentsForm: \'lbox_img_comment_form'.$id.'\',
			commentsImgId: \'lbox_comment_img_id'.$id.'\',
			commentsLoadingGif: \'lbox_ajax_comment_gif'.$id.'\',
			commentsMessageContainer: \'lbox_comments_message_container'.$id.'\',
			commentsTextarea: \'lbox_comment_textarea'.$id.'\',
			desContainer: \'lbox_des_container'.$id.'\',
			downArrow: \'lbox_down_arrow'.$id.'\',
			enableSlideshow: '.$gallery->lbox_enable_slideshow.',
			host: \''.$host.'\',
			fade: '.$gallery->lbox_fade.',
			folder:\''.$gallery->folder.'\',
			guest: '.$guest.',
			imageTypeFolder: \'lightbox\',
			idArray: idArray'.$id.',
			jsonImages: jsonImagesObject'.$id.',
			jsonImagesImageType: jsonImagesObject'.$id.'.lbox,
			largeImage: \'lbox_large_image'.$id.'\',
			lboxDark: \'lbox_dark'.$id.'\',
			lboxWhite: \'lbox_white'.$id.'\',
			leftArrow: \'lbox_left_arrow'.$id.'\',
			lightboxOn: '.$gallery->lightbox.',
			lightboxWidth: '.$galleryLboxWidth.',
			magnify: '.$gallery->magnify.',
			main: 0,
			numPics: '.$numPics.',
			numRatings: \'lbox_num_ratings'.$id.'\',
			preload: '.$gallery->lbox_preload.',
			ratedArray: ratedArray'.$id.',
			ratingsArray: ratingsArray'.$id.',
			ratingsContainer: \'lbox_ratings_container'.$id.'\',
			ratingsForm: \'lbox_rating_form'.$id.'\',
			ratingsImgId: \'lbox_ratings_img_id'.$id.'\',
			ratingsImgRating: \'lbox_img_rating'.$id.'\',
			ratingsMessageContainer: \'lbox_ratings_message_container'.$id.'\',
			rightArrow: \'lbox_right_arrow'.$id.'\',
			scrollBoundary: '.$gallery->lbox_scroll_boundary.',
			scrollSpeed: '.$gallery->lbox_scroll_speed.',
			showDescriptions: '.$gallery->lbox_show_descriptions.',
			showUpDown: '.$gallery->lbox_arrows_up_down.',
			showLeftRight: '.$gallery->lbox_arrows_left_right.',
			showLargeImage: '.$gallery->show_large_image.',
			showThumbs: '.$gallery->lbox_show_thumbs.',
			showSlideshowControls: '.$gallery->lbox_show_slideshow_controls.',
			slideshowAutostart: '.$gallery->lbox_slideshow_autostart.',
			slideshowForward: \'lbox_slideshow_forward'.$id.'\',
			slideshowPause: '.$gallery->lbox_slideshow_pause.',
			slideshowPlay: \'lbox_slideshow_play'.$id.'\',
			slideshowRewind: \'lbox_slideshow_rewind'.$id.'\',
			thumbContainer: \'lbox_thumb_container'.$id.'\',
			thumbTable: \'lbox_thumb_table'.$id.'\',
			thumbScrollbar: '.$gallery->lbox_thumb_scrollbar.',
			upArrow: \'lbox_up_arrow'.$id.'\'
		});
		
		igalleryMain'.$id.'.lboxGalleryObject = igalleryLbox'.$id.';
		igalleryLbox'.$id.'.mainGalleryObject = igalleryMain'.$id.';
		';
	}
	$headJs .= '
		});
		';
		
		//add mootools to the head of the document
		JHTML::_('behavior.mootools');
		
		$document =& JFactory::getDocument();
		//add the external css and javascript to the head
		$document->addStyleSheet($host.'components/com_igallery/css/gallery.css');
		
		//load the stylesheet for the chose gallery style
		$document->addStyleSheet($host.'components/com_igallery/css/'.$gallery->style.'.css');
		
		$document->addScript($host.'components/com_igallery/javascript/gallery.js');
		
		
		//add the head javascript to the document
		$document->addScriptDeclaration($headJs);
		
		
		if($option == 'com_igallery')
		{
			$document->setTitle($gallery->name);
		}
		
		$itemId = JRequest::getVar('Itemid', '');
		
		//assign vars and display
		$this->assignRef('id',$id);
		$this->assignRef('gallery',$gallery);
		$this->assignRef('galleries',$galleries);
		$this->assignRef('photoList',$photoList);
		$this->assignRef('commentsList',$commentsList);
		$this->assignRef('ratingsList',$ratingsList);
		$this->assignRef('user',$user);
		$this->assignRef('host',$host);
		$this->assignRef('guest',$guest);
		$this->assignRef('galleryWidth',$galleryWidth);
		$this->assignRef('largestWidth',$largestWidth);
		$this->assignRef('largestHeight',$largestHeight);
		$this->assignRef('galleryLboxWidth',$galleryLboxWidth);
		$this->assignRef('largestLboxWidth',$largestLboxWidth);
		$this->assignRef('largestLboxHeight',$largestLboxHeight);
		$this->assignRef('numPics',$numPics);
		$this->assignRef('calledFrom',$calledFrom);
		$this->assignRef('registerLink',$registerLink);
		$this->assignRef('itemId',$itemId);
		
		parent::display($tpl);
		
	}
}
?>
