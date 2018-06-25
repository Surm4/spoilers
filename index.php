<html>
<head>
<meta charset="UTF-8">
<meta name="author" content="Marcin Surma">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="shortcut icon"  href="world.ico" />
<link rel="stylesheet"  media="screen and (min-width: 661px)" type="text/css" href="css/default_style.css">
<link rel="stylesheet" media="screen and (min-width: 0px) and (max-width: 660px)" href="css/small_style.css">
<link rel="stylesheet" type="text/css" href="css/fontello.css">
<link href="https://fonts.googleapis.com/css?family=Ceviche+One|Kavoon|Knewave|Luckiest+Guy|Racing+Sans+One" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Gloria+Hallelujah" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<title>Spoilers</title>
<style>

</style>
</head>
<body onload="spoilersLoad();">
<div class="header">
	<a href="index.php"><span class="logo">SPOILERS</span></a>
	<ul class="chooseOrder">
	</ul>
	<a href="error_reset.php"><span class="addNew">Dodaj</span></a>
</div>
<div class="buttons">
<button class="funcExecButtonLeft" onclick="spoilersDeLoad()">Poprzednia</button>
<button class="funcExecButtonRight" onclick="spoilersLoad()">Następna</button>
</div>





<script>
/* DATA GET*/
var limit = 10;
var offset;
var count;
var ordering=0;
var ifOrderSet=0;

setTimeout(checkOrders, 1);
function checkOrders() {
if (ordering==0) {
	$("#Htst").css("color","rgba(62, 254, 146, 0.23)");
}
}


function offSet() {

if (offset==null) {
	offset=0;
}
else {
	offset=offset+10;
}

}

function getCount() {

$.post("getcount.php",
{
        limit: limit,
        offset: offset
}, function(data) {
		count=data;
		
		if (count==="Error") {
			window.location.href="error.php";
		}
		else if (count ==  0) {
			offset=offset-10;
		}
});
	
}

function spoilersLoad() {

if (ifOrderSet==0) {
offSet();
getCount();
}
else {
	limit=10;
	offset=0;
	ifOrderSet=0;
}


$.post("select.php",
{
        limit: limit,
        offset: offset,
		ordering: ordering
}, function(data) {
	/*alert(data);*/
	$("div").remove(".spoilerDisplayContainer");
	$(".header").after(data);
	$("body").animate({scrollTop:0}, "500", "swing");
	});

}

function offSetDecrease() {

if (offset==null || offset==0) {
	offset=0;
}
else {
	offset=offset-10;
}

}

function spoilersDeLoad() {


if (ifOrderSet==0) {
offSetDecrease();
getCount();
}
else {
	limit=10;
	offset=0;
	ifOrderSet=0;
}


$.post("select.php",
{
        limit: limit,
        offset: offset,
		ordering: ordering
}, function(data) {
	/*alert(data);*/
	$("div").remove(".spoilerDisplayContainer");
	$(".header").after(data);
	$("html, body").animate({scrollTop:0}, "500", "swing");
});

}

/*ORDERING*/
function orderN() {
ordering=0;
$("#Htst").css("color","rgba(62, 254, 146, 0.23)");
$("#Nst").css("color","#3eff92");
ifOrderSet=1;
spoilersLoad();
}
function orderH() {
ordering=1;
$("#Nst").css("color","rgba(62, 254, 146, 0.23)");
$("#Htst").css("color","#3eff92");
ifOrderSet=1;
spoilersLoad();
}
</script>
<script>
/*DODAJ BUTTON CHECK*/
function addButtonCheck(screen_o) {
    if (screen_o.matches) { 
		document.getElementsByClassName("addNew")[0].innerHTML="<i id='circleButtn' class='demo-icon icon-plus-circle'></i>";
    } else {
        document.getElementsByClassName("addNew")[0].innerHTML="Dodaj";
    }
}

var screen_o = window.matchMedia("(max-width: 380px)");
addButtonCheck(screen_o); 
screen_o.addListener(addButtonCheck); 
</script>
<script>
/*ORDER BUTTONS CHECK*/


function formButtonCheck(screen_t) {
    if (screen_t.matches) { 
		$(".orderList").remove();
		$(".chooseOrder").prepend("<li class='orderListMenu' onclick='openMenu()'><span></span><i class='demo-icon icon-th'></i></li>");
    } else {
        $(".orderListMenu").remove();
		$(".chooseOrder").prepend("<li class='orderList' id='Nst' onclick='orderN()'><span >Najnowsze</span></li>");
		$(".chooseOrder").append("<li class='orderList' id='Htst'  onclick='orderH()'><span >Gorące</span></li>");	
		$(".header").css("filter", "none"); 
		$(".spoilerDisplayContainer, .buttons").css("filter", "none"); 
		$("body").css("overflow", "auto");
		$("#menuContainer").empty();
		$("#menuContainer").remove();
    }
}

var screen_t = window.matchMedia("(max-width: 575px)");
formButtonCheck(screen_t); 
screen_t.addListener(formButtonCheck); 
/* PHONE BUTTON OPERATOR*/
function openMenu() {
$("body").css("overflow", "hidden");
/*
var selector = "body:not(#menuContainer, #menuContainerCenter)";
$(selector).css("filter", "blur(1rem)"); 
DOESNT WORK
*/
$(".header").css("filter", "blur(1rem)"); 
$(".spoilerDisplayContainer, .buttons").css("filter", "blur(1rem)"); 
$("body").prepend("<div id='menuContainer' ></div>");
$("#menuContainer").append("<div id='menuContainerCenter'><div id='menuInfo'>Sortuj wg:</div><div id='menuClick' onclick='orderNbutMobile()'>Najnowszych</div><div id='menuClick' onclick='orderHbutMobile()'>Gorących</div> </div>");
}

function orderNbutMobile() {
ordering=0;
$(".header").css("filter", "none"); 
$(".spoilerDisplayContainer, .buttons").css("filter", "none"); 
$("body").css("overflow", "auto");
$("#menuContainer").empty();
$("#menuContainer").remove();
ifOrderSet=1;
spoilersLoad();
}
function orderHbutMobile() {
ordering=1;
$(".header").css("filter", "none"); 
$(".spoilerDisplayContainer, .buttons").css("filter", "none"); 
$("body").css("overflow", "auto");
$("#menuContainer").empty();
$("#menuContainer").remove();
ifOrderSet=1;
spoilersLoad();
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


	$.post("reportadd.php",
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


</script>
<noscript>
  <meta http-equiv="refresh" content="0;url=noscript.php">
</noscript>
</body>
</html>