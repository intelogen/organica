<?
	if(isset($_REQUEST[session_name()])){
		session_start();
		$_SESSION['t']='1';
	}
	$MAX_POSTS_IN_ONE_BASE=100;
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
	
	echo '<a href="index.php?showforum='.mt_rand(1,$cur_max_pages).'#do=newthread">Новая тема</a>';
?>