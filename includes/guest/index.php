<?
	//error_reporting(0);
	session_start();	
	require_once('func/setup.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="ru">
<head>
<!--Invision Power Board (Powered by Invision Power Board)-->
<meta HTTP-EQUIV="Content-Type" content="text/html; charset=windows-1251" />
<meta HTTP-EQUIV="Content-language" content ="ru" />
<link rel="stylesheet" type="text/css" href="design/index.css" media="all" />
<meta name="keywords" content="<?= $keyword?>">
<meta name="description" content="<?= $descr?>">
<title><?= $title.": ".ucfirst($keyword).'. Страница '.$cur_page?></title>
</head>
<body>
<div id="ipbwrapper">
<?
	require_once('main.php');

	
	if(isset($_GET['act']))
	{
		switch ($_GET['act']) {
		case 'Reg':
			include('func/login_bar.php');	
			include('reg_start.php');
			break;
		case 'Login':
			if ($_GET['CODE']=='00')include('log_start.php');//залогиниваемся
			else if ($_GET['CODE']=='03')
			{
				unset($_SESSION['t']);
				unset($_SESSION['username']);
			include('func/login_bar.php');
			}
			break;
		}
	}
	else include('func/login_bar.php');
	
	if(isset($_SESSION['username']))
	{//topic
	?>
		<div class="borderwrap" style="display:show" id="fo_1">
	<div class="maintitle">
		<p class="expand"><a href="javascript:togglecategory(1, 1);"><img src='style_images/1/exp_minus.gif' border='0'  alt='Collapse' /></a></p>
		<p><img src='style_images/1/nav_m.gif' border='0'  alt='&gt;' width='8' height='8' />&nbsp;<a href="topics.php?showforum=1">A Test Root</a></p>
	</div>
	<table cellspacing="1">
		<tr> 
			<th colspan="2" width="66%">Форум</th>
			<th align="center" width="7%">Тем</th>
			<th align="center" width="7%">Ответов</th>
			<th width="35%">Последнее сообщение</th>
		</tr><tr> 
			<td align="center" class="row2" width="1%"><a href="topics.php?act=Login&amp;CODE=04&amp;f=2" title="Пометить форум прочитанным?"><img src='style_images/1/bf_new.gif' border='0'  alt='New Posts' /></a></td>
			<td class="row2"><b><a href="topics.php?showforum=2">Главный форум</a></b><br /><span class="forumdesc">Вы можете задавать ваши вопросы здесь<br /><i></i></span></td>
			<td align="center" class="row1">26,931</td>
			<td align="center" class="row1">4,100</td>
			<td class="row1" nowrap="nowrap"><a href="topics.php?showtopic=36979&amp;view=getlastpost" title="Перейти к последнему сообщению"><img src='style_images/1/lastpost.gif' border='0'  alt='Last Post' /></a> <span>Сегодня, 11:41 PM<br /><b>В теме:</b>&nbsp;<a href='topics.php?showtopic=36979&amp;view=getnewpost' title='Перейти к первому непрочитанному сообщению: watch movies online for free without downloading anything  4588'>watch movies online for fre...</a><br /><b>Автор:</b> <a href='topics.php?showuser=1448'>GlobeXStarX</a></span></td>
		</tr><tr> 
			<td class="catend" colspan="5"><!-- no content --></td>
		</tr>
	</table>
</div>

	<?	
	}
	include('func/body.php');
?>
<table id="gfooter" cellspacing="0"><tr><td align="right">Сейчас: <? echo date("d.m.y h:i"); ?></td></tr></table>
<div class="copyright" align="center">Форум IP.Board © 2010  IPS, Inc. Copyright ©2000 - 2010
</div>
</div>
</body>
</html>
