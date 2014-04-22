<?
	$global_inverse_i_start=($cur_page-1)*$MAX_PER_PAGE;
	
	$global_inverse_i_end=(($cur_page-1)*$MAX_PER_PAGE+$MAX_PER_PAGE>$total_message)?$total_message:(($cur_page-1)*$MAX_PER_PAGE+$MAX_PER_PAGE);		
	
	$global_i_end=$total_message-$global_inverse_i_start;
	$global_i_start=$total_message-$global_inverse_i_end;
	$num_base_start=(int)($global_i_start/$MAX_POSTS_IN_ONE_BASE)+1;
	$num_base_end=(int)($global_i_end/$MAX_POSTS_IN_ONE_BASE)+1;
	if($num_base_start==$num_base_end)
	{
		$local_i_start=$global_i_start%$MAX_POSTS_IN_ONE_BASE;
		$local_i_end=$global_i_end%$MAX_POSTS_IN_ONE_BASE;
		get_posts_from_base($num_base_start,$local_i_start,$local_i_end);
	}
	else
	{
		$local_i_start_base_1=$global_i_start%$MAX_POSTS_IN_ONE_BASE;
		$local_i_end_base_1=$MAX_POSTS_IN_ONE_BASE;
		$local_i_start_base_2=0;
		$local_i_end_base_2=$global_i_end%$MAX_POSTS_IN_ONE_BASE;
		get_posts_from_base($num_base_end,$local_i_start_base_2,$local_i_end_base_2);
		get_posts_from_base($num_base_start,$local_i_start_base_1,$local_i_end_base_1);
	}
	echo '<center>';
	for($i=$cur_page-3;$i<=$cur_page+3;$i++)
	{
		if($i<1)$t=$i+$cur_max_pages;
		else if($i>$cur_max_pages)$t=$i-$cur_max_pages;
		else $t=$i;

		if($t<1)$t=1;
		else if($t>$cur_max_pages)$t=1;

		if($i==$cur_page)echo 'Страница '.$cur_page.' , ';
		else echo '<a href="index.php?'.$format_page.'='.$t.'">Страница ',$t,'</a> , ';
	}
	echo '</center>';	

function get_posts_from_base($num_base_start,$local_i_start,$local_i_end){
	if(file_exists('base'.$num_base_start))
	{
		$f_base=file_get_contents('base'.$num_base_start);
		$mas_posts=explode("=||=\n",$f_base);
		for($i=($local_i_end-1);$i>=$local_i_start;$i--)
		{
			$cut_msg=explode("=|=",$mas_posts[$i]);
			print_msg($cut_msg[0],$cut_msg[1]);
		}					
		unset($cut_msg);
		unset($mas_posts);
		unset($f_base);
	}
}							

function print_msg($title,$msg)
{
echo <<<POST1
<br><div class="borderwrap"><div class="formsubtitle">$title</div><div class="tablepad"><span class="postcolor">$msg</span></div></div>
POST1;
}
?>