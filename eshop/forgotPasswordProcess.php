<?php

include "connection.php";

include "SMTP.php";
include "PHPMailer.php";
include "Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

if(isset($_GET["e"])){

    $email = $_GET["e"];
    
    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."'");
    $user_num = $user_rs->num_rows;

    if($user_num == 1){

        $code = uniqid();
        Database::iud("UPDATE `user` SET `vcode`='".$code."' WHERE `email`= '".$email."' ");

        //Email Code

         $mail = new PHPMailer;
         $mail->IsSMTP();
         $mail->Host = 'smtp.gmail.com';
         $mail->SMTPAuth = true;
         $mail->Username = 'rathnayakayasith@gmail.com';//senders email
         $mail->Password = 'tnfconkzpjinhrys';//app password
         $mail->SMTPSecure = 'ssl';
         $mail->Port = 465;
         $mail->setFrom('rathnayakayasith@gmail.com', 'Reset Password');//sender's email, Sender's name
         $mail->addReplyTo('rathnayakayasith@gmail.com', 'Reset Password');//sender's email, Sender's name
         $mail->addAddress($email);//reciever's email
         $mail->isHTML(true);
         $mail->Subject = 'eShop forgot password verification code';//Subject of the email
         $bodyContent = '<h1 style = "color:red">Your verification code is '.$code.'</h1>';//Content
         $mail->Body    = $bodyContent;

         if(!$mail->send()){
            echo("Verification Sending Failed");
         }else{
            echo("Success");
         }


    }else{
        echo ("Invalid Email Address");
    }

}else{
    echo("Please enter your Email Address");
}

?>