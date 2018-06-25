<html>
<head>
<?php

require_once("db_connect.php");
require_once("session.php");

$h_id = $_GET["heartid"];
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


$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

?>
<meta name="author" content="Marcin Surma">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="shortcut icon"  href="world.ico" />
<link rel="stylesheet"  media="screen and (min-width: 661px)" type="text/css" href="css/default_style.css">
<link rel="stylesheet" media="screen and (min-width: 0px) and (max-width: 660px)" href="css/small_style.css">
<link rel="stylesheet" type="text/css" href="css/fontello.css">
<link href="https://fonts.googleapis.com/css?family=Ceviche+One|Kavoon|Knewave|Luckiest+Guy|Racing+Sans+One" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<title>Get Link</title>

</head>
<body onkeydown="">

<div class="header">
	<a href="index.php"><span class="logo">SPOILERS</span></a>
</div>
<?php


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

$query="SELECT * FROM `spoilers`  WHERE ID=$h_id";
$response=mysqli_query($connect, $query);	

if (mysqli_num_rows($response) > 0) {
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
		echo "<li id='$id' class='linksRef' title='$actual_link' onclick='copyLink(event)'>Kliknij aby skopiować LINK</li>";
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
		echo "<div class='spoilerDisplay'>Wystąpił błąd</div>";
		echo "</div>";
}
		
		
?>
<script>
var inputExists = 0;

function copyLink(event) {
	var h_id = event.target.title;
	if (inputExists===0) {
		inputExists=1;
		var dummy = $('<input>').attr('class', 'hiddenInput').val(h_id).appendTo('body').select();
		document.execCommand('copy');
	}
	else {
		$(".hiddenInput").val(h_id).select();
		document.execCommand('copy');
	}
}


</script>
<script>
/*HEART ADD*/
function heartAdd(event) {
	var h_id = event.target.id;
	
	$.post("heartadd.php",
{
        heartid: h_id
}, function(data) {
	if (isNaN(data)==false) {
		/*alert(data);*/
		$( "#hc_"+h_id ).html(data);
		$( "#hrt_"+h_id ).css("color","#f7281d");
	}
	else if (data==="Exist") {
		return;
	}
	else {
		/*alert(data);*/
		window.location.href="error.php";
	}
});

}


</script>
<script>
/*Link ADD*/

function linkAdd(event) {
	var h_id = event.target.id;
	var string = "linkadd.php?heartid="+h_id;
	window.open(string, "_blank");

}


</script>
<script>
/*Report ADD*/

function	reportAdd(event) {

	var h_id = event.target.id;
	h_id = h_id.substring(4);


	$.post("reportAdd.php",
{
        heartid: h_id
}, function(data) {
	if (data==="Fine") {
		$( "#rpt_"+h_id ).css("color","#f7281d");
	}
	else if (data==="Exist") {
		return;
	}
	else {
		window.location.href="error.php";
	}
});

}



function formButtonCheck(screen_t) {
    if (screen_t.matches) { 
		$(".sendReport, .getLink, .heart, .heartRed, .linksRef, .sendReportRed").addClass("mobi");
		$(".heartCount, .heartCountNumber").addClass("heartCountM");
		$(".nav_list").addClass("nav_listMobi");
    } else {
		$(".sendReport, .getLink, .heart, .heartRed, .linksRef, .sendReportRed").removeClass("mobi");
		$(".heartCount, .heartCountNumber").removeClass("heartCountM");
		$(".nav_list").removeClass("nav_listMobi");
    }
}

var screen_t = window.matchMedia("(max-width: 470px)");
formButtonCheck(screen_t); 
screen_t.addListener(formButtonCheck); 
</script>
<noscript>
  <meta http-equiv="refresh" content="0;url=noscript.php">
</noscript>
</body>
</html>