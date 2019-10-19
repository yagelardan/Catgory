<?php
mysql_connect('catgory.ipagemysql.com', 'yagcat', 'dbgori12345!');
mysql_select_db("catgodb");

if(isset($_POST['user_comm']))
{
  $comment=$_POST['user_comm'];
  $user_id=$_POST['user_id'];
  $post_user_id=$_POST['user_id_posted'];
  //$insert=mysql_query("insert into comments values('','$name','$comment',CURRENT_TIMESTAMP)");
  $post_id=$_POST['post_id'];
  
	//prevent xss
	$comment=htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');
	$comment=str_replace('(', "&#40;", $comment);
	$comment=str_replace(')', "&#41;", $comment);
	
  $insert=mysql_query("insert into user_post_comment(post_id,user_id,comment) values($post_id,$user_id,'$comment');");
  
  //$id=mysql_insert_id($insert);

  //$select=mysql_query("select name,comment,post_time from comments where name='$name' and comment='$comment' and id='$id'");
  $select=mysql_query("select * from user_post_comment where post_id =$post_id order by comment_id desc");
  if($row=mysql_fetch_array($select))
  {
	  $name="hello";
	  $comment=$row['comment'];
      //$time=$row['post_time'];
	  
		$comment_id=$row[0];
		$comment_user_id=$row[2];
		$que_user_info1=mysql_query("select * from users where user_id=$comment_user_id");
		$que_user_pic1=mysql_query("select * from user_profile_pic where user_id=$comment_user_id");
		$fetch_user_info1=mysql_fetch_array($que_user_info1);
		$fetch_user_pic1=mysql_fetch_array($que_user_pic1);
		$user_name1=$fetch_user_info1[1];
		$user_Email1=$fetch_user_info1[2];
		$user_gender1=$fetch_user_info1[4];
		$user_pic1=$fetch_user_pic1[2];
	  
	  
	  
	  
	  
	  
	  
  ?>
  <!--
      <div class="comment_div"> 
        <p class="comment"><?php echo $comment;?></p>	
	  </div>
	  -->
	  
	  
	  
	  
	  
	  			<div class="comment" style="word-wrap: break-word;">
					  <div class="comment-header" >
						<!--<div class="profile-pic">
						  <img src="https://s3.amazonaws.com/uifaces/faces/twitter/sachagreif/128.jpg" alt="profile-image" />
						</div>-->
						<div class="comment-info" >
						  
						 <!-- <p class="date-container">2016/02/15 às 20:32</p>-->
						 <?php
						 	if($comment_user_id==$post_user_id || $comment_user_id==$user_id)
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
						$text=$row[3];
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
exit;
}

?>