<?php

include "connection.php";

if(isset($_GET["id"])){

    $pid = $_GET["id"];

    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='".$pid."'");
    
    if($product_rs->num_rows == 1){

        $product_data = $product_rs->fetch_assoc();
        $status = $product_data["status_status_id"];

        if($status == 1){
            Database::iud("UPDATE `product` SET `status_status_id`='2' WHERE `id`='".$pid."'");
            echo ($product_data["title"]." has been DEACTIVATED.");
        }else if($status == 2){
            Database::iud("UPDATE `product` SET `status_status_id`='1' WHERE `id`='".$pid."'");
            echo ($product_data["title"]." has been ACTIVATED.");
        }

    }else{
        echo ("Invalid Product ID.");
    }


}else{
    echo ("Something went wrong.");
}

?>