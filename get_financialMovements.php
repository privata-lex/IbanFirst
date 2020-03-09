<?php

###
# GET financialMovements 
###

#########################################################################################
#
# API Testing Script for IBANFIRST
#
# @Author Adrien Gras <agr@djpad.com>
#
# This script is meant for testing purpose. You should not use directly into your code.
# You can executing it by filling the needed informations below, and then with a shell, 
# call it by using :
#
# 	$ php <path_to_this_script>/testAPI.php
#
#########################################################################################

#########################################################################################
# REQUEST INFORMATIONS
#########################################################################################

# $username 	: The username used to connect to the API.
$username 	= "a00720d";

# $password 	: The password used to connect to the API.
$password 	= "6KPPczga4H6pR+ZeMj+iQ5UpB0foUoO3hQWOjUiYkESU3HGLfXwce8He7TfwY/k4c3hAcFViIFfKUC+GwcbYsQ==";

# $url 		: The url to call the API.
$url 		= "https://sandbox2.ibanfirst.com/api/financialMovements/";

# $method 	: The HTTP method of the request.
$method 	= "GET";

# $postParams  	: The JSON Object to send with a POST request.
$postParams =<<<JSON
{
	"some_json":"here"
}
JSON;

#########################################################################################
# REQUEST PROCESS CODE (do not modify this part)
#########################################################################################

echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
echo "===============================================================================\n";
echo "=      ___   ___  ____  ____________________  ____________  _______  ______   =\n";
echo "=     / _ | / _ \/  _/ /_  __/ __/ __/_  __/ / __/ ___/ _ \/  _/ _ \/_  __/   =\n";
echo "=    / __ |/ ___// /    / / / _/_\ \  / /   _\ \/ /__/ , _// // ___/ / /      =\n";
echo "=   /_/ |_/_/  /___/   /_/ /___/___/ /_/   /___/\___/_/|_/___/_/    /_/       =\n";
echo "=                                                                             =\n";
echo "===============================================================================\n";
echo "\n";
$nonce="";$nonce64;$date;$digest;$header;
$chars = "0123456789abcdef";
for ($i = 0; $i < 32; $i++) { $nonce .= $chars[rand(0, 15)]; }
$nonce64 = base64_encode($nonce) ;
$date = gmdate('c');
$date = substr($date,0,19)."Z" ;
$digest = base64_encode(sha1($nonce.$date.$password, true));
$header = sprintf('X-WSSE: UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"',$username, $digest, $nonce64, $date);
$printHeader = sprintf("X-WSSE:\n \t\tUsernameToken Username=\"%s\",\n \t\tPasswordDigest=\"%s\",\n \t\tNonce=\"%s\",\n \t\tCreated=\"%s\"",$username, $digest, $nonce64, $date);
echo "Initialisation\n";
echo "===============================================================================\n";
echo "\n";
echo " - User : ".$username."\n";
echo " - Path : ".$method." ".$url."\n";
echo " - Header : ".$printHeader."\n";
echo "\n";
echo "===============================================================================\n";
echo "\n";
echo " + Request initialisation...\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
if($method == "GET"){ curl_setopt($ch, CURLOPT_HTTPGET, 1); }
if($method == "POST"){ curl_setopt($ch, CURLOPT_POST, 1); curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams); }
if($method == "DELETE"){ curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); }
if($method == "PUT"){ curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); }
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch,CURLOPT_HTTPHEADER, array($header,'Content-Type: application/json'));
curl_setopt($ch, CURLOPT_VERBOSE, false);
$time_start = microtime(true);
echo " + Sending request...\n";
$res = curl_exec($ch);
echo " + Getting result...\n";
$time_end = microtime(true);
$time = $time_end - $time_start;
curl_close($ch);
$firstline = explode("\r\n",$res)[0];
$json = json_encode(json_decode(explode("\r\n\r\n",$res)[1], true), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

echo "\n";
echo "Result (took ".(round($time,3)*1000)." ms)\n";
echo "===============================================================================\n";
echo "\n";
echo $firstline."\n";
echo "\n";
echo $json."\n";
echo "\n";
echo "===============================================================================\n";
echo "\n";

?>