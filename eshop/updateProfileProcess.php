<?php

session_start();

include "connection.php";

$email = $_SESSION["u"]["email"];

$fname = $_POST["f"];
$lname = $_POST["l"];
$mobile = $_POST["m"];
$line1 = $_POST["li1"];
$line2 = $_POST["li2"];
$city = $_POST["c"];
$pcode = $_POST["p"];

$user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");

if ($user_rs->num_rows == 1) {

    Database::iud("UPDATE `user` SET `fname`='" . $fname . "',`lname`='" . $lname . "',
    `mobile`='" . $mobile . "' WHERE `email`='" . $email . "'");

    $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE 
    `user_email`='" . $email . "'");

    if ($address_rs->num_rows == 1) {
        Database::iud("UPDATE `user_has_address` SET `city_city_id`='" . $city . "',
        `line1`='" . $line1 . "',`line2`='" . $line2 . "',`postal_code`='" . $pcode . "' WHERE
        `user_email`='" . $email . "'");
    } else {
        Database::iud("INSERT INTO `user_has_address`
        (`user_email`,`city_city_id`,`line1`,`line2`,`postal_code`) VALUES
        ('" . $email . "','" . $city . "','" . $line1 . "','" . $line2 . "','" . $pcode . "')");
    }

    if (sizeof($_FILES) == 1) {

        $image = $_FILES["i"];
        $image_extension = $image["type"];

        $allowed_image_extensions = array("image/jpeg", "image/png", "image/svg+xml");

        if (in_array($image_extension, $allowed_image_extensions)) {

            $new_extension;

            if ($image_extension == "image/jpeg") {
                $new_extension = ".jpeg";
            } else if ($image_extension == "image/png") {
                $new_extension = ".png";
            } else if ($image_extension == "image/svg+xml") {
                $new_extension = ".svg";
            }

            $file_name = "resources//profile_images//" . $fname . "_" . uniqid() . $new_extension;
            move_uploaded_file($image["tmp_name"], $file_name);

            $image_rs = Database::search("SELECT * FROM `profile_img` WHERE 
            `user_email`='" . $email . "'");

            if ($image_rs->num_rows == 1) {
                Database::iud("UPDATE `profile_img` SET `img_path`='" . $file_name . "' WHERE
                `user_email`='" . $email . "'");
                echo ("Updated");
            } else {
                Database::iud("INSERT INTO `profile_img` (`img_path`,`user_email`)VALUES
                ('" . $file_name . "','" . $email . "')");
                echo ("Saved");
            }

        }else{
            echo ("Invalid Image Type.");
        }

    } else if (sizeof($_FILES) == 0) {
        echo ("You have not selected any Profile Image");
    } else {
        echo ("You can upload only 1 file.");
    }
} else {
    echo ("Invalid User.");
}


