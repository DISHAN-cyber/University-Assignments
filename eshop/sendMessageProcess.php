<?php

session_start();

include "connection.php";

$logged_user = $_SESSION["u"]["email"];
$receiver = $_POST["to"];
$msg = $_POST["msg"];

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

Database::iud("INSERT INTO `chat`(`content`,`chat_date_time`,`chat_status`,`from`,`to`)
VALUES ('".$msg."','".$date."','1','".$logged_user."','".$receiver."')");

echo ("success");

?>