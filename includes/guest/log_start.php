<form action="index.php?act=Login&amp;CODE=01" method="post" name="LOGIN" onsubmit="return ValidateForm()">
	<div class="borderwrap">
		<div class="maintitle"><img src='style_images/1/nav_m.gif' border='0'  alt='&gt;' width='8' height='8' />&nbsp;���� �� �����</div>
		<div class="formsubtitle">��� ���� ����� �����, ����������, ������� ���� ���� ��������������� ������</div>
		<div class="errorwrap">
			<h4>Attention!</h4>
			<p>����� ��� ��� ����� �� �����, �� ������ ������ ������� �����������.<br />� ������, ���� �� ��� �� ������ ������������������, �� ������ ������ ��� �������, ����� �� ������ '�����������', ������� ��������� � ������� ����� ������</p>
			<p><b>������ ���� ������? �� ����! <a href="index.php?act=Reg&amp;CODE=10">������� ����!</a></b></p>
		</div>
		<table cellspacing="1">
			<tr>
				<td width="60%" valign="top">
					<fieldset>
						<legend><b>���� �� �����</b></legend>
						<table cellspacing="1">
							<tr><td width="50%"><b>������� ���� ��� ������������</b></td>
								<td width="50%"><input type="text" size="25" maxlength="64" name="UserName" class="forminput" /></td>							</tr>
							<tr>
								<td width="50%"><b>������� ��� ������</b></td>
								<td width="50%"><input type="password" size="25" name="PassWord" class="forminput" /></td>
							</tr>
						</table>
					</fieldset>
				</td>
				<td width="40%" valign="top">
					<fieldset>
						<legend><b>�����</b></legend>
						<table cellspacing="1">
							<tr>
								<td width="10%"><input type="checkbox" name="CookieDate" value="1" checked="checked" /></td>
								<td width="90%"><b>��������� ����?</b><br /><span class="desc">�� ����������� ������� �����, ���� �� �������� �� ����� � ������ ����������</span></td>
							</tr>
							<tr>
								<td width="10%"><input type="checkbox" name="Privacy" value="1" /></td>
								<td width="90%"><b>����� � �������� ������</b><br /><span class="desc">��������, ���� �� ������ ���� ������������ � ������ �������������, ������� ��������� � ������ ������ �� ������</span></td>
							</tr>
						</table>
					</fieldset>
				</td>
			</tr>
			<tr>
				<td class="formbuttonrow" colspan="2"><input class="button" type="submit" name="submit" value="�����" /></td>
			</tr>
			<tr>
				<td class="catend" colspan="2"><!-- no content --></td>
			</tr>
		</table>
	</div>
</form>