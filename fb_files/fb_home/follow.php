<?php
	session_start();
	header('Content-Type: text/html; charset=utf-8');
	if(isset($_SESSION['fbuser']) || isset($_COOKIE['fbuser']))
	{
		include("background.php");
		
		$user_country_result=mysql_query("SELECT * FROM users WHERE user_id='$userid'");
		$row_country=mysql_fetch_assoc($user_country_result);
		$user_country=$row_country['country_id'];
		$user_second_country=$row_country['second_country_id'];
						
		if (isset($_POST['checkboxvar'])) 
		{
			echo "<h3>You now follow:</h3>";
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
			
			$que_unfollow=mysql_query("select * from users_following where user_id='$userid'");
			while ($row = mysql_fetch_assoc($que_unfollow)) 
			{
				if(ctype_alnum($row['follow_sub'])) 
				{
					$found=0;
					foreach($_POST['checkboxvar'] as $result) 
					{
						if($row['follow_sub']==$result)
						{
							$found=1;
							break;
							
						}
					}
					if($found==0)
					{
						$sub_name=$row['follow_sub'];
						mysql_query("delete from users_following where user_id='$userid' and follow_sub='$sub_name'");
						header("Location: http://www.walla.co.il/");
					}
					echo "<li>";
					echo "<a href='sub.php?s=".$row['follow_sub']."'>";
					echo "<h3>".$row['follow_sub']."</h3>";
					echo "</a>";
					echo "</li>";
				}
			}
			
			header("Location:Home.php");
			
			$cntry_one_update=$_POST['countryname'];
			$cntry_two_update=$_POST['second_countryname'];
			//mysql_query("insert into users(country_id,second_country_id) values('$user_country','$user_second_country')");
			mysql_query("UPDATE users SET country_id='$cntry_one_update',second_country_id='$cntry_two_update' WHERE user_id='$userid'");
			//mysql_query("UPDATE users SET country_id='ca' WHERE user_id='$userid'");
		}
?>

<html>








<head>
<title>My followings</title>
	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
	<link rel="stylesheet" href="assets/css/main.css" />
	<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->

	<script src="Home_js/home.js" language="javascript"></script>
	
	 <script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/skel.min.js"></script>
	<script src="assets/js/util.js"></script>
	<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
	<script src="assets/js/main.js"></script>
	
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
  #select_country
  {
  width:70%;
  }
  #second_select_country
  {
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
  #select_country
  {
  width:100%;
  }
  #second_select_country
  {
  width:100%;
  }
}
</style>


<body>



	<div id="wrapper">

		<!-- Header -->
			<header id="header" style="background-color:#85144b; color:white;">
<a href="#" class="logo"><img src="images/logo.jpg" alt="" style="height:100%;" /></a>
				<h1><a href="Home.php" style="font-size: 80%; color:#fff;">CatGory</a></h1>
				<nav class="links">
					<ul>
						<li><a href="sub.php?s=random">Random(nsfw)</a></li>
						<li><a href="sub.php?s=funny">Funny</a></li>
						<li><a href="sub.php?s=tech">Tech</a></li>
						<li><a href="sub.php?s=buzz">Buzz</a></li>
						<li><a href="sub.php?s=finance">Finance</a></li>
						<li><a href="sub.php?s=sport">Sport</a></li>
						<li><a href="sub.php?s=cute">Cute</a></li>
						<li><a href="sub.php?s=science">Science</a></li>
						<li><a href="sub.php?s=gaming">Gaming</a></li>
						<li><a href="sub.php?s=books">Books</a></li>
						<li><a href="sub.php?s=design">Design</a></li>
						<li><a href="sub.php?s=fashion">Fashion</a></li>
						<li><a href="sub.php?s=apps">Apps</a></li>
						<li><a href="sub.php?s=food">Food</a></li>
						<li><a href="sub.php?s=comic">Comic</a></li>
												<!--
						<li><a href="sub.php?s=tech">Tech</a></li>
						<li><a href="sub.php?s=science">Science</a></li>
						<li><a href="sub.php?s=buzz">Buzz</a></li>
						<li><a href="sub.php?s=finance">Finance</a></li>
						<li><a href="sub.php?s=sport">Sport</a></li>
						-->
					</ul>
				</nav>
				<nav class="main">
					<ul>
						<!--
						<li class="search">
							<a class="fa-search" style="color:white;" href="#search">Search</a>
							<form id="search" method="get" action="#">
								<input type="text" name="query" placeholder="Search" />
							</form>
						</li>
						-->
						<li class="menu" >
							<a class="fa-bars" style="color:white;" href="#menu">Menu</a>
						</li>
					</ul>
				</nav>
			</header>

		<!-- Menu -->
			<section id="menu">

				<!-- Search 
					<section>
						<form class="search" method="get" action="#">
							<input type="text" name="query" placeholder="Search" />
						</form>
					</section>
				-->
				<!-- Links -->
				<!-- Links -->
					<section>
						<ul class="actions vertical">
							<li><a href="Home.php" class="button big fit">Front page</a></li>
							<li><a href="follow.php" class="button big fit">My followings</a></li>
						</ul>
						
						<ul class="links">
							<?php
								$que_following_before=mysql_query("select * from users_following where user_id='$userid' order by follow_sub ASC");
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
						<ul class="actions vertical" style="background-color:#999;">
							<li><a href="../fb_logout/logout.php" class="button big fit">Log out</a></li>
						</ul>
					</section>

			</section>

		<!-- Main -->
			<div id="main">
			<!--<h1>My followings</h1>-->
			
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
				<!--<td>Choose categories</td>--><br>
				<td>
				<?php
					
					$que_catgories=mysql_query("select * from categories");
					while ($row = mysql_fetch_assoc($que_catgories)) 
					{
					/*
						echo "<input type='checkbox' name='checkboxvar[]' value='".$row['cat_name']."'";
						if(search_category($row['cat_name'],$userid)==1){echo "checked";}
						echo "> <span style='font-size: 1.1em;'> ".$row['cat_name']."</span><br>";
					*/
					/*
					<div class="image-box">
					  <img src="https://3.bp.blogspot.com/-W__wiaHUjwI/Vt3Grd8df0I/AAAAAAAAA78/7xqUNj8ujtY/s1600/image02.png"  draggable="false" onClick="toggleCheck(this);" />
					  <input id="dogs" type="checkbox" name="dogs" value="Dog">
					  <label for="dogs">dogs</label>
					</div>
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
			   
					<select style="background: transparent;" name="countryname" id="select_country"> 
						<!--<option value="us"> United states </option>-->
						<option value="us">United States (Default country)</option>
						<?php	
						$que_countries_txt=mysql_query("select * from countries order by country_name ASC");
						while ($row = mysql_fetch_assoc($que_countries_txt)) 
						{
							echo '<option value="'.$row['country_id'].'">'.$row['country_name'].'</option>';
						}
						?>
					</select> 
				
					
					<select style="background: transparent;" name="second_countryname" id="second_select_country"> 
						<!--<option value="us"> United states </option>-->
						<option value="dummy">Addition country (Optional)</option>
						<option value="us">United States</option>
						<?php
						$que_countries_txt=mysql_query("select * from countries order by country_name ASC");
						while ($row = mysql_fetch_assoc($que_countries_txt)) 
						{
							echo '<option value="'.$row['country_id'].'">'.$row['country_name'].'</option>';
						}
						?>
					</select>
					<script>
						document.getElementById('select_country').value = '<?php echo $user_country;?>';
						document.getElementById('second_select_country').value = '<?php echo $user_second_country;?>';
					</script>
			   
				</td> </tr> </table> <input type='submit' id="sv_button" class='buttons' value="save"> </form>

			

			
			</div>

		<!-- Sidebar -->
			<section id="sidebar">

				
					
				<!-- Footer -->
					<section id="footer">
						<section id="intro">
							
							<header>
								<h2 style="color:#000; font-size: 1.75em;">Followings</h2>
								<!--<p>Categories based social network</a></p>-->
							</header>
						</section>
						<!--
						<ul class="icons">
							<li><a href="#" class="fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="fa-instagram"><span class="label">Instagram</span></a></li>
							<li><a href="#" class="fa-rss"><span class="label">RSS</span></a></li>
							<li><a href="#" class="fa-envelope"><span class="label">Email</span></a></li>
						</ul>
						-->
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
		header("location:../../index.php");
	}
?>