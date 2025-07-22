<?php

include "connection.php";

$email = $_POST["e"];
$newPw = $_POST["np"];
$retypedPw = $_POST["rp"];
$vcode = $_POST["vcode"];

if (!isset($newPw)) {
    echo ("Please Enter a new password");
} else if (strlen($newPw) < 5 || strlen($newPw) > 20) {
    echo ("New Password must contain BETWEEN 5 to 20 Characters");
} else if (!isset($retypedPw)) {
    echo ("Please Retype your new password");
} else if (strlen($retypedPw) < 5 || strlen($retypedPw) > 20) {
    echo ("Retyped Password must contain BETWEEN 5 to 20 Characters");
} else if ($newPw != $retypedPw) {
    echo ("The passwords does not match.");
} else {

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$email."'
    AND `vcode`='".$vcode."'");
    $user_num = $user_rs->num_rows;

    if($user_num == 1){

        Database::iud("UPDATE `user` SET `password`='".$retypedPw."' WHERE `email`='".$email."'
        AND `vcode`='".$vcode."' ");
        echo ("success");

    }else{
        echo ("Invalid Verification Code");
    }
}
?>

