<?php

session_start();

include "connection.php";

if(isset($_SESSION["u"])){

    $email = $_SESSION["u"]["email"];
    $pid = $_POST["p"];
    $type = $_POST["t"];
    $feedback = $_POST["f"];

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    Database::iud("INSERT INTO `feedback` (`feed_date`,`feed_type`,`feed_msg`,`customer_email`,
    `product_id`) VALUES ('".$date."','".$type."','".$feedback."','".$email."','".$pid."')");

    echo ("success");

}else{
    echo ("Please Login to your account.");
}

?>