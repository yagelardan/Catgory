<?php

mysql_connect('catgory.ipagemysql.com', 'yagcat', 'dbgori12345!');
mysql_select_db("catgodb");
  $userid=$_POST['getuserid'];
  $no = $_POST['getresult'];
  /*
	$result11="SELECT * FROM user_post
	INNER JOIN users_following ON user_post.sub_id=users_following.follow_sub
	WHERE  users_following.user_id='$userid' ORDER BY user_post.post_id DESC limit $no,10";
*/



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
	//return $url;
	}

	function get_youtube_image($url)
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
			
		$img_url="http://img.youtube.com/vi/".$matches[1]."/0.jpg";
		return $img_url;
		  //}

	//the ID of the YouTube URL: x6qe_kVaBpg
	//$id = $matches[1];
	}
	
				$user_country_result=mysql_query("SELECT * FROM users WHERE user_id='$userid'");
				$row_country=mysql_fetch_assoc($user_country_result);
				$user_country=$row_country['country_id'];
				$user_second_country=$row_country['second_country_id'];
				


/* working
				$result11="SELECT user_post.*, (LOG10(ABS(COUNT(user_likes.post_id)) + 1) * SIGN(COUNT(user_likes.post_id)))/user_post.post_unix_time AS like_count
				FROM user_post
				LEFT JOIN user_likes ON user_post.post_id = user_likes.post_id
				INNER JOIN users_following ON user_post.sub_id=users_following.follow_sub
				WHERE  users_following.user_id='$userid'  AND (user_post.country_id='$user_country' OR user_post.country_id='$user_second_country') 
				GROUP BY user_post.post_id
				ORDER BY like_count DESC limit $no,15";
*/	


				//alpha*likes*(beta/(1+time()-post.time()) source - https://www.quora.com/Is-there-any-algorithm-that-ranks-post-based-only-on-likes-and-time
				$alpha=rand(5, 200) / 10;
				$beta=rand(5, 200) / 10;

				//$result11="SELECT user_post.*, ($alpha*(user_post.likes_count)*(($beta)/(1+UNIX_TIMESTAMP()-user_post.post_unix_time))) AS like_count
				$result11="SELECT user_post.*, ($alpha*(COUNT(user_likes.post_id)+1)*(RAND()*10)*(($beta)/(1+UNIX_TIMESTAMP()-user_post.post_unix_time))) AS like_count
				FROM user_post
				LEFT JOIN user_likes ON user_post.post_id = user_likes.post_id
				INNER JOIN users_following ON user_post.sub_id=users_following.follow_sub
				WHERE  (users_following.user_id='$userid'  AND (user_post.country_id='$user_country' OR user_post.country_id='$user_second_country')) AND (((UNIX_TIMESTAMP()-user_post.post_unix_time)>100) OR (user_post.user_id='$userid'))
				GROUP BY user_post.post_id
				ORDER BY like_count DESC limit $no,15";


	
/* random-working
				$result11="SELECT user_post.*
				FROM user_post
				LEFT JOIN user_likes ON user_post.post_id = user_likes.post_id
				INNER JOIN users_following ON user_post.sub_id=users_following.follow_sub
				WHERE  users_following.user_id='$userid'  AND (user_post.country_id='$user_country' OR user_post.country_id='$user_second_country') 
				GROUP BY user_post.post_id
				ORDER BY RAND() limit $no,15";
*/
	$count_finish=0;
	$que_post=mysql_query($result11);
		while($post_data=mysql_fetch_array($que_post))
	{
        $count_finish=$count_finish+1;
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

		$que_like=mysql_query("select * from user_post_status where post_id=$postid");
		$count_like=mysql_num_rows($que_like);
		$que_comment=mysql_query("select * from user_post_comment where post_id =$postid order by comment_id");
		$count_comment=mysql_num_rows($que_comment);
		$len=strlen($post_data[2]);
		
	
	$color_design="444";
	$result_color = mysql_query("SELECT * FROM categories WHERE cat_name='$post_sub' LIMIT 1");
	$row_color = mysql_fetch_assoc($result_color);
	$color_design=$row_color['cat_color'];


			
		if($len>0 && $len<=5000)
		{ 
                        $post_txt=substr($post_data[2],0,600);
			if(strlen($post_txt)>=599)
			{
				$post_txt=$post_txt."<a href=postpage.php?post=".$postid." target='_blank' rel='noopener noreferrer'> ...continue reading </a>";
			}
			$date = date_create($post_data[4]);
			if($post_img!="")
			{
											//if(@getimagesize("../../fb_users/".$user_gender."/".$user_Email."/Post/".$post_img))
if(1==1)
				{
				$img_path=pathinfo($post_img);
				$extension=$img_path['extension'];
?>
<script>
$('img').on('click',function(event) {
    //$('img').click(function(){
alert("hello");
        video = '<iframe src="'+ $(this).attr('data-video') +'"></iframe>';
        $(this).replaceWith(video);
    });
</script>


					<article class="post" style="word-wrap: break-word; color:#000;">
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
					<!--
						<header>
							<div class="title">
								<h2><a href="#">Magna sed adipiscing</a></h2>
								<p>Lorem ipsum dolor amet nullam consequat etiam feugiat</p>
							</div>
							<div class="meta">
								<time class="published" datetime="2015-11-01">November 1, 2015</time>
								<a href="#" class="author"><span class="name">Jane Doe</span><img src="images/avatar.jpg" alt="" /></a>
							</div>
						</header>
					-->
					<?php
							$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
							// Check if there is a url in the text
							if(preg_match($reg_exUrl, $post_txt, $url)) {
							   // make the urls hyper links
							   $url_shorten=$url[0];
							   $url_shorten=str_replace("http://","",$url_shorten);
							   $url_shorten=str_replace("https://","",$url_shorten);
							   $post_txt = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank" rel="nofollow noopener noreferrer">'. $url_shorten.'</a>', $post_txt);
						   }
					?>
					
						<p><?php echo $post_txt;?></p>
						
						<?php 
							if($extension=="webm" || $extension=="mp4")
							{
						?>
						<video width="100%"  style="height:17em;" controls>
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
								<a href="postpage.php?post=<?php echo $postid;?>" class="image featured" target='_blank' rel='noopener noreferrer'><img src="../../fb_users/<?php echo $user_gender; ?>/<?php echo $user_Email; ?>/Post/<?php echo $post_img; ?>"  alt="" /></a>
						<?php	
							}
						?>
						
						<footer>
						<!--
							<ul class="actions">
								<li><a href="#" class="button big" target='_blank'>Continue Reading</a></li>
							</ul>
						-->
							<ul class="stats">
								
								<li style="margin-right:-40px; ">
									<a href="#" title="Love it" class="btn_likecount btn-counter_likecount multiple-count_likecount" style="border:0px;" onclick="likethis(<?php echo $postid;?>)" data-count="<?php echo $likecounter;?>"><span >&#x2764;</span></a>
								</li>
							
								<!--<li><a href="postpage.php?post=<?php echo $postid;?>" class="icon fa-heart"><?php echo $count_like;?></a></li>-->
								<li><a href="postpage.php?post=<?php echo $postid;?>" target='_blank' rel='noopener noreferrer' class="icon fa-comment"><?php echo $count_comment;?></a></li>
								<li><a href="sub.php?s=<?php echo $post_sub; ?>" target='_blank' rel='noopener noreferrer' style="background-color:#<?php echo $color_design;?>; color:white; border:0px;"><?php echo $post_sub;?></a></li>
								<li><a href="postpage.php?post=<?php echo $postid;?>" target='_blank' rel='noopener noreferrer' style="font-weight: bold; border:0px;">Read more</a></li>
							</ul>
						</footer>
					</article>
									<?php
				}}
				else{
				/*
					$post_find=mysql_query("SELECT * FROM user_post WHERE post_id='$postid'");
					$row_post_find=mysql_fetch_assoc($post_find);
					$post_find_time=$row_post_find['post_unix_time'];

					if(time()-$post_find_time>100)
					{
				*/
				?>
					<article class="post" style="word-wrap: break-word; color:#000;">
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
						<!--
						<header>
							<div class="title">
								<h2><a href="#">Magna sed adipiscing</a></h2>
								<p>Lorem ipsum dolor amet nullam consequat etiam feugiat</p>
							</div>
							<div class="meta">
								<time class="published" datetime="2015-11-01">November 1, 2015</time>
								<a href="#" class="author"><span class="name">Jane Doe</span><img src="images/avatar.jpg" alt="" /></a>
							</div>
						</header>
						-->
						
						<?php
								$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
								// Check if there is a url in the text
								if(preg_match($reg_exUrl, $post_txt, $url)) {
								   // make the urls hyper links
								   $url_shorten=$url[0];
								   $url_shorten=str_replace("http://","",$url_shorten);
								   $url_shorten=str_replace("https://","",$url_shorten);
								   $post_txt = preg_replace($reg_exUrl, '<a href="'.$url[0].'" target="_blank" rel="nofollow noopener noreferrer">'. $url_shorten.'</a>', $post_txt);
							   }
						?>
						<p>
						<?php if(isset($post_data[9]) && $post_data[9]!=""){?>
						<a href="<?php echo $post_data[9];?>" target='_blank' rel='noopener noreferrer'>
							<?php echo $post_txt;?>
						</a>
						<?php }else{
							echo $post_txt;
						 }?>
						
						</p>
						
						

						
						<?php
							if(isset($post_data[9]) && $post_data[9]!="")
							{
							$url=$post_data[9];
							$parse = parse_url($url);
							$url_host=$parse['host'];
							if(isset($url_host) && $url_host=="www.youtube.com")
							{

						?>
						<!--
						<iframe width="100%" height="300px" webkitallowfullscreen mozallowfullscreen allowfullscreen
							src="<?php echo get_youtube($url);?>">
						</iframe>
						-->					
						<script>
						function img_youtube_onclick()
						{
						alert("hello");
						    $('img').click(function(){
								video = '<iframe src="'+ $(this).attr('data-video') +'"></iframe>';
								$(this).replaceWith(video);
							});
						}
						</script>
												    
						<div class="youtubecontainer" data-video="<?php echo get_youtube($url);?>">
						<img src="http://fm100.com/wp-content/uploads/2015/06/play-button-flat-fm100-salmon.png" style="position: absolute; top:52%; left:46%; pointer-events: none;"  width="40px" height="40px">
						<img src="<?php echo get_youtube_image($url);?>" width="100%" height="300px" style="pointer-events: none;">
						</div>
						

						
						<!--<img  src="<?php echo get_youtube_image($url);?>" data-video="http://www.youtube.com/embed/zP_D_YKnwi0?autoplay=1" onclick="img_youtube_onclick();">-->
						
						<?php
							}
								elseif(isset($url_host)){
									
						
									//echo "<a href='$post_data[9]' target='_blank' style='height:17em;' class='image featured'><img src='http://free.pagepeeker.com/v2/thumbs.php?size=x&url=$post_data[9]' alt='' /></a>";
									

									echo "<a href='$post_data[9]' target='_blank' rel='noopener noreferrer'>";
									echo "<div class='module' style='height:14em;  background:  url(http://free.pagepeeker.com/v2/thumbs.php?size=x&url=$post_data[9]);'>";
									  echo "<header>";
										echo "<h2 style='color:black; background-color:white;'>";
										  echo "$url_host";
										echo "</h2>";
									  echo "</header>";
									echo "</div></a>";
									echo "<a href='$url' target='_blank' rel='noopener noreferrer'>(Link - $url_host)</a>"; 
									
								}
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
									<a href="#" title="Love it" class="btn_likecount btn-counter_likecount multiple-count_likecount" style="border:0px;" onclick="likethis(<?php echo $postid;?>)" data-count="<?php echo $likecounter;?>"><span >&#x2764;</span></a>
								</li>
							
								<!--<li><a href="postpage.php?post=<?php echo $postid;?>" class="icon fa-heart"><?php echo $count_like;?></a></li>-->
								<li><a href="postpage.php?post=<?php echo $postid;?>" target='_blank' rel='noopener noreferrer' class="icon fa-comment"><?php echo $count_comment;?></a></li>
								<li><a href="sub.php?s=<?php echo $post_sub; ?>" target='_blank' rel='noopener noreferrer' style="background-color:#<?php echo $color_design;?>; color:white; border:0px;"><?php echo $post_sub;?></a></li>
								<li><a href="postpage.php?post=<?php echo $postid;?>" target='_blank' rel='noopener noreferrer' style="font-weight: bold; border:0px;">Read more</a></li>
							</ul>
						</footer>
					</article>	
				<?php }}}?>		
<script src="lovebtn/js/index.js"></script>
<?php
                        if($count_finish==0)
				{
					echo "No more results";
				}
				?>
				