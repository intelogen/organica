<?
	if(!isset($_SESSION['username']))
	{
?>
	<div id="userlinksguest">		
		<p class="pcen">��� ���������� ����� ��������� ���������� <a href="index.php?act=Reg&CODE=00">������������������</a> </p>
	</div>
<?
	}
	if(file_exists('dop_content.php')) include('dop_content.php');
	echo '<div id="navstrip">
	<img src="design/nav.gif">&nbsp;<a href="index.php">'.$title.": ".ucfirst($keyword).'</a>&nbsp;&gt;&nbsp;�������� '.$cur_page.'</div>';
	
		if(isset($_SESSION['username']))
		{
			if (trim($_SESSION['username']) == '')$_SESSION['username']='admin';
	?>

		<div id="userlinks">
	<p class="home"><b>�� ����� ��� �����:  
	
	<?
		echo '<a href="index.php?showuser='.mt_rand(10,10000).'">'.$_SESSION['username'].'</a>';
	?>
	
	
	</b> ( <a href="index.php?act=Login&amp;CODE=03">�����</a> )</p>
	<p>&nbsp;<b><a href="index.php?act=UserCP&amp;CODE=00" title="�������� ��� ���������, ������������� �������, ������ � ������...">������ ����������</a></b> &middot;&nbsp;<a href="index.php?act=Search&amp;CODE=getnew">���������� ����� ���������</a>&nbsp;&middot;&nbsp;<a href="javascript:buddy_pop();" title="���������� ���������, ����������� � ������� ������ ���������� ������, moderator lists � ������...">��� ��������</a>&nbsp;&middot;&nbsp;<a href="index.php?act=Msg&amp;CODE=01">����� ��: 0</a>	</p>
</div>
<div id="navstrip"><img src='style_images/1/nav.gif' border='0'  alt='&gt;' />&nbsp;<a href='index.php?act=idx'>Invision Power Board</a></div>
<br>
	<?
		}
		else
		{
	?>	
	<table cellspacing="0" class="newslink">
	<tr>
		<td><b>������������ ��� �����! ��� ��������� ����� ���: <span>�������, 06:06 PM</span></b></td>
		<td align="right" valign="middle"><form action="index.php?act=Login&amp;CODE=01&amp;CookieDate=1" method="post">
				<input type="text" size="20" name="UserName" onfocus="this.value=''" value="��� ������������" />
				<input type="password" size="20" name="PassWord" onfocus="this.value=''" value="ibfrules" />
				<input class="button" type="image" src="index_files/login-bu.gif" />
			</form>		</td>
		</tr>
	</table>
	<br />
	<? } ?>
