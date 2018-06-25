<html>
<head>
<?php

require_once("session.php");

?>
<meta name="author" content="Marcin Surma">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="shortcut icon"  href="world.ico" />
<link rel="stylesheet" type="text/css" href="css/default_style.css">
<?php
if ($_SESSION["addingError"]!=0) {
	echo "<link rel='stylesheet' type='text/css' href='css/placeholder.css'>";
}
?>
<link rel="stylesheet" type="text/css" href="css/fontello.css">
<link href="https://fonts.googleapis.com/css?family=Ceviche+One|Kavoon|Knewave|Luckiest+Guy|Racing+Sans+One" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<title>Dodaj spoiler</title>

</head>
<body>

<div class="header">
	<a href="index.php"><span class="logo">SPOILERS</span></a>
</div>

<div class="addContainer">
	<div class="addContainerCenter">
		<form id="formSpoiler" name="formSpoiler" action="data_check.php" method="post">
		<textarea  name="content" id="content" class="spoilerArea" type="text" placeholder="Wpisz swój spoiler... &#x0a;- maksymalnie 3000 znaków, &#x0a;- minimalnie 20, &#x0a;- odstęp między dodawaniem spoilerów == 1 minuta." maxlength="3000"></textarea>
		<button onclick="formCheck()" type="button" class="addButton">Dodaj</button>
		</form>
	</div>
</div>
<script>
var start;
var possibility;
var sInt;
var shallWe = 0;
var CheckIn = 0;



function txtLen() {

}

function formCheck(){
	
	var contentString = $("#content").val();
	var stringTrimmed = contentString.trim();
	var contentLen = contentString.length;
	var stringLen = stringTrimmed.length;
	var stringSub = contentLen-stringLen;

	if ( contentLen===stringSub || contentLen>3000 || contentLen<20) {
		CheckIn = 1;
	}
	else {
		CheckIn = 0;
	}
	/*alert(CheckIn);*/
	
	
	
	if (CheckIn===0) {
		$(".spoilerAreaAdd").removeClass("spoilerAreaAdd");
		$("#content").addClass("spoilerArea");
		
	    $.get("timeget.php", function(data, status){
		if(data==="Granted") {
			$("#formSpoiler").submit();
		}
		else {
			if (shallWe==0) {
			shallWe=1;
			possibility=data;
			start=0;
			var sInt = setInterval(counting, 1000);
			}
		}
    });
}
else {
	document.getElementById("formSpoiler").reset();
	$(".spoilerArea").removeClass("spoilerArea");
	$("#content").addClass("spoilerAreaAdd");
}
	
}


function counting() {
		if (start==0) {
			start=1;
			addin=60-possibility;
			$(".addButton").html("Dodaj za "+addin);
		}
		else {
			possibility++;
			addin=60-possibility;
				if (addin==0 || addin<0) {
					$(".addButton").html("Dodaj");
					sInt=0;
					shallWe=0;
				}
				else {
					$(".addButton").html("Dodaj za "+addin);
				}
		}
}

</script>
<script>
/*FORM MOBILE CHECK*/
function formButtonCheck(screen_t) {
    if (screen_t.matches) { 
		document.getElementsByClassName("addContainer")[0].style.width="90%";
		document.getElementsByClassName("addButton")[0].style.width="100%";
    } else {
        document.getElementsByClassName("addContainer")[0].style.width="50%";
		document.getElementsByClassName("addButton")[0].style.width="15%";
    }
}

var screen_t = window.matchMedia("(max-width: 800px)");
formButtonCheck(screen_t); 
screen_t.addListener(formButtonCheck); 

</script>
<noscript>
  <meta http-equiv="refresh" content="0;url=noscript.php">
</noscript>
</body>
</html>