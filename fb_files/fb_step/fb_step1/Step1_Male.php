<?php
	session_start();
	if(isset($_SESSION['tempfbuser']))
	{
mysql_connect('catgory.ipagemysql.com', 'yagcat', 'dbgori12345!');
mysql_select_db("catgodb");
		$user=$_SESSION['tempfbuser'];
		$que1=mysql_query("select * from users where Email='$user' ");
		$rec=mysql_fetch_array($que1);
		$userid=$rec[0];
		$gender=$rec[4];

		
		if (isset($_POST['checkboxvar'])) 
		{
			$path = "../../../fb_users/Male/".$user."/Profile/";
			$path2 = "../../../fb_users/Male/".$user."/Post/";
			$path3 = "../../../fb_users/Male/".$user."/Cover/";
			mkdir($path, 0777, true);
			mkdir($path2, 0777, true);
			mkdir($path3, 0777, true);
		
			//print_r($_POST['checkboxvar']); 
			//$que_follows=mysql_query("select * from users_following where user_id=$userid");
			//echo mysql_num_rows($que_follows);
			foreach($_POST['checkboxvar'] as $result) 
			{
				//check if sub to follow contain only english letters and numbers(might change checkbox value)
				if(ctype_alnum($result)) 
				{
					$que_follows=mysql_query("select * from users_following where user_id='$userid' AND follow_sub='$result'");
					//echo mysql_num_rows($que_follows);
					if(mysql_num_rows($que_follows)==0)
					{
						//echo $result."<br>";
						//need to check if sub exist(might change on checkbox value)
						$que_catgories_chk=mysql_query("select * from categories");
						while ($row = mysql_fetch_assoc($que_catgories_chk)) 
						{
							if($row['cat_name']==$result)
							{
								mysql_query("insert into users_following(user_id,follow_sub) values('$userid','$result')");
								break;
							}
						}
					}
				}
			}
			session_start();
			$_SESSION['fbuser']=$user;
			header("location:../../fb_home/Home.php");
		}
	/*
	if(isset($_POST['file']) && ($_POST['file']=='Upload'))
	{
		$path = "../../../fb_users/Male/".$user."/Profile/";
		$path2 = "../../../fb_users/Male/".$user."/Post/";
		$path3 = "../../../fb_users/Male/".$user."/Cover/";
		mkdir($path, 0, true);
		mkdir($path2, 0, true);
		mkdir($path3, 0, true);
		
		$img_name=$_FILES['file']['name'];
    	$img_tmp_name=$_FILES['file']['tmp_name'];
    	$prod_img_path=$img_name;
    	move_uploaded_file($img_tmp_name,"../../../fb_users/Male/".$user."/Profile/".$prod_img_path);
		
		mysql_query("insert into user_profile_pic(user_id,image) values('$userid','$img_name')");
		//header("location:../fb_step3/Secret_Question2.php");
		//header("location:../fb_step2/Secret_Question1.php");
		//header("location:../../fb_home/Home.php");
		session_start();
		$_SESSION['fbuser']=$user;
		header("location:../../fb_home/Home.php");
	} 
	*/
?>
<html>
<head>
	<title> Follow </title>
	<script src="step1_js/Image_check.js" language="javascript">
	</script>
	<LINK REL="SHORTCUT ICON" HREF="../../fb_title_icon/Catico.ico" />

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!--[if lte IE 8]><script src="../../fb_home/assets/js/ie/html5shiv.js"></script><![endif]-->
	<link rel="stylesheet" href="../../fb_home/assets/css/main.css" />
	<!--[if lte IE 9]><link rel="stylesheet" href="../../fb_home/assets/css/ie9.css" /><![endif]-->
	<!--[if lte IE 8]><link rel="stylesheet" href="../../fb_home/assets/css/ie8.css" /><![endif]-->
	<script src="../../fb_home/Home_js/home.js" language="javascript"></script>
	 <script src="../../fb_home/assets/js/jquery.min.js"></script>
	<script src="../../fb_home/assets/js/skel.min.js"></script>
	<script src="../../fb_home/assets/js/util.js"></script>
	<!--[if lte IE 8]><script src="../../fb_home/assets/js/ie/respond.min.js"></script><![endif]-->
	<script src="../../fb_home/assets/js/main.js"></script>
</head>


<style>
input {
  display: none
  
}
.image-box {
  width: 30%;
  text-align: center;
  background: #E9E8E7;
  margin: 20px;
  padding:0px;
  -webkit-box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 0.75);
  -moz-box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 0.75);
  box-shadow: 2px 2px 5px 0px rgba(0, 0, 0, 0.75);
  border-radius: 5px 5px 5px 5px;
  -moz-border-radius: 5px 5px 5px 5px;
  -webkit-border-radius: 5px 5px 5px 5px;
  
  float:left;
 
 
}
.image-box img {
  max-width: 100%;
  display: block;
  
  
  margin-bottom: 7px;
}
input[type=checkbox] ~  .image-box{
background:#aaa;
}
input[type=checkbox] + label {
   color:#aaa;
  //font-style: italic;
  font-style: normal;
  
} 
label{
margin:0;
font-size: 110%;
}
input[type=checkbox]:checked + label {
  background-color: #00b8d4;
   color:#000;
  padding-left:40px;
    padding-right:40px;

 color:black;
  //font-style: normal;
  font-weight: bold;
}

  #sv_button{
  width:70%;
  }

@media screen and (max-width: 980px) {
.image-box {
  width: 80%;
  margin-left:1.5em;
  margin-bottom: 0.5em;
  }
  #sv_button{
  width:100%;
  }
}
</style>


<body>

	<div id="wrapper">

		<!-- Header -->
			<header id="header" style="background-color:#444; color:white;">
				<h1 style="font-size: 80%; color:#fff;">CatGory</h1>
			</header>

		<!-- Menu -->
			<section id="menu">

				<!-- Search -->
					<section>
						<form class="search" method="get" action="#">
							<input type="text" name="query" placeholder="Search" />
						</form>
					</section>

				<!-- Links -->
					<section>
						<ul class="links">
							<li>
								<a href="Home.php">
									<h2>Front page</h2>
								</a>
							</li>

							
							<?php
								$que_following_before=mysql_query("select * from users_following where user_id='$userid'");
								while ($row = mysql_fetch_assoc($que_following_before)) 
								{
									echo "<li>";
									echo "<a href='sub.php?s=".$row['follow_sub']."'>";
									echo "<h3>".$row['follow_sub']."</h3>";
									echo "</a>";
									echo "</li>";
								}
							?>
						</ul>		
					</section>

				<!-- Actions -->
					<section>
						<ul class="actions vertical">
							<li><a href="follow.php" class="button big fit">follow</a></li>
						</ul>
						<ul class="actions vertical" style="background-color:#999;">
							<li><a href="../fb_logout/logout.php" class="button big fit">Log out</a></li>
						</ul>
					</section>

			</section>

		<!-- Main -->
			<div id="main">
			<h1>Choose topics to follow</h1>
			
				<?php 
				
				function search_category($cat, $userid)
				{
					$que_following_check=mysql_query("select * from users_following where user_id='$userid'");
					while ($row = mysql_fetch_assoc($que_following_check)) 
					{
						if($row['follow_sub']==$cat)
						{
							return 1;
						}
					}
					return 0;
				}

				?>
				 
			
			
				<form method='post' id='userform' > <tr>
				<td>
				<?php
					
					$que_catgories=mysql_query("select * from categories");
					while ($row = mysql_fetch_assoc($que_catgories)) 
					{
						//echo $row['cat_name'];
						/*
						echo "<input type='checkbox' name='checkboxvar[]' value='".$row['cat_name']."'";
						if(search_category($row['cat_name'],$userid)==1){echo "checked";}
						echo ">".$row['cat_name']."<br>";
						*/
						
						
						echo '<div class="image-box" >';
						echo "<input id='".$row['cat_name']."' type='checkbox'  name='checkboxvar[]' value='".$row['cat_name']."'";
						if(search_category($row['cat_name'],$userid)==1){echo "checked";}
						echo ">";
						//echo "> <span style='font-size: 1.1em;'> ".$row['cat_name']."</span><br>";
						echo '<label for="'.$row['cat_name'].'">'.$row['cat_name'].'</label>';
						echo '</div>';
					}
					
				?>
				
				<!--<input type='checkbox' name='checkboxvar[]' value='funny' <?php if(search_category('funny',$userid)==1){echo "checked";} ?> >Funny<br>
				<input type='checkbox' name='checkboxvar[]' value='tech'>Tech<br>
				<input type='checkbox' name='checkboxvar[]' value='buzz'>Buzz<br>
				<input type='checkbox' name='checkboxvar[]' value='finance'>Finance<br>
				<input type='checkbox' name='checkboxvar[]' value='sport'>Sport<br>
				<input type='checkbox' name='checkboxvar[]' value='cute'>Cute<br>
				<input type='checkbox' name='checkboxvar[]' value='science'>Science<br>
				<input type='checkbox' name='checkboxvar[]' value='gaming'>Gaming<br>
			   -->
				</td> </tr> </table> <input type='submit' id="sv_button" class='buttons' value="Finish registration"> </form>

			

			
			</div>

		<!-- Sidebar -->
			<section id="sidebar">

				
					
				<!-- Footer -->
					<section id="footer">
						<section id="intro">
							
							<header>
								<h2 style="color:#00b8d4;">CatGory</h2>
								<p>Categories based social network</a></p>
							</header>
						</section>
					</section>
			</section>
	</div>















</body>

<script>
function toggleCheck(sibling) {
  var checkBox = sibling.parentNode.getElementsByTagName("input")[0];
  checkBox.checked = !checkBox.checked;
}
</script>
</html>

<?php
	}
	else
	{
		header("location:../../../index.php");
	}
?>