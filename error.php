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
<link rel="stylesheet" type="text/css" href="css/fontello.css">
<link href="https://fonts.googleapis.com/css?family=Ceviche+One|Kavoon|Knewave|Luckiest+Guy|Racing+Sans+One" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<title>Error</title>

</head>
<body onkeydown="">

<div class="header">
	<a href="index.php"><span class="logo">SPOILERS</span></a>
</div>

<div class="addContainer">
	<div class="errorCenter">
		Wystąpił błąd... przepraszam.
	</div>
</div>



<script>
/*FORM MOBILE CHECK*/
function formButtonCheck(screen_t) {
    if (screen_t.matches) { 
		document.getElementsByClassName("addContainer")[0].style.width="90%";
    } else {
        document.getElementsByClassName("addContainer")[0].style.width="50%";
    }
}

var screen_t = window.matchMedia("(max-width: 1020px)");
formButtonCheck(screen_t); 
screen_t.addListener(formButtonCheck); 

</script>
<noscript>
  <meta http-equiv="refresh" content="0;url=noscript.php">
</noscript>
</body>
</html>