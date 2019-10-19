<?php
//get the q parameter from URL
$q=$_GET["q"];

//find out which feed was selected
if($q=="Google") {
  $xml=("http://rss.walla.co.il/?w=/1/0/12/@rss.e");
} elseif($q=="NBC") {
  $xml=("http://rss.msnbc.msn.com/id/3032091/device/rss/rss.xml");
}
//http://rss.walla.co.il/?w=/6/0/12/@rss.e
//http://rss.walla.co.il/?w=/1/0/12/@rss.e
//http://news.google.com/news?ned=us&topic=h&output=rss

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);

//get elements from "<channel>"
/*
$channel=$xmlDoc->getElementsByTagName('channel')->item(0);
$channel_title = $channel->getElementsByTagName('title')
->item(0)->childNodes->item(0)->nodeValue;
$channel_link = $channel->getElementsByTagName('link')
->item(0)->childNodes->item(0)->nodeValue;
$channel_desc = $channel->getElementsByTagName('description')
->item(0)->childNodes->item(0)->nodeValue;
*/


//get and output "<item>" elements
$x=$xmlDoc->getElementsByTagName('item');
for ($i=0; $i<=6; $i++) {
  $item_title=$x->item($i)->getElementsByTagName('title')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_link=$x->item($i)->getElementsByTagName('link')
  ->item(0)->childNodes->item(0)->nodeValue;
  $item_desc=$x->item($i)->getElementsByTagName('description')
  ->item(0)->childNodes->item(0)->nodeValue;
  /*
  echo ("<p><a href='" . $item_link
  . "'>" . $item_title . "</a>");
  echo ("<br>");
  echo ($item_desc . "</p>");
  */
  
  preg_match("/(<img[^>]+\>)/i", $item_desc, $matches);
	if (isset($matches[0])) {
		$src= $matches[0];
		
		preg_match( '@src="([^"]+)"@' , $src, $match );
		$src = array_pop($match);
	} else {
		$src="";
	}
	
	
	

  echo 	'<li><article><header>';
  echo '<h3><b><a href="'.$item_link.'">'.$item_title.'</a></b></h3>';
  //echo '<time class="published" datetime="2015-10-20">October 20, 2015</time>';
  echo '</header>';
  echo '<a href="'.$item_link.'" class="image"><img src="'.$src.'" alt="" /></a>';
  echo '</article></li>';
}
?>