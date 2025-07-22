<?php

include "connection.php";

if(isset($_GET["email"])){
    $mail = $_GET["email"];

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='".$mail."'");
    $user_num = $user_rs->num_rows;

    if($user_num == 1){
        
        $user_data = $user_rs->fetch_assoc();
        $status = $user_data["status_status_id"];

        if($status == 1){
            Database::iud("UPDATE `user` SET `status_status_id`='2' WHERE `email`='".$mail."'");
            echo ("User has been blocked.");
        }else if($status == 2){
            Database::iud("UPDATE `user` SET `status_status_id`='1' WHERE `email`='".$mail."'");
            echo ("User has been unblocked.");
        }

    }else{
        echo ("Cannot find the user. Please try again later.");
    }

}else{
    echo ("Something went wrong.");
}

?>