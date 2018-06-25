<?php

require_once("session.php");


if(isset($_SESSION["timeget"])) {
	$currentDate = time();
	$date=$_SESSION["timeget"];
	if ($date<$currentDate) {
		$dateSub = $currentDate-$date;
		if ($dateSub>=60) {
			unset($_SESSION["timeget"]);
			echo "Granted";
		}
		else {
			echo "$dateSub";
		}
	}
}
else {
	echo "Granted";
	$currentDate = time();
	$_SESSION["timeget"]=$currentDate;
}

?>