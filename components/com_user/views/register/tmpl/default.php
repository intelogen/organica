<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<script type="text/javascript">
<!--
	Window.onDomReady(function(){
		document.formvalidator.setHandler('passverify', function (value) { return ($('password').value == value); }	);
	});
// -->
</script>

<?php
	if(isset($this->message)){
		$this->display('message');
	}
?>

<form action="<?php echo JRoute::_( 'index.php?option=com_user' ); ?>" method="post" id="josForm" name="josForm" class="form-validate">

<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
<div class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>"><?php echo $this->escape($this->params->get('page_title')); ?></div>
<?php endif; ?>

<div style="padding:10px;margin:10px;border:1px solid #EEE;background-color:#FDFDFD;">
    <h3>Why to Register?</h3>
    <strong> We have a plan to organize your body.</strong> The plan is simple! All you have to do is fill out our Body Score and check off body compromises, symptoms, body type and individual goals. When these steps are complete your Maxim Body System assigned coach, will build a customized program designed specifically for you and personally coach you to success.<br />
No team goes to the Super Bowl with a great coach. <br />
	<div style="padding:10px;margin:10px;border:1px solid #EEE;background-color:#FDFDFD;">
		<img src="/images/icons/loginicon.png" align=middle> <a href="<?=JRoute::_('index.php?option=com_user&view=login')?>"><?=JText::_("Already Have an ID, click to login");?></a>
	</div>
</div>

<table class="registration-form">
    <tr>
        
    <td valign="top">
    
    <?php //здесь была картинка   ?> 
      <?php  /*<img src="/images/icons/sign_up.jpg" width="150">*/ ?>
    <?php //здесь была картинка   ?> 
    
    </td>
    
     <td>
        <table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
        <tr>
	        <td width="30%" height="40">
		        <label id="namemsg" for="name">
			        <?php echo JText::_( 'Name' ); ?>:
		        </label>
	        </td>
  	        <td>
  		        <input type="text" name="name" id="name" size="40" value="<?php echo $this->user->get( 'name' ) ? $this->user->get( 'name' ) : $this->request['name'] ;?>" class="inputbox required" maxlength="50" /> *
  	        </td>
        </tr>
        <tr>
	        <td height="40">
		        <label id="usernamemsg" for="username">
			        <?php echo JText::_( 'Username' ); ?>:
		        </label>
	        </td>
	        <td>
		        <input type="text" id="username" name="username" size="40" value="<?php echo $this->user->get( 'username' ) ? $this->user->get( 'username' ) : $this->request['username'];?>" class="inputbox required validate-username" maxlength="25" /> *
	        </td>
        </tr>
        <tr>
	        <td height="40">
		        <label id="emailmsg" for="email">
			        <?php echo JText::_( 'Email' ); ?>:
		        </label>
	        </td>
	        <td>
		        <input type="text" id="email" name="email" size="40" value="<?php echo $this->user->get( 'email' ) ? $this->user->get( 'email' ) : $this->request['email'];?>" class="inputbox required validate-email" maxlength="100" /> *
	        </td>
        </tr>
        <tr>
	        <td height="40">
		        <label id="pwmsg" for="password">
			        <?php echo JText::_( 'Password' ); ?>:
		        </label>
	        </td>
  	        <td>
  		        <input class="inputbox required validate-password" type="password" id="password" name="password" size="40" value="" /> *
  	        </td>
        </tr>
        <tr>
	        <td height="40">
		        <label id="pw2msg" for="password2">
			        <?php echo JText::_( 'Verify Password' ); ?>:
		        </label>
	        </td>
	        <td>
		        <input class="inputbox required validate-passverify" type="password" id="password2" name="password2" size="40" value="" /> *
	        </td>
        </tr>


        <!-- additional fields -->
        <tr>
	        <td height="40">
		        <label id="pw2msg" for="address">
			        <?php echo JText::_( 'Address' ); ?>:
		        </label>
	        </td>
	        <td>
		        <input class="inputbox required" type="text" id="address" name="address" size="40" value="<?php echo $this->request['username']; ?>" /> *
	        </td>
        </tr>
        <tr>
	        <td height="40">
		        <label id="pw2msg" for="city">
			        <?php echo JText::_( 'City' ); ?>:
		        </label>
	        </td>
	        <td>
		        <input class="inputbox required" type="text" id="city" name="city" size="40" value="<?php echo $this->request['city']; ?>" /> *
	        </td>
        </tr>
        <tr>
	        <td height="40">
		        <label id="pw2msg" for="state">
			        <?php echo JText::_( 'State' ); ?>:
		        </label>
	        </td>
	        <td>
		        <input class="inputbox required" type="text" id="state" name="state" size="40" value="<?php echo $this->request['state']; ?>" /> *
	        </td>
        </tr>
        <tr>
	        <td height="40">
		        <label id="pw2msg" for="zip">
			        <?php echo JText::_( 'Zip' ); ?>:
		        </label>
	        </td>
	        <td>
		        <input class="inputbox required" type="text" id="zip" name="zip" size="40" value="<?php echo $this->request['zip']; ?>" /> *
	        </td>
        </tr>
        <tr>
	        <td height="40">
		        <label id="pw2msg" for="phone">
			        <?php echo JText::_( 'Phone' ); ?>:
		        </label>
	        </td>
	        <td>
		        <input class="inputbox required" type="text" id="phone" name="phone" size="40" value="<?php echo $this->request['phone']; ?>" /> *
	        </td>
        </tr>
        <tr>
	        <td height="40">
		        <label id="pw2msg" for="birthday">
			        <?php echo JText::_( 'Your age' ); ?>:
		        </label>
	        </td>
	        <td>
		        <input class="inputbox required" type="text" id="birthday" name="birthday" size="40" value="<?php echo $this->request['birthday']; ?>" /> *
	        </td>
        </tr>
        <tr>
	        <td height="40">
                    <?php echo JText::_( 'Gender' ); ?>:
	        </td>
	        <td>
                    <label for="male">Male</label>
                    <input type="radio" id="male" name="sex" value="1" <?php echo $this->request['sex'] == '1' ? 'checked="true"' : ''; ?> />
                    <label for="female">Female</label>
                    <input type="radio" id="female" name="sex" value="0" <?php echo $this->request['sex'] == '0' ? 'checked="true"' : ''; ?> />
	        </td>
        </tr>
        <!-- end additional fields -->

        <tr>
            <td colspan="2">
                If you are referred by any coach, please select from the options below. 
            </td>
        </tr>
        <tr>
	        <td height="40">
		        <label id="referredby" for="referredby">
			        <?php echo JText::_( 'Referred By' ); ?>:
		        </label>
	        </td>    
            
	        <td>
		        <select name="referredby" id="referredby">
			        <option value='0'> -- Choose One -- </option>
                    <option value='other:internet' <?php echo $this->request['referredby'] == 'other:internet' ? 'selected="true"' : ''; ?>>Internet Search</option>
                    <option value='other:friend' <?php echo $this->request['referredby'] == 'other:friend' ? 'selected="true"' : ''; ?>>Friends</option>
                    <option value='other:none' <?php echo $this->request['referredby'] == 'other:none' ? 'selected="true"' : ''; ?>>None</option>
                    <optgroup label="Coach Name">
                    
			        <?php						
				        foreach ($this->coaches as $c): ?>
					        <option value="coach:<?=$c->id;?>" <?php echo $this->request['referredby'] == 'coach:'.$c->id ? 'selected="true"' : ''; ?>><?=$c->name;?></option>
			        <?php endforeach;	?>
                    
                    </optgroup>
		        </select>
	        </td>
        </tr>
            <tr>
                <td colspan="2">
                    <?php echo $this->recaptcha; ?>
                </td>
            </tr>
        <tr>
            <td colspan=2 >
                <button class="button validate" type="submit"><?php echo JText::_('Register'); ?></button>
            </td>
        </tr>
        <tr>
        		<td colspan=2>
	        			<div style="padding:10px;margin:10px;border:1px solid #EEE;background-color:#FDFDFD;">
							<img src="/images/icons/loginicon.png" align=middle> <a href="<?=JRoute::_('index.php?option=com_user&view=login')?>"><?=JText::_("Already Have an ID, click to login");?></a>
						</div>
        		</td>
        </tr>
        <tr>
	        <td colspan="2" height="40">
		        <?php echo JText::_( 'REGISTER_REQUIRED' ); ?>
	        </td>
        </tr>
        </table>
     </td>
     </tr>
 </table>
	<input type="hidden" name="task" value="register_save" />
        
        
	<input type="hidden" name="id" value="0" />
	<input type="hidden" name="gid" value="0" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
