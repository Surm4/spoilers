<?php

require_once("db_connect.php");
require_once("session.php");



$limit = $_POST["limit"];
$offset = $_POST["offset"];
$ordering = $_POST["ordering"];
$error = 0;
$color=0;

$limitToF=is_numeric($limit);
$offsetToF=is_numeric($offset);
$orderingToF=is_numeric($ordering);

if($limitToF==false) {
	$error="Error";
}
if($offsetToF==false) {
	$error="Error";
}
if($orderingToF==false) {
	$error="Error";
}

if ($error==="Error") {
	echo $error;
	exit();
}



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
$order=0;
if ($ordering==1) {
	$order="ORDER BY `likes` DESC";
}
else {
	
	$order="ORDER BY `spoilers`.`Date`  DESC";
}

if($order===0) {
	echo "$order";
	exit();
}

$user_ip = getUserIP();
$query="SELECT * FROM `spoilers` $order LIMIT $limit OFFSET $offset";
$response=mysqli_query($connect, $query);	


if (@mysqli_num_rows($response) > 0) {
    while($row = mysqli_fetch_assoc($response)) {
		$content=$row["Content"];
		$content=htmlspecialchars($content);
		$id=$row["ID"];
		$heartC = $row["Likes"];
		$colorCheck="SELECT * FROM `likes` WHERE ID=$id AND IP='$user_ip'";
		$colorQuery = mysqli_query($connect, $colorCheck);
		$reportCheck="SELECT * FROM `reports` WHERE ID=$id AND IP='$user_ip'";
		$reportQuery = mysqli_query($connect, $reportCheck);
		echo "<div class='spoilerDisplayContainer'>";
		echo "<div id='$id' class='spoilerDisplay'>$content</div>";
		echo "<div class='report'><ul class='nav_list'>";
		echo "<li id='$id' class='heartCount'>Liczba serduszek:</li>";
		echo "<li id='hc_$id' class='heartCountNumber'>$heartC</li>";
		if (mysqli_num_rows($colorQuery) > 0) {
		echo "<li id='hrt_$id' class='heartRed' onclick='heartAdd(event)'><i  id='$id' class='demo-icon icon-heart'></i></li>";
		}
		else {
		echo "<li id='hrt_$id' class='heart' onclick='heartAdd(event)'><i  id='$id' class='demo-icon icon-heart'></i></li>";
		}
		echo "<li id='$id' class='getLink' onclick='linkAdd(event)'>Link</li>";
		if (mysqli_num_rows($reportQuery) > 0) {
		echo "<li id='rpt_$id' class='sendReportRed' onclick='reportAdd(event)'>Zgloś</li>";
		}
		else {
		echo "<li id='rpt_$id' class='sendReport' onclick='reportAdd(event)'>Zgloś</li>";
		}
		echo "</ul></div></div>";
	}
}
else {
		echo "<div class='spoilerDisplayContainer'>";
		echo "<div class='spoilerDisplay'>Brak spoilerów na tej stronie...</div>";
		echo "</div>";
		
}


?>