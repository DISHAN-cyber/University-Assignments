<?php

session_start();

include "connection.php";

if (isset($_SESSION["u"])) {
    if (isset($_GET["id"])) {

        $email = $_SESSION["u"]["email"];
        $pid = $_GET["id"];

        $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE 
        `user_email`='" . $email . "' AND `product_id`='" . $pid . "'");
        $watchlist_num = $watchlist_rs->num_rows;

        if ($watchlist_num == 1) {
            $watchlist_data = $watchlist_rs->fetch_assoc();
            $watchlist_id = $watchlist_data["w_id"];

            Database::iud("DELETE FROM `watchlist` WHERE `w_id`='" . $watchlist_id . "'");
            echo ("Removed");
        } else {
            Database::iud("INSERT INTO `watchlist` (`user_email`,`product_id`) VALUES
            ('" . $email . "','" . $pid . "')");
            echo ("Added");
        }
    } else {
        echo ("Something went wrong. Try again later.");
    }
} else {
    echo ("Please log in to your account.");
}
