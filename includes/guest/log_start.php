<form action="index.php?act=Login&amp;CODE=01" method="post" name="LOGIN" onsubmit="return ValidateForm()">
	<div class="borderwrap">
		<div class="maintitle"><img src='style_images/1/nav_m.gif' border='0'  alt='&gt;' width='8' height='8' />&nbsp;Вход на форум</div>
		<div class="formsubtitle">Для того чтобы войти, пожалуйста, введите ниже Ваши регистрационные данные</div>
		<div class="errorwrap">
			<h4>Attention!</h4>
			<p>Перед тем как войти на форум, Вы должны пройти процесс регистрации.<br />В случае, если Вы еще не успели зарегистрироваться, Вы всегда можете это сделать, нажав на ссылку 'Регистрация', которая находится в верхней части экрана</p>
			<p><b>Забыли свой пароль? Не беда! <a href="index.php?act=Reg&amp;CODE=10">Нажмите сюда!</a></b></p>
		</div>
		<table cellspacing="1">
			<tr>
				<td width="60%" valign="top">
					<fieldset>
						<legend><b>Вход на форум</b></legend>
						<table cellspacing="1">
							<tr><td width="50%"><b>Введите Ваше имя пользователя</b></td>
								<td width="50%"><input type="text" size="25" maxlength="64" name="UserName" class="forminput" /></td>							</tr>
							<tr>
								<td width="50%"><b>Введите Ваш пароль</b></td>
								<td width="50%"><input type="password" size="25" name="PassWord" class="forminput" /></td>
							</tr>
						</table>
					</fieldset>
				</td>
				<td width="40%" valign="top">
					<fieldset>
						<legend><b>Опции</b></legend>
						<table cellspacing="1">
							<tr>
								<td width="10%"><input type="checkbox" name="CookieDate" value="1" checked="checked" /></td>
								<td width="90%"><b>Запомнить меня?</b><br /><span class="desc">Не рекомендуем ставить галку, если Вы заходите на форум с чужого компьютера</span></td>
							</tr>
							<tr>
								<td width="10%"><input type="checkbox" name="Privacy" value="1" /></td>
								<td width="90%"><b>Войти в скрытном режиме</b><br /><span class="desc">Отметьте, если не хотите быть добавленными в список пользователей, которые находятся в данный момент на форуме</span></td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td class="formbuttonrow" colspan="2"><input class="button" type="submit" name="submit" value="Войти" /></td>
			</tr>
			<tr>
				<td class="catend" colspan="2"><!-- no content --></td>
			</tr>
		</table>
	</div>
</form>