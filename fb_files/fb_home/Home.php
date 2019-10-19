<?php
	session_start();
	header('Content-Type: text/html; charset=utf-8');
	if(isset($_SESSION['fbuser']) || isset($_COOKIE['fbuser']))
	{
		include("background.php");
		
	if(isset($_POST['delete_warning']))
	{
		$user_warning_id=intval($_POST['warning_id']);
		mysql_query("delete from user_warning where user_id=$user_warning_id;");
	}
	if(isset($_POST['delete_notice']))
	{
		$n_id=intval($_POST['notice_id']);
		mysql_query("delete from users_notice where notice_id=$n_id;");
	}
	if(isset($_POST['txt']))
	{
		$txt=$_POST['post_txt'];
		
		$txt_url="";
		if(isset($_POST['post_txt_url']))
		{
			if (!filter_var($_POST['post_txt_url'], FILTER_VALIDATE_URL) === false) 
			{
				$txt_url=$_POST['post_txt_url'];
			}
		}
		
		
		$txt=htmlspecialchars($txt, ENT_QUOTES, 'UTF-8');
		$txt=str_replace('(', "&#40;", $txt);
		$txt=str_replace(')', "&#41;", $txt);
		$txt=nl2br($txt);//make it with line breaks
                $txt=str_replace('<br />', " <br>", $txt);
		
		$priority="public";
		$subname=$_POST['subname'];
		$post_time=$_POST['txt_post_time'];
		$countryname=$_POST['country_post_name'];

		$chk_post_sub_name=0;
		$que_catgories_txt=mysql_query("select * from categories order by cat_name");
		while ($row = mysql_fetch_assoc($que_catgories_txt)) 
		{
			if($row['cat_name']==$subname)
			{
				$chk_post_sub_name=1;
				break;
			}
		}
		
		$chk_post_country_name=0;
		$que_catgories_txt=mysql_query("select * from countries order by country_id");
		while ($row = mysql_fetch_assoc($que_catgories_txt)) 
		{
			if($countryname==$row['country_id'] || $countryname=="us")
			{
				$chk_post_country_name=1;
				break;
			}
		}



		if($chk_post_sub_name==1 && $chk_post_country_name==1)
		{

			//count all posts in time frame
			$all_user_recent_posts=mysql_query("select * from user_post where user_id=$userid;");
			$count_all_user_recent_posts=0;
			$current_time=$post_time;
			while($usr_posts=mysql_fetch_array($all_user_recent_posts))
			{
				$time_sub=(strtotime("$current_time")-strtotime("$usr_posts[4]"))/60;
				if($time_sub<=60)
				{
					$count_all_user_recent_posts+=1;
				}
			}
			//$txt=$txt." (count posts from last hour for user: ".$count_all_user_recent_posts.")";
			if($count_all_user_recent_posts>500)
			{
				//$txt="You posts too much - ".$txt ;
				header('Location: Home.php?al=1');
			}
			else
			{
				$country_post=$_POST['country_post_name'];
				mysql_query("insert into user_post(user_id,post_txt,post_time,priority,sub_id,post_unix_time,link,country_id) values('$userid','$txt','$post_time','$priority','$subname',UNIX_TIMESTAMP(),'$txt_url','$country_post');");
                                
$postid = mysql_insert_id();
  $post_unique_like=mysql_query("select * from user_likes where post_id='$postid' and user_id='$userid'");
  $post_unique_like_count=mysql_num_rows($post_unique_like);
  if($post_unique_like_count==0)
  {
    mysql_query("insert into user_likes(user_id,post_id) values('$userid','$postid');");
  }


                                 header('Location: postpage.php?post='.$postid);
				//header('Location: Home.php');
			}
		}else{
			header('Location: Home.php');
		}
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	if(isset($_POST['file']) && ($_POST['file']=='post'))
	{
		$txt=$_POST['post_txt'];
		$priority="public";
		$post_time=$_POST['pic_post_time'];
		$subname=$_POST['subname'];
		$countryname=$_POST['country_post_name_file'];
		$txt=htmlspecialchars($txt, ENT_QUOTES, 'UTF-8');

		
		
		$txt=str_replace('(', "	&#40;", $txt);
		$txt=str_replace(')', "	&#41;", $txt);
		$txt=nl2br($txt);//make it with line breaks
                $txt=str_replace('<br />', " <br>", $txt);
		
		
	   if($txt=="")
		{
			$txt="  ";
		}

		if($gender=="Male")
		{
			$path = "../../fb_users/Male/".$user."/Post/";
		}
		else
		{
			$path = "../../fb_users/Female/".$user."/Post/";
		}
		
		
		$chk_post_sub_name=0;
		$que_catgories_txt=mysql_query("select * from categories order by cat_name");
		while ($row = mysql_fetch_assoc($que_catgories_txt)) 
		{
			if($row['cat_name']==$subname)
			{
				$chk_post_sub_name=1;
				break;
			}
		}
		
		$chk_post_country_name=0;
		$que_catgories_txt=mysql_query("select * from countries order by country_id");
		while ($row = mysql_fetch_assoc($que_catgories_txt)) 
		{
			if($countryname==$row['country_id'] || $countryname=="us")
			{
				$chk_post_country_name=1;
				break;
			}
		}
		
		
		if($chk_post_sub_name==1 && $chk_post_country_name==1)
		{
			$mili_sec=round(microtime(true) * 1000);
			$img_name="pic".$mili_sec;
			//$img_name=$_FILES['file']['name'];
			$img_tmp_name=$_FILES['file']['tmp_name'];
			$prod_img_path=$img_name;
			$check_file_type=0;
			$extention="";
			$file_type=$_FILES['file']['type'];
			
			if($file_type=="image/jpeg" || $file_type=="image/jpg" || $file_type=="image/png" || $file_type=="video/webm" || $file_type=="video/mp4" || $file_type=="audio/mp3" || $file_type=="audio/mpeg")
			{
				$check_file_type=1;
			}
			switch($file_type)
			{
				case "image/jpeg":
					$extention=".jpeg";
					break;
				case "image/jpg":
					$extention=".jpg";
					break;
				case "image/png":
					$extention=".png";
					break;
				case "video/webm":
					$extention=".webm";
					break;
				case "video/mp4":
					$extention=".mp4";
					break;
				case "audio/mp3":
					$extention=".mp3";
					break;
				case "audio/mpeg":
					$extention=".mp3";
					break;
			}
			$img_name=$img_name.$extention;
			
			/*
			else
			{
				header('Location: Home.php?al=2');
			}
			*/
			if($check_file_type==1)
			{
				if($gender=="Male")
				{
					move_uploaded_file($img_tmp_name,"../../fb_users/Male/".$user."/Post/".$prod_img_path.$extention);
				}
				else
				{
					move_uploaded_file($img_tmp_name,"../../fb_users/Female/".$user."/Post/".$prod_img_path.$extention);
				}	
			
 			
			
				$all_user_recent_posts=mysql_query("select * from user_post where user_id=$userid;");
				$count_all_user_recent_posts=0;
				$current_time=$post_time;
				while($usr_posts=mysql_fetch_array($all_user_recent_posts))
				{
					$time_sub=(strtotime("$current_time")-strtotime("$usr_posts[4]"))/60;
					if($time_sub<=60)
					{
						$count_all_user_recent_posts+=1;
					}
				}
				
				if($count_all_user_recent_posts>500)
				{
					//$txt="You posts too much - ".$txt ;
					header('Location: Home.php?al=1');
				}
				else
				{
					$country_post=$_POST['country_post_name_file'];
					mysql_query("insert into user_post(user_id,post_txt,post_pic,post_time,priority,sub_id,country_id) values('$userid','$txt','$img_name','$post_time','$priority','$subname','$country_post');");


									$postid = mysql_insert_id();
									  $post_unique_like=mysql_query("select * from user_likes where post_id='$postid' and user_id='$userid'");
									  $post_unique_like_count=mysql_num_rows($post_unique_like);
									  if($post_unique_like_count==0)
									  {
										mysql_query("insert into user_likes(user_id,post_id) values('$userid','$postid');");
									  }

									 header('Location: postpage.php?post='.$postid);
					//header('Location: #');
				}
			}else{header('Location: Home.php?al=2');}
		}else{header('Location: Home.php');}
	}
	if(isset($_POST['delete_post']))
	{
		$post_id=intval($_POST['post_id']);
		mysql_query("delete from user_post where post_id=$post_id;");
	}
	if(isset($_POST['Like']))
	{
		$post_id=intval($_POST['postid']);
		$user_id=intval($_POST['userid']);
		mysql_query("insert into user_post_status(post_id,user_id,status) values($post_id,$user_id,'Like');");
		header('Location: Home.php');
	}
	if(isset($_POST['Unlike']))
	{
		$post_id=intval($_POST['postid']);
		$user_id=intval($_POST['userid']);
		mysql_query("delete from user_post_status where post_id=$post_id and  	user_id=$user_id;");
	}
	if(isset($_POST['comment']))
	{
		$post_id=intval($_POST['postid']);
		$user_id=intval($_POST['userid']);
		$txt=$_POST['comment_txt'];
		if($txt!="")
		{
		mysql_query("insert into user_post_comment(post_id,user_id,comment) values($post_id,$user_id,'$txt');");
		header('Location: Home.php');
		}
	}
	if(isset($_POST['delete_comment']))
	{
		$comm_id=intval($_POST['comm_id']);
		mysql_query("delete from user_post_comment where comment_id=$comm_id;");
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

	$user_country_result=mysql_query("SELECT * FROM users WHERE user_id='$userid'");
	$row_country=mysql_fetch_assoc($user_country_result);
	$user_country=$row_country['country_id'];


?>

<html>



<style>
.module {
  height: 17em;
  position: relative;
  overflow: hidden;
  margin: 0px;
}
.module > header {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 5px 10px;
}
.module > header > h2 {
  margin: 0;
  color: white;
  text-shadow: 0 1px 0 black;
}

* {
  box-sizing: border-box;
}

</style>





<head>
<title>Home</title>

	<meta charset="utf-8">
	<link rel="stylesheet" href="lovebtn/css/style.css" />

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
	
	<!--Jquery for comment box hide-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	
    <script>
		function time_get()
		{
		var selected = document.getElementById("select_post_id");
		var selectedVal = selected.options[selected.selectedIndex].value;
	   if(selectedVal != ""){
		  //do whatever
	   }else{alert('select category to the post');}
   
			d = new Date();
			mon = d.getMonth()+1;
			time = d.getDate()+"-"+mon+"-"+d.getFullYear()+" "+d.getHours()+":"+d.getMinutes();
			posting_txt.txt_post_time.value=time;
		}
		function time_get1()
		{
			document.getElementById("progressBar").innerHTML ="Uploading file... please wait";
			
			var selected = document.getElementById("select_post_id_file");
			var selectedVal = selected.options[selected.selectedIndex].value;
		   if(selectedVal != ""){
			  //do whatever
		   }else{alert('select category to the post');}
		
			d = new Date();
			mon = d.getMonth()+1;
			time = d.getDate()+"-"+mon+"-"+d.getFullYear()+" "+d.getHours()+":"+d.getMinutes();
			posting_pic.pic_post_time.value=time;
		}
		
		

						
	</script>
</head>


<body style="background-color:#fafafa; font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; ">




	<div id="wrapper">

		<!-- Header -->
				<header id="header" style="background-color:rgba(255, 255, 255, 0.7); overflow: hidden; color:#000; border-style: solid; border-bottom: solid #85144b;">
					<a href="#" class="logo"><img src="images/logo.jpg" alt="" style="height:100%;" /></a>
				<h1><a href="Home.php" style="font-size: 70%; color:#85144b; float:left;">CatGory</a></h1>
				
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
				
				<h1><a class="btn" style="font-size: 70%; color:#2ebaae; float:left; padding-right:2em; overflow: hidden; cursor:pointer">Post</a></h1>
				
				
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
                                                       $("#postform").hide();
							$(document).ready(function(){
								$("#postform").hide();
								$(".btn").click(function(){
									$("#postform").toggle();
								});
							});
						</script>	
						
						<!--<button class="btn">Share a post</button>-->
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
				<!-- Posts List
					<section>
						<ul class="posts">
						
							<script>
								function showRSS(str) {
								  if (str.length==0) { 
									document.getElementById("rssOutput").innerHTML="";
									return;
								  }
								  if (window.XMLHttpRequest) {
									// code for IE7+, Firefox, Chrome, Opera, Safari
									xmlhttp=new XMLHttpRequest();
								  } else {  // code for IE6, IE5
									xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
								  }
								  xmlhttp.onreadystatechange=function() {
									if (xmlhttp.readyState==4 && xmlhttp.status==200) {
									  document.getElementById("rssOutput").innerHTML=xmlhttp.responseText;
									}
								  }
								  xmlhttp.open("GET","getrss.php?q="+str,true);
								  xmlhttp.send();
								}
							</script>

								<form>
									<script>
										showRSS("Google");
									</script>

								</form>
								<div id="rssOutput"></div>

						</ul>
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
					
				<!-- Footer 
					<section id="footer">
						<section id="intro">
							
							<header>
								<a href="#" class="logo"><img src="images/logo.jpg" alt="" /></a>
								<h2 style="color:#00b8d4;">CatGory</h2>
								<p>Categories based social network</a></p>
							</header>
						</section>
						
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

			
			
			
			
			<section class="main clearfix" style="top:10%;">
				<?php
					if(isset($_GET['al']))
					{
						if($_GET['al']==1)
						{
							echo '<div class="alert-box notice"><span>notice: </span>You posted too much (maximum 5 per hour).</div>';
						}
					if($_GET['al']==2)
						{
							echo '<div class="alert-box error"><span>error: </span>You can only upload .jpg/.jpeg/.png images or .webm/.mp4 videos or mp3 audio.</div>';
						}
					}
				?>
				
				<?php
					$user_country_result=mysql_query("SELECT * FROM users WHERE user_id='$userid'");
					$row_country=mysql_fetch_assoc($user_country_result);
					$user_country=$row_country['country_id'];
					$user_second_country=$row_country['second_country_id'];
					
					if($user_country=="us")
					{
						$user_country_one_name="United States";
					}
					else
					{
						$user_country_one_id=mysql_query("SELECT * FROM countries WHERE country_id='$user_country'");
						$row_country_one_id=mysql_fetch_assoc($user_country_one_id);
						$user_country_one_name=$row_country_one_id['country_name'];
					}
					
					if($user_second_country!="dummy")
					{
						if($user_second_country=="us")
						{
							$user_country_two_name="United States";
						}
						else
						{
							$user_country_two_id=mysql_query("SELECT * FROM countries WHERE country_id='$user_second_country'");
							$row_country_two_id=mysql_fetch_assoc($user_country_two_id);
							$user_country_two_name=$row_country_two_id['country_name'];
						}
					}
					
				?>
					<!--Status-->	
					<div id="postform" style="background-color:#fff;">	
						<div > <!--<img src="img/Status.PNG">--><input type="button" onClick="upload_close();"  value="Text post" style="background:#FFFFFF; border:#FFFFFF; width:50%; float:left;"> <!--<img src="img/photo&video.PNG">--><input type="button"  value="Photo/Video/Audio" onClick="upload_open();" name="file" style="background:#FFFFFF; border:#FFFFFF; width:50%;"></div>

						<form method="post" name="posting_txt" onSubmit="return blank_post_check();" id="post_txt">
							<div>
								<!--<textarea style="height:60;   width:100%; resize: none;" name="post_txt" maxlength="511" placeholder="Title"></textarea>-->
								<textarea style="height:120;   width:100%; resize: none;" name="post_txt" maxlength="5000" placeholder="Share your thoughts"></textarea>
								<textarea style="height:50;   width:100%; resize: none; overflow-y: hidden;" name="post_txt_url" maxlength="200" placeholder="Add link(optional)"></textarea>
								<input type="hidden" name="txt_post_time">
							</div>	
							<div>
								<select style="background: transparent; width:50%; float:left;" name="subname" id="select_post_id"> 
									<option value=""> Choose subject </option> 
									<?php
									$que_catgories_txt=mysql_query("select * from categories order by cat_name");
									while ($row = mysql_fetch_assoc($que_catgories_txt)) 
									{
										echo '<option value="'.$row['cat_name'].'">'.$row['cat_name'].'</option>';
									}
									?>
								</select> 
								
								<select id="country_post_id" style="background: transparent; width:50%; float:right;" name="country_post_name"> 
									<option value="<?php echo $user_country; ?>"><?php echo $user_country_one_name;?></option>
									<?php
									if($user_second_country!="dummy")
									{
									?>
										<option value="<?php echo $user_second_country; ?>"><?php echo $user_country_two_name;?></option>
									<?php
									}
									?>
								</select> 
							</div>
							<div> <input type="submit" value="post" name="txt" class="btn" id="post_button" onClick="time_get()"> </div>
						</form>

							<script>
								
								document.getElementById('country_post_id').value = '<?php echo $user_country;?>';
							</script>
						<!-- form -->
						<form method="post" enctype="multipart/form-data" name="posting_pic" style="display:none;" id="post_pic" onSubmit="return Img_check();">
								<div>
									<textarea style="height:120;  width:100%; resize: none;" name="post_txt" maxlength="5000" placeholder="Share your thoughts"></textarea>
								</div>
									<input type="hidden" name="pic_post_time">
								<div >
								<select style="background: transparent; width:50%; float:left;" name="subname" id="select_post_id_file"> 
									<option value=""> Choose subject </option> 
									<?php
									$que_catgories_pic=mysql_query("select * from categories order by cat_name");
									while ($row = mysql_fetch_assoc($que_catgories_pic)) 
									{
										echo '<option value="'.$row['cat_name'].'">'.$row['cat_name'].'</option>';
									}
									?>


								</select> 
								
								
								
								<select id="country_post_id_file" style="background: transparent; width:50%; float:right;" name="country_post_name_file" > 
									<option value="<?php echo $user_country; ?>"><?php echo $user_country_one_name;?></option>
									<?php
									if($user_second_country!="dummy")
									{
									?>
										<option value="<?php echo $user_second_country; ?>"><?php echo $user_country_two_name;?></option>
									<?php
									}
									?>
								</select> 
								
								</div>
								<div > <input type="file" name="file" id="img"> </div>
								
								<div> <input type="submit" value="post" name="file" id="post_button" onClick="time_get1()"> </div>
<p id="progressBar"></p>

						</form>
							<script>
								document.getElementById('country_post_id_file').value = '<?php echo $user_country;?>';
							</script>
					</div>




				<script type="text/javascript">
					function likethis(likepostid,likeuserid)
					{
					//alert(likepostid);
						  $.ajax({
						  type: 'post',
						  url: 'fetchlikes.php',
						  data: {
							getpostid:likepostid,
							getuserid:likeuserid
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





					
			
                                <script src="lovebtn/js/index.js"></script>





					<div id="content">
						<div id="result_para">

					 
						</div>
					</div>

					<input type="hidden" id="user_id" value="<?php echo $userid;?>">
					  <input type="hidden" id="result_no" value="0">
					  <input type="button" id="load" onclick="loadmore(); this.blur();" value="Load More Results" style="width:100%; background-color:white;">

					  

				<script type="text/javascript">

				$(document).ready(function(){
					document.getElementById("result_no").value = 0;
				
              var val = 0;
              var userval = document.getElementById("user_id").value;
              $.ajax({
              type: 'post',
              url: 'fetch.php',
              data: {
                getresult:val,
                getuserid:userval
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
				
				
				});
				
				
				
            var loading = false;
            function loadmore()
            {
              if (loading) {
                return ;
              }
              loading = true;
              var val = document.getElementById("result_no").value;
              var userval = document.getElementById("user_id").value;
              $.ajax({
              type: 'post',
              url: 'fetch.php',
              data: {
                getresult:val,
                getuserid:userval
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
						}else if($pagenum==2)
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


<?php
	$que_warning=mysql_query("select * from user_warning where user_id=$userid");
	$warning_count=mysql_num_rows($que_warning);
	if($warning_count>0)
	{
		$warning_data=mysql_fetch_array($que_warning);
		$warning_txt=$warning_data[1];
?>

<div style="position:fixed; background:#3A3E41; opacity: 0.8; left:0%; top:0%; height:100%; width:100%; z-index:3"></div>
<div style="position:fixed; background:#FFF; left:17%; top:5%; height:90%; width:65.5%; z-index:3"></div>


<div style="position:fixed; left:35%; top:8%; z-index:3;"> <img src="img/Warning_icon.png" height="100" width="100"></div>
<div style="position:fixed; left:43%; top:8%; z-index:3; color:#971111; font-size:72px;">   warning  </div>

<div style="position:fixed; left:20%; top:32%; color:#971111; font-size:20px; z-index:3;">  <?php echo $warning_txt; ?> 
</div>

<form method="post" >
    <input type="hidden" name="warning_id" value="<?php echo $userid; ?>" >
<div style="position:fixed; left:62%; top:83%; z-index:3;">  
    <input type="submit" name="delete_warning" value="I accept Warning" id="accept_button">
</div> 
</form>
 
	
<?php	
	}
	$que_notice=mysql_query("select * from users_notice where user_id=$userid");
	$notice_count=mysql_num_rows($que_notice);
	if($notice_count>0)
	{
		$notice_data=mysql_fetch_array($que_notice);
		$notice_id=$notice_data[0];
		$notice_txt=$notice_data[2];
		$notice_time=$notice_data[3];
?>

<div style="position:fixed; background:#3A3E41; opacity: 0.8; left:0%; top:0%; height:100%; width:100%; z-index:3"></div>
<div style="position:fixed; background:#FFF; left:17%; top:5%; height:90%; width:65.5%; z-index:3"></div>


<div style="position:fixed; left:39%; top:8%; z-index:3;"> <img src="img/Notice.png" height="100" width="100"></div>
<div style="position:fixed; left:47%; top:12%; z-index:3; color:#3B59A4; font-size:48px;">   Notice  </div>

<div style="position:fixed; left:20%; top:32%; font-size:20px; z-index:3;">  <?php echo $notice_txt; ?> 
</div>

<div style="position:fixed; left:62%; top:75%; font-size:20px; color:#999999; z-index:3;"> Notice Time: <?php echo $notice_time; ?> 
</div>

<form method="post">
    <input type="hidden" name="notice_id" value="<?php echo $notice_id; ?>" >
<div style="position:fixed; left:62%; top:83%; z-index:3;">  
    <input type="submit" name="delete_notice" value="I accept Notice" id="accept_button">
</div> 
</form>
 
	
<?php	
	}
	 $query_online=mysql_query("select * from user_status where status='Online'");
	 $online_count=mysql_num_rows($query_online);
	 $online_count=$online_count-1;

?>
	
	<header>

	<!--
		<nav>
			<ul>

					
					<form name="fb_search" action="Search_Display_submit.php" method="get" onSubmit="return bcheck()">
						<div > <input type="text"  name="search1" aria-autocomplete="list"  onKeyUp="searching();" id="search_text1" placeholder="Search" aria-haspopup="true" aria-controls="typeahead-dropdown-14" dir="ltr" style="direction: ltr; text-align: left;"> </div>
						<div id="searching_ID"></div> 
					</form>

			</ul>

		</nav>
		-->
		
	</header><!-- end header -->
	
	
	

	



	
		
		
		


</body>
</html>
<?php
	}
	else
	{
		header("location:../../index.php");
	}
?>