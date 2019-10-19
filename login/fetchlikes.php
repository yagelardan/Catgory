<?php
	//mysql_connect('kwordco.ipagemysql.com', 'yagelgori', 'dbgori12345!');
mysql_connect('catgory.ipagemysql.com', 'yagcat', 'dbgori12345!');	
mysql_select_db("catgodb");
  
  $postid=$_POST['getpostid'];
  //$result = mysql_query("select * from  where post_id='$postid'");

  //$dataofpost=mysql_fetch_row($result);
  //$countlikes=2
  //$countlikes=$countlikes+1;
  
  mysql_query("UPDATE user_post SET likes_count=likes_count+1 WHERE post_id='$postid'");
  echo "hello";
?>
				