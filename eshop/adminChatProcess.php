<?php

session_start();

include "connection.php";

if (isset($_SESSION["u"])) {

    $email = $_SESSION["u"]["email"];
    $msg = $_POST["m"];
    $email2 = $_POST["e"];

    if(isset($_POST["e"])){
        $email2 = $_POST["e"];
    }

    $status = 0;

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    if (empty($email2)) {

        Database::iud("INSERT INTO `admin_chat` (`msg`,`msg_date`,`status`,`from`,`to`) VALUES ('" . $msg . "','" . $date . "','" . $status . "','rathnayakayasith6@gmail.com','" . $email . "')");

        echo ("Message sent to the admin");
    } else {
        Database::iud("INSERT INTO `admin_chat` (`msg`,`msg_date`,`status`,`from`,`to`) VALUES ('" . $msg . "','" . $date . "','" . $status . "','" . $email . "','rathnayakayasith6@gmail.com')");

        echo ("Message sent.");
    }
} else {
    echo ("Please Login to your account.");
}
