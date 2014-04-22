<?
	$format_page='showforum';
	$MAX_POSTS_IN_ONE_BASE=100;
	
	if(file_exists('set.php'))include('set.php');
	else{
		$f_keys=file('func/keywords.txt');
		$f_motors=file('func/motor.txt');
		$keyword=trim($f_keys[array_rand($f_keys)]);
		$title=trim($f_motors[array_rand($f_motors)]);
		$descr=trim($f_keys[array_rand($f_keys)]).', '.$keyword.', '.trim($f_keys[array_rand($f_keys)]).', '.trim($f_keys[array_rand($f_keys)]);
		$fh=fopen('set.php','w');
		fputs($fh,"<?\n");
		fputs($fh,'$title="'.$title.'";'."\n");
		fputs($fh,'?>');
		fclose($fh);
		unset($f_keys);
		unset($f_motors);
	}	
	
	if(isset($_GET['out']))
	{
		unset ($_SESSION['username']);	
		unset ($_SESSION['t']);	
	}
		
	if(isset($_GET[$format_page])) {
		$cur_page=$_GET[$format_page];
		if((!is_numeric($cur_page))|| ($cur_page<0))$cur_page=1;		
	}
	else $cur_page=1;
	
	if(file_exists('settings.ini'))
	{
		$f_settings=file('settings.ini');
		$MAX_PER_PAGE=trim($f_settings[0]);
		$cur_f_base=trim($f_settings[1]);
		$cur_count_posts_in_f_base=trim($f_settings[2]);
		unset($f_settings);
	}
	else{
		$fh=fopen('settings.ini','w');
		fputs($fh,"10\n1\n1\n");
		fclose($fh);
		$MAX_PER_PAGE=10;
		$cur_f_base=1;
		$cur_count_posts_in_f_base=1;
	}
	
	$total_message=($cur_f_base-1)*$MAX_POSTS_IN_ONE_BASE+$cur_count_posts_in_f_base;
	$ost=$total_message%$MAX_PER_PAGE;

	if($ost)$cur_max_pages=(int)($total_message/$MAX_PER_PAGE)+1;
	else $cur_max_pages=$total_message/$MAX_PER_PAGE;
		
	if($cur_page>$cur_max_pages)$cur_page=$cur_max_pages;
	
	
	
	
	if(file_exists('descr'))
	{
		$f_descr=file('descr');
		if ($cur_page<=count($f_descr))
		{
			$mas=explode('|',trim($f_descr[$cur_page-1]));
			$keyword=$mas[0];
			$descr=$mas[1];
		}
		else
		{
			$f_keys=file('func/keywords.txt');
			$keyword=trim($f_keys[array_rand($f_keys)]);
			$descr=trim($f_keys[array_rand($f_keys)]).', '.$keyword.', '.trim($f_keys[array_rand($f_keys)]).', '.trim($f_keys[array_rand($f_keys)]);
			
			unset($f_keys);
			$fh=fopen('descr','a');
			fputs($fh,$keyword.'|'.$descr."\n");
			fclose($fh);
		}		
		unset($_descr);
	}
	else
	{
		$f_keys=file('func/keywords.txt');
		$keyword=trim($f_keys[array_rand($f_keys)]);
		$descr=trim($f_keys[array_rand($f_keys)]).', '.$keyword.', '.trim($f_keys[array_rand($f_keys)]).', '.trim($f_keys[array_rand($f_keys)]);
		
		unset($f_keys);
		$fh=fopen('descr','a');
		fputs($fh,$keyword.'|'.$descr."\n");
		fclose($fh);
	}
?>