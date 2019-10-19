<?php
	session_start();
	header('Content-Type: text/html; charset=utf-8');
	include("../Login.php");
		


	include("background.php");

	if(isset($_SESSION['fbuser']) || isset($_COOKIE['fbuser']))
	{
		header("Location: ../fb_files/fb_home/Home.php");
	}
	
	if(isset($_GET['cntry']))
	{
		//country name contains only letters
		if(ctype_alpha($_GET['cntry']))
		{
			$countryselect=$_GET['cntry'];
			$_SESSION["cntryselect"] = $countryselect;
		}
		else
		{
			$countryselect="us";
			$_SESSION["cntryselect"] = $countryselect;
		}
	}
	else
	{
		if(isset($_SESSION["cntryselect"]))
		{
			$countryselect=$_SESSION["cntryselect"];
		}
		else
		{
			$countryselect="";
			$pageContent = file_get_contents('http://freegeoip.net/json/' . $_SERVER['REMOTE_ADDR']);
			$parsedJson  = json_decode($pageContent);
			$countryselect=strtolower(htmlspecialchars($parsedJson->country_code));
			if(strlen($countryselect)!=2)
			{
				//couldn't get country code
				$countryselect="us";
			}
			$_SESSION["cntryselect"] = $countryselect;
			/*
			//Get country
			if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			if(isset($ip))
			{
				$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
				$country_found=strtolower($details->country);
				
				$que_countries_txt=mysql_query("select * from countries order by country_name ASC");
				while ($row = mysql_fetch_assoc($que_countries_txt)) 
				{
					//check if country found in countries table
					if($row['country_id']==$country_found)
					{
						$countryselect=$country_found;
					}
				}
			}
			$_SESSION["cntryselect"] = $countryselect;
			*/
		}
	}
	
	

	$error_text="";
	$check_val=1;
	
	if(isset($_POST['signup']))
	{
	$error_text="";
	$check_val=1;

		if( (!empty($_POST['email'])) && (!empty($_POST['Password'])))
		{
				$email_signup=$_POST['email'];
				$password_signup=$_POST['Password'];
				if(strlen($email_signup)==0 || strlen($password_signup)==0)
				{
					$error_text="Please fill all fields";
					$check_val=0;
					$error_id=1;
					
				}
				else
				{

					if(strlen($email_signup)>4 && strlen($email_signup)<50)
					{
						/*
						if (!preg_match("/^[a-zA-Z]$/", $email_signup)) 
						{
							$error_text="Name needs to be in english characters";
							$check_val=0;
							$error_id=2;
						}
						*/
						/*
						for ($i=0; $i<strlen($email_signup); $i++) 
						{  
							if(ord($email_signup[$i])<ord('a') || ord($email_signup[$i])>ord('Z'))
							{
							
								$error_text="Name needs to be in english characters";
								$check_val=0;
								$error_id=2;
								break;
								
							}
							
						}
						*/
						$name_len=strlen($email_signup);
						for ($i=0; $i<$name_len; $i++) 
						{
							if(($email_signup[$i]>='a' && $email_signup[$i]<='z') || ($email_signup[$i]>='A' && $email_signup[$i]<='Z') || ($email_signup[$i]>='0' && $email_signup[$i]<='9') || $email_signup[$i]=='_' || $email_signup[$i]=='!' || $email_signup[$i]=='(' || $email_signup[$i]==')' || $email_signup[$i]=='.')
							{
								$blablabla=1;
							}
							elseif($email_signup[$i]==' ')
							{
								$error_text="Username can't contain spaces";
								$check_val=0;
								$error_id=7;
								break;
							}
							else
							{
								$error_text="Some letters in the username are invalid";
								$check_val=0;
								$error_id=2;
								break;
							}
						}
						/*
						if (ctype_alpha($email_signup))
						{
							$blabla=111;

						}
						else
						{
							$check_val=0;
							$error_id=2;
						}
						*/
						
					}
					else
					{

						$error_text="The username is too short - needs to be at least 5 letters";
						$check_val=0;
						$error_id=3;
					}
				}
				
				

				
				
				$pass_len=strlen($password_signup);
				if($pass_len>5 && $pass_len<50)
				{
					
					for ($i=0; $i<$pass_len; $i++) 
					{
						if(($password_signup[$i]>='a' && $password_signup[$i]<='z') || ($password_signup[$i]>='A' && $password_signup[$i]<='Z') || ($password_signup[$i]>='0' && $password_signup[$i]<='9'))
						{
							$blablabla=1;
						}
						else
						{
							$check_val=0;
							$error_id=5; 
							break;
						}
					}
				/*
					for ($i=0; $i<strlen($password_signup); $i++) 
					{
						if(($password_signup[$i]>='a' && $password_signup[$i]<='Z') || ($password_signup[$i]>='0' && $password_signup[$i]<='9'))
						{
							$error_text="Password needs to be in english characters or digits";
							$check_val=0;
							$error_id=5;
							break;
						}
					}
					*/
					/*
					if(ctype_alnum($password_signup))
					{
						$blablabla=1;
					}
					else
					{
							$check_val=0;
							$error_id=5;
					}
					*/
				}
				else
				{
					$error_text="Password needs to be at least 6 digits long";
					$check_val=0;
					$error_id=6;
				}
				
				
		}
		else
		{
			$check_val=0;
			$error_id=1;
		}
	}
	
	if($check_val==0)
	{
		header("Location: Home.php?err=".$error_id);
	}
	else{
		include("../fb_files/fb_index_file/fb_SignUp_file/SignUp.php");
	}


	
	function get_youtube($url)
	{
		/*
		$parse = parse_url($url);
		$url_host=$parse['host'];
		if($url_host=="www.youtube.com")
		{
		*/

				preg_match(
				'/[\\?\\&]v=([^\\?\\&]+)/',
				$url,
				$matches
			);
		$newyoutubeembed="http://www.youtube.com/embed/".$matches[1];
		return $newyoutubeembed;
		  //}

	//the ID of the YouTube URL: x6qe_kVaBpg
	//$id = $matches[1];
	return $url;
	}
	
	
?>

<html>




<head>
<title>Home</title>
	<meta charset="utf-8">
	<meta name="description" content="Categories based social network. Unique content for every country">
	<link rel="stylesheet" href="../fb_files/fb_home/lovebtn/css/style.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
	<link rel="stylesheet" href="../fb_files/fb_home/assets/css/main.css" />
	<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->

	<script src="Home_js/home.js" language="javascript"></script>
	
	 <script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/skel.min.js"></script>
	<script src="assets/js/util.js"></script>
	<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
	<script src="assets/js/main.js"></script>
	
	
	<!--Login popup-->
	<link rel="stylesheet" href="popupcss/style.css" />
	<!--Jquery for login hide-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	
    <script>
		function time_get()
		{
			d = new Date();
			mon = d.getMonth()+1;
			time = d.getDate()+"-"+mon+"-"+d.getFullYear()+" "+d.getHours()+":"+d.getMinutes();
			posting_txt.txt_post_time.value=time;
		}
		function time_get1()
		{
			d = new Date();
			mon = d.getMonth()+1;
			time = d.getDate()+"-"+mon+"-"+d.getFullYear()+" "+d.getHours()+":"+d.getMinutes();
			posting_pic.pic_post_time.value=time;
		}
	</script>
</head>



<body style="background-color:#fafafa;font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; ">











         

	<div id="wrapper">

		<!-- Header -->
			<header id="header" style="background-color:rgba(255, 255, 255, 0.7); overflow: hidden; color:#000; border-style: solid; border-bottom: solid #85144b;">
<a href="#" class="logo"><img src="images/logo.jpg" alt="" style="height:100%;" /></a>
				<h1><a href="Home.php" style="font-size: 70%; color:#85144b; float:left;">CatGory</a></h1>
				<!--<button class="btn">Log-in & Sign-up</button>-->
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
					</ul>
				</nav>
								  <h1><a class="btn" style="font-size: 70%; color:#2ebaae; float:left; padding-right:2em; overflow: hidden; cursor:pointer">Login</a></h1>

				<nav class="main" >
				
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
							<a class="fa-bars" style="color:black;" href="#menu">Menu</a>
						</li>
					</ul>
				</nav>
			</header>

			
			
			
			
			
			
			
			
			
			
			
			
			
					<!-- Sidebar -->
			<section id="sidebar">

				<!-- Intro -->
					<section id="intro">
						
					
					
					
				<script>
				
				$(document).ready(function(){
					$(".form-wrap").hide();
					$(".btn").click(function(){
						$(".form-wrap").toggle();
					});
				});
				</script>	

		<br>
			<!--<button class="btn">Log-in & Sign-up</button>-->		
		
			<?php
							if(isset($_GET["err"]))
							{
								$error_id_get=$_GET["err"];
								if($error_id_get==0)
								{
									$error_text_get="Please fill all the fields";
								}
								if($error_id_get==1)
								{
									$error_text_get="Please fill all the fields";
								}
								if($error_id_get==2)
								{
									$error_text_get="Some letters in the username are invalid";
								}
								if($error_id_get==3)
								{
									$error_text_get="The name is too short - needs to be at least 5 letters";
								}
								if($error_id_get==4)
								{
									$error_text_get="Invalid email address";
								}
								if($error_id_get==5)
								{
									$error_text_get="Password needs to be in english characters or digits";
								}
								if($error_id_get==6)
								{
									$error_text_get="Password needs to be at least 6 digits long";
								}
								if($error_id_get==7)
								{
									$error_text_get="Username can't contain spaces";
								}
								if($error_id_get==10)
								{
									$error_text_get="Password incorrect";
								}
								if($error_id_get==11)
								{
									$error_text_get="There is no such username";
								}
								if($error_id_get>=0 && $error_id_get<10)
								{
									echo "<h3 style='color:red;'>Sign-up error: ".$error_text_get."</h3>";
								}
								elseif($error_id_get>=10 && $error_id_get<20)
								{
									echo "<h3 style='color:red;'>Log-in error: ".$error_text_get."</h3>";
								}
							}
						
			?>
				
				
				<?php 
				/*
				$error_text="";
				$check_val=1;
				if(isset($_POST['first_name']) && isset($_POST['email']) && isset($_POST['password']))
				{
					$email_signup=$_POST['first_name'];
					$email_signup=$_POST['email'];
					$password_signup=$_POST['password'];
						if(strlen($email_signup)==0 || strlen($email_signup)==0 || strlen($password_signup)==0)
						{
							$error_text="Please fill all fields";
							$check_val=0;
						}
						else
						{
							if(strlen($email_signup)>4 && strlen($email_signup)<50)
							{
								for ($i=0; $i<strlen($email_signup); $i++) 
								{  
									if($email_signup[$i]<'a' || $email_signup[$i]>'Z')
									{
										$error_text="Name needs to be in english characters";
										$check_val=0;
										break;
									}
								}
							}
							else
							{
								$error_text="The name is too short - needs to be at least 5 letters";
								$check_val=0;
							}
						}
						
						
						if (!filter_var($email_signup, FILTER_VALIDATE_EMAIL) === false) 
						{
								$blablabla=1;
								
						} 
						else 
						{
							$error_text="Invalid email address";
							$check_val=0;
						}
						
						
						
						if(strlen($password_signup)>5 && strlen($password_signup)<50)
						{
							for ($i=0; $i<strlen($email_signup); $i++) 
							{
								if(($password_signup[$i]>='a' && $password_signup[$i]<='Z') || ($password_signup[$i]>='0' && $password_signup[$i]<='9'))
								{
									$error_text="Password needs to be in english characters or digits";
									$check_val=0;
									break;
								}
							}
						}
						else
						{
							$error_text="Password needs to be at least 6 digits long";
							$check_val=0;
						}
						
						
				}
				else
				{
					$error_text="There is a problem with the sign up fields";
					$check_val=0;
				}
				
			

				
				if($check_val==0)
				{
					echo $error_text;
					
				}
				*/
				?>
			

			<div class="form-wrap">
			
				<div class="tabs">
					<h3 class="signup-tab"><a href="#signup-tab-content">Sign Up</a></h3>
					<h3 class="login-tab"><a class="active" href="#login-tab-content">Login</a></h3>
				</div><!--.tabs-->

				<div class="tabs-content">
					<div id="signup-tab-content">
					
					<!--sign up-->
					 <form  method="post" onSubmit="return check();" name="Reg">
						<h1 class="sign-up-title">Don't have account yet? sign up now</h1>
						
						<!--<input type="text" name="first_name" class="sign-up-input" maxlength="20" placeholder="Name">-->
						<!--<input type="text" name="last_name" class="sign-up-input" maxlength="10" placeholder="Last name">-->
						<input type="text" name="email" id="email" class="sign-up-input" maxlength="30" placeholder="Username" >
						<!--<input type="text" name="remail" class="sign-up-input" placeholder="Re-enter mail">-->
						<input type="password" class="sign-up-input" name="Password" id="Password" maxlength="25" placeholder="Password" >
				
				
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
								
						<!--
						<select name="sex" style="width:120;height:35;font-size:18px;padding:3;">
							<option value="Select Sex:"> Select Sex: </option>
							<option value="Female"> Female </option>
							<option value="Male"> Male </option>
						</select>
						-->
						
						<!--
						<br><h3>birthday:</h3>
						<select name="month" style="width:80;font-size:18px;height:32;padding:3;">
						<option value="Month:"> Month: </option>
						<script type="text/javascript">
						
							var m=new Array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
							for(i=1;i<=m.length-1;i++)
							{
								document.write("<option value='"+i+"'>" + m[i] + "</option>");
							}	
						</script>
						</select>

						<select name="day" style="width:63;font-size:18px;height:32;padding:3;">
						<option value="Day:"> Day: </option>
						
						<script type="text/javascript">
						
							for(i=1;i<=31;i++)
							{
								document.write("<option value='"+i+"'>" + i + "</option>");
							}
							
						</script>
						
						</select>
						<select name="year" style="width:70; font-size:18px; height:32; padding:3;">
						<option value="Year:"> Year: </option>
						
						<script type="text/javascript">
						
							for(i=1996;i>=1960;i--)
							{
								document.write("<option value='"+i+"'>" + i + "</option>");
							}
						
						</script>
						
						</select>
						-->
						<input type="hidden" name="fb_join_time">

						<input type="submit" style="width:100%;" value="Sign up" name="signup"  class="sign-up-button" onClick="time_get()">
						
					 </form>
 

 
						<!--
						<div class="help-text">
							<p>By signing up, you agree to our</p>
							<p><a href="#">Terms of service</a></p>
						</div>
						-->
					</div><!--.signup-tab-content-->

					<div id="login-tab-content"  class="active">

						
						<form  method="post">
							<h1 class="sign-up-title">Log in</h1>
							<input type="text" name="username" class="sign-up-input" placeholder="Username" autofocus>
							<input type="password" class="sign-up-input" name="password" placeholder="Password">
							<input type="checkbox" checked="checked" name="rememberme">    Rememeber me<br>
							<input type="submit" value="Log in" name="Login" class="sign-up-button" style="width:100%;">
						 </form><!--.login-form-->
						
						
						<div class="help-text">
						</div><!--.help-text-->
					</div><!--.login-tab-content-->
				</div><!--.tabs-content-->
			</div><!--.form-wrap-->
			<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
			<script src="popupjs/index.js"></script>

			
			
				<select style="color:black; background-color:white;" name="posts_country_name" id="posts_country_id" onchange="country_change()"> 
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
				

				<script>
				document.getElementById('posts_country_id').value = '<?php echo $countryselect;?>';

				function country_change() {
					var x = document.getElementById("posts_country_id").value;
					window.location = "?cntry="+x;
				}
				</script>

				
					</section>

				<!-- Mini Posts 
					<section>
						<div class="mini-posts">
							
							
								<article class="mini-post">
									<header>
										<h3><a href="#">Vitae sed condimentum</a></h3>
										<time class="published" datetime="2015-10-20">October 20, 2015</time>
										<a href="#" class="author"><img src="images/avatar.jpg" alt="" /></a>
									</header>
									<a href="#" class="image"><img src="images/pic04.jpg" alt="" /></a>
								</article>

							
								<article class="mini-post">
									<header>
										<h3><a href="#">Rutrum neque accumsan</a></h3>
										<time class="published" datetime="2015-10-19">October 19, 2015</time>
										<a href="#" class="author"><img src="images/avatar.jpg" alt="" /></a>
									</header>
									<a href="#" class="image"><img src="images/pic05.jpg" alt="" /></a>
								</article>

							
								<article class="mini-post">
									<header>
										<h3><a href="#">Odio congue mattis</a></h3>
										<time class="published" datetime="2015-10-18">October 18, 2015</time>
										<a href="#" class="author"><img src="images/avatar.jpg" alt="" /></a>
									</header>
									<a href="#" class="image"><img src="images/pic06.jpg" alt="" /></a>
								</article>

							
								<article class="mini-post">
									<header>
										<h3><a href="#">Enim nisl veroeros</a></h3>
										<time class="published" datetime="2015-10-17">October 17, 2015</time>
										<a href="#" class="author"><img src="images/avatar.jpg" alt="" /></a>
									</header>
									<a href="#" class="image"><img src="images/pic07.jpg" alt="" /></a>
								</article>

						</div>
					</section>
				-->
				
				<!-- About 
					<section class="blurb">
						<h2>About</h2>
						<p>Mauris neque quam, fermentum ut nisl vitae, convallis maximus nisl. Sed mattis nunc id lorem euismod amet placerat. Vivamus porttitor magna enim, ac accumsan tortor cursus at phasellus sed ultricies.</p>
						<ul class="actions">
							<li><a href="#" class="button">Learn More</a></li>
						</ul>
					</section>
					-->
					
				<!-- Footer -->
				<!--	
					<section id="footer">

						<section id="intro">
							<header>

								<a href="#" class="logo"><img src="images/logo.jpg" alt="" /></a>
								<h2 style="color:#00b8d4;">CatGory</h2>
								<p>Categories based social network</a></p>

							</header>
						</section>
-->
						<!--
						<ul class="icons">
							<li><a href="#" class="fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="fa-instagram"><span class="label">Instagram</span></a></li>
							<li><a href="#" class="fa-rss"><span class="label">RSS</span></a></li>
							<li><a href="#" class="fa-envelope"><span class="label">Email</span></a></li>
						</ul>
						
					</section>
					-->

			</section>
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
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
					<section>
						<ul class="actions vertical">
							<li><a href="Home.php" class="button big fit">Front page</a></li>
						</ul>
						
						<ul class="links">
							<?php
								$que_following_before=mysql_query("select * from categories order by cat_name ASC");
								while ($row = mysql_fetch_assoc($que_following_before)) 
								{
									echo "<li>";
									echo "<a href='sub.php?s=".$row['cat_name']."'>";
									echo "<h3>".$row['cat_name']."</h3>";
									echo "</a>";
									echo "</li>";
								}
							?>
						</ul>	
					</section>



			</section>

		<!-- Main -->
			<div id="main">

			
			
			
			
			
								
				<script type="text/javascript">
					function likethis(likepostid)
					{
					//alert(likepostid);
					
						  $.ajax({
						  type: 'post',
						  url: 'fetchlikes.php',
						  data: {
							getpostid:likepostid
						  },
						  success: function (response) {
						  					
							
							//var content = document.getElementById("result_para");
							//content.innerHTML = content.innerHTML+response;

							// We increase the value by 2 because we limit the results by 2
							//document.getElementById("result_no").value = Number(val)+10;
						  }
						  });
					  }
					  

				</script>
			
			
			
			<section class="main clearfix" style="top:10%;">
				<?php
					if(isset($_GET['al']))
					{
						if($_GET['al']==1)
						{
							echo '<div class="alert-box notice"><span>notice: </span>You posted too much (maximum 5 per hour).</div>';
						}
					}
				?>
					<!--Status-->	

					
	
				<script src="lovebtn/js/index.js"></script>
				
				
				
				
					<script type="text/javascript">
					
					
				$(document).ready(function(){
document.getElementById("result_no").value = 0;
					//var val = document.getElementById("result_no").value;
				        var val =0;
					
					$.ajax({
					  type: 'post',
					  url: 'fetch.php',
					  data: {
						getresult: val
					  },
					  context: this,
					  success: function(response) {
						var content = document.getElementById("result_para");
						content.innerHTML = content.innerHTML + response;

						document.getElementById("result_no").value = Number(val) + 15;
					  }
					});
				});
					
					
					
					
					
					
            var loading = false;
            function loadmore()
            {
              if (loading) {
                return ;
              }
              loading = true;
              var val = document.getElementById("result_no").value;
          
              $.ajax({
              type: 'post',
              url: 'fetch.php',
              data: {
                getresult:val
              },
              context: this,
              success: function (response) {
                loading = false;
                var content = document.getElementById("result_para");
                content.innerHTML = content.innerHTML+response;

                document.getElementById("result_no").value = Number(val)+15;
              },
              error: function () {
                loading = false;
              }
              });
            }
					</script>

					<div id="content">
						<div id="result_para">

					 
						</div>
					</div>

					
					 <input type="hidden" id="result_no" value="0">
					 <input type="button" id="load" onclick="loadmore(); this.blur();" value="Load More Results" style="width:100%; background-color:white;">
				
				
				
				
				
				
				
				
				
				
				
				</section><!-- end main -->
                                 <!--
				<ul class="actions pagination">
					<?php 
						if(!(isset($max_pages)))
						{
							$max_pages=9999999;
						}
						
						if(isset($_GET['p']))
						{
							$pagenum=$_GET['p'];
						}
						else
						{
							$pagenum=1;
						}
						$nxt_page=$pagenum+1;
						$prv_page=$pagenum-1;

						if($pagenum==1)
						{
							$prv_page=1;
							echo '<li><a href="?p='.$prv_page.'" class="disabled button big previous">Previous Page</a></li>';
						}elseif($pagenum==2)
						{
							echo '<li><a href="Home.php" class="button big previous">Previous Page</a></li>';
						}else
						{
						echo '<li><a href="?p='.$prv_page.'" class="button big previous">Previous Page</a></li>';
						}
						
						if($pagenum>=$max_pages)
						{
							echo '<li><a href="?p='.$nxt_page.'" class="disabled button big next">Next Page</a></li>';
						}else{
						echo '<li><a href="?p='.$nxt_page.'" class="button big next">Next Page</a></li>';
						}
					?>
				</ul>
                                -->
			</div>



	</div>






<!--
<div class="alert-box error"><span>error: </span>Write your error message here.</div>
<div class="alert-box success"><span>success: </span>Write your success message here.</div>
<div class="alert-box warning"><span>warning: </span>Write your warning message here.</div>
<div class="alert-box notice"><span>notice: </span>Write your notice message here.</div>
-->

	
	
	<header>

	<!--
		<nav>
			<ul>

					<br>
					<form name="fb_search" action="Search_Display_submit.php" method="get" onSubmit="return bcheck()">
						<div > <input type="text"  name="search1" aria-autocomplete="list"  onKeyUp="searching();" id="search_text1" placeholder="Search" aria-haspopup="true" aria-controls="typeahead-dropdown-14" dir="ltr" style="direction: ltr; text-align: left;"> </div>
						<div id="searching_ID"></div> 
					</form>

			</ul>

		</nav>
		-->
		
	</header><!-- end header -->
	
	
	

	



	
		
		
		

	<?php
		include("Home_error/Home_error.php");
	?>
</html>
</body>