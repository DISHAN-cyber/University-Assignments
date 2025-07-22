<?php

include "connection.php";

if(isset($_GET["id"])){
    
    $list_id = $_GET["id"];

    $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `w_id`='".$list_id."' ");
    $watchlist_num = $watchlist_rs->num_rows;

    if($watchlist_num == 0){
        echo ("Something went wrong.");
    }else{
        Database::iud("DELETE FROM `watchlist` WHERE `w_id`='".$list_id."'");
        echo ("Deleted");
    }

}


?>