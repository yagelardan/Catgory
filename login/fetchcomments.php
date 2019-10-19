<?php
	//mysql_connect('kwordco.ipagemysql.com', 'yagelgori', 'dbgori12345!');
mysql_connect('catgory.ipagemysql.com', 'yagcat', 'dbgori12345!');
mysql_select_db("catgodb");
  $userid=$_POST['getuserid'];
  $no = $_POST['getresult'];
  $postid=$_POST['getpostid'];
  $post_user_id=$_POST['getpostuserid'];
	$count_finish=0;

$que_comment=mysql_query("select * from user_post_comment where post_id =$postid order by comment_id desc limit $no,30");
$count_comment=mysql_num_rows($que_comment);
while($comment_data=mysql_fetch_array($que_comment))
{
	$count_finish=$count_finish+1;
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
					  <div class="comment-header">
						<div class="comment-info">
						  <p class="username"><?php echo $user_name1; ?></p>
						 <!-- <p class="date-container">2016/02/15 às 20:32</p>-->
						 <?php
						 	if($userid==$post_user_id || $userid==$comment_user_id)
							{
						?>
						
						<form method="post">  
							<input type="hidden" name="comm_id" value="<?php echo $comment_id; ?>" >
							<input type="submit" name="delete_comment" class="comment-actions" value="delete"> 
						
						
						
						</form> 
						
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
						<p><?php echo $text?></p>
					  </div>
					</div>			 
				<?php
				}
				?>
				
				<?php
				if($count_finish==0)
				{
					echo "No more comments";
				}
				?>