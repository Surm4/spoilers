<?php

require_once("db_connect.php");
require_once("session.php");



$limit = $_POST["limit"];
$offset = $_POST["offset"];
$error = 0;


$limitToF=is_numeric($limit);
$offsetToF=is_numeric($offset);

if($limitToF==false) {
	$error="Error";
}
if($offsetToF==false) {
	$error="Error";
}

if ($error==="Error") {
	echo $error;
	exit();
}

$query="SELECT COUNT(`ID`) as `count` FROM `spoilers` LIMIT $limit OFFSET $offset";

$response=mysqli_query($connect, $query);	

if (mysqli_num_rows($response) !=1 or mysqli_num_rows($response)==null) {
	$count=0;
	echo $count;
}
else {
    while($row = mysqli_fetch_assoc($response)) {
		$count=$row["count"];
		$count=htmlspecialchars($count);
		echo $count;
}
}


?>