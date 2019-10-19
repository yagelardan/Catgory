<?php
mysql_connect('catgory.ipagemysql.com', 'yagcat', 'dbgori12345!');
mysql_select_db("catgodb");
  
  $userid=$_POST['getuserid'];
  $postid=$_POST['getpostid'];

  //$result = mysql_query("select * from  where post_id='$postid'");

  //$dataofpost=mysql_fetch_row($result);
  //$countlikes=2
  //$countlikes=$countlikes+1;
  
  mysql_query("UPDATE user_post SET likes_count=likes_count+1 WHERE post_id='$postid'");
	
  $post_unique_like=mysql_query("select * from user_likes where post_id='$postid' and user_id='$userid'");
  $post_unique_like_count=mysql_num_rows($post_unique_like);
  if($post_unique_like_count==0)
  {
    mysql_query("insert into user_likes(user_id,post_id) values('$userid','$postid');");
  }
?>
				