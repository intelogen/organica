<?php

/**
 * Image Processing Library (JImageLib)
 * 
 * 
 * @version     $Id: jimagelib.php 921 2009-07-05 16:14:37Z daniel.ghilea $
 * @package		Joomla
 * @subpackage	JImageLib
 * $licence     GNU/GPL
 */

/*
Changes to this file for use in ignite gallery 2.1:

line 21:
change:
jimport( 'JImageLib.Config' );
to:
include_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'jimagelib'.DS.'config.php');

line 1361 and 1370:
changed:
count
to:
isset
as an undefined error came up

line 1289, added in ftp layer support for GD image creation, changed:

if ($saveFunction == 'imagejpeg') 
$message = $saveFunction($this->temp, $fullPath , $quality);
else $message = $saveFunction($this->temp, $fullPath);
				
if ($message == false){
$this->setError($this->__("ERROR_SAVE"));
return false;	
}

to:

ob_start();
				
if ($saveFunction == 'imagejpeg') 
		 $message = $saveFunction($this->temp, null, $quality);
else $message = $saveFunction($this->temp);

if ($message == false){
	$this->setError($this->__("ERROR_IMAGE_OUTPUT"));
	return false;	
}

$output = ob_get_contents(); 
ob_end_clean();
if(! JFile::write($fullPath, $output) )
{
	$this->setError($this->__("ERROR_SAVE"));
}

and in the language file added in:
$JIMAGELIB_LANG["ERROR_IMAGE_OUTPUT"] =  "Error Outputting Image Stream.";

line 2636 added in:
$languagePath = JPATH_COMPONENT_ADMINISTRATOR.DS.'jimagelib'.DS.'language'.DS;

line 394, commented out the function call in constructor, as the thumb folder is not used
in this extension, and trying to create it leads to errors on some servers.

line 2417, commented out the error/return inside the is_writable as when the ftp user is
on the ftp layer doesn't have a function for is_writable, so is_writable returns false

PHP4 support

added constants in lines 75-98
lines 108-376, changed protected to var
changed all JImageLib:: to JI_
changed 'private functions' to plain functions
changed jimage so it doesn't extend jimageconfig
*/

jimport( 'joomla.html' );
jimport( 'joomla.factory' );

define('JI_DEFAULT_CACHE', 0);
define('JI_DEFAULT_DIRECTORY', "thumb/");
define('JI_DEFAULT_DROPSHADOW_DIRECTORY', 'libraries/JImageLib/extlibs/effects/dropshadow/images/');
define('JI_DEFAULT_GRAPHICS_MAGICK_DIRECTORY', 'c:\gm');
define('JI_DEFAULT_IMAGE_MAGICK_DIRECTORY', 'c:\im');
define('JI_DEFAULT_IMG_PROCESSOR', "gd");
define('JI_DEFAULT_JPG_QUALITY', 70);
define('JI_DEFAULT_JIMAGELIB_DIRECTORY', 'libraries/JImageLib/');
define('JI_DEFAULT_LANGUAGE_DIRECTORY', 'libraries/JImageLib/language/');
define('JI_DEFAULT_LEFT_CROP', 0);
define('JI_DEFAULT_PREFIX', "tn_");
define('JI_DEFAULT_POPUP_TYPE', "none");
define('JI_DEFAULT_RESIZE_OPTION', "bestfit");
define('JI_DEFAULT_RESIZE_COLOR', "#FFFFFF");
define('JI_DEFAULT_TOP_CROP', 0);
define('JI_DEFAULT_USE_IMG_SIZE', "none");
define('JI_DEFAULT_WM_POSITION', "random");
define('JI_DEFAULT_WM_MARGIN_TOP', 0);
define('JI_DEFAULT_WM_MARGIN_LEFT', 0);
define('JI_DEFAULT_WM_TRANSPARENCY', 90);
define('JI_GREYBOX_CSS_PATH', 'libraries/JImageLib/extlibs/popups/greybox/');
define('JI_GREYBOX_JS_PATH', 'libraries/JImageLib/extlibs/popups/greybox/');
define('JI_SLIMBOX_CSS_PATH', 'libraries/JImageLib/extlibs/popups/slimbox/css/');
define('JI_SLIMBOX_JS_PATH', 'libraries/JImageLib/extlibs/popups/slimbox/js/');

class JImageLib{

	
	/*
	 * Image path
	 * 
	 * @var string 
	 */
	var $path;
	
		
	/*
	 * Image width
	 * 
	 * @var int 
	 */
	var $width = 0;
	
	
	/*
	 * Image height
	 * 
	 * @var int 
	 */
	var $height = 0;
	
	
	/*
	 * Properties of the loaded image
	 * 
	 * @var array 
	 */
	var $img = array();
	
	
	/*
	 * Reference to the temporary image (for GD) or filename (for IM and GM)
	 * 
	 * @var object/string
	 */
	var $temp;
	
	
		
	/*
	 * Filename escaped to be used as a shell argument (for IM and GM)
	 * 
	 * @var string 
	 */
	var $temp_esc = '';
	
	
	
	/*
	 * IM and GM directory
	 * 
	 * @var string 
	 */
	var $dir = '';
	
	
	/*
	 * IM and GM extension ( '.exe' for Windows and '' for Unix)
	 * 
	 * @var string 
	 */
	var $ext = '';
	
	
	

	
	/*
	 * Image library that is going to be used for processing
	 * 
	 * Options available: 
	 * "gd", "im", "gm"
	 * 
	 * @var string 
	 */
	var $imageLib;
	
	
	
	/*
	 * Alt text
	 * 
	 * @var string
	 */
	var $alt = "";
	
	/*
	 * Image title
	 * 
	 * @var string
	 */
	var $title = "";

	/*
	 * <img> css class attribute
	 * 
	 * @var string
	 */
	var $class = "";
	
	/*
	 * <img> id attribute
	 * 
	 * @var string
	 */
	var $id = "";
	
	/*
	 * Pop-up type used when generating a tag. 
	 * 
	 * Options available: 
	 * "none", "expand", "lightbox", "greybox"
	 * 
	 * @var string
	 */
	var $popUp = JI_DEFAULT_POPUP_TYPE;

	/*
	 * <img> other attributes
	 * 
	 * @var string
	 */
	var $attributes = "";
		
	
	/*
	 * Directory where the generated images will be saved
	 * 
	 * @var string
	 */
	var $directory = JI_DEFAULT_DIRECTORY;
	
	
	/*
	 * Prefix for the generated images
	 * 
	 * @var string
	 */
	var $prefix = JI_DEFAULT_PREFIX;
	
	/*
	 * How is included the new image size into the name of generated images
	 * 
	 * @var string
	 */
	var $useImgSize = JI_DEFAULT_USE_IMG_SIZE;
	
	/*
	 * Custom name for the next generated image
	 * 
	 * @var string
	 */
	var $customName;
	
	/*
	 * Cache expiration time
	 * 
	 * @var int
	 */
	var $cache = JI_DEFAULT_CACHE;
	
	/*
	 * Error messages
	 * 
	 * @var array 
	 */
	var $errors = array();
	
	
	/*
	 * Actions that will be done to the image
	 * 
	 * @var array 
	 */
	var $actions = array();
	
	
	/*
	 * Library language array
	 * 
	 * @var array
	 */
	var $language = array();
	

	/*
	 * Img types supported
	 * 
	 * @var	array
	 */

	var $supportedTypes = array(IMAGETYPE_GIF => "gif", IMAGETYPE_JPEG =>"jpg",IMAGETYPE_PNG => "png");



	/*
	 * Img processors
	 * 
	 * @var	array
	 */

	var $imgProcessors = array("gd", "im", "gm");


	/*
	 * Img naming options
	 * 
	 * @var	array
	 */

	var $imgSizeMode = array("both", "dir", "file", "none");



	/*
	 * Pop-up types
	 * 
	 * @var	array
	 */

	var $popups = array( "none", "expand", "slimbox", "greybox");




	/*
	 * Filter types
	 * 
	 * @var	array
	 */

	var $filters = array("grayscale", "sepia", "negative", "blur", "invert",
							"edgedetect", "meanremoval", "emboss", "dropshadow",
							"brightness", "contrast", "smoothness", "colorize");

	/*
	 * Filters that need parameters
	 * 
	 * @var	array
	 */
	var $filtersWithParams = array("brightness", "contrast", "smoothness", "colorize");



	/*
	 * Flip directions
	 * 
	 * @var	array
	 */

	var $flip = array("h", "v");



	/*
	 * Resizing options
	 * 
	 * @var	array
	 */

	var $resizeOptions = array( "bestfit", "crop", "fill", "stretch");




	/*
	 * Watermark positions
	 * 
	 * @var	array
	 */

	var $watermarkPositions = array("center", "top", "topright", "topleft",	"bottom", "bottomright", "bottomleft", "right", "left", "random");

	

	

	
	
	
	
	
	function __construct()
	{

		//$this->setDirectory(JI_DEFAULT_DIRECTORY);
	}
	
	
	
	
	/*
	 * Overridden get method to get image properties
	 * 
	 * @access	private
	 * @param	string	$property	The name of the property to get
	 * @param	mixed  	$default	The default value
	 * @return	mixed				The value of the property
	 * 
	 */
	
	function get($property, $default = null)
	{
		if (isset($this->$property)){
			return $this->$property;
		}
		return $default;
	}
	
	
	
	/*
	 * Overridden set method to set image properties
	 * 
	 * @access	private
	 * @param	string	$property	The name of the property to set
	 * @param	mixed  	$value		The  value for the property
	 * @return	boolean				True on success
	 * 
	 */
	
	function set($property, $value = null)
	{
		if ($this->$property = $value){
			return true;
		}
		else return false;
	}
	
	

	/*
	 * Gets the image path
	 * 
	 * @return  string		The path to the image
	 * 
	 */
	
	function getPath()
	{
		return $this->get('path');
	}

	
	/*
	 * Sets the image path
	 * 
	 * @param  string	$path		The path to the image to load
	 * 
	 */
	
	function setPath($path)
	{
		if (!is_file($path)) {
			$this->setError($this->__("ERROR_FILE_NOT_FOUND"));
			return false;
		}
		
		$img_info = getimagesize($path);
		if ((!is_array($img_info)) OR (count($img_info) < 3)){
			$this->setError($this-> __("ERROR_INVALID_FILE"));
			return false;
		}
		
		if(! isset($this->supportedTypes[$img_info[2]]) ){
			$this->setError($this-> __("ERROR_INVALID_TYPE"));
			return false;
		}
		
		$this->img['path'] = str_replace('\\', '/', realpath($path));
		$this->img['width'] = $img_info[0];
		$this->img['height'] = $img_info[1];
		$this->img['ext'] = $this->supportedTypes[$img_info[2]];
		$this->img['mime'] = $img_info['mime'];
		
		return $this->set('path', $path);
	}
	
	
	
	/*
	 * Loads the image from the specified image path
	 * 
	 * @param  string	$path		The path to the image to load
	 * 
	 */
	
	function load($path)
	{
		return $this->setPath($path);
	}
	
	
	
	/*
	 * Gets image width
	 * 
	 * @return  int		The width of the image
	 * 
	 */
	
	function getWidth()
	{
		return $this->get('width', 0);
	}

	
	
	/*
	 * Sets new image width
	 * 
	 * @param  int	$width		The new width for the image
	 * 
	 */
	
	function setWidth($width)
	{
		if (!is_int($width) || $width < 0){
			$this->setError($this->__("ERROR_INVALID_WIDTH"));
			return false;
		}
		return $this->set('width', $width);
	}
	
	
	
	/*
	 * Gets image height
	 * 
	 * @return  int		The height of the image
	 * 
	 */
	
	function getHeight()
	{
		return $this->get('height', 0);
	}
	
	
	
	/*
	 * Sets new image height
	 * 
	 * @param  int	$height		The new height for the image
	 * 
	 */
	
	function setHeight($height)
	{
		if (!is_int($height) || $height < 0){
			$this->setError($this->__("ERROR_INVALID_HEIGHT"));
			return false;
		}
		return $this->set('height', $height);
	}
	
	
	
	/*
	 * Gets image processing system
	 * 
	 * @return  string		The image 3rd party library used for image processing
	 * 
	 */
	
	function getImageLib()
	{
		return $this->get('imageLib', JI_DEFAULT_IMG_PROCESSOR);
	}
	
	
	
	/*
	 * Sets image processing system
	 * 
	 * Options available: 
	 * "gd", "im", "gm"
	 * 
	 * @param  string	$imageLib		The new image 3rd party library used for image processing
	 * 
	 */
	
	function setImageLib($imageLib = JI_DEFAULT_IMG_PROCESSOR)
	{
		if (! in_array(strtolower($imageLib), $this->imgProcessors)){
			$this->setError($this-> __("ERROR_INVALID_IMG_LIB"));
			return false;
		}
		
				
		if (! $this->loadImageLib(strtolower($imageLib))){
			return false;
		}

		return $this->set('imageLib', strtolower($imageLib));
	}
	
	
	/*
	 * Loads the image processing system
	 * 
	 * 
	 * @param  string	$imageLib		The image 3rd party library used for image processing
	 * 
	 */
	
	function loadImageLib($imageLib)
	{
		switch ($imageLib){
			
			case $this->imgProcessors[0]:
				/*
				 * Un-comment the following line to increase the memory limit 
				 * (used for GD processing)
				 * 
				 */
				// ini_set('memory_limit', '64M');
				
				
				if (! function_exists('gd_info')){
					$this->setError($this->__("ERROR_CANNOT_LOAD_GD"));
					return false;
				}
				$gd_info = gd_info();
				$version = $gd_info['GD Version'];
			
				if (strpos($version, '2.') === false){
					$this->setError($this->__("ERROR_CANNOT_LOAD_GD"));		
					return false;
				}
			break;

			case $this->imgProcessors[1]: 
				if (PHP_SHLIB_SUFFIX == 'dll') $this->ext = '.exe';
				
				if (JI_DEFAULT_IMAGE_MAGICK_DIRECTORY == ''  || ! is_file(realpath(JI_DEFAULT_IMAGE_MAGICK_DIRECTORY) .'/'. 'convert' . $this->ext ) ){
					$this->setError($this->__("ERROR_CANNOT_LOAD_IM"));		
					return false;
				}
				$this->dir = str_replace('\\', '/', realpath(JI_DEFAULT_IMAGE_MAGICK_DIRECTORY)) . '/';
			break;
			
			case $this->imgProcessors[2]: 
				if (PHP_SHLIB_SUFFIX == 'dll') $this->ext = '.exe';
				
				if (JI_DEFAULT_GRAPHICS_MAGICK_DIRECTORY == ''  || ! is_file(realpath(JI_DEFAULT_GRAPHICS_MAGICK_DIRECTORY) .'/'. 'gm' . $this->ext ) ){
					$this->setError($this->__("ERROR_CANNOT_LOAD_IM"));		
					return false;
				}
				$this->dir = str_replace('\\', '/', realpath(JI_DEFAULT_GRAPHICS_MAGICK_DIRECTORY)) . '/';
			break;
		}

		return true;
	}
	
	
	/*
	 * Gets alt text
	 * 
	 * @return  string		The alt text of the image
	 * 
	 */
	
	function getAlt()
	{
		return $this->get('alt');
	}
	

	
	/*
	 * Sets the alt text
	 * 
	 * @param  string	$alt	The new alt text for the image
	 * 
	 */
	
	function setAlt($alt)
	{
		return $this->set('alt', htmlspecialchars(strip_tags($alt)) );
	}
	
	
	
	/*
	 * Gets the image title
	 * 
	 * @return  string		The title of the image
	 * 
	 */
	
	function getTitle()
	{
		return $this->get('title');
	}
	

	
	/*
	 * Sets the image title
	 * 
	 * @param  string	$title		The new title for the image
	 * 
	 */
	
	function setTitle($title)
	{
		return $this->set('title', htmlspecialchars(strip_tags($title)) );
	}
	
	
	
	/*
	 * Gets the css class
	 * 
	 * @return  string		The css class of the image
	 * 
	 */
	
	function getClass()
	{
		return $this->get('class');
	}
	
	
	
	/*
	 * Sets the css class
	 * 
	 * @param  string	$class		The new css class for the image
	 * 
	 */
	
	function setClass($class)
	{
		return $this->set('class', htmlspecialchars(strip_tags($class)) );
	}
	
	
	
	/*
	 * Gets the <img> id attribute
	 * 
	 * @return  string		The id attribute of the image
	 * 
	 */
	
	function getId()
	{
		return $this->get('id');
	}
	
	
	
	/*
	 * Sets the <img> id attribute
	 * 
	 * @param  string	$id		The new id attribute for the image
	 * 
	 */
	
	function setId($id)
	{
		return $this->set('id', htmlspecialchars(strip_tags($id)) );
	}
	

	
	/*
	 * Gets the pop-up type
	 * 
	 * @return  string		The pop-up type used when generating a tag.
	 * 
	 */
	
	function getPopUp()
	{
		return $this->get('popUp', JI_DEFAULT_POPUP_TYPE);
	}
	

	
	/*
	 * Sets the pop-up type
	 * 
	 * Options available: 
	 * "none", "expand", "lightbox", "greybox"
	 * 
	 * @param  string	$popUp		The pop-up type used when generating a tag.
	 * 
	 */
	
	function setPopUp($popUp)
	{
		if (! in_array(strtolower($popUp), $this->popups)){
			$this->setError($this-> __("ERROR_INVALID_POPUP"));
			return false;
		}
		return $this->set('popUp', $popUp);
	}
	
	
	
	/*
	 * Gets other attributes string
	 * 
	 * @return  string		The other attributes used when generating a tag.
	 * 
	 */
	
	function getAttributes()
	{
		return $this->get('attributes');
	}
	
	
	
	/*
	 * Sets other attributes string
	 * 
	 * @param  string	$att		The other attributes used when generating a tag.
	 * 
	 */
	
	function setAttributes($att)
	{
		return $this->set('attributes', htmlspecialchars(strip_tags($att)) );
	}


		
	/*
	 * Gets the directory where the generated images will be saved
	 * 
	 * @return  string		Directory
	 * 
	 */
	
	function getDirectory()
	{
		return $this->get('directory', JI_DEFAULT_DIRECTORY);
	}
	
	
	/*
	 * Sets the new directory for saving the generated images
	 * 
	 * @param  string	$newDirectory		The directory in which images will be saved
	 * 
	 */
	
	function setDirectory($newDirectory)
	{
		if ($newDirectory == ''){
			$this->directory = '';
			return true;
		}
		
		$tmp = str_replace('\\', '/', $newDirectory);
		
		if (! file_exists($tmp)){
			if (!JFolder::create($tmp)){
				$this->setError($this-> __("ERROR_INVALID_DIRECTORY"));
				return false;
			}
		}
		
		$tmp = str_replace('\\', '/', realpath($newDirectory));
		if (! is_writable($tmp)){
			$this->setError($this-> __("ERROR_INVALID_DIRECTORY"));
			return false;
		}
		return $this->set('directory', $newDirectory);
	}
	
	
	
	/*
	 * Gets the prefix for the generated images
	 * 
	 * @return  string		Prefix for naming generated images
	 * 
	 */
	
	function getPrefix()
	{
		return $this->get('prefix', JI_DEFAULT_PREFIX);
	}
	

	/*
	 * Sets the new prefix for the generated images
	 * 
	 * @param  string	$newPrefix		The prefix for generated images
	 * 
	 */
	
	function setPrefix($newPrefix)
	{
		/*
		 * @TODO Restrictions for image prefix
		 */
		return $this->set('prefix', $newPrefix );
	}
	
	
	
	/*
	 * Gets how including the new image size into the name is handled
	 * 
	 * @return  string		Handling mode
	 * 
	 */
	
	function getUseImageSize()
	{
		return $this->get('useImgSize', JI_DEFAULT_USE_IMG_SIZE);
	}
	
	
	/*
	 * Sets how to include the new image size into the name or containing directory
	 * 
	 * @param  string	$mode		The handling mode
	 * 
	 */
	
	function setUseImageSize($mode)
	{
		if (! in_array(strtolower($mode), $this->imgSizeMode)){
			$this->setError($this-> __("ERROR_INVALID_IMG_SIZE_MODE"));
			return false;
		}
		
		return $this->set('useImgSize', strtolower($mode));
	}
	
	
	/*
	 * Gets custom name for the next generated image
	 * 
	 * @return  string		The custom name for the next generated image
	 * 
	 */
	
	function getName()
	{
		return $this->get('customName');
	}
	
	
	/*
	 * Sets new custom name for each generated image
	 * 
	 * @param  string	$customName		New custom name
	 * 
	 */
	
	function setName($customName)
	{
		/*
		 * @TODO Restrictions for the custom name
		 */
		return $this->set('customName', $customName );
	}
	
	
	/*
	 * Gets cache expiration time
	 * 
	 * @return  int		Cache expiration time
	 * 
	 */
	
	function getCacheTime()
	{
		return $this->get('cache');
	}
	
	
	/*
	 * Sets cache expiration time. If it is set to 0, then caching is disabled
	 * 
	 * @param  int	$time		Cache expiration time
	 * 
	 */
	
	function setCacheTime($time = 0)
	{
		return $this->set('cache', $time );
	}
	

		
	/*
	 * Sets the filter type
	 * 
	 * Options available: 
	 *  grayscale, sepia, negative, blur, invert, edgeDetect, meanRemoval, emboss, dropShadow 
	 *
	 * Options requiring parameter :
	 *  brightness, contrast, smoothness, colorize
	 * 
	 * @param  string	$filterType		Type of the filter that will be applied
	 * @param  int		$value			Value for the filters that require parameter
	 *									For colorize, it represents the hex
	 *									code of the color
	 * 
	 */
	
	function setFilter($filterType, $value = null )
	{
		if (! in_array(strtolower($filterType), $this->filters)){
			$this->setError($this-> __("ERROR_INVALID_FILTER"));
			return false;
		}
		
		if (in_array(strtolower($filterType), $this->filtersWithParams)){
			if ($value == null) {
				$this->setError($this-> __("ERROR_NO_FILTER_PARAM"));
				return false;
			}
			if ((!is_int($value) || $value < -100 || $value > 100 ) && (strtolower($filterType) != "colorize")){
				$this->setError($this-> __("ERROR_INVALID_FILTER_PARAM"));
				return false;
			}	
				
			if (strtolower($filterType) == 'colorize'){
				if ( ! list($r, $g, $b) = $this->getColor($value)){
					$this->setError($this-> __("ERROR_INVALID_COLOR"));
					return false;			
				}
				$this->actions[strtolower($filterType)] = array('r' => $r, 'g' => $g, 'b' => $b);
			}
			else $this->actions[strtolower($filterType)] = $value;
		}
		else $this->actions[strtolower($filterType)] = true;
		return true;
	}
	
	
	
	/*
	 * Sets the option to flip an image along the horizontal or vertical axis
	 * 
	 * Options available:
	 * 'H' or 'V'  
	 *   
	 * @param  string	$direction		The direction for flipping
	 * 
	 */
	
	function setFlipping($direction)
	{
		if (! in_array(strtolower($direction), $this->flip)){
			$this->setError($this-> __("ERROR_INVALID_FLIP"));
			return false;
		}
		
		$this->actions['flip'] = strtolower($direction);
		return true;
	}
	
	
	/*
	 * Sets the angle for rotating the image.
	 * 
	 * The angle should be positive value for a clockwise rotation and negative value for a counter-clockwise rotation
	 * 
	 * 
	 * @param  string	$angle		Angle degrees for the rotation
	 * 
	 */
	
	function setRotation($angle)
	{

		if (!is_int($angle)){
				$this->setError($this-> __("ERROR_INVALID_ROTATION_ANGLE"));
				return false;
		}	
		
		if ($angle > 180){
			while ($angle > 180) $angle -= 360;
		}
		if ($angle < -180){
			while ($angle < -180) $angle += 360;
		}
		
		
		$this->actions['rotate'] = $angle;
		return true;
	}
	

	
	/*
	 * Sets the options for cropping image to the specified dimensions
	 * 
	 * 
	 * @param  int	$top		Top margin for cropping
	 * @param  int	$left		Left margin for cropping
	 * 
	 */
	
	function setCropping($top = JI_DEFAULT_TOP_CROP, $left = JI_DEFAULT_LEFT_CROP)
	{

		if (!is_int($top)){
				$this->setError($this-> __("ERROR_INVALID_CROP_TOP"));
				return false;
		}	
		if (!is_int($left)){
				$this->setError($this-> __("ERROR_INVALID_CROP_LEFT"));
				return false;
		}	

		$width = $this->getWidth();
		$height = $this->getHeight();
		
		if ($width == 0 || $height == 0){
			$this->setError($this-> __("ERROR_INVALID_CROP_SIZE"));
			return false;
		}
		
		$this->actions['crop'] = array('width' => $width, 'height'=> $height, 'top' => $top, 'left' => $left );
		return true;
	}
	

	
	
	/*
	 * Sets options for resizing an image to the new dimensions
	 * 
	 * 
	 * @param  string	$option		How to handle aspect ratio
	 * @param  string	$color		Code of the color used to fill the background, if option is fill
	 * 
	 */
	
	function setResizing($option = JI_DEFAULT_RESIZE_OPTION, $color = JI_DEFAULT_RESIZE_COLOR)
	{
		if (! in_array(strtolower($option), $this->resizeOptions)){
			$this->setError($this-> __("ERROR_INVALID_RESIZE_OPTION"));
			return false;
		}

		if (! $this->getColor($color)){
			$this->setError($this-> __("ERROR_INVALID_COLOR"));
			return false;			
		}
		
		$width = $this->getWidth();
		$height = $this->getHeight();
		
		if ($width == 0 && $height == 0){
			$this->setError($this-> __("ERROR_INVALID_SIZE"));
			return false;
		}
		
		if (($width == 0 || $height == 0) && (strtolower($option) == "crop" || strtolower($option) == "fill") ){
			$this->setError($this-> __("ERROR_INVALID_CROP_SIZE"));
			return false;
		}
		
		$this->actions['resize'] = array('width' => $width, 'height'=> $height, 'option' => strtolower($option), 'color' => $color );
		return true;
	}
	

	
	
	/*
	 * Returns the last generated error message
	 * 
	 * @return  string		Error message
	 * 
	 */
	
	function getError()
	{
		if (sizeof($this->errors) < 1) return false;
		return $this->errors[sizeof($this->errors) - 1];
	}
	
	
	
	
	/*
	 * Adds another error message.
	 *   
	 * @param  string	$error		The error message
	 * 
	 */
	
	function setError($error)
	{
		return $this->errors[] = $error;
	}
	
	
	
	
	/*
	 * Converts a hex color code into RGB values
	 *   
	 * @param  string	$code		The color code
	 * 
	 * @return	array				Array with RGB values
	 */
	
	function getColor($code)
	{
		if ($code[0] == '#') $code = substr($code, 1);
		if (strlen($code) != 6 && strlen($code) != 3) return false;
		else if (strlen($code) == 3){
			$r = hexdec($code[0].$code[0]);
			$g = hexdec($code[1].$code[1]);
			$b = hexdec($code[2].$code[2]);
		}
		else if (strlen($code) == 6){
			$r = hexdec($code[0].$code[1]);
			$g = hexdec($code[2].$code[3]);
			$b = hexdec($code[4].$code[5]);
		}
		
		return array($r, $g, $b);
	}
	
	
	
	
	/*
	 * 
	 * Removes an action from the action list
	 *   
	 * @param  string	$action		The action to be removed from the action list
	 * 								'all' for removing all the actions
	 * 
	 */
	
	function remove($action)
	{
		$action = strtolower($action);
		switch ($action){
			case 'all':
				$this->actions = array();
			break; 
			default:
				unset($this->actions[$action]);
			break;
		}
	}
	
	
	
	
	/*
	 * 
	 * 
	 */
	
	function getImageFromFile($path, $fileName)
	{
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				$function = '';
				switch($this->img['ext']){
					case 'jpg':
					case 'jpeg':
						$function = 'imagecreatefromjpeg';
					break;
					case 'png':
						$function = 'imagecreatefrompng';
					break;
					case 'gif':
						$function = 'imagecreatefromgif';
					break;
				}
				if ($function == '' || ! function_exists($function)){
					$this->setError($this->__("ERROR_INVALID_TYPE_GD"));
					return false;
				}
				
				if (! $this->temp = $function($this->img['path'])){
					$this->setError($this->__("ERROR_SAVE"));
					return false;
				}
				
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]: 
				$this->temp = $path . 'jimglib--' . sha1(time().$path.$fileName).'.'.strtolower(substr($fileName,strrpos($fileName, '.') + 1));
				$this->temp_esc = escapeshellarg($this->temp);
				copy($this->img['path'], $this->temp);
			
			break;
		}
		
		return true;
	}
	
	
	
	
	/*
	 * 
	 * 
	 */
	
	function saveImageToFile($path, $fileName, $quality, $display = false)
	{
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				$saveFunction = '';
				switch(strtolower(substr($fileName,strrpos($fileName, '.') + 1))){
					case 'jpg':
					case 'jpeg':
						$saveFunction = 'imagejpeg';
					break;
					case 'png':
						$saveFunction = 'imagepng';
					break;
					case 'gif':
						$saveFunction = 'imagegif';
					break;
				}
		
				if ($saveFunction == '' || ! function_exists($saveFunction)){
					$this->setError($this->__("ERROR_INVALID_TYPE_GD"));
					return false;
				}
		
				$fullPath = $path . $fileName;
				if ($display == true){
					$fullPath = null;						
				}
				
				ob_start();
				
				if ($saveFunction == 'imagejpeg') 
						 $message = $saveFunction($this->temp, null, $quality);
				else $message = $saveFunction($this->temp);
				
				if ($message == false){
					$this->setError($this->__("ERROR_IMAGE_OUTPUT"));
					return false;	
				}
				
				$output = ob_get_contents(); 
				ob_end_clean();
				if(! JFile::write($fullPath, $output) )
				{
					$this->setError($this->__("ERROR_SAVE"));
				}
						
				
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]: 
				if ($display == true)
					$fullPath = $this->temp_esc;						
				else $fullPath = escapeshellarg($path . $fileName);
				
				$command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
				
				$command = $this->dir . $command . ' -quality '. $quality . '% ' . $this->temp_esc . ' '. $fullPath ;
				$message = exec(escapeshellcmd($command));
				
				if ($message != ''){
					$this->setError($this->__("ERROR_SAVE"));
					return false;	
				}
			break;
				
			
		}
		
		return true;	
	}
	
	
	
	
	/*
	 * 
	 * 
	 */
	
	function removeTempImage()
	{
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				imagedestroy($this->temp);	
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]:
				unlink($this->temp);
				$this->temp = '';  
			break;
				
		}
		
	}
	
	
	
	
	/*
	 * Processes the requested actions.
	 *    
	 *    
	 * @param	string	$path			Path to the new image
	 * @param	string	$fileName		File name of the new image			
 	 * @param	int		$quality		Quality for saving JPGs
 	 * @param	boolean	$display		The image will be displayed directly to the browser or not
	 * 
	 */
	
	function process($path, $fileName, $quality, $display = false)
	{
		
		if (! $this->getImageFromFile($path, $fileName)){
			return false;
		}
		
		if (isset($this->actions['watermark']) > 0)
		{
			$watermark = $this->actions['watermark'];
			unset($this->actions['watermark']);
		}
		
		$message = $this->executeActions();
		 
		if ($message == true){
			if (isset($watermark) > 0){
				$message = $this->watermark($watermark);
				if ($message == false){
					return false;
				}
			}
			if ($display == true){
				$extension = substr($fileName, strrpos($fileName, '.') + 1);
				switch (strtolower($extension)){
					case 'jpg':
					case 'jpeg':
						$header = 'Content-Type: image/jpeg';
					break;
					case 'png':
						$header = 'Content-Type: image/png';
					break;
					case 'gif':
						$header = 'Content-Type: image/gif';
					break;		
				}

				header($header);	
				
				if ($this->getImageLib() != $this->imgProcessors[0]){
					echo file_get_contents($this->temp);
				}
			}
			
			$message = $this->saveImageToFile($path, $fileName, $quality, $display);
		}
		
		$this->removeTempImage();

		return $message;
	}




	/*
	 * Executes actions to the temporary image
	 *   
	 */
	
	function executeActions()
	{
		foreach ($this->actions as $action => $args){
			if (in_array($action, $this->filters) && !function_exists('imagefilter')) {
				$this->setError($this->__("ERROR_INVALID_FILTER_GD"));
				return false;
			}
			if (in_array($action, $this->filters) && !in_array($action, $this->filtersWithParams) )
			{
				if (! $this->$action()) return false;
			}
			else {
				if (! $this->$action($args)) return false;
			}
		}
		return true;
	}
	
	
	
	
	function flip($direction)
	{
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				$width = imagesx($this->temp);
				$height = imagesy($this->temp);
				
				$new = imagecreatetruecolor($width, $height);
				
				if ($direction == 'v'){
					for ($i = 0; $i < $width; $i++){
						$message = imagecopy($new, $this->temp, $i, 0, $width - $i - 1, 0, 1, $height);
						if ($message == false) return false;
					}	
				}
				
				if ($direction == 'h'){
					for ($i = 0; $i < $height; $i++){
						$message = imagecopy($new, $this->temp, 0, $i, 0, $height - $i - 1, $width, 1);
						if ($message == false) return false;
					}	
				}
				
				imagedestroy($this->temp);
				$this->temp = $new;
						
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]:
				$command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
				$direction = ($direction == 'h') ? ' -flip': ' -flop';
				
				$command = $this->dir . $command . $direction . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));
				
				if ($message != ''){
					return false;	
				} 
			break;
					
		}
				
		return true;
	}
	
	function rotate($angle)
	{
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				if (! $this->temp = imagerotate($this->temp, 360-$angle, imagecolorallocate($this->temp, 255, 255, 255))){
					return false;
				}	
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]: 
				$command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
								
				$command = $this->dir . $command . ' -rotate ' . escapeshellarg($angle) .  $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));
				
				if ($message != ''){
					return false;	
				} 
				
			break;
				
		}
		
		return true;
	}
	
	
	function resize($args)
	{		
				
	switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				$originalWidth = imagesx($this->temp);
				$originalHeight = imagesy($this->temp);
				
				$width = min($originalWidth, $args['width']);
				$height = min($originalHeight, $args['height']);
				
				$srcX = $srcY = $destX = $destY = 0;
				$newWidth = $width;
				$newHeight = $height;
				
				switch ($args['option']){
					case 'bestfit':
						if ($width == 0)  $newWidth = $width  = round($originalWidth * $height / $originalHeight);
						if ($height == 0) $newHeight = $height = round($originalHeight * $width / $originalWidth);
						if (($originalWidth / $width) > ($originalHeight / $height))
							$height = $newHeight = round($originalHeight * $width / $originalWidth);
						else $width = $newWidth  = round($originalWidth * $height / $originalHeight);	
					break;
					case 'crop':
						if (($originalWidth / $width) > ($originalHeight / $height)){
							$aux = $originalWidth;
							$originalWidth = $width * $originalHeight / $height;
							$srcX = ($aux - $originalWidth) / 2;
						}
						else {
							$aux = $originalHeight;
							$originalHeight = $height * $originalWidth / $width;
							$srcY = ($aux - $originalHeight) / 2;
						}
					break;	
					case 'stretch':
						if ($width == 0)  $newWidth = $width  = $originalWidth;
						if ($height == 0) $newHeight = $height = $originalHeight;
					break;
					case 'fill':
						if (($originalWidth / $width) > ($originalHeight / $height)){
							$newHeight = round($originalHeight * $width / $originalWidth);
							$destY = ($height - $newHeight) / 2;
						}
						else {
							$newWidth  = round($originalWidth * $height / $originalHeight);
							$destX = ($width - $newWidth) / 2;
						}
					break;
				}

				$new = imagecreatetruecolor($width, $height);
				if ($args['option'] == "fill") {
					$rgb = $this->getColor($args['color']);
					$color = imagecolorallocate($new, $rgb[0], $rgb[1], $rgb[2]);
					imagefill($new, 0, 0, $color);
				}
				if (! imagecopyresampled($new, $this->temp, $destX, $destY, $srcX, $srcY, $newWidth, $newHeight, $originalWidth, $originalHeight)){
					return false;
				}
				
				imagedestroy($this->temp);
				$this->temp = $new;
		
		
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]:
				$base_command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
				if ($args['width'] == 0) $dimensions = 'x'.$args['height'];
				else if ($args['height'] == 0) $dimensions = $args['width'];
				else $dimensions = $args['width'].'x'.$args['height'];
				
				switch ($args['option']){
						case 'bestfit':
							$command = $this->dir . $base_command . ' -resize ' . escapeshellarg($dimensions) . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
							$message = exec(escapeshellcmd($command));	
						break;
						case 'crop':
							$srcX = $srcY = 0;
							$originalWidth = $this->img['width'];
							$originalHeight = $this->img['height'];
							
							if (($originalWidth / $args['width']) > ($originalHeight / $args['height'])){
								$aux = $originalWidth;
								$originalWidth = $args['width'] * $originalHeight / $args['height'];
								$srcX = ($aux - $originalWidth) / 2;
								$dimensions = 'x'.$args['height'];
							}
							else {
								$aux = $originalHeight;
								$originalHeight = $args['height'] * $originalWidth / $args['width'];
								$srcY = ($aux - $originalHeight) / 2;
								$dimensions = $args['width'];
							}
							
							// Resize the image with the master dimension
							
							$command = $this->dir . $base_command . ' -resize ' . escapeshellarg($dimensions) . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
							$message = exec(escapeshellcmd($command));	
							
							// And then crop it to the right dimensions
							
							$command = $this->dir . $base_command . ' -crop ' . escapeshellarg($args['width'] . 'x' . $args['height'] . '+' . $srcX . '+' . $srcY ). ' ' . $this->temp_esc . ' ' . $this->temp_esc;
							$message = exec(escapeshellcmd($command));	
						break;	
						case 'stretch':
							if ($args['width'] == 0) $dimensions = $this->img['width'].'x'.$args['height'];
							else if ($args['height'] == 0) $dimensions = $args['width'].'x'.$this->img['height'];
							else $dimensions = $args['width'].'x'.$args['height'];
							
							$command = $this->dir . $base_command . ' -resize ' . escapeshellarg($dimensions . '!') . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
							$message = exec(escapeshellcmd($command));	
						break;
						case 'fill':
							if ($args['color'][0] != '#') $args['color'] = '#' . $args['color'];
							
							$temp_fill = '___fill_' . sha1(time().'___fill') . '.jpg';
							
							$command = $this->dir . $base_command . ' -size ' . escapeshellarg($dimensions) . ' xc:"'. $args['color'] . '" '. $temp_fill;
							$message = exec($command);	
							
							$command = $this->dir . $base_command . ' -resize ' . escapeshellarg($dimensions) . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
							$message = exec(escapeshellcmd($command));	
							
							$base_command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'composite'.$this->ext : 'gm'.$this->ext . ' composite' ;
							$command = $this->dir . $base_command  . ' -gravity center over ' . $this->temp_esc . ' ' . $temp_fill . ' ' . $this->temp_esc;
							$message = exec(escapeshellcmd($command));	
							
							unlink($temp_fill);
						break;
						if ($message != ''){
							return false;	
						} 
					} 
			break;
				
		}		
		
		return true;
	}
	
	
	
	function crop($args)
	{
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				$originalWidth = imagesx($this->temp);
				$originalHeight = imagesy($this->temp);
				
				$args['width']  = min($args['width'], $originalWidth);
				$args['height'] = min($args['height'], $originalHeight);
			
				$new = imagecreatetruecolor($args['width'], $args['height']);
				if (! imagecopyresampled($new, $this->temp, 0, 0, $args['top'], $args['left'], $originalWidth, $originalHeight, $originalWidth, $originalHeight)){
					return false;
				}
				
				imagedestroy($this->temp);
				$this->temp = $new;
				
			break;

			case $this->imgProcessors[1]: 			
			case $this->imgProcessors[2]: 
				$base_command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
				
				$originalWidth = $this->img['width'];
				$originalHeight = $this->img['height'];
							
				$args['width']  = min($args['width'], $originalWidth);
				$args['height'] = min($args['height'], $originalHeight);

				$command = $this->dir . $base_command . ' -crop ' . escapeshellarg($args['width'] . 'x' . $args['height'] . '+' . $args['top'] . '+' . $args['left'] ). ' ' . $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));	
				
			break;
				
		}
		return true;
	}
	
	function watermark($args)
	{
		$path = $args['watermark'];
		if (!is_file($path)) {
				$this->setError($this->__("ERROR_WM_FILE_NOT_FOUND"));
				return false;
			}
			
		$img_info = getimagesize($path);
		if ((!is_array($img_info)) OR (count($img_info) < 3)){
			$this->setError($this-> __("ERROR_INVALID_WM_FILE"));
			return false;
		}
				
		if($img_info[2] != IMAGETYPE_PNG){
			$this->setError($this-> __("ERROR_INVALID_WM_TYPE"));
			return false;
		}

		$position = $args['position'];
		if ($position == 'random'){
			$rand = rand(0, count($this->watermarkPositions) - 1);
			$position = $this->watermarkPositions[$rand - 1];	
		}

		/*
		 * @TODO : Implement transparency feature
		 * 
		 */
			
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				$wm = imagecreatefrompng($path);
				
				$width = imagesx($this->temp);
				$height = imagesy($this->temp);
						
				$wmWidth = $img_info[0];
				$wmHeight = $img_info[1];
				
				$destX = $destY = $srcX = $srcY = 0;
								
				switch ($position){
					case 'center':
						$destX = $width / 2 - $wmWidth / 2;
						$destY = $height / 2 - $wmHeight / 2;
					break;
					case 'top':
						$destX = $width / 2 - $wmWidth / 2;
					break;
					case 'topleft':
					break;
					case 'topright':
						$destX = $width - $wmWidth;
					break;
					case 'bottom':
						$destX = $width / 2 - $wmWidth / 2;
						$destY = $height - $wmHeight;
					break;
					case 'bottomleft':
						$destY = $height - $wmHeight;
					break;
					case 'bottomright':
						$destX = $width - $wmWidth;
						$destY = $height - $wmHeight;
					break;
					case 'right':
						$destX = $width - $wmWidth;
						$destY = $height / 2 - $wmHeight / 2;
					break;
					case 'left':
						$destY = $height / 2 - $wmHeight / 2;
					break;
				}
						
				imagecopy($this->temp, $wm, $destX, $destY, $srcX, $srcY, $wmWidth, $wmHeight);
				
				imagedestroy($wm);
				
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]:
				$base_command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'composite'.$this->ext : 'gm'.$this->ext . ' composite' ;
				
				switch ($position){
					case 'top': $position = 'north';
					break;
					case 'topleft': $position = 'northwest';
					break;
					case 'topright': $position = 'northeast';
					break;
					case 'bottom': $position = 'south';
					break;
					case 'bottomleft': $position = 'southwest';
					break;
					case 'bottomright': $position = 'southeast';
					break;
					case 'right': $position = 'east';
					break;
					case 'left': $position = 'west';
					break;
				}
				
				$path = str_replace('\\', '/', realpath($path));
				
				$command = $this->dir . $base_command  . ' -gravity '. $position .' '. escapeshellarg($path) .' ' . $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));	
			break;
				
		}
		
		return true;
	}
	
	
	function grayscale()
	{
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				imagefilter($this->temp, IMG_FILTER_GRAYSCALE);	
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]: 
				$command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
							
				$command = $this->dir . $command . ' -colorspace Gray' . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));
				
				if ($message != ''){
					return false;	
				} 
			break;
				
		}
				
		return true;
	}
	
	
	function sepia()
	{
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				imagefilter($this->temp, IMG_FILTER_GRAYSCALE);
				imagefilter($this->temp, IMG_FILTER_COLORIZE, 100, 50, 0);
			break;

			case $this->imgProcessors[1]:
				$base_command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
							
				$command = $this->dir . $base_command . ' -colorspace Gray' . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));
				
				$command = $this->dir . $base_command . ' -sepia-tone 80%' . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec($command);
				
				if ($message != ''){
					return false;	
				}  
			break;
			case $this->imgProcessors[2]:

				$this->setError($this-> __("ERROR_SEPIA_NOT_SUPPORTED_GM"));
				return false;	
				   
			break;				
				
		}
				
		return true;
	}
	
	function negative()
	{
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				imagefilter($this->temp, IMG_FILTER_NEGATE);			
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]:
				$command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
				$command = $this->dir . $command . ' -negate' . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));
				
				if ($message != ''){
					return false;	
				}    
			break;
				
		}
		
		return true;
	}
	
	function blur()
	{
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				imagefilter($this->temp, IMG_FILTER_GAUSSIAN_BLUR);
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]: 
				$command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
				$command = $this->dir . $command . ' -blur 1' . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));
				
				if ($message != ''){
					return false;	
				}    
			break;
				
		}
		
		return true;
	}
	
	function invert()
	{
		return $this->negative();
	}
	
	
	function edgedetect()
	{
		switch ($this->getImageLib()){

			case $this->imgProcessors[0]:
				imagefilter($this->temp, IMG_FILTER_EDGEDETECT);	
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]: 
				$command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
				$command = $this->dir . $command . ' -edge 1' . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));
				
				if ($message != ''){
					return false;	
				}    
			break;
							
		}
		
		return true;
	}
	
	
	function meanremoval()
	{
		switch ($this->getImageLib()){

			case $this->imgProcessors[0]:
				imagefilter($this->temp, IMG_FILTER_MEAN_REMOVAL);	
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]:
				$this->setError($this-> __("ERROR_MEAN_NOT_SUPPORTED"));
				return false;	 
			break;
				
		}
				
		return true;
	}
	
	
	function emboss()
	{
		switch ($this->getImageLib()){

			case $this->imgProcessors[0]:
				imagefilter($this->temp, IMG_FILTER_EMBOSS);	
			break;
		
			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]: 
				$command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
				$command = $this->dir . $command . ' -emboss 1 -negate' . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));
				
				if ($message != ''){
					return false;	
				}    
			break;
				
		}
		
		
		return true;
	}
	
	
	/*
	 * Thanks to www.partdigital.com  and  
	 * Nakul Ganesh, Joomla! GSoC 2008 (http://developer.joomla.org/gsoc2008/advanced-media-manager.html)
	 * 
	 */
	
	function dropshadow()
	{
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				
				$x = imagesx($this->temp);
				$y = imagesy($this->temp);
							 	 
				$dir = str_replace('\\', '/', realpath(JI_DEFAULT_DROPSHADOW_DIRECTORY)."/");
				
				$tl = imagecreatefromgif($dir."shadow_TL.gif");
				$t  = imagecreatefromgif($dir."shadow_T.gif"); 
				$tr = imagecreatefromgif($dir."shadow_TR.gif"); 
				$r  = imagecreatefromgif($dir."shadow_R.gif"); 
				$br = imagecreatefromgif($dir."shadow_BR.gif"); 
				$b  = imagecreatefromgif($dir."shadow_B.gif"); 
				$bl = imagecreatefromgif($dir."shadow_BL.gif");
				$l  = imagecreatefromgif($dir."shadow_L.gif");
				
						
				$w = imagesx($l); 	
				$h = imagesy($l);	
			
				$newWidth  = $x + (2*$w);
				$newHeight = $y + (2*$w); 
				
					
				$new = imagecreatetruecolor($newWidth, $newHeight); 
					 
				imagecopyresized($new, $t, 0, 0, 0, 0, $newWidth, $w, $h, $w);			
				imagecopyresized($new, $l, 0, 0, 0, 0, $w, $newHeight, $w, $h);
				imagecopyresized($new, $b, 0, $newHeight-$w, 0, 0, $newWidth, $w, $h, $w); 
				imagecopyresized($new, $r, $newWidth-$w, 0, 0, 0, $w, $newHeight, $w, $h);
						 
				$w = imagesx($tl); 
				$h = imagesy($tl); 
				imagecopyresized($new, $tl, 0, 0, 0, 0, $w, $h, $w, $h);  
				imagecopyresized($new, $bl, 0, $newHeight-$h, 0, 0, $w, $h, $w, $h); 
				imagecopyresized($new, $br, $newWidth-$w, $newHeight-$h, 0, 0, $w, $h, $w, $h);
				imagecopyresized($new, $tr, $newWidth-$w, 0, 0, 0, $w, $h, $w, $h);  
						 
					
				$w = imagesx($l); 
				imagecopyresampled($new, $this->temp, $w, $w, 0, 0, $x, $y, $x ,$y);
				$this->temp = $new;

			break;

			case $this->imgProcessors[1]: 
				
				
				$dir = str_replace('\\', '/', realpath(JI_DEFAULT_DROPSHADOW_DIRECTORY)."/");
				
				$tl = escapeshellarg($dir."shadow_TL.gif");
				$t  = escapeshellarg($dir."shadow_T.gif"); 
				$tr = escapeshellarg($dir."shadow_TR.gif"); 
				$r  = escapeshellarg($dir."shadow_R.gif"); 
				$br = escapeshellarg($dir."shadow_BR.gif"); 
				$b  = escapeshellarg($dir."shadow_B.gif"); 
				$bl = escapeshellarg($dir."shadow_BL.gif");
				$l  = escapeshellarg($dir."shadow_L.gif");
				$bb  = escapeshellarg($dir."blank.jpg");
				
				$temp_fill = '___fill_' . sha1(time().'___fill') . '.jpg';
				$temp_top = '___t_' . sha1(time().'___t') . '.jpg';
				$temp_right = '___r_' . sha1(time().'___r') . '.jpg';
				$temp_left = '___l_' . sha1(time().'___l') . '.jpg';
				$temp_bottom = '___b_' . sha1(time().'___b') . '.jpg';
				$temp_bg = '___bg_' . sha1(time().'___bg') . '.jpg';
				
				$img_info = getimagesize($this->temp);
				$width = $img_info[0];
				$height = $img_info[1];
				
				$base_command = 'convert'.$this->ext;
				
				$message = exec(escapeshellcmd($base_command . ' -resize '.$width.'x15! ' . $t . ' ' . $temp_top));
				$message = exec(escapeshellcmd($base_command . ' -resize 15x'.$height.'! ' . $l . ' ' . $temp_left));
				$message = exec(escapeshellcmd($base_command . ' -resize 15x'.$height.'! ' . $r . ' ' . $temp_right));
				$message = exec(escapeshellcmd($base_command . ' -resize '.$width.'x15! ' . $b . ' ' . $temp_bottom));
				$message = exec(escapeshellcmd($base_command . ' -resize '.($width + 20).'x'.$height.'! ' . $bb . ' ' . $temp_bg));
				
				$base_command = 'montage'.$this->ext;
				$command = $this->dir . $base_command  
						. ' -gravity northwest '.$tl
						. ' -gravity north "'.$temp_top.'" '
						. ' -gravity northeast '.$tr 
						. ' -geometry +0+0 '.$temp_top.' ';
				$message = exec(escapeshellcmd($command));
						
				$command = $this->dir . $base_command
						. ' -gravity northwest "'.$temp_left.'" '
						. ' -gravity north "'.$temp_bg.'" '
						. ' -gravity northeast "'.$temp_right.'" '
						. ' -gravity southwest '.$bl
						. ' -gravity south "'.$temp_bottom.'" '
						. ' -gravity southeast '.$br
						. ' -tile 3x2 -geometry +0+0 '.$temp_fill.' ';
					
				$message = exec(escapeshellcmd($command));
				
				
				$command = $this->dir . $base_command  
						. ' -gravity north "'.$temp_top.'" '
						. ' -gravity south '.$temp_fill 
						. ' -tile 1x2 -geometry +0+0 '.$temp_fill.' ';
				$message = exec(escapeshellcmd($command));
				
					
				$base_command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'composite'.$this->ext : 'gm'.$this->ext . ' composite' ;
				$command = $this->dir . $base_command  . ' -gravity center over ' . $this->temp_esc . ' ' . $temp_fill . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));
				
				unlink($temp_fill);
				unlink($temp_top);
				unlink($temp_left);
				unlink($temp_right);
				unlink($temp_bottom);
				unlink($temp_bg);
			break;
			case $this->imgProcessors[2]:
				$base_command = 'gm'.$this->ext . ' montage' ;
				
				$dir = str_replace('\\', '/', realpath(JI_DEFAULT_DROPSHADOW_DIRECTORY)."/");
				
				$tl = escapeshellarg($dir."shadow_TL.gif");
				$t  = escapeshellarg($dir."shadow_T.gif"); 
				$tr = escapeshellarg($dir."shadow_TR.gif"); 
				$r  = escapeshellarg($dir."shadow_R.gif"); 
				$br = escapeshellarg($dir."shadow_BR.gif"); 
				$b  = escapeshellarg($dir."shadow_B.gif"); 
				$bl = escapeshellarg($dir."shadow_BL.gif");
				$l  = escapeshellarg($dir."shadow_L.gif");
				$bb  = escapeshellarg($dir."blank.jpg");
				
				$temp_fill = '___fill_' . sha1(time().'___fill') . '.jpg';
				
				$img_info = getimagesize($this->temp);
				$width = $img_info[0];
				$height = $img_info[1];
				
				$command = $this->dir . $base_command  
						. ' -gravity northwest '.$tl
						. ' convert -resize '.$width.'x15! -gravity north '.$t
						. ' -gravity northeast '.$tr
						. ' convert -resize 15x'.$height.'! -gravity west '.$l
						. ' convert -resize '.($width + 20).'x'.$height.'! '.$bb
						. ' convert -resize 15x'.$height.'! -gravity east '.$r
						. ' -gravity southwest '.$bl
						. ' convert -resize '.$width.'x15! -gravity south '.$b
						. ' -gravity southeast '.$br
						. ' -tile 3x3 -geometry +0+0 '. $temp_fill .' ';
					
				$message = exec(escapeshellcmd($command));
					
				$base_command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'composite'.$this->ext : 'gm'.$this->ext . ' composite' ;
				$command = $this->dir . $base_command  . ' -gravity center over ' . $this->temp_esc . ' ' . $temp_fill . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));
					
				unlink($temp_fill);
			break;
				
		}
		
		return true;
	}
	
	function brightness($brightness)
	{
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				imagefilter($this->temp, IMG_FILTER_BRIGHTNESS, $brightness);
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]: 
				$command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
				$command = $this->dir . $command . ' -modulate ' . ($brightness + 100) .' ' . $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));
				
				if ($message != ''){
					return false;	
				}    
			break;	
		}
		
		return true;
	}
	
	function contrast($contrast)
	{	
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				imagefilter($this->temp, IMG_FILTER_CONTRAST, $contrast);	
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]: 
				$base_command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
				
				if ($contrast < 0){
					$contrast_command = ' +contrast';
					$contrast = - $contrast;
				}
				else $contrast_command = ' -contrast';
				
				$contrast = ceil($contrast / 10);
				/*
				 * The -contrast command increases the image contrast by 10%, so it has to be repeated
				 * by ceil($contrast / 10) times
				 */
				
				$command = ' ';
				for ($i = 0; $i < $contrast; $i++)
					$command .= $contrast_command;
					
				$command = $this->dir . $base_command . $command . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec(escapeshellcmd($command));
				
				if ($message != ''){
					return false;	
				}    
			break;
				
		}
		
		return true;
	} 
	
	
	function smoothness($smoothness)
	{
	
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				imagefilter($this->temp, IMG_FILTER_SMOOTH, $smoothness);	
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]:
				$this->setError($this-> __("ERROR_SMOOTH_NOT_SUPPORTED"));
				return false;	 
			break;
				
		}
		
		return true;
	}
	
	
	function colorize($args)
	{
		switch ($this->getImageLib()){
			
			case $this->imgProcessors[0]:
				imagefilter($this->temp, IMG_FILTER_COLORIZE, $args['r'], $args['g'], $args['b']);	
			break;

			case $this->imgProcessors[1]: 
			case $this->imgProcessors[2]:
				$command = ($this->getImageLib() == $this->imgProcessors[1]) ? 'convert'.$this->ext : 'gm'.$this->ext . ' convert' ;
				$separator = ($this->getImageLib() == $this->imgProcessors[1]) ? ',' : '/' ;
				$command = $this->dir . $command . ' -colorize ' . $args['r'] . $separator . $args['g']. $separator . $args['b'] . ' ' . $this->temp_esc . ' ' . $this->temp_esc;
				$message = exec($command);
				
				if ($message != ''){
					return false;	
				}     
			break;
				
		}
		
		return true;
	}


	/*
	 * Saves changes of the current image. A new image is created if path is not empty
	 * 
	 * @param	string		$path		Path to the new image
	 * @param	int			$quality	Saving quality(only for JPEGs)
	 * 
	 * @return  false or string			Returns false on failure and the path to the saved image on succes
	 * 
	 */
	
	function save($path = '', $quality = JI_DEFAULT_JPG_QUALITY)
	{	
		if (!isset($this->img) || count($this->img) < 1){
			$this->setError($this-> __("ERROR_NO_IMAGE"));
			return false;
		}
		if (!isset($this->imageLib)){
			$this->setImageLib();
		}

		if (($this->getWidth() != 0 || $this->getHeight() != 0 ) && (! array_key_exists('resize', $this->actions) && ! array_key_exists('crop', $this->actions))){
			$this->setResizing();
		}
		
		if ($path == '') {
			$path = $this->getPath();			
		}	
		
		if (file_exists($path)){
			clearstatcache();
			if (filemtime($path) + $this->getCacheTime() > time()){
				return $path;
			}
			
		}
		
		$tmp = str_replace('\\', '/', dirname($path));
		
		if (! file_exists($tmp)){
			if (!JFolder::create($tmp)){
				$this->setError($this-> __("ERROR_INVALID_DIRECTORY"));
				return false;
			}
		}
		
		
		$tmp = str_replace('\\', '/', realpath($tmp)). '/';
				
		if (! is_writable($tmp)){
			//$this->setError($this-> __("ERROR_INVALID_DIRECTORY"));
			//return false;
		}
		
		$fileName = basename($path);
		$path = str_replace('\\', '/', realpath(dirname($path))). '/';
		
				
		$message = $this->process($path, $fileName, $quality);

		if ($message == false){
			return false;
		}	
		else {
			// Refresh image information in case of override
			$site_path = str_replace('\\', '/', realpath(JPATH_SITE)) . '/';
			$new_path = str_replace($site_path, '', $path.$fileName); 
			if ($path.$fileName == str_replace('\\', '/', realpath($this->getPath())) ){
				$this->setPath($new_path);
			}
			return $new_path;
		}	 
	}
	
	
	
	
	/*
	 * Saves changes of the current image. A new image is created if path is not empty
	 * 
	 * @return  false or string			Returns false on failure and the path to the generated image on succes
	 *  
	 */
	
	function getThumbnail()
	{	
		// Sets the naming options
		
		$width = min($this->getWidth(), $this->img['width']);
		$height = min($this->getHeight(), $this->img['height']);
		if ($width == 0)  $width  = $this->img['width'];
		if ($height == 0) $height = $this->img['height'];

		
		if (isset($this->customName) && $this->getName() != ''){
			$fileName = $this->getName();
		}
		else {
			$fileName = basename($this->getPath());
			$mode = $this->getUseImageSize();	
			if ($mode == 'both' || $mode == 'file'){
				$fileName = $width . "x". $height. "_". $fileName;
			}
			if (isset($this->prefix) && $this->getPrefix() != ''){
				$fileName = $this->getPrefix() . $fileName;
			}
		}

		if (isset($this->directory) && $this->getDirectory() != ''){
			$path = $this->getDirectory();
		}
		else {
			$path = dirname($this->getPath());			
		}
		
		$mode = $this->getUseImageSize();
		if ($mode == 'both' || $mode == 'dir'){
				$path = $path . "/" . $width . "x". $height . "/";
		}
		
		
		
		$this->setResizing();
			
		$message = $this->save($path.$fileName);
		
		return $message;		
	}
	
	
	
	
	/*
	 * Outputs the image to the browser with the appropriate headers
	 * 
	 */
	
	function getImage()
	{	
		if (!isset($this->img) || count($this->img) < 1){
			$this->setError($this-> __("ERROR_NO_IMAGE"));
			return false;
		}
		if (!isset($this->imageLib)){
			$this->setImageLib();
		}
		
		if (($this->getWidth() || $this->getHeight()) && (! array_key_exists('resize', $this->actions) && ! array_key_exists('crop', $this->actions))){
			$this->setResizing();
		}
		
		$path = $this->getPath();
		
		$fileName = basename($path);
		
		$path = str_replace('\\', '/', realpath(dirname($path))). '/';
		

		
		$message = $this->lib->process($path, $fileName, 100, true);
		
				
		return $message;		
	}
	
	
	
	
	/*
	 * Creates a copy of the image with a watermark image or text applied on it, to a specified position
	 * 
	 * The image used as a watermark must be JPG, GIF or PNG
	 *
	 * @param	string or object	$watermark		Path to the watermark image or a JImageLib object
	 * @param	string				$position		The position for the Watermark
	 * 		Options available: "center", "top", "topright", "topleft", "bottom", "bottomright", 
	 * 		"bottomleft", "right", "left" or "random" 
	 * @param	int					$margin_top		Value for top margin
	 * @param	int					$margin_left	Value for left margin
	 * @param	int					$transparency	Value for watermark transparency
	 * 
	 * @return  false or string			Returns false on failure and the path to the generated image on succes
	 *  
	 */
	
	function addWatermark($watermark, $position = DEFAULT_WM_POSITION, $margin_top = DEFAULT_WM_MARGIN_TOP, $margin_left = DEFAULT_WM_MARGIN_LEFT, $transparency = JI_DEFAULT_WM_TRANSPARENCY)
	{	
		// Checks if params are correct
		if (! in_array(strtolower($position), $this->watermarkPositions)){
			$this->setError($this-> __("ERROR_INVALID_WM_POSITION"));
			return false;
		}
		
		if (!is_int($margin_top) || $margin_top < 0){
			$this->setError($this->__("ERROR_INVALID_MARGIN_TOP"));
			return false;
		}
		
		if (!is_int($margin_left) || $margin_left < 0){
			$this->setError($this->__("ERROR_INVALID_MARGIN_LEFT"));
			return false;
		}
		
		if (!is_int($transparency) || $transparency < 0 || $transparency > 100){
			$this->setError($this->__("ERROR_INVALID_WM_TRANSPARENCY"));
			return false;
		}
		/*
		 * @TODO : Support for JImageLib object $watermark 
		 * 
		 */
		
		
		// Sets the naming options
		$width = min($this->getWidth(), $this->img['width']);
		$height = min($this->getHeight(), $this->img['height']);
		if ($width == 0)  $width  = $this->img['width'];
		if ($height == 0) $height = $this->img['height'];
		
		
		if (isset($this->customName) && $this->getName() != ''){
			$fileName = $this->getName();
		}
		else {
			$fileName = basename($this->getPath());
			$mode = $this->getUseImageSize();	
			if ($mode == 'both' || $mode == 'file'){
				$fileName = $width . "x". $height. "_". $fileName;
			}
			if (isset($this->prefix) && $this->getPrefix() != ''){
				$fileName = $this->getPrefix() . $fileName;
			}
		}

		if (isset($this->directory) && $this->getDirectory() != ''){
			$path = $this->getDirectory();
		}
		else {
			$path = dirname($this->getPath());	
				
		}
		
		$mode = $this->getUseImageSize();
		if ($mode == 'both' || $mode == 'dir'){
				$path = $path . "/" . $width . "x". $height . "/";
		}
		
		
		$this->actions['watermark'] = array('watermark' => $watermark, 'position' => strtolower($position), 
								'margin_top' => $margin_top, 'margin_left' => $margin_left,
								'transparency' => $transparency);
		
		
		$message = $this->save($path.$fileName);
		
			
		return $message;		
	}
	
	
	
	
	/*
	 * Generates a HTML <IMG /> tag with all the attributes
	 * If width and height are different from the image's dimensions,
	 * the tag will consist in a thumbnail linked by the image
	 * using the selected pop-up type
	 * 
	 * @return		string		String representing <IMG /> tag.
	 * 
	 */
	
	function getTag()
	{
		$width = $this->getWidth();
		$height = $this->getHeight();
		
		/* 
		 * If on of the length property is set, saves the image without resizing it
		 * and then generates its thumbnail
		 * 
		 */
		
		if ($width || $height) {
			$this->setWidth(0);	
			$this->setHeight(0);
			unset($this->actions['resizing']);
		}
		 
		if (! $image = $this->save()){
			return false;
		}
		
		
		$this->setWidth($width);
		$this->setHeight($height);
		if (! $thumb = $this->getThumbnail()){
			return false;
		}
		
		$attr = "";
		
		if ($this->getClass() != '') $attr .= ' class="'. $this->getClass() .'" ';
		if ($this->getTitle() != '') $attr .= ' title="'. $this->getTitle() .'" ';
		if ($this->getId() != '') $attr .= ' id="'. $this->getId() .'" ';
		
		$img = JHTML::image($thumb, $this->getAlt(), $attr . $this->getAttributes());

		$document = &JFactory::getDocument();
		
		if ($this->getPopUp() == 'slimbox'){
			$document->addStyleSheet(JI_SLIMBOX_CSS_PATH.'slimbox.css');
			$document->addScript(JI_SLIMBOX_JS_PATH.'mootools.js');
			$document->addScript(JI_SLIMBOX_JS_PATH.'slimbox.js');
			$tag = JHTML::link($image, $img, ' rel="lightbox" title="'.$this->getTitle().'" ');			
		}
		
		if ($this->getPopUp() == 'greybox'){
			$document->addStyleSheet(JI_GREYBOX_CSS_PATH .'gb_styles.css');
			$document->addScript(JI_GREYBOX_JS_PATH .'AJS.js');
			$document->addScript(JI_GREYBOX_JS_PATH .'AJS_fx.js');
			$document->addScript(JI_GREYBOX_JS_PATH .'gb_scripts.js');
			$tag = JHTML::link($image, $img, ' rel="gb_imageset[imgs]" title="'.$this->getTitle().'" ');
		}
		
		if ($this->getPopUp() == 'none'){
			$tag = JHTML::link($image, $img, ' title="'.$this->getTitle().'" ');
		}		
		
		/*
		 * @TODO Expand pop-up
		 * 
		 */
		
		return $tag;
	}
	
	

	
	
	
	/*
	 * Sets the language file for the error messages.
	 *   
	 * @param  string	$language		The language
	 * @param  string	$languagePath	The path to the language file directory
	 * 
	 */
	
	function setLanguage($language, $languagePath = JI_DEFAULT_LANGUAGE_DIRECTORY )
	{
		$languagePath = JPATH_COMPONENT_ADMINISTRATOR.DS.'jimagelib'.DS.'language'.DS;
		
		$params   = JComponentHelper::getParams('com_languages');
		$lg = $params->get('site', 'en-GB');
		$lg = substr($lg, 0, 2);
		
		if ( file_exists($languagePath.'jimagelib.lang-'.$language.'.php')){
			include($languagePath.'jimagelib.lang-'.$language.'.php');
		}
		elseif ( file_exists($languagePath.'jimagelib.lang-'.$lg.'.php')){
			include($languagePath.'jimagelib.lang-en.php');
		}
		elseif ( file_exists($languagePath.'jimagelib.lang-en.php')){
			include($languagePath.'jimagelib.lang-en.php');
		} 
		else {
			$this->setError("Could not load the language file");
			return false;
		}
		
		
		$this->language = $JIMAGELIB_LANG;
		return true;
	}
	
	
	
	
	/*
	 * Returns the error message translated into the specified language
	 * 
	 * @param	string	$code	Error code
	 * 	
	 * @return  string			Message in the specified language or the error code 
	 * 							if the translation failed
	 * 
	 */
	
	function __($code)
	{
		if (! isset($this->language) || count($this->language) < 1) {
			$this->setLanguage("en");
		}
		
		if (isset($this->language[$code])){
			return $this->language[$code];
		}
		else return $msg;
	}
}
