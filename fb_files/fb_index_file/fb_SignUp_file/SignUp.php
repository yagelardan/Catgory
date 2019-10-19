<?php
if(isset($_POST['signup']))
{
mysql_connect('catgory.ipagemysql.com', 'yagcat', 'dbgori12345!');
mysql_select_db("catgodb");
	
	$Email=$_POST['email'];

	$que1=mysql_query("select * from users where Email='$Email'");
	$count1=mysql_num_rows($que1);

	if($count1>0)
	{
		echo "<script>
				alert('There is an existing account associated with this username.');
			</script>";
	}
	else
	{
		//$Name=$_POST['first_name'].' '.$_POST['last_name'];
		$Name=$Email;
		$Password=$_POST['Password'];

		$Password=password_hash($Password,PASSWORD_BCRYPT);

		//$Gender=$_POST['sex'];
		//$Birthday_Date=$_POST['day'].'-'.$_POST['month'].'-'.$_POST['year'];
		$Gender="Male";
		$Birthday_Date="11-11-1990";
		$FB_Join_Date=$_POST['fb_join_time'];
		
		//$day=intval($_POST['day']);
		//$month=intval($_POST['month']);
		//$year=intval($_POST['year']);
		
		$day=11;
		$month=11;
		$year=1990;
		
		$country=$_POST['countryname'];
		$second_country=$_POST['second_countryname'];
		
		if(checkdate($month,$day,$year))
		{
			$que2=mysql_query("insert into users(Name,Email,Password,Gender,Birthday_Date,FB_Join_Date,country_id,second_country_id) values('$Name','$Email','$Password','$Gender','$Birthday_Date','$FB_Join_Date','$country','$second_country')");

			session_start();
			$_SESSION['tempfbuser']=$Email;
	   	        $_SESSION['fbuser']=$Email;//might delete 22-6-16

			if($Gender=="Male")
			{
				header("location:../fb_files/fb_step/fb_step1/Step1_Male.php");
			}
			else
			{
				header("location:../fb_files/fb_step/fb_step1/Step1_Female.php");
			}
		}
		else
		{
			echo "<script>
				alert('The selected date is not valid.');
			</script>";
		}
	}
}
?>
