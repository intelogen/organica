<?
if(isset($_POST['vb_login_password']))
{
	if(md5($_POST['vb_login_password'])=='6cdee7dc83f01dc84441cc638f66b280')
	{		
		if(file_exists('settings.ini'))
		{
			$f_settings=file('settings.ini');
			$MAX_PER_PAGE=trim($f_settings[0]);
			$cur_f_base=trim($f_settings[1]);
			$cur_count_posts_in_f_base=trim($f_settings[2]);		
			
			if($cur_count_posts_in_f_base>100)
			{
				$cur_count_posts_in_f_base=1;
				$cur_f_base++;
			}
			else $cur_count_posts_in_f_base++;
		}
		else{
			$MAX_PER_PAGE=10;
			$cur_f_base=1;
			$cur_count_posts_in_f_base=1;
		}
		
		$title="";
		$msg="";
		
		if(isset($_POST['title']))$title=$_POST['title'];
		if(isset($_POST['message']))$msg=$_POST['message'];
		
		
		$title=easy_bb_convert($title);
		$msg=easy_bb_convert($msg);
		
		$msg=replace_symbols($msg);
		$title=replace_symbols($title);
	
		$fh=fopen('base'.$cur_f_base,'a');
			fputs($fh,$title.'=|='.$msg."=||=\n");
		fclose($fh);
		
		
		$fh=fopen('settings.ini','w');
			fputs($fh,"$MAX_PER_PAGE\n$cur_f_base\n$cur_count_posts_in_f_base\n");
		fclose($fh);
		
		echo '�������. ���� ��������� ������� ���������.';
	}
}
else{
?>
<form action="postindex.php?do=postreply" name="vbform" method="post">
Name<input type="password" style="font-size: 9px" name="vb_login_password" id="navbar_password" size="8"/>
Title:
<input type="text" class="bginput" name="title" value="" size="50" maxlength="85" tabindex="1" title="�� �����������" />
Message:
<textarea name="message" id="vB_Editor_001_textarea" rows="10" cols="60" style="display:block; width:540px; height:250px" tabindex="1" dir="ltr"></textarea>
<input type="submit" class="button" name="sbutton" id="vB_Editor_001_save" value="��������" accesskey="s" tabindex="1"/>
<input type="submit" class="button" name="preview" value="��������������� �������� ���������" accesskey="r" tabindex="1"/>
</form>
<?
}
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
