<?php
	session_start();
	if(isset($_SESSION['fbuser']))
	{
		$user=$_SESSION['fbuser'];
	}
	elseif(isset($_COOKIE['fbuser']))
	{
		$user=$_COOKIE['fbuser'];
	}
mysql_connect('catgory.ipagemysql.com', 'yagcat', 'dbgori12345!');
mysql_select_db("catgodb");
	$query1=mysql_query("select * from users where Email='$user'");
	$rec1=mysql_fetch_array($query1);
	$userid=$rec1[0];
	mysql_query("update user_status set status='Offline' where user_id='$userid'");
	if(isset($_SESSION['fbuser']))
	{
		unset($_SESSION['fbuser']);
	}
	if(isset($_SESSION['tempfbuser']))
	{
		unset($_SESSION['tempfbuser']);
	}
	
	setcookie("fbuser",$user, time()-15552000, '/');
	setcookie("tempfbuser",$user, time()-15552000, '/');
	//session_destroy();
	header("location:../../login/Home.php");
?>