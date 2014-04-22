<?php
/**
 * Core Design Login module for Joomla! 1.5
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

if (!defined('_JSCRIPTEGRATOR')) {
	echo JText::_('CDLOGIN_ENABLE_SCRIPTEGRATOR');
	return;
}

// require Scriptegrator version 1.3.3 or higher
$version = '1.3.4';
if (!JScriptegrator::versionRequire($version))
{
	echo JText::sprintf('CDLOGIN_SCRIPTEGRATOR_REQUIREVERSION', $version);
	return;
}

if (!JScriptegrator::checkLibrary('highslide', 'site'))
{
	echo JText::_('CDLOGIN_MISSING_HIGHSLIDE');
	return;
}

?>

<?php if ($type == 'logout'): ?>
<?php if ($cd_login_border == 'top' or $cd_login_border == "both"): ?>
<div class="cd_login_border-top"></div>
<?php endif; ?>
<div class="cd_login-logout-greeting"><?php echo $name; ?> <a href="#"
	onclick="return hs.htmlExpand(this, { contentId: 'highslide-html-logoutform', wrapperClassName: 'mod_cd_login', outlineType: '<?php echo
    $outlineType; ?>', align: '<?php echo $align; ?>', anchor: '<?php echo $anchor; ?>', dimmingOpacity: <?php echo
    $dimmingOpacity; ?>, slideshowGroup: 'mod_cd_login_logoutform' } )"
	title="<?php echo
    JText::_('CDLOGIN_BUTTON_LOGOUT'); ?>"> </a></div>
<div class="highslide-html-content" id="highslide-html-logoutform"
	style="width: 350px">
<div class="highslide-html-content-header">
<div class="highslide-move"
	title="<?php echo JText::_('CD_LOGIN_TITLE_MOVE'); ?>"><a href="#"
	onclick="return hs.close(this)" class="control"
	title="<?php echo
	JText::_('CD_LOGIN_CLOSELABEL'); ?>"><?php echo JText::_('CD_LOGIN_CLOSELABEL'); ?></a>
</div>
</div>
<div class="highslide-body">
<p class="cd_login-bold"><?php echo JText::_('CD_LOGIN_LOGOUT_CONFIRM'); ?></p>
<div class="cd_login-logoutform">
<form action="index.php" method="post" name="login" id="form-login"><input
	type="submit" name="Submit" class="cd_login-logoutbutton"
	value="<?php echo
    JText::_('CDLOGIN_BUTTON_LOGOUT'); ?>"
	title="<?php echo JText::_('CDLOGIN_BUTTON_LOGOUT'); ?>" /> <input
	type="hidden" name="option" value="com_user" /> <input type="hidden"
	name="task" value="logout" /> <input type="hidden" name="return"
	value="<?php echo $return; ?>" /></form>
</div>
</div>
<?php if (JText::_('CD_LOGIN_LOGOUT_MESSAGE') == ''): ?> <?php else: ?>
<div class="cd_login_message_to_users"><span><?php echo JText::_('CD_LOGIN_LOGOUT_MESSAGE'); ?></span></div>
<div style="height: 5px"></div>
<?php endif; ?></div>
<?php if ($cd_login_border == 'bottom' or $cd_login_border == "both"): ?>
<div class="cd_login_border-bottom"></div>
<?php endif; ?>
<?php else: ?>

<?php
	$document = &JFactory::getDocument(); // set document for next usage
	$focus_script = "
				<script type=\"text/javascript\">
					hs.Expander.prototype.onAfterExpand = function () {
					   document.getElementById('modlgn_username').focus();
					}				
				</script>\n";
	
	$document->addCustomTag($focus_script);
?>

<?php echo $params->get('pretext'); ?>
<?php if ($cd_login_border == 'top' or $cd_login_border == "both"): ?>
<div class="cd_login_border-top"></div>
<?php endif; ?>

<div class="cd_moduletitle_logo"><a href="#"
	onclick="return hs.htmlExpand(this, { contentId: 'highslide-html-loginform', wrapperClassName: 'mod_cd_login', outlineType: '<?php echo
        $outlineType; ?>', align: '<?php echo $align; ?>', anchor: '<?php echo $anchor; ?>', dimmingOpacity: <?php echo
        $dimmingOpacity; ?>, slideshowGroup: 'mod_cd_login_loginform' } )"
	title="<?php echo
	JText::_('CD_LOGIN_MODULE_TITLE'); ?>"><?php echo JText::_('CD_LOGIN_MODULE_TITLE'); ?>
</a></div>

	<?php if ($cd_login_border == 'bottom' or $cd_login_border == "both"): ?>
<div class="cd_login_border-bottom"></div>
	<?php endif; ?>
<div class="highslide-html-content" id="highslide-html-loginform">

<div class="highslide-html-content-header">
<div class="highslide-move"
	title="<?php echo JText::_('CD_LOGIN_TITLE_MOVE'); ?>"><a href="#"
	onclick="return hs.close(this)" class="control"
	title="<?php echo
	JText::_('CD_LOGIN_CLOSELABEL'); ?>"><?php echo JText::_('CD_LOGIN_CLOSELABEL'); ?></a>
</div>
</div>
<div class="highslide-body">

<form
	action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>"
	method="post" name="login" id="cd_login_form_login">
<fieldset class="input">
<div>
<p id="form-login-username"><label for="modlgn_username"><?php echo JText::_('CDLOGIN_USERNAME') ?></label><br />
<input id="modlgn_username" type="text" name="username" class="inputbox"
	title="<?php echo
        JText::_('CDLOGIN_USERNAME') ?>"
	alt="username" size="18" /></p>
<p id="form-login-password"><label for="modlgn_passwd"><?php echo JText::_('CDLOGIN_PASSWORD') ?></label><br />
<input id="modlgn_passwd" type="password" name="passwd" class="inputbox"
	size="18"
	title="<?php echo
            JText::_('CDLOGIN_PASSWORD') ?>"
	alt="password" /></p>
<p id="form-login-remember"><input<?php if (!JPluginHelper::isEnabled('system', 'remember')): ?> disabled="disabled" <?php endif; ?> id="modlgn_remember" type="checkbox"
	name="remember" class="inputbox" value="yes"
	title="<?php echo
            JText::_('CDLOGIN_REMEMBER_ME') ?>"
	alt="<?php echo JText::_('CDLOGIN_REMEMBER_ME') ?>" /> <label
	for="modlgn_remember"><?php echo
	JText::_('CDLOGIN_REMEMBER_ME') ?></label></p>
	<p id="form-login-submit"><input type="submit"
	name="Submit" id="cd_login_loginbutton"
	title="<?php echo
                JText::_('CDLOGIN_BUTTON_LOGIN') ?>"
	value="" /></p>
	</div>
	</fieldset>
                <?php if ($display_links): ?>
<ul>
	<li><a href="<?php echo $forgot_password_link; ?>"
		title="<?php echo JText::_('CDLOGIN_FORGOT_YOUR_PASSWORD'); ?>"> <?php echo JText::_('CDLOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
	</li>
	<li><a href="<?php echo $forgot_username_link; ?>"
		title="<?php echo JText::_('CDLOGIN_FORGOT_YOUR_USERNAME'); ?>"> <?php echo JText::_('CDLOGIN_FORGOT_YOUR_USERNAME'); ?></a>
	</li>
	<?php
	$usersConfig = &JComponentHelper::getParams('com_users');
	if ($usersConfig->get('allowUserRegistration')): ?>
	<li><a href="<?php echo $register_link; ?>"
		title="<?php echo JText::_('CDLOGIN_REGISTER'); ?>"> <?php echo JText::_('CDLOGIN_REGISTER'); ?></a>
	</li>
	<?php else: ?>
	<?php endif; ?>
	<?php endif; ?>
</ul>
<?php if (!$display_links): ?>
<div style="height: 10px"></div>
<?php endif; ?>
<input type="hidden" name="option" value="com_user" /> <input
	type="hidden" name="task" value="login" /> <input type="hidden"
	name="return" value="<?php echo $return; ?>" /> <?php echo JHTML::_('form.token'); ?>
</form>
</div>
<?php if (JText::_('CD_LOGIN_LOGIN_MESSAGE') == ''): ?> <?php else: ?>
<div class="cd_login_message_to_users"><span><?php echo JText::_('CD_LOGIN_LOGIN_MESSAGE'); ?></span></div>
<?php endif; ?></div>
<?php echo $params->get('posttext'); ?>

<?php endif; ?>
