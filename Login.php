<?php

if(isset($_POST['Login']))
{

	//mysql_connect("kwordco.ipagemysql.com","yageldbs","123456789");
	//mysql_connect('kwordco.ipagemysql.com', 'yagelgori', 'dbgori12345!');
mysql_connect('catgory.ipagemysql.com', 'yagcat', 'dbgori12345!');
	mysql_select_db("catgodb");
	
	if($_POST['username'] && $_POST['password'])
	{
		$user=$_POST['username'];
		$pass=$_POST['password'];
	
		/*
		$que1=mysql_query("select * from users where Email='$user' and Password='$pass'");
		$count1=mysql_num_rows($que1);
		*/

		
		$que1=mysql_query("select * from users where Email='$user'");
		$count1=mysql_num_rows($que1);
		
		//$hash=password_hash('123456',PASSWORD_BCRYPT);//stored password
		
		$rowque1=mysql_fetch_array($que1);
		$hash=$rowque1['Password'];
		
		//$hash='$2y$10$ZHyj39im8HFBm86zK6U0cejs36aKvVjBaEbw8A.2A8QqPLO2Xlh42';
		//$pass='123456';
		
		if (password_verify($pass, $hash)) 
		{
			echo 'Password is valid!';
		} else {
			$count1=0;
		}

		
		if($count1>0)
		{
			if(isset($_POST['rememberme']))
			{
			$que6=mysql_query("select * from users where Email='$user'");
			$rec6=mysql_fetch_array($que6);
			$userid=$rec6[0];	 	


				setcookie("fbuser",$user, time()+15552000, '/');
				setcookie("tempfbuser",$user, time()+15552000, '/');
				


			$query1=mysql_query("select * from users where Email='$user'");
			$rec1=mysql_fetch_array($query1);
			$userid=$rec1[0];
			mysql_query("update user_status set status='Online' where user_id='$userid'");
			header("location:../fb_files/fb_home/Home.php");
			
			
			}
			else
			{
			//session_start();
			$que6=mysql_query("select * from users where Email='$user'");
			$rec6=mysql_fetch_array($que6);
			$userid=$rec6[0];	
			session_start();
			$_SESSION['fbuser']=$user;
			$_SESSION['tempfbuser']=$user;
			$query1=mysql_query("select * from users where Email='$user'");
			$rec1=mysql_fetch_array($query1);
			$userid=$rec1[0];
			mysql_query("update user_status set status='Online' where user_id='$userid'");
			header("location:../fb_files/fb_home/Home.php");		
			}			
		}
		else
		{
			$que5=mysql_query("select * from users where Email='$user'");
			$count5=mysql_num_rows($que5);
		
			if($count5>0)
			{
				//header("location:../Invalid_Password.php");
                                header("Location: Home.php?err=10");
			}
			else
			{
				//header("location:../Invalid_Username.php");
                                header("Location: Home.php?err=11");
			}
		}
	}
}
?>