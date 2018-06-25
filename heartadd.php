<?php

require_once("db_connect.php");
require_once("session.php");



function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

$user_ip = getUserIP();

$h_id = $_POST["heartid"];
$h_idToF=is_numeric($h_id);
$error=0;


if($h_idToF==false) {
	$error="Error";
}

if ($error==="Error") {
	echo $h_idToF;
	exit();
}

$h_id=intval($h_id);

$querysearch = "SELECT * FROM `likes` WHERE ID=$h_id AND IP='$user_ip'";
$queryadd = "INSERT INTO `likes` (ID_DB, ID, IP) VALUES ('', '$h_id', '$user_ip')";
$conn=mysqli_query($connect, $querysearch);
if (mysqli_num_rows($conn) > 0) {
	echo "Exist";
	exit();
}
else {
	if (!mysqli_query($connect, $queryadd)) {
		echo "Error 2";
		exit();
	}
}

$query="UPDATE `spoilers` SET `Likes` = `Likes`+1 WHERE ID=$h_id";
$q2="SELECT `Likes` FROM `spoilers` WHERE ID=$h_id";
if (mysqli_query($connect, $query)) {
	$response = mysqli_query($connect, $q2);
	if (mysqli_num_rows($response) > 0) {
    while($row = mysqli_fetch_assoc($response)) {
		echo $row["Likes"];
	}}
	else {
		echo "Error 3";
	}
}	
else {
	echo "Error 4";
}




?>