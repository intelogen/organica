<?php
/**
 * Core Design Login module for Joomla! 1.5
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

class modCdLoginHelper
{
	function getReturnURL($params, $type)
	{
		if ($itemid = $params->get($type))
		{
			$menu =& JSite::getMenu();
			$item = $menu->getItem($itemid);
			$url = JRoute::_($item->link.'&Itemid='.$itemid, false);
			
		} else
		{
			// stay on the same page
			$uri = JFactory::getURI();
			$url = $uri->toString(array('path', 'query', 'fragment'));
		}

		return base64_encode($url);
	}

	function getType()
	{
		$user = &JFactory::getUser();
		return (!$user->get('guest')) ? 'logout' : 'login';
	}

	function loadScripts($name)
	{
		$document = &JFactory::getDocument();
		$live_path = JURI::base(true) . '/'; // define live site

		// add CSS stylesheet
		$document->addStyleSheet($live_path . "modules/$name/tmpl/css/$name.css", "text/css");
	}

	function setForgotUsernameLink($define_links, $custom_link_forgot_username)
	{
		switch ($define_links)
		{
			case '0':
				$forgot_username_link = JRoute::_('index.php?option=com_user&view=remind');
				break;
			case '1':
				$forgot_username_link = JRoute::_($custom_link_forgot_username);
				break;
			default:
				$forgot_username_link = JRoute::_('index.php?option=com_user&view=remind');
				break;
		}
		return $forgot_username_link;
	}

	function setForgotPasswordLink($define_links, $custom_link_forgot_password)
	{
		switch ($define_links)
		{
			case '0':
				$forgot_password_link = JRoute::_('index.php?option=com_user&view=reset');
				break;
			case '1':
				$forgot_password_link = JRoute::_($custom_link_forgot_password);
				break;
			default:
				$forgot_password_link = JRoute::_('index.php?option=com_user&view=reset');
				break;
		}
		return $forgot_password_link;
	}

	function setRegisterLink($define_links, $custom_link_register)
	{
		switch ($define_links)
		{
			case '0':
				$register_link = JRoute::_('index.php?option=com_user&task=register');
				break;
			case '1':
				$register_link = JRoute::_($custom_link_register);
				break;
			default:
				$register_link = JRoute::_('index.php?option=com_user&task=register');
				break;
		}
		return $register_link;
	}

	function getFormName($form_name, $greeting)
	{
		$user = &JFactory::getUser();
		if ($form_name)
		{
			$form_name = $user->get('name');
		} else
		{
			$form_name = $user->get('username');
		}

		if ($greeting) {
			$form_name = JText::sprintf('CDLOGIN_HINAME', $form_name);
		} else {
			$form_name =  JText::_('CDLOGIN_HI_LOGOUT');
		}
		return $form_name;
	}

}
?>
