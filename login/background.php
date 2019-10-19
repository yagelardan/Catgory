<html>
<head>
<LINK REL="SHORTCUT ICON" HREF="../fb_files/fb_title_icon/Catico.ico" />
<!--
	<script src="background_file/background_js/event.js"></script>
	<script src="background_file/background_js/searching.js"></script>
	<script src="background_file/background_js/searched_reco_event.js">
	</script>
	<script src="background_file/background_js/submited_searched_reco_event.js"></script>
    <link href="../fb_font/font.css" rel="stylesheet" type="text/css">
   
	
	<link rel="stylesheet" href="headercss/reset.css">
    <link rel="stylesheet" href="headercss/style.css">
	-->
</head>
<body>


 <header>
  <div class="wrapper" >
  
  <h1 class="iconicstroke-heart-stroke"></h1>
  </div>
   <script src="headerejs/index.js"></script>
   
</header>
    
		
<script>
	function bcheck()
	{
		s=document.fb_search.search1.value;
		
		if(s=="")
		{
			return false;
		}
		return true;
	}
</script>


<?php
		
	//mysql_connect('kwordco.ipagemysql.com', 'yagelgori', 'dbgori12345!');
  mysql_connect('catgory.ipagemysql.com', 'yagcat', 'dbgori12345!');
mysql_select_db("catgodb");

?>


<!--Online-->
<script>
		function up_online()
		{
		 	document.getElementById("online_bg").style.display='block';
			document.getElementById("down_onlne").style.display='block';
			document.getElementById("down_onlne_img").style.display='block';
			document.getElementById("up_online").style.display='none';
			document.getElementById("up_online_img").style.display='none';
		}
		function down_online()
		{
		 	document.getElementById("online_bg").style.display='none';
			document.getElementById("down_onlne").style.display='none';
			document.getElementById("down_onlne_img").style.display='none';
			document.getElementById("up_online").style.display='block';
			document.getElementById("up_online_img").style.display='block';
		}
</script>
<div style="display:none;" id="online_bg">

<?php
	 $query_online=mysql_query("select * from user_status where status='Online'");
	 $online_count=mysql_num_rows($query_online);
	 $online_count=$online_count-1;
	 
?>
	<div style="position:fixed; left:84.5%; top:6%;">
	<table>
<?php			
	 
	 
	 while($online_data=mysql_fetch_array($query_online))
	 {
	 
	  	$online_user_id=$online_data[0];
		$query_online_user_data=mysql_query("select * from users where user_id=$online_user_id");
		$query_online_user_pic=mysql_query("select * from user_profile_pic where user_id=$online_user_id");
		$fetch_online_user_info=mysql_fetch_array($query_online_user_data);
		$fetch_online_user_pic=mysql_fetch_array($query_online_user_pic);
		$online_user_name=$fetch_online_user_info[1];
		$online_user_Email=$fetch_online_user_info[2];
		$online_user_gender=$fetch_online_user_info[4];
		$online_user_pic=$fetch_online_user_pic[2];


		

  	
	 if($user!=$online_user_Email)
     {
?>
			 <tr>
			   	   <td> <a href="../fb_view_profile/view_profile.php?id=<?php echo $online_user_id; ?>"> <img src="../../fb_users/<?php echo $online_user_gender; ?>/<?php echo $online_user_Email; ?>/Profile/<?php echo $online_user_pic; ?>" height="30" width="30"> </a> </td>
				   <td style="color:#ffffff;"> <a href="../fb_view_profile/view_profile.php?id=<?php echo $online_user_id; ?>" style="text-transform:capitalize; text-decoration:none; color:#ffffff;"> <?php echo $online_user_name; ?> </a> &nbsp; </td>	
				   <td><img src="background_file/background_icons/online_symbol.png"  /></td>   
			 </tr>
 <?php	            
	  }
	}
?>
</table>
</div>
</div>




</body>
</html>