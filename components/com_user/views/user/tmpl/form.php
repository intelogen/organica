<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<script type="text/javascript">
<!--
	Window.onDomReady(function(){
		document.formvalidator.setHandler('passverify', function (value) { return ($('password').value == value); }	);
	});
// -->
</script>

<form action="index.php" method="post" name="userform" autocomplete="off" class="form-validate">
<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
	<div class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
<?php endif; ?>
<table cellpadding="5" cellspacing="0" border="0" width="100%">
<tr>
	<td>
		<label for="username">
			<?php echo JText::_( 'User Name' ); ?>:
		</label>
	</td>
	<td>
		<span><?php echo $this->user->get('username');?></span>
	</td>
</tr>
<tr>
	<td width="120">
		<label for="name">
			<?php echo JText::_( 'Your Name' ); ?>:
		</label>
	</td>
	<td>
		<input class="inputbox required" type="text" id="name" name="name" value="<?php echo $this->user->get('name');?>" size="40" />
	</td>
</tr>
<tr>
	<td>
		<label for="email">
			<?php echo JText::_( 'email' ); ?>:
		</label>
	</td>
	<td>
		<input class="inputbox required validate-email" type="text" id="email" name="email" value="<?php echo $this->user->get('email');?>" size="40" />
	</td>
</tr>
<?php if($this->user->get('password')) : ?>
<tr>
	<td>
		<label for="password">
			<?php echo JText::_( 'Password' ); ?>:
		</label>
	</td>
	<td>
		<input class="inputbox validate-password" type="password" id="password" name="password" value="" size="40" />
	</td>
</tr>
<tr>
	<td>
		<label for="password2">
			<?php echo JText::_( 'Verify Password' ); ?>:
		</label>
	</td>
	<td>
		<input class="inputbox validate-passverify" type="password" id="password2" name="password2" size="40" />
	</td>
</tr>
<!-- additional form fields -->
<tr>
	<td>
		<label for="address">
			<?php echo JText::_( 'Address' ); ?>:
		</label>
	</td>
	<td>
		<input class="inputbox" type="text" id="address" name="address" size="40" value="<?php echo $this->user->get('address');?>" />
	</td>
</tr>
<tr>
	<td>
		<label for="city">
			<?php echo JText::_( 'City' ); ?>:
		</label>
	</td>
	<td>
		<input class="inputbox" type="text" id="city" name="city" size="40" value="<?php echo $this->user->get('city');?>" />
	</td>
</tr>
<tr>
	<td>
		<label for="state">
			<?php echo JText::_( 'State' ); ?>:
		</label>
	</td>
	<td>
		<input class="inputbox" type="text" id="state" name="state" size="40" value="<?php echo $this->user->get('state');?>" />
	</td>
</tr>
<tr>
	<td>
		<label for="zip">
			<?php echo JText::_( 'Zip' ); ?>:
		</label>
	</td>
	<td>
		<input class="inputbox" type="text" id="zip" name="zip" size="40" value="<?php echo $this->user->get('zip');?>" />
	</td>
</tr>
<tr>
	<td>
		<label for="phone">
			<?php echo JText::_( 'Phone' ); ?>:
		</label>
	</td>
	<td>
		<input class="inputbox" type="text" id="phone" name="phone" size="40" value="<?php echo $this->user->get('phone');?>" />
	</td>
</tr>
<tr>
	<td>
		<label for="birthday">
			<?php echo JText::_( 'Birthday' ); ?>:
		</label>
	</td>
	<td>
		<input class="inputbox" type="text" id="birthday" name="birthday" size="40" value="<?php echo $this->user->get('birthday');?>" />
	</td>
</tr>
<tr>
	<td>
			<?php echo JText::_( 'Gender' ); ?>:
	</td>
	<td>
            <label for="male">Male</label>
            <input type="radio" name="sex" id="male" value="1" <?php echo $this->user->get('sex')==1?'checked="true"':'';?> />
            <label for="female">Female</label>
            <input type="radio" name="sex" id="female" value="0" <?php echo $this->user->get('sex')==0?'checked="true"':'';?> />
	</td>
</tr>
<!-- end additional form fields -->
<?php endif; ?>
</table>
<?php if(isset($this->params)) :  echo $this->params->render( 'params' ); endif; ?>
	<button class="button validate" type="submit" onclick="submitbutton( this.form );return false;"><?php echo JText::_('Save'); ?></button>

	<input type="hidden" name="username" value="<?php echo $this->user->get('username');?>" />
	<input type="hidden" name="id" value="<?php echo $this->user->get('id');?>" />
	<input type="hidden" name="gid" value="<?php echo $this->user->get('gid');?>" />
	<input type="hidden" name="option" value="com_user" />
	<input type="hidden" name="task" value="save" />
	<?php echo JHTML::_( 'form.token' ); ?>
</form>
