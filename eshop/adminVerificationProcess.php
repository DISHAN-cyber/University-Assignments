<?php

include "connection.php";

require "SMTP.php";
require "PHPMailer.php";
require "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST["e"])) {

    $email = $_POST["e"];

    $admin_rs = Database::search("SELECT * FROM `admin` WHERE `email`='" . $email . "'");
    $admin_num = $admin_rs->num_rows;

    if ($admin_num == 1) {
        $admin_data = $admin_rs->fetch_assoc();

        $code = uniqid();
        Database::iud("UPDATE `admin` SET `vcode`='".$code."' WHERE `email`='".$email."'");

        //Email Code

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rathnayakayasith@gmail.com'; //senders email
        $mail->Password = 'yyujkqrmuhibgkyp'; //app password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('rathnayakayasith@gmail.com', 'Reset Password'); //sender's email, Sender's name
        $mail->addReplyTo('rathnayakayasith@gmail.com', 'Reset Password'); //sender's email, Sender's name
        $mail->addAddress($email); //reciever's email
        $mail->isHTML(true);
        $mail->Subject = 'eShop forgot password verification code'; //Subject of the email
        $bodyContent = '<h1 style = "color:red">Your verification code is ' . $code . '</h1>'; //Content
        $mail->Body    = $bodyContent;

        if (!$mail->send()) {
            echo ("Verification Sending Failed");
        } else {
            echo ("Success");
        }
        
    } else {
        echo ("Invalid user.");
    }
} else {
    echo ("Please insert your email.");
}
