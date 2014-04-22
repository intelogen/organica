	<div class="formsubtitle">Регистрация</div>
	<div class="tablepad"><form action="index.php" name="REG" method="post">
	
	<table class="tborder" cellpadding="6" cellspacing="1" border="0" width="100%" align="center">
		<tr><td class="tcat">Регистрация</td></tr>
		<tr><td class="panelsurround" align="center">
			<div class="smallfont" style="margin-bottom:3px">
				Чтобы оставлять на форуме Форумы города Луги сообщения, необходимо сначала зарегистрироваться.<br />
Пожалуйста, укажите ваше имя пользователя, адрес электронной почты и прочую обязательную информацию о себе в форме ниже.
			</div>
			<div class="smallfont" style="margin-bottom:3px">
				<strong>Имя</strong>:<br />
				<input type="text" class="bginput" name="username" size="50" maxlength="25" value="" />
			</div>
			
			<fieldset class="fieldset">
				<legend>Пароль</legend>
				<table cellpadding="0" cellspacing="3" border="0" width="400">
					<tr>
						<td colspan="2">Введите свой пароль. <font color="red">Внимание!</font> Пароль чувствителен к регистру букв.</td>
					</tr>
					<tr>
						<td>Пароль:<br />
							<input type="password" class="bginput" name="password" size="25" maxlength="50" value="" />
						</td>
						<td>Подтвердите пароль:<br />
							<input type="password" class="bginput" name="passwordconfirm" size="25" maxlength="50" value="" />
						</td>
					</tr>
				</table>
			</fieldset>
			<fieldset class="fieldset">
				<legend>Адрес электронной почты</legend>
				<table cellpadding="0" cellspacing="3" border="0" width="400">
					<tr><td colspan="2">Введите правильный адрес электронной почты.</td></tr>
					<tr>
						<td>Адрес электронной почты:<br />
							<input type="text" class="bginput" name="email" size="25" maxlength="50" value="" dir="ltr" />
						</td>
						<td>Подтвердите адрес:<br />
							<input type="text" class="bginput" name="emailconfirm" size="25" maxlength="50" value="" dir="ltr" />
						</td>
					</tr>
				</table>
			</fieldset>
		</td></tr>
	</table>
	<br />
	<input type="submit" class="button" value="Регистрация завершена" accesskey="s"/>
</form></div>