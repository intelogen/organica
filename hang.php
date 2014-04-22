<?php
	ini_set("display_errors",1);
2P
asdfka;dkfaskd as fasd asdf dkas a
	echo "gollge";
die();
	var $dbtype = 'mysql';					// Normally mysql
	var $host = 'localhost:3306';				// This is normally set to localhost
	var $user = 'usr7b99f69d226';							// MySQL username
	var $password = 'God2009';						// MySQL password
	var $db = 'mmh_mysqle7a1c3734c24897a4e524081fa2e1d01';							// MySQL database name
	var $dbprefix = 'jos_';
	
	mysql_connect($host,$user,$password);
	mysql_select_db($db);

	echo mysql_error();
?>
