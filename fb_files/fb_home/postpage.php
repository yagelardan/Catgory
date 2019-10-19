<?php
	session_start();
	header('Content-Type: text/html; charset=utf-8');
	if(isset($_GET['post'])&& is_numeric($_GET['post']))
	{
		$postid=$_GET['post'];
	}else{
		header("Location:../../login/Home.php");
		$postid=0;
	}
	
	if(isset($_SESSION['fbuser']) || isset($_COOKIE['fbuser']))
	{
		include("background.php");
	}
	else{
		header("Location: ../../login/postpage.php?post=".$postid);
	}


	if(isset($_POST['delete_warning']))
	{
		$user_warning_id=intval($_POST['warning_id']);
		mysql_query("delete from user_warning where user_id=$user_warning_id;");
		header('Location: #');
	}
	if(isset($_POST['delete_notice']))
	{
		$n_id=intval($_POST['notice_id']);
		mysql_query("delete from users_notice where notice_id=$n_id;");
		header('Location: #');
	}
	if(isset($_POST['txt']))
	{
		$txt=$_POST['post_txt'];
	
		$txt=htmlspecialchars($txt, ENT_QUOTES, 'UTF-8');
		$txt=str_replace('(', "&#40;", $txt);
		$txt=str_replace(')', "&#41;", $txt);
		
		$priority=$_POST['priority'];
		$post_time=$_POST['txt_post_time'];
		mysql_query("insert into user_post(user_id,post_txt,post_time,priority) values('$userid','$txt','$post_time','$priority');");
		header('Location: #');
	}
	
	if(isset($_POST['file']) && ($_POST['file']=='post'))
	{
		$txt=$_POST['post_txt'];
		$priority=$_POST['priority'];
		$post_time=$_POST['pic_post_time'];
		if($txt=="")
		{
			$txt="added a new photo1.";
		}
		if($gender=="Male")
		{
			$path = "../../fb_users/Male/".$user."/Post/";
		}
		else
		{
			$path = "../../fb_users/Female/".$user."/Post/";
		}
		
		$img_name=$_FILES['file']['name'];
    	$img_tmp_name=$_FILES['file']['tmp_name'];
    	$prod_img_path=$img_name;
		if($gender=="Male")
		{
			move_uploaded_file($img_tmp_name,"../../fb_users/Male/".$user."/Post/".$prod_img_path);
		}
		else
		{
			move_uploaded_file($img_tmp_name,"../../fb_users/Female/".$user."/Post/".$prod_img_path);
		}
    	mysql_query("insert into user_post(user_id,post_txt,post_pic,post_time,priority) values('$userid','$txt','$img_name','$post_time','$priority');");
		header('Location: #');
	}
	if(isset($_POST['delete_post']))
	{
		$post_id=intval($_POST['post_id']);
		mysql_query("delete from user_post where post_id=$post_id;");
		header('Location: Home.php');
	}
	if(isset($_POST['Like']))
	{
		$post_id=intval($_POST['postid']);
		$user_id=intval($_POST['userid']);
		mysql_query("insert into user_post_status(post_id,user_id,status) values($post_id,$user_id,'Like');");
		header('Location: #');
	}
	if(isset($_POST['Unlike']))
	{
		$post_id=intval($_POST['postid']);
		$user_id=intval($_POST['userid']);
		mysql_query("delete from user_post_status where post_id=$post_id and  	user_id=$user_id;");
		header('Location: #');
	}
	if(isset($_POST['comment']))
	{
		$post_id=intval($_POST['postid']);
		$user_id=intval($_POST['userid']);
		$txt=$_POST['comment_txt'];
		$txt=htmlspecialchars($txt, ENT_QUOTES, 'UTF-8');
		$txt=str_replace('(', "&#40;", $txt);
		$txt=str_replace(')', "&#41;", $txt);
		if($txt!="")
		{
		mysql_query("insert into user_post_comment(post_id,user_id,comment) values($post_id,$user_id,'$txt');");
		header('Location: #');
		}
	}
	if(isset($_POST['delete_comment']))
	{
		$comm_id=intval($_POST['comm_id']);
		mysql_query("delete from user_post_comment where comment_id=$comm_id;");
		header('Location: #');
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



<head>
<title>Comments</title>
        <link rel="stylesheet" href="lovebtn/css/style.css" />

	<!--
	<link href="Home_css/Home.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="cardcss/style.css">
	-->
	<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
	<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
	<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="assets/css/main.css" />
	<link rel="stylesheet" href="commentbox/css/style.css" />
	<link rel="stylesheet" href="commentbox/scss/style.scss" />
	<!--
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src="cardjs/index.js"></script>
	<script src="Home_js/home.js" language="javascript"></script>
	-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/skel.min.js"></script>
	<script src="assets/js/util.js"></script>
	<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
	<script src="assets/js/main.js"></script>


</head>



<body style="background-color:#fafafa; font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; ">
	<style type="text/css">
	#share-buttons img {
		width: 55px;
		padding: 2px;
		border: 0;
		box-shadow: 0;
		display: inline;
	}

	 
	</style>

		<?php
			$que_post_share=mysql_query("select * from user_post where post_id=$postid");
			while($post_data_share=mysql_fetch_array($que_post_share))
			{
				$post_txt_share=$post_data_share[2];
			}
			//$url_share='http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$url_share='http://' . $_SERVER['HTTP_HOST']."/catgory/login/postpage.php?post=".$postid;
		
		?>
<!-- facebook reddit tumblr twitter
<div id="share-buttons">
    <a href="http://www.facebook.com/sharer.php?u=<?php echo $url_share;?>" target="_blank" style="border: 0;">
        <img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" />
    </a>
    <a href="http://reddit.com/submit?url=<?php echo $url_share;?>&amp;title=<?php echo $post_txt_share;?>" target="_blank" style="border: 0;">
        <img src="https://simplesharebuttons.com/images/somacro/reddit.png" alt="Reddit" />
    </a>
	
    <a href="http://www.tumblr.com/share/link?url=<?php echo $url_share;?>&amp;title=<?php echo $post_txt_share;?>" target="_blank" style="border: 0;">
        <img src="https://simplesharebuttons.com/images/somacro/tumblr.png" alt="Tumblr" />
    </a>
    <a href="https://twitter.com/share?url=<?php echo $url_share;?>&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons" target="_blank" style="border: 0;">
        <img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" />
    </a>
</div>
-->

	<div id="wrapper">
				<header id="header" style="background-color:rgba(255, 255, 255, 0.7); overflow: hidden; color:#000; border-style: solid; border-bottom: solid #85144b;">
<a href="#" class="logo"><img src="images/logo.jpg" alt="" style="height:100%;" /></a>
				<h1><a href="Home.php" style="font-size: 80%; color:#85144b;">catgory</a></h1>
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
						<li class="menu">
							<a class="fa-bars" style="color:black;" href="#menu">Menu</a>
						</li>
					</ul>
				</nav>
			</header>
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
						<ul class="actions vertical" style="background-color:#999;">
							<li><a href="../fb_logout/logout.php" class="button big fit">Log out</a></li>
						</ul>
					</section>

			</section>
	
	
	
	
					
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




	
	
		<?php
			$que_post=mysql_query("select * from user_post where post_id=$postid");
			while($post_data=mysql_fetch_array($que_post))
			{
				$postid=$post_data[0];
				$post_user_id=$post_data[1];
				$post_txt=$post_data[2];
				$post_img=$post_data[3];
				$post_sub=$post_data[6];
				$que_user_info=mysql_query("select * from users where user_id=$post_user_id");
				$que_user_pic=mysql_query("select * from user_profile_pic where user_id=$post_user_id");
				$fetch_user_info=mysql_fetch_array($que_user_info);
				$fetch_user_pic=mysql_fetch_array($que_user_pic);
				$user_name=$fetch_user_info[1];
				$user_Email=$fetch_user_info[2];
				$user_gender=$fetch_user_info[4];
				$user_pic=$fetch_user_pic[2];
                $likecounter=$post_data["likes_count"];
				
				$len=strlen($post_data[2]);
				
				
				$que_comment=mysql_query("select * from user_post_comment where post_id =$postid order by comment_id");
				$count_comment=mysql_num_rows($que_comment);
				
				$color_design="444";
				$result_color = mysql_query("SELECT * FROM categories WHERE cat_name='$post_sub' LIMIT 1");
				$row_color = mysql_fetch_assoc($result_color);
				$color_design=$row_color['cat_color'];
				
				
				
				if($len>0 && $len<=5000)
				{
					$line1=substr($post_data[2],0,5000);

		?>			
			<section class="main clearfix" style="top:10%; width:100%; ">
					<article class="post" style="word-wrap: break-word;">
						<div style="font-weight: bold;">
							<!--<?php echo $user_name;?>-->
							
							<!--
							<div style="float:right;">
									<p>
										<a href="#" title="Love it" class="btn_likecount btn-counter_likecount multiple-count_likecount" onclick="likethis(<?php echo $postid;?>, <?php echo $userid;?>)" data-count="<?php echo $likecounter;?>"><span>&#x2764;</span></a>
									</p>
							</div>
							-->
						</div>
					<?php
							$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
							// Check if there is a url in the text
							if(preg_match($reg_exUrl, $post_txt, $url)) {
							   // make the urls hyper links
							   $url_shorten=$url[0];
							   $url_shorten=str_replace("http://","",$url_shorten);
							   $url_shorten=str_replace("https://","",$url_shorten);
							   $post_txt = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank" rel="nofollow">'. $url_shorten.'</a>', $post_txt);
						   }
					?>
						
						<p style="color:#000;"><?php echo $post_txt;?></p>
					<?php 
					if($post_data[3]!="")
					{
						$img_path=pathinfo($post_data[3]);
						$extension=$img_path['extension'];
					?>	
						<br>
						<?php 
							if($extension=="webm" || $extension=="mp4")
							{
						?>
						<video width="100%" style="height:17em;" controls>
						  <source src="../../fb_users/<?php echo $user_gender; ?>/<?php echo $user_Email; ?>/Post/<?php echo $post_img; ?>" type="video/webm">
						  <source src="../../fb_users/<?php echo $user_gender; ?>/<?php echo $user_Email; ?>/Post/<?php echo $post_img; ?>" type="video/mp4">
						Your browser does not support the video tag.
						</video>
						<?php
							}
							elseif($extension=="mp3")
							{
							?>
							<audio style="width:100%;" controls>
							  <source src="../../fb_users/<?php echo $user_gender; ?>/<?php echo $user_Email; ?>/Post/<?php echo $post_img; ?>" type="audio/mpeg">
							Your browser does not support the audio element.
							</audio>
							<?php
							}
							else
							{
						?>
							<a href="../../fb_users/<?php echo $user_gender; ?>/<?php echo $user_Email; ?>/Post/<?php echo $post_img; ?>" class="image featured"><img src="../../fb_users/<?php echo $user_gender; ?>/<?php echo $user_Email; ?>/Post/<?php echo $post_img; ?>" alt="" /></a>
						<?php	
							}
					}
					?>
					

						
						
						<?php
							if(isset($post_data[9]) && $post_data[9]!="")
							{
							$url=$post_data[9];
							$parse = parse_url($url);
							$url_host=$parse['host'];
							if(isset($url_host) && $url_host=="www.youtube.com")
							{
						?>
						<iframe width="100%" height="55%" webkitallowfullscreen mozallowfullscreen allowfullscreen
							src="<?php echo get_youtube($url);?>">
						</iframe>
						<?php
							}
								elseif(isset($url_host)){
									echo "<a href='$post_data[9]' target='_blank'>";
									echo "<div class='module' style='height:20em;  background:  url(http://free.pagepeeker.com/v2/thumbs.php?size=x&url=$post_data[9]);'>";
									  echo "<header>";
										echo "<h2 style='color:black; background-color:white;'>";
										  echo "$url_host";
										echo "</h2>";
									  echo "</header>";
									echo "</div></a>";
									echo "<a href='$url' target='_blank'>(Link - $url_host)</a>"; 
								}
							}
						?>
						
						
						<?php
						if($userid==$post_user_id)
						{
						?>
						<form method="post">  
							<input type="hidden" name="post_id" value="<?php echo $postid; ?>" >
							<input type="submit" name="delete_post" class="comment-actions" value="Delete post"> 
						</form>
						<?php
						}
						?>
						
						
						
						
						
						<footer>
						<!--
							<ul class="actions">
								<li><a href="#" class="button big">Continue Reading</a></li>
							</ul>
						-->
							<ul class="stats">
								<li style="margin-right:-40px; ">
									<a href="#" title="Love it" class="btn_likecount btn-counter_likecount multiple-count_likecount" onclick="likethis(<?php echo $postid;?>)" data-count="<?php echo $likecounter;?>"><span >&#x2764;</span></a>
								</li>
							
								<!--<li><a href="postpage.php?post=<?php echo $postid;?>" class="icon fa-heart"><?php echo $count_like;?></a></li>-->
								<li><a href="" class="icon fa-comment"><?php echo $count_comment;?></a></li>
								<li><a href="sub.php?s=<?php echo $post_sub; ?>" target='_blank' style="background-color:#<?php echo $color_design;?>; color:white;"><?php echo $post_sub;?></a></li>
							</ul>
						</footer>
					</article>
			</section>
			<?php }} ?>
			<script src="lovebtn/js/index.js"></script>
			
			
			
		<?php $url_share='http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>
		
		

<!-- I got these buttons from simplesharebuttons.com 
<div id="share-buttons">
    <a href="http://www.facebook.com/sharer.php?u=<?php echo $url_share;?>" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/facebook.png" alt="Facebook" />
    </a>
    <a href="http://reddit.com/submit?url=<?php echo $url_share;?>&amp;title=Simple Share Buttons" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/reddit.png" alt="Reddit" />
    </a>
    <a href="http://www.tumblr.com/share/link?url=<?php echo $url_share;?>&amp;title=Simple Share Buttons" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/tumblr.png" alt="Tumblr" />
    </a>
    <a href="https://twitter.com/share?url=<?php echo $url_share;?>&amp;text=Simple%20Share%20Buttons&amp;hashtags=simplesharebuttons" target="_blank">
        <img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter" />
    </a>
</div>
-->
			
	
					
					
					
	<!--
	<table cellspacing="0" style=" margin: 10px 27%;">
			<tr style="color:#6D84C4;">
			<td >   </td>
			<?php
				$que_status=mysql_query("select * from user_post_status where post_id=$postid and user_id=$userid;");
				$que_like=mysql_query("select * from user_post_status where post_id=$postid");
				$count_like=mysql_num_rows($que_like);
				$status_data=mysql_fetch_array($que_status);
				if($status_data[3]=="Like")
				{?>
				
				<td style="padding-top:15;">
			<form method="post">
			<input type="hidden" name="postid" value="<?php echo $postid; ?>">
			<input type="hidden" name="userid" value="<?php echo $userid; ?>">
			<input type="submit" value="Unlike" name="Unlike" style="border:#FFFFFF; background:#FFFFFF; font-size:15px; color:#6D84C4;" onMouseOver="unlike_underLine(<?php echo $postid; ?>)" onMouseOut="unlike_NounderLine(<?php echo $postid; ?>)" id="unlike<?php echo $postid; ?>"></form></td>
				<?php
				}
				else
				{?>
				<td style="padding-top:15;">
			<form method="post">
			<input type="hidden" name="postid" value="<?php echo $postid; ?>">
			<input type="hidden" name="userid" value="<?php echo $userid; ?>">
			<input type="submit" value="Like!" name="Like" style="border:#FFFFFF; background:#FFFFFF; font-size:15px; color:#6D84C4;" onMouseOver="like_underLine(<?php echo $postid; ?>)" onMouseOut="like_NounderLine(<?php echo $postid; ?>)" id="like<?php echo $postid; ?>"></form></td>
				<?php
				}
			 ?>
			 <?php
			 
				$que_comment=mysql_query("select * from user_post_comment where post_id =$postid order by comment_id ");
		$count_comment=mysql_num_rows($que_comment);
			 ?>
			
			<td colspan="3"> &nbsp; <input type="button" value="Comment(<?php echo $count_comment; ?>)" style="background:#FFFFFF; border:#FFFFFF;font-size:15px; color:#6D84C4;" onClick="Comment_focus(<?php echo $postid; ?>);" onMouseOver="Comment_underLine(<?php echo $postid; ?>)" onMouseOut="Comment_NounderLine(<?php echo $postid; ?>)" id="comment<?php echo $postid; ?>">   <span style="color:#999999;">   <?php echo $post_data[4]; ?> </span> </td>
			<td>   </td>
		</tr>
		<tr>
			<td>   </td>
			<td  bgcolor="#EDEFF4" style="width:9;" colspan="3"><img src="img/like.PNG"><span style="color:#6D84C4;"><?php echo $count_like; ?></span> like this. </td>
		</tr>

	<?php
		while($comment_data=mysql_fetch_array($que_comment))
		{
			$comment_id=$comment_data[0];
			$comment_user_id=$comment_data[2];
			$que_user_info1=mysql_query("select * from users where user_id=$comment_user_id");
			$que_user_pic1=mysql_query("select * from user_profile_pic where user_id=$comment_user_id");
			$fetch_user_info1=mysql_fetch_array($que_user_info1);
			$fetch_user_pic1=mysql_fetch_array($que_user_pic1);
			$user_name1=$fetch_user_info1[1];
			$user_Email1=$fetch_user_info1[2];
			$user_gender1=$fetch_user_info1[4];
			$user_pic1=$fetch_user_pic1[2];
	?>
		<tr>
			<td> </td>
			<td width="4%" bgcolor="#EDEFF4" style="padding-left:12;" rowspan="2">  <img src="../../fb_users/<?php echo $user_gender1; ?>/<?php echo $user_Email1; ?>/Profile/<?php echo $user_pic1; ?>" height="40" width="47">    </td>
			<td bgcolor="#EDEFF4" style="padding-left:7;" > <a href="../fb_view_profile/view_profile.php?id=<?php echo $comment_user_id; ?>" style="text-transform:capitalize; text-decoration:none; color:#3B5998;" onMouseOver="Comment_name_underLine(<?php echo $comment_id; ?>)" onMouseOut="Comment_name_NounderLine(<?php echo $comment_id; ?>)" id="cuname<?php echo $comment_id; ?>"> <?php echo $user_name1; ?></a> </td>
		<?php
			if($userid==$post_user_id)
			{ ?>
				<td align="right" rowspan="2" bgcolor="#EDEFF4"> 
				<form method="post">  
					<input type="hidden" name="comm_id" value="<?php echo $comment_id; ?>" >
					<input type="submit" name="delete_comment" value="  " style="background-color:#FFFFFF; border:#FFFFFF; background-image:url(img/delete_comment.gif); width:13; height:13;"> &nbsp;
				</form> </td>
			<?php
			}
			else if($userid==$comment_user_id)
			{ ?>
			<td align="right" rowspan="2" bgcolor="#EDEFF4">
				<form method="post">  
					<input type="hidden" name="comm_id" value="<?php echo $comment_id; ?>" >
					<input type="submit" name="delete_comment" value="  " style="background-color:#FFFFFF; border:#FFFFFF; background-image:url(img/delete_comment.gif); width:13; height:13;"> &nbsp;
				</form> </td>
			<?php
			}
			else
			{?>
				<td align="right" rowspan="2" bgcolor="#EDEFF4">  </td>
			<?php
			}
		?>
			
		</tr>
		<?php
		$clen=strlen($comment_data[3]);
		if($clen>0 && $clen<=420)
		{
			$cline1=substr($comment_data[3],0,420);
		?>
		<tr>
			<td> </td>
			<td bgcolor="#EDEFF4" style="padding-left:7;" colspan="2"> <?php echo $cline1; ?></td>
		</tr>

		<?php
		}}
		?>

		<tr>
		<td width="4%" style="padding-left:17;" bgcolor="#EDEFF4" rowspan="2">  <img src="../../fb_users/<?php echo $gender; ?>/<?php echo $user; ?>/Profile/<?php echo $img; ?>" style="height:33; width:33;">    </td>
			<td bgcolor="#EDEFF4" colspan="2" style="padding-top:15;"> 
			<form method="post" name="commenting" onSubmit="return blank_comment_check()"> 
			<input type="text" name="comment_txt" placeholder="Write a comment..." maxlength="420" style="width:440;" id="<?php echo $postid;?>"> 
			<input type="hidden" name="postid" value="<?php echo $postid; ?>"> 
			<input type="hidden" name="userid" value="<?php echo $userid; ?>"> 
			<input type="submit" name="comment" style="display:none;"> 
			</form> </td>
		</tr>
	</table>
	-->

	
	
	
	
	
	
	
    <article class="wrapper"  >

		  <div class="title-ctn">
			<p style="color:white;">
			  <span class="comment-count"></span> Comments
			</p>
		  </div>

		  <div class="comment-form-wrapper" style="width:100%; padding-left:0px; padding-right:0px;">
			<div class="profile-pic"><img src="https://s3.amazonaws.com/uifaces/faces/twitter/sachagreif/128.jpg" alt="Sacha Greif" /></div>

			
			
			
			
			
			
			<script type="text/javascript">
			function post()
			{
			  var comment = document.getElementById("comment").value;
			  var useridval = document.getElementById("user_id_logged").value;
			  var useridpostedval = document.getElementById("user_id_posted").value;
			  var postidpageval = document.getElementById("post_id_page").value;
			  if(comment)
			  {
				$.ajax
				({
				  type: 'post',
				  url: 'post_comment.php',
				  data: 
				  {
					 user_comm:comment,
					 user_id:useridval,
					 user_id_posted:useridpostedval,
					 post_id:postidpageval
					
				  },
				  success: function (response) 
				  {
					document.getElementById("all_comments").innerHTML=response+document.getElementById("all_comments").innerHTML;
					document.getElementById("comment").value="";
				   
			  
				  }
				});
			  }
			  
			  return false;
			}
			</script>
			
			<div class="comment-form">
			  <form method='post' action="" onsubmit="return post();">
				  <!--<textarea id="comment" placeholder="Write Your Comment Here....."></textarea>
				  <br>-->
				  <!--<input type="text" id="username" placeholder="Your Name">
				  <br>-->
				  <input type="text" id="comment" placeholder="Write a comment..." maxlength="420" style="width:100%; height:70px;"> 
				  <input type="submit" value="Post Comment">
				  <input type="hidden" id="user_id_logged" value="<?php echo $userid;?>">
				  <input type="hidden" id="user_id_posted" value="<?php echo $post_user_id;?>">
				  <input type="hidden" id="post_id_page" value="<?php echo $postid;?>">
			  </form>
			</div>

			
			
			
			
			
			
			
			<!--
			<div class="comment-form">
			<form method="post" id="comment" name="commenting" onSubmit="return blank_comment_check()"> 
				<input type="text" name="comment_txt" placeholder="Write a comment..." maxlength="420" style="width:100%; height:70px;" id="<?php echo $postid;?>"> 
				<input type="hidden" name="postid" value="<?php echo $postid; ?>"> 
				<input type="hidden" name="userid" value="<?php echo $userid; ?>"> 
				<input type="submit" name="comment" class="comment-actions" value="Post"> 
			</form>
			</div>
			-->
			<!-- comment-form -->
			
			<section class="comments-container" style="width:100%;">
			<div id="all_comments"></div>
			
			
				<?php
					//$que_status=mysql_query("select * from user_post_status where post_id=$postid and user_id=$userid;");
					//$que_like=mysql_query("select * from user_post_status where post_id=$postid");
					//$count_like=mysql_num_rows($que_like);
					//$status_data=mysql_fetch_array($que_status);
					
					$que_comment=mysql_query("select * from user_post_comment where post_id =$postid order by comment_id desc limit 0,30");
					$count_comment=mysql_num_rows($que_comment);
					while($comment_data=mysql_fetch_array($que_comment))
					{
						
						$comment_id=$comment_data[0];
						$comment_user_id=$comment_data[2];
						$que_user_info1=mysql_query("select * from users where user_id=$comment_user_id");
						$que_user_pic1=mysql_query("select * from user_profile_pic where user_id=$comment_user_id");
						$fetch_user_info1=mysql_fetch_array($que_user_info1);
						$fetch_user_pic1=mysql_fetch_array($que_user_pic1);
						$user_name1=$fetch_user_info1[1];
						$user_Email1=$fetch_user_info1[2];
						$user_gender1=$fetch_user_info1[4];
						$user_pic1=$fetch_user_pic1[2];
						
				?>





					<div class="comment" style="word-wrap: break-word;">
					  <div class="comment-header" >
						<!--<div class="profile-pic">
						  <img src="https://s3.amazonaws.com/uifaces/faces/twitter/sachagreif/128.jpg" alt="profile-image" />
						</div>-->
						<div class="comment-info" >
						  
						 <!-- <p class="date-container">2016/02/15 às 20:32</p>-->
						 <?php
						 	if($comment_user_id==$post_user_id || $comment_user_id==$userid)
							{
						?>
						<p class="username" style=" font-weight: bold;"><?php echo $user_name1; ?></p>
						<form method="post">  
							<input type="hidden" name="comm_id" value="<?php echo $comment_id; ?>" >
							<input type="submit" name="delete_comment" class="comment-actions" value="delete"> 
						
						
						  <!--<span class="comment-actions"><a href="#"class="btn btn-like">Delete <span class="icon-love">&#10084;</span></a></span>-->
						</form> 
						
						<?php
							}
							else
							{
						  ?>
						  <p class="username" style="color:black; font-weight: bold;"><?php echo $user_name1; ?></p>
						  <?php 
							}
						  ?>
						</div>
					  </div>
					  <!-- comment-header -->
					<?php
						$text=$comment_data[3];
						// The Regular Expression filter
						$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
						// Check if there is a url in the text
						if(preg_match($reg_exUrl, $text, $url)) {

							   // make the urls hyper links
							   $url_shorten=$url[0];
							   $url_shorten=str_replace("http://","",$url_shorten);
							   $url_shorten=str_replace("https://","",$url_shorten);
							   $text = preg_replace($reg_exUrl, '<a href="'.$url[0].'" rel="nofollow">'. $url_shorten.'</a>', $text);

						}
					?>
					  <div class="comment-body">
						<p style="color:#000;"><?php echo $text?></p>
					  </div>
					</div>
			 




				<?php
				}
				?>

			  		<script type="text/javascript">
						var loading = false;
						function loadmore()
						{
						  if (loading) {
							return ;
						  }
						  loading = true;
						  var val = document.getElementById("result_no").value;
						  var userval = document.getElementById("user_id").value;
						  var postidval = document.getElementById("post_id").value;
						  var postuseridval = document.getElementById("postuser_id").value;
						  $.ajax({
						  type: 'post',
						  url: 'fetchcomments.php',
						  data: {
							getresult:val,
							getuserid:userval,
							getpostid:postidval,
							getpostuserid:postuseridval
						  },
						  context: this,
						  success: function (response) {
							loading = false;
							var content = document.getElementById("result_para");
							content.innerHTML = content.innerHTML+response;

							document.getElementById("result_no").value = Number(val)+30;
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

					<input type="hidden" id="user_id" value="<?php echo $userid;?>">
					<input type="hidden" id="post_id" value="<?php echo $postid;?>">
					<input type="hidden" id="postuser_id" value="<?php echo $post_user_id; ?>"> 
					 <input type="hidden" id="result_no" value="30">
					 <div class="more-container">
						<input type="button" class="comment-actions" id="load" onclick="loadmore(); this.blur();" value="More comments">
					 </div>

			  

			  

			  <!--
			<div class="more-container">
			  <a href="#" class="btn btn-more">More comments</a>
			</div>
				-->
					
		  </section>
		  </div>  <!-- comment-form-wrapper -->
		</article>
			<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
		</div>
	
</body>