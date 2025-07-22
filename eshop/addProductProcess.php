<?php

session_start();
include "connection.php";

// Ensure all necessary POST variables are set
if (!isset($_POST["ca"], $_POST["b"], $_POST["m"], $_POST["t"], $_POST["co"], $_POST["clr"], $_POST["qty"], $_POST["cost"], $_POST["dwc"], $_POST["doc"], $_POST["d"])) {
    die("Required fields are missing.");
}

// Get POST data
$email = $_SESSION["u"]["email"];
$category = $_POST["ca"];
$brand = $_POST["b"];
$model = $_POST["m"];
$title = $_POST["t"];
$condition = $_POST["co"];
$clr = $_POST["clr"];
$qty = $_POST["qty"];
$cost = $_POST["cost"];
$dwc = $_POST["dwc"];
$doc = $_POST["doc"];
$desc = $_POST["d"];

// Sanitize input to prevent SQL injection
$category = mysqli_real_escape_string(Database::$connection, $category);
$brand = mysqli_real_escape_string(Database::$connection, $brand);
$model = mysqli_real_escape_string(Database::$connection, $model);
$title = mysqli_real_escape_string(Database::$connection, $title);
$condition = mysqli_real_escape_string(Database::$connection, $condition);
$clr = mysqli_real_escape_string(Database::$connection, $clr);
$qty = mysqli_real_escape_string(Database::$connection, $qty);
$cost = mysqli_real_escape_string(Database::$connection, $cost);
$dwc = mysqli_real_escape_string(Database::$connection, $dwc);
$doc = mysqli_real_escape_string(Database::$connection, $doc);
$desc = mysqli_real_escape_string(Database::$connection, $desc);

// Check if the model and brand combination exists
$mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE `model_model_id`='$model' AND `brand_brand_id`='$brand'");

if ($mhb_rs->num_rows > 0) {
    $mhb_data = $mhb_rs->fetch_assoc();
    $mhb_id = $mhb_data["model_has_brand_id"];
} else {
    Database::iud("INSERT INTO `model_has_brand`(`model_model_id`, `brand_brand_id`) VALUES ('$model', '$brand')");
    $mhb_id = Database::$connection->insert_id;
}

// Get the current date and time
$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

$status = 1; // Product status

// Insert product details
Database::iud("INSERT INTO `product`(`title`, `price`, `qty`, `description`, `datetime_added`, `delivery_fee_colombo`, `delivery_fee_other`, `category_cat_id`, `condition_condition_id`, `model_has_brand_model_has_brand_id`, `status_status_id`, `color_clr_id`, `user_email`) 
VALUES ('$title', '$cost', '$qty', '$desc', '$date', '$dwc', '$doc', '$category', '$condition', '$mhb_id', '$status', '$clr', '$email')");

$product_id = Database::$connection->insert_id;

// Process uploaded images
$length = count($_FILES);

if ($length <= 3 && $length > 0) {
    $allowed_img_extensions = array("image/jpeg", "image/png", "image/svg+xml");

    for ($x = 0; $x < $length; $x++) {
        if (isset($_FILES["image" . $x])) {
            $image_file = $_FILES["image" . $x];
            $file_extension = $image_file["type"];

            if (in_array($file_extension, $allowed_img_extensions)) {
                // Determine file extension
                $new_image_extension = "";
                switch ($file_extension) {
                    case "image/jpeg":
                        $new_image_extension = ".jpeg";
                        break;
                    case "image/png":
                        $new_image_extension = ".png";
                        break;
                    case "image/svg+xml":
                        $new_image_extension = ".svg";
                        break;
                }

                $file_name = "resources/product_images/" . $title . $x . uniqid() . $new_image_extension;
                move_uploaded_file($image_file["tmp_name"], $file_name);

                // Insert image path into database
                Database::iud("INSERT INTO `product_img`(`img_path`, `product_id`) VALUES ('$file_name', '$product_id')");
            } else {
                echo "Invalid image type.";
            }
        }
    }
    echo "Success";
} else {
    echo "Invalid Image Count.";
}
