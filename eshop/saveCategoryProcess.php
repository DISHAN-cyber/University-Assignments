<?php

include "connection.php";

if(isset($_GET["n"])){

    $cname = $_GET["n"];

    $category_rs = Database::search("SELECT * FROM `category` WHERE `cat_name` LIKE 
    '%".$cname."%'");
    $category_num = $category_rs->num_rows;

    if($category_num == 0){
        Database::iud("INSERT INTO `category` (`cat_name`) VALUE ('".$cname."')");
        echo ("success");
    }else{
        echo ("The category you entered already exists.");
    }

}else{
    echo ("Please add a category name.");
}

?>