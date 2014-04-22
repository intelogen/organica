<?
session_start();
$_SESSION['show'] = 1;
echo '<a href="index.php?showforum='.mt_rand(1,$cur_max_pages).'#do=newthread">Новая тема</a>';
?>