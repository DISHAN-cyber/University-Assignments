<?php

session_start();

include "connection.php";

if (isset($_SESSION["u"])) {

    $id = $_GET["id"];
    $qty = $_GET["qty"];
    $umail = $_SESSION["u"]["email"];

    $array;

    $order_id = uniqid();

    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $id . "' ");
    $product_data = $product_rs->fetch_assoc();

    $address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON
    user_has_address.city_city_id=city.city_id INNER JOIN `district` ON 
    city.district_district_id=district.district_id WHERE `user_email`='" . $umail . "'");

    $address_num = $address_rs->num_rows;

    if ($address_num == 1) {

        $address_data =  $address_rs->fetch_assoc();

        $address = $address_data["line1"] . ", " . $address_data["line2"];

        $delivery = "0";

        if ($address_data["district_id"] == 9) {
            $delivery = $product_data["delivery_fee_colombo"];
        } else {
            $delivery = $product_data["delivery_fee_other"];
        }

        $item = $product_data["title"];
        $amount = ((int)$product_data["price"] * (int)$qty) + (int)$delivery;

        $fname = $_SESSION["u"]["fname"];
        $lname = $_SESSION["u"]["lname"];
        $mobile = $_SESSION["u"]["mobile"];
        $uaddress = $address;
        $city = $address_data["city_name"];

        $merchant_id = "1227178";
        $merchant_secret = "Mzc0ODEwNzg3MDI3NDczNjg0OTU0MDY1MjQyMjM5MTUzMzk5MTk5OA==";
        $currency = "LKR";

        $hash = strtoupper(
            md5(
                $merchant_id .
                    $order_id .
                    number_format($amount, 2, '.', '') .
                    $currency .
                    strtoupper(md5($merchant_secret))
            )
        );

        $array["id"] = $order_id;
        $array["item"] = $item;
        $array["amount"] = $amount;
        $array["fname"] = $fname;
        $array["lname"] = $lname;
        $array["mobile"] = $mobile;
        $array["address"] = $uaddress;
        $array["city"] = $city;
        $array["umail"] = $umail;
        $array["mid"] = $merchant_id;
        $array["msecret"] = $merchant_secret;
        $array["currency"] = $currency;
        $array["hash"] = $hash;

        echo json_encode($array);
    } else {
        echo ("2");
    }
} else {
    echo ("1");
}

?>