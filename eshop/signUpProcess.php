<?php

include "connection.php";

$fname = $_POST["f"];
$lname = $_POST["l"];
$email = $_POST["e"];
$password = $_POST["p"];
$mobile = $_POST["m"];
$gender = $_POST["g"];

if(empty($fname)){
    echo ("Please Enter your First Name.");
}else if(strlen($fname)>50){
    echo("First Name must contain LOWER THAN 50 Characters.");
}else if(empty($lname)){
    echo("Please Enter your Last Name.");
}else if(strlen($lname)>50){
    echo("Last Name must contain LOWER THAN 50 Characters.");
}else if(empty($email)){
    echo("Please Enter your Email Address.");
}else if(strlen($email)>100){
    echo("Email must contain LOWER THAN 100 Characters.");
}elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo("Invalid Email Address.");
}else if(empty($password)){
    echo("Please Enter your Password");
}else if(strlen($password)<5 || strlen($password)>20){
    echo("Password must contain between 5 to 20 characters.");
}else if(empty($mobile)){
    echo("Please Enter your Mobile number.");
}else if(strlen($mobile)!=10){
    echo("Mobile number must contain 10 numbers");
}else if(!preg_match("/07[0,1,2,4,5,6,7,8]{1}[0-9]{7}/",$mobile)){
    echo("Invalid Mobile Number.");
}else{

    $rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."' OR
    `mobile`='".$mobile."'");
    $num = $rs->num_rows;

    if($num > 0){
        echo("User with the same Email Address or Mobile number already exists");       
    }else{

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `user`
        (`fname`,`lname`,`email`,`password`,`joined_date`,`gender_gender_id`,`status_status_id`,`mobile`)
        VALUES('".$fname."','".$lname."','".$email."','".$password."','".$date."','".$gender."','1','".$mobile."')");

        echo("success");
    }
}

?>