<?php
/*
$country = (string)file_get_contents('http://api.wipmania.com');
echo strtolower(substr($country, -2));
*/
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
$country="us";
if(isset($ip))
{
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
echo strtolower($details->country);
$country=strtolower($details->country);
}

?>