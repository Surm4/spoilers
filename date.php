<?php
$data = getdate();
$dataczas=$data["year"]."-".$data["mon"]."-".$data["mday"]." ".$data["hours"].":".$data["minutes"].":".$data["seconds"];
echo "$dataczas";
?>