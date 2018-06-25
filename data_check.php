<?php
require_once("db_connect.php");
require_once("session.php");

$data = getdate();
$dataczas=$data["year"]."-".$data["mon"]."-".$data["mday"]." ".$data["hours"].":".$data["minutes"].":".$data["seconds"];

if (!isset($_SESSION["addingError"])) {
	$_SESSION["addingError"] = 0;
}

$content = $_POST["content"];
$contentLen = strlen($content);

if (isset($content) and $content!=null) {
	$_SESSION["addingError"] = 0;
	if ($contentLen>3000 OR $contentLen<20) {
		$_SESSION["addingError"] = 1;
		header('Location: add.php');
		exit();
	} 
	else {
		$content=stripslashes($content);
		$content=mysqli_real_escape_string($connect, $content);
		$query="INSERT INTO spoilers (ID, Date, Content, Likes, Reports) VALUES ('', '$dataczas', '$content', '0', '0')";
		if (mysqli_query($connect, $query)) {
			$_SESSION["addingError"] = 0;		
			header('Location: index.php');
		}
		else {
			header('Location: error.php');
		}
	}
}
else {
	$_SESSION["addingError"] = 1;
	header('Location: add.php');
	exit();
}
?>