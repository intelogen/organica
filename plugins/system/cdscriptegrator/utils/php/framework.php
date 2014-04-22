<?php
/**
 * Core Design Scriptegrator plugin for Joomla! 1.5
 */

defined('_JEXEC') or die( 'Restricted access' );

class JScriptegrator {
	
	/**
	 * Set properties for Scriptegrator plugin
	 * 
	 * @param $property 
	 * 
	 * @return string
	 */
	function properties($property = 'name') {
	
		$name = 'cdscriptegrator';
		$version = '1.3.6';
		$folder = '/plugins/system/cdscriptegrator';
		
		switch ($property) {
			case 'name':
				$property = $name;
				break;
			case 'version':
				$property = $version;
				break;
			case 'folder':
				$property = $folder;
				break;
			default:
				$property = $name;
				break;
		}
		return $property;
	}
	
	/**
	 * Define Scriptegrator
	 * 
	 * @return void
	 */
	function defineScriptegrator() {
		if (!defined('_JSCRIPTEGRATOR')) {
			define('_JSCRIPTEGRATOR', JScriptegrator::properties('name'));
		}
	}

	/**
	 * Return Scriptegrator folder path
	 * 
	 * @param $absolute
	 * 
	 * @return string
	 */
	function folder($absolute = false) {
		global $mainframe;

		$root = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));
		if ($absolute) {
			$path = JPath::clean($root . JScriptegrator::properties('folder'));
		} else {
			$path = JURI::root(true) . JScriptegrator::properties('folder');
		}

		return $path;
	}

	/**
	 * Get actual Scriptegrator version
	 * 
	 * @return string
	 */
	function getVersion() {
		return JScriptegrator::properties('version');
	}

	/**
	 * Check version compatibility
	 * 
	 * @param $min_version
	 * 
	 * @return boolean
	 */
	function versionRequire($min_version) {
		return (version_compare( JScriptegrator::getVersion(), $min_version, '>=' ) == 1);
	}

	/**
	 * jQuery UI loader
	 * 
	 * @param $compress
	 * @param $file
	 * 
	 * @return void
	 */
	function UILoader($compress = 0, $file = 'ui.core') {
		$document = &JFactory::getDocument(); // set document for next usage
		$document->addScript(JURI::root(true) . JScriptegrator::properties('folder') . "/libraries/jquery/js/ui/jsloader.php?compress=$compress&amp;file=$file");
	}
	
	/**
	 * jQuery UI CSS loader
	 * 
	 * @param $compress
	 * @param $theme
	 * @param $file
	 * 
	 * @return void
	 */
	function UICssLoader($compress = 0, $theme = 'smoothness', $file = 'ui.base') {
		$document = &JFactory::getDocument(); // set document for next usage
		$document->addStyleSheet(JURI::root(true) . JScriptegrator::properties('folder') . "/libraries/jquery/theme/$theme/cssloader.php?compress=$compress&amp;file=$file", 'text/css');
	}

	/**
	 * JS loader legacy wrapper
	 * 
	 * @param $library
	 * @param $compress
	 * 
	 * @return void
	 */
	function JSLoader($library = 'jquery', $compress = 0) {
		JScriptegrator::library($library, $compress);
	}
	
	/**
	 * Library JS loader
	 * 
	 * @param $library
	 * @param $compress
	 * 
	 * @return void
	 */
	function library($library = 'jquery', $compress = 0) {
		$document = &JFactory::getDocument(); // set document for next usage
		$document->addScript(JURI::root(true) . JScriptegrator::properties('folder') . "/libraries/$library/js/jsloader.php?compress=$compress");
	}

	/**
	 * Check if library is enabled (jQuery, Highslide...)
	 * 
	 * @param $library
	 * @param $interface
	 * 
	 * @return boolean
	 */
	function checkLibrary($library = 'jquery', $interface = 'site') {
		global $mainframe;

		$plugin = &JPluginHelper::getPlugin('system', _JSCRIPTEGRATOR);
		$pluginParams = new JParameter($plugin->params);

		$pluginParams = (int)$pluginParams->get($library, 0);
		
		$library = false;
		
		switch ($interface) {
			case 'site':
				switch ($pluginParams) {
					case 1:
					case 3:
						$library = true;
						break;
					default:
						$library = false;
						break;
				}
				break;
			case 'admin':
				switch ($pluginParams) {
					case 2:
					case 3:
						$library = true;
						break;
					default:
						$library = false;
						break;
				}
				break;
			default:
				return false;
				break;
		}
		
		return $library;
	}
	
	/**
	 * Return list of available themes
	 * 
	 * @return array
	 */
	function themeList() {
		jimport('joomla.filesystem.folder');
		$path = JScriptegrator::folder(true) . DS . 'libraries' . DS . 'jquery' . DS . 'theme';
		$files = array();
		$files = JFolder::folders($path, '.', false, false);
		return $files;
	}

}

?>
