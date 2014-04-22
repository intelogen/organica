<?php
// $Id: mod_chatango.php,v 1.1 2008/11/27 12:04:36 websmurf Exp $
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

$module_description = ($params->get( 'module_description' )) ? $params->get( 'module_description' ) : 'Chat with us live!';
$moduleclass_sfx 	= ($params->get( 'moduleclass_sfx' )) ? $params->get( 'moduleclass_sfx' ) : 'moduletable';
$chat_user	 		= $params->get('chat_user');
$chat_width 		= $params->get('chat_width');
$chat_height 		= $params->get('chat_height');
$chat_font 			= $params->get('chat_font');
$chat_bg	 		= '0x' . $params->get('chat_bg');
$chat_text_bg	 	= '0x' . $params->get('chat_text_bg');
$chat_input_bg 		= '0x' . $params->get('chat_input_bg');
$chat_text	 		= $params->get('chat_text');
$chat_your_name		= $params->get('chat_your_name');
$chat_friends_name	= $params->get('chat_friends_name');
$chat_msg	 		= $params->get('chat_msg');
$chat_Link			= $params->get('chat_link');
$chat_input 		= $params->get('chat_input');
$flash_vars 		= 'k=0&c=' . $chat_text . '&n=' . $chat_friends_name . '&s=' . $chat_your_name . '&m=' . $chat_msg . '&l=' . $chat_Link . '&t=' . $chat_input . '&d=' . $chat_text_bg . '&i=' . $chat_input_bg . '&b=' . $chat_bg . '&f=' . $chat_font;
?>
<div class="chatango<?php echo $moduleclass_sfx; ?>">
	<div id="chatango_description"><?php echo $module_description; ?></div>
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="<?php echo $chat_width ?>" height="<?php echo $chat_height ?>">
	<param name="movie" value="http://<?php echo $chat_user ?>.chatango.com/flash/mini.swf" />
	<param name="quality" value="high" />
	<param name="menu" value="false" />
	<param name="wmode" value="<?php if($chat_bg == '0xtrans') echo 'transparent'; ?>" />
	<param name="bgcolor" value="<?php echo (($chat_bg == '0xtrans') ? 'FFFFFF' : $params->get('chat_bg') ); ?>">
	<param name="flashvars" value="<?php echo $flash_vars ?>">
	<embed src="http://<?php echo $chat_user ?>.chatango.com/flash/mini.swf" bgcolor="<?php echo (($chat_bg == '0xtrans') ? 'FFFFFF' : $params->get('chat_bg') ); ?>" flashvars="<?php echo $flash_vars ?>" quality="high" menu="false" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo $chat_width ?>" height="<?php echo $chat_height ?>"></embed></object>
	<br />
	<img border="0" src="http://<?php echo $chat_user ?>.chatango.com/i?5" />
</object>