<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta name="generator" content="vBulletin 3.7.4" />
	<link rel="shortcut icon" href="favicon.ico">
	<title>Сообщение</title>
	<link rel="stylesheet" type="text/css" href="design/index.css" media="all">
</head>
<body>
<div id="ipbwrapper">
<table cellspacing="0" class="newslink">
	<tr>
		<td><b>Приветствуем Вас вновь! Ваш последний визит был: <span>Сегодня, 06:06 PM</span></b></td>
		<td align="right" valign="middle"><form action="index.php?act=Login&amp;CODE=01&amp;CookieDate=1" method="post">
				<input type="text" size="20" name="UserName" onfocus="this.value=''" value="Имя пользователя" />
				<input type="password" size="20" name="PassWord" onfocus="this.value=''" value="ibfrules" />
				<input class="button" type="image" src="index_files/login-bu.gif" />
			</form>		</td>
		</tr>
	</table>
	<br />
<?

	if(isset($_POST['title']))$title=$_POST['title'];
	else $title='Заголовок';
	if(isset($_POST['message']))$message=$_POST['message'];
	else $message='Сообщение';
	
	$title=easy_bb_convert($title);

	$message=easy_bb_convert($message);
	$message=replace_symbols($message);
	$title=replace_symbols($title);
	echo <<<M
		<br>
		<div class="borderwrap">
			<div class="formsubtitle">$title</div>
			<div class="tablepad"><span class="postcolor">$message</span></div>
		</div>
M;
	echo '<a href="index.php?t=1#do=newreply">Ответ</a>';
	
	function replace_symbols($str)
	{
		$str=str_replace('&lt;','<',$str);
		$str=str_replace('&gt;','>',$str);
		$str=str_replace('&quot;','"',$str);
		return $str;
	}
	
	function easy_bb_convert($bbcode)
	{
		$nl2br=1;
		$prex = array(
					'/\[b\](.*?)\[\/b\]/is'				=>	'<strong>$1</strong>',	
					'/\[i\](.*?)\[\/i\]/is'				=>	'<em>$1</em>',				
					'/\[u\](.*?)\[\/u\]/is'				=>	'<u>$1</u>',			
					'/\[url\](\<br[\s]*\/\>)[\s]*(.*?)\[\/url\]/is'			=>	'<a href="$2">$2</a>',
					'/\[url\][\s]*(.*?)\[\/url\]/is'	=>	'<a href="$1">$1</a>',
					'/\[url\=(\<br[\s]*\/\>)[\s]*(.*?)\](.*?)\[\/url\]/is'	=>	'<a href="$2">$3</a>',
					'/\[url\=(.*?)\](.*?)\[\/url\]/is'	=>	'<a href="$1">$2</a>',
					'/\[img\](\<br[\s]*\/\>)[\s]*(.*?)\[\/img\]/is'			=>	'<img src="$2" />',
					'/\[img\=(\<br[\s]*\/\>)[\s]*(.*?)\]/is'				=>	'<img src="$2" />',
					'/\[img\][\s]*(.*?)\[\/img\]/is'			=>	'<img src="$1" />',
					'/\[img\=[\s]*(.*?)\]/is'				=>	'<img src="$1" />',
					);
					
					
		$bbcode = htmlspecialchars( $bbcode, ENT_QUOTES );
		if($nl2br)$bbcode = nl2br($bbcode);
		
		$val = $bbcode;
		$val = preg_replace (array_keys($prex), array_values($prex), $val);
		
		return $val;   
	}

?>
<table id="gfooter" cellspacing="0"><tr><td align="right">Сейчас: <? echo date("d.m.y h:i"); ?></td></tr></table>
<div class="copyright" align="center">Форум IP.Board © 2010  IPS, Inc. Copyright ©2000 - 2010
</div>
</div>
</body>
</html>